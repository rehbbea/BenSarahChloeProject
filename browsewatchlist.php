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
<?php include 'template.php';?>

	<h3> Your Watchlist</h3> 
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
		 
		include 'searchbar.php';
		 
		 
            $msg = ''; 
		$defaultq="SELECT u.d_name, a.date_listed, a.date_expires, a.item_name, a.auction_id, c.cat_desc, a.description, h.currentval 
		FROM (SELECT auctionid, max(`amount`) as currentval FROM `t_bids` GROUP BY auctionid) as h RIGHT JOIN t_auctions as a ON 			a.auction_id=h.auctionid, t_sellers as s, t_users as u, t_cat as c 
			where a.seller_id =s.user_id AND s.user_id=u.user_id AND a.cat= c.cat_id AND
		date_expires>NOW() AND a.auction_id IN (SELECT auctionid FROM t_watchlist WHERE user_id = " . $userid . ") ORDER BY(date_expires);";
		$currentq=$defaultq;
		?>	
      <div>

         <?php
			/*If the search button is used, then the query sourcing the display table is updated*/
			if (isset($_POST['searchbtn'])  && !empty($_POST['search'])) {
			$search = $_POST['search'];
	        $lookup = "SELECT u.d_name, a.date_listed, a.date_expires, a.item_name, a.auction_id, c.cat_desc, a.description, h.currentval 
			FROM (SELECT auctionid, max(`amount`) as currentval FROM `t_bids` GROUP BY auctionid) as h RIGHT JOIN t_auctions as a ON a.auction_id=h.auctionid, t_sellers as s, t_users as u, t_cat as c 
			where a.seller_id =s.user_id AND s.user_id=u.user_id AND a.cat= c.cat_id AND
			date_expires>NOW() AND a.auction_id IN (SELECT auctionid FROM t_watchlist WHERE user_id = " . $userid . ") AND (lower(description) like lower('%" . $search . "%') OR lower(item_name) like lower('%" . $search . "%')) ORDER BY(date_expires);";
	        if(!mysqli_query($connection, $lookup) | mysqli_query($connection, $lookup)->num_rows < 1) {
				echo "Sorry, there is nothing under that description";
			}
			else
			{
				$currentq=$lookup;
				
			}
            }
			else if (isset($_POST['searchbtn']) &&!($_POST['category']==0)){
			$cat = $_POST['category'];
	        $lookup = "SELECT u.d_name, a.date_listed, a.date_expires, a.item_name, a.auction_id, c.cat_desc, a.description, h.currentval 
			FROM (SELECT auctionid, max(`amount`) as currentval FROM `t_bids` GROUP BY auctionid) as h RIGHT JOIN t_auctions as a ON a.auction_id=h.auctionid, t_sellers as s, t_users as u, t_cat as c 
			where a.seller_id =s.user_id AND s.user_id=u.user_id AND a.cat= c.cat_id AND
			date_expires>NOW() AND a.auction_id IN (SELECT auctionid FROM t_watchlist WHERE user_id = " . $userid . ") AND a.cat =" . $cat . "  ORDER BY(date_expires);";
				        if(!mysqli_query($connection, $lookup) | mysqli_query($connection, $lookup)->num_rows < 1) {
				echo "Sorry, there is nothing under that description";
			}
							$currentq=$lookup;
			}			
			
            
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
		"currentval" => "Highest bid");		
		
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
				else if($column == 'date_expires')
				{
					if 	($row['date_expires']<date('m/d/Y h:i:s a', time())){
						echo "Expired";
					}
					else {
					echo $row['date_expires'];
					}
				
				}
				else if($column == 'currentval')
				{
					echo "£ " . number_format($row['currentval'],2);
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