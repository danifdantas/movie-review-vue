<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL);

function login($username, $password)
{
  require_once('connect.php');

  //check if user credentials are correct
  $check_user_psw = "SELECT COUNT(*) FROM tbl_user WHERE user_name = :username AND user_pass = :psw";
  $psw_set = $pdo->prepare($check_user_psw);
  $psw_set->execute(
    array(
      ':username'=> $username,
      ':psw' => $password
    )
  );
  $user_ok = (int)$psw_set->fetchColumn();
  // var_dump($user_ok);exit;
  //Check if user is active
  $check_user_active_query = "SELECT user_active FROM tbl_user WHERE user_name = :username";
  $check_user_active = $pdo->prepare($check_user_active_query);
  $check_user_active->execute(
    array(
      ':username'=> $username,
    )
  );
  $result = $check_user_active->fetch(PDO::FETCH_ASSOC);
  $user_status = (int)$result["user_active"];

  // var_dump($user_status);die;

  //PASSWORD INCORRECT 
   if($user_ok===0)
   {
     
      $get_failed_login = "SELECT user_failed_login FROM tbl_user WHERE user_name = :username";
      $get_failed_login = $pdo->prepare($get_failed_login);
      $get_failed_login->execute(
          array(
          ":username" => $username
        )
      );
      $result=$get_failed_login->fetch(PDO::FETCH_ASSOC);
      $failed=$result["user_failed_login"];
      //  var_dump(++$failed);die;
      $failed = ++$failed;
      $set_failed_login = "UPDATE tbl_user SET user_failed_login = $failed WHERE user_name = :username";
      $set_failed_login = $pdo->prepare($set_failed_login);
      $set_failed_login->execute(
              array(
              ":username" => $username
            )
          );
      if($failed>=3)
      {
          $set_user_active = "UPDATE tbl_user SET user_active = 1 WHERE user_name = :username";
          $set_user_active = $pdo->prepare($set_user_active);
          $set_user_active->execute(
                array(
                ":username" => $username
              )
            );
            $get_last_login = "SELECT user_login_time FROM tbl_user WHERE user_name = :username";
            $get_last_login = $pdo->prepare($get_last_login);
            $get_last_login->execute(
                  array(
                  ":username" => $username
                )
              );
              $last_login_time = $get_last_login->fetch(PDO::FETCH_ASSOC);
              $time=$last_login_time["user_login_time"];
              $curr_time=date();
              // $difference=$time->diff($curr_time);
          var_dump($curr_time); die;
          
          redirect_to('blocked.php');
          
      } 
    }elseif($user_ok>0) 
      {
      //   echo "inside elseif";
      // var_dump($user_ok);exit;
      $get_user_query = "SELECT * FROM tbl_user WHERE user_pass = :psw AND user_name = :username";
      $get_user_set = $pdo->prepare($get_user_query);
      $get_user_set->execute(
        array(
          ":psw" => $password,
          ":username" => $username
        )
      );
      // var_dump($get_user_query);die;
      while ($found_user = $get_user_set->fetch(PDO::FETCH_ASSOC)) {
        $id = $found_user['user_id'];
        $_SESSION['user_id'] = $id;
        $_SESSION['user_name'] = $found_user['user_name'];
        $_SESSION['user_login_time'] = $found_user['user_login_time'];
        date_default_timezone_set('America/Toronto');
  
        $set_login_datetime = "UPDATE tbl_user SET user_login_time = NOW() WHERE user_id = :userId";
        $set_login_datetime = $pdo->prepare($set_login_datetime);
        $set_login_datetime->execute(
          array(
            ":userId" => $_SESSION['user_id']
          )
        );
        $set_user_active = "UPDATE tbl_user SET user_active = 0  WHERE user_id = :userId";
        $set_user_active = $pdo->prepare($set_user_active);
        $set_user_active->execute(
          array(
            ":userId" => $_SESSION['user_id']
          )
        );
        $set_failed_login = "UPDATE tbl_user SET user_failed_login = 0 WHERE user_name = :username";
        $set_failed_login = $pdo->prepare($set_failed_login);
        $set_failed_login->execute(
            array(
            ":username" => $username
          )
        );
        redirect_to('index.php');
      }
    }else{
        $message = 'The username or password is incorrect!';
        return $message;
    }
      
}
