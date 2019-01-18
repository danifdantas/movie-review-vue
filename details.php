<?php require_once('admin/scripts/read.php'); 
if(isset($_GET['id'])){
  $tbl = 'tbl_movies';
  $col = 'movies_id';
  $value = $_GET['id'];
  $result = getSingle($tbl, $col, $value);

}else{

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Movie Review</title>
</head>
<body>
<?php include('templates/header.html') ?>
<h1>This is the movie site</h1>
<section>
<?php 

$results = getSingle('tbl_movies', 'movies_id', $value);
while($row = $results->fetch(PDO::FETCH_ASSOC)):?>
<h2><?php echo $row['movies_title']?></h2>
<img src="images/<?php echo $row['movies_cover'];?>" alt="<?php echo $row['movies_title'];?>">
<p><?php echo $row['movies_storyline']?></p>
<?php endwhile; ?>
</section>
<?php include('templates/footer.html') ?>
</body>
</html>