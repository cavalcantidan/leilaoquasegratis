<?
	include_once("admin.config.inc.php");
	include("connect.php");
	include("functions.php");
	include("security.php");
	$type1 = "1";
	$type2 = "2";
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
			}
			else
			{
					$startdate = ChangeDateFormat($_GET["sdate"]);
					$enddate = ChangeDateFormat($_GET["edate"]);
			}
			$urldata = "sdate=".ChangeDateFormatSlash($startdate)."&edate=".ChangeDateFormatSlash($enddate);
		
		$qrysel = "select *,sum(bid_count) as totalbid from bid_account where bid_flag='d' and bidding_type='m' and bidpack_buy_date>='$startdate 00:00:01' and bidpack_buy_date<='$enddate 23:59:59' group by auction_id";
		
		$ressel = mysql_query($qrysel);
		$total = mysql_num_rows($ressel);
		$totalpage=ceil($total/$PRODUCTSPERPAGE);
		
		$qr = "select * from general_setting where id='1'";
		$rs = mysql_query($qr);
		$ob = mysql_fetch_object($rs);

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
<title><? echo $ADMIN_MAIN_SITE_NAME." - SMS Monetary Value"; ?></title>
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
      <TD width="100%" class="H1">Relat&oacute;rio Monet&aacute;rio de SMS</TD>
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
				<TD width="7%" align="left" nowrap="nowrap">Total lances por sms</TD>
				<TD width="10%" align="center">Taxa de lance SMS(vat incl)</TD>
				<TD width="10%" align="center">OPERADORA (per SMS)</TD>
				<TD width="10%" align="center">Valor Total por Operadora</TD>
				<TD width="10%" align="center">SMS Gateway(per SMS)</TD>
				<TD width="10%" align="center">Valor total por Gatway sms</TD>
				<TD width="10%" align="center">Outros Custos(per SMS)</TD>
				<TD width="10%" align="center">Outros Custos Totais</TD>
				<TD width="10%"  align="center">Lucro de lance por SMS</TD>
				<TD width="10%" align="center">Valor Total</TD>
				<TD width="10%" align="center">Lucro</TD>
			 </TR>
		<?
			while($obj = mysql_fetch_object($ressel))
			{
				$totalsmsbid1 = $obj->totalbid + $totalsmsbid;
				$totalsmsbid = $totalsmsbid1;
			}
		?>
				<TD align="center" nowrap="nowrap"><?=$totalsmsbid;?></TD>
				<TD nowrap="nowrap" align="center"><?=$Currency."&nbsp;".$ob->smsrateincl;?></TD>
				<TD width="10%" align="center"><?=$Currency."&nbsp;".number_format(($ob->smsrateincl*$ob->mobileoperator)/100,2);?></TD>
				<TD width="10%" align="center"><?=$Currency."&nbsp;".number_format((($ob->smsrateincl*$ob->mobileoperator)/100)*$totalsmsbid,2);?></TD>
				<TD width="10%" align="center"><?=$Currency."&nbsp;".number_format(($ob->smsrateincl*$ob->smsgateway)/100,2);?></TD>
				<TD width="10%" align="center"><?=$Currency."&nbsp;".number_format((($ob->smsrateincl*$ob->smsgateway)/100)*$totalsmsbid,2);?></TD>
				<TD width="10%" align="center"><?=$Currency."&nbsp;".number_format(($ob->smsrateincl*$ob->othercost)/100,2);?></TD>
				<TD width="10%" align="center"><?=$Currency."&nbsp;".number_format((($ob->smsrateincl*$ob->othercost)/100)*$totalsmsbid,2);?></TD>
				<TD nowrap="nowrap" align="center"><?=$Currency."&nbsp;".number_format(($ob->smsrateincl*$ob->netsave)/100,2);?></TD>
				<TD align="center" nowrap="nowrap"><?=$Currency."&nbsp;".number_format(($ob->smsrateincl*$totalsmsbid),2);?></TD>
				<TD align="center" nowrap="nowrap"><?=$Currency."&nbsp;".number_format((($ob->smsrateincl*$ob->netsave)/100)*$totalsmsbid,2);?></TD>
			</tr>
		 </TABLE>
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
