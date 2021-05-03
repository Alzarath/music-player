<?php
require_once "../../app.php";
$return = array();
$get_dir = isset($_GET['dir'])?strip_tags($_GET['dir']):false;

function error_message(){
    echo json_encode(array("data" => array(), "error" => true));
    die();
}

if($get_dir===false){
    error_message();
}

$request_dir = $root.$library.$get_dir;
if(realpath($request_dir)===false){
    error_message();
}
if(strstr($request_dir, $root) === false){
    error_message();
    // tries to list no music dirs
}

if(!is_readable($request_dir)){
    error_message();
}
$return = array();
$list = scandir($request_dir);
$validExts = array("mp3", "wav", "flac", "m4a", "ogg", "opus", "oga", "mp4", "webm")
foreach($list as $file){
    $ext = array_pop(preg_split("/\./", $file));
    if(!is_dir($request_dir.$file) && in_array($ext, $validExts)){
        $return[] = array(
            "image" => "./public/img/default.png",
            "name" => $file,
            "path" => $public['library'].'/'.$get_dir . "/" . $file
        );
    }
}

echo json_encode($return);
?>
