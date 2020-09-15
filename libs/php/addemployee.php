<?php 

//inserts the new employee data to database
require('config.php');

    $query = "INSERT INTO `employee`(`firstname`, `lastname`, `email`, `location`, `department`) VALUES ('$_POST[firstName]','$_POST[lastName]','$_POST[email]','$_POST[location]','$_POST[department]')" ;
    $result= mysqli_query($conn,$query);
  
    if($result){
        $response['status'] = 200;
        $response['message'] = "New employee created successfully";
     }else{
        $response['status'] = 404;
        $response['message'] = "Failed to save record--".mysqli_error($conn);
     }

header('Content-Type: application/json; charset=UTF-8');
echo json_encode($response);

?>