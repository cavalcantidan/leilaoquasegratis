<?
	include("config.inc.php");
	include("security.php");
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
		/*if(document.f1.listtype[1].checked==true && (document.f1.auctionstatus_future.checked==true || document.f1.auctionstatus_running.checked==true))
		{
			alert("Você não pode selecionar leilões futuros ou ativos para lista de agregados!!!");
			return false;
		} */
	}
</script>
</head>

<body>
<TABLE width="100%"  border=0 cellPadding=0 cellSpacing=10>
  <!--DWLayoutTable-->
    <TR> 
        <TD width="100%" class="H1">Buscar Leil&atilde;o</TD>
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
		<td align="center" class="h2"><b>Por favor selecione a data</b></td>
	</tr>
	<tr>
		<td height="5"></td>
	</tr>
	<form action="searchauctionresult.php" method="post" name="f1" onsubmit="return Check(this)">	
	<tr>
		<td align="center"><b>De</b> : <input class="textbox" type="text" name="datefrom" id="datefrom" size="12" value="<?=$startdate!=""?ChangeDateFormatSlash($startdate):"";?>">&nbsp;&nbsp;<img src="images/pmscalendar.gif" align="absmiddle" width="20" height="20" id="vfrom">&nbsp;&nbsp;-&nbsp;&nbsp; <b>&agrave;</b> : <input class="textbox" type="text" name="dateto" size="12" id="dateto" value="<?=$enddate!=""?ChangeDateFormatSlash($enddate):"";?>">&nbsp;&nbsp;<img src="images/pmscalendar.gif" align="absmiddle" width="20" height="20" id="zfrom">&nbsp;&nbsp;</font></td>
	</tr>
	<tr>
		<td height="3"></td>
	</tr>
	<tr>
		<td align="center" class="h2"><strong>Leil&atilde;o ID:</strong> 
		  <input type="text" value="<?=$aid;?>" size="10" name="auctionid" />
	</td>
	<tr>
		<td height="3"></td>
	</tr>
	<tr>
		<td align="center" class="h2">
			<table border="0">
				<tr>
					<td width="100" rowspan="4" colspan="2" align="right"><strong>Buscar em:</strong> </td>
				</tr>
				<tr>
					<td align="left" nowrap="nowrap"><input type="checkbox" name="auctionstatus_running" value="2" />
					&nbsp;Iniciado</td>
					<td align="left" nowrap="nowrap"><input type="checkbox" name="auctionstatus_ended" value="3" />
					&nbsp;Finalizado</td>
				</tr>
				<tr>
					<td align="left" nowrap="nowrap"><input type="checkbox" name="auctionstatus_future" value="1" />
					&nbsp;Futuro</td>
					<td align="left" nowrap="nowrap"><input type="checkbox" name="auctionstatus_pendente" value="4" />
					&nbsp;Pendente</td>
				</tr>
			</table>
	</td>
	</tr>
	<tr>
		<td height="3"></td>
	</tr>
	<tr>
		<td align="center" class="h2">
			<table border="0">
				<tr>
					<td width="100" rowspan="4" colspan="2" align="right"><strong>Ordernar Por:</strong> </td>
				</tr>
				<tr>
					<td width="40%" align="left"><input type="radio" name="orderby" value="code" checked="checked" />
					&nbsp;Codigo</td>
					<td align="left" nowrap="nowrap"><input type="radio" name="orderby" value="datestart" />
					&nbsp;Data de In&iacute;cio</td>
				</tr>
				<tr>
					<td width="40%" align="left"><input type="radio" name="orderby" value="dateend" />
					&nbsp;Data de Finaliza&ccedil;&atilde;o</td>
					<td align="left" nowrap="nowrap"><input type="radio" name="orderby" value="category" />
					&nbsp;Categoria</td>
				</tr>
				<tr>
					<td width="40%" align="left" nowrap="nowrap"><input type="radio" name="orderby" value="itemname" />
					&nbsp;Nome do Item</td>
				</tr>
			</table>
	</td>
	</tr>
	<tr>
		<td align="center" class="h2">
			<table border="0">
				<tr>
					<td width="100" rowspan="4" colspan="2" align="right"><strong>Tipo de Relat&oacute;rio:</strong> </td>
				</tr>
				<tr>
					<td width="40%" align="left" nowrap="nowrap"><input type="radio" name="listtype" value="list" checked="checked" />
					&nbsp;Lista</td>
					<td align="left" nowrap="nowrap"><input type="radio" name="listtype" value="aggregate" />
					&nbsp;Agregado</td>
				</tr>
			</table>
	</td>
	</tr>
	<tr>
		<td height="3"></td>
	</tr>
	<tr>
		<td align="center"><input type="submit" name="submit" value="Buscar" class="bttn-s"></td>
	</tr>
	</form>
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
