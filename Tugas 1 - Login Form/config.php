<?php
/* Database credentials. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
/* Pendefinisian database. Termasuk nama server, username, password, dan nama database */
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'kpl');
 
/* Attempt to connect to MySQL database */
/* Menghubungkan kepada database MySQL dengan variabel $link */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
// Check connection
// Cek koneksi
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>