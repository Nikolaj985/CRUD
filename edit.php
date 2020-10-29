<?php
session_start();
require_once("pdo.php");
if(!isset($_SESSION["name"])){//if not logged
    die("ACCESS DENIED");
}
if(isset($_GET["id"])){
    $_REQUEST["id"] =$_GET["id"];
}

if(isset($_POST["make"])  && isset($_POST["model"]) && isset($_POST["year"]) && isset($_POST["mileage"])  ) {
    if(strlen($_POST["make"]) < 1 || strlen($_POST["model"]) < 1 || strlen($_POST["year"]) < 1 || strlen($_POST["mileage"]) < 1 ){    
    $_SESSION['error'] = "All fields are required"; //If not all fields entered write error
    header("Location: edit.php?id=".$_REQUEST["id"]);
    return; 
    }elseif(isset($_POST["year"]) && is_numeric($_POST["year"]) && is_numeric($_POST["mileage"])){ //If all good edit entry in DB
        $stmt = $pdo->prepare('UPDATE autos SET make = :mk, model = :md, year = :yr, mileage = :mi WHERE autos_id = :ui');//prepare query
      $stmt->execute(array(
        ':mk' => $_POST['make'],
        ':md' => $_POST['model'],
        ':yr' => $_POST['year'],
        ':mi' => $_POST['mileage'],
        ':ui' => $_POST['autos_id'])
      );//Execute query
      $_SESSION['success'] = "Record edited"; // Enter success message and return to index.php 
      header("Location: index.php");
      return;

    }elseif(isset($_POST["year"]) && !is_numeric($_POST["year"])){//error if year not numeric
        $_SESSION['error'] = "Year must be an integer";
        header("Location: edit.php?id=".$_REQUEST["id"]);
        return; 
    }elseif(isset($_POST["mileage"]) && !is_numeric($_POST["mileage"])){//error if mileage not numeric
        $_SESSION['error'] = "Mileage must be an integer";
        header("Location: edit.php?id=".$_REQUEST["id"]);
        return; 
    }
}
if ( isset($_SESSION['error']) ) {
    echo('<p style="color: red;">'.htmlentities($_SESSION['error'])."</p>\n");//print error message and delete (flash message)
    unset($_SESSION['error']);
}
$edit = getElement($_REQUEST['id'], $pdo);//get DB entry by id
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nikolaj Grigorjev</title>
</head>
<body>
<p>Edit Entry</p>
<form method="post">
<p>Make:
<input type="text" name="make" value="<?=htmlentities($edit['make']) ?>"></p> <!--Value from DB to edit-->
<p>Model:
<input type="text" name="model" value="<?=htmlentities($edit['model']) ?>"></p> <!--Value from DB to edit-->
<p>Year:
<input type="text" name="year" value="<?=htmlentities($edit['year']) ?>"></p> <!--Value from DB to edit-->
<p>Mileage:
<input type="text" name="mileage" value="<?=htmlentities($edit['mileage']) ?>"></p> <!--Value from DB to edit-->
<input type="hidden" name="autos_id" value="<?=htmlentities($edit['autos_id']) ?>"> <!--Value from DB to edit-->
<p><input type="submit" value="Save"/>
<a href="index.php">Cancel</a></p>
</form>
</body>
</html>
