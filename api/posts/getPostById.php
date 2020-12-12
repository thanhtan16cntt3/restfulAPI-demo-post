<?php 
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once('../../config/database.php');
    include_once('../../models/post.php');

    $database = new Database();
    $db = $database->connect();

    $post = new Post($db);

    $post->id = isset($_GET['id']) ? $_GET['id'] : die();

    $post->getPostById();

    $post_arr = array(
        'id' => $post->id,
        'title' => $post->title,
        'body' => $post->body,
        'category_name' => $post->category_name,
        'category_id' => $post->category_id,
        'author' => $post->author
    );

    print_r(json_encode($post_arr));
?>