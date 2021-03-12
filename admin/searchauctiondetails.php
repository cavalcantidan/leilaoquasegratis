<?
	include_once("admin.config.inc.php");
	include("connect.php");
	include("functions.php");
	include("security.php");
	$aucid = $_GET["aid"];

	$qrysmscharge = "select * from general_setting where id='1'";
	$ressmscharge = mysql_query($qrysmscharge);
	$objsmscharge = mysql_fetch_object($ressmscharge);
	$SMSCHARGE = $objsmscharge->smsrateincl;
	$dinarvalue = $objsmscharge->dinars;
	
	$qrysel = "select *,sum(bid_count) as totalbid from auction a left join products p on a.productID=p.productID left join bid_account ba on ba.auction_id=a.auctionID left join shipping s on s.id=a.shipping_id where a.auctionID='".$aucid."' and ba.bid_flag='d' group by ba.auction_id";

	$ressel = mysql_query($qrysel);
	$total = mysql_num_rows($ressel);
	$obj = mysql_fetch_object($ressel);

	if($obj->auc_status=="1") { $status = "Futuro"; }
	if($obj->auc_status=="2") { $status = "Ativo"; }
	if($obj->auc_status=="3") { $status = "Finalizado"; }

	$qrsms = "select *,sum(bid_count) as smsbids from bid_account where auction_id='".$aucid."' and bidding_type='m' and bid_flag='d' group by auction_id";
	$rssms = mysql_query($qrsms);
	$obsms = mysql_fetch_object($rssms);

	$qronbid = "select *,sum(bid_count) as onlinebid from bid_account where auction_id='".$aucid."' and (bidding_type='s' or bidding_type='b') and bid_flag='d' group by auction_id";
	$rsonbid = mysql_query($qronbid);
	$obonbid = mysql_fetch_object($rsonbid);

	$qrsms1 = "select *,sum(bid_count) as smsbids from bid_account where auction_id='".$aucid."' and bidding_type='m' and bid_flag='d' group by user_id";
	$rssms1 = mysql_query($qrsms1);
	$totalsmsbiduser = mysql_num_rows($rssms1);

	$qronbid1 = "select *,sum(bid_count) as onlinebid from bid_account where auction_id='".$aucid."' and (bidding_type='s' or bidding_type='b') and bid_flag='d' group by user_id";
	$rsonbid1 = mysql_query($qronbid1);
	$totalbidon = mysql_num_rows($rsonbid1);
	
	if($obj->auc_status=="3")
	{
		$qrsmswin = "select *,sum(bid_count) as smsbids from bid_account where auction_id='".$aucid."' and user_id='".$obj->buy_user."' and bidding_type='m' and bid_flag='d' group by auction_id";
		$rssmswin = mysql_query($qrsmswin);
		$obsmswin = mysql_fetch_object($rssmswin);
	
		$qronbidwin = "select *,sum(bid_count) as onlinebid from bid_account where auction_id='".$aucid."' and user_id='".$obj->buy_user."' and (bidding_type='s' or bidding_type='b') and bid_flag='d' group by auction_id";
		$rsonbidwin = mysql_query($qronbidwin);
		$obonbidwin = mysql_fetch_object($rsonbidwin);
	
		$qrsms1win = "select *,sum(bid_count) as smsbids from bid_account where auction_id='".$aucid."' and bidding_type='m' and bid_flag='d' and user_id='".$obj->buy_user."' group by user_id";
		$rssms1win = mysql_query($qrsms1win);
		$totalsmsbiduserwin = mysql_num_rows($rssms1win);
	
		$qronbid1win = "select *,sum(bid_count) as onlinebid from bid_account where auction_id='".$aucid."' and (bidding_type='s' or bidding_type='b') and user_id='".$obj->buy_user."' and bid_flag='d' group by user_id";
		$rsonbid1win = mysql_query($qronbid1win);
		$totalbidonwin = mysql_num_rows($rsonbid1win);
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?=$lng_characset;?>" />
<META content="MSHTML 6.00.2600.0" name=GENERATOR>
<link rel="stylesheet" href="main.css" type="text/css">

<title><? echo $ADMIN_MAIN_SITE_NAME." - Relat&oacute;rio"; ?></title>
</head>

<body>
<TABLE width="100%"  border=0 cellPadding=0 cellSpacing=10>
  <!--DWLayoutTable-->
    <TR> 
      <TD width="100%" class="H1">Detalhes do leil&atilde;o <?=$aucid;?></TD>
    </TR>
  	<TR>
    <TD background="images/vdots.gif"><img height=1 src="images/spacer.gif" width=1 border=0></TD>
	</TR>
	<tr>
		<td height="10"></td>
	</tr>
	<TR>
    	<TD width="500px;"><!--content-->
          <TABLE width="100%" border='0' cellSpacing=0>
		  	  <tr height="5">
			  	<td colspan="3">&nbsp;</td>
			  </tr>
			  <tr>
			  	<td width="70%"><strong>Leil&atilde;o <?=$status;?></strong></td>	
				<td width="15%" align="center" style="padding-right: 10px;"><strong>Sua Moeda</strong></td>
				<td width="15%" align="center"><strong>Real</strong></td>
			  </tr>
			  <tr height="2">
			  	<td colspan="3">&nbsp;</td>
			  </tr>
			  <tr>	
			  	<td width="70%">Pre&ccedi;o de varejo</td>
			  	<td width="15%" align="right" style="padding-right: 5px;"><?=number_format($obj->price * $dinarvalue,2,',','.');?></td>
				<td width="15%" align="right" style="padding-right: 5px;"><?=$Currency.number_format($obj->price,2,',','.');?></td>
			 </tr>
			  <tr height="3">
			  	<td colspan="3">&nbsp;</td>
			  </tr>
			  <tr>
			  	<td colspan="3">
					<TABLE width="100%" border="0" style="margin-left: -3px;">
						<tr>
							<td width="40%">Participantes por SMS</td>
							<td width="60%"><?=$totalsmsbiduser!=""?$totalsmsbiduser:"0";?></td>
						</tr>
						<tr>
							<td width="40%">Total de lances por SMS</td>
							<td width="60%"><?=$obsms->smsbids!=""?$obsms->smsbids:"0";?></td>
						</tr>
						<tr>
							<td width="40%">M&eacute;dia de lances por SMS</td>
							<td width="60%"><?=$totalsmsbiduser!=""?number_format($obsms->smsbids/$totalsmsbiduser,1,',','.'):"0";?></td>
						</tr>
						<tr height="5">
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td width="40%">Participantes On-line</td>
							<td width="60%"><?=$totalbidon;?></td>
						</tr>
						<tr>
							<td width="40%">Total de lances on-line</td>
							<td width="60%"><?=$obonbid->onlinebid;?></td>
						</tr>
						<tr>
							<td width="40%">M&eacute;dia de lances on-line</td>
							<td width="60%"><?=$totalbidon!=""?number_format($obonbid->onlinebid/$totalbidon,1,',','.'):"0";?></td>
						</tr>
						<tr height="5">
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td width="40%">Lances por SMS realizados pelo vencedor</td>
							<td width="60%"><?=$obsmswin->smsbids!=""?$obsmswin->smsbids:"0";?></td>
						</tr>
					</TABLE>
					</td>
					</tr>
					<tr>
							<td width="70%">Despesas de lances por SMS</td>
							<td width="15%" style="padding-right: 5px;" align="right"><?=$obsmswin->smsbids!=""?number_format($obsmswin->smsbids*$SMSCHARGE * $dinarvalue,2,',','.'):"0,00";?></td>
							<td width="15%" align="right" style="padding-right: 5px;"><?=$obsmswin->smsbids!=""?$Currency.number_format($obsmswin->smsbids*$SMSCHARGE,2,',','.'):$Currency."0,00";?></td>
						</tr>
					<tr>
						<td colspan="3">
					<TABLE width="100%" border="0" style="margin-left: -3px;">
						<tr>
							<td width="40%">Lances On-line realizados pelo vencedor</td>
							<td width="60%"><?=$obonbidwin->onlinebid!=""?$obonbidwin->onlinebid:"0";?></td>
						</tr>
					</TABLE>
					 </td>
					</tr>
					<tr>
						<td width="70%">Despesas de lances On-line</td>
						<td width="15%" align="right" style="padding-right: 5px;"><?=$obonbidwin->onlinebid!=""?number_format($obonbidwin->onlinebid*$onlineperbidvalue * $dinarvalue,2,',','.'):"0,00";?></td>
						<td width="15%" align="right" style="padding-right: 5px;"><?=$obonbidwin->onlinebid!=""?$Currency.number_format($obonbidwin->onlinebid*$onlineperbidvalue,2,',','.'):$Currency."0,00";?></td>
					</tr>
				<tr>
				<td width="70%">Pre&ccedil;o final</td>
				<?
					if($obj->fixedpriceauction=="1")
					{
						$fprice = $obj->auc_fixed_price;
					}
					elseif($obj->offauction=="1")
					{
						$fprice = "0.00";
					}
					else
					{
					    $fprice = $obj->auc_final_price;
					}
				?>
				<td width="15%" align="right" style="padding-right: 5px;"><?=number_format($fprice * $dinarvalue,2,',','.');?></td>
				<td width="15%" align="right" style="padding-right: 5px;"><?=$Currency.number_format($fprice,2,',','.');?></td>
			</tr>
			<tr>
				<td width="70%">Custo para Entrega</td>
				<td width="15%" align="right" style="padding-right: 5px;"><?=number_format($obj->shippingcharge * $dinarvalue,2,',','.');?></td>
				<td width="15%" align="right" style="padding-right: 5px;"><?=$Currency.number_format($obj->shippingcharge,2,',','.');?></td>
			</tr>
			<?
//counting for amount paid by the user
				$winneramount = number_format($obsmswin->smsbids*$SMSCHARGE,2) + number_format($obonbidwin->onlinebid*$onlineperbidvalue,2,',','.') + $fprice + $obj->shippingcharge;
		
				$winnersave = $obj->price - $winneramount;
//end user counting
			?>
			<tr>
				<td width="70%"><font color="#FF0000">Total pago pelo vencedor</font></td>
				<td width="15%" align="right" style="padding-right: 5px;"><font color="#FF0000"><?=number_format($winneramount * $dinarvalue,2,',','.'); ?></font></td>
				<td width="15%" align="right" style="padding-right: 5px;"><font color="#FF0000"><?=$Currency;?><?=number_format($winneramount,2,',','.'); ?></font></td>
			</tr>
			<tr height="1">
				<td>&nbsp;</td>
			</tr>
              <TR class=th-a> 
			  	<td width="70%">Vencedor</td>
			  	<td width="15%" align="right" style="padding-right: 5px;"><?=number_format($winnersave * $dinarvalue,2,',','.');?></td>
				<td width="15%" align="right" style="padding-right: 5px;"><?=$Currency;?><?=number_format($winnersave,2,',','.');?></td>
			  </TR>
			<tr height="5">
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td width="70%">Custo do produto</td>
				<td width="15%" align="right" style="padding-right: 5px;"><?=number_format($obj->actual_cost * $dinarvalue,2,',','.');?></td>
				<td width="15%" align="right" style="padding-right: 5px;"><?=$Currency;?><?=number_format($obj->actual_cost,2,',','.');?></td>
			</tr>
			<tr>
				<td width="70%">Faturamento de lances por SMS</td>
				<td width="15%" align="right" style="padding-right: 5px;"><?=$obsms->smsbids!=""?number_format($obsms->smsbids*$SMSCHARGE*$dinarvalue,2,',','.'):"0,00";?></td>
				<td width="15%" align="right" style="padding-right: 5px;"><?=$Currency;?><?=$obsms->smsbids!=""?number_format($obsms->smsbids*$SMSCHARGE,2,',','.'):"0,00";?></td>
			</tr>
			<tr>
				<td width="70%">Faturamento de lances on-line</td>
				<td width="15%" align="right" style="padding-right: 5px;"><?=$totalbidon!=""?number_format($obonbid->onlinebid*$onlineperbidvalue*$dinarvalue,2,',','.'):"0,00";?></td>
				<td width="15%" align="right" style="padding-right: 5px;"><?=$Currency;?><?=$totalbidon!=""?number_format($obonbid->onlinebid*$onlineperbidvalue,2,',','.'):"0,00";?></td>
			</tr>
			<tr>
				<td width="70%">Pre&ccedil;o pago pelo vencedor</td>
				<td width="15%" align="right" style="padding-right: 5px;"><?=number_format($fprice * $dinarvalue,2,',','.');?></td>
				<td width="15%" align="right" style="padding-right: 5px;"><?=$Currency;?><?=number_format($fprice,2,',','.');?></td>
			</tr>
			<tr height="1">
				<td>&nbsp;</td>
			</tr>
			<?
				$comgain = (number_format($obsms->smsbids*$SMSCHARGE,2) + number_format($obonbid->onlinebid*$onlineperbidvalue,2) + $fprice) - $obj->actual_cost;
				
				if($comgain<0)
				{
					$comgain1 = "<font color='red'>R$ ".number_format($comgain,2,',','.')."</font>";
					$comgain2 = "<font color='red'>".$Currency.number_format($comgain * $dinarvalue,2,',','.')."</font>";
				}
				else
				{
					$comgain1 = "<font color='green'>R$ ".number_format($comgain,2,',','.')."</font>";
					$comgain2 = "<font color='green'>".$Currency.number_format($comgain * $dinarvalue,2,',','.')."</font>";
				}
			?>
              <TR class=th-a> 
			  	<td width="70%" align="right">Empresa ganha</td>
			  	<td width="15%" align="right" style="padding-right: 5px;"><?=$comgain2;?></td>
				<td width="15%" align="right" style="padding-right: 5px;"><?=$comgain1;?></td>
			  </TR>
		 </TABLE>
		</TD>
	</TR>

	<tr><td height="5"></td></tr>
	<tr><td height="10" style="padding-left: 470px;">
        <a href="searchauctionresult.php?info=<?=$_GET["info"];?>&pgno=<?=$_GET["pgno"];?>">Voltar</a>
	</td></tr>
	<tr><td height="5"></td></tr>
</TABLE>

</body>
</html>
