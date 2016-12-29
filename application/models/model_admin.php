<?php
/**
 *
 */
class Model_Admin extends Model
{
    

    public function __construct(){

    }


    public function get_data()
    {
        // TODO: Implement get_data() method.
    }

    public function getAllData(){
      $query = "SELECT * FROM Users, Goods, Orders, Producers, Types";
      return $this->connect->query($query);
    }
}

 ?>
