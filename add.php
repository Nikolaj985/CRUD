<?php
session_start();
include_once("pdo.php");
if(!isset($_SESSION["name"])){//if not logged 
    die("ACCESS DENIED");    
}
if(isset($_POST["make"]) && (strlen($_POST["make"]) < 1 || strlen($_POST["model"]) < 1 || strlen($_POST["year"]) < 1 || strlen($_POST["mileage"]) < 1 )) {
    $_SESSION['error'] = "All fields are required"; //If not all fields entered write error
    header("Location: add.php");
    return; 
}else{
    if(isset($_POST["year"]) && is_numeric($_POST["year"]) && is_numeric($_POST["mileage"])){ //If all good add new entry to DB
        $stmt = $pdo->prepare('INSERT INTO autos
        (make, model, year, mileage) VALUES ( :mk, :md, :yr, :mi)'); //prepare query
      $stmt->execute(array( //Execute query
        ':mk' => $_POST['make'],
        ':md' => $_POST['model'],
        ':yr' => $_POST['year'],
        ':mi' => $_POST['mileage']) 
      );
      $_SESSION['success'] = "Record added"; // Enter success message and return to index.php 
      header("Location: index.php");
      return;

    }elseif(isset($_POST["year"]) && !is_numeric($_POST["year"])){//error if year not numeric
        $_SESSION['error'] = "Year must be an integer";
        header("Location: add.php");
        return; 
    }elseif(isset($_POST["mileage"]) && !is_numeric($_POST["mileage"])){//error if mileage not numeric 
        $_SESSION['error'] = "Mileage must be an integer";
        header("Location: add.php");
        return; 
    }
}
if ( isset($_SESSION['error']) ) {
    echo('<p style="color: red;">'.htmlentities($_SESSION['error'])."</p>\n");//print error message and delete (flash message) 
    unset($_SESSION['error']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nikolaj Grigorjev</title>
</head>
<body>
<p>Add A New Entry</p>
<form method="post">
<p>Make:
<input type="text" name="make"></p>
<p>Model:
<input type="text" name="model"></p>
<p>Year:
<input type="text" name="year"></p>
<p>Mileage:
<input type="text" name="mileage"></p>
<p><input type="submit" value="Add New"/>
<a href="index.php">Cancel</a></p>
</form>
</body>
</html>