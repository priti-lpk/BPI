<?php

ob_start();
session_start();
if (!isset($_SESSION['mainuser'])) {
   header('Location:../index.php');
}
?>
