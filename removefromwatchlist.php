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
				
			    $watchremove = "DELETE FROM t_watchlist WHERE auctionid = " . $item_id . " AND user_id = " . $uid;
				if (!mysqli_query($connection, $watchremove))
				{
				    $msg = "We couldn't remove your item, something went wrong";
				    echo "We couldn't remove your item, something went wrong";
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
