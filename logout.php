<?php
session_start();
$_SESSION = array();
session_destroy();

if (empty($_SESSION['username']) and empty($_SESSION['password'])){
    header('Location: index.php');
    exit;
}
?>