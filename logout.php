<?php 
include_once 'config/session.php';
include_once 'config/connect.php';
include_once 'config/utilities.php';

session_destroy();
header('Location: index.php');
?>