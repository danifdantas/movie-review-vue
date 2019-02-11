<?php
function createUser($username, $fname, $email)
{
  require_once 'connect.php';
  //GENERATE PASSWORD
    $psw = generate_password();
    // print_r($psw);
    // die;
    $password =  password_hash($psw, PASSWORD_DEFAULT);
  // TODO: SEND EMAIL

  // CHECK IF USERNAME ALREADY EXISTS 
  $check_user_exists_query = "SELECT COUNT(*) FROM tbl_user WHERE user_name = :username";
  $check_user_exists = $pdo->prepare($check_user_exists_query );
  $check_user_exists->execute(
    array(
      ':username'=> $username
    )
  );
  $check_user = $check_user_exists->fetchColumn();
  if($check_user > 0)
  {
    $message = "This username already exists, please choose a different one.";
    return $message;
  }

  $create_user_query = "INSERT INTO tbl_user (user_fname, user_name, user_pass, user_email) VALUES (:fname, :username, :password, :email)";
  $create_user = $pdo->prepare($create_user_query);
  $create_user->execute(
    array(
      ":fname" => $fname,
      ":username" => $username,
      ":password" => $password,
      ":email" => $email
    )
    );
    // or you could store in a variable and check the result as an interger
    // $count = $create_user->rowCount();
    // if there is more than 0 rows being affected by the query then...
  
      
    if($create_user->rowCount())
    {
      $message = send_email($username, $fname, $email, $psw);
      echo $username;
      echo $psw;
      // redirect_to('index.php');
    }else{
      $message = "Create User Failed";
      return $message;
    }
     
}