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
   // $Name = $_POST['Name'];
  
    
	 if(!empty($Nume) && !empty($Cantitate) && !empty($Pret))
		{

        //save to database
      //	$user_id = random_num(20);
        $query1= "select Nume from product where Nume='$Nume'";
        $result = mysqli_query($con, $query1);
        $user_data = mysqli_fetch_assoc($result);
					
       // echo $result;
        if($user_data['Nume'] === $Nume )
        { 
          echo '<script type="text/javascript">
          window.onload = function () { alert("Produsul cu acest nume exista deja!"); }
        </script>';
        }
        else {
          $query = "insert into product (Nume,Descriere,Pret,Cantitate) values ('$Nume','$Descriere','$Pret','$Cantitate')";
           $result = mysqli_query($con, $query);
           echo '<script type="text/javascript">
           window.onload = function () { alert("Produs adaugat cu succes!"); }
         </script>';
        }
        //if($result) echo "good";
        //else echo "Bad";
       // header("Location: AdaugareProduse.php");
        //die;
		}else
		{
			echo "Please enter some valid information!";
		}
   
}

// File upload path
$targetDir = "uploads/";
$fileName = basename($_FILES["file"]["name"]);
$targetFilePath = $targetDir . $fileName;
$fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);

if(isset($_POST["submit"]) && !empty($_FILES["file"]["name"])){
    // Allow certain file formats
    $allowTypes = array('jpg','png','jpeg','gif','pdf');
    if(in_array($fileType, $allowTypes)){
        // Upload file to server
        if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)){
            // Insert image file name into database
			$query1 = "select * from product order by idProduct DESC limit 1";
			$result1= mysqli_query($con,$query1);
			$user_data = mysqli_fetch_assoc($result1);
            $insert = $con->query("INSERT into productimages (Nume,idProduct) VALUES ('".$fileName."', '".$user_data['idProduct']."') ");
            if($insert){
                $statusMsg = "The file ".$fileName. " has been uploaded successfully.";
                header('Location: AdaugareProduse.php');
            }else{
                $statusMsg = "File upload failed, please try again.";
            } 
        }else{
            $statusMsg = "Sorry, there was an error uploading your file.";
        }
    }else{
        $statusMsg = 'Sorry, only JPG, JPEG, PNG, GIF, & PDF files are allowed to upload.';
    }
}else{
    $statusMsg = 'Please select a file to upload.';
}

// Display status message
echo $statusMsg;
?>