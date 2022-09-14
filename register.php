<?php
// Fungsi untuk memanggil file konfigurasi config.php
require_once "config.php";
 
// Mendefinisikan variabel dan memberikan nilai NULL
$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";
 
// Fungsi untuk memproses data yang akan dimasukan oleh user
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Fungsi untuk registrasi username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))){
        $username_err = "Username can only contain letters, numbers, and underscores.";
    } else{
        // Menginput username ke database MySQL
        $sql = "SELECT id FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Nyatakan variabel sebagai statement yang sudah didefinisikan sebagai parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Mendefinisikan parameters
            $param_username = trim($_POST["username"]);
            
            // Query untuk mengeksekusi statement yang sudah didefinisikan
            if(mysqli_stmt_execute($stmt)){
                // Memindahkan hasil eksekusi dari statement yang sudah didefinisikan
                mysqli_stmt_store_result($stmt);
                // Memeriksa apakah username terdaftar pada database.
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "This username is already taken."; // Jika username sudah terdaftar, tampilkan pesan kesalahan
                } else{
                    $username = trim($_POST["username"]); // Jika username belum terdaftar, maka username berhasil dipilih
                }
            } else{
                // Jika proses registrasi gagal, tampilkan pesan kesalahan
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Fungsi untuk registrasi password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters."; // Jika password kurang dari 6 karakter, tampilkan pesan kesalahan
    } else{
        $password = trim($_POST["password"]); // Jika password lebih dari 6 karakter, maka password berhasil dipilih
    }
    
    // Fungsi untuk confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match."; // Jika password tidak sama, tampilkan pesan kesalahan
        }
    }
    
    // Periksa input yang memiliki error sebelum mendaftarkan ke database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){
        
        // Menginput data username dan password yang sudah dipilih
        $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Nyatakan variabel sebagai statement yang sudah didefinisikan sebagai parameters
            mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);
            
            // Mendefinisikan parameters
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Fungsi untuk memberi enkripsi pada password
            
            // Query untuk mengeksekusi statement yang sudah didefinisikan
            if(mysqli_stmt_execute($stmt)){
                // Lanjutkan pada halaman login
                header("location: login.php");
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Statement penutup
            mysqli_stmt_close($stmt);
        }
    }
    
    // Memutus koneksi pada database
    mysqli_close($link);
}
?>

<!-- Tampilan halaman registrasi dalam bahasa HTML  -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; }
        .wrapper{ width: 360px; padding: 20px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Sign Up</h2>
        <p>Please fill this form to create an account.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                <span class="invalid-feedback"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>">
                <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-secondary ml-2" value="Reset">
            </div>
            <p>Already have an account? <a href="login.php">Login here</a>.</p>
        </form>
    </div>    
</body>
</html>