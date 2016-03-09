
<?php
	if (isset($_GET['item'])&& isset($_SESSION['username'])){
			$item_id = $_GET['item'];
			$email = $_SESSION['username'];
      $query = "SELECT user_id FROM t_users WHERE email = '" . $email . "'";
      $result = mysqli_query($connection,$query)
        or die('Error making select users query' . mysql_error());
		$row = mysqli_fetch_array($result);
		$user_id = $row['user_id'];
		
		$lookupitem="SELECT pageviews, seller_id from t_auctions WHERE auction_id=".$item_id;		
		$lookupresult = mysqli_query($connection,$lookupitem)
			or die('Error making find owner query' . mysql_error());
		$pages = mysqli_fetch_array($lookupresult);
		$owner = $pages['seller_id'];
		$pageview=  $pages['pageviews'];
		if (!($owner==$user_id)){
		$addapageview = "UPDATE t_auctions SET pageviews = (". $pageview ." + 1) WHERE auction_id=".$item_id;
		
		$addpage = mysqli_query($connection,$addapageview)
			or die('Error making find owner query' . mysql_error());	
		}
		
	}
	
	?>