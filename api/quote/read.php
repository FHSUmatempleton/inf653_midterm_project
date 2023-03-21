<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/Quote.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate quote object
  $Quote = new Quote($db);

  // quote query
  $result = $Quote->read();
  // Get row count
  $num = $result->rowCount();

  // Check if any quotes
  if($num > 0) {
    // Quote array
    $quotes_arr = array();
    // $quotes_arr['data'] = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
      extract($row);

      $quote_item = array(
        'id' => $id,
        'quote' => html_entity_decode($quote),
        'category_name' => $category_name,
        'author_name' => $author_name
      );

      // Push to "data"
      array_push($quotes_arr, $quote_item);
      // array_push($quotes_arr['data'], $quote_item);
    }

    // Turn to JSON & output
    echo json_encode($quotes_arr);

  } else {
    // No Quotes
    echo json_encode(
      array('message' => 'No Quotes Found')
    );
  }
