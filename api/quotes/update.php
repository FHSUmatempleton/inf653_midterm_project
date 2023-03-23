<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: PUT');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/Quote.php';
  include_once '../../models/Author.php';
  include_once '../../models/Category.php';
  include_once '../../functions/isValid.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate quote object
  $quote = new Quote($db);

  // Get raw quoteed data
  $data = json_decode(file_get_contents("php://input"));

  // make sure all parameters are provided with request
  if (!isset($data->id) || !isset($data->quote) || !isset($data->author_id) || !isset($data->category_id)) {
    echo json_encode(
      array('message' => 'Missing Required Parameters')
    );
    die();
  }

  // Determine if author exists
  $author = new Author($db);
  $authorExists = isValid($data->author_id, $author);
  if (!$authorExists) {
    echo json_encode(
      array('message' => 'author_id Not Found')
    );
    die();
  }

  // Determine if category exists
  $category = new Category($db);
  $categoryExists = isValid($data->category_id, $category);
  if (!$categoryExists) {
    echo json_encode(
      array('message' => 'category_id Not Found')
    );
    die();
  }

  // Set ID to update
  $quote->id = $data->id;

  $quote->quote = $data->quote;
  $quote->author_id = $data->author_id;
  $quote->category_id = $data->category_id;

  // Determine if quote exists
  if (!$quote->read_single()) {
    echo json_encode(
      array('message' => 'No Quotes Found')
    );
    die();
  }

  // Update quote
  if($quote->update()) {
    // Create array
    $quote_arr = array(
      'id' => $quote->id,
      'quote' => $quote->quote,
      'author_id' => $quote->author_id,
      'category_id' => $quote->category_id
    );
    
    // Make JSON
    print_r(json_encode($quote_arr));
  } else {
    echo json_encode(
      array('message' => 'Quote Not Updated')
    );
  }

