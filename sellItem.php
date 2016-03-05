<?php include 'database.php'; 
?>

<?php
   session_start();
?>
<!doctype html>
<html>
  <head>
    <meta charset="utf-8"/>
    <title>What's for sale?</title>
	<!-- Include stylesheet-->
	<link href="../../stylesheet.css" rel="stylesheet" type="text/css">
  </head>
<body>
<!-- template.php contains the header and nav bar-->
<?php include 'template.php';?>

	<h3>List an item to sell</h3> 
      <div>
        
<!--Hmmm, so I don't want to ask the user their name because they should be logged in but I don't get the mechanism behind that 
and it is too late now to work on it anymore tonight*/
 /*     </div> <!-- /container --> 

     <div class = "container">

         <form class = "form-newItem" role = "form" 
            action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']); 
            ?>" method = "post">
            <h4 class = "form-newItem-heading"></h4>
		<html>
			<div class="input-append date form_datetime">
			<input size="16" type="text" value="" readonly>
			<span class="add-on"><i class="icon-th"></i></span>
				</div>
 
			<script type="text/javascript">
				$(".form_datetime").datetimepicker({
				format: "dd MM yyyy - hh:ii"
				});
			</script>                
		</html>	
			<p><input type='date(format,timestamp)' name='date_expires' placeholder = "When do you want the auction to finish?" required></p>
			<p><input type='text' name='reserve' size='40' placeholder = "Reserve Price" required></p>
            <p><input type = "text" size='40' name = "item_name" placeholder = "Name of item" 
               required></td></p>
			   <select name="choose a category">	
				<option value="1">Clothing</option>
				<option value="2">Leisure</option>
				<option value="3">Electronics</option>
				<option value="4">Collectables</option>
				<option value="5">Jewellery</option>	
				<option value="4">Home and Garden</option>
				<option value="5">Miscellaneous/Other</option>					
				</select><br />
			<p><input type='message' name='description' size='40' placeholder = "Item description"  rows="10" cols="30"></p>
			<p><input type='message' name='start_price' size='40' placeholder = "Start price" ></p>			
           </p> 
			<td align="center"><p><button class = "btn btn-lg btn-primary btn-block" type = "submit" 
               name = "additem">Add Item</button></p></td></tr>
			   </table>
         </form>
 
		 
      </div> 
	</div>
	<div id=footer> Created by us bblah blah blah</div>
  </body>
</html>
