<?php
	include_once("admin.config.inc.php");
	include("connect.php");
	include("functions.php");
	include("security.php");
	$PRODUCTSPERPAGE = 10;
	$PageNo = 1;
	if($_POST["submit"]!="" || $_GET["sdate"]!=""){
		if($_GET['pgno']) $PageNo = $_GET['pgno'];

	    if($_POST["submit"]!=""){
		    $startdate = ChangeDateFormat($_POST["datefrom"]);
		    $enddate = ChangeDateFormat($_POST["dateto"]);
		    $product = $_POST["products"];
	    }else{
			$startdate = ChangeDateFormat($_GET["sdate"]);
			$enddate = ChangeDateFormat($_GET["edate"]);
			$product = $_GET["prod"];
	    }

		$urldata = "sdate=".ChangeDateFormatSlash($startdate)."&edate=".ChangeDateFormatSlash($enddate)."&prod=".$product;
		
		$qrysel = "select *,sum(bid_count) as totalbids from auction a left join products p on a.productID=p.productID  left join bid_account ba on a.auctionID=ba.auction_id where a.productID='$product' and a.auc_start_date>='$startdate' and a.auc_end_date<='$enddate'  and bid_flag='d' group by ba.auction_id";
		
		$qrysel2=$qrysel;
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
<link rel="stylesheet" href="main.css" type="text/css">
<title><? echo $ADMIN_MAIN_SITE_NAME." - Finincial Report"; ?></title>
<link href="zpcal/themes/aqua.css" rel="stylesheet" type="text/css" media="all" title="Calendar Theme - aqua.css" />
<script type="text/javascript" src="zpcal/src/utils.js"></script>
<script type="text/javascript" src="zpcal/src/calendar.js"></script>
<script type="text/javascript" src="zpcal/lang/calendar-en.js"></script>
<script type="text/javascript" src="zpcal/src/calendar-setup.js"></script>
<script language="javascript">
	function Check(f1){	
		if(document.f1.datefrom.value==""){
			alert("Por favor selecione a data inicial!!!");
			document.f1.datefrom.focus();
			return false;
		}
		if(document.f1.dateto.value==""){
			alert("Por favor selecione a data final!!!");
			document.f1.dateto.focus();
			return false;
		}
		if(document.f1.products.value=="none"){
			alert("Por favor selecione o produto!!!");
			document.f1.products.focus();
			return false;
		}
	}
	function OpenPopup(url){
		window.open(url,'popupWindow','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=no,copyhistory=no,width=100,height=100,screenX=300,screenY=350,top=300,left=350');
		
	}
</script>
</head>

<body>
<TABLE width="100%"  border=0 cellPadding=0 cellSpacing=10>
  <!--DWLayoutTable-->
    <TR> 
      <TD width="100%" class="H1">Relat&oacute;rio Financeiro</TD>
    </TR>
  	<TR>
    <TD background="images/vdots.gif"><IMG height=1 src="images/spacer.gif" width=1 border=0 /></TD>
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
	<form name="f1" action="" method="post" onsubmit="return Check(this)">	
	<tr>
		<td align="center"><b>De</b> : <input class="textbox" type="text" name="datefrom" id="datefrom" size="12" value="<?=$startdate!=""?ChangeDateFormatSlash($startdate):"";?>">&nbsp;&nbsp;<img src="images/pmscalendar.gif" align="absmiddle" width="20" height="20" id="vfrom">&nbsp;&nbsp;-&nbsp;&nbsp; <b>&agrave;</b> : <input class="textbox" type="text" name="dateto" size="12" id="dateto" value="<?=$enddate!=""?ChangeDateFormatSlash($enddate):"";?>">&nbsp;&nbsp;<img src="images/pmscalendar.gif" align="absmiddle" width="20" height="20" id="zfrom">&nbsp;&nbsp;</font></td>
	</tr>
	<tr>

		<td height="5"></td>
	</tr>
	<tr>
		<td align="center">
			<b>Produtos :&nbsp;</b>
	<?
		$qrr="select * from products order by name";
		$resp = mysql_query($qrr) or die(mysql_error());
		$totalp = mysql_num_rows($resp);	
	?>
		<select name="products" class="solidinput" style="width: 250px;">
			<option value="none">Por favor selecione</option>
			<? if($totalp>0){
				while($roww=mysql_fetch_array($resp)){	
			?>
				<option <?=$product==$roww["productID"]?"selected":"";?> value="<?=$roww["productID"];?>"><?=$roww["name"];?></option>			
			<?
				}			
			 } 
			?>
		</select>
		</td>
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
    	<table border="0">
        	<tr>
            	<td>&nbsp;</td>
            </tr>
            <tr>
            	<Td style="font-weight: bold; font-size: 14px;"><?=GetProductName($product);?></Td>
            </tr>
        </table>
          <TABLE width="100%" border=1 cellSpacing=0 class=t-a>
            <!--DWLayoutTable-->
              <TR class=th-a> 
				<!--<TD nowrap width="5%">User Id</TD>-->
				<TD width="7%" align="left" nowrap="nowrap">Leil&atilde;o ID</TD>
				<TD nowrap="nowrap" align="left">Pre&ccedil;o do Produto</TD>
				<TD nowrap="nowrap" align="left">Pre&ccedil;o Inicial</TD>
				<!--TD align="left" nowrap="nowrap">Pre&ccedil;o Fixo</TD-->
				<TD nowrap="nowrap" align="left">Pre&ccedil;o Final</TD>
				<TD nowrap="nowrap" align="center">Total de lances<br />(Real + Admin)</TD>
				<TD nowrap="nowrap" align="center">Valor de lances<br />(Real)</TD>
				<TD nowrap="nowrap" align="left">Situa&ccedil;&atilde;o</TD>
				<TD nowrap="nowrap" align="left">Lucro/Preju&iacute;zo</TD>
				<TD width="4%" align="center" nowrap="nowrap">Op&ccedil;&otilde;es</TD>
			 </TR>
		<?
			while($obj = mysql_fetch_object($ressel))
			{
				if($obj->auc_status=="1") { $status = "<font color='green'>Futuro</font>"; }
				elseif($obj->auc_status=="2") { $status = "<font color='red'>Ativo</font>"; }
				elseif($obj->auc_status=="3") { $status = "<font color='blue'>Vencido</font>"; }
				elseif($obj->auc_status=="4") { $status = "<font color='green'>Pendente</font>"; }
				
				if ($colorflg==1){
					$colorflg=0;
					echo "<TR bgcolor=\"#f4f4f4\"> ";
				}else{
					$colorflg=1;
				  	echo "<TR> ";
				}
					
					$numberbids = explode("|",GetBidsDetails($obj->auctionID));
				
					$bidamount = number_format($numberbids[0] * 0.50,2,',','.');
					
					$price = $obj->price;
					if($obj->fixedpriceauction=="1") { $fprice = $obj->auc_fixed_price; }
					elseif($obj->offauction=="1") { $fprice = "0,00"; }
					else { $fprice = $obj->auc_final_price; }
					
					$prloss = $fprice + $bidamount - $price;
					if($prloss<0)
					{
						$prloss1 = "<font color='red'>".$Currency.number_format($prloss,2,',','.')."</font>";
					}
					else
					{
						$prloss1 = "<font color='green'>".$Currency.number_format($prloss,2,',','.')."</font>";
					}
		?>
				<TD align="left" nowrap="nowrap"><?=$obj->auctionID;?></TD>
				<td align="right" nowrap="nowrap"><?=$Currency.number_format($obj->price,2,',','.');?>
				<TD nowrap="nowrap" align="right"><?=$Currency.($obj->auc_start_price!=""?number_format($obj->auc_start_price,2,',','.'):"0,00");?></TD>
				<!--TD align="right" nowrap="nowrap"><?=$Currency.($obj->auc_fixed_price!=""?number_format($obj->auc_fixed_price,2,',','.'):"0,00");?></TD-->
				<TD nowrap="nowrap" align="right"><?=$Currency.($obj->auc_final_price!=""?number_format($obj->auc_final_price,2,',','.'):"0,00");?></TD>
				<td align="center"><?=$numberbids[0]!=""?$numberbids[0]:"0"?> + <?=$numberbids[1]!=""?$numberbids[1]:"0";?></td>
				<TD align="right" nowrap="nowrap"><?=$Currency.($bidamount!=""?number_format($bidamount,2,',','.'):"0,00")?></TD>
				<TD nowrap="nowrap" align="center"><?=$status;?></TD>
				<td align="right"><?=$prloss1;?></td>
				<TD width="21%" align="center" nowrap="nowrap">
					<input type="button" name="details" class="bttn" value="Detalhes" onClick="window.location.href='auctiondetails.php?aid=<?=$obj->auctionID;?>'" />
				</TD>
			</tr>
		<?
			$bidamount="";
			//$prloss1="";
			}
		?>		
		 </TABLE>
		  <?
			if($PageNo>1)
			{
			  $PrevPageNo = $PageNo-1;
		  ?>
		  <A class='paging' href="finincialreport.php?pgno=<?=$PrevPageNo;?>&<?=$urldata;?>">&lt; P&aacute;gina Anterior</A>
		  <?
		   }
		  ?> &nbsp;&nbsp;&nbsp;
		  <?php
			if($PageNo<$totalpage)
			{
			 $NextPageNo = 	$PageNo + 1;
		  ?>
		  <A class='paging' id='next' href="finincialreport.php?pgno=<?=$NextPageNo;?>&<?=$urldata;?>">Pr&amp;oacute;xima P&amp;aacute;gina &gt;</A>
		  <?
		   }
		  ?>
			  <!-- paging ends -->
	<?
		
		}
	}
	 ?>
	 <?
		if($total>0)
		{
			?>
			<!--br /><br />
			<table align="center">
			<tr>
			<td><input type="button" name="submit" class="bttn" value="Exportar em CSV" onclick="OpenPopup('download.php?export=financial&datefrom=<?=$_POST["datefrom"]?>&dateto=<?=$_POST["dateto"]?>&products=<?=$_POST["products"]?>')" /></td>
			</tr>
			</table-->
			<?
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
</TABLE>	
</body>
</html>
