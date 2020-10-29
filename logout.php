<?php
session_start();
session_destroy();//destroy session and return to index.php
header("Location: index.php");
?>