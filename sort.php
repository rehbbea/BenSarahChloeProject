		<div class = "container"> 
         <form class = "form-filter" role = "form" 
            action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']); 
            ?>" method = "post">
            <h4 class = "form-search-heading"></h4>
			<p align="right">Sort by: <select name="sort_by">
				<option value="1">Finishing soon</option>
				<option value="2">Most recent</option>
				<option value="3">Price (low to high)</option>
				<option value="4">Price (high to low)</option></select>
			 <button class = "btn btn-lg btn-primary btn-block" type = "submit" 
               name = "sortbtn">Sort</button>
				 </p>				
    </div>
