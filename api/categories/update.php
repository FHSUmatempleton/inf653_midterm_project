<?php
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: PUT');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization,X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/Category.php';
  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate category object
  $category = new Category($db);

  // Get raw posted data
  $data = json_decode(file_get_contents("php://input"));

  // check if params were provided with request
  if (!isset($data->id) || !isset($data->category)) {
    echo json_encode(
      array('message' => 'Missing Required Parameters')
    );
    die();
  }
  
  // update params
  $category->id = $data->id;
  $category->category = $data->category;

  // Update category
  if($category->update()) {
    // Create array
    $cat_arr = array(
      'id' => $category->id,
      'category' => $category->category
    );
    
    // Make JSON
    print_r(json_encode($cat_arr));
  } else {
    echo json_encode(
      array('message' => 'Category not updated')
    );
  }
