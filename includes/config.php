<?php
ob_start();
session_start();

$host = 'localhost';
$dbUser = 'root';
$dbPass = '';
$dbName = 'burgerland';

try {

    $db = new PDO("mysql:host=".$host.";dbname=".$dbName, $dbUser, $dbPass);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch(PDOException $e) {
    echo '<p style="color:red;">'.$e->getMessage().'</p>';
    exit;
}

if(isset($_SESSION['userAdmin']) || strrpos($_SERVER['REQUEST_URI'],'admin') !== false){
    include('../classes/user.php');
}else{
   include('classes/user.php'); 
}

$user = new User($db); 

if(isset($_SESSION['userAdmin']) || strrpos($_SERVER['REQUEST_URI'],'admin') !== false){
    include('../classes/order.php');
}else{
   include('classes/order.php');
}

$order = new Order($db); 
?>
