<?php
// Initialize the session
// Fungsi untuk menyatakan bahwa sesi sudah dimulai
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
// Cross-check apakah user sudah log in. Jika TRUE, maka akan diarahkan langsung kepada halaman utama web
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: welcome.php");
    exit;
}
 
// Include config file
// Fungsi untuk memanggil file konfigurasi config.php
require_once "config.php";
 
// Define variables and initialize with empty values
// Mendefinisikan variabel dan memberikan nilai NULL
$username = $password = "";
$username_err = $password_err = $login_err = "";
 
// Processing form data when form is submitted
// Fungsi untuk memproses data yang akan dimasukan oleh user
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    // Fungsi untuk memeriksa apakah username telah terisi
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    // Fungsi untuk memeriksa apakah password telah terisi
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate credentials
    // Proses log in dengan memeriksa benar/salahnya username dan/atau password
    if(empty($username_err) && empty($password_err)){
        // Prepare a login statement
        // Mendefinisikan statement log in 
        $sql = "SELECT id, username, password FROM users WHERE username = ?";

        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            // Nyatakan variabel sebagai statement yang sudah didefinisikan sebagai parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            // Mendefinisikan parameters sebagai username
            $param_username = $username;
            
            // Attempt to execute the prepared statement
            // Query untuk mengeksekusi statement yang sudah didefinisikan
            if(mysqli_stmt_execute($stmt)){
                // Store result
                // Memindahkan hasil eksekusi dari statement yang sudah didefinisikan
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                // Memeriksa apakah username terdaftar pada database. Jika iya maka selanjutnya periksa password pada username
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        // Check if the given hash matches the given options
                        // Memeriksa apakah password yang diinputkan memiliki nilai yang sama dengan password yang sudah dienkripsi
                        if(password_verify($password, $hashed_password)){
                            
                            // Password is correct, so start a new session
                            //Jika password benar, maka mulai session yang baru
                            session_start();
                                
                            // Store data in session variables
                            // Mengembalikan data pada variabel session
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;
                            $_SESSION["latest_login"] = date('Y-m-d H:i');

                            // Redirect user to welcome page
                            // Arahkan user pada halaman utama web
                            header("location: welcome.php"); 
                        }
                        else{
                            // Password is not valid, display a generic error message
                            // Jika password salah, tampilkan pesan kesalahan
                            $login_err = "Invalid username or password.";
                        }
                    }
                } else{
                    // Username doesn't exist, display a generic error message
                    // Jika username salah, tampilkan pesan kesalahan
                    $login_err = "Invalid username or password.";
                }
            } else{
                // Jika proses tidak dapat dilanjutkan, tampilkan pesan kesalahan
                echo "Oops! Something went wrong. Please try again later.";
            }

        // Close statement
        // Statemen penutup
        mysqli_stmt_close($stmt);
        }

        // Prepare a login date time statement
        // Mendefinisikan statement tanggal & waktu log in
        $sql = "UPDATE users SET latest_login = now() WHERE username = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            // Nyatakan variabel sebagai statement yang sudah didefinisikan sebagai parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            // Mendefinisikan parameters sebagai username
            $param_username = $username;
            
            // Attempt to execute the prepared statement
            // Query untuk mengeksekusi statement yang sudah didefinisikan
            if(mysqli_stmt_execute($stmt)){
                // Store result
                // Memindahkan hasil eksekusi dari statement yang sudah didefinisikan
                mysqli_stmt_store_result($stmt);
                
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }        
                            
        // Close statement
        // Statement penutup
        mysqli_stmt_close($stmt);
        }   
    }
    
    // Close connection
    // Memutuskan koneksi kepada database
    mysqli_close($link);
}
?>

<!-- Tampilan halaman login dalam bahasa HTML  -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; }
        .wrapper{ width: 360px; padding: 20px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Login</h2>
        <p>Please fill in your credentials to login.</p>

        <?php 
        if(!empty($login_err)){
            echo '<div class="alert alert-danger">' . $login_err . '</div>';
        }        
        ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                <span class="invalid-feedback"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Login">
            </div>
            <p>Don't have an account? <a href="register.php">Sign up now</a>.</p>
        </form>
    </div>
</body>
</html>