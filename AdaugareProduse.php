<?php 
session_start();

	include("connection.php");
	include("functions.php");
  
  $user_data = check_login($con);
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="./Styles/AdaugareProduseStyle.css">
    <title>BikeAttack</title>
	<style>
		#errorMs {
			color: #a00;
		}
		.gallery img{
            width: 300px;
		}
	</style>
</head>
<body>
<ul id="menu">
  <ul>
        <center>
    <li><a href="AdaugareProduse.php">Adaugare</a></li>
    <li><a href="Editare.php">Editare</a></li>		
    <li><a href="Comenzi.php">Comenzi</a></li>
	<?php
	if($user_data['ID']==0)
	 echo '<li><a href="Login.php">Login</a></li>';
	 else echo '<li><a href="logout.php">Logout</a></li>';
	?>
    </center>
   </ul>
</ul>
<div class="title">
 <h1>Hello, <?php echo $user_data['Username']; ?> !</h1>
</div>
 <div class="center">
      <h1> Adaugare Produse</h1>
  <form action="Upload.php" method="post" enctype="multipart/form-data">
    Select Image File to Upload:
    <div class="txt_field">
            <input name="Nume" type="text" required>
            <span></span>
            <label>Nume</label>
          </div>
        <div class="txt_field">
          <input name="Cantitate" type="text" required>
          <span></span>
          <label>Cantitate</label>
        </div>
        <div class="txt_field">
          <input name="Pret" type="text" required>
          <span></span>
          <label>Pret</label>
        </div>
        <div class="txt_field">
            <span></span>
            <input> <textarea name="Descriere" rows=4 cols=45>Bicicleta</textarea>
            <label>Descriere</label>
          </div>
    <input type="file" name="file">
    <input type="submit" name="submit" value="Upload">
  </form>
</div>
</body>
</html>