<?php
// Include the database configuration file
include 'connection.php';
$statusMsg = '';

if($_SERVER['REQUEST_METHOD'] == "POST")
	{
		//something was posted
		$idComanda = $_POST['idComanda'];
		$Status = $_POST['Status'];

               $query = "UPDATE orders SET Status='$Status' WHERE idOrder='$idComanda'";
            
                if(mysqli_query($con, $query)){
                    echo '<script type="text/javascript">
                    window.onload = function () { alert("Comanda editata cu succes!"); }
                    </script>';
                    
                    
                    header("Location: Comenzi.php");
                }
                else {
                     echo "Bad";
                     echo $idComanda;
                }
    }

?>