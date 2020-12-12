<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: DELETE');
    header('Access-Control-Allow-headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once('../../config/database.php');
    include_once('../../models/post.php');

    $database = new Database();
    $db = $database->connect();

    $post = new Post($db);

    //get raw posted data
    $data = json_decode(file_get_contents("php://input"));

    $post->id = $data->id;

    if($post->delete()){
        echo json_encode(array("message" => "Post deleted successfully"));
    } else{
        echo json_encode(array("message" => "Post not deleted correctly"));
    }