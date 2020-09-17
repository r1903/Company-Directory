<?php 

require('config.php');


//fetches all employees onload 
if(isset($_POST['employees'])) {
 
    $query = "select firstname,lastname,email,employee.location,department,l.location as locname from employee,location l where l.id = employee.location order by firstname ";
    $result = mysqli_query($conn, $query);
    $response = array();

    if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_assoc($result))
        {
            $response[] = $row;
        }
    }else{
        $response['status'] = 404;
        $response['message'] = "Employees not found";
    }    

}

//selects the list of departments for selected location.
if(isset($_POST['locationId'])) {
    
    $location_id = $_POST['locationId'];
    $query = $location_id =="All Location" ? "select distinct name from department":"select * from department where location_id='$location_id'";
   
    $result = mysqli_query($conn, $query);

    $response = array();

    if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_assoc($result)){
            $response[] = $row;
        }
    }else{
        $response['status'] = 404;
        $response['message'] = "Data not found";
    }
   
} 

mysqli_close($conn);
header('Content-Type: application/json; charset=UTF-8');
echo json_encode($response);

?>


