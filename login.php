<?php 
session_start();
$stored_hash = '1a52e17fa899cf40fb04cfc42e6352f1'; // stored hash password
if(isset($_POST["email"]) && isset($_POST["pass"])){ //if password and email entered
    if($_POST["email"]=="" || $_POST["pass"]==""){ // if password and email empty
        $_SESSION['error'] = "Email and password are required";//return error message
        header("Location: login.php");
        return;
    }elseif(strpos($_POST["email"],'@')===false){//if email doesnt contain @ return error message
        $_SESSION['error'] = "Email must have an at-sign (@)";
        header("Location: login.php");
        return;
    }
    elseif($stored_hash==hash("md5","XyZzy12*_".$_POST["pass"])){//If password ok - login, write to log file and return to index
        error_log("Login success ".$_POST['email']);
        $_SESSION['name'] = $_POST['email'];
        header("Location: index.php");
        return;
    }else{
        $check = hash("md5","XyZzy12*_".$_POST["pass"]);//If password Not ok - write to log file and return to login.php
        error_log("Login fail ".$_POST['email']." $check");
        $_SESSION['error'] = "Incorrect password";
        header("Location: login.php");
        return;
        }
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
<?php 
if ( isset($_SESSION['error']) ) {
  echo('<p style="color: red;">'.htmlentities($_SESSION['error'])."</p>\n"); //print error message and delete (flash message)
  unset($_SESSION['error']);
}
?>
<form method="post">
    <label for="email">Email</label>
    <input type="text" id="email" name="email" placeholder="Your email.." >
    <label for="pass">Password</label>
    <input type="password" id="pass" name="pass" >
    <input type="submit" value="Log In">
  </form>
</body>
</html>

