<?php include 'database.php'; ?>
<?php
   session_start();
?>
<!doctype html>
<html>
  <head>
    <meta charset="utf-8"/>
    <title>Login</title>
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
	<h3>Browse items</h3> 
      <div>
	  
         <?php
            $msg = '';


      function findList()
		{
		$connection = mysqli_connect("localhost", "root", "PAmG7Up6wy2ZcEAu", "auctions");
		 /*introduce password hashing here*/
 		$query = "SELECT * FROM t_auctions WHERE date_expires>NOW() ORDER BY(date_expires);";
        $result = mysqli_query($connection, $query)
          or die('Error making saveToDatabase query' . mysql_error());
		 
        mysqli_close($connection);
		return $result;
      }	
    if (!is_null(findList()))
      {
        $results = findList();
        echo "<h4> Results from the query need to go here</h4>";
		
      }
         ?>
      </div> <!-- /container -->

	</div>
	<div id=footer> Created by us bblah blah blah</div>
  </body>
</html>
