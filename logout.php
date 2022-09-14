<?php
// Initialize the session
// Fungsi untuk menyatakan bahwa sesi sudah dimulai
session_start();
 
// Unset all of the session variables
// Mereset semua variabel session menjadi array kosong
$_SESSION = array();
 
// Destroy the session.
// Menghapus seluruh data pada session
session_destroy();
 
// Redirect to login page
// Mengarahkan user pada halaman login
header("location: login.php");
exit;
?>