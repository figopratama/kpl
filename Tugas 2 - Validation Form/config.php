<?php
/* Database credentials. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
/* Pendefinisian database. Termasuk nama server, username, password, dan nama database */
session_start();
$host = "localhost"; /* Host name */
$user = "root"; /* User */
$password = ""; /* Password */
$dbname = "kpl"; /* Database name */

$link = mysqli_connect($host, $user, $password,$dbname);
// Check connection
if (!$link) {
 die("Connection failed: " . mysqli_connect_error());
}
?>