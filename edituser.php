<?php
session_start();
$nameErr  = $addressErr  = $contactErr =  $notesErr = "";
$name  = $address =$notes = $contact = "";

$oName;
$oPhone;
$oAddress;
$oNotes;



$servername = "localhost";
$username = "root";
$password = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{
	$customerIDTemp=$_POST['customerID'];
}else{
	$customerIDTemp=$_GET['customerID'];	
}
$conn = new mysqli($servername, $username, $password); 

if ($conn->connect_error) {
die("Connection failed: " . $conn->connect_error);
} 

$sql = "USE haji_restaurant";
$conn->query($sql);
$sql = "SELECT   
customer.CustomerName,
customer.CustomerPhone,
customer.CustomerAddress,
customer.CustomerNotes
FROM  customer WHERE  customer.CustomerID =  ".$customerIDTemp."";

	$result = $conn->query($sql);
while($row = $result->fetch_assoc()){
$oName = $row['CustomerName'];
$oPhone = $row['CustomerPhone'];
$oAddress = $row['CustomerAddress'];
$oNotes = $row['CustomerNotes'];
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
if (empty($_POST["name"])) {
	$nameErr = "Please enter name";
}else{
	if (!preg_match("/^[a-zA-Z ]*$/", $name)){
		$nameErr = "Only letters and white space allowed";
		$name = "";
	}else{
		$name = $_POST['name'];
		if (empty($_POST["contact"])){
			$contactErr = "Please enter your phone number";
		}else{
			if(!preg_match("/^[0-9 -]*$/", $contact)){
				$contactErr = "Please enter a valid phone number";
				$contact = "";
			}else{
				$contact = $_POST['contact'];
				if (empty($_POST["address"])){
					$addressErr = "Please enter your address";
					$address = "";
					}else{
						$address = $_POST['address'];
						if (empty($_POST["notes"])){
						$notesErr = "Please enter  Notes";
						$notes = "";
						}else{
						$notes = $_POST['notes'];
						$servername = "localhost";
						$username = "root";
						$password = "";
						$conn = new mysqli($servername, $username, $password); 
						if ($conn->connect_error) {
							die("Connection failed: " . $conn->connect_error);
						} 
						$sql = "USE haji_restaurant";
						$conn->query($sql);
						$sql = "UPDATE customer SET CustomerName = '".$name."', CustomerPhone = '".$contact."', 
						CustomerAddress = '".$address."', CustomerNotes= '".$notes."'";
						$conn->query($sql);
						header("Location:landing.php");
						}
					}
				}
			}
		}
	}
}
				
			
		
	

										
function test_input($data){
$data = trim($data);
$data = stripcslashes($data);
$data = htmlspecialchars($data);
return $data;
}
?>
<html>
<link rel="stylesheet" href="style.css">
<body>
<header>
<blockquote>
<a href="index.php"><img src="image/HajiRestaurantLogo.jpeg"></a>
</blockquote>
</header>
<blockquote>
<div class="container">
<form action="updateCustomer.php" method="post">
<h1>Edit Profile:</h1>
<input type="text" name="customerID"  value=<?php echo $customerIDTemp;?> >
Full Name:<br><input type="text" name="name" placeholder="<?php echo $oName; ?>">
<span class="error" style="color: red; font-size: 0.8em;"><?php echo $nameErr;?></span><br><br>

Mobile Number:<br><input type="text" name="contact" placeholder="<?php echo $oPhone; ?>">
<span class="error" style="color: red; font-size: 0.8em;"><?php echo $contactErr;?></span><br><br>

<label>Address:</label><br>
<textarea name="address" cols="50" rows="5" placeholder="<?php echo $oAddress; ?>"></textarea>
<span class="error" style="color: red; font-size: 0.8em;"><?php echo $addressErr;?></span><br><br>

<label>Notes:</label><br>
<textarea name="notes" cols="50" rows="5" placeholder="<?php echo $oNotes; ?>"></textarea>
<span class="error" style="color: red; font-size: 0.8em;"><?php echo $notesErr;?></span><br><br>

<input class="button" type="submit" name="submitButton" value="Edit">
<input class="button" type="button" name="cancel" value="Cancel" onClick="window.location='landing.php';" />
</form>
</div>
</blockquote>
</body>
</html>