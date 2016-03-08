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

	<h3> Browse items</h3> 

      <div>
		<div class = "container"> 
         <form class = "form-search" role = "form" 
            action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']); 
            ?>" method = "post">
            <h4 class = "form-search-heading"></h4>
			<p>Choose a category: <select name="category">
				<option value="0">Category</option>
				<option value="1">Clothing</option>
				<option value="2">Leisure</option>
				<option value="3">Electronics</option>
				<option value="4">Collectables</option>
				<option value="5">Jewellery</option>	
				<option value="6">Home and Garden</option>
				<option value="7">Miscellaneous/Other</option>					
				</select><label> or search by keyword:</label></select>
				<input type = "text" class = "form-control" 
               name = "search" placeholder = "What are you looking for?" >
			 <button class = "btn btn-lg btn-primary btn-block" type = "submit" 
               name = "searchbtn">Go</button>
				 </p>				
    </div>

	
         </form>
		 </div>	  

         <?php
		 include 'database.php'; 
			$defaultq="SELECT u.d_name, a.date_listed, a.date_expires, a.item_name, a.auction_id, c.cat_desc, a.description, h.currentval 
			FROM (SELECT auctionid, max(`amount`) as currentval FROM (SELECT auctionid, amount from t_bids UNION SELECT auction_id, start_price from t_auctions) as b GROUP BY auctionid) as h RIGHT JOIN t_auctions as a ON a.auction_id=h.auctionid, t_sellers as s, t_users as u, t_cat as c where a.seller_id =s.user_id AND s.user_id=u.user_id AND a.cat= c.cat_id AND
			date_expires>NOW() ORDER BY(date_expires);";
			$currentq=$defaultq;
		
			/*If the search button is used, then the query sourcing the display table is updated*/
			if (isset($_POST['searchbtn'])  && !empty($_POST['search'])) {
			$search = $_POST['search'];
	        $lookup = "SELECT u.d_name, a.date_listed, a.date_expires, a.item_name, a.auction_id, c.cat_desc, a.description, h.currentval 
			FROM (SELECT auctionid, max(`amount`) as currentval FROM `t_bids` GROUP BY auctionid) as h RIGHT JOIN t_auctions as a ON a.auction_id=h.auctionid, t_sellers as s, t_users as u, t_cat as c 
			where a.seller_id =s.user_id AND s.user_id=u.user_id AND a.cat= c.cat_id AND
			date_expires>NOW() AND (lower(description) like lower('%" . $search . "%') OR lower(item_name) like lower('%" . $search . "%')) ORDER BY (date_expires);";
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
		FROM (SELECT auctionid, max(`amount`) as currentval FROM (SELECT auctionid, amount from t_bids UNION SELECT auction_id, start_price from t_auctions) as b GROUP BY auctionid) as h RIGHT JOIN t_auctions as a ON a.auction_id=h.auctionid, t_sellers as s, t_users as u, t_cat as c where a.seller_id =s.user_id AND s.user_id=u.user_id AND a.cat= c.cat_id AND a.cat =" . $cat . " AND date_expires>NOW() ORDER BY(date_expires);";
	        if(!mysqli_query($connection, $lookup) | mysqli_query($connection, $lookup)->num_rows < 1) {
				echo "Sorry, there is nothing under that description";
			}
							$currentq=$lookup;
			}
		
		
		

			
            
      function drawTableContents($query){
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