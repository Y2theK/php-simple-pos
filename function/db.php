<?php
$con = new PDO("mysql:host=localhost;dbname=pos_project","root","");
$con->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION); // to show db error massage 

function query($sql,$params = []){
    global $con;
    $stmt = $con->prepare($sql);
    return $stmt->execute($params);
}
function getAll($sql,$params = []){
    global $con;
    $stmt = $con->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll(PDO::FETCH_OBJ);
}
function getOne($sql,$params = []){
    global $con;
    $stmt = $con->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetch(PDO::FETCH_OBJ);
}






?>
