<?php 
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);
require_once('admin/scripts/config.php');
if(isset($_GET['filter'])){
  $tbl = 'tbl_movies';
  $tbl_2 = 'tbl_genre';
  $tbl_3 = 'tbl_mov_genre';
  $col = 'movies_id';
  $col_2 = 'genre_id';
  $col_3 = 'genre_name';
  $filter = $_GET['filter'];
  $results = filterResults($tbl, $tbl_2, $tbl_3, $col, $col_2, $col_3, $filter);
// var_dump($results);exit;
} else {
  $results = getAll('tbl_movies');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous"> -->
  <link rel="stylesheet" href="css/main.css">
  <title>Movie Review</title>
</head>
<body>
<?php include('templates/header.html') ?>
  <main>

<h1 class="main-title">This is the movie site</h1>
<section id='movies'>
<?php 
// $results = getAll('tbl_movies');
while($row = $results->fetch(PDO::FETCH_ASSOC)):?>
<?php ?>
<div class="movie-card">
    <h2><?php echo $row['movies_title'];?></h2>
    <img src="images/<?php echo $row['movies_cover'];?>" alt="<?php echo $row['movies_title'];?>">
    
    <div>
      <h3><?php echo $row['movies_title']?><small><br>(<?php echo $row['movies_year'];?>)</small></h3>
      <p><?php echo $row['movies_storyline'];?></p>
    </div>
    <a class="btn" href="details.php?id=<?php echo $row['movies_id'];?>">Read More</a>
  </div>
<?php endwhile; ?>

</section>
<?php include('templates/footer.html') ?>
</main>
</body>
</html>