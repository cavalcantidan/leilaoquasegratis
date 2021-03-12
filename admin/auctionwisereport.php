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
			if($_POST["submit"]!="")
			{
			$PageNo = 1;
			}
			else
			{
			$PageNo = $_GET['pgno'];
			}
		}

			if($_POST["datefrom"]!="")
			{
				$startdate = ChangeDateFormat($_POST["datefrom"]);
				$enddate = ChangeDateFormat($_POST["dateto"]);
				$auctionstatus = $_POST["auctionstatus"];
				$auctiontype = $_POST["auctiontype"];
				$cid = $_POST["category"];
			}
			else
			{
					$startdate = ChangeDateFormat($_GET["sdate"]);
					$enddate = ChangeDateFormat($_GET["edate"]);
					$auctionstatus = $_GET["stat"];
					$auctiontype = $_GET["type"];
					$cid = $_GET["catid"];
			}

			$urldata = "sdate=".ChangeDateFormatSlash($startdate)."&edate=".ChangeDateFormatSlash($enddate)."&stat=".$auctionstatus."&type=".$auctiontype."&catid=".
			$cid;
		
		if($auctiontype!="none")
		{
			if($auctiontype=="fpa") { $auctype = "and fixedpriceauction='1'"; }							
			if($auctiontype=="pa") { $auctype = "and pennyauction='1'"; }							
			if($auctiontype=="nba") { $auctype = "and nailbiterauction='1'"; }							
			if($auctiontype=="off") { $auctype = "and offauction='1'"; }							
			if($auctiontype=="na") { $auctype = "and nightauction='1'"; }							
			if($auctiontype=="oa") { $auctype = "and openauction='1'"; }							
		}

		if($auctionstatus!="")
		{
			if($auctionstatus==2)
			{	
				$qrysel = "select * from auction a left join products p on a.productID=p.productID where (a.auc_status='$auctionstatus' or a.auc_status='1') and  auc_start_date>='$startdate' and auc_end_date<='$enddate' ".$auctype;
			}
			else
			{
				$qrysel = "select * from auction a left join products p on p.productID=a.productID where a.auc_status='$auctionstatus' and auc_start_date>='$startdate' and auc_end_date<='$enddate' ".$auctype;
			}
		}
		else
		{
				$qrysel = "select * from auction a left join products p on p.productID=a.productID where auc_start_date>='$startdate' and auc_end_date<='$enddate' ".$auctype;
		}
		if($cid!="")
		{
				$qrysel .= " and a.categoryID='$cid'";
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
<title><? echo $ADMIN_MAIN_SITE_NAME." - Auctionwise Report"; ?></title>
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
<script language="javascript">
// USE FOR AJAX //
function GetXmlHttpObject()
{
var xmlHttp=null;
try
  {
  // Firefox, Opera 8.0+, Safari
  xmlHttp=new XMLHttpRequest();
  }
catch (e)
  {
  // Internet Explorer
  try
    {
    xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
    }
  catch (e)
    {
    xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
  }
return xmlHttp;
}

function PauseAuction(aucid)
{
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	  {
	  alert ("Seu navegador não suporta AJAX!");
	  return;
	  } 
	var url="pauseauction.php";
	url=url+"?aucid="+aucid
	xmlHttp.onreadystatechange=changeStatus;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
}
function changeStatus()
{
	if (xmlHttp.readyState==4)
	{ 
		var temp=xmlHttp.responseText;
		redata = temp.split('|');
		if(redata[0]=="success")
		{
			document.getElementById('pause_' + redata[1]).style.display = 'none';
			document.getElementById('resume_' + redata[1]).style.display = 'block';
			document.getElementById('auctionstatus_' + redata[1]).style.color = 'green';
			document.getElementById('auctionstatus_' + redata[1]).innerHTML = 'Paused';
		}
	}
}
function StartAuction(aucid1)
{
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	  {
	  alert ("Seu navegador não suporta AJAX!");
	  return;
	  } 
	var url="pauseauction.php";
	url=url+"?aucidstart="+aucid1
	xmlHttp.onreadystatechange=changeStatus1;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
}
function changeStatus1()
{
	if (xmlHttp.readyState==4)
	{ 
		var temp=xmlHttp.responseText;
		redata = temp.split('|');
		if(redata[0]=="success")
		{
			document.getElementById('pause_' + redata[1]).style.display = 'block';
			document.getElementById('resume_' + redata[1]).style.display = 'none';
			document.getElementById('auctionstatus_' + redata[1]).style.color = '#FF0000';
			document.getElementById('auctionstatus_' + redata[1]).innerHTML = 'Active';
		}
	}
}
</script>
</head>

<body>
<TABLE width="100%"  border=0 cellPadding=0 cellSpacing=10>
  <!--DWLayoutTable-->
    <TR> 
      <TD width="100%" class="H1">Relat&oacute;rio por Leil&atilde;o</TD>
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
		<td align="center">
			<b>Leil&atilde;o Tipo :&nbsp;</b>
			<select name="auctiontype" class="solidinput">
				<option value="none">Por favor selecione</option>
				<option <?=$auctiontype=="fpa"?"selected":"";?> value="fpa">Fixed Price Auction</option>
				<option <?=$auctiontype=="pa"?"selected":"";?> value="pa">Cent Auction</option>
				<option <?=$auctiontype=="nba"?"selected":"";?> value="nba">NailBiter Auction</option>
				<option <?=$auctiontype=="off"?"selected":"";?> value="off">100% off</option>
				<option <?=$auctiontype=="na"?"selected":"";?> value="na">Night Auction</option>
				<option <?=$auctiontype=="oa"?"selected":"";?> value="oa">Open Auction</option>
		  </select>
			&nbsp;&nbsp;&nbsp;
			<b>Leil&atilde;o Tipo :&nbsp;</b>
			<select name="auctionstatus" class="solidinput">
				<option value="">select</option>
				<option <?=$auctionstatus=="2"?"selected":"";?> value="2">Active</option>
				<option <?=$auctionstatus=="3"?"selected":"";?> value="3">Sold</option>
				<option <?=$auctionstatus=="4"?"selected":"";?> value="4">Pending</option>
			</select>
	  </td>
	</tr>	
	<tr>
		<td height="5"></td>
	</tr>
	<tr>
		<td align="center">
			<b>Categoria :&nbsp;</b>
			<select name="category" style="width: 250px;">
			<option value="">selecione</option>
			<?
				$qrycat = "select * from categories";			
				$rescat = mysql_query($qrycat);
				$totalcat = mysql_num_rows($rescat);
				while($objcat = mysql_fetch_object($rescat))
				{
			?>
			<option <?=$objcat->categoryID==$cid?"selected":"";?> value="<?=$objcat->categoryID;?>"><?=$objcat->name;?></option>
			<?
				}
			?>
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
				<TD width="7%" align="left" nowrap="nowrap">Leil&atilde;o  ID</TD>
				<TD width="50%" nowrap="nowrap" align="center">Nome</TD>
				<TD nowrap="nowrap" align="left">Pre&ccedil;o Inicial</TD>
				<TD align="left" nowrap="nowrap">Pre&ccedil;o Fixo</TD>
				<TD nowrap="nowrap" align="left">Status do Leil&atilde;o</TD>
				<TD nowrap="nowrap" align="left">Dura&ccedil;&atilde;o</TD>
				<TD width="35%" align="center" nowrap="nowrap">Op&ccedil;&otilde;es</TD>
			 </TR>
		<?
			while($obj = mysql_fetch_object($ressel))
			{
				if($obj->time_duration=="none"){ $duration = "Default"; }
				elseif($obj->time_duration=="10sa"){ $duration = "10 Second"; }
				elseif($obj->time_duration=="15sa"){ $duration = "15 Second"; }
				elseif($obj->time_duration=="20sa"){ $duration = "20 Second"; }
				
				if($obj->auc_status=="2" || $obj->auc_status=="1") {
					if($obj->pause_status=="1")
					{
						$status = "<font color='green'>Paused</font>";	
					}
					else
					{
					 $status = "<font color='red'>Active</font>";
					}
				  }
				if($obj->auc_status=="3") { $status = "<font color='blue'>Sold</font>"; }
				if($obj->auc_status=="4") { $status = "<font color='green'>Pending</font>"; }
				

				if ($colorflg==1){
					$colorflg=0;
					echo "<TR bgcolor=\"#f4f4f4\"> ";
				}else{
					$colorflg=1;
				  	echo "<TR> ";
				}
		?>
				<TD align="left" nowrap="nowrap"><?=$obj->auctionID;?></TD>
				<TD nowrap="nowrap" align="center"><?=stripslashes($obj->name);?></TD>
				<TD nowrap="nowrap" align="right"><?=$Currency.$obj->auc_start_price;?></TD>
				<TD align="right" nowrap="nowrap"><?=$Currency.$obj->auc_fixed_price;?></TD>
				<TD nowrap="nowrap" align="left"><span id="auctionstatus_<?=$obj->auctionID;?>"><?=$status;?></span></TD>
				<TD nowrap="nowrap" align="left"><?=$duration;?></TD>
				<TD align="left" nowrap="nowrap">
					<div style="width: 70px; float:left;">
					<input type="button" name="details" class="bttn" value="Detalhes" onclick="javascript: window.location.href='auctiondetails.php?aid=<?=$obj->auctionID;?>'" /></div>
					<div style="width: 80px; float:right; clear:left">
				<? if($obj->pause_status=="0" && $obj->auc_status=="2"){ ?>
					<input type="button" id="pause_<?=$obj->auctionID;?>" name="pause" class="bttn" value="Pause" onclick="PauseAuction('<?=$obj->auctionID;?>');" />
					<input type="button" id="resume_<?=$obj->auctionID;?>" name="resume" class="bttn" value="Resumo" onclick="StartAuction('<?=$obj->auctionID;?>');" style="display: none;" />
				<? } elseif($obj->pause_status=="1" && $obj->auc_status=="2") { ?>
					<input type="button" id="pause_<?=$obj->auctionID;?>" name="pause" class="bttn" value="Pause" onclick="PauseAuction('<?=$obj->auctionID;?>');" style="display: none;" />
					<input type="button" id="resume_<?=$obj->auctionID;?>" name="resume" class="bttn" value="Resumo" onclick="StartAuction('<?=$obj->auctionID;?>');"/>
				<? } ?>
				</div>
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
		  <A class='paging' href="auctionwisereport.php?pgno=<?=$PrevPageNo;?>&<?=$urldata;?>">&lt; P&aacute;gina Anterior</A>
		  <?
		   }
		  ?> &nbsp;&nbsp;&nbsp;
		  <?php
			if($PageNo<$totalpage)
			{
			 $NextPageNo = 	$PageNo + 1;
		  ?>
		  <A class='paging' id='next' href="auctionwisereport.php?pgno=<?=$NextPageNo;?>&<?=$urldata;?>">Pr&amp;oacute;xima P&amp;aacute;gina &gt;</A>
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
