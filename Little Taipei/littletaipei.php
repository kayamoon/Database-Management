
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Little Taipei</title>
    <link rel="stylesheet" href="css/normalize.css" media="screen">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <link rel="stylesheet" href="css/styles.css" media="screen">
  <!--<link href="css/cartstyle.css" type="text/css" rel="stylesheet" />	-->
    <link href="https://fonts.googleapis.com/css?family=Khand:700|Lora|Raleway&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Khand:300,400&display=swap" rel="stylesheet">

</head>

<style>
	h1 {
		text-align: center;
		color: #000;
		font-weight: 700;
		padding-top: 50px;
		padding-bottom: 30px;
	}

	footer {
		padding-bottom: 60px;
  }
  
  .product-quantity {
    padding: 5px 10px;
    margin-right: 20px;
    border-radius: 3px;
    border: #E0E0E0 1px solid;
}

.no-records {
	text-align: center;
	clear: both;
	margin: 38px 0px;
}

.shopping-cart {
    font-family: 'Lora', serif;
    color: #404040;
  }

  .menuheading {
      background-color: lightblue;
      border-bottom: 1px solid #E4F6E5;
  }

  .card {
    border: 1.5px solid #DA9091;
    margin-bottom: .5px;
  }


</style>


<body>



<!-- MAIN NAVIGATION -->



    <header>

                  <nav class="navbar fixed-top navbar-expand-lg navbar-light bg-light">
                        <a class="navbar-brand" href="littletaipei.php">LITTLE TAIPEI</a>
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                          <span class="navbar-toggler-icon"></span>
                        </button>
                      
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                          <ul class="navbar-nav ml-auto">
                            <li class="nav-item">
                              <a class="nav-link" href="#menu">Menu <span class="sr-only">(current)</span></a>
                            </li>
                            <li class="nav-item">
                              <a class="nav-link" href="#about">About</a>
                            </li>
                            <li class="nav-item">
                                    <a class="nav-link" href="#contact">Contact</a>
                                  </li>
                         <!--   <li class="nav-item dropdown">
                              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                View Cart
                              </a>
                              <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="#"><span>Item Name - Price</span><span class="item-right">
                                        <button class="btn btn-xs btn-danger pull-right">x</button>
                                    </span></a>
                                <a class="dropdown-item" href="#"><span>Item Name - Price</span><span class="item-right">
                                        <button class="btn btn-xs btn-danger pull-right">x</button>
                                    </span></a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="checkout.html">Checkout</a>
                              </div>
                            </li> -->
                          </ul>
                        </div>
                      </nav>
    </header>

    
	<div class="container mt-4">

   <!-- MENU STARTS-->
   <div id="menu"><h1>Menu</h1></div>
   <div class="container row d-flex justify-content-center mx-auto">

  <div class="container col-8 ml-auto shopping-cart">
<h2>Your Order</h2>


<!-- SHOPPING CART FUNCTIONALITY, ADD, REMOVE, OR EMPTY CART PHP -->

    
 <?php
 session_start();
 require("mysqli_connect.php");
 $itemIDsInCart = array();

 if(!empty($_GET["action"])) {
    
 switch($_GET["action"]) {
     case "add":
         if(!empty($_POST["quantity"])) {
             $productByID = $dbc->query("SELECT * FROM MenuItem WHERE itemID='" . $_GET["itemID"] . "'");

             //$productByID = $dbc->query('SELECT * FROM MenuItem WHERE itemID=2');
             while ($row = $productByID->fetch_assoc()){
                   $itemArray = array($row["itemID"]=>array('itemName'=>$row["itemName"], 'itemID'=>$row["itemID"], 'quantity'=>$_POST["quantity"], 'unitPrice'=>$row["unitPrice"]));
                   $rowitemID = $row["itemID"];
            // echo "Item Array".$itemArray[1]['unitPrice']."<br>";

        }
    
        //echo $productByID[1]["itemID"];

            //echo "<br> itemArray".var_dump($itemArray);

             if(!empty($_SESSION["cart_item"])) {
                //echo "rowitemID: ".$rowitemID."  session cart item keys ".array_values($_SESSION["cart_item"])."<br>";
                foreach($_SESSION["cart_item"] as $k => $v) {
                    array_push($itemIDsInCart, $v["itemID"]);
                }

                 //if(in_array($rowitemID,array_keys($_SESSION["cart_item"]))) { //if item is already in cart increase quantity
                    if(in_array($rowitemID,$itemIDsInCart)) { //if item is already in cart increase quantity
                     foreach($_SESSION["cart_item"] as $k => $v) {
                         //echo "K:".$k."  rowitemID: ".$rowitemID."  session cart item  ".$_SESSION["cart_item"]."<br>";
                             if($rowitemID == $v["itemID"]) {
                                 if(empty($_SESSION["cart_item"][$k]["quantity"])) {
                                     $_SESSION["cart_item"][$k]["quantity"] = 0;
                                 }
                                 $_SESSION["cart_item"][$k]["quantity"] += $_POST["quantity"];

                             }
                     }
                 } else {
                     $_SESSION["cart_item"] = array_merge($_SESSION["cart_item"],$itemArray); //if item is not in cart, add item
                 //    echo "k:".$k."  rowitemID: ".$rowitemID."  session cart item  ".$_SESSION["cart_item"]."<br>";
                  //   echo "first else";
                 }
             } else {
                 $_SESSION["cart_item"] = $itemArray; //if no items in cart, add first item
                // echo "second else";
             }
            }      
     break;
     case "remove":
		if(!empty($_SESSION["cart_item"])) {
			foreach($_SESSION["cart_item"] as $k => $v) {
                    if($_GET["itemID"] == $v["itemID"])
						unset($_SESSION["cart_item"][$k]);				
					if(empty($_SESSION["cart_item"]))
						unset($_SESSION["cart_item"]);
			}
		}
	break;
     case "empty":
         unset($_SESSION["cart_item"]);
     break;  
     case "checkout":
        //if cart is not empty
        if(!empty($_SESSION["cart_item"])) {

          echo "<div class='alert alert-success' role='alert'>"."Your Order Has Been Placed! Please Check Your Email for an Order Confirmation."."</div>";

        //get customer details and put into Customer table - hardcoded customer details
        $query="INSERT into Customer(firstName,lastName,phoneNumber,addressName,city,stateName)values('Tai','Sen','7184996074','222 East St','Boston','MA')";

        //get customerID of last inserted customer
        if ($dbc->query($query) === TRUE) {
          $last_id = $dbc->insert_id;
          //echo "New record created successfully. Last inserted ID is: " . $last_id;
          $customer_id = $last_id;
        } /* else {
          echo "Error: " . $query . "<br>" . $dbc->error;
        } */
        //echo "customer ID:".$customer_id;


        //get cart item array //loop through each item
        //tally up the order's total price and number of items
        $total_cost = 0;
        $total_count = 0;
        foreach($_SESSION["cart_item"] as $k => $v) {
         // echo "<br> Create New Order Item for ".$v["itemName"]." : ".$v["itemID"]." : ".$v["quantity"]. " : ".$v["unitPrice"];
          $total_cost += ($v["quantity"]*$v["unitPrice"]);
          $total_count += $v["quantity"];
        }
        //echo "<br> Order details: CustomerID: ".$customer_id." Total Cost: ".$total_cost." Total Quantity: ".$total_count;


        //create order and put order information and customer information into Orders table
        $query="INSERT into Orders(orderDateTime,totalCost,numberOfItems,customerID)values(now(),$total_cost,$total_count,$customer_id)";


        //get orderID of last inserted order
        if ($dbc->query($query) === TRUE) {
          $last_id = $dbc->insert_id;
          //echo "New record created successfully. Last inserted ID is: " . $last_id;
          $order_id = $last_id;
        } /* else {
          echo "Error: " . $query . "<br>" . $dbc->error;
        } */
       // echo "order ID:".$order_id;

        //must create order items after orderID is inserted into Orders

        foreach($_SESSION["cart_item"] as $k => $v) {
          $qnt = $v["quantity"];
          $id = $v["itemID"];
          $query="INSERT into OrderItem(quantityBought,itemID,orderID)values($qnt,$id,$order_id)";
          $result=$dbc->query($query);
        }
      }
    break;
        //future addition: subtract quantity from MenuItem table (quantity in stock)
 }
 }
 ?>	



<!-- SHOPPING CART TABLE -->


 <?php 

if(isset($_SESSION["cart_item"])){
    $total_quantity = 0;
    $total_price = 0;
?>	




<!--bootstrap table-->
<div class="table-responsive">
<table class="table shopping-cart">
  <thead>
    <tr>
      <th scope="col">Name</th>
      <th scope="col">Quantity</th>
      <th scope="col">Unit Price</th>
      <th scope="col">Price</th>
      <th scope="col">Remove</th>
    </tr>
  </thead>
  <tbody>


  <?php		
    foreach ($_SESSION["cart_item"] as $item){
        $item_price = $item["quantity"]*$item["unitPrice"];
		?>
    <tr>
      <th scope="row"><?php echo $item["itemName"]; ?></th>
      <td><?php echo $item["quantity"]; ?></td>
      <td><?php echo "$ ".$item["unitPrice"]; ?></td>
      <td><?php echo "$ ". number_format($item_price,2); ?></td>
      <td><a href="littletaipei.php?action=remove&itemID=<?php echo $item["itemID"]; ?>" class="btnRemoveAction"><img src="icon-delete.png" alt="Remove Item" /></a></td>
    </tr>

    <?php
				$total_quantity += $item["quantity"];
				$total_price += ($item["unitPrice"]*$item["quantity"]);
		}
		?>
   

   <!-- TOTAL PRICE AND QUANTITY ROW -->
    <tr class="table-active">
      <th scope="row">TOTAL</th>
      <td><?php echo $total_quantity; ?></td>
      <td></td>
      <td><strong><?php echo "$ ".number_format($total_price, 2); ?></strong></td>
      <td></td>
    </tr>
  </tbody>
</table>



<!-- CHECKOUT AND EMPTY CART BUTTONS -->
<button type="button" class="btn btn-success float-left" data-toggle="button" aria-pressed="false"><a href="littletaipei.php?action=checkout">Checkout</a></button>
<button type="button" class="btn btn-outline-danger float-right"><a href="littletaipei.php?action=empty">Empty Cart</a></button>

  </div>



<!-- PRINT "CART IS EMPTY" IF EMPTY" -->
  <?php
} else {
?>
<div class="no-records">Your Cart is Empty</div>
<?php 
}
?>
</div>


<div class="container col-8 mt-5" id="product-grid">

        <!--APPETIZERS-->
        <h2 class="mb-3 mt-3 menuheading">Appetizers</h2>


<?php
          require("mysqli_connect.php");
          $query='SELECT * FROM MenuItem WHERE categoryID=1';
          $result=$dbc->query($query);
          while($row = $result->fetch_assoc()){?>
                  <form method="post" action="littletaipei.php?action=add&itemID=<?php echo $row['itemID']; ?>">
                      <div class="card w-90">
                        <div class="card-body">
                          <h5 class="card-title font-weight-bold"><?php echo $row['itemName'];?></h5>
                          <p class="price card-text float-left">$<?php echo $row['unitPrice'];?></p>
                          <div class="float-right"><input type="text" class="product-quantity" name="quantity" value="1" size="2" /><input type="submit" value="Add to Cart" class="btn btn-outline-primary" /></div>
                    </form>
                        </div>
                      </div>
                  
          <?php }  ?>


              <!--SOUP-->
        <h2 class="mb-3 mt-3 menuheading">Soup</h2>


<?php
          require("mysqli_connect.php");
          $query='SELECT * FROM MenuItem WHERE categoryID=2';
          $result=$dbc->query($query);
          while($row = $result->fetch_assoc()){?>
                  <form method="post" action="littletaipei.php?action=add&itemID=<?php echo $row['itemID']; ?>">
                      <div class="card w-90">
                        <div class="card-body">
                          <h5 class="card-title font-weight-bold"><?php echo $row['itemName'];?></h5>
                          <p class="price card-text float-left">$<?php echo $row['unitPrice'];?></p>
                          <div class="float-right"><input type="text" class="product-quantity" name="quantity" value="1" size="2" /><input type="submit" value="Add to Cart" class="btn btn-outline-primary" /></div>
                    </form>
                        </div>
                      </div>
                  
          <?php }  ?>


             <!--RICE-->
        <h2 class="mb-3 mt-3 menuheading">Rice</h2>


<?php
          require("mysqli_connect.php");
          $query='SELECT * FROM MenuItem WHERE categoryID=3';
          $result=$dbc->query($query);
          while($row = $result->fetch_assoc()){?>
                  <form method="post" action="littletaipei.php?action=add&itemID=<?php echo $row['itemID']; ?>">
                      <div class="card w-90">
                        <div class="card-body">
                          <h5 class="card-title font-weight-bold"><?php echo $row['itemName'];?></h5>
                          <p class="price card-text float-left">$<?php echo $row['unitPrice'];?></p>
                          <div class="float-right"><input type="text" class="product-quantity" name="quantity" value="1" size="2" /><input type="submit" value="Add to Cart" class="btn btn-outline-primary" /></div>
                    </form>
                        </div>
                      </div>
                  
          <?php }  ?>



             <!--FRIED RICE-->
        <h2 class="mb-3 mt-3 menuheading">Fried Rice</h2>


<?php
          require("mysqli_connect.php");
          $query='SELECT * FROM MenuItem WHERE categoryID=4';
          $result=$dbc->query($query);
          while($row = $result->fetch_assoc()){?>
                  <form method="post" action="littletaipei.php?action=add&itemID=<?php echo $row['itemID']; ?>">
                      <div class="card w-90">
                        <div class="card-body">
                          <h5 class="card-title font-weight-bold"><?php echo $row['itemName'];?></h5>
                          <p class="price card-text float-left">$<?php echo $row['unitPrice'];?></p>
                          <div class="float-right"><input type="text" class="product-quantity" name="quantity" value="1" size="2" /><input type="submit" value="Add to Cart" class="btn btn-outline-primary" /></div>
                    </form>
                        </div>
                      </div>
                  
          <?php }  ?>


            <!--NOODLE SOUP-->
        <h2 class="mb-3 mt-3 menuheading">Noodle Soup</h2>


<?php
          require("mysqli_connect.php");
          $query='SELECT * FROM MenuItem WHERE categoryID=5';
          $result=$dbc->query($query);
          while($row = $result->fetch_assoc()){?>
                  <form method="post" action="littletaipei.php?action=add&itemID=<?php echo $row['itemID']; ?>">
                      <div class="card w-90">
                        <div class="card-body">
                          <h5 class="card-title font-weight-bold"><?php echo $row['itemName'];?></h5>
                          <p class="price card-text float-left">$<?php echo $row['unitPrice'];?></p>
                          <div class="float-right"><input type="text" class="product-quantity" name="quantity" value="1" size="2" /><input type="submit" value="Add to Cart" class="btn btn-outline-primary" /></div>
                    </form>
                        </div>
                      </div>
                  
          <?php }  ?>



            <!--NOODLES-->
        <h2 class="mb-3 mt-3 menuheading">Noodles</h2>


<?php
          require("mysqli_connect.php");
          $query='SELECT * FROM MenuItem WHERE categoryID=6';
          $result=$dbc->query($query);
          while($row = $result->fetch_assoc()){?>
                  <form method="post" action="littletaipei.php?action=add&itemID=<?php echo $row['itemID']; ?>">
                      <div class="card w-90">
                        <div class="card-body">
                          <h5 class="card-title font-weight-bold"><?php echo $row['itemName'];?></h5>
                          <p class="price card-text float-left">$<?php echo $row['unitPrice'];?></p>
                          <div class="float-right"><input type="text" class="product-quantity" name="quantity" value="1" size="2" /><input type="submit" value="Add to Cart" class="btn btn-outline-primary" /></div>
                    </form>
                        </div>
                      </div>
                  
          <?php }  ?>



                <!--VEGETABLES-->
        <h2 class="mb-3 mt-3 menuheading">Vegetables</h2>


<?php
          require("mysqli_connect.php");
          $query='SELECT * FROM MenuItem WHERE categoryID=7';
          $result=$dbc->query($query);
          while($row = $result->fetch_assoc()){?>
                  <form method="post" action="littletaipei.php?action=add&itemID=<?php echo $row['itemID']; ?>">
                      <div class="card w-90">
                        <div class="card-body">
                          <h5 class="card-title font-weight-bold"><?php echo $row['itemName'];?></h5>
                          <p class="price card-text float-left">$<?php echo $row['unitPrice'];?></p>
                          <div class="float-right"><input type="text" class="product-quantity" name="quantity" value="1" size="2" /><input type="submit" value="Add to Cart" class="btn btn-outline-primary" /></div>
                    </form>
                        </div>
                      </div>
                  
          <?php }  ?>



                <!--DESSERTS-->
        <h2 class="mb-3 mt-3 menuheading">Desserts</h2>


<?php
          require("mysqli_connect.php");
          $query='SELECT * FROM MenuItem WHERE categoryID=8';
          $result=$dbc->query($query);
          while($row = $result->fetch_assoc()){?>
                  <form method="post" action="littletaipei.php?action=add&itemID=<?php echo $row['itemID']; ?>">
                      <div class="card w-90">
                        <div class="card-body">
                          <h5 class="card-title font-weight-bold"><?php echo $row['itemName'];?></h5>
                          <p class="price card-text float-left">$<?php echo $row['unitPrice'];?></p>
                          <div class="float-right"><input type="text" class="product-quantity" name="quantity" value="1" size="2" /><input type="submit" value="Add to Cart" class="btn btn-outline-primary" /></div>
                    </form>
                        </div>
                      </div>
                  
          <?php }  ?>



<!-- 
1	Appetizers
2	Soup
3	Rice
4	Fried Rice
5	Noodle Soup
6	Noodles
7	Vegetables
8	Desserts -->

        


</div>
            </div> 






              
<div class="container" id="about">
    <h1>About</h1>
    <p> Little Taipei is a an Taiwanese restaurant that specializes in authentic street food and comforting homemade dishes. We hope to bring a taste of Taiwan's capital, Taipei, to Boston. </p>
</div>

<div class="container" id="contact">
        <h1>Contact</h1>
        <div>
          <address><p>886 Brighton St, Boston MA 02111</p></address>
          <p>Open everyday 9am-9pm.</p>
          <p class="email">littletaipei@gmail.com</p>
      </div>
</div>


		<div class="container">
			<footer>
				<p>Made by Kaya Chou-Kudu with Love</p>
			</footer>
		</div>

    </div>
    
    <script src="js/script.js"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>

</html>