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
				 $winnerquery = "SELECT buyer_id FROM t_bids WHERE auctionid = " . $item_id . " AND amount in (SELECT max(amount) FROM t_bids WHERE auctionid = " . $item_id . ")";
				 $winnerresult = mysqli_query($connection, $winnerquery);
				 $winrow = mysqli_fetch_array($winnerresult);
				 $winnerid = $winrow['buyer_id'];
				 
				 $updatequery = "UPDATE t_buyers SET buyer_rep = buyer_rep * no_buys";
				 mysqli_query($connection, $updatequery);
				 $updatequery = "UPDATE t_buyers SET no_buys = no_buys + 1";
				 mysqli_query($connection, $updatequery);
				 $updatequery = "UPDATE t_buyers SET buyer_rep = buyer_rep + " . $star;
				 mysqli_query($connection, $updatequery);
				 $updatequery = "UPDATE t_buyers SET buyer_rep = buyer_rep / no_buys";
				 mysqli_query($connection, $updatequery);
				 
				 echo "<h2>You give them a " . $star . " star rating.</h2>";
				 $newurl = "viewitem.php?item=" . $item_id;
				 header('Refresh: 5; URL = ' . $newurl);	
                 exit;				 
			}
   }
   header('Refresh: 20; URL = browse.php');
?>
