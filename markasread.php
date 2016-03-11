<?php include 'database.php'; ?>

<?php
   session_start();
   if (isset($_GET['msg'])){
			$message_id = $_GET['msg'];
				 $updatequery = "UPDATE t_emails SET is_read = 1 WHERE  message_id = " . $message_id ;
				 mysqli_query($connection, $updatequery);

				$newurl = "home.php";
				 header('Refresh: 5; URL = ' . $newurl);	
				 echo "Message marked as read";
                 exit;			 
			}
   
  header('Refresh: 1; URL = home.php');
?>