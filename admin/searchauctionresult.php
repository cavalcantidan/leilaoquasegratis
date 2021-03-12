<?php
	include_once("admin.config.inc.php");
	include_once("connect.php");
	include_once("functions.php");
	include_once("security.php");
	$qrysmscharge = "select * from general_setting where id='1'";
	$ressmscharge = mysql_query($qrysmscharge);
	$objsmscharge = mysql_fetch_object($ressmscharge);
	$SMSCHARGE = $objsmscharge->smsrateincl;
	$dinarvalue = $objsmscharge->dinars;
		
	$PageNo = 1;
	if($_GET['pgno'])$PageNo = $_GET['pgno'];
	if($_POST["submit"]!="" || $_GET["info"]!=""){
		if($_POST["submit"]!=""){
			$aid = $_POST["auctionid"];
			if($_POST["datefrom"]!="") { $startdate = ChangeDateFormat($_POST["datefrom"]); }else $startdate ='';
			if($_POST["dateto"]!="") { $enddate = ChangeDateFormat($_POST["dateto"]); }else $enddate ='';

            $aucstatus = "";
			if($_POST["auctionstatus_future"]=="1")   { $aucstatus = "a.auc_status=1"; } 
			if($_POST["auctionstatus_running"]=="2")  { if($aucstatus!="") { $aucstatus .= " or "; } $aucstatus .= "a.auc_status=2"; } 
			if($_POST["auctionstatus_ended"]=="3")    { if($aucstatus!="") { $aucstatus .= " or "; } $aucstatus .= "a.auc_status=3"; } 
			if($_POST["auctionstatus_pendente"]=="4") { if($aucstatus!="") { $aucstatus .= " or "; } $aucstatus .= "a.auc_status=4"; } 
			
			if($_POST["orderby"]=="code") { $orderby = " order by a.auctionID"; }
			if($_POST["orderby"]=="dateend") { $orderby = " order by a.auc_end_date"; }
			if($_POST["orderby"]=="itemname") { $orderby = " order by p.name"; }
			if($_POST["orderby"]=="datestart") { $orderby = " order by a.auc_start_date"; }
			if($_POST["orderby"]=="category") { $orderby = " order by a.categoryID"; }
		}else{
			$info = explode("|",$_GET["info"]);
			$startdate = $info[0];
			$enddate = $info[1];
			$aid = $info[2];
			$aucstatus = $info[3];
			$orderby = $info[4];
		}

        $filtro = "";
        $qrysel = "select *,p.name as pname from auction a left join products p on a.productID=p.productID";
	    if($_POST["listtype"]!="aggregate"){
            $qrysel .= " left join categories c on a.categoryID=c.categoryID";
        }
		if($aid!=""){
		    $filtro = "a.auctionID='$aid'";
		}else{
			if($startdate!="") $filtro = "auc_start_date>='$startdate'";
			if($enddate!=""){
                if($filtro!=""){$filtro .= " and ";}
                $filtro .= "auc_end_date<='$enddate'";
            }
			if($aucstatus!=""){
                if($filtro!=""){$filtro .= " and ";}
				$filtro .= "($aucstatus)";
			}
		}
        if($filtro!=""){$qrysel .=" where ". $filtro;}
		if($orderby!=""){ $qrysel .= $orderby; }
	    $urldata = "info=".$startdate."|".$enddate."|".$aid."|".$aucstatus."|".$orderby;	

		$ressel = mysql_query($qrysel);
		$total  = mysql_num_rows($ressel);
		$totalpages = ceil($total/$PRODUCTSPERPAGE);

	    if($_POST["listtype"]!="aggregate"){
		    if($totalpages>=1){
			    $startrow=$PRODUCTSPERPAGE*($PageNo-1);
			    $qrysel	.=" LIMIT $startrow,$PRODUCTSPERPAGE";
			    $ressel=mysql_query($qrysel);
			    $total=mysql_num_rows($ressel);
		    }
	    }
    }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?=$lng_characset;?>" />
<META content="MSHTML 6.00.2600.0" name=GENERATOR>
<link rel="stylesheet" href="main.css" type="text/css">
<script language="javascript">
function calc_counter_from_time(diff) {
  if (diff > 0) {
    hours=Math.floor(diff / 3600)

    minutes=Math.floor((diff / 3600 - hours) * 60)

    seconds=Math.round((((diff / 3600 - hours) * 60) - minutes) * 60)
  } else {
    hours = 0;
    minutes = 0;
    seconds = 0;
  }

  if (seconds == 60) {
    seconds = 0;
  }

  if (minutes < 10) {
    if (minutes < 0) {
      minutes = 0;
    }
    minutes = '0' + minutes;
  }
  if (seconds < 10) {
    if (seconds < 0) {
      seconds = 0;
    }
    seconds = '0' + seconds;
  }
  if (hours < 10) {
    if (hours < 0) {
      hours = 0;
    }
    hours = '0' + hours;
  }
  return hours + ":" + minutes + ":" + seconds;
}
</script>
<title><? echo $ADMIN_MAIN_SITE_NAME." - Relat&oacute;rio de Lances"; ?></title>
</head>

<body>
<TABLE width="100%"  border=0 cellPadding=0 cellSpacing=10>
  <!--DWLayoutTable-->
    <TR> 
      <TD width="100%" class="H1">Resultado da busca</TD>
    </TR>
  	<TR>
    <TD background="images/vdots.gif"><img height=1 src="images/spacer.gif" width=1 border=0 /></TD>
	</TR>
	<tr>
		<td height="10"></td>
	</tr>
	<tr>
		<td height="5"></td>
	</tr>
		<? if(isset($total))
		{
			if($total==0)
			{
		?>
	<TR>
    	<TD><!--content-->
		<table width="70%" border="0" cellspacing="1" cellpadding="1" align="center"> 
		<tr>
			<td height="8"></td>
		</tr>
		<tr>
			<td>
				<table width="100%" border="0" cellspacing="1" cellpadding="1" align="center" bgcolor="#000000">
					<tr> 
					  <td> 
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
						  <tr> 
							<td class=th-a > 
							  <div align="center">Sem Informa&ccedil;&otilde;es Para Exibir.</div>
							</td>
						  </tr>
						</table>
					  </td>
					</tr>
				</table>
			</td>
		</tr>			
      </table>
	 </TD>
   </TR>
	 <?
	 	}
		else
		{
			if($_POST["listtype"]=="list" || $_POST["listtype"]=="")
			{
	?>
	<TR>
    	<TD><!--content-->
          <TABLE width="100%" border=1 cellSpacing=0 class=t-a>
            <!--DWLayoutTable-->
              <TR class=th-a> 
				<!--TD width="7%" align="left" nowrap="nowrap">Tipo</TD-->
				<TD width="10%" nowrap="nowrap" align="center">Leil&atilde;o ID</TD>
				<TD width="10%" align="center">Situa&ccedil;&atilde;o</TD>
				<TD width="30%" nowrap="nowrap" align="center">Item</TD>
				<TD width="10%" align="center" nowrap="nowrap">Categoria</TD>
				<TD width="10%" align="center" nowrap="nowrap">Data inicial</TD>
				<TD width="10%" align="center" nowrap="nowrap">Data final</TD>
				<TD width="10%" align="center" nowrap="nowrap">Dura&ccedil;&atilde;o</TD>
				<TD width="10%" align="center" nowrap="nowrap">Pre&ccedil;o</TD>
				<TD width="10%" align="center" nowrap="nowrap">Qt. Participantes</TD>
				<TD width="10%" align="center" nowrap="nowrap">Lances</TD>
				<TD width="10%" align="center" nowrap="nowrap">Faturamentos</TD>
				<TD width="10%" align="center" nowrap="nowrap">Op&ccedil;&otilde;es</TD>
			 </TR>
		<?
			while($obj = mysql_fetch_object($ressel))
			{
				if ($colorflg==1){
					$colorflg=0;
					echo "<TR bgcolor=\"#f4f4f4\"> ";
				}else{
					$colorflg=1;
				  	echo "<TR> ";
				}
				if($obj->auc_status=="2") {
					if($obj->pause_status=="1"){
						$status = "<font color='green'>Pausado</font>";	
					}else{
					 $status = "<font color='red'>Ativo</font>";
					}
				  }
				if($obj->auc_status=="1") { $status = "<font color='green'>Futuro</font>"; }
				if($obj->auc_status=="3") { $status = "<font color='blue'>Finalizado</font>"; }
				if($obj->auc_status=="4") { $status = "<font color='green'>Pendente</font>"; }				
				$qr1 = "select *,sum(bid_count) as totalbids from bid_account where auction_id='".$obj->auctionID."' and bid_flag='d' group by auction_id";
				$rs1 = mysql_query($qr1);
				$objbids1 = mysql_fetch_object($rs1);
				
				$qr2 = "select * from bid_account where auction_id='".$obj->auctionID."' and bid_flag='d' group by user_id";
				$rs2 = mysql_query($qr2);
				$totaluser = mysql_num_rows($rs2);
				
	/*			if($obj->fixedpriceauction=="1"){ $auctiontype = "Fix price"; }
				if($obj->pennyauction=="1"){ $auctiontype = "1 Centavo"; }
				if($obj->nailbiterauction=="1"){ $auctiontype = "Nailbiter"; }
				if($obj->offauction=="1"){ $auctiontype = "100% off"; }
				if($obj->nightauction=="1"){ $auctiontype = "Night Auc"; }
				if($obj->openauction=="1"){ $auctiontype = "Open Auc"; }*/
				
				$revenues = explode("|",GetTotalBidsAmount($obj->auctionID,$SMSCHARGE));
		?>
				<!--TD width="7%" align="left" nowrap="nowrap"><?=$auctiontype;?></TD-->
				<TD width="10%" nowrap="nowrap" align="center"><?=$obj->auctionID;?></TD>
				<TD width="10%" align="center"><?=$status;?></TD>
				<TD width="10%" nowrap="nowrap" align="center"><?=$obj->pname;?></TD>
				<TD width="10%" align="center" nowrap="nowrap"><?=$obj->name;?></TD>
				<TD width="10%" align="center" nowrap="nowrap"><?=arrangedate($obj->auc_start_date);?>&nbsp;<?=$obj->auc_start_time;?></TD>
				<TD width="10%" align="center" nowrap="nowrap">
				<?php
					if($obj->auc_status=="3"){
					   echo	arrangedate(substr($obj->auc_final_end_date,0,10))."&nbsp;".substr($obj->auc_final_end_date,11);
					}else{
						echo arrangedate($obj->auc_end_date)."&nbsp;".$obj->auc_end_time;
					}
					?>
				</TD>
				<TD width="10%" align="center" nowrap="nowrap">
				<span id="time_<?=$obj->auctionID;?>">
					<?php
						echo "<script language='javascript'>
							document.getElementById('time_".$obj->auctionID."').innerHTML = calc_counter_from_time('".$obj->total_time."');
							</script>";	
					?>
				</span>
				</TD>
				<TD width="10%" align="right" nowrap="nowrap"><?=$Currency.number_format($obj->auc_final_price,2,',','.');?></TD>
				<TD width="10%" align="center" nowrap="nowrap"><?=$totaluser!=""?$totaluser:"0";?></TD>
				<TD width="10%" align="center" nowrap="nowrap"><?=$objbids1->totalbids!=""?$objbids1->totalbids:"0";?></TD>
				<TD width="10%" align="center" nowrap="nowrap"><?=$Currency.number_format($revenues[0],2,',','.');?></TD>
				<TD width="10%" align="center" nowrap="nowrap">
				<? if($obj->auc_status!=1){ ?>
					<input type="button" name="details" class="bttn" value="Detalhes" onclick="javascript: window.location.href='searchauctiondetails.php?aid=<?=$obj->auctionID;?>&<?=$urldata;?>&pgno=<?=$PageNo;?>'" />
				<? } else { ?>
					<input type="button" name="details" class="bttn" value="Detalhes" />
				<? } ?>
				</TD>
			</tr>
		<?
			}
		?>		
		 </TABLE>
		</TD>	
	</TR>
	<Tr>
		<td>
		  <?
			if($PageNo>1){
			  $PrevPageNo = $PageNo-1;
		  ?>
		  <A class='paging' href="searchauctionresult.php?pgno=<?=$PrevPageNo;?>&<?=$urldata;?>">&lt; P&aacute;gina Anterior</A>
		  <?
		   }
		  ?> &nbsp;&nbsp;&nbsp;
		  <?php
			if($PageNo<$totalpages){
			 $NextPageNo = 	$PageNo + 1;
		  ?>
		  <A class='paging' id='next' href="searchauctionresult.php?pgno=<?=$NextPageNo;?>&<?=$urldata;?>">Pr&amp;oacute;xima P&amp;aacute;gina &gt;</A>
		  <?
		   }
		  ?>
		 </td>
		</Tr>
	<?
		
		}
		elseif($_POST["listtype"]=="aggregate"){
			while($obj = mysql_fetch_object($ressel)){
				if($obj->fixedpriceauction=="1"){
					$fprice = $obj->auc_fixed_price;
				}elseif($obj->offauction=="1"){
					$fprice = "0.00";
				}else{
					$fprice = $obj->auc_final_price;
				}
				
				$totalcost = $obj->actual_cost + $totalcostplus;
				$totalcostplus = $totalcost;
				
				$finalprice = $fprice + $fpriceplus;
				$fpriceplus = $finalprice;
				
				$priceinfo = explode("|",GetTotalBidsAmount($obj->auctionID,$SMSCHARGE));
				
				$biddingprice = $priceinfo[0] + $biddingprice1;
				$biddingprice1 = $biddingprice;
	
				$onlineprice = $priceinfo[1] + $onlineprice1;
				$onlineprice1 = $onlineprice;
	
				$smsprice = $priceinfo[2] + $smsprice1;
				$smsprice1 = $smsprice;
			}
	?>
	<TR>
    	<TD width="500px"><!--content-->
          <TABLE width="100%" border=1 cellSpacing=0 class=t-a>
            <!--DWLayoutTable-->
              <TR class=th-a> 
					<td>Relat&oacute;rio</td>
			  </TR>
		 </TABLE>
		<TABLE width="100%" border="0">
			<tr height="5">
				<td colspan="3">&nbsp;</td>
			</tr>
			<tr>
				<td width="70%"><strong>Todos leil&otilde;es finalizados</strong></td>
				<td width="15%" align="center"><strong>Sua Moeda</strong></td>
				<td width="25%" align="center"><strong>Real</strong></td>
			</tr>
			<tr>
				<td colspan="2">
					<TABLE width="70%" border="0">
						<tr>
							<td width="70%">Total de Leil&otilde;es</td>
							<td width="15%"><?=$total;?></td>
						</tr>
					</TABLE>
				</td>
			</tr>
			<tr>
				<td width="70%">Custo total dos produtos</td>
				<td align="right" style="padding-right: 20px;" width="15%"><?=number_format(($totalcost * $dinarvalue),2,',','.');?></td>
				<td width="25%" align="right"><?=$Currency;?><?=number_format($totalcost,2,',','.');?></td>
			</tr>
			<tr height="5">
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td width="70%">Faturamento de lances por SMS</td>
				<td align="right" style="padding-right: 20px;" width="15%"><?=number_format(($smsprice * $dinarvalue),2,',','.');?></td>
				<td width="25%" align="right"><?=$Currency;?><?=number_format($smsprice,2,',','.');?></td>
			</tr>
			<tr>
				<td width="70%">Faturamento de lances on-line</td>
				<td align="right" style="padding-right: 20px;" width="15%"><?=number_format(($onlineprice * $dinarvalue),2,',','.');?></td>
				<td width="25%" align="right"><?=$Currency;?><?=number_format($onlineprice,2,',','.');?></td>
			</tr>
			<tr>
				<td width="70%">Pre&ccedil;o final para arremate</td>
				<td align="right" style="padding-right: 20px;" width="15%"><?=number_format(($finalprice * $dinarvalue),2,',','.');?></td>
				<td width="25%" align="right"><?=$Currency;?><?=number_format($finalprice,2,',','.');?></td>
			</tr>
			<tr height="5">
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td width="70%">Total de despesas</td>
				<td align="right" style="padding-right: 20px;" width="15%"><?=number_format(($totalcost * $dinarvalue),2,',','.');?></td>
				<td width="25%" align="right"><?=$Currency;?><?=number_format($totalcost,2,',','.');?></td>
			</tr>
				<?
				$totalearn = $smsprice  + $onlineprice + $finalprice;
				$comgain = $totalearn - $totalcost;
				if($comgain<0){
					$comgain1 = "<font color='red'>".$Currency.number_format($comgain,2,',','.')."</font>";
					$comgain2 = "<font color='red'>R$ ".number_format($comgain * $dinarvalue,2,',','.')."</font>";
				}else{
					$comgain1 = "<font color='green'>".$Currency.number_format($comgain,2,',','.')."</font>";
					$comgain2 = "<font color='green'>R$ ".number_format($comgain * $dinarvalue,2,',','.')."</font>";
				}
				?>
			<tr>
				<td width="70%">Total de lucro</td>
				<td align="right" style="padding-right: 20px;" width="15%" nowrap="nowrap"><?=number_format($totalearn * $dinarvalue,2,',','.');?></td>
				<td width="25% "align="right" nowrap="nowrap"><?=$Currency;?><?=number_format($totalearn,2,',','.');?></td>
			</tr>
			<tr height="5">
				<td>&nbsp;</td>
			</tr>
		</TABLE>
		</TD>
   </TR>
   <TR>
   	<td>
		<table width="62%" cellpadding="0" cellspacing="0" border="0">
		   <TR class=th-a> 
				<td width="70%" align="right" style="padding-right: 20px;">Empresa ganha</td>
				<td align="right" style="padding-right: 20px;" width="15%" nowrap="nowrap"><?=$comgain2;?></td>
				<td align="right" width="25%" nowrap="nowrap"><?=$comgain1;?></td>
		   </TR>
		</table>
	</td>
   </TR>
	<?
		}
	  }
	}
	 ?>
	</TABLE>	 
</body>
</html>