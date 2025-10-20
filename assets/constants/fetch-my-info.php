<?php

try {
require_once '/var/www/html/vendor/autoload.php';  
$dotenv = Dotenv\Dotenv::createImmutable('/var/www/env'); 
$dotenv->load();

$servername = $_ENV['DB_HOST'];
$username   = $_ENV['DB_USER'];
$password  = $_ENV['DB_PASS'];
$dbname     = $_ENV['DB_NAME'];

$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

}catch(PDOException $e)
{
echo "Connection failed: " . $e->getMessage();
}

?>