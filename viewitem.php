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
				     $newurl = "viewitem.php?item=" . $item_id;
					 header('Refresh: 1; URL = ' . $newurl);
					 exit;
				}			
	
		}
	
			$query = "SELECT u.d_name, u.user_id, a.date_listed, s.seller_rep, a.date_expires as expire_date, date_expires-NOW() as hours_to_expire, timediff(date_expires, NOW()) as hours_to_go, a.reserve_price, a.item_name, c.cat_desc, a.description, h.currentval, h.d_name as buyer
			FROM (SELECT auctionid, max(`amount`) as currentval, d_name FROM `t_bids` as b, t_users as us WHERE b.buyer_id=us.user_id GROUP BY auctionid) as h RIGHT JOIN t_auctions as a ON a.auction_id=h.auctionid, t_sellers as s, t_users as u, t_cat as c 
			WHERE auction_id = " . $item_id ." AND c.cat_id = a.cat;";

			$result = mysqli_query($connection,$query)
		        or die('No such item.' . mysql_error());
			$row = mysqli_fetch_array($result);
			$seller = $row['d_name'];
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
			$step = '0.01';
			if (empty($currentval)||($currentval)==0){
			$currentval=0;
			$winnersofar="No one has bid yet";
			}
			if (empty($winnersofar)){
			$winnersofar="No one has bid yet";
			}
			$currprice = number_format($currentval,2);
			$image = 'http://i.imgur.com/S2N3B.png';
			echo "<table id='t01'> <tr><td>	Category:" . $catdesc . "</td></tr>";
			echo "<tr> <td></html><h3>" . $itemname . "</h3><html> </td>";
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
					 echo "Congratulations your item has sold to " . $winnername . " For $" . $currentval . "<br>";
					 echo "Please get in touch with them at " . $winneremail . "to arrange payment and delivery.";
					 echo "<br>You can rate your buyer below.<br>";
				     echo "<a href=\"ratebuyer.php?item=" . $item_id . "?star=1\" ><img src=\"http://i.imgur.com/p7omcv4.png\" onmouseover=\"this.src='http://i.imgur.com/TWPqI6x.png'\" onmouseout=\"this.src='http://i.imgur.com/p7omcv4.png'\"  /></a>";
				     echo "<a href=\"ratebuyer.php?item=" . $item_id . "?star=2\" ><img src=\"http://i.imgur.com/p7omcv4.png\" onmouseover=\"this.src='http://i.imgur.com/TWPqI6x.png'\" onmouseout=\"this.src='http://i.imgur.com/p7omcv4.png'\"  /></a>";
				     echo "<a href=\"ratebuyer.php?item=" . $item_id . "?star=3\" ><img src=\"http://i.imgur.com/p7omcv4.png\" onmouseover=\"this.src='http://i.imgur.com/TWPqI6x.png'\" onmouseout=\"this.src='http://i.imgur.com/p7omcv4.png'\"  /></a>";
				     echo "<a href=\"ratebuyer.php?item=" . $item_id . "?star=4\" ><img src=\"http://i.imgur.com/p7omcv4.png\" onmouseover=\"this.src='http://i.imgur.com/TWPqI6x.png'\" onmouseout=\"this.src='http://i.imgur.com/p7omcv4.png'\"  /></a>";
				     echo "<a href=\"ratebuyer.php?item=" . $item_id . "?star=5\" ><img src=\"http://i.imgur.com/p7omcv4.png\" onmouseover=\"this.src='http://i.imgur.com/TWPqI6x.png'\" onmouseout=\"this.src='http://i.imgur.com/p7omcv4.png'\"  /></a>";
					 	
					 exit;
				 }
				 else if($userid == $winnerid)
				 {
					 $detailsquery = "SELECT d_name, email FROM t_users WHERE user_id = " . $sellerid;
					 $detailsresult = mysqli_query($connection, $detailsquery);
					 $detailsrow = mysqli_fetch_array($detailsresult);
					 $sellername = $detailsrow['d_name'];
					 $selleremail = $detailsrow['email'];
					 echo "Congratulations you have won the bid for $" . $currentval . "<br>";
					 echo "Please get in touch with " . $sellername ." at " . $selleremail . "to arrange payment and delivery.";
					 echo "<br>You can rate your seller below.<br>";
					 echo "<a href=\"ratebuyer.php?item=" . $item_id . "?star=1\" ><img src=\"http://i.imgur.com/p7omcv4.png\" onmouseover=\"this.src='http://i.imgur.com/TWPqI6x.png'\" onmouseout=\"this.src='http://i.imgur.com/p7omcv4.png'\"  /></a>";
				     echo "<a href=\"ratebuyer.php?item=" . $item_id . "?star=2\" ><img src=\"http://i.imgur.com/p7omcv4.png\" onmouseover=\"this.src='http://i.imgur.com/TWPqI6x.png'\" onmouseout=\"this.src='http://i.imgur.com/p7omcv4.png'\"  /></a>";
				     echo "<a href=\"ratebuyer.php?item=" . $item_id . "?star=3\" ><img src=\"http://i.imgur.com/p7omcv4.png\" onmouseover=\"this.src='http://i.imgur.com/TWPqI6x.png'\" onmouseout=\"this.src='http://i.imgur.com/p7omcv4.png'\"  /></a>";
				     echo "<a href=\"ratebuyer.php?item=" . $item_id . "?star=4\" ><img src=\"http://i.imgur.com/p7omcv4.png\" onmouseover=\"this.src='http://i.imgur.com/TWPqI6x.png'\" onmouseout=\"this.src='http://i.imgur.com/p7omcv4.png'\"  /></a>";
				     echo "<a href=\"ratebuyer.php?item=" . $item_id . "?star=5\" ><img src=\"http://i.imgur.com/p7omcv4.png\" onmouseover=\"this.src='http://i.imgur.com/TWPqI6x.png'\" onmouseout=\"this.src='http://i.imgur.com/p7omcv4.png'\"  /></a>";
					 exit;
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
			<align=\"center\"><p><td><button class = \"btn btn-lg btn-primary btn-block\" type = \"submit\" 
               name = \"addbid\">Bid</button></p></td></tr>
         </form>";
			
			
			if(mysqli_query($connection, $watchquery)->num_rows < 1)
			{
				echo "<a href=addtowatchlist.php?item=" . $item_id ."><td>Add to Watchlist</td></tr></table></a> ";
			}
			else
			{
				echo "<a href=removefromwatchlist.php?item=" . $item_id ."><td>Remove from Watchlist</td></tr></table></a> ";
			}
			}
			else {echo "</table>";}
			echo "<img src=\"" . $image . "\">";
			
		}
	    else 
		{
	          echo "Sorry that item couldn't be found. ";
	          echo "<a href=browse.php> Browse Items</a> ";
	    }
		?>	
	</div>
	<div id=footer> Created by us bblah blah blah</div>
  </body>
</html>