<?
	include_once("admin.config.inc.php");
	include("connect.php");
	include("functions.php");
	include("security.php");
	
	$aid = $_GET["aid"];

	if($aid!=""){	
		$qrysel = "select * from auction a left join products p on a.productID=p.productID left join registration r on a.buy_user=r.id  where a.auctionID='$aid'";
		$ressel = mysql_query($qrysel);
		$total = mysql_num_rows($ressel);
		$obj = mysql_fetch_object($ressel);

		if($obj->fixedpriceauction=="1") { $auctype = "Fixed Price Auction"; }
		if($obj->pennyauction=="1") { if($auctype==""){ $auctype = "1 Centavo"; } else { $auctype .= ", 1 Centavo"; } }
		if($obj->nailbiterauction=="1") { if($auctype==""){ $auctype = "NailBiter Auction"; } else { $auctype .= ", NailBiter Auction"; } }
		if($obj->offauction=="1") { if($auctype==""){ $auctype = "100% Off Auction"; } else { $auctype .= ", 100% Off Auction"; } }
		if($obj->nightauction=="1") { if($auctype=="") { $auctype = "Night Auction";  } else { $auctype .= ", Night Auction"; } }
		if($obj->openauction=="1") { if($auctype=="") { $auctype = "Open Auction"; } else { $auctype .= ", Open Auction"; } }
		
		if($obj->time_duration=="none") { $duration = "Padr&atilde;o"; } 
		elseif($obj->time_duration=="10sa") { $duration = "10 Second Auction"; } 
		elseif($obj->time_duration=="15sa") { $duration = "15 Second Auction"; } 
		elseif($obj->time_duration=="20sa") { $duration = "20 Second Auction"; } 
		
		if($obj->auc_status=="1") { $status = "<font color='green'>Futuro</font>"; }
		elseif($obj->auc_status=="2") { $status = "<font color='red'>Ativo</font>"; }
		elseif($obj->auc_status=="3") { $status = "<font color='blue'>Vendido</font>"; }
		elseif($obj->auc_status=="4") { $status = "<font color='green'>Pendente</font>"; }

		$numberbids = explode("|",GetBidsDetails($aid));
		$biddingprice = $numberbids[0]*0.50;

		if($obj->fixedpriceauction=="1")
		{
			$priceauc = $obj->auc_fixed_price;
			$prodprice = $obj->price;
			$prloss = $priceauc + $biddingprice - $prodprice;
		}
		elseif($obj->offauction=="1")
		{
			$priceauc = 0.01;
			$prodprice = $obj->price;
			$prloss = $priceauc + $biddingprice - $prodprice;
		}
		else
		{
			$priceauc = $obj->auc_final_price;
			$prodprice = $obj->price;
			$prloss = $priceauc + $biddingprice - $prodprice;
		}
	
		if($prloss<0)
		{
			$prloss1 = "<font color='red'>-".$Currency.number_format(substr($prloss,1),2)."</font>";
		}
		else
		{
			$prloss1 = "<font color='green'>".$Currency.number_format($prloss,2)."</font>";
		}
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?=$lng_characset;?>" />
<link rel="stylesheet" href="main.css" type="text/css">
<title><? echo $ADMIN_MAIN_SITE_NAME." - Detalhes do leil&atilde;o"; ?></title>

</head>

<body>
<TABLE width="100%"  border=0 cellPadding=0 cellSpacing=10>
  <!--DWLayoutTable-->
    <TR> 
        <TD width="30%" class="H1">Detalhes Do Leil&atilde;o</TD>
        <TD class="H1">Hist&oacute;rico de lances</TD>
    </TR>
  	<TR>
        <TD background="images/vdots.gif"><IMG height=1 src="images/spacer.gif" width=1 border=0 /></TD>
        <TD background="images/vdots.gif"><IMG height=1 src="images/spacer.gif" width=1 border=0 /></TD>
	</TR>
	<tr>
		<td height="5"></td>
		<td height="5"></td>
	</tr>
	<tr>
		<td height="5"></td>
		<td height="5"></td>
	</tr>
	<tr>
		<td>
			<table border="0">
				<tr>
					<td class="f-c"  align="right">Nome :</td>
					<td align="left">&nbsp;&nbsp;<?=stripslashes($obj->name);?></td>
				</tr>
				<!--tr>
					<td class="f-c"  align="right">Tipo :</td>
					<td>&nbsp;&nbsp;<?=$auctype;?></td>
				</tr-->
				<tr>
					<td class="f-c"  align="right">Situa&ccedil;&atilde;o :</td>
					<td>&nbsp;&nbsp;<?=$status;?></td>
				</tr>
				<tr>
					<td class="f-c"  align="right">&nbsp;&nbsp;&nbsp;Dura&ccedil;&atilde;o :</td>
					<td>&nbsp;&nbsp;<?=$duration;?></td>
				</tr>
				<tr>
					<td class="f-c"  align="right">&nbsp;&nbsp;&nbsp;Data de In&iacute;cio :</td>
					<td>&nbsp;&nbsp;<?=ChangeDateFormatSlash($obj->auc_start_date);?></td>
				</tr>
				<tr>
					<td class="f-c"  align="right">&nbsp;&nbsp;&nbsp;Data Final :</td>
					<? if($obj->auc_status=="3") { $enddate = $obj->auc_final_end_date; }
					 else { $enddate = $obj->auc_end_date; }?>
					<td>&nbsp;&nbsp;<?=ChangeDateFormatSlash($enddate);?></td>
				</tr>
				<tr>
					<td class="f-c"  align="right">&nbsp;&nbsp;&nbsp;Pre&ccedil;o Inicial :</td>
					<td>&nbsp;&nbsp;<?=$Currency.$obj->auc_start_price;?></td>
				</tr>
				<!--tr>
					<td class="f-c"  align="right">&nbsp;&nbsp;&nbsp;Pre&ccedil;o Fixo :</td>
					<td>&nbsp;&nbsp;<?=$Currency.$obj->auc_fixed_price;?></td>
				</tr-->
				<? if($obj->auc_status=="3"){ ?>
				<tr>
					<td class="f-c"  align="right">&nbsp;&nbsp;&nbsp;Pre&ccedil;o Final :</td>
					<td>&nbsp;&nbsp;<?=$Currency.$obj->auc_final_price;?></td>
				</tr>
				<tr>
					<td class="f-c"  align="right">&nbsp;&nbsp;&nbsp;Ganhador :</td>
					<td <?php if($obj->admin_user_flag=='1'){echo ' class="a" ';} ?>>&nbsp;&nbsp;<?=$obj->username;?></td>
				</tr>
				<tr>
					<td class="f-c"  align="right">&nbsp;&nbsp;&nbsp;Lucro / Preju&iacute;zo :</td>
					<td>&nbsp;&nbsp;<?=$prloss1;?></td>
				</tr>
				<? } ?>
			</table>
		</TD>
		<td>
        <?
			$qry = "select *,sum(bid_count) as bidcount from bid_account ba left join registration r on ba.user_id=r.id where auction_id='$aid' and bid_flag='d' group by user_id";
			$re = mysql_query($qry);
			$total = mysql_num_rows($re);
			if($obj->auc_status=="3" || $obj->auc_status=="2"){
				if($total==0){
		?>
			<table width="100%" border="1" cellspacing="0" cellpadding="0" bgcolor="#000000">
				<tr> 
				    <td class=th-a > 
					    <div align="center">Sem hist&oacute;rico de lances para exibi&ccedil;&atilde;o.</div>
				    </td>
				</tr>
			</table>
		<?php }else{ ?>
	        <TABLE width="100%" border=1 cellSpacing=0 class=t-a>
	            <TR class=th-a> 
				    <TD width="15%" align="left" nowrap="nowrap">Usu&aacute;rio</TD>
				    <TD width="15%" align="left" nowrap="nowrap">Primeiro nome</TD>
				    <TD width="30%" align="left" nowrap="nowrap">E-mail</TD>
				    <!--TD width="15%" align="left" nowrap="nowrap">Lances</TD>
				    <TD width="15%" align="left" nowrap="nowrap">Lances</TD-->
				    <TD width="15%" nowrap="nowrap" align="center">Lances</TD>
				</TR>						
	<?
		while($ob = mysql_fetch_object($re)){
			$clsname = "";
			if($ob->admin_user_flag=='1'){$clsname = " class='a' ";}
				
			if ($colorflg=='')$colorflg='bgcolor="#f4f4f4"'; else $colorflg='';
			echo "<TR $colorflg ".$clsname.">";

			/*$qrb = "select *,sum(bid_count) as butlerbid from bid_account where auction_id='$aid' and user_id='".$ob->user_id."' and bidding_type='b' group by user_id";
			$rb = mysql_query($qrb);
			$butler = mysql_fetch_object($rb);

			$qrb1 = "select *,sum(bid_count) as singlebid from bid_account where auction_id='$aid' and user_id='".$ob->user_id."' and bidding_type='s' group by user_id";
			$rb1 = mysql_query($qrb1);
			$butler1 = mysql_fetch_object($rb1);*/

			$totalbids = $ob->bidcount + $bids;
			/*$butlerbids = $butler->butlerbid + $butbids;
			$singlebids = $butler1->singlebid + $singbids;
                <TD align=\"center\">{$butler1->singlebid!=""?$butler1->singlebid:"0"}</TD>
				<TD align=\"center\">{$butler->butlerbid!=""?$butler->butlerbid:"0"}</TD>
            */

            echo "<TD align=\"left\">{$ob->username}</TD>
				<TD align=\"left\">{$ob->firstname}</TD>
				<TD align=\"left\">{$ob->email}</TD>
				<TD align=\"center\">{$ob->bidcount}</TD>
			</TR> ";

			$bids = $totalbids;
			/*$butbids = $butlerbids;
			$singbids = $singlebids;
                <td align="center"><?=$singlebids;?></td>
				<td align="center"><?=$butlerbids;?></td>
            */
		}
	    ?>
	            <TR class=th-a> 
				<td colspan="3" align="right">Total de Lances:</td>

				<td align="center" nowrap="nowrap"><?=$totalbids;?><br />(<?=$numberbids[0]!=""?$numberbids[0]:"0";?> + <font class="a"><?=$numberbids[1]!=""?$numberbids[1]:"0";?></font>)</td>
				</TR>
		</TABLE>
		<?
			}
		}
		?>
	</td>
	</tr>
    <tr>
        <td  colspan="2" class="a">Obs: Usu&aacute;rios em vermelho s&atilde;o rob&ocirc;s.</td>
    </tr>
	</TABLE>
</body>
</html>
