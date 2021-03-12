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
		
		  if($_POST["submit"]!="")
		  {
			$startdate = ChangeDateFormat($_POST["datefrom"]);
			$enddate = ChangeDateFormat($_POST["dateto"]);
			$uid = $_POST["userid"];
		  }
		  else
		  {
			$startdate = ChangeDateFormat($_GET["sdate"]);
			$enddate = ChangeDateFormat($_GET["edate"]);
			$uid = $_GET["uid"];
		  }

		$urldata = "sdate=".ChangeDateFormatSlash($startdate)."&edate=".ChangeDateFormatSlash($enddate)."&uid=".$uid;

		$qrysel = "select * from login_logout where user_id='0' and load_time >='".$startdate."' and load_time <= '".$enddate."'";
		$ressel = mysql_query($qrysel);
		$total = mysql_num_rows($ressel);
		
		$totalpage=ceil($total/$PRODUCTSPERPAGE);

		if($totalpage>=1)
		{
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
<script type="text/javascript" src="function.js"></script>
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
<title><? echo $ADMIN_MAIN_SITE_NAME." - Login Report"; ?></title>
</head>
<body>
<TABLE width="100%"  border=0 cellPadding=0 cellSpacing=10>
  <!--DWLayoutTable-->
    <TR> 
      <TD width="100%" class="H1">Relat&oacute;rio de usuarios n&atilde;o registrados</TD>
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
	<form name="f1" action="" method="post" onsubmit="return Check(this)">	
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
							  <div align="center">Sem informa&ccedil;&otilde;es para exibir</div>
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
	?>
	<TR>
    	<TD width="400px"><!--content-->
          <TABLE width="50%" border=1 cellSpacing=0 class=t-a style="margin-left: 200px;">
            <!--DWLayoutTable-->
              <TR class=th-a> 
				<!--<TD nowrap width="5%">User Id</TD>-->
				<TD width="70%" align="center" nowrap="nowrap">IP </TD>
				<TD width="10%" align="center" nowrap="nowrap">Data de Visita</TD>
				<TD width="20%" nowrap="nowrap" align="center">Hora de Visita</TD>
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
		?>
				<TD width="70%" align="center" nowrap="nowrap"><?=$obj->ipaddress;?></TD>
				<TD width="10%" align="center" nowrap="nowrap"><?=arrangedate(substr($obj->load_time,0,10));?></TD>
				<TD width="10%" align="center" nowrap="nowrap"><?=substr($obj->load_time,11);?></TD>
			 </TR>
		<?
			}
		?>		
		 </TABLE>
		</TD>
	</TR>
	 </TD>
	 </TR>	
	</TABLE>	 
	<table border="0" align="center">
	<tr>
		<td>
		  <?
			if($PageNo>1)
			{
			  $PrevPageNo = $PageNo-1;
		  ?>
		  <A class='paging' href="nonregistreduserreport.php?pgno=<?=$PrevPageNo;?>&<?=$urldata;?>">&lt; P&aacute;gina Anterior</A>
		  <?
		   }
		  ?> &nbsp;&nbsp;&nbsp;
		  <?php
			if($PageNo<$totalpage)
			{
			 $NextPageNo = 	$PageNo + 1;
		  ?>
		  <A class='paging' id='next' href="nonregistreduserreport.php?pgno=<?=$NextPageNo;?>&<?=$urldata;?>">Pr&amp;oacute;xima P&amp;aacute;gina &gt;</A>
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
