<?php 

require('config.php');

if(isset($_POST['updatedFirstName']) && isset($_POST['updatedLastName']) && isset($_POST['updatedEmail']) && isset($_POST['updatedLocation']) && isset($_POST['updatedDepartment']) && isset($_POST['compareVal'])) {

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