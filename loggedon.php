
<?php
	if (isset($_SESSION['username'])){
	$email = $_SESSION['username'];
      $query = "SELECT first_name, user_id FROM t_users WHERE email = '" . $email . "'";
      $result = mysqli_query($connection,$query)
        or die('Error making select users query' . mysql_error());
	$row = mysqli_fetch_array($result);
	$name = $row['first_name'];
	$user_id = $row['user_id'];
	
	$getmessages = "SELECT * from t_emails WHERE is_read=0 AND user_id= " .$user_id;
	$msgresult= mysqli_query($connection,$getmessages)
        or die('Error getting messages' . mysql_error());
	$msgrow = mysqli_fetch_array($msgresult);
/*$num_messages=$msgresult->num_rows*/
		if ($msgresult->num_rows>0){
			echo "<a href = \"home.php\">You have ".$msgresult->num_rows." unread messages </a>";
			}
	echo "Welcome " . $name . " ";
	echo "<a href=logout.php>Logout</a>";
			
	}
	else 
	{
	echo "Welcome guest, you are not logged in ";
	echo "<a href=databaseindex.php> Sign in</a> or <a href=createNewUser2.php> Sign up</a> ";
	}
	?>