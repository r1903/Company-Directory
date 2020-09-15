<?php 

require('config.php');

if(isset($_POST['id'])){

    $employee_id = $_POST['id'];

    $query = "select firstname,lastname,email,employee.location,department,l.location as locname from employee,location l where l.id = employee.location and employee.email='$employee_id'";
    $result = mysqli_query($conn, $query);
    $response = array();

    if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_assoc($result)){
            $response = $row;
        }
    }else{
        $response['status'] = 404;
        $response['message'] = "Data not found";
    }

    header('Content-Type: application/json; charset=UTF-8');
    echo json_encode($response);
     
} 

?>