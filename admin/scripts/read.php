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
function getSingle($tbl, $col, $value){
  include('connect.php');
  $querySingle = 'SELECT * FROM '.$tbl.' WHERE '.$col.'='.$value;
  $runSingle = $pdo->query($querySingle);
  // var_dump($querySingle);
  if($runSingle){
     return $runSingle;
  } else {
    $error ='There was a problem';
    return error;
  }
}

function filterResults($tbl, $tbl_2, $tbl_3, $col, $col_2, $col_3, $filter){
  include ('connect.php');
  $filterQuery = 'SELECT * FROM '.$tbl.' as a, '; 
  $filterQuery.= $tbl_2. ' as b, ';
  $filterQuery.= $tbl_3.' as c ';
  $filterQuery.= 'WHERE a.' .$col. ' = c.' .$col;
  $filterQuery.= ' AND b.' .$col_2. ' = c.'.$col_2;
  $filterQuery.= ' AND b.' .$col_3.'= "'.$filter.'"';
// var_dump($filterQuery);
  // SELECT * FROM tbl_movies as a, tbl_genre as b, tbl_mov_genre as c WHERE a.movies_id = c.movies_id AND b.genre_id = c.genre_id AND b.genre_name="action"
  $runQuery = $pdo->query($filterQuery);
  if($runQuery) {
    return $runQuery;
  } else {
    $error = 'There was a problem';
    return $error;
  }

}

?>