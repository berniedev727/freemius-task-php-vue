<?php
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
// Check existence of id parameter before processing further
if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
    // Include config file
    require_once "config.php";
    
    $id = trim($_GET["id"]);

    // Prepare a select statement
    $sql = "SELECT * FROM products WHERE id = ?";
    
    if($stmt = $mysqli->prepare($sql)){
        // Bind variables to the prepared statement as parameters
        $stmt->bind_param("i", $id);
        
        // Attempt to execute the prepared statement
        if($stmt->execute()){
            $result = $stmt->get_result();
            
            if($result->num_rows == 1){
                /* Fetch result row as an associative array. Since the result set contains only one row, we don't need to use while loop */
                $row = $result->fetch_array(MYSQLI_ASSOC);
                
                
                // set response code - 200 OK
                http_response_code(200);
             
                // make it json format
                echo json_encode($row);
            } else{
                // set response code - 404 Not found
                http_response_code(404);
             
                // tell the user product does not exist
                echo json_encode(array("message" => "Product does not exist."));
                exit();
            }
            
        } else{
            // set response code - 400 bad request
            http_response_code(400);
         
            // tell the user
            echo json_encode(array("message" => "Oops! Something went wrong. Please try again later."));
        }
    }
     
    // Close statement
    $stmt->close();
    
    // Close connection
    $mysqli->close();
} else{
    // set response code - 400 bad request
    http_response_code(400);
 
    // tell the user
    echo json_encode(array("message" => "ID Parameter required"));
    exit();
}


?>