<?php
function getConnection(){
      //database connect
      define('DB_NAME', 'finalAssignmentDB');
      define('DB_USER', 'root');
      define('DB_PASSWORD', '');
      define('DB_HOST', 'localhost');
      $conn = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME) or
      die("Can not connect to DB");
      return $conn;
}
?>
