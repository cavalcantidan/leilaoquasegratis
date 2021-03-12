<?php
	include("config/connect.php");
	include("functions.php");

	$aucid=$_POST["id_leilao"];
    $uid = $_SESSION["userid"];
    $Hist_geral  = '';
    $Hist_meu  = '';

    $qry = "select * from bid_account ba left join 
            auction a on ba.auction_id=a.auctionID left join 
            registration r on ba.user_id=r.id 
            where ba.auction_id='$aucid' and ba.bid_flag='d'";
    $order_by = ' order by ba.id desc limit 0,10';

	$reshis = mysql_query($qry.$order_by) or die(mysql_error());
	$total  = mysql_num_rows($reshis);

	for($i=1;$i<=$total;$i++){
		$obj = mysql_fetch_object($reshis);
		if($Hist_geral!='') $Hist_geral .= ',';

		$Hist_geral .=  '{"history":{"bprice":"'.$obj->bidding_price.'","time":"'.substr($obj->bidpack_buy_date,10).'","username":"'.$obj->username.'"}}';
	}
	
           
    if($uid!=''){
	    $reshis1 = mysql_query($qry." and ba.user_id='{$uid}'".$order_by) or die(mysql_error());
	    $total1  = mysql_num_rows($reshis1);
        
	    for($i=1;$i<=$total1;$i++){
		    $obj1 = mysql_fetch_object($reshis1);
		    if($Hist_meu!='') $Hist_meu .= ',';

		    $Hist_meu .= '{"myhistory":{"bprice":"'.$obj1->bidding_price.'","time":"'.substr($obj1->bidpack_buy_date,10).'"}}';
	    }  
    }     

	echo '{"histories":['.$Hist_geral.'],"myhistories":['.$Hist_meu.']}';
?>