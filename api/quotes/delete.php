<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: DELETE');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/Quote.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate quote object
  $quote = new Quote($db);

  // Get raw quoteed data
  $data = json_decode(file_get_contents("php://input"));

  // Set ID to update
  $quote->id = $data->id;
  if (!$quote->read_single()) {
    echo json_encode(
      array('message' => 'No Quotes Found')
    );
    die();
  }
  
  // Delete quote
  if($quote->delete()) {
    echo json_encode(
      array('id' => $quote->id)
    );
  } else {
    echo json_encode(
      array('message' => 'Quote Not Deleted')
    );
  }

