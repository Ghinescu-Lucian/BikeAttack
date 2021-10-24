<?php 

session_start();

	include("connection.php");
	include("functions.php");


	if($_SERVER['REQUEST_METHOD'] == "POST")
	{
		//something was posted
		$Username = $_POST['Username'];
		$Password = $_POST['Password'];

		if(!empty($Username) && !empty($Password) && !is_numeric($Username))
		{

			//read from database
			$query = "select * from users where Username = '$Username' limit 1";
			$result = mysqli_query($con, $query);

			if($result)
			{
				if($result && mysqli_num_rows($result) > 0)
				{

					$user_data = mysqli_fetch_assoc($result);
					
					if($user_data['Password'] === $Password)
					{

						$_SESSION['ID'] = $user_data['ID'];
						if(strcmp($user_data['Username'],"Admin")==0)
							header("Location:AdaugareProduse.php");
						else
						header("Location:Index.php");
						die;
					}
				}
			}
			
			echo "wrong username or password!";
		}else
		{
			echo "wrong username or password!";
		}
	}

?>
<!DOCTYPE html>
<!-- Coding By CodingNepal - youtube.com/codingnepal -->
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>BikeAttack</title>
    <link rel="stylesheet" href="./Styles/LoginStyle.css">
  </head>
  <body>
    <img class="logo" src="./Imagini/LogoPng.png">
    <div class="center">
      <h1>Login</h1>
      <form method="POST">
        <div class="txt_field">
          <input  type="text" name="Username"  required>
          <span></span>
          <label>Username</label>
        </div>
        <div class="txt_field">
          <input  type="password"  name="Password" required>
          <span></span>
          <label>Password</label>
        </div>
        <input id="LoginButton" type="submit" value="Login">
        <div class="signup_link">
          Not a member? <a href="SignUp.php">Signup</a>
        </div>
      </form>
    </div>
  
  </body>
</html>
