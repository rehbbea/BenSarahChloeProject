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
	<h3>Sign in</h3> 
      <div>
         <?php
            $msg = '';
            
            if (isset($_POST['login']) && !empty($_POST['username']) 
               && !empty($_POST['password'])) {
			$user = $_POST['username'];
			$password = $_POST['password'];
	        $lookup = "SELECT * FROM t_users WHERE email = '" . $user . "' AND p_word = '" . $password . "'";
	        if(!mysqli_query($connection, $lookup) | mysqli_query($connection, $lookup)->num_rows < 1) {
				unset($_SESSION["username"]);
				unset($_SESSION["password"]);
				$msg = 'Incorrect username or password';
			}
			else
			{
				$_SESSION['valid'] = true;
                  $_SESSION['timeout'] = time();
                  $_SESSION['username'] = $user;
                  
                     header('Refresh: 0; URL = loggedon.php');
			}

            }
         ?>
      </div> <!-- /container -->

      <div class = "container">
     <table> 
         <form class = "form-signin" role = "form" 
            action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']); 
            ?>" method = "post">
            <h4 class = "form-signin-heading"><?php echo $msg; ?></h4>
			<td><p><label>Email:</label></p></td>
            <td><p><input type = "text" class = "form-control" 
               name = "username" placeholder = "email address" 
               required autofocus></td></p></tr>
			<td><p><label>Password:</label></p></td>
            <td><p><input type = "password" class = "form-control"
               name = "password" placeholder = "password" required></td>
           </p> </tr>
			<td align="center"><p><button class = "btn btn-lg btn-primary btn-block" type = "submit" 
               name = "login">Login</button></p></td></tr>
			   </table>
         </form>
       <p>Don't have an account? sign up here</p>  
		 
      </div> 
	</div>
	<div id=footer> Created by us bblah blah blah</div>
  </body>
</html>
