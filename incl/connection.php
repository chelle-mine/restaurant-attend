<?php

if (isset($_GET['restaurant-id'])) {
  // execute check_restaurants
} else if (isset($_POST['restaurant-id'])) {
  // execute update_restaurant
}

$mysqli_host = 'localhost';
$mysqli_user = 'root';
$mysqli_pw = 'root';
$mysqli_db = '';

$mysqli = new mysqli($mysqli_host, $mysqli_user, $mysqli_pw, $mysqli_db);

if ($mysqli->connect_error) {
  die('Error: '.$mysqli->connect_errorno.' '.$mysqli->connect_error);
}

/*
 * @param $restaurant_id
 * @return 0 or num_rows
 */
function check_restaurants($restaurant_id) {

  $query = "SELECT `id` FROM `users_restaurants` WHERE `restaurant_id`='".$mysqli->real_escape_string($restaurant_id)."'";

  if ($result = $mysqli->query($query)) {
    return $result->num_rows;
  }
  $mysqli->query();
}

/*
 * @param $restaurant_id
 * @return attendance WHERE restaurant_id = $restaurant_id
 */
function update_restaurant($restaurant_id) {

  $query = "";
}
$mysqli->close();

?>
