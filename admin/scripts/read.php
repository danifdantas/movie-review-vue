<?php

function getAll($tbl){
  include('connect.php');
  
  $queryAll = 'SELECT * FROM '.$tbl;
  // var_dump($queryAll);
  // exit;
  $runAll = $pdo->query($queryAll);
  if($runAll){
    return $runAll;
  }else{
    $error = 'There was a problem accessing this info';
    return $error;
  }
 
}
// $results = getAll('tbl_movies');

// while($row = $results->fetch(PDO::FETCH_ASSOC)){
//   echo $row['movies_title'];
// }

?>