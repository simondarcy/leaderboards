<?php
/* 
list.php
This service returns a list of score for a particular 
*/

ini_set('display_errors',1);
error_reporting(E_ALL);


header('Content-type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE');  
header('Access-Control-Allow-Headers: *');  



//The get service will return all scores witin a leaderboard
if ($_SERVER['REQUEST_METHOD'] === 'GET') {


    if (!isset($_GET['id'])){
        echo '{"error":"no id"}';
        return;
    }

    $lid = htmlspecialchars($_GET["id"]);

    require_once('connect.php');

    $query = "SELECT * FROM scores WHERE boardFK = $lid ORDER BY score DESC";

    $result = $link->query($query) or die('Errant query:  '.$query);

    /* create one master array of the records */
    $posts = array();
    if( $result ) {
        while($row = $result->fetch_object()) {
            array_push($posts, $row);
            //$posts[] = array($row);
        }
    }

    /* output in necessary format */
    header('Content-type: application/json');

    echo json_encode(array('scores'=>$posts));

    /* disconnect from the db */
    $result->close();
    $link->close();

} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $postdata = file_get_contents("php://input");

    $request = json_decode($postdata);


    //return;

    if ( !$request->id || !$request->name || !$request->score) {
        echo '{"error":"Missing data, you need id, score and name"}';
        return;
    }
    
    $id = $request->id;
    $score = $request->score;
    $name = $request->name;

    require_once('connect.php');


    /* add new user to DB */
    $query = "INSERT INTO `scores` (`id`, `name`, `score`, `timestamp`, `boardFK`) VALUES (NULL, '$name', '$score', CURRENT_TIMESTAMP, '$id')";
    $result = $link->query($query) or die('Errant query:  '.$query);
    $newid = $link->insert_id;
    echo '{"message":"Score registered successfully", "token":"'.$name.'", "id":'.$newid.'}';
    $link->close();

    return;

    

} else {
    echo '{"error":"invalid method"}';
    return;
}


//A post will insert the new score then return a list of scores as well as where the recently inserted scores postion




?>