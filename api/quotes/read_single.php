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
  $quote = new Quote($db);

  // Get ID
  $quote->id = isset($_GET['id']) ? $_GET['id'] : die();

  // Get quote
  $result = $quote->read_single();

  if ($result) {
    // Create array
    $quote_arr = array(
      'id' => $quote->id,
      'quote' => $quote->quote,
      'author' => $quote->author_name,
      'category' => $quote->category_name
    );
    
    // Make JSON
    print_r(json_encode($quote_arr));
  } else {
    // No Quotes
    echo json_encode(
      array('message' => 'No Quotes Found')
    );
  }
