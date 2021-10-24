<?php
include("connection.php");
include("functions.php");
session_start();
$user_data=check_login($con);

include("function2.php");
$products_data = getProducts($con);

if(isset($_POST["keyword"])){
  $keyword= $_POST["keyword"];
  $tmp= getProductsKey($con,$keyword);
  if($tmp)
    $products_data=$tmp;
  else
    echo "<script>alert('Cuvant inexistent!')</script>";  
}

if(isset($_POST["add_to_cart"]))
{
  $one=1;
   if(isset($_SESSION["shopping_cart"]))
  {
         $item_array_id = array_column($_SESSION["shopping_cart"],"item_id");
         if(!in_array($_POST["hidden_idProduct"], $item_array_id))
         {
              $count = count($_SESSION["shopping_cart"]);
              $item_array = array(
                'item_id'        => $_POST["hidden_idProduct"],
                'item_name'      => $_POST["hidden_name"],
                'item_price'     => $_POST["hidden_price"],
                'item_img'       => $_POST["hidden_img"],
                'item_quantity'  => $one
      
              );
              $_SESSION["shopping_cart"][$count] = $item_array;

         }
         else{
              echo '<script>alert("Produsul a fost adaugat deja in cos!")</script>';
             // echo '<script>window.location="Biciclete.php"</script>';

            }
  }
  else{
    $item_array = array(
          'item_id'        => $_POST["hidden_idProduct"],
          'item_name'      => $_POST["hidden_name"],
          'item_price'     => $_POST["hidden_price"],
          'item_img'       => $_POST["hidden_img"],
          'item_quantity'  => $one

        );
    $_SESSION["shopping_cart"][0]=$item_array;   
  }
}


?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="./Styles/BicicleteStyle.css">
    <title>BikeAttack</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  </head>
  <body>
<ul id="menu">
  <ul>
        <center>
    <li><a href="Index.php">Acasa</a></li>
    <li><a href="#">Biciclete</a></li>
    <li><a href="Cos.php">Cosul tau</a></li>
    <?php
	if($user_data['ID']==0)
	 echo '<li><a href="Login.php">Login</a></li>';
	 else echo '<li><a href="logout.php">Logout</a></li>';
	?>
    </center>
   </ul>
</ul>

<form method="POST">
<div class="wrapper">
      <div class="search-input">
        <a href="" target="_blank" hidden></a>
        <input type="text" name="keyword" placeholder="Cuvinte cheie">
        <div class="autocom-box">
          <!-- here list are inserted from javascript -->
        </div>
        <div class="icon"><button type="submit" class="fas fa-search"></button></div>
      </div>
</div>
</form>

   <div class="container">

<?php
    if ($products_data->num_rows > 0) {
        // output data of each row
        while($row = $products_data->fetch_assoc()) {
        //  echo 'ID: ' .$row["idProduct"] ;
          $res = getImage($row["idProduct"]);
             echo '
            <div class= "product">
            <div class="product-card">
              <h2 class="name">'. $row["Nume"]. '</h2>
              <span class="price">' . $row["Pret"].' lei</span>
              <a class="popup-btn">Detalii</a>
              <img src="./uploads/'.$res.'" class="product-img" alt="">
            </div>
            <div class="popup-view">
              <div class="popup-card">
                <a><i class="fas fa-times close-btn"></i></a>
                <div class="product-img">
                  <img src="./uploads/'.$res.'" alt="">
                </div>
                <div class="info">
                  <h2>'.$row["Nume"].'<br><span>ID: '.$row["idProduct"].'</span></h2>
                  <p>'.$row["Descriere"].'.</p>
                  <span class="price">'.$row["Pret"].' lei</span>
                <!--  <a href="#" class="add-cart-btn" >Add to Cart</a>-->
                <form method="POST" action="Biciclete.php?action=add&id='.$row["idProduct"].'">
                    <input type="hidden" name="hidden_name" value="'.$row["Nume"].'" />
                    <input type="hidden" name="hidden_price" value="'.$row["Pret"].'" />
                    <input type="hidden" name="hidden_idProduct" value="'.$row["idProduct"].'" />
                    <input type="hidden" name="hidden_img" value="'.$res.'" /> 
                    <input type="submit" name="add_to_cart" class="add-cart-btn" value="Adauga in cos"/>
                 </form>    
                </div>
              </div>
                
            </div>
          </div>  

            ';
        }
      }
      else
      echo ' <h1> Nu exista produse de acest tip! </h1> ';
?>
</div>
<script src="./Scripts/suggestions.js"></script> 
   <script src="./Scripts/SearchBoxScript.js"></script> 

  <script type="text/javascript">
  var popupViews = document.querySelectorAll('.popup-view');
  var popupBtns = document.querySelectorAll('.popup-btn');
  var closeBtns = document.querySelectorAll('.close-btn');

  //javascript for quick view button
  var popup = function(popupClick){
    popupViews[popupClick].classList.add('active');
  }

  popupBtns.forEach((popupBtn, i) => {
    popupBtn.addEventListener("click", () => {
      popup(i);
    });
  });
  //javascript for close button
  closeBtns.forEach((closeBtn) => {
    closeBtn.addEventListener("click", () => {
      popupViews.forEach((popupView) => {
        popupView.classList.remove('active');
      });
    });
  });
  </script>

</body>
</html>
