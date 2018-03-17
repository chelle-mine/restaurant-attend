<?php

require_once 'request.php';

$CATEGORY = 'restaurants';
$LOCATION = $_GET['location'] ?? '';

if (!empty($LOCATION)) {
  $restaurants = search($CATEGORY, $LOCATION);
  echo $restaurants;
} else {
  echo 'Please enter a location.<br>';
  return;
}

?>
