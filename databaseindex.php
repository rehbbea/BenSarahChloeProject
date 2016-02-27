<?php include 'database.php'; ?>
<?php
   session_start();
?>
<!doctype html>
<html>
  <head>
    <meta charset="utf-8"/>
    <title>Login</title>
	<!--
    <link rel="stylesheet" href="css/style.css" type="text/css">
	-->
  </head>
  <body>
   <h2>Enter Email and Password</h2> 
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
      
         <form class = "form-signin" role = "form" 
            action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']); 
            ?>" method = "post">
            <h4 class = "form-signin-heading"><?php echo $msg; ?></h4>
            <input type = "text" class = "form-control" 
               name = "username" placeholder = "email address" 
               required autofocus></br>
            <input type = "password" class = "form-control"
               name = "password" placeholder = "password" required>
            <button class = "btn btn-lg btn-primary btn-block" type = "submit" 
               name = "login">Login</button>
         </form>
         
      </div> 
  
  </body>
</html>
