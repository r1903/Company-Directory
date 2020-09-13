<?php 

require('config.php');

extract($_POST);

if(isset($_POST['employees'])) {
 
    $query = "select * from employee";
    $result = mysqli_query($conn, $query);
    $emparray = array();
   
    while($row =mysqli_fetch_assoc($result))
    {
        $emparray[] = $row;
    }

    header('Content-Type: application/json; charset=UTF-8');
    echo json_encode($emparray);

}

if(isset($_POST['firstName']) && isset($_POST['lastName']) && isset($_POST['email']) && isset($_POST['manager']) && isset($_POST['location']) && isset($_POST['department'])) {

    $query = "INSERT INTO `employee`(`firstname`, `lastname`, `email`, `manager`, `location`, `department`) VALUES ('$firstName','$lastName','$email','$manager','$location','$department')" ;
     mysqli_query($conn,$query);

}



if(isset($_POST['emailid'])) {

    $email = $_POST['emailid'];
    $query = "delete from employee where email='$email'";
    mysqli_query($conn, $query);
}

if(isset($_POST['id'])){
    $employee_id = $_POST['id'];

    $query = "select * from employee where email='$employee_id'";
    $result = mysqli_query($conn, $query);

    // if(!$result){
    //     exit(mysqli_error());
    // }

    $response = array();

    if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_assoc($result)){
            $response = $row;
        }
    }else{
        $response['status'] = 200;
        $response['message'] = "Data not found";
    }
   
     echo json_encode($response);
     
} else{

    $response['status'] = 200;
    $response['message'] = "Invalid Request";

}


if(isset($_POST['locationId'])) {
    
    $location_id = $_POST['locationId'];
    $query = $location_id =="All Location" ? "select distinct name from department":"select * from department where location_id='$location_id'";
   
    $result = mysqli_query($conn, $query);

    // if(!$result){
    //     exit(mysqli_error());
    // }

    $response = array();

    if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_assoc($result)){
            $response[] = $row;
        }
    }else{
        $response['status'] = 200;
        $response['message'] = "Data not found";
    }
    header('Content-Type: application/json; charset=UTF-8');
     echo json_encode($response);
     
} else{

    $response['status'] = 200;
    $response['message'] = "Invalid Request";

}



?>


