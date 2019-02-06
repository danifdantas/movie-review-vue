<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL);

require_once('scripts/config.php');
confirm_logged_in();

if(filter_has_var(INPUT_POST,'submit')) {
  // var_dump($_POST);
  $username = trim(htmlspecialchars($_POST['username']));
  $fname = trim(htmlspecialchars($_POST['fname']));
  $email = trim(htmlspecialchars($_POST['email']));
  // var_dump($username, $password, $email, $fname);
  //Validation
  if(empty($_POST['username']) || empty($_POST['fname']))
  {
    $message = 'Please fill out all fields';
    
  }elseif(filter_var($email, FILTER_VALIDATE_EMAIL) === false)
  {
    $message = 'Please fill out all fields';
  }
  else
  {
    $result = createUser($username, $fname, $email);
    $message = $result;
  }
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
  <title>Create User</title>
</head>
<body>
  <h1>Create User</h1>
  <?php if(!empty($message)):?>
  <div class="message">
    <p><?php echo $message?></p>
    </div>
  <?php endif; ?>
  <form action="admin_createuser.php" method="post">
    <label for="first-name">First Name:</label>
     <input type="text" id="first-name" name="fname" value="">

    <label for="username">Username:</label>
     <input type="text" id="username" name="username" value="">

    <label for="email">Email:</label>
     <input type="email" id="email" name="email" value="">

    <!-- <label for="password">Password:</label>
    <input type="text" id="password" name="password" value=""> -->

    <button class="btn" type="submit" name="submit">Create User</button>
  </form>
</body>
</html>