<?php
session_start();
include_once('pdo.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nikolaj Grigorjev</title>
</head>
<body>
<h1>Welcome to Autos Database</h1>
<?php 
    if(!isset($_SESSION["name"])){ //if not logged show loggin window
?>
    <div><a href="login.php">Please log in</a></div>
    <div>Attent to go to <a href="add.php">add data</a> without logging in - it should fail with a error message</div>
<?php 
    }else{ //if logged
        if ( isset($_SESSION['success']) ) { //print success message and delete (flash message)
            echo('<p style="color: green;">'.htmlentities($_SESSION['success'])."</p>\n");
            unset($_SESSION['success']);
        }
        $rows = getAllData($pdo); //get all entries rom DB
        if(!empty($rows)){//If not empty print
        echo '<table border="1">'; 
        echo "<tr><th>Make</th><th>Model</th><th>Year</th><th>Mileage</th><th>Action</th></tr>";
        
        foreach($rows as $row){
        echo "<tr><td>".htmlentities($row['make'])."</td>";
        echo "<td>".htmlentities($row['model'])."</td>";;
        echo "<td>".htmlentities($row['year'])."</td>";
        echo "<td>".htmlentities($row['mileage'])."</td>";
        echo "<td> <a href='edit.php?id=".$row['autos_id']."'>Edit</a> | <a href='delete.php?id=".$row['autos_id']."'>Delete</a> </td>";
        }
        echo "</table>";
        }else{
            echo "No rows found";
    }
?>
<div><a href="add.php">Add New Entry</a></div>
<div><a href="logout.php">Logout</a></div>
<?php
}
?>
</body>
</html>