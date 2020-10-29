<?php
session_start();
include_once("pdo.php");
if(!isset($_SESSION["name"])){//if not logged
    die("ACCESS DENIED");    
}
if(isset($_POST["delete"])){ //if submitted delete entry
    $stm = $pdo->prepare("DELETE FROM autos WHERE autos_id = :ai");
    $stm->execute(array(
        ":ai" => $_POST["autos_id"]
    ));
    $_SESSION["success"]="Record deleted"; // Enter success message and return to index.php 
    header("Location: index.php");
}

$edit = getElement($_REQUEST['id'], $pdo);//get DB entry by id




?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nikolaj Grigorjev ae947edd</title>
</head>
<body>
<p>Delete entry: <?=htmlentities($edit['make'])." | ".htmlentities($edit['model'])." | ".htmlentities($edit['year'])." | ".htmlentities($edit['mileage'])."?" ?></p>
<form method="post">
<input type="hidden" name="autos_id" value="<?=htmlentities($edit['autos_id']) ?>">
<p><input type="submit" name="delete" value="Delete"/>
<a href="index.php">Cancel</a></p>
</form>
</body>
</html>