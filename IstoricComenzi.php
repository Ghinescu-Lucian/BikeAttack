<?php 
session_start();

	include("connection.php");
	include("functions.php");
    include("function2.php");

	$user_data = check_login($con);
    $orders_data= getOrdersUser($con,$user_data["Username"]);

?>
<html lang="en" ng-app="main">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="./Styles/MenuStyle.css">
    <title>BikeAttack</title>
    <style>
        table {
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
  <h2><a href="Cos.php">Inapoi</a></h2>
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
