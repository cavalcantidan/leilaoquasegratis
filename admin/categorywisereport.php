<?
	include_once("admin.config.inc.php");
	include("connect.php");
	include("functions.php");
	include("security.php");
	if($_POST["submit"]!="" || $_GET["sdate"]!="")
	{
		if(!$_GET['pgno'])
		{
			$PageNo = 1;
		}
		else
		{
			$PageNo = $_GET['pgno'];
		}

			if($_POST["datefrom"]!="")
			{
				$startdate = ChangeDateFormat($_POST["datefrom"]);
				$enddate = ChangeDateFormat($_POST["dateto"]);
				$cid = $_POST["category"];
			}
			else
			{
					$startdate = ChangeDateFormat($_GET["sdate"]);
					$enddate = ChangeDateFormat($_GET["edate"]);
					$cid = $_GET["catid"];
			}
			$urldata = "sdate=".ChangeDateFormatSlash($startdate)."&edate=".ChangeDateFormatSlash($enddate)."&catid=".$cid;
		
		$qrysel = "select *,sum(bid_count) as totalbid from auction a left join categories c on a.categoryID=c.categoryID left join bid_account ba on ba.auction_id=a.auctionID where auc_start_date>='$startdate' and auc_end_date<='$enddate' and bid_flag='d' group by a.categoryID";
		
		if($cid!="")
		{
		$qrysel = "select *,sum(bid_count) as totalbid from auction a left join categories c on a.categoryID=c.categoryID left join bid_account ba on ba.auction_id=a.auctionID where a.categoryID='$cid' and auc_start_date>='$startdate' and auc_end_date<='$enddate' and bid_flag='d' group by a.categoryID";
		}
		$ressel = mysql_query($qrysel);
		$total = mysql_num_rows($ressel);
		$totalpage=ceil($total/$PRODUCTSPERPAGE);

		if($totalpage>=1)
		{
			$startrow=$PRODUCTSPERPAGE*($PageNo-1);
			$qrysel.=" LIMIT $startrow,$PRODUCTSPERPAGE";
			//echo $sql;
			$ressel=mysql_query($qrysel);
			$total=mysql_num_rows($ressel);
		}
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?=$lng_characset;?>" />
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?=$lng_characset;?>" />
<META content="MSHTML 6.00.2600.0" name=GENERATOR>
<link rel="stylesheet" href="main.css" type="text/css">
<link href="zpcal/themes/aqua.css" rel="stylesheet" type="text/css" media="all" title="Calendar Theme - aqua.css" />
<script type="text/javascript" src="zpcal/src/utils.js"></script>
<script type="text/javascript" src="zpcal/src/calendar.js"></script>
<script type="text/javascript" src="zpcal/lang/calendar-en.js"></script>
<script type="text/javascript" src="zpcal/src/calendar-setup.js"></script>
<title><? echo $ADMIN_MAIN_SITE_NAME." - Bidding Report"; ?></title>
<script language="javascript">
	function Check(f1)
	{	
		if(document.f1.datefrom.value=="")
		{
			alert("Por favor selecione a data inicial!!!");
			return false;
			document.f1.datefrom.focus();
		}
		if(document.f1.dateto.value=="")
		{
			alert("Por favor selecione a data final!!!");
			return false;
			document.f1.dateto.focus();
		}
	}
</script>
</head>

<body>
<TABLE width="100%"  border=0 cellPadding=0 cellSpacing=10>
  <!--DWLayoutTable-->
    <TR> 
      <TD width="100%" class="H1">Relat&oacute;rio de lance por categoria</TD>
    </TR>
  	<TR>
    <TD background="images/vdots.gif"><IMG height=1 
      src="images/spacer.gif" width=1 border=0></TD>
	</TR>
	<tr>
		<td height="10"></td>
	</tr>
	<tr>
		<td height="5"></td>
	</tr>
	<tr>
		<td align="center" class="h2"><b>Por Favor Selecione a Data</b></td>
	</tr>
	<tr>
		<td height="5"></td>
	</tr>
	<form action="" method="post" name="f1" onsubmit="return Check(this)">	
	<tr>
		<td align="center"><b>De</b> : <input class="textbox" type="text" name="datefrom" id="datefrom" size="12" value="<?=$startdate!=""?ChangeDateFormatSlash($startdate):"";?>">&nbsp;&nbsp;<img src="images/pmscalendar.gif" align="absmiddle" width="20" height="20" id="vfrom">&nbsp;&nbsp;-&nbsp;&nbsp; <b>&agrave;</b> : <input class="textbox" type="text" name="dateto" size="12" id="dateto" value="<?=$enddate!=""?ChangeDateFormatSlash($enddate):"";?>">&nbsp;&nbsp;<img src="images/pmscalendar.gif" align="absmiddle" width="20" height="20" id="zfrom">&nbsp;&nbsp;</font></td>
	</tr>
	<tr>
		<td height="5"></td>
	</tr>
	<tr>
		<td align="center" class="h2"><strong>Categoria:</strong> 
		<?
			$qrycat = "select * from categories";
			$rescat = mysql_query($qrycat);
			$total1 = mysql_num_rows($rescat);
		?>		
	    <select name="category" style="width:250px;">
			<option value="">selecione</option>
		<?
			while($v = mysql_fetch_object($rescat))
			{
		?>
				<option <?=$v->categoryID==$cid?"selected":"";?> value="<?=$v->categoryID;?>"><?=$v->name;?></option>
		<?
			}
		?>
		</select>
	</td>
	<tr>
		<td height="5"></td>
	</tr>
	<tr>
		<td height="5"></td>
	</tr>
	<tr>
		<td align="center"><input type="submit" name="submit" value="Buscar" class="bttn-s"></td>
	</tr>
	</form>
	<TR>
    	<TD><!--content-->
		<? if(isset($total))
		{
			if($total==0)
			{
		?>
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
	 <?
	 	}
		else
		{
	?>
          <TABLE width="100%" border=1 cellSpacing=0 class=t-a>
            <!--DWLayoutTable-->
              <TR class=th-a> 
				<!--<TD nowrap width="5%">User Id</TD>-->
				<TD width="7%" align="left" nowrap="nowrap">Leil&atilde;o ID</TD>
				<TD width="30%" align="center">Nome</TD>
				<TD width="10%" nowrap="nowrap" align="center">Lances Online</TD>
				<TD width="10%" nowrap="nowrap" align="center"><?=$BidButName;?> Lances</TD>
				<TD width="10%" nowrap="nowrap" align="center">Lances Sms</TD>
				<TD width="10%" nowrap="nowrap" align="center">Lances Totais</TD>
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
				
				$qr = "select *,sum(bid_count) as totalsinglebid from auction a left join categories c on a.categoryID=c.categoryID left join bid_account ba on ba.auction_id=a.auctionID where a.categoryID='".$obj->categoryID."' and ba.bidding_type='s' and bid_flag='d' and ba.bidpack_buy_date>='$startdate 00:00:01' and ba.bidpack_buy_date<='$enddate 23:59:59' group by a.categoryID";
				$rs = mysql_query($qr);
				$objbids = mysql_fetch_object($rs);

				$qr1 = "select *,sum(bid_count) as totalbidbutlerbid from auction a left join categories c on a.categoryID=c.categoryID left join bid_account ba on ba.auction_id=a.auctionID where a.categoryID='".$obj->categoryID."' and ba.bidding_type='b'  and bid_flag='d' and ba.bidpack_buy_date>='$startdate 00:00:01' and ba.bidpack_buy_date<='$enddate 23:59:59'  group by a.categoryID";
				$rs1 = mysql_query($qr1);
				$objbids1 = mysql_fetch_object($rs1);

				$qr2 = "select *,sum(bid_count) as totalsmsbid from auction a left join categories c on a.categoryID=c.categoryID left join bid_account ba on ba.auction_id=a.auctionID where a.categoryID='".$obj->categoryID."' and ba.bidding_type='m' and bid_flag='d'  and ba.bidpack_buy_date>='$startdate 00:00:01' and ba.bidpack_buy_date<='$enddate 23:59:59'  group by a.categoryID";
				$rs2 = mysql_query($qr2);
				$objbids2 = mysql_fetch_object($rs2);
				$totalbids = $objbids->totalsinglebid + $objbids1->totalbidbutlerbid + $objbids2->totalsmsbid;
		?>
				<TD align="left" nowrap="nowrap"><?=$obj->auctionID;?></TD>
				<TD nowrap="nowrap" align="left"><?=$obj->name;?></TD>
				<TD align="left" nowrap="nowrap"><?=$objbids->totalsinglebid!=""?$objbids->totalsinglebid:"0"?></TD>
				<TD align="left" nowrap="nowrap"><?=$objbids1->totalbidbutlerbid!=""?$objbids1->totalbidbutlerbid:"0"?></TD>
				<TD align="left" nowrap="nowrap"><?=$objbids2->totalsmsbid!=""?$objbids2->totalsmsbid:"0"?></TD>
				<TD align="left" nowrap="nowrap"><?=$totalbids!=""?$totalbids:"0";?></TD>
			</tr>
		<?
			}
		?>		
		 </TABLE>
		  <?
			if($PageNo>1)
			{
			  $PrevPageNo = $PageNo-1;
		  ?>
		  <A class='paging' href="categorywisereport.php?pgno=<?=$PrevPageNo;?>&<?=$urldata;?>">&lt; P&aacute;gina Anterior</A>
		  <?
		   }
		  ?> &nbsp;&nbsp;&nbsp;
		  <?php
			if($PageNo<$totalpage)
			{
			 $NextPageNo = 	$PageNo + 1;
		  ?>
		  <A class='paging' id='next' href="categorywisereport.php?pgno=<?=$NextPageNo;?>&<?=$urldata;?>">Pr&amp;oacute;xima P&amp;aacute;gina &gt;</A>
		  <?
		   }
		  ?>
	<?
		
		}
	}
	 ?>
	 </TD>
	 </TR>
	</TABLE>	 
<script type="text/javascript">
var cal = new Zapatec.Calendar.setup({ 
inputField:"datefrom",
ifFormat:"%d/%m/%Y",
button:"vfrom",
showsTime:false 
});
</script>
<script type="text/javascript">
var cal = new Zapatec.Calendar.setup({ 
inputField:"dateto",
ifFormat:"%d/%m/%Y",
button:"zfrom",
showsTime:false 
});
</script>
</body>
</html>
