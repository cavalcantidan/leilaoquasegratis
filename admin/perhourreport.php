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
			$starttime = $_POST["starthour"].":".$_POST["startmin"].":".$_POST["startsec"];
			$endtime = $_POST["endhour"].":".$_POST["endmin"].":".$_POST["endsec"];
		  }
		  else
		  {
			$startdate = ChangeDateFormat($_GET["sdate"]);
			$enddate = ChangeDateFormat($_GET["edate"]);
			$uid = $_GET["uid"];
			$starttime = $_GET["stime"];
			$endtime = $_GET["etime"];
		  }

		$urldata = "sdate=".ChangeDateFormatSlash($startdate)."&edate=".ChangeDateFormatSlash($enddate)."&uid=".$uid."&stime=".$starttime."&etime=".$endtime;
		
		$qrysel = "SELECT *,DATE_FORMAT(login_time, '%Y-%m-%d')  AS logindate,DATE_FORMAT(logout_time, '%Y-%m-%d') as logoutdate 
FROM login_logout la left join registration r on la.user_id=r.id where login_time>='$startdate $starttime' and logout_time<='$enddate $endtime' and user_id!='0' group by user_id";
		if($uid!="")
		{
		$qrysel = "SELECT *,DATE_FORMAT(login_time, '%Y-%m-%d')  AS logindate,DATE_FORMAT(logout_time, '%Y-%m-%d') as logoutdate 
FROM login_logout la left join registration r on la.user_id=r.id where login_time>='$startdate $starttime' and logout_time<='$enddate $endtime' and user_id='$uid' group by user_id";
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
		if(document.f1.starthour.value=="")
		{
			alert("Por favor selecione start hour!!!");
			document.f1.starthour.focus();
			return false;
		}
		if(document.f1.startmin.value=="")
		{
			alert("Por favor selecione start minute!!!");
			document.f1.startmin.focus();
			return false;
		}
		if(document.f1.startsec.value=="")
		{
			alert("Por favor selecione start second!!!");
			document.f1.startsec.focus();
			return false;
		}
		if(document.f1.endhour.value=="")
		{
			alert("Por favor selecione end hour!!!");
			document.f1.endhour.focus();
			return false;
		}
		if(document.f1.endmin.value=="")
		{
			alert("Por favor selecione end minute!!!");
			document.f1.endmin.focus();
			return false;
		}
		if(document.f1.endsec.value=="")
		{
			alert("Por favor selecione end second!!!");
			document.f1.endsec.focus();
			return false;
		}
	}
</script>
<title><? echo $ADMIN_MAIN_SITE_NAME." - Login Report"; ?></title>
</head>
<body>
<TABLE width="100%"  border=0 cellPadding=0 cellSpacing=10>
  <!--DWLayoutTable-->
    <TR> 
      <TD width="100%" class="H1">Tempo m&eacute;dio de login/logout por hora</TD>
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
		<td align="center"><b>Selecione o horario: </b>
		  <select name="starthour">
			<option value="">hh</option>
			<?
				$timeset = explode(":",$starttime);
				$timesetend = explode(":",$endtime);
				for($h=0;$h<=23;$h++)
				{
			?>
				<option <?=$h==$timeset[0]?"selected":"";?> value="<?=str_pad($h,2,'0',STR_PAD_LEFT);?>"><?=str_pad($h,2,'0',STR_PAD_LEFT);?></option>
			<?
				}
			?>
		</select>
		<select name="startmin">
			<option value="">mm</option>
			<?
				for($m=0;$m<=59;$m++)
				{
			?>
				<option <?=$m==$timeset[1]?"selected":"";?> value="<?=str_pad($m,2,'0',STR_PAD_LEFT);?>"><?=str_pad($m,2,'0',STR_PAD_LEFT);?></option>
			<?
				}
			?>
		</select>
		<select name="startsec">
			<option value="">ss</option>
			<?
				for($s=0;$s<=59;$s++)
				{
			?>
				<option <?=$s==$timeset[2]?"selected":"";?> value="<?=str_pad($s,2,'0',STR_PAD_LEFT);?>"><?=str_pad($s,2,'0',STR_PAD_LEFT);?></option>
			<?
				}
			?>
		</select>
		&nbsp;&nbsp; <b>a</b> &nbsp;&nbsp;
				<select name="endhour">
			<option value="">hh</option>
			<?
				for($h=0;$h<=23;$h++)
				{
			?>
				<option <?=$h==$timesetend[0]?"selected":"";?> value="<?=str_pad($h,2,'0',STR_PAD_LEFT);?>"><?=str_pad($h,2,'0',STR_PAD_LEFT);?></option>
			<?
				}
			?>
		</select>
		<select name="endmin">
			<option value="">mm</option>
			<?
				for($m=0;$m<=59;$m++)
				{
			?>
				<option <?=$m==$timesetend[1]?"selected":"";?> value="<?=str_pad($m,2,'0',STR_PAD_LEFT);?>"><?=str_pad($m,2,'0',STR_PAD_LEFT);?></option>
			<?
				}
			?>
		</select>
		<select name="endsec">
			<option value="">ss</option>
			<?
				for($s=0;$s<=59;$s++)
				{
			?>
				<option <?=$s==$timesetend[2]?"selected":"";?> value="<?=str_pad($s,2,'0',STR_PAD_LEFT);?>"><?=str_pad($s,2,'0',STR_PAD_LEFT);?></option>
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
		<td align="center"><b>usuario  ID: </b>
		  <input type="text" name="userid" value="<?=$uid;?>" size="8" />
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
				<TD width="7%" align="left" nowrap="nowrap">Usu&aacute;rio ID</TD>
				<TD align="left" nowrap="nowrap">Nome</TD>
				<TD width="20%" nowrap="nowrap" align="center">Total Login/Logout</TD>
				<TD width="20%" nowrap="nowrap" align="center">Dura&ccedil;&atilde;o M&eacute;dia</TD>
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
				$time = explode("|",getTotalTimeLogin1($obj->user_id,$startdate." ".$starttime,$enddate." ".$endtime));				
				$finalusertime = $time[1]/$time[0];
				$allusertime = $finalusertime + $finalusertimeplus;
				$finalusertimeplus = $allusertime;
		?>
				<TD width="7%" align="left" nowrap="nowrap"><?=$obj->user_id;?></TD>
				<TD align="left" nowrap="nowrap"><?=$obj->username;?></TD>
				<TD width="20%" nowrap="nowrap" align="center"><?=$time[0];?></TD>
				<TD width="20%" nowrap="nowrap" align="center">
				<span id="duration_<?=$obj->user_id;?>">
					<?
						echo "<script language=javascript>
						document.getElementById('duration_".$obj->user_id."').innerHTML = calc_counter_from_time('".$finalusertime."');
						</script>
						";
					?>
				</span>
				</TD>
				<TD width="21%" align="center" nowrap="nowrap">
					<input type="button" name="details" class="bttn" value="Estatisticas" onclick="window.location.href='view_member_statistics.php?uid=<?=$obj->user_id;?>'" />
				</TD>
			</tr>
		<?
			}
		?>		
         <TR class=th-a> 
			<td colspan="3">Media Geral login/logout</td>
			<td align="center">
			<span id="allusertime">
				<?
					echo "<script language=javascript>
					document.getElementById('allusertime').innerHTML = calc_counter_from_time('".$allusertime/$total."');
					</script>
					";
				?>
			</span>
			</td>
			<td>&nbsp;</td>
		 </TR>
		 </TABLE>
		  <?
			if($PageNo>1)
			{
			  $PrevPageNo = $PageNo-1;
		  ?>
		  <A class='paging' href="perhourreport.php?pgno=<?=$PrevPageNo;?>&<?=$urldata;?>">&lt; P&aacute;gina Anterior</A>
		  <?
		   }
		  ?> &nbsp;&nbsp;&nbsp;
		  <?php
			if($PageNo<$totalpage)
			{
			 $NextPageNo = 	$PageNo + 1;
		  ?>
		  <A class='paging' id='next' href="perhourreport.php?pgno=<?=$NextPageNo;?>&<?=$urldata;?>">Pr&amp;oacute;xima P&amp;aacute;gina &gt;</A>
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
