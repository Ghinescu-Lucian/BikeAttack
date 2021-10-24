<?php 
session_start();

	include("connection.php");
	include("functions.php");


	if($_SERVER['REQUEST_METHOD'] == "POST")
	{
		//something was posted
		$Username = $_POST['Username'];
		$Password = $_POST['Password'];
    $PasswordC = $_POST['PasswordC'];
    $Email = $_POST['Email'];
    $Name = $_POST['Name'];
  
    if (strcmp($Password,$PasswordC) != 0) echo "Password dosen't mach!";
    else if(strcmp($Username,"Admin")==0) echo "Username invalid!";
		else if(!empty($Username) && !empty($Password) && !is_numeric($Username) && !empty($Email) && !empty($Name))
		{

			//save to database
		//	$user_id = random_num(20);
			$query = "insert into users (Username,Password,Nume,Email) values ('$Username','$Password','$Name','$Email')";

			$result = mysqli_query($con, $query);
      if($result) echo "good";
      else echo "Bad";
		  header("Location: Login.php");
			die;
		}else
		{
			echo "Please enter some valid information!";
		}
	}
?>

<!DOCTYPE html>
<!-- Coding By CodingNepal - youtube.com/codingnepal -->
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>BikeAttack</title>
    <link rel="stylesheet" href="./Styles/SignUpStyle.css">
  </head>
  <body>
    <img class="logo" src="./Imagini/LogoPng.png">
    <div class="center">
      <h1>SignUp</h1>
      <form method="post">
        <div class="txt_field">
            <input id="name"  name="Name" type="text" required>
            <span></span>
            <label>Name<s/label>
          </div>
        <div class="txt_field">
            <input id="email" name="Email" type="text" required>
            <span></span>
            <label>Email</label>
          </div>
        <div class="txt_field">
          <input id="username" name="Username" type="text" required>
          <span></span>
          <label>Username</label>
        </div>
        <div class="txt_field">
          <input id="pwd" name="Password" type="password" required>
          <span></span>
          <label>Password</label>
        </div>
        <div class="txt_field">
            <input id="pwdC"  name="PasswordC" type="password" required>
            <span></span>
           <label>Confirm password</label>
          </div>
        <input id="signUp" type="submit" value="SignUp" >
        <div class="signup_link">
            <br> <a href="Index.php">Home</a>
            <br>
        </div>
      </form>
    </div>

  </body>
</html>
