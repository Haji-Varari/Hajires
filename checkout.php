<html>
<body style="font-family:Arial; margin: 0 auto; background-color: #f2f2f2;">
<header>
<blockquote>
	<img src="image/HajiRestaurantLogo.jpeg">
	<input class="hi" style="float: right; margin: 2%;" type="button" name="cancel" value="Home" onClick="window.location='home.php';" />
</blockquote>
</header>
<?php
session_start();

if(isset($_SESSION['id'])){
	$servername = "localhost";
	$username = "root";
	$password = "";

	$conn = new mysqli($servername, $username, $password); 

	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	} 

	$sql = "USE haji_restaurant";
	$conn->query($sql);

	$sql = "SELECT CustomerID from customer ";
	$result = $conn->query($sql);
	while($row = $result->fetch_assoc()){
		$cID = $row['CustomerID'];
	}

	$sql = "UPDATE cart SET CustomerID = ".$cID."";
	$conn->query($sql);

	$sql = "SELECT * FROM cart";
	$result = $conn->query($sql);
	while($row = $result->fetch_assoc()){
		$sql = "INSERT INTO `order`(CustomerID, FoodID, DatePurchase, Quantity, TotalPrice, Status) 
		VALUES(".$row['CustomerID'].", '".$row['FoodID']
		."', CURRENT_TIME, ".$row['Quantity'].", ".$row['TotalPrice'].", 'N')";
		$conn->query($sql);
	}
	$sql = "DELETE FROM cart";
	$conn->query($sql);

	$sql = "SELECT customer.CustomerName, customer.CustomerID, customer.CustomerAddress, customer.CustomerPhone, food.FoodName, food.Price, food.Image, `order`.`DatePurchase`, `order`.`Quantity`, `order`.`TotalPrice`
		FROM customer, food, `order`
		WHERE `order`.`CustomerID` = customer.CustomerID AND `order`.`FoodID` = food.FoodID AND `order`.`Status` = 'N' AND `order`.`CustomerID` = ".$cID."";
	$result = $conn->query($sql);
	echo '<div class="container">';
	echo '<blockquote>';
?>
<input class="button" style="float: right;" type="button" name="cancel" value="Continue Shopping" onClick="window.location='home.php';" />
<?php
	echo '<h2 style="color: #000; text-align: left;">Order Successful</h2>';
	echo "<table>";
	echo "<tr><th colspan=\"4\"  style='text-align: center;'>Order Summary</th>";
	echo "<th></th></tr>";
	$row = $result->fetch_assoc();
	echo "<tr><td>Name: </td><td colSpan=\"4\" style='text-align: right;' >".$row['CustomerName']."</td></tr>";
	echo "<tr><td>Mobile Number: </td><td colspan=\"4\" style='text-align: right;' >".$row['CustomerPhone']."</td></tr>";
	echo "<tr><td>Address: </td><td colspan=\"4\" style='text-align: right;' >".$row['CustomerAddress']."</td></tr>";
	echo "<tr><td>Date: </td><td colspan=\"4\" style='text-align: right;'>".$row['DatePurchase']."</td></tr>";
	echo "</blockquote>";

	$sql = "SELECT customer.CustomerName, customer.CustomerID, customer.CustomerAddress,  customer.CustomerPhone, food.FoodName, food.Price, food.Image, `order`.`DatePurchase`, `order`.`Quantity`, `order`.`TotalPrice`
		FROM customer, food, `order`
		WHERE `order`.`CustomerID` = customer.CustomerID AND `order`.`FoodID` = food.FoodID AND `order`.`Status` = 'N' AND `order`.`CustomerID` = ".$cID."";
	$result = $conn->query($sql);
	$total = 0;
	
	echo "<tr  style='background-color: #000;height:3px'><td colspan=\"5\"></td></tr>";
	echo "<tr  style='background-color: #fff;'><td colspan=\"2\">Item Name</td> <td  style='text-align: center;'>Quantity</td> <td style='text-align: center;'>Per item price</td> <td style='text-align: right;'>Item Total</td> <td></td></tr>";
	while($row = $result->fetch_assoc()){
		$itemTotal=$row['Quantity']*$row['Price'];
		echo "<tr>";
		echo "<td colspan=\"2\"> ".$row['FoodName']."</td>";
		echo "<td style='text-align: center;'> ".$row['Quantity']."</td>";
		echo "<td style='text-align: center;'> ".$row['Price']."</td>";
		echo "<td style='text-align: right;'> ".$itemTotal."</td>";

    	echo "</td></tr>";
    	$total += $row['TotalPrice'];
	}
	echo "<tr  style='background-color: #000;height:3px'><td colspan=\"5\"></td></tr>";

	echo "<tr><td colspan=\"4\">Total Price:</td><td style='text-align: right;colspan=\"4\";background-color: #ccc;'';> <b>Rs.".$total."</b></td></tr>";
	echo "</table>";
	echo "</div>";

	$sql = "UPDATE `order` SET Status = 'y' WHERE CustomerID = ".$cID."";
	$conn->query($sql);
}

$nameErr = $addressErr = $icErr = $contactErr = "";
$name  = $address = $ic = $contact = "";
$cID;

if(isset($_POST['submitButton'])){
	if (empty($_POST["name"])) {
		$nameErr = "Please enter your name";
	}else{
		if (!preg_match("/^[a-zA-Z ]*$/", $name)){
			$nameErr = "Only letters and white space allowed";
			$name = "";
		}else{
			$name = $_POST['name'];
			if (empty($_POST["ic"])){
				$icErr = "Please enter your IC number";
			}else{
				if(!preg_match("/^[0-9 -]*$/", $ic)){
					$icErr = "Please enter a valid IC number";
					$ic = "";
				}else{
					$ic = $_POST['ic'];
					if (empty($_POST["email"])){
						$emailErr = "Please enter your email address";
					}else{
						if (filter_var($email, FILTER_VALIDATE_EMAIL)){
							$emailErr = "Invalid email format";
							$email = "";
						}else{
							$email = $_POST['email'];
							if (empty($_POST["contact"])){
								$contactErr = "Please enter your phone number";
							}else{
								if(!preg_match("/^[0-9 -]*$/", $contact)){
									$contactErr = "Please enter a valid phone number";
									$contact = "";
								}else{
									$contact = $_POST['contact'];
									if (empty($_POST["gender"])){
										$genderErr = "* Gender is required!";
										$gender = "";
									}else{
										$gender = $_POST['gender'];
										if (empty($_POST["address"])){
											$addressErr = "Please enter your address";
											$address = "";
										}else{
											$address = $_POST['address'];

											$servername = "localhost";
											$username = "root";
											$password = "";

											$conn = new mysqli($servername, $username, $password); 

											if ($conn->connect_error) {
											    die("Connection failed: " . $conn->connect_error);
											} 

											$sql = "USE haji_restaurant";
											$conn->query($sql);

											$sql = "INSERT INTO customer(CustomerName, CustomerPhone, CustomerIC, CustomerAddress, CustomerGender) 
											VALUES('".$name."', '".$contact."', '".$ic."',  '".$address."')";
											$conn->query($sql);
 
											$sql = "SELECT CustomerID from customer WHERE CustomerName = '".$name."' AND CustomerIC = '".$ic."'";
											$result = $conn->query($sql);
											while($row = $result->fetch_assoc()){
												$cID = $row['CustomerID'];
											}

											$sql = "UPDATE cart SET CustomerID = ".$cID." WHERE 1";
											$conn->query($sql);

											$sql = "SELECT * FROM cart";
											$result = $conn->query($sql);
											while($row = $result->fetch_assoc()){
												$sql = "INSERT INTO `order`(CustomerID, FoodID, DatePurchase, Quantity, TotalPrice, Status) 
												VALUES(".$row['CustomerID'].", '".$row['FoodID']
												."', CURRENT_TIME, ".$row['Quantity'].", ".$row['TotalPrice'].", 'N')";
												$conn->query($sql);
											}
											$sql = "DELETE FROM cart";
											$conn->query($sql);
										}
									}
								}
							}
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
<style> 
header {
	background-color: rgb(0,51,102);
	width: 100%;
}
header img {
	margin: 1%;
}
header .hi{
    background-color: #fff;
    border: none;
    border-radius: 20px;
    text-align: center;
    transition-duration: 0.5s; 
    padding: 8px 30px;
    cursor: pointer;
    color: #000;
    margin-top: 15%;
}
header .hi:hover{
    background-color: #ccc;
}
form{
	margin-top: 1%;
	float: left;
	width: 40%;
	color: #000;
}
input[type=text] {
	padding: 5px;
    border-radius: 3px;
    box-sizing: border-box;
    border: 2px solid #ccc;
    transition: 0.5s;
    outline: none;
}
input[type=text]:focus {
    border: 2px solid rgb(0,51,102);
}
textarea {
	outline: none;
	border: 2px solid #ccc;
}
textarea:focus {
	border: 2px solid rgb(0,51,102);
}
.button{
    background-color: rgb(0,51,102);
    border: none;
    border-radius: 20px;
    text-align: center;
    transition-duration: 0.5s; 
    padding: 8px 30px;
    cursor: pointer;
    color: #fff;
}
.button:hover {
    background-color: rgb(102,255,255);
    color: #000;
}
table {
    border-collapse: collapse;
    width: 100%;
    float: center;
}
th, td {
    padding: 8px;
}
tr{background-color: #fff;}

th {
    background-color: rgb(0,51,102);
    color: white;
}
.container {
	width: 50%;
    border-radius: 5px;
    background-color: #f2f2f2;
    padding: 20px;
    margin: 0 auto;
}
</style>
<blockquote>
<?php
if(!isset($_SESSION['id'])){
	echo "<form method='post'  action=''>";

	echo 'Name:<br><input type="text" name="name" placeholder="Full Name">';
	echo '<span class="error" style="color: red; font-size: 0.8em;"><?php echo $nameErr;?></span><br><br>';	

	echo 'Mobile Number:<br><input type="text" name="contact" placeholder="0123456789">';
	echo '<span class="error" style="color: red; font-size: 0.8em;"><?php echo $contactErr;?></span><br><br>';

	echo '<label>Address:</label><br>';
	   echo '<textarea name="address" cols="30" rows="5" placeholder="Address"></textarea>';
	   echo '<span class="error" style="color: red; font-size: 0.8em;"><?php echo $addressErr;?></span><br><br>';
?>
<input class="button" type="button" name="cancel" value="Cancel" onClick="window.location='home.php';" />
<?php
	echo '<input class="button" type="submit" name="submitButton" value="CHECKOUT">';
	echo '</form><br><br>';
}

if(isset($_POST['submitButton'])){
	$servername = "localhost";
	$username = "root";
	$password = "";

	$conn = new mysqli($servername, $username, $password); 

	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	} 

	$sql = "USE haji_restaurant";
	$conn->query($sql);

	$sql = "SELECT customer.CustomerName, customer.CustomerIC, customer.CustomerAddress,  customer.CustomerPhone, food.FoodName, food.Price, food.Image, `order`.`DatePurchase`, `order`.`Quantity`, `order`.`TotalPrice`
		FROM customer, food, `order`
		WHERE `order`.`CustomerID` = customer.CustomerID AND `order`.`FoodID` = food.FoodID AND `order`.`Status` = 'N' AND `order`.`CustomerID` = ".$cID."";
	$result = $conn->query($sql);

	echo '<table style="width: 40%">';
	echo "<tr><th>Order Summary</th>";
	echo "<th></th></tr>";
	$row = $result->fetch_assoc();
	echo "<tr><td>Name: </td><td style='text-align:right;'>".$row['CustomerName']."</td></tr>";
	echo "<tr><td>No.Number: </td><td>".$row['CustomerIC']."</td></tr>";
	echo "<tr><td>Mobile Number: </td><td>".$row['CustomerPhone']."</td></tr>";
	echo "<tr><td>Address: </td><td>".$row['CustomerAddress']."</td></tr>";
	echo "<tr><td>Date: </td><td>".$row['DatePurchase']."</td></tr>";

	$sql = "SELECT customer.CustomerName, customer.CustomerIC,  customer.CustomerAddress,  customer.CustomerPhone, food.FoodName, food.Price, food.Image, `order`.`DatePurchase`, `order`.`Quantity`, `order`.`TotalPrice`
		FROM customer, food, `order`
		WHERE `order`.`CustomerID` = customer.CustomerID AND `order`.`FoodID` = food.FoodID AND `order`.`Status` = 'N' AND `order`.`CustomerID` = ".$cID."";
	$result = $conn->query($sql);
	$total = 0;
	while($row = $result->fetch_assoc()){
		echo "<tr><td style='border-top: 2px solid #ccc;'>";
		echo '<img src="'.$row["Image"].'"width="20%"></td><td style="border-top: 2px solid #ccc;">';
    	echo $row['FoodName']."<br>Rs".$row['Price']."<br>";
    	echo "Quantity: ".$row['Quantity']."<br>";
    	echo "</td></tr>";
    	$total += $row['TotalPrice'];
	}
	echo "<tr><td style='background-color: #ccc;'></td><td style='text-align: right;colspan=\"4\";background-color: #ccc;'>Total Price: <b>Rs.".$total."</b></td></tr>";
	echo "</table>";

	$sql = "UPDATE `order` SET Status = 'y' WHERE CustomerID = ".$cID."";
	$conn->query($sql);
}
?>
</blockquote>
</body>
</html>