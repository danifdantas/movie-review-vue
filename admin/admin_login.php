<?php 
require_once('scripts/config.php');

if(empty($_POST['username']) || empty($_POST['password'])){
  $message = 'Please fill out all fields';
}else {
  $username = htmlspecialchars($_POST['username']);
  $password = htmlspecialchars($_POST['password']);
  
  $message = login($username,$password);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="../css/main.css">
  <link href="https://fonts.googleapis.com/css?family=Raleway:300,500" rel="stylesheet">
  <title>Admin Login</title>
</head>
<body>

  <div id="container">
  <h1 class = "login-title"> Login</h1>
  <?php if(!empty($message)):?>
  <div class="message">
    <p><?php echo $message?></p>
    </div>
  <?php endif; ?>
    <form action="admin_login.php" method="post">
    <label for="username">Username:</label>
     <input type="text" id="username" name="username">
    <label for="password">Password:</label>
    <input type="password" id="password" name="password">
    <button class="btn" type="submit">Submit</button>
  </form>
</div>
</body>
</html>