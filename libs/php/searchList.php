<?php 

require('config.php');

if(isset($_POST['location']) && isset($_POST['department'])) {
    
    $location = $_POST['location'];
    $department = $_POST['department'];

    if ($location === "All Location" && $department === "All Department") {
        $query = "select firstname,lastname,email,employee.location,department,l.location as locname from employee,location l where l.id = employee.location ORDER BY firstname" ;
    }elseif ($department === "All Department") {
        $query = "select firstname,lastname,email,employee.location,department,l.location as locname from employee,location l where l.id = employee.location and employee.location = '$location' ORDER BY firstname" ;
    }elseif($location === "All Location"){
        $query = "select firstname,lastname,email,employee.location,department,l.location as locname from employee,location l where l.id = employee.location and department = '$department' ORDER BY firstname";
    }else{
        $query = "select firstname,lastname,email,employee.location,department,l.location as locname from employee,location l where l.id = employee.location and employee.location = '$location' and department='$department' ORDER BY firstname" ;
    }

    $result = mysqli_query($conn, $query);

    $response = array();

    if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_assoc($result)){
            $response[] = $row;
        }
    }else{
        $response['status'] = 404;
        $response['message'] = "Employees not found";
    }

    header('Content-Type: application/json; charset=UTF-8');
    echo json_encode($response);
     
} 

?>