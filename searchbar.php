      <div>
		<div class = "container"> 
         <form class = "form-search" role = "form" 
            action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']); 
            ?>" method = "post">
            <h4 class = "form-search-heading"></h4>
			<p>Choose a category: <select name="category">
				<option value="0">Category</option>
				<option value="1">Clothing</option>
				<option value="2">Leisure</option>
				<option value="3">Electronics</option>
				<option value="4">Collectables</option>
				<option value="5">Jewellery</option>	
				<option value="6">Home and Garden</option>
				<option value="7">Miscellaneous/Other</option>					
				</select><label> or search by keyword:</label></select>
				<input type = "text" class = "form-control" 
               name = "search" placeholder = "What are you looking for?" >
			 <button class = "btn btn-lg btn-primary btn-block" type = "submit" 
               name = "searchbtn">Go</button>
				 </p>				
    </div>

	
         </form>
		 </div>	