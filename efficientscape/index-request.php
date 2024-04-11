<?php
    include_once 'database.php';
    $articles = array();
    $getData = "SELECT title, content FROM articles ORDER BY id DESC";
    $resultData = mysqli_query($conn, $getData);
    $checkData = mysqli_num_rows($resultData);
    for ($i = 0; $i < $checkData; $i++){
        $articles[$i] = mysqli_fetch_array($resultData, MYSQLI_ASSOC);
    }
?>