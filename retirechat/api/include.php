<?php

session_start();

$conn = mysqli_connect("localhost", "root", "BAgowan13sql", "retire-chat");

if (mysqli_connect_errno()) {
  die('Unable to connect to database [' . mysqli_connect_error() . ']');
}


?>
