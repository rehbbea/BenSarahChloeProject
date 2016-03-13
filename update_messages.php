<?php include 'database.php';

/*All won auctions. Message type = 4 */
/*Get won items */
 /* Send sellers a message when their auction expires but item not sold Message type 5*/
$notsoldupdate= "INSERT INTO t_emails (user_id, msgtype, auction_id, message, is_read) SELECT s.user_id, 5, a.auction_id, CONCAT(\"Sorry, the auction on your item \", a.item_name, \" was  not successful\"), 0 FROM (SELECT b.auctionid, amount as currentval, us.d_name FROM (SELECT auctionid, max(amount) as top from t_bids group by auctionid) as m, `t_bids` as b, t_users as us WHERE b.buyer_id=us.user_id AND m.top=b.amount AND m.auctionid=b.auctionid) as h RIGHT JOIN t_auctions as a ON	a.auction_id=h.auctionid, t_sellers as s, t_users as u, t_cat as c where a.seller_id =s.user_id AND s.user_id=u.user_id AND a.cat= c.cat_id AND date_expires<NOW() AND h.currentval< a.reserve_price AND CONCAT(s.user_id, \"_\", a.auction_id, \"_\", \"5\") NOT IN (SELECT CONCAT(e.user_id, \"_\" , e.auction_id, \"_\", e.msgtype) FROM t_emails as e);";

 /*Send sellers a message when their auction expires and item sold. Message type 4*/
$solditemupdate= "INSERT INTO t_emails (user_id, msgtype, auction_id, message, is_read) SELECT s.user_id, 4, a.auction_id, CONCAT(\"Congratulations, the auction on your item \", a.item_name, \" was successful. The winning bid was £\", FORMAT(h.currentval, 'G', 'en-us'), \" placed by \", h.d_name), 0 FROM (SELECT b.auctionid, amount as currentval, us.d_name FROM (SELECT auctionid, max(amount) as top from t_bids group by auctionid) as m, `t_bids` as b, t_users as us WHERE b.buyer_id=us.user_id AND m.top=b.amount AND m.auctionid=b.auctionid) as h RIGHT JOIN t_auctions as a ON	a.auction_id=h.auctionid, t_sellers as s, t_users as u, t_cat as c where a.seller_id =s.user_id AND s.user_id=u.user_id AND a.cat= c.cat_id AND date_expires<NOW() AND h.currentval>a.reserve_price AND CONCAT(s.user_id, \"_\", a.auction_id, \"_\", \"4\") NOT IN (SELECT CONCAT(e.user_id, \"_\" , e.auction_id, \"_\", e.msgtype) FROM t_emails as e);";

 /*Send buyers a message when their bid is successful. Message type 3*/
$wonitemupdate="INSERT INTO t_emails (user_id, msgtype, auction_id, message, is_read) SELECT m.buyer, 3, a.auction_id, CONCAT(\"Congratulations, the your bid on item \", a.item_name, \" was successful. Your winning bid was £\", FORMAT(currentval, 'G', 'en-us')), 0 FROM 
(SELECT auctionid, max(amount) as currentval, buyer_id as buyer from t_bids group by auctionid) as m, t_bids as b, t_users as us, t_auctions as a WHERE m.buyer=us.user_id AND a.auction_id=b.auctionid AND b.amount=currentval
AND date_expires<NOW() AND a.reserve_price<currentval AND CONCAT(s.user_id, \"_\", a.auction_id, \"_\", \"3\") NOT IN (SELECT CONCAT(e.user_id, \"_\" , e.auction_id, \"_\", e.msgtype) FROM t_emails as e);";

/*Tell bidders on an auction that it is ending soon. Message type 1*/
$endingsoonbid="INSERT INTO t_emails (user_id, msgtype, auction_id, message, is_read) SELECT b.buyer_id, 1, t.auction_id, CONCAT(\"The auction on item \", t.item_name, \" is ending soon\"), 0
FROM (SELECT timestampdiff(minute,now(),`date_expires`) as timetogo, auction_id, date_expires, item_name FROM t_auctions) as t,  (SELECT auctionid, buyer_id, max(amount) as max from t_bids group by auctionid, buyer_id) as b WHERE b.auctionid=t.auction_id and date_expires>NOW() AND t.timetogo<30 AND CONCAT(b.buyer_id, \"_\", t.auction_id, \"_\", \"1\") NOT IN (SELECT CONCAT(e.user_id, \"_\" , e.auction_id, \"_\", e.msgtype) FROM t_emails as e);";

/*Tell watchers on an auction that it is ending soon Message type 1*/
$endingsoonwatch="INSERT INTO t_emails (user_id, msgtype, auction_id, message, is_read) SELECT w.user_id, 1, t.auction_id, CONCAT(\"The auction on item \", t.item_name, \" is ending soon\"), 0
FROM (SELECT timestampdiff(minute,now(),`date_expires`) as timetogo, auction_id, date_expires, item_name FROM t_auctions) as t, t_watchlist as w WHERE w.auctionid=t.auction_id and date_expires>NOW() AND t.timetogo<30 AND CONCAT(w.user_id, \"_\", a.auction_id, \"_\", \"1\") NOT IN (SELECT CONCAT(e.user_id, \"_\" , e.auction_id, \"_\", e.msgtype) FROM t_emails as e);";


 mysqli_query($connection, $notsoldupdate);
 mysqli_query($connection, $wonitemupdate);
 mysqli_query($connection, $solditemupdate);
 mysqli_query($connection, $endingsoonbid);
 mysqli_query($connection, $endingsoonwatch);
 /*mysqli_query($connection, $outbid);	*/ 
$sendemailquery = "SELECT message_id, msgtype, auction_id, message, is_read, email FROM t_emails LEFT JOIN t_users ON (t_emails.user_id = t_users.user_id) WHERE is_sent = 0 LIMIT 1";
$emailresult = mysqli_query($connection,$sendemailquery);
if(!empty($emailresult))
{
    $emailrow = mysqli_fetch_array($emailresult);
    if(!empty($emailrow))
    {
        $type = $emailrow['msgtype'];
        $emailbody = $emailrow['message'];
        $to_address = $emailrow['email'];
        $message_id = $emailrow['message_id'];
        if($type == 5)
        {
             $subject = "Item not sold.";
        }
        if($type == 4)
        {
            $subject = "";
        }
        if($type == 3)
        {
            $subject = "";
        }
        if($type == 2)
        {
            $subject = "";
        }
        if($type == 1)
        {
            $subject = "Auction ending soon.";
        }
        $emailfile = fopen("email.txt", "w") or die("Unable to open file!");
        $subjline = "Subject: " . $subject . "\n";
        fwrite($emailfile, $subjline);
        $fromline = "From: Watchlist@buymytat.com\n\n";
        fwrite($emailfile, $fromline);
        $textline = $emailbody;
        fwrite($emailfile, $textline);
        fclose($emailfile);
        $command = "sendmail " . $to_address . " < email.txt";
        shell_exec($command);
       $emailsent = "UPDATE t_emails SET is_sent = 1 WHERE message_id = " . $message_id;
       mysqli_query($connection, $emailsent);
    }
}
 
?>