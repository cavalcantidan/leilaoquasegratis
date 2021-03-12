<?
	include_once("admin.config.inc.php");
	include("connect.php");
	include("functions.php");
	include("security.php");
	$type1 = "1";
	$type3 = "2";
	include("pagepermission.php");

	$querysmscharge = "select * from general_setting where id='1'";
	$ressmscharge = mysql_query($querysmscharge);
	$objsmscharge = mysql_fetch_object($ressmscharge);
	$SMSCHARGE = $objsmscharge->smsrateincl;

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

		$qrysel = "select *,sum(actual_cost) as totalcost,c.name as catname from auction a left join  categories c on a.categoryID=c.categoryID left join products p on a.productID=p.productID where auc_start_date>='$startdate' and auc_end_date<='$enddate' and auc_status='3' group by a.categoryID";
		if($cid!="")
		{
		$qrysel = "select *,sum(actual_cost) as totalcost,c.name as catname from auction a left join  categories c on a.categoryID=c.categoryID left join products p on a.productID=p.productID where auc_start_date>='$startdate' and auc_end_date<='$enddate' and auc_status='3' and a.categoryID='$cid' group by a.categoryID";
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
      <TD width="100%" class="H1">Relat&oacute;rio de lucro/perca por categoria</TD>
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
			$qrycat = "select * from categories";
			$rscat = mysql_query($qrycat);
			$totalcat = mysql_num_rows($rscat);
		?>
	    <select name="category" style="width: 280px;">
			<option value="">selecione</option>
			<?
				while($cat = mysql_fetch_object($rscat))
				{
			?>
				<option <?=$cat->categoryID==$cid?"selected":"";?> value="<?=$cat->categoryID;?>"><?=$cat->name;?></option>
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
				<TD width="7%" align="left" nowrap="nowrap">Categoria ID</TD>
				<TD width="25%" align="center">Nome</TD>
				<TD width="10%" nowrap="nowrap" align="center">Leil&otilde;es</TD>
				<TD width="10%" nowrap="nowrap" align="center">Custo total Atual(A)</TD>
				<TD width="10%" nowrap="nowrap" align="center">Pago ao ganhador(B)</TD>
				<TD width="10%" nowrap="nowrap" align="center">Valor do lance online(C)</TD>
				<TD width="10%" nowrap="nowrap" align="center">SMS<br />
				Valor do lance(D)</TD>
				<TD width="10%" nowrap="nowrap" align="center">Valor Total<br>(C + D)</TD>
				<TD width="10%" nowrap="nowrap" align="center">Valor Final<br>E = (B + C + D)</TD>
				<TD width="10%" nowrap="nowrap" align="center">Liquido<br />
				Lucro/Perca(E - A)</TD>
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
				
				$infopart = explode("|",GetPayAmountAndAuctions($obj->productID,$startdate,$enddate,$SMSCHARGE));
		?>
				<TD width="7%" align="left" nowrap="nowrap"><?=$obj->categoryID;?></TD>
				<TD width="25%" align="center" nowrap="nowrap"><?=$obj->catname;?></TD>
				<TD width="10%" nowrap="nowrap" align="center"><?=$infopart[1];?></TD>
				<TD width="10%" nowrap="nowrap" align="right"><?=$Currency;?><?=$obj->totalcost;?></TD>
				<TD width="10%" nowrap="nowrap" align="right"><?=$Currency;?><?=$infopart[2]!=""?number_format($infopart[2],2):"0.00";?></TD>
				<TD width="10%" nowrap="nowrap" align="right"><?=$Currency;?><?=$infopart[4]!=""?number_format($infopart[4],2):"0.00";?></TD>
				<TD width="10%" nowrap="nowrap" align="right"><?=$Currency;?><?=$infopart[5]!=""?number_format($infopart[5],2):"0.00";?></TD>
				<TD width="10%" nowrap="nowrap" align="right"><?=$Currency;?><?=$infopart[4]!=""?number_format($infopart[4] + $infopart[5],2):"0.00";?></TD>
				<TD width="10%" nowrap="nowrap" align="right"><?=$Currency;?><?=$infopart[0]!=""?number_format($infopart[0],2):"0.00";?></TD>
				<?
				$comgain = $infopart[0] - $obj->totalcost;
				if($comgain<0)
				{
					$comgain1 = "<font color='red'>-&euro;".substr(number_format($comgain,2),1)."</font>";
				}
				else
				{
					$comgain1 = "<font color='green'>&euro;".number_format($comgain,2)."</font>";
				}
				?>
				<TD width="10%" nowrap="nowrap" align="right"><?=$comgain1;?></TD>
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
		  <A class='paging' href="categoryfinincialreport.php?pgno=<?=$PrevPageNo;?>&<?=$urldata;?>">&lt; P&aacute;gina Anterior</A>
		  <?
		   }
		  ?> &nbsp;&nbsp;&nbsp;
		  <?php
			if($PageNo<$totalpage)
			{
			 $NextPageNo = 	$PageNo + 1;
		  ?>
		  <A class='paging' id='next' href="categoryfinincialreport.php?pgno=<?=$NextPageNo;?>&<?=$urldata;?>">Pr&amp;oacute;xima P&amp;aacute;gina &gt;</A>
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
