<?php 
session_start();

	include("connection.php");
	include("functions.php");

    $user_data = check_login($con);
    include("function2.php");
    $result=NULL;
    if($_SERVER['REQUEST_METHOD'] == "POST")
	{
		//something was posted
		$idProduct = $_POST['idProduct'];

		$querry = " Select * from product where idProduct = $idProduct";
        $result = mysqli_query($con, $querry);
        $product_data = mysqli_fetch_assoc($result);
        $_SESSION['NumeProdus'] = $product_data['Nume'];
        $_SESSION['idProduct'] = $product_data['idProduct'];
        $_SESSION['Pret'] = $product_data['Pret'];
        $_SESSION['Cantitate'] = $product_data['Cantitate'];
        $_SESSION['Descriere'] = $product_data['Descriere'];



        header("Location: Editare.php ");
    }
    $products_data = getProducts($con);
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="./Styles/EditareStyle.css">
    <title>BikeAttack</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
<div class="center">
      <h1>Cauta Produs</h1>
  <form  method="post" enctype="multipart/form-data">
  <div class="txt_field">
            <input name="idProduct" type="text" required>
            <span></span>
            <label>ID Produs</label>
          </div>
    <input type="submit" name="submit" value="Search ID">
  </form>
</div>
<div class="center">
<h1> Editare Produse</h1>
  <form action="Update.php" method="post" enctype="multipart/form-data">
          
          <input type="hidden" name="idProduct" value="<?php if($_SESSION["idProduct"]) echo $_SESSION["idProduct"];?>">
          <div class="txt_field">
          <span> Selectati operatia </span>
          <select name="mod" >
            <option value="Editare">Editare</option>
            <option value="Stergere">Stergere</option>
          </select>
        </div>
          <div class="txt_field">
            <input name="Nume" type="text" required value="<?php if($_SESSION["NumeProdus"]) echo $_SESSION["NumeProdus"] ?>">
            <span></span>
            <label>Nume</label>
          </div>
        <div class="txt_field">
          <input name="Cantitate" type="text" required value="<?php  echo $_SESSION["Cantitate"] ?>">
          <span></span>
          <label>Cantitate</label>
        </div>
        <div class="txt_field">
          <input name="Pret" type="text" required value="<?php  echo $_SESSION["Pret"] ?>">
          <span></span>
          <label>Pret</label>
        </div>
        <div class="txt_field">
            <span></span>
            <input> <textarea name="Descriere" rows=4 cols=45><?php  echo $_SESSION["Descriere"] ?></textarea>
            <label>Descriere</label>
        </div>
    <input type="submit" name="submit" value="Update">
  </form>
</div>
<div class="container">

    <?php
        if ($products_data->num_rows > 0) {
            // output data of each row
            while($row = $products_data->fetch_assoc()) {
              echo 'ID: ' .$row["idProduct"] ;
              $res = getImage($row["idProduct"]);
                 echo '
                <div class= "product">
                <div class="product-card">
                  <h2 class="name">'. $row["Nume"]. '</h2>
                  <span class="price">' . $row["Pret"].' lei</span>
                  <a class="popup-btn">Quick View</a>
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
                    </div>
                  </div>
                </div>
              </div>  

                ';
            }
          }
    ?>
  </div>

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
<body>
</html>