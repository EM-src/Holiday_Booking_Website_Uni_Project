<?php
function getConnection(){
      //database connect
      define('DB_NAME', 'unn_w21050558');
      define('DB_USER', 'unn_w21050558');
      define('DB_PASSWORD', 'Viper12345!');
      define('DB_HOST', 'localhost');
      $conn = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME) or
      die("Can not connect to DB");
      return $conn;
}
?>