<?php
// ini_set('display_errors', 'On');
// error_reporting(E_ALL);

function login($username, $password)
{
  require_once('connect.php');

  //check if user exists
  $check_user = "SELECT COUNT(*) FROM tbl_user WHERE user_name = :username";
  $user_set = $pdo->prepare($check_user);
  $user_set->execute(
    array(
      ':username'=> $username
    )
  );
 
  //Check user password
  $check_user_psw = "SELECT user_pass FROM tbl_user WHERE user_name = :username";
  $user_psw = $pdo->prepare($check_user_psw);
  $user_psw->execute(
    array(
      ':username'=> $username,
    )
  );

  //PASSWORD INCORRECT 
  if($check_user_psw !== $password)
  {
    //INCREMENT USER FAILED LOGIN
    $set_failed_login = "UPDATE tbl_user SET user_failed_login = user_failed_login +1 WHERE user_name = :username";
    $set_failed_login = $pdo->prepare($set_failed_login);
    $set_failed_login->execute(
              array(
              ":username" => $username
            )
          );
    //UPDATE FAILED LOGIN TIME
    date_default_timezone_set('America/Toronto');
    $set_failed_login_time = "UPDATE tbl_user SET user_failed_login_time = NOW() WHERE user_name = :username";
    $set_failed_login_time = $pdo->prepare($set_failed_login_time);
    $set_failed_login_time->execute(
              array(
              ":username" => $username
            )
          );
   
  }    
  // CHECK FAILED ATTEMPTS
  $get_user_active_query = "SELECT user_failed_login FROM tbl_user WHERE user_name = :username";
  $user_active = $pdo->prepare($get_user_active_query);
  $user_active->execute(
          array(
          ":username" => $username
        )
      );
    
    while ($check_user_active = $user_active->fetch(PDO::FETCH_ASSOC))
    {
      if($check_user_active["user_failed_login"] >= 3) 
         {
          //BLOCK USER FOR 15min -  
          $block_user_query = "SELECT user_failed_login, (CASE when `user_failed_login_time` is not NULL and DATE_ADD(user_failed_login_time, INTERVAL 15 MINUTE)>NOW() then 1 else 0 end) as denied FROM tbl_user WHERE user_name = :username
          ";
          $block_user = $pdo->prepare($block_user_query);
          $block_user->execute(
                array(
                ":username" => $username
              )
            );
          $block = $block_user->fetch(PDO::FETCH_ASSOC);
            if($block["denied"] == 1)
            {
              redirect_to('blocked.php');
            }  
          }
     }
  if($user_set->fetchColumn() > 0)
  {
        $get_user_query = "SELECT * FROM tbl_user WHERE user_pass = :psw AND user_name = :username";
        $get_user_set = $pdo->prepare($get_user_query);
        $get_user_set->execute(
            array(
          ":psw" => $password,
          ":username" => $username
          )
        );
          while ($found_user = $get_user_set->fetch(PDO::FETCH_ASSOC)) 
          {
            $id = $found_user['user_id'];
            $_SESSION['user_id'] = $id;
            $_SESSION['user_name'] = $found_user['user_name'];
            $_SESSION['user_login_time'] = $found_user['user_login_time'];
             
            date_default_timezone_set('America/Toronto');

            // SET LOGIN TIME
            $set_login_datetime = "UPDATE tbl_user SET user_login_time = NOW() WHERE user_id = :userId";
            $set_login_datetime = $pdo->prepare($set_login_datetime);
            $set_login_datetime->execute(
                    array(
                      ":userId" => $_SESSION['user_id']
                    )
                  );
            // RESET USER TO ACTIVE
            $set_user_active = "UPDATE tbl_user SET user_active = 0  WHERE user_id = :userId";
            $set_user_active = $pdo->prepare($set_user_active);
            $set_user_active->execute(
                    array(
                      ":userId" => $_SESSION['user_id']
                    )
                  );
            //RESET LOGIN ATTEMPTS
            $set_failed_login = "UPDATE tbl_user SET user_failed_login = 0 WHERE user_name = :username";
            $set_failed_login = $pdo->prepare($set_failed_login);
            $set_failed_login->execute(
                      array(
                      ":username" => $username
                    )
                  );
              redirect_to('index.php');
          }
  }
  else
  {
    $message = 'The username or password is incorrect!';
    return $message;
  }
}   

      

     
    

