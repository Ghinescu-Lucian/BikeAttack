<?php 

session_start();

	include("connection.php");
	include("functions.php");
  $user_data = check_login($con);

	if($_SERVER['REQUEST_METHOD'] == "POST")
	{
		//something was posted
    $Nume = $_POST['Nume'];
    $Prenume = $_POST['Prenume'];
    $Adresa = $_POST['Adresa'];
    $Telefon = $_POST['Telefon'];
    $Data = date("Y/m/d");
    $Time = date("h:i");
    $Data = $Data .' '. $Time;
    $Detalii=" ";
    $total = 0;
    $Username =$user_data['Username'];
    echo $Data;
    if (isset($_SESSION['shopping_cart'])){
        $product_id = array_column($_SESSION['shopping_cart'], 'idProduct');
        foreach($_SESSION["shopping_cart"] as $keys => $values)
        {
            $Detalii = $Detalii." ".$values['item_name']." x ".$values['item_quantity'];
            $total = $total + (int)$values['item_price'] * (int)$values['item_quantity'];
           // unset($_SESSION['shopping_cart'][$key]);    
        }
  
      }
    if(!empty($Nume) && !empty($Prenume) && !empty($Adresa) && !empty($Telefon))
		{
      $Nume = $Nume ." ". $Prenume;

			$query = "insert into orders (Username, Nume, Pret, Data, nrTelefon, Adresa, Detalii, modPlata) values  ('$Username','$Nume','$total','$Data','$Telefon','$Adresa','$Detalii','Ramburs')";

			$result = mysqli_query($con, $query);

			if($result)
			{
        foreach ($_SESSION['shopping_cart'] as $key => $value)
          unset($_SESSION['shopping_cart'][$key]);
        echo "<script>alert('Comanda plasata cu succes!')</script>";
        echo "<script>window.location = 'Index.php'</script>";    
			}
			else{
        echo "<script>alert('Eroare baza de date!')</script>";
        echo "<script>window.location = 'Index.php'</script>";

      }
		}else
		{
      echo "<script>alert('Completati toate campurile!')</script>";
      echo "<script>window.location = 'PlasareComanda.php'</script>";
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
      <h1>Informatii livrare</h1>
      <form method="POST">
      <div class="txt_field">
          <input  type="text"  name="Nume" required>
          <span></span>
          <label>Nume</label>
        </div>
        <div class="txt_field">
          <input  type="text"  name="Prenume" required>
          <span></span>
          <label>Prenume</label>
        </div>
        <div class="txt_field">
          <input  type="text" name="Adresa"  required>
          <span></span>
          <label>Adresa</label>
        </div>
        <div class="txt_field">
          <input  type="text"  name="Telefon" required>
          <span></span>
          <label>Numar telefon</label>
        </div>
        <input id="LoginButton" type="submit" value="Plaseaza Comanda">
        <div class="signup_link">
          <br> <a href="Index.php">Home</a>
        </div>
      </form>
    </div>
  </body>
</html>
