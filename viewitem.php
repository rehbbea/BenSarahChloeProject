<?php include 'database.php'; 
?>

<?php
   session_start();
?>
<!doctype html>
<html>
  <head>
    <meta charset="utf-8"/>
    <title>View an item</title>
	<!-- Include stylesheet-->
	<link href="../../stylesheet.css" rel="stylesheet" type="text/css">
	<?php include 'pageviews.php'; ?>
  </head>
<body>
<!-- template.php contains the header and nav bar-->
<?php include 'template.php';?>

	<div>
	<?php
	
		if (isset($_GET['item'])){
			$item_id = $_GET['item'];
			
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
	    if (isset($_POST['addbid']) && isset($_SESSION['username']) && !empty($_POST['bid_amount']))
		{
			$isbuyerq = "SELECT user_id FROM t_buyers WHERE user_id='" . $userid. "';";			/*check the user is a buyer*/
			/*If the user isn't listed as a buyer, add to the buyers table*/
			if(!mysqli_query($connection, $isbuyerq) | mysqli_query($connection, $isbuyerq)->num_rows < 1) {
			$addbuyer = "INSERT INTO t_buyers (user_id) VALUES (". $userid .")";
			$result = mysqli_query($connection, $addbuyer)
				or die('Error adding seller' . mysql_error());			
			}
			$bid_amount =  $_POST['bid_amount'];
		    $bidquery = "INSERT INTO t_bids (auctionid, buyer_id, amount) VALUES ('". $item_id ."', '". $userid ."', '". $bid_amount ."')";
				if (!mysqli_query($connection, $bidquery)){
				    $msg = "We couldn't add your bid, something went wrong";
					echo $bidquery;
				    echo "We couldn't add your bid, something went wrong";
				}
				else{
					$outbidcheck = "SELECT user_id FROM t_watchlist WHERE user_id = " . $oldid . " AND auctionid = " . $item_id ;
                                        $checkresult = mysqli_query($connection, $outbidcheck);
                                        if(!empty($checkresult))
                                        {
                                            $checkrow = mysqli_fetch_array($checkresult);
                                            if(!empty($checkrow))
                                            {
                                                $checkid = $checkrow['user_id'];
                                                if(!empty($checkid))
                                                {
                                                /*Tell bidders they are outbid Message type 2*/
                                                    $outbid = "INSERT INTO t_emails (user_id, msgtype, auction_id, message, is_read) SELECT b.buyer_id, 2, b.auctionid,
CONCAT(\"You have been outbid on item \", a.item_name, \". Go to item to place another bid\"), 0
FROM (SELECT max(amount) as highest, buyer_id, auctionid FROM t_bids Group by auctionid) as h, t_auctions as a, t_bids as b WHERE h.auctionid=b.auctionid
AND h.auctionid=a.auction_id AND date_expires>NOW() and h.highest>b.amount  AND b.buyer_id = " . $checkid . " AND (h.buyer_id!=b.buyer_id) AND CONCAT(b.buyer_id, \"_\",
b.auctionid, \"_\", \"2\") NOT IN (SELECT CONCAT(e.user_id, \"_\" , e.auction_id, \"_\", e.msgtype) FROM t_emails as e);";
mysqli_query($connection, $outbid);
                                                }
                                            }
                                       }


				     $newurl = "viewitem.php?item=" . $item_id;
					 header('Refresh: 1; URL = ' . $newurl);
					 exit;
				}			
	
		}
	
			$query = "SELECT u.d_name as seller_name, u.user_id, a.date_listed, s.seller_rep, a.date_expires as expire_date, date_expires-NOW() as hours_to_expire, timediff(date_expires, NOW()) as hours_to_go, a.reserve_price, a.item_name, c.cat_desc, a.description, h.currentval, h.d_name as buyer, a.s_feedback, a.w_feedback, a.sent, a.img
			FROM (SELECT b.auctionid, amount as currentval, us.d_name FROM (SELECT auctionid, max(amount) as top from t_bids group by auctionid) as m, `t_bids` as b, t_users as us WHERE b.buyer_id=us.user_id AND m.top=b.amount AND m.auctionid=b.auctionid) as h RIGHT JOIN t_auctions as a ON a.auction_id=h.auctionid, t_sellers as s, t_users as u, t_cat as c 
			WHERE auction_id = " . $item_id ." AND c.cat_id = a.cat AND a.seller_id=s.user_id AND s.user_id=u.user_id;";

			$result = mysqli_query($connection,$query)
		        or die('No such item.' . mysql_error());
			$row = mysqli_fetch_array($result);
			$seller = $row['seller_name'];
			$sellerrep = $row['seller_rep'];
			$hoursexpire = $row['hours_to_expire'];
			$sellerid = $row['user_id'];
			$itemname = $row['item_name'];
			$catdesc = $row['cat_desc'];
			$desc = $row['description'];
			$currentval = $row['currentval'];
			$expires = $row['expire_date'];
			$reserve = $row['reserve_price'];
			$hours = $row['hours_to_go'];
			$winnersofar = $row['buyer'];
			$sent = $row['sent']; 
			$s_feedback = $row['s_feedback'];
			$w_feedback = $row['w_feedback']; 	
			$image = $row['img'];
			$step = '0.01';
			if (empty($currentval)||($currentval)==0){
			$currentval=0;
			$winnersofar="No one has bid yet";
			}
			if (empty($winnersofar)){
			$winnersofar="No one has bid yet";
			}
			$currprice = number_format($currentval,2);
			if (empty($image)){
			$image = 'http://i.imgur.com/S2N3B.png';
			}
			echo "<table id='t01'> <tr><td>	Category:" . $catdesc . "</td><td></td><td ROWSPAN=3 ><img src=\"" . $image . "\" style=\"height:200px;\"></td><td></td></tr>";
			echo "<tr> <td></html><h3>" . $itemname . "</h3><html> </td></tr>";
			echo "<td>" . $desc . "</td></tr></table>";	
			if($hoursexpire < 0)
		     {
				 $winnerquery = "SELECT buyer_id FROM t_bids WHERE auctionid = " . $item_id . " AND amount in (SELECT max(amount) FROM t_bids WHERE auctionid = " . $item_id . ")";
				 $winnerresult = mysqli_query($connection, $winnerquery);
				 $winrow = mysqli_fetch_array($winnerresult);
				 $winnerid = $winrow['buyer_id'];
				 if($userid != $sellerid && $userid != $winnerid)
				 {
					 echo "Too late! the auction has finished";
					 header('Refresh: 5; URL = databaseindex.php');
				     exit;
				 }
				 else if($userid == $sellerid)
                 {
					 $detailsquery = "SELECT d_name, email FROM t_users WHERE user_id = " . $winnerid;
					 $detailsresult = mysqli_query($connection, $detailsquery);
					 $detailsrow = mysqli_fetch_array($detailsresult);
					 $winnername = $detailsrow['d_name'];
					 $winneremail = $detailsrow['email'];
					 echo "<p>Congratulations your item has sold to " . $winnername . " For $" . $currentval . "</p><br>";
					 echo "<p>Please get in touch with them at " . $winneremail . "to arrange payment and delivery.</p>";
					 if (empty($s_feedback)){
					 echo "<p>You can rate your buyer below.<br></p>";
				     echo "<a href=\"ratebuyer.php?item=" . $item_id . "&star=1\" ><img src=\"http://i.imgur.com/p7omcv4.png\" onmouseover=\"this.src='http://i.imgur.com/TWPqI6x.png'\" onmouseout=\"this.src='http://i.imgur.com/p7omcv4.png'\"  /></a>";
 				     echo "<a href=\"ratebuyer.php?item=" . $item_id . "&star=2\" ><img src=\"http://i.imgur.com/p7omcv4.png\" onmouseover=\"this.src='http://i.imgur.com/TWPqI6x.png'\" onmouseout=\"this.src='http://i.imgur.com/p7omcv4.png'\"  /></a>";
 				     echo "<a href=\"ratebuyer.php?item=" . $item_id . "&star=3\" ><img src=\"http://i.imgur.com/p7omcv4.png\" onmouseover=\"this.src='http://i.imgur.com/TWPqI6x.png'\" onmouseout=\"this.src='http://i.imgur.com/p7omcv4.png'\"  /></a>";
 				     echo "<a href=\"ratebuyer.php?item=" . $item_id . "&star=4\" ><img src=\"http://i.imgur.com/p7omcv4.png\" onmouseover=\"this.src='http://i.imgur.com/TWPqI6x.png'\" onmouseout=\"this.src='http://i.imgur.com/p7omcv4.png'\"  /></a>";
 				     echo "<a href=\"ratebuyer.php?item=" . $item_id . "&star=5\" ><img src=\"http://i.imgur.com/p7omcv4.png\" onmouseover=\"this.src='http://i.imgur.com/TWPqI6x.png'\" onmouseout=\"this.src='http://i.imgur.com/p7omcv4.png'\"  /></a>";
					 	
					 exit;
					 }
					 else { echo "<p>You have already rated this buyer</p>";
					exit;}
					 }
				 
				 else if($userid == $winnerid)
				 {
					 $detailsquery = "SELECT d_name, email FROM t_users WHERE user_id = " . $sellerid;
					 $detailsresult = mysqli_query($connection, $detailsquery);
					 $detailsrow = mysqli_fetch_array($detailsresult);
					 $sellername = $detailsrow['d_name'];
					 $selleremail = $detailsrow['email'];
					 echo "<p>Congratulations you have won the bid for $" . $currentval . "<br></p>";					
					 echo "<p>Please get in touch with " . $sellername ." at " . $selleremail . "to arrange payment and delivery.<br></p>";
 					 echo "<p>Or use the button below to send payment through paypal.<br></p>";
 
 					 echo "
 					 <form action=\"https://www.paypal.com/cgi-bin/webscr\" method=\"post\" target=\"_top\">
					<input type=\"hidden\" name=\"cmd\" value=\"_xclick\">
					<input type=\"hidden\" name=\"business\" value=" . $selleremail . "\">
					<input type=\"hidden\" name=\"lc\" value=\"US\">
					<input type=\"hidden\" name=\"item_name\" value=" . $itemname . "\">
					<input type=\"hidden\" name=\"amount\" value=\"" . $currentval ."\">
					<input type=\"hidden\" name=\"currency_code\" value=\"GBP\">
					<input type=\"hidden\" name=\"button_subtype\" value=\"services\">
					<input type=\"hidden\" name=\"no_note\" value=\"0\">
					<input type=\"hidden\" name=\"bn\" value=\"PP-BuyNowBF:btn_buynowCC_LG.gif:NonHostedGuest\">
					<input type=\"image\" src=\"https://www.paypalobjects.com/en_US/i/btn/btn_buynowCC_LG.gif\" border=\"0\" name=\"submit\" alt=\"PayPal - The safer, easier way to pay online!\">
					<img alt=\"\" border=\"0\" src=\"https://www.paypalobjects.com/en_US/i/scr/pixel.gif\" width=\"1\" height=\"1\">
					</form>";		
					if (empty($w_feedback)){
					echo "<p>You can rate your seller below.</p><br>";
					echo "<a href=\"rateseller.php?item=" . $item_id . "&star=1\" ><img src=\"http://i.imgur.com/p7omcv4.png\" onmouseover=\"this.src='http://i.imgur.com/TWPqI6x.png'\" onmouseout=\"this.src='http://i.imgur.com/p7omcv4.png'\"  /></a>";
				     echo "<a href=\"rateseller.php?item=" . $item_id . "&star=2\" ><img src=\"http://i.imgur.com/p7omcv4.png\" onmouseover=\"this.src='http://i.imgur.com/TWPqI6x.png'\" onmouseout=\"this.src='http://i.imgur.com/p7omcv4.png'\"  /></a>";
 				     echo "<a href=\"rateseller.php?item=" . $item_id . "&star=3\" ><img src=\"http://i.imgur.com/p7omcv4.png\" onmouseover=\"this.src='http://i.imgur.com/TWPqI6x.png'\" onmouseout=\"this.src='http://i.imgur.com/p7omcv4.png'\"  /></a>";
 				     echo "<a href=\"rateseller.php?item=" . $item_id . "&star=4\" ><img src=\"http://i.imgur.com/p7omcv4.png\" onmouseover=\"this.src='http://i.imgur.com/TWPqI6x.png'\" onmouseout=\"this.src='http://i.imgur.com/p7omcv4.png'\"  /></a>";
 				     echo "<a href=\"rateseller.php?item=" . $item_id . "&star=5\" ><img src=\"http://i.imgur.com/p7omcv4.png\" onmouseover=\"this.src='http://i.imgur.com/TWPqI6x.png'\" onmouseout=\"this.src='http://i.imgur.com/p7omcv4.png'\"  /></a>";
					 exit;
					}
					else { echo "<p>You have already rated this seller</p>";
					exit;}
			 }
			
			}
			$watchquery = "SELECT auctionid FROM t_watchlist WHERE auctionid = " . $item_id . " AND user_id = " . $userid;
			$userbidquery = "SELECT max(amount) as userbid FROM t_bids WHERE auctionid = " . $item_id . " AND buyer_id = " . $userid;
			$userbidresult = mysqli_query($connection,$userbidquery)
				 or die('Error making select bids' . mysql_error());
		    echo "<table id='t01'><tr><td>Being sold by:</td><td> " . $seller . ". </td><td> with reputation " . $sellerrep . "/5 seller.</td></tr>";
			echo "<tr><td>Ends in: </td><td>" . $hours . " </td><td>(At ". $expires .")</td></tr>";
			echo "<tr><td>Highest Bid: </td><td> $" . $currprice  . " </td><td> Bidder: </td> <td>".$winnersofar."</td></tr> ";
			if($userbidresult->num_rows > 0)
			{
				$userbid = mysqli_fetch_array($userbidresult)['userbid'];
				if(!empty($userbid))
				{
				    echo "<tr><td>Your Bid:</td><td>" . $userbid . "</td>";
				}
			}
			/*echo "Reserve Price: $" . $reserve  . "<br><br>"; typically you would not reveal the reserve price*/
			if ($userid != $sellerid){/* Only show buyers the watchlist and bid options - cannot bid on own item*/
			echo "
         <form class = \"form-newBid\" role = \"form\" 
            method = \"post\">
            <h4 class = \"form-newBid-heading\"></h4>
            <p> <td><input type = \"number\" size=\"8\" name = \"bid_amount\", min= \"" . ($currentval + $step) . "\", step=\"0.01\" 
               required></td>
			<align=\"center\"><p><td><button class = \"button\" type = \"submit\" 
               name = \"addbid\">Bid</button></p></td></tr>
         </form>";
			
			
			if(mysqli_query($connection, $watchquery)->num_rows < 1)
			{
				echo "<td><a href=\"addtowatchlist.php?item=" . $item_id ."\" >Add to Watchlist</a></td></tr></table> ";
			}
			else
			{
				echo "<td><a href=\"removefromwatchlist.php?item=" . $item_id ."\" >Remove from Watchlist</a></td></tr></table> ";
			}
			}
			else {echo "</table>";}
			
			
		}
	    else 
		{
	          echo "Sorry that item couldn't be found. ";
	          echo "<a href=browse.php> Browse Items</a> ";
	    }
		?>	
	</div>

  </body>
</html>
