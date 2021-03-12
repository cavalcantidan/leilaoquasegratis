<?
	include("connect.php");
	include("admin.config.inc.php");
	include("security.php");
	
	
	if($_POST["submit"]!="")
	{
		$dinar = $_POST["dinarvalue"];
		$smspricevatincl = $_POST["smsvatincl"];
		$smspricevatexcl = $_POST["smsvatexcl"];
		$mobileoperator = $_POST["mobileoperator"];
		$smsgateway = $_POST["smsgateway"];
		$othercost = $_POST["othercost"];
		$totaldetraction = $_POST["totaldetractionhidden"];
		$netsave = $_POST["nethidden"];
		$ccgatewayfixfees = $_POST["ccgatewayfixfees"];
		$ccgatewayvariablefees = $_POST["ccgatewayvariablefees"];
		
		$qryupd = "Update general_setting set dinars='".$dinar."',smsrateincl='".$smspricevatincl."',smsrateexcl='".$smspricevatexcl."',mobileoperator='".$mobileoperator."',smsgateway='".$smsgateway."',othercost='".$othercost."',totaldetraction='".$totaldetraction."',netsave='".$netsave."', ccgatewayfixfees='".$ccgatewayfixfees."', ccgatewayvariablefees='".$ccgatewayvariablefees."' where id='1'";
		mysql_query($qryupd) or die(mysql_error());
		header("location: message.php?msg=68");
	}
	
	$qrysel = "select * from general_setting where id='1'";
	$ressel = mysql_query($qrysel);
	$row = mysql_fetch_object($ressel);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?=$lng_characset;?>" />
<title></title>
<LINK href="main.css" type=text/css rel=stylesheet>
<script language="javascript">
	function formatNumber(theNum, numDecPlaces)
	{
		 var num = new String();
		 num = "" + theNum;
		 var pos = 0;
		 count = 0;
		 while (num.substring(pos-1,pos)!== ".") {
		   pos += 1 ;
		   count += 1;
		 }
		 while (pos < (count+numDecPlaces)){
		   pos +=1;
		 }
		 return num.substring(0,pos);
	}

	function Check(f1)
	{
		if(document.f1.dinarvalue.value=="")
		{
			alert("Por favor informe o valor para a moeda!");
			document.f1.dinarvalue.focus();
			return false;
		}
	}
	function AddNetValue(name)
	{
		value = Number(document.getElementById(name).value);
		dinarvalue = Number(document.getElementById('dinarvalue').value);
		smsprice = document.getElementById('smsvatincl').value;
		
		if(name!="smsvatincl" && name!="smsvatexcl")
		{
			newdinarvalue = ((dinarvalue * value) / 100) * smsprice;
			totallength = String(newdinarvalue).length;
			if(totallength>4)
			{
			document.getElementById('dinar' + name).innerHTML = formatNumber(newdinarvalue,2);
			}
			else
			{
			document.getElementById('dinar' + name).innerHTML = newdinarvalue;
			}
			
			newtotaldetraction = Number(document.getElementById('mobileoperator').value) + Number(document.getElementById('smsgateway').value) + Number(document.getElementById('othercost').value);
	
			document.getElementById('totaldetractionhidden').value = newtotaldetraction;
			
			document.getElementById('totaldetraction').value = newtotaldetraction;
			document.getElementById('dinartotaldetraction').innerHTML = formatNumber(((dinarvalue * newtotaldetraction) / 100) * smsprice,2);

			document.getElementById('net').value = 100 - newtotaldetraction;
			document.getElementById('netsave').innerHTML = formatNumber(((dinarvalue * (100-newtotaldetraction)) / 100) * smsprice,2);
			document.getElementById('nethidden').value = 100 - newtotaldetraction;
		}
		else
		{
			newdinarvalue = (dinarvalue * value);
			document.getElementById('dinar' + name).innerHTML = newdinarvalue;
		}
	}

	function ChangeFirstLoad()
	{
		dinarvalue = Number(document.getElementById('dinarvalue').value);
		smsprice = document.getElementById('smsvatincl').value;

		document.getElementById('dinarsmsvatincl').innerHTML = document.getElementById('smsvatincl').value * dinarvalue;		

		document.getElementById('dinarsmsvatexcl').innerHTML = document.getElementById('smsvatexcl').value * dinarvalue;
		
		document.getElementById('dinarmobileoperator').innerHTML = ((dinarvalue * document.getElementById('mobileoperator').value) / 100) * smsprice;

		document.getElementById('dinarsmsgateway').innerHTML = formatNumber(((dinarvalue * document.getElementById('smsgateway').value) / 100) * smsprice,2);

		document.getElementById('dinarothercost').innerHTML = formatNumber(((dinarvalue * document.getElementById('othercost').value) / 100) * smsprice,2);

			totaldetractionplus = Number(document.getElementById('mobileoperator').value) + Number(document.getElementById('smsgateway').value) + Number(document.getElementById('othercost').value);

		document.getElementById('totaldetraction').value = totaldetractionplus;
		document.getElementById('totaldetractionhidden').value = totaldetractionplus;

		document.getElementById('dinartotaldetraction').innerHTML = formatNumber(Number(((dinarvalue * document.getElementById('totaldetraction').value) / 100) * smsprice),2);

		document.getElementById('net').value = 100 - totaldetractionplus;
		document.getElementById('nethidden').value = 100 - totaldetractionplus;
		
		document.getElementById('netsave').innerHTML =  formatNumber(((dinarvalue * document.getElementById('net').value) / 100) * smsprice,2);

		document.getElementById('dinarccgatewayfixfees').innerHTML = (document.getElementById('ccgatewayfixfees').value * dinarvalue) / 100;	

		document.getElementById('dinarccgatewayvariablefees').innerHTML = (document.getElementById('ccgatewayvariablefees').value * dinarvalue) / 100;	
		
	}
	function onlineDinarCount(name)
	{
		dinarvalue = Number(document.getElementById('dinarvalue').value);

		document.getElementById('dinarccgatewayfixfees').innerHTML = (document.getElementById('ccgatewayfixfees').value * dinarvalue) / 100;	

		document.getElementById('dinarccgatewayvariablefees').innerHTML = (document.getElementById('ccgatewayvariablefees').value * dinarvalue) / 100;	
	}
</script>
</head>

<BODY bgColor=#ffffff onload="ChangeFirstLoad();">   
<form name="f1" action="currencymanage.php" method="post">
<table width="100%" cellpadding="0" cellSpacing="10">
  <tr>
	<td class="H1">Manage Currency</td>
  </tr>
  <tr>
	<td background="<?=DIR_WS_ICONS?>vdots.gif"><IMG height=1 src="<?=DIR_WS_ICONS?>spacer.gif" width=1 border=0></td>
  </tr>
  <tr>
	<td class="a" align="right" colspan=2>* Campos Obrigatorios</td>
  </tr>
  <tr>
 	<td>
 	  <table cellpadding="1" cellspacing="2">
	    <tr valign="middle">
          <td class="f-c" align="left" valign="middle" colspan="2" width="200">1 Euro = <input type="text" size="10" name="dinarvalue" id="dinarvalue" value="<?=$row->dinars;?>" /> Dinars</td>
		</tr>
	    <tr valign="middle" height="5">
          <td>&nbsp;</td>
		  <td>&nbsp;</td>
		</tr>
  	 </table>
	 <table cellpadding="1" cellspacing="2">
		  <tr>
			<td>SMS bid price vat incl.</td>
			<td><input type="text" size="6" maxlength="8" name="smsvatincl" onblur="AddNetValue(this.id);" id="smsvatincl" value="<?=$row->smsrateincl!="0.00"?$row->smsrateincl:"0";?>" />&nbsp;<span class="a"><?=$Currency;?></span> (Dinars: <span id="dinarsmsvatincl">0</span>)</td>
		  </tr>
		  <tr>
			<td>SMS bid price vat excl.</td>
			<td><input type="text" size="6" maxlength="8" name="smsvatexcl" id="smsvatexcl" onblur="AddNetValue(this.id);" value="<?=$row->smsrateexcl!="0.00"?$row->smsrateexcl:"0";?>" />&nbsp;<span class="a"><?=$Currency;?></span> (Dinars: <span id="dinarsmsvatexcl">0</span>)</td>
		  </tr>
		  <tr height="3">
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td>Mobile operators</td>
			<td><input type="text" size="6" maxlength="8" name="mobileoperator" id="mobileoperator" onblur="AddNetValue(this.id);" value="<?=$row->mobileoperator!="0.00"?$row->mobileoperator:"0";?>" />&nbsp;<span class="a">%</span> (Dinars: <span id="dinarmobileoperator">0</span>)</td>
		  </tr>
		  <tr>
			<td>SMS gateway</td>
			<td><input type="text" size="6" maxlength="8" name="smsgateway" id="smsgateway"  onblur="AddNetValue(this.id);" value="<?=$row->smsgateway!="0.00"?$row->smsgateway:"0";?>" />&nbsp;<span class="a">%</span> (Dinars: <span id="dinarsmsgateway">0</span>)</td>
		  </tr>
		  <tr>
			<td>Other costs</td>
			<td><input type="text" size="6" maxlength="8" name="othercost" id="othercost" onblur="AddNetValue(this.id);" value="<?=$row->othercost!="0.00"?$row->othercost:"0";?>" />&nbsp;<span class="a">%</span> (Dinars: <span id="dinarothercost">0</span>)</td>
		  </tr>
		  <tr height="3">
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td>Totat detractions</td>
			<td><input type="text" size="6" maxlength="8" name="totaldetraction" id="totaldetraction" disabled="disabled" />&nbsp;<span class="a">%</span> (Dinars: <span id="dinartotaldetraction">0</span>)</td>
			<input type="hidden" name="totaldetractionhidden" id="totaldetractionhidden" value="<?=$row->totaldetraction!="0.00"?$row->totaldetraction:"0";?>" />
		  </tr>
		<tr valign="middle">
			<td>&nbsp;</td>
		</tr>
		<tr valign="middle">
			  <td align="left" class="f-c" valign="middle">&nbsp;Net</td>
			  <td align="left" valign="middle"><input type="text" size="6" maxlength="8" name="net" id="net" disabled="disabled" />&nbsp;<span class="a">%</span> (Dinars: <span id="netsave">0</span>)</td>
			<input type="hidden" name="nethidden" id="nethidden" value="<?=$row->netsave!="0.00"?$row->netsave:"0";?>" />
		</tr>
		<tr valign="middle">
			<td>&nbsp;</td>
		</tr>
		<tr valign="middle">
			<td>&nbsp;</td>
		</tr>
	<tr>
		<td><strong>Online</strong></td>
	</tr>
	  <tr>
		<td>CC Gateway fix fees</td>
		<td><input type="text" size="6" maxlength="8" name="ccgatewayfixfees" id="ccgatewayfixfees"  onblur="onlineDinarCount(this.id);" value="<?=$row->ccgatewayfixfees!="0.00"?$row->ccgatewayfixfees:"0";?>" />&nbsp;<span class="a">%</span> (Dinars: <span id="dinarccgatewayfixfees">0</span>)</td>
	  </tr>
		<td>CC Gateway variable fees</td>
		<td><input type="text" size="6" maxlength="8" name="ccgatewayvariablefees" id="ccgatewayvariablefees"  onblur="onlineDinarCount(this.id);" value="<?=$row->ccgatewayvariablefees!="0.00"?$row->ccgatewayvariablefees:"0";?>" />&nbsp;<span class="a">%</span> (Dinars: <span id="dinarccgatewayvariablefees">0</span>)</td>
	  </tr>
	<tr valign="middle">
	<td>&nbsp;</td>
	</tr>
		<tr valign="middle">
			  <td align="center" valign="middle" colspan="2"><input type="submit" value="Enviar" name="submit" class="bttn" /></td>
		</tr>
	 </table>
   </td>
  </tr>
	<tr valign="middle">
	<td>&nbsp;</td>
	</tr>
	 </table>
	</td>
  </tr>
</table>
</form>
</BODY>
</html>
