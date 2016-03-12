<?php include 'database.php'; 
?>

<?php
   session_start();
?>
<!doctype html>
<html>
  <head>
    <meta charset="utf-8"/>
    <title>My home</title>
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
		$defaultq="SELECT h.d_name, a.date_listed, a.date_expires, a.item_name, a.auction_id, c.cat_desc, a.description, h.currentval, a.reserve_price, a.sent, a.s_feedback, a.s_paid, a.auction_id as item_id
		FROM (SELECT b.auctionid, amount as currentval, us.d_name FROM (SELECT auctionid, max(amount) as top from t_bids group by auctionid) as m, `t_bids` as b, t_users as us WHERE b.buyer_id=us.user_id AND m.top=b.amount AND m.auctionid=b.auctionid) as h RIGHT JOIN t_auctions as a ON	a.auction_id=h.auctionid, t_sellers as s, t_users as u, t_cat as c 
			where a.seller_id =s.user_id AND s.user_id=u.user_id AND a.cat= c.cat_id AND
		date_expires<NOW() AND a.auction_id IN (SELECT auction_id FROM t_auctions WHERE seller_id = " . $userid . ") ORDER BY(date_expires);";
		$currentq=$defaultq;

      function drawTableContents($query)
		{
		include 'database.php'; 
        $result = mysqli_query($connection, $query)
		or die($query. "Hmm, that didn't seem to work" . mysql_error());
		
		$first = true;
		$total_owe=0;
		
		$colnames = array(
		/*"date_listed" => "Date listed", Do we need this?*/
		"date_expires" => "End of auction",
		"item_name" => "Name",
		/*"cat_desc" => "Category",   Do we need this?*/
		"description" => "Description",
		"currentval" => "Highest bid",
		"d_name" =>"Winner name", 		
		"reserve_price" => "Success",
		"sent"=>  "Sent item?",
		"s_feedback"=>  "Feedback for seller",	
		"s_paid"=>  "Payment for listing",		
		);	
				if ($result->num_rows<1){
		echo "<p>You have no finished auctions</p>"; 
		}
		else{
		echo "<table>";
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
				else if($column == 'd_name')
				{
					if (!($row['reserve_price']>$row['currentval'])){
						echo $row['d_name'];
						}
					else {
						echo "No one won";
					 }
				}
				
				else if($column == 'sent')
				{
					if (!($row['reserve_price']>$row['currentval'])){
						if (empty($row['sent'])){
							echo "<a href=\"sent.php?item=" . $row['item_id'] ."\">Record item sent </a>";
						}
					else if ($row['sent']>0){
						echo "Item is sent";
						}
					 }
				}								
				else if($column == 's_feedback')
				{
					if (!($row['reserve_price']>$row['currentval'])){
						if  (empty($row['s_feedback'])){
					echo "<a href=\"ratebuyer.php?item=" . $row['item_id'] . "&star=1\" ><img src=\"img/star.gif\" onmouseover=\"this.src='img/star2.gif'\" onmouseout=\"this.src='img/star.gif'\"  /></a>";
 				     echo "<a href=\"ratebuyer.php?item=" . $row['item_id'] . "&star=2\" ><img src=\"img/star.gif\" onmouseover=\"this.src='img/star2.gif'\" onmouseout=\"this.src='img/star.gif'\"  /></a>";
 				     echo "<a href=\"ratebuyer.php?item=" . $row['item_id'] . "&star=3\" ><img src=\"img/star.gif\" onmouseover=\"this.src='img/star2.gif'\" onmouseout=\"this.src='img/star.gif'\"  /></a>";
 				     echo "<a href=\"ratebuyer.php?item=" . $row['item_id'] . "&star=4\" ><img src=\"img/star.gif\" onmouseover=\"this.src='img/star2.gif'\" onmouseout=\"this.src='img/star.gif'\"  /></a>";
 				     echo "<a href=\"ratebuyer.php?item=" . $row['item_id'] . "&star=5\" ><img src=\"img/star.gif\" onmouseover=\"this.src='img/star2.gif'\" onmouseout=\"this.src='img/star.gif'\"  /></a>";
					 	
					 /*exit;*/
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
					$total_owe= $total_owe+ $row['owe'];
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
		
		echo "</table>";
		if ($total_owe>0){
			$corpemail="sarah@sarahkerry.co.uk";
			$itemname="Buy my tat fees";
			 echo "<p>You owe £ " . number_format($total_owe,2) . " altogether </p>";
			  echo "
 					 <form action=\"https://www.paypal.com/cgi-bin/webscr\" method=\"post\" target=\"_top\">
					<input type=\"hidden\" name=\"cmd\" value=\"_xclick\">
					<input type=\"hidden\" name=\"business\" value=" . $corpemail . "\">
					<input type=\"hidden\" name=\"lc\" value=\"US\">
					<input type=\"hidden\" name=\"item_name\" value=" . $itemname . "\">
					<input type=\"hidden\" name=\"amount\" value=\"" . $total_owe ."\">
					<input type=\"hidden\" name=\"currency_code\" value=\"GBP\">
					<input type=\"hidden\" name=\"button_subtype\" value=\"services\">
					<input type=\"hidden\" name=\"no_note\" value=\"0\">
					<input type=\"hidden\" name=\"bn\" value=\"PP-BuyNowBF:btn_buynowCC_LG.gif:NonHostedGuest\">
					<input type=\"image\" src=\"https://www.paypalobjects.com/en_US/i/btn/btn_buynowCC_LG.gif\" border=\"0\" name=\"submit\" alt=\"PayPal - The safer, easier way to pay online!\">
					<img alt=\"\" border=\"0\" src=\"https://www.paypalobjects.com/en_US/i/scr/pixel.gif\" width=\"1\" height=\"1\">
					</form>";	
						/*Would be good if this could trigger an event to say the user has paid*/
			 
			}
		// Associative array
		// Free result set
		mysqli_free_result($result);		 
        mysqli_close($connection);
      }	
	}
			drawTableContents($currentq);
		
		
         ?>
      </div> <!-- /container -->

	<h3>My Messages</h3> 
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
			$show=0;
		$messageq="SELECT  message_id, auction_id, msgtype, message, is_read FROM t_emails WHERE user_id = " . $userid. " AND is_read= ". $show;

      function drawMessageContents($query)
		{
		include 'database.php'; 
        $result = mysqli_query($connection, $query)
		or die($query. "Hmm, that didn't seem to work" . mysql_error());
		if ($result->num_rows<1){
		echo "<p>You have no new messages</p>"; 
		}
		else{
		$first = true;
		
		$colnames = array(
		"msgtype" => "Message type",
		"message" => "Message",
		"is_read"=> "Read?"
		);				
		echo "<table>";
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
			echo "<td>";
				if($column == 'is_read')
				{

					if ($row['is_read']==0)
					{
						echo "<a href=\"markasread.php?msg=" . $row['message_id'] ."\"> <p> Message Read</p> </a>";
						}
					else {
						echo "Message Read";
						}

				}
				else if ($column == 'msgtype'){
					if ($row['msgtype']==1){
					echo "Auction ending soon";
					}
					else if ($row['msgtype']==2){
					echo "Outbid";
					}
					else if ($row['msgtype']==3){
					echo "Won item";
					}
					else if ($row['msgtype']==4){
					echo "Item sold";
					}
					else if ($row['msgtype']==5){
					echo "No Sale";
					}
				}
				else {
				    echo $row[$column];
				}
				echo "</td>";
			}
		
			echo "</tr>";			
		}
		
		echo "</table>";
		// Associative array
		// Free result set
		mysqli_free_result($result);		 
        mysqli_close($connection);
      }	
   }
			drawMessageContents($messageq);
		
		
         ?>
      </div> <!-- /container -->	  
	<h3> Your Current Auctions</h3> 
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
		$defaultq="SELECT u.d_name, a.date_listed, a.date_expires, a.item_name, a.auction_id, c.cat_desc, a.description, h.currentval, a.pageviews 
		FROM (SELECT auctionid, max(`amount`) as currentval FROM `t_bids` GROUP BY auctionid) as h RIGHT JOIN t_auctions as a ON 			a.auction_id=h.auctionid, t_sellers as s, t_users as u, t_cat as c 
			where a.seller_id =s.user_id AND s.user_id=u.user_id AND a.cat= c.cat_id AND
		date_expires>NOW() AND a.auction_id IN (SELECT auction_id FROM t_auctions WHERE seller_id = " . $userid . ") ORDER BY(date_expires);";
		$auctionq=$defaultq;

            
      function drawAuctions($query)
		{
		include 'database.php'; 
        $result = mysqli_query($connection, $query)
		or die("Hmm, that didn't seem to work" . mysql_error());
		
		if ($result->num_rows==0){
		echo "<p>You have no current auctions</p>";
		}
		else{
		$first = true;
		
		$colnames = array(
		"d_name" =>"Display name", 
		"date_listed" => "Date listed",
		"date_expires" => "End of auction",
		"item_name" => "Name",
		"cat_desc" => "Category",
		"description" => "Description",
		"currentval" => "Highest bid",
		"pageviews"=>"Page views");		
		
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
				if($column == 'd_name')
				{
					echo "<a href=viewitem.php?item=" . $row['auction_id'] .">" . $row['d_name'] ."</a> ";
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
		}
		// Associative array
		// Free result set
		mysqli_free_result($result);		 
        mysqli_close($connection);
		
      }	
   
		echo "<table>";
			drawAuctions($auctionq);
		echo "</table>";
         ?>
      </div> <!-- /container -->
	  
	</div>
	<div id=footer> Created by us bblah blah blah</div>
  </body>
</html>	
	
	