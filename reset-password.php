<?php
// Initialize the session
// Fungsi untuk menyatakan bahwa sesi sudah dimulai
session_start();
 
// Check if the user is logged in, otherwise redirect to login page
// Cross-check apakah user sudah log in. Jika TRUE, maka akan diarahkan langsung kepada halaman log in
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
 
// Include config file
// Fungsi untuk memanggil file konfigurasi config.php
require_once "config.php";
 
// Define variables and initialize with empty value
// Mendefinisikan variabel dan memberikan nilai NULL
$new_password = $confirm_password = "";
$new_password_err = $confirm_password_err = "";
 
// Processing form data when form is submitted
// Fungsi untuk memproses data yang akan dimasukan oleh user
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate new password
    // Fungsi untuk menambahkan password yang baru
    if(empty(trim($_POST["new_password"]))){
        $new_password_err = "Please enter the new password.";     
    } elseif(strlen(trim($_POST["new_password"])) < 6){
        $new_password_err = "Password must have atleast 6 characters.";
    } else{
        $new_password = trim($_POST["new_password"]);
    }
    
    // Validate confirm password
    // Fungsi untuk confirm password yang baru
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm the password.";
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($new_password_err) && ($new_password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
        
    // Check input errors before updating the database
    // Periksa input yang memiliki error sebelum mendaftarkan ke database
    if(empty($new_password_err) && empty($confirm_password_err)){
        // Prepare an update statement
        // Mengupdate data password yang baru
        $sql = "UPDATE users SET password = ? WHERE id = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            // Nyatakan variabel sebagai statement yang sudah didefinisikan sebagai parameters
            mysqli_stmt_bind_param($stmt, "si", $param_password, $param_id);
            
            // Set parameters
            // Mendefinisikan parameters
            $param_password = password_hash($new_password, PASSWORD_DEFAULT); // Fungsi untuk memberi enkripsi pada password
            $param_id = $_SESSION["id"];
            
            // Attempt to execute the prepared statement
            // Query untuk mengeksekusi statement yang sudah didefinisikan
            if(mysqli_stmt_execute($stmt)){
                // Password updated successfully. Destroy the session, and redirect to login page
                // Password berhasil diupdate. Mengakhiri session dan user diarahkan pada halaman login
                session_destroy();
                header("location: login.php");
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            // Statement penutup
            mysqli_stmt_close($stmt);
        }
    }
    
    // Close connection
    // Memutus koneksi pada database
    mysqli_close($link);
}
?>
 
<!-- Tampilan halaman reset password dalam bahasa HTML  -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; }
        .wrapper{ width: 360px; padding: 20px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Reset Password</h2>
        <p>Please fill out this form to reset your password.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"> 
            <div class="form-group">
                <label>New Password</label>
                <input type="password" name="new_password" class="form-control <?php echo (!empty($new_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $new_password; ?>">
                <span class="invalid-feedback"><?php echo $new_password_err; ?></span>
            </div>
            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>">
                <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <a class="btn btn-link ml-2" href="welcome.php">Cancel</a>
            </div>
        </form>
    </div>    
</body>
</html>