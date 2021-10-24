<?php 
session_start();

	include("connection.php");
	include("functions.php");
    include("function2.php");

	$user_data = check_login($con);
    $orders_data= getOrders($con);
    
    if($_SERVER['REQUEST_METHOD'] == "POST")
	{
		$idComanda = $_POST['idComanda'];

		$querry = " Select * from orders where idOrder = $idComanda";
        $result = mysqli_query($con, $querry);
        $order_data = mysqli_fetch_assoc($result);
        $_SESSION['Status'] = $order_data['Status'];
        $_SESSION['idComanda'] = $idComanda;
     


      // header("Location: Comenzi.php ");
    }

?>
<html lang="en" ng-app="main">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="./Styles/ComenziStyle.css">
    <title>BikeAttack</title>
    <style>
        table {
        position: relative;
        top:70%;
        font-family: arial, sans-serif;
        border-collapse: collapse;
        width: 100%;
        }

        td, th {
        border: 1px solid #dddddd;
        text-align: left;
        padding: 8px;
        }

        tr:nth-child(even) {
        background-color: #dddddd;
        }
    </style>
  </head>
  <body>
  <ul id="menu">
  <ul>
        <center>
    <li><a href="AdaugareProduse.php">Adaugare</a></li>
    <li><a href="Editare.php">Editare</a></li>		
    <li><a>Comenzi</a></li>
	<?php
	if($user_data['ID']==0)
	 echo '<li><a href="Login.php">Login</a></li>';
	 else echo '<li><a href="logout.php">Logout</a></li>';
	?>
    </center>
   </ul>
</ul>
  </table>
  <div class="center">
<h1>Cauta Comanda</h1>
  <form method="post" enctype="multipart/form-data">
  <div class="txt_field">
            <input name="idComanda" type="text" required>
            <span></span>
            <label>ID Comanda</label>
          </div>
    <input type="submit" name="submit" value="Search ID">
  </form>
</div>
<div class="center">
<h1>Status comanda</h1>
  <form action="UpdateComanda.php" method="post" enctype="multipart/form-data">
        <div class="txt_field">      
            <a>ID :<?php echo $_SESSION['idComanda']; ?></a>
        </div>
        <div class="txt_field">
          <input name="idComanda" type="hidden" value="<?php echo $_SESSION['idComanda'];?>">
          <input name="Status" type="text" required value="<?php  echo $_SESSION["Status"]; ?>">
          <span></span>
          <label>Status</label>
        </div>
    <input type="submit" name="submit" value="Update">
  </form>
</div>
<table>
  <tr>
    <th>Id</th>
    <th>Total</th>
    <th>Adresa</th>
    <th>Telefon</th>
    <th>Data</th>
    <th>Status</th>
    <th>Detalii</th>
  </tr>
  <?php
    if ($orders_data->num_rows > 0) {
        // output data of each row
        while($row = $orders_data->fetch_assoc()) {
        //  echo 'ID: ' .$row["idProduct"] ;
        if(empty($row['Status'])) $row['Status']="In procesare";
        echo '
        <tr>
        <td>'.$row['idOrder'].'</td>
        <td>'.$row['Pret'].' lei</td>
        <td>'.$row['Adresa'].'</td>
        <td>'.$row['nrTelefon'].'</td>
        <td>'.$row['Data'].'</td>
        <td>'.$row['Status'].'</td>
        <td>'.$row['Detalii'].'</td>
        </tr>
        ';
        }
    }
    ?>
    </table>
  </body>
</html>
