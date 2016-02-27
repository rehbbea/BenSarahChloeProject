<?php include 'database.php'; ?>

<?php
   session_start();
   unset($_SESSION["username"]);
   unset($_SESSION["password"]);
   mysqli_close($connection);
   
   header('Refresh: 1; URL = databaseindex.php');
?>
