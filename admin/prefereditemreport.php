<?
	include_once("admin.config.inc.php");
	//include("admin.cookie.php");
	include("connect.php");
	include("functions.php");
	include("security.php");
	$type1 = "1";
	$type3 = "2";
	include("pagepermission.php");
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
				$pid = $_POST["product"];
			}
			else
			{
					$startdate = ChangeDateFormat($_GET["sdate"]);
					$enddate = ChangeDateFormat($_GET["edate"]);
					$pid = $_GET["proid"];
			}
			$urldata = "sdate=".ChangeDateFormatSlash($startdate)."&edate=".ChangeDateFormatSlash($enddate)."&proid=".$pid;
			
			$qrysel = "select *,sum(bid_count) as totalbids,DATE_FORMAT( bidpack_buy_date,  '%Y-%m-%d'  )  AS newdate,c.name as catname from bid_account ba left join products p on ba.product_id=p.productID left join categories c on p.categoryID=c.categoryID where ba.product_id!='0' and bid_flag='d' and bidpack_buy_date>='$startdate' and bidpack_buy_date<='$enddate' group by p.categoryID order by totalbids desc";
			
			if($pid!="")
			{
			$qrysel = "select *,sum(bid_count) as totalbids,DATE_FORMAT( bidpack_buy_date,  '%Y-%m-%d'  )  AS newdate,c.name as catname from bid_account ba left join products p on ba.product_id=p.productID left join categories c on p.categoryID=c.categoryID where ba.product_id!='0' and bid_flag='d' and bidpack_buy_date>='$startdate' and bidpack_buy_date<='$enddate' and c.categoryID='$pid' group by p.categoryID order by totalbids desc";
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
      <TD width="100%" class="H1">Relat&oacute;rio &Iacute;tem Preferido </TD>
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
		<td align="center" class="h2"><strong>Categoria :</strong>
		<?
			$qrypro = "select * from categories";
			$rspro = mysql_query($qrypro);
			$totalpro = mysql_num_rows($rspro);
		?>
		<select name="product" style="width: 280px;">
			<option value="">selecione</option>
			<?
				while($pro = mysql_fetch_object($rspro))
				{
			?>
				<option <?=$pro->categoryID==$pid?"selected":"";?> value="<?=$pro->categoryID;?>"><?=$pro->name;?></option>
			<?
				}	
			?>
		</select>
		</td>
	</tr>
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
							  <div align="center">Sem produtos para exibir.</div>
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
				<TD width="7%" align="left" nowrap="nowrap">ID Categoria</TD>
				<TD width="25%" align="center">Nome</TD>
				<TD width="10%" nowrap="nowrap" align="center">Leil&otilde;es</TD>
				<TD width="10%" nowrap="nowrap" align="center">Lances On-line</TD>
				<TD width="10%" nowrap="nowrap" align="center"><?=$BidButName;?> Lances</TD>
				<TD width="10%" nowrap="nowrap" align="center">Lances SMS</TD>
				<TD width="10%" nowrap="nowrap" align="center">Total de Lances</TD>
				<TD width="5%" align="center">M&eacute;dia de Lances</TD>
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
				$qr = "select * from auction where categoryID='".$obj->categoryID."' and  auc_end_date<='$enddate'";
				$rs = mysql_query($qr);
				$totalauc = mysql_num_rows($rs);
				
				$qr1 = "select *,sum(bid_count) as totalonlinebid,DATE_FORMAT( bidpack_buy_date,  '%Y-%m-%d'  )  AS newdate1 from bid_account ba left join auction a on ba.auction_id=a.auctionID where a.categoryID='".$obj->categoryID."' and bid_flag='d' and bidding_type='s' and bidpack_buy_date>='$startdate 00:00:01' and bidpack_buy_date<='$enddate 23:59:59' group by a.categoryID";
				$rs1 = mysql_query($qr1);
				$ob1 = mysql_fetch_object($rs1);

				$qr2 = "select *,sum(bid_count) as totalbidbutlerbid,DATE_FORMAT( bidpack_buy_date,  '%Y-%m-%d'  )  AS newdate2 from bid_account ba left join auction a on ba.auction_id=a.auctionID where a.categoryID='".$obj->categoryID."' and bid_flag='d' and bidding_type='b' and bidpack_buy_date>='$startdate 00:00:01' and bidpack_buy_date<='$enddate 23:59:59' group by a.categoryID";
				$rs2 = mysql_query($qr2);
				$ob2 = mysql_fetch_object($rs2);

				$qr3 = "select *,sum(bid_count) as totalsmsbid,DATE_FORMAT( bidpack_buy_date,  '%Y-%m-%d'  )  AS newdate3 from bid_account ba left join auction a on ba.auction_id=a.auctionID where a.categoryID='".$obj->categoryID."' and bid_flag='d' and bidding_type='m' and bidpack_buy_date>='$startdate 00:00:01' and bidpack_buy_date<='$enddate 23:59:59' group by a.categoryID";
				$rs3 = mysql_query($qr3);
				$ob3 = mysql_fetch_object($rs3);
		?>
				<TD width="7%" align="left" nowrap="nowrap"><?=$obj->categoryID?></TD>
				<TD width="30%" align="center"><?=$obj->catname; ?></TD>
				<TD width="10%" nowrap="nowrap" align="center"><?=$totalauc;?></TD>
				<TD width="10%" nowrap="nowrap" align="center"><?=$ob1->totalonlinebid!=""?$ob1->totalonlinebid:"0";?></TD>
				<TD width="10%" nowrap="nowrap" align="center"><?=$ob2->totalbidbutlerbid!=""?$ob2->totalbidbutlerbid:"0";?></TD>
				<TD width="10%" nowrap="nowrap" align="center"><?=$ob3->totalsmsbid!=""?$ob3->totalsmsbid:"0";?></TD>
				<TD width="10%" nowrap="nowrap" align="center"><?=$obj->totalbids;?></TD>
				<TD width="5%" nowrap="nowrap" align="center"><?=$totalauc!="0"?number_format($obj->totalbids/$totalauc,1):"0";?></TD>
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
		  <A class='paging' href="prefereditemreport.php?pgno=<?=$PrevPageNo;?>&<?=$urldata;?>">&lt; P&aacute;gina Anterior</A>
		  <?
		   }
		  ?> &nbsp;&nbsp;&nbsp;
		  <?php
			if($PageNo<$totalpage)
			{
			 $NextPageNo = 	$PageNo + 1;
		  ?>
		  <A class='paging' id='next' href="prefereditemreport.php?pgno=<?=$NextPageNo;?>&<?=$urldata;?>">Pr&amp;oacute;xima P&amp;aacute;gina &gt;</A>
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
