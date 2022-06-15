<?php
    include_once('db.php');
    session_start();
    check_section();
    $path="";
    if(!isset($_GET['id']))
    {
        die('Sai tập tin');
    }
    if(empty($_GET['id']))
    {
        die('Tập tin không tồn tại');
    }
    $name = $_GET['id'];
    $path = $_SERVER['DOCUMENT_ROOT'].$name;
    $name = basename($_GET['id']);
    if(!file_exists($path))
    {
        die("Tập tin không tồn tại");
    }
    $size = filesize($path);
    header('Content-Type: application/octet-stream');
    header("Content-Length: '$size'");
    header("Content-Disposition: attachment; filename =\"$name\"");

    $file = fopen($path,"rb");
    
    while(!feof($file))
    {
        $data = fread($file,1024);
        echo $data;
    }
    fclose($file);
?>