<?
	include_once("admin.config.inc.php");
	include("connect.php");
	include("functions.php");
	include("security.php");
	$PRODUCTSPERPAGE = 10;
	
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
				$status = $_POST["userstatus"];
				$startdate = ChangeDateFormat($_POST["datefrom"]);
				$enddate = ChangeDateFormat($_POST["dateto"]);
			}
			else
			{
					$startdate = ChangeDateFormat($_GET["sdate"]);
					$enddate = ChangeDateFormat($_GET["edate"]);
					$status =$_GET["status"];
			}
			$urldata = "sdate=".ChangeDateFormatSlash($startdate)."&edate=".ChangeDateFormatSlash($enddate)."&status=".$status;

		$qrysel = "select *,id as rid from registration where register_date>='".$startdate."' and register_date<='".$enddate."' order by id";	
		if($status=="1")
		{
		$qrysel = "select *,r.id as rid from bid_account ba left join registration r on r.id=ba.user_id where register_date>='".$startdate."' and register_date<='".$enddate."' group by ba.user_id order by r.id";
		}
		elseif($status=="2")
		{
		$qrysel = "select *,id as rid from registration where register_date>='".$startdate."' and register_date<='".$enddate."' order by id";	
		}
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
<title><? echo $ADMIN_MAIN_SITE_NAME." - User Report"; ?></title>
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
      <TD width="100%" class="H1">Relat&oacute;rio de Usu&aacute;rios</TD>
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
		<td align="center" class="h2">
			<b>Status: &nbsp;&nbsp;&nbsp;</b>
			<select name="userstatus">
				<option value="">selecione</option>
				<option <?=$status=="1"?"selected":"";?> value="1">Ativo</option>
				<option <?=$status=="2"?"selected":"";?> value="2">Inativo</option>
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
				<TD width="7%" align="left" nowrap="nowrap">Usu&aacute;rio ID</TD>
				<TD width="50%" nowrap="nowrap" align="center">Nome</TD>
				<TD width="20%" nowrap="nowrap" align="center">Indicado por</TD>
				<TD nowrap="nowrap" align="left">Data de Registro</TD>
				<TD width="15%" align="left" nowrap="nowrap">Status</TD>
				<TD width="4%" align="center" nowrap="nowrap">Op&ccedil;&otilde;es</TD>
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
				
				$qr = "select * from bid_account where user_id='".$obj->rid."' and bid_flag='c'";
				$rs = mysql_query($qr);
				$totalbid = mysql_num_rows($rs);
				
				if($totalbid>0)
				{
					$status1 = "<font color='green'>Active</font>";
				}
				else
				{
					$status1 = "<font color='red'>Not Active</font>";
				}
				
				if($obj->sponser>"0")
				{
					$qreg = "select * from registration where id='".$obj->sponser."'";
					$rseg = mysql_query($qreg);
					$objreg=mysql_fetch_object($rseg);
				}
				
				if($status==2)
				{
					if($status1 == "<font color='green'>Active</font>")
					{
						continue;
					}
				}
		?>
				<TD align="left" nowrap="nowrap"><?=$obj->rid;?></TD>
				<TD nowrap="nowrap" align="left"><?=$obj->username;?></TD>
				<TD nowrap="nowrap" align="left"><?=$objreg->username!=""?$objreg->username:"-";?></TD>
				<TD nowrap="nowrap" align="left"><?=arrangedate($obj->register_date);?></TD>
				<TD align="left" nowrap="nowrap"><?=$status1;?></TD>
				<TD width="21%" align="center" nowrap="nowrap">
				<? if($totalbid>"0"){ ?>
					<input type="button" name="details" class="bttn" value="Estatisticas" onclick="javascript: window.location.href='view_member_statistics.php?uid=<?=$obj->id;?>'" />
				<? } else { ?>
					<input type="button" name="details" class="bttn" value="Estatisticas" onclick="" />
				<? } ?>
				</TD>
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
		  <A class='paging' href="userreport.php?pgno=<?=$PrevPageNo;?>&<?=$urldata;?>">&lt; P&aacute;gina Anterior</A>
		  <?
		   }
		  ?> &nbsp;&nbsp;&nbsp;
		  <?php
			if($PageNo<$totalpage)
			{
			 $NextPageNo = 	$PageNo + 1;
		  ?>
		  <A class='paging' id='next' href="userreport.php?pgno=<?=$NextPageNo;?>&<?=$urldata;?>">Pr&amp;oacute;xima P&amp;aacute;gina &gt;</A>
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
