<?php include 'database.php'; ?>

<?php
   session_start();
   if (isset($_GET['item']) and isset($_GET['star'])){
			$item_id = $_GET['item'];
			$star = $_GET['star'];
		    if (isset($_SESSION['username'])){
		        $email = $_SESSION['username'];
				 $query = "SELECT user_id FROM t_users WHERE email = '" . $email . "'";
				 $result = mysqli_query($connection,$query)
				 or die('Error making select users query' . mysql_error());
			    $row = mysqli_fetch_array($result);
				$uid = $row['user_id'];
				 $sellerquery = "SELECT seller_id FROM t_auctions WHERE auction_id = " . $item_id;
				 $sellerresult = mysqli_query($connection, $sellerquery);
				 $sellrow = mysqli_fetch_array($sellerresult);
				 $sellerid = $sellrow['seller_id'];
				 
				 $updatequery = "UPDATE t_sellers SET seller_rep = seller_rep * no_sales";
				 mysqli_query($connection, $updatequery);
				 $updatequery = "UPDATE t_sellers SET no_sales = no_sales + 1";
				 mysqli_query($connection, $updatequery);
				 $updatequery = "UPDATE t_sellers SET seller_rep = seller_rep + " . $star;
				 mysqli_query($connection, $updatequery);
				 $updatequery = "UPDATE t_sellers SET seller_rep = seller_rep / no_sales";
				 mysqli_query($connection, $updatequery);
				 
				 $updatequery = "UPDATE t_auctions SET w_feedback = 1 WHERE  auction_id = " . $item_id ;
				 mysqli_query($connection, $updatequery);				 
				 echo "<h2>You give them a " . $star . " star rating.</h2>";
				 $newurl = "viewitem.php?item=" . $item_id;
				 header('Refresh: 5; URL = ' . $newurl);		
				 exit;
			}
   }
   header('Refresh: 20; URL = browse.php');
?>