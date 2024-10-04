<?php 
    
$servername = "localhost";
$username = "root";
$password = "root1";
$dbname = "tienda";

// Create connection
$db = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($db->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
//echo 'Éxito... ' . $db->host_info . "\n";

?>