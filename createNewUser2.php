<?php include 'database.php'; ?>
<?php
   session_start();
?>
<!doctype html>
<html>
  <head>
    <meta charset="utf-8"/>
    <title>Login</title>
	<style>

		h2 {color:#13420A; 
			font-family: verdana}
		h3 {font-family: verdana;
			color:19570D;}
		h4 {font-family: verdana;
			color:19570D}
		p {color:19570D;
			font-family: verdana;}

		#header {
			background-color:#DAF5D5;
			font-family: verdana
			color:#DEF5DA;
			text-align:center;
			padding:5px;
			}
		#nav {
			line-height:30px;
			background-color:#9BD490;
			font-family: verdana
			color:19570D;
			height:350px;
			width:100px;
			float:left;
			padding:5px; 
			}
		#section {
			color:19570D;
			font-family: verdana
			width:450px;
			float:left;
			padding:10px; 
			}
		#footer {
			background-color:9BD490;
			font-family: verdana
			color:black;
			clear:both;
			text-align:center;
			padding:5px; 
			}
	</style>
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
	<h3>Register</h3> 
      <div>
         <?php
            $msg = '';
       function isDataValid()
			{           
				if (isset($_POST['signup']) && !empty($_POST['username']) && !empty($_POST['firstName']) && !empty($_POST['lastName'])   
					&& !empty($_POST['d_name'])  && !empty($_POST['password'])) {
			      $user = array();
					$user['firstName'] = $_POST['firstName'];
					$user['lastName'] = $_POST['lastName'];
					$user['email'] = $_POST['username'];
					$user['d_name'] = $_POST['d_name'];
					$user['password'] = $_POST['password'];
					
					$checkunique =  "SELECT email FROM t_users WHERE email = '${user['email']}';";
					$checkdisplay =  "SELECT d_name FROM t_users WHERE d_name = '${user['d_name']}';";
					$connection = mysqli_connect("localhost", "root", "PAmG7Up6wy2ZcEAu", "auctions");
					$email = filter_var($user['email'], FILTER_SANITIZE_EMAIL);
					if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
							echo "<h4>That email address is not valid</h4>";
							return False;
							}
					if (mysqli_query($connection, $checkunique)->num_rows >0) {
						$msg = 'There is already an account for that email address';
						$emailnotused=0;
						echo "<h4>That email address is already in use</h4>";
						return False;
					}
					else
						{$emailnotused=1;}
					if (mysqli_query($connection, $checkdisplay)->num_rows >0) {
						$msg = 'There is already an account for that display name';	
						$namenotused = 0;
						echo "<h4>That display name is already in use</h4>";
						return False;
					}
					else
						{$namenotused = 1;}
					if ($namenotused=1 AND $emailnotused=1){
						return True;}
					else {return False;}
				}
				else {return False;}	
				mysqli_close($connection);/**/
			}
		function getUser()	
			{
			      $user = array();
					$user['firstName'] = $_POST['firstName'];
					$user['lastName'] = $_POST['lastName'];
					$user['email'] = $_POST['username'];
					$user['d_name'] = $_POST['d_name'];
					$user['password'] = $_POST['password'];
				return $user;
			}
      function saveToDatabase($user)
		{
		$connection = mysqli_connect("localhost", "root", "PAmG7Up6wy2ZcEAu", "auctions");
		 /*introduce password hashing here*/
 		$query = "INSERT INTO t_users(first_name, last_name, p_word, d_name, email) ".
				"VALUES ('${user['firstName']}', '${user['lastName']}', SHA('${user['password']}'),".
				" '${user['d_name']}','${user['email']}');";
        $result = mysqli_query($connection, $query)
          or die('Error making saveToDatabase query' . mysql_error());
        mysqli_close($connection);
      }	
    if (isDataValid()==True)
      {
        $newUser = getUser();
        saveToDatabase($newUser);
        echo "<h2>User added</h2>";
		
      }
         ?>
      </div> <!-- /container -->

      <div class = "container">
     <table> 
         <form class = "form-signin" role = "form" 
            action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']); 
            ?>" method = "post">
            <h4 class = "form-signin-heading"><?php echo $msg; ?></h4>
	<!--	<td><p><label>First Name:</label></p></td>-->
			<td><p><input type='text' name='firstName' size='40' placeholder = "First name" required></p></td></tr>
	<!--	<td><p><label>Last Name:</label></p></td>-->
			<td><p><input type='text' name='lastName' size='40' placeholder = "Last name" required></p></td></tr>
	<!--	<td><p><label>Email:</label></p></td>-->
            <td><p><input type = "text" size='40' name = "username" placeholder = "Email address" 
               required></td></p></tr>
	<!--	<td><p><label>Choose a username to display:</label></p></td>-->
			<td><p><input type='text' name='d_name' size='40' placeholder = "Choose a username to display" required></p></td></tr>
	<!--	<td><p><label>Password:</label></p></td>-->
            <td><p><input type = "password" name = "password" placeholder = "password" required></td>
           </p> </tr>
			<td align="center"><p><button class = "btn btn-lg btn-primary btn-block" type = "submit" 
               name = "signup">Sign Up</button></p></td></tr>
			   </table>
         </form>
 
		 
      </div> 
	</div>
	<div id=footer> Created by us bblah blah blah</div>
  </body>
</html>
