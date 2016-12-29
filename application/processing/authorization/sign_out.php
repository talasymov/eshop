<?php
  session_start();
  if(!isset($_SESSION['isUserCorrect'])){
    $_SESSION['isUserCorrect'] = FALSE;
  }
  else{
      $_SESSION['isUserCorrect'] = FALSE;
  }
  echo json_encode($_SESSION['isUserCorrect']);
  unset($_SESSION['isUserCorrect']);
  session_destroy();
 ?>
