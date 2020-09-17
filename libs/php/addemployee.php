<?php 

//inserts the new employee data to database
require('config.php');

if(filter_var($_POST['firstName'],FILTER_SANITIZE_STRING) == false){
   $response['error']="Please enter valid First Name";
}elseif(filter_var($_POST['lastName'],FILTER_SANITIZE_STRING) == false){
   $response['error']="Please enter valid Last Name";
}elseif(filter_var($_POST['email'],FILTER_SANITIZE_STRING) == false || filter_var($_POST['email'],FILTER_VALIDATE_EMAIL) == false){
   $response['error']="Please enter valid Email Address";
}else{

   $firstName = filter_var($_POST['firstName'],FILTER_SANITIZE_STRING);
   $lasstName = filter_var($_POST['lastName'],FILTER_SANITIZE_STRING);
   $email = filter_var($_POST['email'],FILTER_SANITIZE_STRING);

   $query = "INSERT INTO `employee`(`firstname`, `lastname`, `email`, `location`, `department`) VALUES ('$firstName','$lastName','$email','$_POST[location]','$_POST[department]')" ;
   $result= mysqli_query($conn,$query);

   if($result){
      $response['status'] = 200;
      $response['message'] = "New employee created successfully";
   }else{
      $response['status'] = 404;
      $response['message'] = "Failed to save record--".mysqli_error($conn);
   }

}

header('Content-Type: application/json; charset=UTF-8');
echo json_encode($response);

?>