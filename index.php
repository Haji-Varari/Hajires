<html>
<link rel="stylesheet" href="style.css">
<body >
<blockquote>
<div class="container">
<center><h1>Login</h1></center>
<style>
body {font-family: Arial, Helvetica, sans-serif;background:  #f2f2f2;}
form {border: 3px solid #f2f2f2;}

input[type=text], input[type=password] {
  width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  box-sizing: border-box;
}

button {
  background-color: #04AA6D;
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  cursor: pointer;
  width: 100%;
}

button:hover {
  opacity: 0.8;
}


.imgcontainer {
  text-align: center;
  width: 100%;
  height: 20%
  margin: 24px 0 12px 0;
}

img.avatar {
  width: 15%;
  height: 10%
  border-radius: 50%;
}

.container {
  padding: 16px;
}

span.psw {
  float: right;
  padding-top: 16px;
}

@media screen and (max-width: 300px) {
  span.psw {
     display: block;
     float: none;
  }
  .cancelbtn {
     width: 100%;
  }
}
</style>



<form action="checklogin.php" method="post">
  <div class="imgcontainer" >
    <img src="image/HajiRestaurantLogo.jpeg" alt="Avatar" class="avatar">
  </div>

  <div class="container">
    <label for="username"><b>Username</b></label>
    <input type="text" placeholder="Enter Username" name="username" required>

    <label for="pwd"><b>Password</b></label>
    <input type="password" placeholder="Enter Password" name="pwd" required>
        
    <button type="submit">Login</button>
	 <button type="submit">Register</button>
  </div>
</form>

</div>
<blockquote>
<?php

?>


<?php
session_start();
if(isset($_GET['errcode'])){
  if($_GET['errcode']==1){
      echo '<span style="color: red;">Invalid username or password.</span>';
  }elseif($_GET['errcode']==2){
      echo '<span style="color: red;">Please login.</span>';
  }
}
?>	
</body>
</html>