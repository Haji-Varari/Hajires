<?php
session_start();
if(isset($_POST['contactNumber'])){
    $contactNumber=$_POST['contactNumber'];
    include "connectDB.php";     
     $sql="SELECT * FROM Customer WHERE CustomerPhone=:contactNumber";
     $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
        ':contactNumber' => $contactNumber,   
     ));
    
    if($stmt->rowCount()>0){
        while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) )
        { 
            $_SESSION['id']=$row['UserID']; 
            $customerID=$row['CustomerID'];
        }
        header("Location:edituser.php?customerID=$customerID");
        
    }else{
        echo '<span style="color: red;">Customer Does not exist</span>';
        header("Location:landing.php?errcode=1");
    }
     
}else{
    echo '<span style="color: red;">Customer Does not exist</span>';
    header("Location:landing.php?errcode=2");
}
?>