<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once('../../config/database.php');
    include_once('../../models/category.php');

    $database = new Database();
    $db = $database->connect();

    $category = new Category($db);

    $data = json_decode(file_get_contents("php://input"));

    $category->name = $data->name;

    if($category->create()){
        echo json_encode(array("message" => "Category created successfully"));
    } else{
        echo json_encode(array("message" => "Category not created correctly"));
    }