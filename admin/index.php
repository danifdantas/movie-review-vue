<?php 
require_once('scripts/config.php');
confirm_logged_in();
greeting();
$message = greeting();
$date= date_create($_SESSION['user_login_time']);
$readable_date = ( date_format($date, ' l jS F Y \a\t g:ia')); 
            
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="../css/main.css">
  <link href="https://fonts.googleapis.com/css?family=Raleway:300,500" rel="stylesheet">
  <title>Welcome to Your Admin Panel</title>
</head>
<body id="admin-dash">
  <h1>Admin Dashboard</h1>
  <h2>Welcome <?php echo $_SESSION['user_name'];?></h2>
  <h3><?php echo $message;  ?></h3>
  <?php 
      ?>
  <p>Your Last Login Was on <?php echo $readable_date;?></p>
  <p>This is the admin dashboard page</p>
  <nav>
    <ul>
      <li><a href="admin_createuser.php">Create User</a></li>
      <li><a href="#">Edit User</a></li>
      <li><a href="#">Delete User</a></li>
      <li><a href="scripts/caller.php?caller_id=logout">Sign Out</a></li>
    </ul>
  </nav>
</body>
</html>

