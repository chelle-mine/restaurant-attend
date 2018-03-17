<?php

require_once 'request.php';

$BUSINESS_ID = $_GET['business_id'] ?? '';

if (!empty($BUSINESS_ID)) {
  $reviews = get_reviews($BUSINESS_ID);
  echo $reviews;
} else {
  echo 'Invalid Business ID.<br>';
}

?>
