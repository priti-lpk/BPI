<?php
ob_start();
if (!isset($_SESSION)) {
    session_start();
}

if (!isset($_SESSION['mainuser'])) {
    header('Location:index.php');
}

?>
