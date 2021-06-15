<?
// $test = "SELCT FROM DB";
// $new = explode(' ', $test);
// var_dump($new);

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, PUT, DELETE');

// Table we have in our DB
$tables = ['posts'];
$method = $_SERVER['REQUEST_METHOD'];
// echo $method;
$request_uri = $_SERVER['REQUEST_URI'];
// echo $request_uri;
$url = rtrim($request_uri, '/');
$url = filter_var($request_uri, FILTER_SANITIZE_URL);
$url = explode('/', $url);
// print_r($url);
$tableName = (string) $url[3];
// print_r($tableName);

if(isset($url[4]) && $url[4] !== null){
    $id = (int) $url[4];
}else{
    $id = null;
}

// Check if tablenam exist in the table array
if(in_array($tableName, $tables)){
    include_once 'classes/Database.php';
    include_once 'api/posts.php';
}else{
    echo "Table doesn't exist";
}

?>