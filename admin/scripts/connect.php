<?php

$db_dsn = array(
  'host' => 'localhost',
  'dbname' => 'db_movies_class',
  'charset' => 'utf8'
);
// This is the db credentials
$dsn = 'mysql:'.http_build_query($db_dsn, '',';');
$db_user = 'root';
$db_pass = 'root';

try{
  $pdo = new PDO($dsn, $db_user, $db_pass);
}catch(PDOException $exeption){
  echo 'Connection Error:'.$exception->getMessage();
  exit();
}
?>