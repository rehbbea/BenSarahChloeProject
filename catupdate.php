<?php
function chooseCat($cat){
	echo "Category";
	if (!is_null($cat) && !empty($cat)){
	include 'database.php'; 
		
	$lookup = "SELECT u.d_name, a.date_listed, a.date_expires, a.item_name, c.cat_desc, a.description, a.highest_bid 
		FROM (t_auctions as a JOIN t_sellers as s) JOIN t_users as u, t_cat as c
		WHERE a.seller_id =s.user_id AND s.user_id=u.user_id AND a.cat= c.cat_id AND
		date_expires>NOW() AND a.cat=" . $cat . " ORDER BY(date_expires);";
		if(!mysqli_query($connection, $lookup) | mysqli_query($connection, $lookup)->num_rows < 1) {
		echo "Sorry, there is nothing in that category";
		}
		else
		{
		$currentq=$lookup;
				
			}
			}
			}
			/?>