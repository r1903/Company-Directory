<?php 

require('config.php');

if(isset($_POST['id'])) {

$email = $_POST['id'];
$query = "delete from employee where email='$email'";
$result= mysqli_query($conn, $query);

if($result){
    $response['status'] = 200;
    $response['message'] = "Employee deleted successfully";
 }else{
    $response['status'] = 404;
    $response['message'] = "Failed to delete record--".mysqli_error($conn);
 }
 
mysqli_close($conn);
header('Content-Type: application/json; charset=UTF-8');
echo json_encode($response);
}

?>