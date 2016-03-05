<?php require 'database.php'; ?>
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
                  
                     header('Refresh: 0; URL = browse.php');
			}

            }
         ?>
      </div> <!-- /container -->

      <div class = "container">

         <form class = "form-signin" role = "form" 
            action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']); 
            ?>" method = "post">
            <h4 class = "form-signin-heading"><?php echo $msg; ?></h4>
			<p><label>Email:</label></p>
            <p><input type = "text" class = "form-control" 
               name = "username" placeholder = "email address" 
               required autofocus></p>
			<p><label>Password:</label></p>
            <p><input type = "password" class = "form-control"
               name = "password" placeholder = "password" required>
           </p> 
			<td align="center"><p><button class = "btn btn-lg btn-primary btn-block" type = "submit" 
               name = "login">Login</button></p>
			   
         </form>
       <p>Don't have an account? sign up here</p>  
		 
      </div> 
	</div>
	<div id=footer> Created by us bblah blah blah</div>
  </body>
</html>
