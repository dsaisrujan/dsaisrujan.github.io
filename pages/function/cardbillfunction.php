<?php
include_once '../../includes/db_connect.php';

$pages="";
define('MAX_REC_PER_PAGE',10); 

function cardname($ctype,$cardnumber,$name,$nofunits,$price,$amt,$date,$userid) {
 
   $query= "SELECT 	card_type  FROM customer_card  WHERE upper(card_type) = trim(upper('$ctype')) and upper(card_number) = trim(upper('$cardnumber')) and upper(name) = trim(upper('$name')) and upper(no_of_units) = trim(upper('$nofunits')) and upper(price) = trim(upper('$price')) and upper(	amount) = trim(upper('$amt'))  and upper(date)=upper('$date') and  upper(user_id)=upper('$userid')" ;

   $result=mysql_query($query);
$num=mysql_numrows($result);

    if ($result) {
         
        if ($num > 0) {
            return false;
        } else {
            return true;
        }

    }
}
   
function cardmaster($billno,$ctype,$cardnumber,$name,$nofunits,$price,$amt,$date,$userid) {
$res = ''; 

	
// echo  $query;
 $query =  "INSERT INTO `customer_card`(`card_type`, `card_number`, `name`, `no_of_units`, `price`, `amount`, `date`, `user_id`) VALUES ('$ctype','$cardnumber','$name','$nofunits','$price','$amt','$date','$userid')" ;
 

echo $query;
	
           $result=mysql_query($query);
		   	$res = 'Your Data was created.'; 
      

}

