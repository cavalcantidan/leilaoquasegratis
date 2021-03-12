<?
	include_once("admin.config.inc.php");
	include("connect.php");
	include("functions.php");
	include("security.php");
	$type1 = "1";
	$type3 = "2";
	include("pagepermission.php");
	if($_POST["submit"]!="" || $_GET["sdate"]!=""){
		if(!$_GET['pgno']){
			$PageNo = 1;
		}else{
			$PageNo = $_GET['pgno'];
		}
		
		if($_POST["datefrom"]!=""){
			$startdate = ChangeDateFormat($_POST["datefrom"]);
			$enddate = ChangeDateFormat($_POST["dateto"]);
			$aid = $_POST["auctionid"];
		}else{
			$startdate = ChangeDateFormat($_GET["sdate"]);
			$enddate = ChangeDateFormat($_GET["edate"]);
			$aid = $_GET["aucid"];
		}
 
		$urldata = "sdate=".ChangeDateFormatSlash($startdate)."&edate=".ChangeDateFormatSlash($enddate)."&aucid=".$aid;
		$qrysel = "select *,p.name as productname from won_auctions w left join auction a on w.auction_id=a.auctionID left join registration r on w.userid=r.id left join products p on a.productID=p.productID where payment_date>='$startdate 00:00:01' and payment_date<='$enddate 23:59:59'";
		if($aid!=""){
			$qrysel = "select *,p.name as productname from won_auctions w left join auction a on w.auction_id=a.auctionID left join registration r on w.userid=r.id left join products p on a.productID=p.productID where w.auction_id='$aid'";			
		}
			
		$ressel = mysql_query($qrysel);
		$total = mysql_num_rows($ressel);
		$totalpage=ceil($total/$PRODUCTSPERPAGE);
		if($totalpage>=1){
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
<title><? echo $ADMIN_MAIN_SITE_NAME." - Relatorio Compra Confirmada!"; ?></title>
<script language="javascript">
	function Check(f1){
        if(document.f1.auctionid.value==""){
    		if(document.f1.datefrom.value==""){
    			alert("Por favor selecione a data inicial ou um id de leilão!");
    			return false;
    			document.f1.datefrom.focus();
    		}
    		if(document.f1.dateto.value==""){
    			alert("Por favor selecione a data final!");
    			return false;
    			document.f1.dateto.focus();
    		}
        }
	}
</script>
</head>
<body>
<table width="100%"  border=0 cellPadding=0 cellSpacing=10>
  <!--DWLayoutTable-->
    <tr> 
      <td width="100%" class="H1">Relatorio de Compra Confirmada</td>
    </tr>
  	<tr>
      <td background="images/vdots.gif"><img height=1 src="images/spacer.gif" width=1 border=0></td>
	</tr>
	<tr>
		<td height="10"></td>
	</tr>
	<tr><td height="5"></td></tr>
	<tr>
		<td align="center" class="h2"><b>Por Favor Selecione a Data</b></td>
	</tr>
	<tr><td height="5"></td></tr>
	<form action="" method="post" name="f1" onsubmit="return Check(this)">	
	<tr>
		<td align="center"><b>De</b> : <input class="textbox" type="text" name="datefrom" id="datefrom" size="12" value="<?=$startdate!=""?ChangeDateFormatSlash($startdate):"";?>" />&nbsp;&nbsp;<img src="images/pmscalendar.gif" align="absmiddle" width="20" height="20" id="vfrom" />&nbsp;&nbsp;-&nbsp;&nbsp; <b>&agrave;</b> : <input class="textbox" type="text" name="dateto" size="12" id="dateto" value="<?=$enddate!=""?ChangeDateFormatSlash($enddate):"";?>" />&nbsp;&nbsp;<img src="images/pmscalendar.gif" align="absmiddle" width="20" height="20" id="zfrom" />&nbsp;&nbsp;</font></td>
	</tr>
	<tr><td height="5"></td></tr>
	<tr><td height="5"></td></tr>
	<tr>
		<td align="center" class="h2"><strong>Leil&atilde;o ID:</strong><input type="text" value="<?=$aid;?>" size="10" name="auctionid" /></td>
	</tr>	
	<tr><td height="5"></td></tr>
	<tr><td height="5"></td></tr>
	<tr>
		<td align="center"><input type="submit" name="submit" value="Buscar" class="bttn-s" /></td>
	</tr>
	</form>
	<tr>
    	<td><!--content-->
		<? if(isset($total)){
			if($total==0){
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
	 	}else{
	?>
          <table width="100%" border="1" cellspacing="0" class="t-a">
            <!--DWLayoutTable-->
              <tr class="th-a"> 
				<!--<TD nowrap width="5%">User Id</TD>-->
				<TD width="7%" align="left" nowrap="nowrap">Leil&atilde;o  ID</TD>
				<TD width="30%" nowrap="nowrap" align="center">Nome</TD>
				<TD width="10%" nowrap="nowrap" align="center">Nome do Ganhador</TD>
				<TD nowrap="nowrap" align="left">Pre&ccedil;o Final</TD>
				<TD nowrap="nowrap" align="left">Data</TD>
				<TD align="left" nowrap="nowrap">Data de Pagamento</TD>
				<TD align="center" nowrap="nowrap">Op&ccedil;&otilde;es</TD>
			 </tr>
		<?
			while($obj = mysql_fetch_object($ressel)){
				if ($colorflg==1){
					$colorflg=0;
					echo "<tr bgcolor=\"#f4f4f4\"> ";
				}else{
					$colorflg=1;
				  	echo "<tr> ";
				}
				if($obj->fixedpriceauction=="1") { $fprice = $obj->auc_fixed_price; }
				else{ $fprice = $obj->auc_final_price; }
		?>
				<TD align="left" nowrap="nowrap"><?=$obj->auctionID;?></TD>
				<TD nowrap="nowrap" align="center"><?=$obj->productname;?></TD>
				<TD nowrap="nowrap" align="center"><?=$obj->username;?></TD>
				<TD nowrap="nowrap" align="left"><?=$Currency.$fprice;?></TD>
				<TD nowrap="nowrap" align="left"><?=substr(arrangedate($obj->won_date),0,10);?></TD>
				<TD align="left" nowrap="nowrap"><?=substr(arrangedate($obj->payment_date),0,10);?></TD>
				<TD align="left" nowrap="nowrap">
					<input type="button" name="details" class="bttn" value="Detalhes" onclick="javascript: window.location.href='auctiondetails.php?aid=<?=$obj->auctionID;?>'" />
				</TD>
			</tr>
		<?
			}
		?>		
		 </table>
		  <?
			if($PageNo>1)
			{
			  $PrevPageNo = $PageNo-1;
		  ?>
		  <a class='paging' href="confirmedpurchasereport.php?pgno=<?=$PrevPageNo;?>&<?=$urldata;?>">&lt; P&aacute;gina Anterior</a>
		  <?
		   }
		  ?> &nbsp;&nbsp;&nbsp;
		  <?php
			if($PageNo<$totalpage)
			{
			 $NextPageNo = 	$PageNo + 1;
		  ?>
		  <a class='paging' id='next' href="confirmedpurchasereport.php?pgno=<?=$NextPageNo;?>&<?=$urldata;?>">Pr&amp;oacute;xima P&amp;aacute;gina &gt;</a>
		  <?
		   }
		  ?>
	<?
		
		}
	}
	 ?>
	 </td>
	 </tr>
	</table>	 
<script type="text/javascript">
    var cal = new Zapatec.Calendar.setup({ inputField:"datefrom", ifFormat:"%d/%m/%Y", button:"vfrom", showsTime:false });
    var cal = new Zapatec.Calendar.setup({ inputField:"dateto", ifFormat:"%d/%m/%Y", button:"zfrom", showsTime:false });
</script>
</body>
</html>
