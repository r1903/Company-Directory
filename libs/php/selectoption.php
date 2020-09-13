<?php 

require('config.php');

$query = "select * from location";
$result = mysqli_query($conn, $query);
$option;

while($row = mysqli_fetch_assoc($result))
{
    $option['location'][] = $row;
}

$query = "select distinct name from department";
$result = mysqli_query($conn, $query);

while($row = mysqli_fetch_assoc($result))
{
    $option['department'][] = $row;
}

header('Content-Type: application/json; charset=UTF-8');
echo json_encode($option);


?>