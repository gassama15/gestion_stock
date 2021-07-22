<?php
// login.php
include_once 'database_connection.php';
if (!isset($_SESSION['type'])) {
    header('Location: login.php');
}

include 'header.php';
include 'footer.php';

?>