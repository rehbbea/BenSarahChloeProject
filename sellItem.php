<?php include 'database.php'; 
?>

<?php
   session_start();
?>
<!doctype html>
<html>
  <head>
    <meta charset="utf-8"/>
    <title>What's for sale?</title>
	<!-- Include stylesheet-->
	<link href="../../stylesheet.css" rel="stylesheet" type="text/css">
  </head>
<body>
<!-- template.php contains the header and nav bar-->
<?php include 'template.php';?>

	<h3>List an item to sell</h3> 
	
	
      <div>
       
<!--Hmmm, so I don't want to ask the user their name because they should be logged in but I don't get the mechanism behind that 
and it is too late now to work on it anymore tonight*/
 /*     </div> <!-- /container --> 
		 <?php
            $msg = '';
            include 'database.php'; 
            if (isset($_POST['additem']) && isset($_SESSION['username']) && !empty($_POST['item_name']) && !empty($_POST['date_expires'])) {
			$user = $_SESSION['username'];
			$item_name =  $_POST['item_name'];
			$description =  $_POST['description'];
			$category =  $_POST['category'];
			$start_price =  $_POST['start_price'];
			$date_expires =  $_POST['date_expires'];
			if (empty($start_price)){
			$start_price = 0;
			}
			if (empty($reserve_price)){
			$reserve_price = 0;
			}

			if (empty($category)||$category=0){
			$category = 7;
			
			}
			if (empty($description)){
			$description= " ";
			}						
			$sellerq = "SELECT user_id FROM t_users WHERE email='" . $user . "';";				/*get the user_id from the session*/
			$result = mysqli_query($connection,$sellerq)
				or die('Error making select users query' . mysql_error());
			$row = mysqli_fetch_array($result);
			$seller_id = $row['user_id'];

			$issellerq = "SELECT user_id FROM t_sellers WHERE user_id='" . $seller_id. "';";			/*check the user is a seller*/
			/*If the user isn't listed as a seller, add to the sellers table*/
			if(!mysqli_query($connection, $issellerq) | mysqli_query($connection, $issellerq)->num_rows < 1) {
			$addseller = "INSERT INTO t_sellers (user_id, seller_rep, seller_rep_count, no_sales) VALUES (". $seller_id .", 0,0,0);";
			$result = mysqli_query($connection, $addseller)
				or die('Error adding seller' . mysql_error());			
			}
	        if(empty($seller_id)) {

				$msg = 'Goodness me, something went wrong - please log in again';
							   echo "We don't know who you are";
			}
			else
			{			
				$itemadd = "INSERT INTO t_auctions (seller_id, item_name, description, cat, start_price, date_expires, reserve_price) VALUES ('". $seller_id ."', '". $item_name ."', '". $description ."', '". $category ."', ". $start_price .", '". $date_expires ."' ,". $reserve_price .");";
				if (!mysqli_query($connection, $itemadd)){
				$msg = "We couldn't add your item, something went wrong";
							   echo "We couldn't add your item, something went wrong";
				}
				else{
				$msg = 'Item added, whippee';
							   echo "Item added, whippee- go to view the item";
				}
			
			}

            }
			        mysqli_close($connection);
         ?>
		 
     <div class = "container">

         <form class = "form-newItem" role = "form" 
            action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']); 
            ?>" method = "post">
            <h4 class = "form-newItem-heading"></h4>
            <p><input type = "text" size='40' name = "item_name" placeholder = "Name of item" 
               required></td></p>
			   <select name="category">	
			   <option value="0">Please select a category</option>
				<option value="1">Clothing</option>
				<option value="2">Leisure</option>
				<option value="3">Electronics</option>
				<option value="4">Collectables</option>
				<option value="5">Jewellery</option>	
				<option value="4">Home and Garden</option>
				<option value="5">Miscellaneous/Other</option>					
				</select><br />
			<p><input type='textarea' name='description' size='40' placeholder = "Item description"  rows="10" cols="30"></p>
			<p><input type='text' name='start_price' size='40' placeholder = "Start price" ></p>	
			<p><input type='text' name='reserve' size='40' placeholder = "Reserve Price"></p>  		
			<p><input type='date(format,timestamp)' name='date_expires' placeholder = "When do you want the auction to finish?" required></p>
       
			<p align="center"><p><button class = "btn btn-lg btn-primary btn-block" type = "submit" 
               name = "additem">Add Item</button></p>
			   
			   
         </form>
 

		 
      </div> 
	</div>
	<div id=footer> Created by us bblah blah blah</div>
  </body>
</html>
