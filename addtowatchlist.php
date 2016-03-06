<?php include 'database.php'; ?>

<?php
   session_start();
   if (isset($_GET['item'])){
			$item_id = $_GET['item'];
		    if (isset($_SESSION['username'])){
		        $email = $_SESSION['username'];
				 $query = "SELECT user_id FROM t_users WHERE email = '" . $email . "'";
				 $result = mysqli_query($connection,$query)
				 or die('Error making select users query' . mysql_error());
			    $row = mysqli_fetch_array($result);
				$uid = $row['user_id'];
				
			    $watchadd = "INSERT INTO t_watchlist (auctionid, user_id) VALUES ('". $item_id ."', '". $uid ."');";
				if (!mysqli_query($connection, $watchadd)){
				    $msg = "We couldn't add your item, something went wrong";
					echo $watchadd;
				    echo "We couldn't add your item, something went wrong";
				}
				else{
				     $newurl = "viewitem.php?item=" . $item_id;
					 header('Refresh: 1; URL = ' . $newurl);
					 exit;
				}			
			}
   }
   header('Refresh: 1; URL = browse.php');
?>
