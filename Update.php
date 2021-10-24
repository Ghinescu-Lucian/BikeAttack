<?php
// Include the database configuration file
include 'connection.php';
$statusMsg = '';

if($_SERVER['REQUEST_METHOD'] == "POST")
	{
		//something was posted
		$Nume = $_POST['Nume'];
		$Cantitate = $_POST['Cantitate'];
    $Pret = $_POST['Pret'];
    $Descriere = trim($_POST['Descriere']);
    $mod=$_POST['mod'];
    $idProduct = $_POST['idProduct'];

  
    if(strcmp($mod,'Editare')==0){
            if(!empty($Nume) && !empty($Cantitate) && !empty($Pret))
                {
                    $query = "UPDATE product SET Nume='$Nume', Descriere='$Descriere', Pret='$Pret', Cantitate='$Cantitate' WHERE idProduct='$idProduct'";
            
                if(mysqli_query($con, $query)){
                    echo '<script type="text/javascript">
                    window.onload = function () { alert("Produs editat cu succes!"); }
                    </script>';
                    header("Location: Editare.php");
                }
                else {
                     echo "Bad";
                     echo $idProduct;
                }
            }
    }
    else{
                 $query = "DELETE FROM product WHERE idProduct = '$idProduct'";
                 $query1 ="SELECT Nume from productimages WHERE idProduct = '$idProduct'";
                 $res=mysqli_query($con,$query1);
                 $res=mysqli_fetch_assoc($res);
                 $path =$res['Nume'];
                if(mysqli_query($con, $query)){
                    unlink('./uploads/'.$path.'');
                    echo '<script type="text/javascript">
                    window.onload = function () { alert("Produs sters cu succes!"); }
                    </script>';
                   
                }
                else {
                     echo "Bad";
                     echo $idProduct;
                }
                header("Location: Editare.php");
    }
}
?>