
<?php
	if (isset($_SESSION['username'])){
	$email = $_SESSION['username'];
      $query = "SELECT first_name FROM t_users WHERE email = '" . $email . "'";
      $result = mysqli_query($connection,$query)
        or die('Error making select users query' . mysql_error());
	$row = mysqli_fetch_array($result);
	$name = $row['first_name'];
	
	echo "Welcome " . $name ;
	echo "<a href=logout.php> Logout</a>";
	}
	else 
	{
	echo "Welcome guest, you are not logged in ";
	echo "<a href=databaseindex.php> Sign in</a> or <a href=createNewUser2.php> Sign up</a> ";
	}
	?>