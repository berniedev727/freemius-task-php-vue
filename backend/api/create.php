<?php
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
// Include config file
require_once "config.php";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Takes raw data from the request
    $json = file_get_contents('php://input');

    // Converts it into a PHP object
    $data = json_decode($json);

    // Define variables and initialize with empty values
    $title = $description = $price = $vendor_name = $vendor_support_email = "";
    $title_err = $description_err = $price_err = $vendor_name_err = $vendor_support_email_err = "";

    // Validate title
    $title = trim($data->title);
    if(empty($title)){
        $title_err = "Please enter a title.";
    }

    // Validate description
    $description = trim($data->description);
    if(empty($title)){
        $description_err = "Please enter a description.";
    }

    // Validate price
    $price = trim($data->price);
    if(empty($price)){
        $price_err = "Please enter a price.";
    }

    // Validate vendor_name
    $vendor_name = trim($data->vendor_name);
    if(empty($vendor_name)){
        $vendor_name_err = "Please enter a vendor_name.";
    }
    
    // Validate vendor_support_email
    $vendor_support_email = trim($data->vendor_support_email);
    if(empty($vendor_support_email)){
        $vendor_support_email_err = "Please enter a vendor_support_email.";
    } else if (!filter_var($vendor_support_email, FILTER_VALIDATE_EMAIL)) {
        $vendor_support_email_err = "Please enter a valid vendor_support_email.";
    }



    // Check input errors before inserting in database
    if(empty($title_err) && empty($description_err) && empty($price_err) && empty($vendor_name_err) && empty($vendor_support_email_err)){

        // Prepare an insert statement
        $sql = "INSERT INTO products (title, description, price, vendor_name, vendor_support_email) VALUES (?, ?, ?, ?, ?)";
 

        if($stmt = $mysqli->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("ssdss", $title, $description, $price, $vendor_name, $vendor_support_email);
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                
                // set response code - 201 created
                http_response_code(201);
         
                // tell the user
                echo json_encode(array("message" => "Product was created."));
                exit();
            } else{
                // set response code - 503 service unavailable
                http_response_code(503);
         
                // tell the user
                echo json_encode(array("message" => "Unable to create product."));
            }
        }
         
        // Close statement
        $stmt->close();
    } else {
        // set response code - 400 bad request
        http_response_code(400);
     
        // tell the user
        echo json_encode(array("message" => "Unable to create product. Data is incomplete."));
    }
    
    // Close connection
    $mysqli->close();

}



?>