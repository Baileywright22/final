<?php
    INCLUDE("security.php");

    header('Content-Type: application/json');
    
    if(security_validate_get()) 
    {
      // Ensure the user has entered a username before continuing.
      if(strlen($_GET['username']) == 0)
      {
        echo "Please enter a username.";
        return;
      }
      
      if(strlen($_GET['password']) == 0)
      {
        echo "Please enter the password.";
        return;
      }

      if($_GET['username'] == 'DIG' && $_GET['password'] == '3134')
      {
        $arr = array($_GET['username'],$_GET['password']);
        echo json_encode($arr)."\n";  
        echo json_encode("The correct combination is DIG and 3134");  
      }
    }
  ?>