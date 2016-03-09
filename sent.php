<?php include 'database.php'; ?>

<?php
   session_start();
   if (isset($_GET['item'])){
			$item_id = $_GET['item'];
				 $updatequery = "UPDATE t_auctions SET sent = NOW() WHERE  auction_id = " . $item_id ;
				 mysqli_query($connection, $updatequery);
				$newurl = "home.php";
				 header('Refresh: 5; URL = ' . $newurl);	
				 echo "Thanks for sending your item";
                 exit;				 
			}
   
   header('Refresh: 1; URL = browse.php');
?>