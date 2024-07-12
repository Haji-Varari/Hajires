<?php
session_start();
if(isset($_POST['name'])){
    $customerID=$_POST['customerID'];
    $address = $_POST['address'];
    $notes = $_POST['notes'];
    $name = $_POST['name'];
    $contact = $_POST['contact'];

    $servername = "localhost";
    $username = "root";
    $password = "";
    $conn = new mysqli($servername, $username, $password); 
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 
    $sql = "USE haji_restaurant";
    $conn->query($sql);
    $sql = "UPDATE customer SET 
    CustomerName = '".$name."',
    CustomerPhone = '".$contact."', 
    CustomerAddress = '".$address."',
    CustomerNotes= '".$notes."'  where  CustomerID= $customerID";
    $conn->query($sql);
    header("Location:landing.php");
}else{
    echo '<span style="color: red;">Customer Does not exist</span>';
    header("Location:landing.php?errcode=2");
}
?>