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

	<h2>View Item</h2> 
	<div>
	<?php
		if (isset($_GET['item'])){
			$item_id = $_GET['item'];
			$query = "SELECT u.d_name, a.date_listed, a.date_expires, a.item_name, c.cat_desc, a.description, h.currentval 
			FROM (SELECT auctionid, max(`amount`) as currentval FROM `t_bids` GROUP BY auctionid) as h RIGHT JOIN t_auctions as a ON a.auction_id=h.auctionid, t_sellers as s, t_users as u, t_cat as c 
			WHERE auction_id = " . $item_id ;
			$result = mysqli_query($connection,$query)
		        or die('No such item.' . mysql_error());
			$row = mysqli_fetch_array($result);
			$itemname = $row['item_name'];
			$catdesc = $row['cat_desc'];
			$desc = $row['description'];
			$currentval = $row['currentval'];
			$image = 'http://i.imgur.com/S2N3B.png';
			
			echo "<h3>" . $itemname . "</h3><br>";
			echo "Category:" . $catdesc . "<br>";
			echo "Current Bid: $" . $currentval  . "<br>";
			echo "Description: " . $desc . "<br><br>";
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
