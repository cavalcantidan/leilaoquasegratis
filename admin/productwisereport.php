<?php
	include_once("admin.config.inc.php");
	include("connect.php");
	include("functions.php");
	include("security.php");
	$PRODUCTSPERPAGE = 10;
	$PageNo = 1;
	if($_GET['pgno']&&$_POST["submit"]==""){$PageNo = $_GET['pgno'];}

	if($_POST["submit"]!="" || $_GET["sdate"]!=""){

		if($_POST["submit"]!=""){
			$startdate = $_POST["datefrom"]!=''?ChangeDateFormat($_POST["datefrom"]):'';
			$enddate   = $_POST["dateto"]!=''?ChangeDateFormat($_POST["dateto"]):'';
			$product   = $_POST["products"];
			$auctionstatus = $_POST["auctionstatus"];
		}else{
			$startdate = $_GET["sdate"]!=''?ChangeDateFormat($_GET["sdate"]):'';
			$enddate   = $_GET["edate"]!=''?ChangeDateFormat($_GET["edate"]):'';
			$auctionstatus = $_GET["stat"];
			$product   = $_GET["prod"];
		}
		$urldata = "sdate=".($startdate!=''?ChangeDateFormatSlash($startdate):'')."&edate=".($enddate!=''?ChangeDateFormatSlash($enddate):'')."&stat=".$auctionstatus."&prod=".$product;

		$qrysel = "select * from auction a left join products p on a.productID=p.productID where a.productID='$product'";
		if($startdate!="") $qrysel .= " and a.auc_start_date>='$startdate'";
		if($enddate!="") $qrysel .= " and auc_end_date<='$enddate'";
        if($auctionstatus!=""){
			if($auctionstatus=="1"){
				$qrysel .= " and (a.auc_status='1' or a.auc_status='2')";
			}else{
				$qrysel .= " and a.auc_status='$auctionstatus'";
			}
		}
        //echo $qrysel."<br /><br />";
		$ressel = mysql_query($qrysel);
		$total = mysql_num_rows($ressel);

		$totalpage=ceil($total/$PRODUCTSPERPAGE);

		if($totalpage>=1){
			$startrow=$PRODUCTSPERPAGE*($PageNo-1);
			$qrysel.=" LIMIT $startrow,$PRODUCTSPERPAGE";
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
<title><? echo $ADMIN_MAIN_SITE_NAME." - Relat&oacute;rio por Produto"; ?></title>
<script language="javascript">
	function Check(f1){	
		if(document.f1.products.value=="none")
		{
			alert("Por favor selecione um produto!!!");
			return false;
			document.f1.products.focus();
		}
	}
</script>
</head>

<body>
<TABLE width="100%"  border=0 cellPadding=0 cellSpacing=10>
  <!--DWLayoutTable-->
    <TR> 
      <TD width="100%" class="H1">Relat&oacute;rio Por Produto</TD>
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
	<tr>
		<td height="5"></td>
	</tr>
	<form name="f1" action="" method="post" onsubmit="return Check(this)">	
	<tr>
		<td height="5"></td>
	</tr>
	<tr>
		<td align="center">
			<b>* Produto :&nbsp;</b>
	<?
		$qrr="select * from products order by name";
		$resp = mysql_query($qrr) or die(mysql_error());
		$totalp = mysql_num_rows($resp);	
	?>
		<select name="products" class="solidinput" style="width: 250px;">
			<option value="none">Por favor selecione</option>
			<? if($totalp>0)
			{
				while($roww=mysql_fetch_array($resp))
				{	
			?>
				<option <?=$product==$roww["productID"]?"selected":"";?> value="<?=$roww["productID"];?>"><?=stripslashes($roww["name"]);?></option>			
			<?
				}			
			 } 
			?>
		</select>
		</td>
	</tr>
	<tr>
		<td align="center" class="h2"><b>Per&iacute;odo</b></td>
	</tr>
	<tr>
		<td align="center"><b>De</b> : <input class="textbox" type="text" name="datefrom" id="datefrom" size="12" value="<?=$startdate!=""?ChangeDateFormatSlash($startdate):"";?>">&nbsp;&nbsp;<img src="images/pmscalendar.gif" align="absmiddle" width="20" height="20" id="vfrom">&nbsp;&nbsp;
        -&nbsp;&nbsp;<b>&agrave;</b> : <input class="textbox" type="text" name="dateto" size="12" id="dateto" value="<?=$enddate!=""?ChangeDateFormatSlash($enddate):"";?>">&nbsp;&nbsp;<img src="images/pmscalendar.gif" align="absmiddle" width="20" height="20" id="zfrom">&nbsp;&nbsp;</font></td>
	</tr>
    <tr>
		<td height="5"></td>
	</tr>
	<tr>
		<td align="center">
			<b>Situa&ccedil;&atilde;o do Leil&atilde;o :&nbsp;</b>
		    <select name="auctionstatus" class="solidinput">
			<option <?=$auctionstatus==""?"selected":"";?> value="">Selecione</option>
			<option <?=$auctionstatus=="1"?"selected":"";?> value="1">Futuro</option>
			<option <?=$auctionstatus=="3"?"selected":"";?> value="2">Ativo</option>
			<option <?=$auctionstatus=="3"?"selected":"";?> value="3">Vendido</option>
			<option <?=$auctionstatus=="4"?"selected":"";?> value="4">Pendente</option>
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
							  <div align="center">Sem informa&ccedil;&otilde;es para exibir.</div>
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
				<TD width="7%" align="left" nowrap="nowrap">Leil&atilde;o  ID</TD>
				<!--TD width="20%" nowrap="nowrap" align="center">Tipo de Leil&atilde;o</TD-->
				<TD nowrap="nowrap" align="left">Pre&ccedil;o inicial</TD>
				<TD align="left" nowrap="nowrap">Pre&ccedil;o Fixo</TD>
				<TD nowrap="nowrap" align="left">Data Final</TD>
				<TD nowrap="nowrap" align="left">Situa&ccedil;&atilde;o</TD>
				<TD width="4%" align="center" nowrap="nowrap">O&ccedil;&otilde;es</TD>
			 </TR>
		<?
			while($obj = mysql_fetch_object($ressel))
			{
				if($obj->fixedpriceauction=="1") { $auctype = "Fixed Price Auction"; }
				if($obj->pennyauction=="1") { $auctype = "1 Centavo"; }
				if($obj->nailbiterauction=="1") { $auctype = "NailBiter Auction"; }
				if($obj->offauction=="1") { $auctype = "100% Off Auction"; }
				if($obj->nightauction=="1") { $auctype = "Night Auction"; }
				if($obj->openauction=="1") { $auctype = "Open Auction"; }
			
				if($obj->auc_status=="1") { $status = "<font color='green'>Futuro</font>"; }
				elseif($obj->auc_status=="2") { $status = "<font color='red'>Ativo</font>"; }
				elseif($obj->auc_status=="3") { $status = "<font color='blue'>Vendido</font>"; }
				elseif($obj->auc_status=="4") { $status = "<font color='green'>Pendente</font>"; }
				
				if ($colorflg==1){
					$colorflg=0;
					echo "<TR bgcolor=\"#f4f4f4\"> ";
				}else{
					$colorflg=1;
				  	echo "<TR> ";
				}
		?>
				<TD nowrap="nowrap" align="center"><?=$obj->auctionID;?></TD>
				<!--TD nowrap="nowrap" align="center"><?=$auctype!=""?$auctype:"";?></TD-->
				<TD nowrap="nowrap" align="right"><?=$Currency.number_format($obj->auc_start_price,2,',','.');?></TD>
				<TD nowrap="nowrap" align="right"><?=$Currency.number_format($obj->auc_fixed_price,2,',','.');?></TD>
				<TD nowrap="nowrap" align="center"><?=substr(ChangeDateFormatSlash($obj->auc_final_end_date),0,10);?></TD>
				<TD nowrap="nowrap" align="center"><?=$status;?></TD>
				<TD width="21%" align="center" nowrap="nowrap">
					<input type="button" name="details" class="bttn" value="Detalhes" onclick="window.location.href='auctiondetails.php?aid=<?=$obj->auctionID;?>'" />
				</TD>
			</tr>
		<?
			}
		?>		
		 </TABLE>
		  <?
			if($PageNo>1){
			  $PrevPageNo = $PageNo-1;
		  ?>
		  <A class='paging' href="productwisereport.php?pgno=<?=$PrevPageNo;?>&<?=$urldata;?>">&lt; P&aacute;gina Anterior</A>
		  <?
		   }
		  ?> &nbsp;&nbsp;&nbsp;
		  <?php
			if($PageNo<$totalpage){
			 $NextPageNo = 	$PageNo + 1;
		  ?>
		  <A class='paging' id='next' href="productwisereport.php?pgno=<?=$NextPageNo;?>&<?=$urldata;?>">Pr&amp;oacute;xima P&amp;aacute;gina &gt;</A>
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
