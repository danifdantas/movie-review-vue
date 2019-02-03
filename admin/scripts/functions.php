
<?php
function redirect_to($location){
  if($location != NULL){
    header('Location:' .$location);
    exit();
  }
}
// function user_blocked(){
//  sleep(2);
//  redirect_to('admin_login.php');
// }