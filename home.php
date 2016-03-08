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
<?php include 'template.php'; ?>

	<h3>My Finished Auctions</h3> 
<?php	
	 if (isset($_SESSION['username'])){
		        $email = $_SESSION['username'];
				 $idquery = "SELECT user_id FROM t_users WHERE email = '" . $email . "'";
				 $idresult = mysqli_query($connection,$idquery)
				 or die('Error making select users query' . mysql_error());
			    $idrow = mysqli_fetch_array($idresult);
				$userid = $idrow['user_id'];
				}
			else
			{
				header('Refresh: 1; URL = databaseindex.php');
				exit;
			}
		 
		 
		 
            $msg = ''; 
		$defaultq="SELECT u.d_name, a.date_listed, a.date_expires, a.item_name, a.auction_id, c.cat_desc, a.description, h.currentval, a.reserve_price, a.sent, a.s_feedback, a.s_paid
		FROM (SELECT auctionid, max(`amount`) as currentval FROM `t_bids` GROUP BY auctionid) as h RIGHT JOIN t_auctions as a ON 			a.auction_id=h.auctionid, t_sellers as s, t_users as u, t_cat as c 
			where a.seller_id =s.user_id AND s.user_id=u.user_id AND a.cat= c.cat_id AND
		date_expires<NOW() AND a.auction_id IN (SELECT auction_id FROM t_auctions WHERE seller_id = " . $userid . ") ORDER BY(date_expires);";
		$currentq=$defaultq;

      function drawTableContents($query)
		{
		include 'database.php'; 
        $result = mysqli_query($connection, $query)
		or die("Hmm, that didn't seem to work" . mysql_error());
		
		$first = true;
		
		$colnames = array(
		"d_name" =>"Display name", 
		"date_listed" => "Date listed",
		"date_expires" => "End of auction",
		"item_name" => "Name",
		"cat_desc" => "Category",
		"description" => "Description",
		"currentval" => "Highest bid",
		"reserve_price" => "Success",
		"sent"=>  "Sent item?",
		"s_feedback"=>  "Feedback for seller",	
		"s_paid"=>  "Payment for listing?",		
		);		
		
		while($row = mysqli_fetch_array($result,MYSQLI_ASSOC))
		{
			
			if($first){
				echo "<tr>";
				foreach($colnames as $column => $value){
					
				echo "<th>$value</th>";
				}
				echo "</tr>";
				$first = false;
			}
		
			echo "<tr>";
			foreach($colnames as $column => $value){
				if($column != 'auction_id')
				{
				echo "<td>";
				if($column == 'reserve_price')
				{
					if ($row['reserve_price']>$row['currentval']){
						echo "Unsuccessful Auction";
					}
					else {
					 echo "Success";
					 }
				}

				else if($column == 'sent')
				{
					if (!($row['reserve_price']>$row['currentval'])){
						if ($row['sent']==False){
							echo "Please send item";
						}
					else if ($row['sent']==True){
						echo "Item sent";
						}
					 }
				}								
				else if($column == 's_feedback')
				{
					if (!($row['reserve_price']>$row['currentval'])){
						if  (empty($row['s_feedback'])){
							echo "Give feedback";
						}
					else if($row['s_feedback']==True) {
						echo "Feedback given";
						}
					 }
				}
				else if($column == 's_paid')
				{
					if  (empty($row['s_paid'])){
					if (!($row['reserve_price']>$row['currentval'])){
						/* if auction succesful charge 2% of the total cost and 20p for the listing*/
						$row['owe']= $row['currentval']*0.02+0.2;
						}
					else  {
						$row['owe']=0.2;
						}
					echo "£ " . number_format($row['owe'],2);
					 }
				}
				else
				{
				    echo $row[$column];
				}
				echo "</td>";
			}
			}
			echo "</tr>";
		}
		
		// Associative array
		// Free result set
		mysqli_free_result($result);		 
        mysqli_close($connection);
      }	
   
		echo "<table>";
			drawTableContents($currentq);
		echo "</table>";
         ?>
      </div> <!-- /container -->

	</div>
	<div id=footer> Created by us bblah blah blah</div>
  </body>
</html>	
	
	