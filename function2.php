<?php
//include("connection.php");




function getImage($idProduct){
    $dbhost = "localhost";
    $dbuser = "root";
    $dbpass = "";
    $dbname = "bikeattack";
    $con = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);

	$image_query = mysqli_query($con,"select Nume from productimages where idProduct = '$idProduct' limit 1");
	while($rows = mysqli_fetch_array($image_query))
        {
            //$img_name = $rows['img_name'];
            $img_src = $rows['Nume'];
            return $img_src;
        }
	
    }

    
function getProducts($con){
	$product_query = mysqli_query($con,"select * from product order by Pret ASC");
	return $product_query;
}
function getProductsKey($con,$keyword){
	$product_query = mysqli_query($con,"select * from product where Nume LIKE '%$keyword%' OR Descriere LIKE '%$keyword%'  ORDER BY Pret");
	return $product_query;
}
function getOrdersUser($con,$username){
	$order_query = mysqli_query($con,"select * from orders where Username = '$username' order by Data DESC");
	return $order_query;
}
function getOrders($con){
	$order_query = mysqli_query($con,"select * from orders order by Data DESC");
	return $order_query;
}
function getQuantity($con, $idProduct){
	$result = mysqli_query($con,"select Cantitate from product where idProduct = $idProduct");
    $Quantity = mysqli_fetch_assoc($result);
    return $Quantity;
}

function cartElement($item_img, $item_name, $item_price, $item_id, $item_quantity){
    $element = "
    
    <form action=\"Cos.php?action=remove&id=$item_id\" method=\"post\" class=\"cart-items\">
                    <div class=\"border rounded\">
                        <div class=\"row bg-white\">
                            <div class=\"col-md-3 pl-0\">
                                <img src=./uploads/$item_img alt=\"Image1\" class=\"img-fluid\">
                            </div>
                            <div class=\"col-md-6\">
                                <h5 class=\"pt-2\">$item_name</h5>
                                <h5 class=\"pt-2\">$item_price lei</h5>
                                <button type=\"submit\" class=\"btn btn-danger mx-2\" name=\"remove\">Remove</button>
                            </div>
                            <div class=\"col-md-3 py-5\">
                                <div>
                                        <form  action=\"Cos.php?action=change&id=$item_id\" method=\"post\">
                                            <button type=\"submit\"  name=\"sub\" class=\"btn bg-light border rounded-circle\"><i class=\"fas fa-minus\"></i></button>
                                         <input type=\"text\" value=\"$item_quantity\" class=\"form-control w-25 d-inline\">
                                            <button type=\"submit\"  name=\"add\" class=\"btn bg-light border rounded-circle\"><i class=\"fas fa-plus\"></i></button>
                                         </form>       
                                 </div>
                            </div>
                        </div>
                    </div>
                </form>
    
    ";
    echo  $element;
}


?>
