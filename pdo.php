<?php
$pdo = new PDO('mysql:host=localhost;port=3306;dbname=misc', 'fred', 'zap');//creates pdo object representing a connection to a database
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //Error reporting, Throw exceptions.

function getAllData($pdo){//Returns all entries from DB
 $stm = $pdo->prepare("SELECT autos_id, make, model, year, mileage FROM autos");
 $stm->execute();
 $rows = $stm->fetchAll();   
    return $rows;
}
function getElement($id, $pdo){//Returns one entry entries from DB = id
$stm = $pdo->prepare("SELECT autos_id, make, model, year, mileage FROM autos WHERE autos_id = :id");
$stm->execute(array(
    ":id" => $id
));
return $stm->fetch(PDO::FETCH_ASSOC);
}