<?php
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');

$query = "";
// Check existence of id parameter before processing further
if(isset($_GET["query"]) && !empty(trim($_GET["query"]))){
    $query = trim($_GET["query"]);
}
    
    // Include config file
    require_once "config.php";
    
    $query = '%' . $query . '%';
    // Prepare a select statement
    $sql = "SELECT * FROM products WHERE title like ? or description like ? or price like ? or vendor_name like ? or vendor_support_email like ?";
    
    if($stmt = $mysqli->prepare($sql)){
        // Bind variables to the prepared statement as parameters
        $stmt->bind_param("sssss", $query, $query, $query, $query, $query);
        
        // Attempt to execute the prepared statement
        if($stmt->execute()){
            $result = $stmt->get_result();
            
            if($result->num_rows > 0){

                $products = [];
                while ($row = $result->fetch_array(MYSQLI_ASSOC)){
                    // extract row
                    // this will make $row['name'] to
                    // just $name only
                    extract($row);
             
                    array_push($products, $row);
                }
                
                
                // set response code - 200 OK
                http_response_code(200);
             
                // make it json format
                echo json_encode($products);
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

?>