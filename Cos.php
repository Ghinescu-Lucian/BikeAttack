<?php
session_start();
include("connection.php");
include("functions.php");
$user_data=check_login($con);

include("function2.php");
$products_data = getProducts($con);

if (isset($_POST['remove'])){
    if ($_GET['action'] == 'remove'){
        foreach ($_SESSION['shopping_cart'] as $key => $value){
            if($value["item_id"] == $_GET['id']){
                unset($_SESSION['shopping_cart'][$key]);
                echo "<script>alert('Produsul a fost sters!')</script>";
                echo "<script>window.location = 'Cos.php'</script>";
            }
        }
    }
  }

if (isset($_POST['add'])){
    echo "aici";
   // if ($_GET['action'] == 'change'){
        echo "aici2";
        foreach ($_SESSION['shopping_cart'] as $key => $value){
            if($value["item_id"] == $_GET['id']){
                $maxQ=getQuantity($con,$_GET['id']);
                if($maxQ["Cantitate"] > $value["item_quantity"]){
                    $_SESSION["shopping_cart"][$key]=array(
                        'item_id'        => $value["item_id"],
                        'item_name'      => $value["item_name"],
                        'item_price'     => $value["item_price"],
                        'item_img'       => $value["item_img"],
                        'item_quantity'  =>  $value["item_quantity"] + 1
                    );
                }
                else{
                    echo "<script>alert('Cantitatea maxim disponibila!')</script>";
                    echo "<script>window.location = 'Cos.php'</script>";
                } 
                }
            }
       // }
    }
    if (isset($_POST['sub'])){
        echo "aici";
       // if ($_GET['action'] == 'change'){
            echo "aici2";
            foreach ($_SESSION['shopping_cart'] as $key => $value){
                if($value["item_id"] == $_GET['id']){
                    if($value["item_quantity"] > 1){
                        $_SESSION["shopping_cart"][$key]=array(
                            'item_id'        => $value["item_id"],
                            'item_name'      => $value["item_name"],
                            'item_price'     => $value["item_price"],
                            'item_img'       => $value["item_img"],
                            'item_quantity'  =>  $value["item_quantity"] - 1
                        );
                    }
                    else{
                        echo "<script>alert('Puteti sterge produsul!')</script>";
                        echo "<script>window.location = 'Cos.php'</script>";
                    } 
                    }
                }
           // }
        }
    

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="./Styles/BicicleteStyle.css">
    <title>BikeAttack</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
<!-- Bootstrap CDN -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<link rel="stylesheet" href="./Styles/cosStyle.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  </head>
  <body>
<ul id="menu">
  <ul>
        <center>
    <li><a href="Index.php">Acasa</a></li>
    <li><a href="Biciclete.php">Biciclete</a></li>
    <li><a href="#">Cosul tau</a></li>
    <?php
	if($user_data['ID']==0)
	 echo '<li><a href="Login.php">Login</a></li>';
	 else echo '<li><a href="logout.php">Logout</a></li>';
	?>
    </center>
   </ul>
</ul>

<h3>Detalii comanda</h3>

<div class="container-fluid">
    <div class="row px-5">
        <div class="col-md-7">
            <div class="shopping-cart">
                <h6>My Cart</h6>
                <hr>

                <?php

                $total = 0;
                    if (isset($_SESSION['shopping_cart'])){
                        $product_id = array_column($_SESSION['shopping_cart'], 'idProduct');
                        foreach($_SESSION["shopping_cart"] as $keys => $values)
                        {
                            cartElement($values['item_img'], $values['item_name'],$values['item_price'], $values['item_id'], $values['item_quantity']);
                            $total = $total + (int)$values['item_price'] * (int)$values['item_quantity'];
                        }
                    }else{
                        echo "<h5>Cart is Empty</h5>";
                    }

                ?>

            </div>
        </div>
        <div class="col-md-4 offset-md-1 border rounded mt-5 bg-white h-25">

            <div class="pt-4">
                <h6>Detalii pret</h6>
                <hr>
                <div class="row price-details">
                    <div class="col-md-6">
                        <?php
                            if (isset($_SESSION['shopping_cart'])){
                                $count  = count($_SESSION['shopping_cart']);
                                echo "<h6>Pret  ($count produse)</h6>";
                            }else{
                                echo "<h6>Pret (0 produse)</h6>";
                            }
                        ?>
                        <h6>Transport</h6>
                        <hr>
                        <h6>Total de plata</h6>
                    </div>
                    <div class="col-md-6">
                        <h6><?php echo $total; ?> lei</h6>
                        <h6 class="text-success">FREE</h6>
                        <hr>
                        <h6><?php
                            echo $total;
                            ?> lei</h6>
                    </div>
                    <a id="OrderButton"  href="PlasareComanda.php">Plaseaza comanda</a>
                </div>
            </div>

        </div>
    </div>
</div>
<h3><a href="IstoricComenzi.php">Istoric Comenzi</a></h3>



<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>