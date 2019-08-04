<?php
include_once '../../includes/db_connect.php';

$pages="";
define('MAX_REC_PER_PAGE',10); 


function petroldip($sno,$dip,$volume,$diff,$status) {
 
   $query= "SELECT dip   FROM  petrol_dip 
                             WHERE upper(sno) = trim(upper('$sno')) and upper(dip) = trim(upper('$dip')) and upper(volume) = trim(upper('$volume')) and upper(diff) = trim(upper('$diff')) and upper(status) = trim(upper('$status'))";
							 //echo $query;
   $result=mysql_query($query);
$num=mysql_numrows($result);

    if ($result) {
         
        if ($num >0) {
            return false;
        } else {
            return true;
        }

    }
}
   

function petroldipmaster($sno,$dip,$dtype,$pdtank,$volume,$diff,$userid,$cdate,$status) {
$res = ''; 
 $query3= "SELECT dip_type FROM petrol_dip WHERE sno ='$sno'";
 //echo $query3;
     $result=mysql_query($query3);
	  $num=mysql_numrows($result);
 $query =  "INSERT INTO `petrol_dip`(`dip`, `dip_type`, `pd_tank`, `volume`, `diff`, `c_user`, `c_date`, `status`) VALUES ('$dip','$dtype','$pdtank','$volume','$diff','$userid',now(),'$status')" ;
 //echo $query;
 $query1 = "update petrol_dip set dip='$dip', dip_type='$dtype',pd_tank='$pdtank',volume='$volume',diff='$diff',c_user='$userid',c_date=now(),status='$status' where sno='$sno'";
 //echo $query1; 
	 if ($num > 0) {
            $result=mysql_query($query1);
			$res = 'Your Data was updated.'; 
        } else {
           $result=mysql_query($query);
		   	$res = 'Your Data was created.'; 
        }
  
	return 	$res; 
}

function petrolgrid() {
$res = ''; 

	$rs = mysql_query("SELECT COUNT(*) FROM petrol_dip") or die("Count query error!");
  list($total) = mysql_fetch_row($rs);
  $total_pages = ceil($total / MAX_REC_PER_PAGE);
  $page = intval(@$_GET["page"]); 
  if (0 == $page){   $page = 1;   }  
  $start = MAX_REC_PER_PAGE * ($page - 1);
  $max = MAX_REC_PER_PAGE;
    
  $res .= '<div class="box box-primary">
                                <div class="box-header">
                                    <i class="ion ion-clipboard"></i>
                                    <h3 class="box-title"><b>Calibration Chart List</b></h3>';
									
      $res .= '                               <div class="box-tools pull-right"> ';
	    $res .= '                                 <ul class="pagination pagination-sm inline">';
	  $k=$page-1;
		if($total_pages>($page+3)){ $m=$page+1; }
		
		$t =($total_pages>3) ? 3:$total_pages;
		if(($page+3)>$total_pages){ $t = $total_pages - $page;}
	 	if($page>1){ $res .= ' <li align="center"  ><a href="'. $_SERVER["PHP_SELF"] . '?page='.$k.'"  > &lt; &lt;</a> </li> ';}
	for ($i = 0; $i <= $t; $i++) {
  		$txt = $page+$i;
		if($txt==$page){  $res .= ' <li align="center"  ><a href="'. $_SERVER["PHP_SELF"] . '?page='.$txt.'"  ><font color="red">'.$txt.'</font></a> </li> '; }
		else{  	$res .= ' <li align="center"  ><a href="'. $_SERVER["PHP_SELF"] . '?page='.$txt.'"  >'.$txt.'</a> </li> '; }
    }
	if($page>2 && $total_pages>($page+3)){ $res .= ' <li align="center"  ><a href="'. $_SERVER["PHP_SELF"] . '?page='.$m.'"  > &gt; &gt;</a> </li> ';}
  
  
     $res .= '    </ul> ';
										
     $res .= '                                </div> 
                                </div><!-- /.box-header -->
                                <div class="box-body"> ';
		 $res .= '						
                                     <table class="table table-hover">
                                        <tr>
                                            <th>ID</th>
                                            <th>CALIBRATIONS</th>
											<th>DIP TYPE</th>
											<th>DIP ID</th>
											 <th>VOLUME</th>
											<th>DIFFERENCE</th>
											  <th>STATUS</th>
                                        </tr> ';
										
             $select_query =  "SELECT `sno`, `dip`, `dip_type`,(SELECT `produt_name` FROM `product_master` WHERE   `s_id`=c.dip_type)diptype,`pd_tank`,
			(SELECT concat('(DIA)', tank_diameter,',','(LEN)',tank_length,',','(CAP)',capacity)tank FROM `calibration_master` WHERE `s_id`=c.pd_tank)calb,
			 `volume`, `diff`, `c_user`, `c_date`, `status` FROM `petrol_dip` c ORDER BY sno  ASC LIMIT $start, $max " ;
	    //echo $select_query;
	 $i=$start + 1;
    $resultk = mysql_query($select_query);
		    while ($rowk = mysql_fetch_array($resultk)) {
	if($rowk["status"]=="A") $status="Active";
	if($rowk["status"]=="I") $status="InActive";
		
	
	 $res .= '<tr><td align="left"> '.$i.'  </td><td align="left">  '.$rowk["calb"].'   </td><td align="left">  '.$rowk["diptype"].'   </td><td align="left">  '.$rowk["dip"].'   </td><td align="left">  '.$rowk["volume"].'   </td><td align="left">  '.$rowk["diff"].'   </td><td> '.$status.'  </td><td align="center">  <a href="petroldip.php?edm=edit&icode='.$rowk["sno"].'" class="ask"><img src="img/user_edit.png" /></a> &nbsp; <a href="petroldip.php?edm=del&del=dels&icode='.$rowk["sno"].'" class="ask"><img src="img/trash.png" /></a></td></tr>';
			$i=$i+1;
    }
 
		               $res .= '                     </table>
                                </div><!-- /.box-body -->
                              <!--  <div class="box-footer clearfix no-border">
                                    <button class="btn btn-default pull-right"><i class="fa fa-plus"></i> Add item</button>
                                </div>-->
                            </div><!-- /.box --> ';
	return $res;
  
}			
?>	