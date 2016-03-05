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
	<link href="../../stylesheet.css" rel="stylesheet" type="text/css">
  </head>
  <body>
	<div id=header><h2> Buy my tat</h2><br></div>
	<div id=nav> 
	<h4>Sell something</h4>
	<h4>Browse auctions</h4>
	<h4>Watchlist</h4>
	<h4>My Bids</h4>
	<h4>My Auctions</h4></div>
	<div id=section>
	<p align="right"><?php include 'loggedon.php'; ?></p>
	<h3> Browse items</h3> 
         <?php
            $msg = ''; 
		$defaultq="SELECT u.d_name, a.date_listed, a.date_expires, a.item_name, c.cat_desc, a.description, a.highest_bid 
			FROM (t_auctions as a JOIN t_sellers as s) JOIN t_users as u, t_cat as c
			WHERE a.seller_id =s.user_id AND s.user_id=u.user_id AND a.cat= c.cat_id AND
		date_expires>NOW() ORDER BY(date_expires);";
		$currentq=$defaultq
		?>	
      <div>
		<div class = "container"> 
         <form class = "form-search" role = "form" 
            action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']); 
            ?>" method = "post">
            <h4 class = "form-search-heading"></h4>
			<p><label>Search by keyword:</label><input type = "text" class = "form-control" 
               name = "search" placeholder = "What are you looking for?" 
             ><button class = "btn btn-lg btn-primary btn-block" type = "submit" 
               name = "searchbtn">Go!</button></p>

         </form>
		 </div>	  

         <?php
			if (isset($_POST['searchbtn'])  && !empty($_POST['search'])) {
			$search = $_POST['search'];
	        $lookup = "SELECT u.d_name, a.date_listed, a.date_expires, a.item_name, c.cat_desc, a.description, a.highest_bid 
			FROM (t_auctions as a JOIN t_sellers as s) JOIN t_users as u, t_cat as c
			WHERE a.seller_id =s.user_id AND s.user_id=u.user_id AND a.cat= c.cat_id AND
		date_expires>NOW() AND (lower(description) like lower('%" . $search . "%') OR lower(item_name) like lower('%" . $search . "%')) ORDER BY(date_expires);";
	        if(!mysqli_query($connection, $lookup) | mysqli_query($connection, $lookup)->num_rows < 1) {
				echo "Sorry, there is nothing under that description";
			}
			else
			{
				$currentq=$lookup;
				
			}

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
		"highest_bid" => "Highest bid");		
		
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
				
				echo $row[$column];
				echo "</td>";
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
