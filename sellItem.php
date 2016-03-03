<?php include 'database.php'; ?>
<?php
   session_start();
?>
<!doctype html>
<html>
  <head>
    <meta charset="utf-8"/>
    <title>Sell some tat</title>
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
/*Hmmm, so I don't want to ask the user their name because they should be logged in but I don't get the mechanism behind that 
and it is too late now to work on it anymore tonight*/
      </div> <!-- /container -->

      <div class = "container">
     <table> 
         <form class = "form-newItem" role = "form" 
            action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']); 
            ?>" method = "post">
            <h4 class = "form-additem-heading"><?php echo $msg; ?></h4>
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
			<td><p><input type='date(format,timestamp)' name='date_expires' placeholder = "When do you want the auction to finish?" required></p></td></tr>
			<td><p><input type='text' name='reserve' size='40' placeholder = "Reserve Price" required></p></td></tr>
            <td><p><input type = "text" size='40' name = "item_name" placeholder = "Name of item" 
               required></td></p></tr>
			   <select name="choose a category">	
				<option value="1">Clothing</option>
				<option value="2">Leisure</option>
				<option value="3">Electronics</option>
				<option value="4">Collectables</option>
				<option value="5">Jewellery</option>	
				<option value="4">Home and Garden</option>
				<option value="5">Miscellaneous/Other</option>					
				</select><br />
			<td><p><input type='message' name='description' size='40' placeholder = "Item description"  rows="10" cols="30"></p></td></tr>
			<td><p><input type='message' name='start_price' size='40' placeholder = "Start price" ></p></td>			
           </p> </tr>
			<td align="center"><p><button class = "btn btn-lg btn-primary btn-block" type = "submit" 
               name = "additem">Add Item</button></p></td></tr>
			   </table>
         </form>
 
		 
      </div> 
	</div>
	<div id=footer> Created by us bblah blah blah</div>
  </body>
</html>
