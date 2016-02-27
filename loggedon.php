<?php include 'database.php'; ?>
<?php
   session_start();
?>
<html>
<head>
 <title>Hello World</title>
</head>
<body>
<?php
$email = $_SESSION['username'];
      $query = "SELECT first_name FROM t_users WHERE email = '" . $email . "'";
      $result = mysqli_query($connection,$query)
        or die('Error making select users query' . mysql_error());
	$row = mysqli_fetch_array($result);
	$name = $row['first_name'];
	
echo "Welcome " . $name;
?>
<br>
<br>
<a href = "logout.php" tite = "Logout">Logout</a>


</body>
</html>