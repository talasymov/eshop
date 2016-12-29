<?php
namespace core\models;

use core as c;
/**
 *
 */
class Model_Profile extends c\Model
{
  public function get_data(){
    $this->initConnect();
    $result = $this->connect->query("SELECT * FROM Users");
    $this->closeConnect();
    return $result;
  }

}
 ?>
