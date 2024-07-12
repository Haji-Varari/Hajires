<html>
<meta http-equiv="Content-Type"'.' content="text/html; charset=utf8"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="style.css">
<body>
<?php
session_start();
	if(isset($_POST['ac'])){
		$servername = "localhost";
		$username = "root";
		$password = "";

		$conn = new mysqli($servername, $username, $password);

		if ($conn->connect_error) {
		    die("Connection failed: " . $conn->connect_error);
		} 

		$sql = "USE haji_restaurant";
		$conn->query($sql);

		$sql = "SELECT * FROM food WHERE FoodID = '".$_POST['ac']."'";
		$result = $conn->query($sql);

		while($row = $result->fetch_assoc()){
			$foodID = $row['FoodID'];
			$quantity = $_POST['quantity'];
			$price = $row['Price'];
		}

		$sql = "INSERT INTO cart(FoodID, Quantity, Price, TotalPrice) VALUES('".$foodID."', ".$quantity.", ".$price.", Price * Quantity)";
		$conn->query($sql);
	}

	if(isset($_POST['delc'])){
		$servername = "localhost";
		$username = "root";
		$password = "";

		$conn = new mysqli($servername, $username, $password);

		if ($conn->connect_error) {
		    die("Connection failed: " . $conn->connect_error);
		} 

		$sql = "USE haji_restaurant";
		$conn->query($sql);

		$sql = "DELETE FROM cart";
		$conn->query($sql);
	}

	$servername = "localhost";
	$username = "root";
	$password = "";

	$conn = new mysqli($servername, $username, $password);

	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	} 

	$sql = "USE haji_restaurant";
	$conn->query($sql);	

	$sql = "SELECT * FROM food";
	$result = $conn->query($sql);
?>	

<?php
if(isset($_SESSION['id'])){
	echo '<header>';
	echo '<blockquote>';
	echo '<a href="index.php"><img src="image/HajiRestaurantLogo.jpeg"></a>';
	echo '<form class="hf" action="logout.php"><input class="hi" type="submit" name="submitButton" value="Logout"></form>';
	echo '<form class="hf" action="edituser.php"><input class="hi" type="submit" name="submitButton" value="Edit Profile"></form>';
	echo '</blockquote>';
	echo '</header>';
}

if(!isset($_SESSION['id'])){
	echo '<header>';
	echo '<blockquote>';
	echo '<a href="index.php"><img src="image/HajiRestaurantLogo.jpeg", height="175px", width="200px"></a>';
	echo '<form class="hf" action="Register.php"><input class="hi" type="submit" name="submitButton" value="Register"></form>';
	echo '<form class="hf" action="login.php"><input class="hi" type="submit" name="submitButton" value="Login"></form>';
	echo '</blockquote>';
	echo '</header>';
}
echo '<blockquote>';
	echo "<table id='myTable' style='width:60%; float:center'>";
	echo "<tr>";
    while($row = $result->fetch_assoc()) {
	    echo "<td>";
	    echo "<table>";
	   	echo '<tr><td>'.'<img src="'.$row["Image"].'"width="65%">'.'</td></tr><tr><td style="padding: 5px;">Item Name: '.$row["FoodName"].'</td></tr><tr><td style="padding: 5px;">Calories: '.$row["Calories"].'</td></tr><tr><td style="padding: 5px;">Rs.'.$row["Price"].'</td></tr><tr><td style="padding: 5px;">
	   	<form action="" method="post">
	   	Quantity: <input type="number" value="1" name="quantity" style="width: 20%"/><br>
	   	<input type="hidden" value="'.$row['FoodID'].'" name="ac"/>
	   	<input class="button" type="submit" value="Add to Cart"/>
	   	</form></td></tr>';
	   	echo "</table>";
	   	echo "</td>";
    }
    echo "</tr>";
    echo "</table>";

	$sql = "SELECT food.FoodName, Food.Image, cart.Price, cart.Quantity, cart.TotalPrice FROM Food,cart WHERE food.FoodID = cart.FoodID;";
	$result = $conn->query($sql);

    echo "<table style='width:20%; float:right;'>";
    echo "<th style='text-align:left;'><i class='fa fa-shopping-cart' style='font-size:24px'></i> Cart <form style='float:right;' action='' method='post'><input type='hidden' name='delc'/><input class='cbtn' type='submit' value='Empty Cart'></form></th>";
    $total = 0;
    while($row = $result->fetch_assoc()){
    	echo "<tr><td>";
    	echo '<img src="'.$row["Image"].'"width="20%"><br>';
    	echo $row['BookTitle']."<br>Rs.".$row['Price']."<br>";
    	echo "Quantity: ".$row['Quantity']."<br>";
    	echo "Total Price: Rs.".$row['TotalPrice']."</td></tr>";
    	$total += $row['TotalPrice'];
    }
    echo "<tr><td style='text-align: right;background-color: #f2f2f2;''>";
    echo "Total: <b>Rs.".$total."</b><center><form action='checkout.php' method='post'><input class='button' type='submit' name='checkout' value='CHECKOUT'></form></center>";
    echo "</td></tr>";
	echo "</table>";
	echo '</blockquote>';
?>
</body>
</html>