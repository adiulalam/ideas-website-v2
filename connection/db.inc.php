<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/environment.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/path.php";

try {
    $pdo = new PDO("mysql:host=$_ENV[HOST]:$_ENV[PORT];dbname=$_ENV[DATABASE]", $_ENV["USERNAME"], $_ENV["PASSWORD"]);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec('SET NAMES "utf8"');
} catch (PDOException $e) {
    $error = 'Unable to connect to database server:' . $e->getMessage();
    //$error= 'Unable to connect to database server:';
    include "$_PATH[errorPath]";
    exit();
}
