<?php 

require('config.php');

if(filter_var($_POST['updatedFirstName'],FILTER_SANITIZE_STRING) == false){
    $response['error']="Please enter valid First Name";
 }elseif(filter_var($_POST['updatedLastName'],FILTER_SANITIZE_STRING) == false){
    $response['error']="Please enter valid Last Name";
 }elseif(filter_var($_POST['updatedEmail'],FILTER_SANITIZE_EMAIL) == false || filter_var($_POST['updatedEmail'],FILTER_VALIDATE_EMAIL) == false){
    $response['error']="Please enter valid Email Address";
 }else{

    $query = "UPDATE employee SET firstname='$_POST[updatedFirstName]',lastname='$_POST[updatedLastName]', email= '$_POST[updatedEmail]',location='$_POST[updatedLocation]',department='$_POST[updatedDepartment]' WHERE email = '$_POST[compareVal]'";
    $result = mysqli_query($conn,$query);

    if($result){
        $response['status'] = 200;
        $response['message'] = "Employee details updated successfully";
    }else{
        $response['status'] = 404;
        $response['message'] = "Failed to update record--".mysqli_error($conn);
    }

}
header('Content-Type: application/json; charset=UTF-8');
echo json_encode($response);

?>