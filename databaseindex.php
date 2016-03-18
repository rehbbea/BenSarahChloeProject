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
<!-- template.php contains the header and nav bar-->
<?php include 'template.php';?>
	<h3>Sign in</h3> 
      <div>
         <?php
            $msg = '';
            
            if (isset($_POST['login']) && !empty($_POST['username']) 
               && !empty($_POST['password'])) {
                        $user = $_POST['username'];
                        $password = $_POST['password'];
                $lookup = "SELECT * FROM t_users WHERE email = '" . $user . "'";
                $result = mysqli_query($connection,$lookup);
                if(!$result | $result->num_rows < 1) {
                                unset($_SESSION["username"]);
                                unset($_SESSION["password"]);
                                $msg = 'Incorrect username or password';
                        }
                        else
                        {
                             $row = mysqli_fetch_array($result);
                             $pword = $row['p_word'];
                             if(password_verify($password, $pword))
                             {

                                $_SESSION['valid'] = true;
                  $_SESSION['timeout'] = time();
                  $_SESSION['username'] = $user;

                     header('Refresh: 0; URL = browse.php');
                             }
                             else
                             {
                                unset($_SESSION["username"]);
                                unset($_SESSION["password"]);
                                $msg = 'Incorrect username or password';
                             }
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
       <p>Don't have an account? <a href ="createNewUser2.php">Sign up here</p></a>  
		 
      </div> 
	</div>
	
  </body>
</html>
