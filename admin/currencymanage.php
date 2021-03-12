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
		$minbidprice = $_POST["minbidprice"];
		
		$qryupd = "Update general_setting set dinars='".$dinar."',smsrateincl='".$smspricevatincl."',smsrateexcl='".$smspricevatexcl."',mobileoperator='".$mobileoperator."',smsgateway='".$smsgateway."',othercost='".$othercost."',totaldetraction='".$totaldetraction."',netsave='".$netsave."', ccgatewayfixfees='".$ccgatewayfixfees."', ccgatewayvariablefees='".$ccgatewayvariablefees."',min_bid_price='".$minbidprice."' where id='1'";
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
function number_format( number, decimals, dec_point, thousands_sep ) {
    var n = number, c = isNaN(decimals = Math.abs(decimals)) ? 2 : decimals;
    var d = dec_point == undefined ? "." : dec_point;
    var t = thousands_sep == undefined ? "," : thousands_sep, s = n < 0 ? "-" : "";
    var i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "", j = (j = i.length) > 3 ? j % 3 : 0;
    
    return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
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
			document.getElementById('dinar' + name).innerHTML = number_format(newdinarvalue,2,'.','');
			
			newtotaldetraction = Number(document.getElementById('mobileoperator').value) + Number(document.getElementById('smsgateway').value) + Number(document.getElementById('othercost').value);
	
			document.getElementById('totaldetractionhidden').value = number_format(newtotaldetraction,2,'.','');
			
			document.getElementById('totaldetraction').value = number_format(newtotaldetraction,2,'.','');
			document.getElementById('dinartotaldetraction').innerHTML = number_format(((dinarvalue * newtotaldetraction) / 100) * smsprice,2,'.','');

			document.getElementById('net').value = number_format(100 - newtotaldetraction,2,'.','');
			document.getElementById('netsave').innerHTML = number_format(((dinarvalue * (100-newtotaldetraction)) / 100) * smsprice,2,'.','');
			document.getElementById('nethidden').value = number_format(100 - newtotaldetraction,2,'.','');
		}
		else
		{
			newdinarvalue = (dinarvalue * value);
			document.getElementById('dinar' + name).innerHTML = number_format(newdinarvalue,2,'.','');
		}
	}

	function ChangeFirstLoad()
	{
		dinarvalue = Number(document.getElementById('dinarvalue').value);
		smsprice = document.getElementById('smsvatincl').value;

		document.getElementById('dinarsmsvatincl').innerHTML = number_format(document.getElementById('smsvatincl').value * dinarvalue,2,'.','');		

		document.getElementById('dinarsmsvatexcl').innerHTML = number_format(document.getElementById('smsvatexcl').value * dinarvalue,2,'.','');
		
		document.getElementById('dinarmobileoperator').innerHTML = number_format(((dinarvalue * document.getElementById('mobileoperator').value) / 100) * smsprice,2,'.','');

		document.getElementById('dinarsmsgateway').innerHTML = number_format(((dinarvalue * document.getElementById('smsgateway').value) / 100) * smsprice,2,'.','');

		document.getElementById('dinarothercost').innerHTML = number_format(((dinarvalue * document.getElementById('othercost').value) / 100) * smsprice,2,'.','');

			totaldetractionplus = Number(document.getElementById('mobileoperator').value) + Number(document.getElementById('smsgateway').value) + Number(document.getElementById('othercost').value);

		document.getElementById('totaldetraction').value = number_format(totaldetractionplus,2,'.','');
		document.getElementById('totaldetractionhidden').value = number_format(totaldetractionplus,2,'.','');

		document.getElementById('dinartotaldetraction').innerHTML = number_format(Number(((dinarvalue * document.getElementById('totaldetraction').value) / 100) * smsprice),2,'.','');

		document.getElementById('net').value = number_format(100 - totaldetractionplus,2,'.','');
		document.getElementById('nethidden').value = number_format(100 - totaldetractionplus,2,'.','');
		
		document.getElementById('netsave').innerHTML =  number_format(((dinarvalue * document.getElementById('net').value) / 100) * smsprice,2,'.','');

		document.getElementById('dinarccgatewayfixfees').innerHTML = number_format((document.getElementById('ccgatewayfixfees').value * dinarvalue) / 100,2,'.','');	

		document.getElementById('dinarccgatewayvariablefees').innerHTML = number_format((document.getElementById('ccgatewayvariablefees').value * dinarvalue) / 100,2,'.','');	
		
	}
	function onlineDinarCount(name)
	{
		dinarvalue = Number(document.getElementById('dinarvalue').value);

		document.getElementById('dinarccgatewayfixfees').innerHTML = number_format((document.getElementById('ccgatewayfixfees').value * dinarvalue) / 100,2,'.','');	

		document.getElementById('dinarccgatewayvariablefees').innerHTML = number_format((document.getElementById('ccgatewayvariablefees').value * dinarvalue) / 100,2,'.','');	
	}
</script>
</head>

<BODY bgColor=#ffffff onload="ChangeFirstLoad();">   
<form name="f1" action="currencymanage.php" method="post">
<table width="100%" cellpadding="0" cellSpacing="10">
  <tr>
	<td class="H1">Administrar Moeda</td>
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
          <td class="f-c" align="left" valign="middle" colspan="2" width="300">1 Real = 
            <input type="text" size="10" name="dinarvalue" id="dinarvalue" value="<?=$row->dinars;?>" />
            no c&acirc;mbio para sua moeda
          </td>
		</tr>
	    <tr valign="middle" height="5" colspan="2">
		  <td>&nbsp;</td>
		</tr>
  	 </table>
	 <table cellpadding="1" cellspacing="2">
		  <tr>
			<td>lance por SMS  com imposto.</td>
			<td><input type="text" size="6" maxlength="8" name="smsvatincl" onblur="AddNetValue(this.id);" id="smsvatincl" value="<?=$row->smsrateincl!="0.00"?$row->smsrateincl:"0";?>" />&nbsp;<span class="a"><?=$Currency;?></span> (Na sua moeda: <span id="dinarsmsvatincl">0</span>)</td>
		  </tr>
		  <tr>
			<td>lance por SMS  sem imposto.</td>
			<td><input type="text" size="6" maxlength="8" name="smsvatexcl" id="smsvatexcl" onblur="AddNetValue(this.id);" value="<?=$row->smsrateexcl!="0.00"?$row->smsrateexcl:"0";?>" />&nbsp;<span class="a"><?=$Currency;?></span> (Na sua moeda: <span id="dinarsmsvatexcl">0</span>)</td>
		  </tr>
		  <tr height="3">
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td>Operadora de Celular</td>
			<td><input type="text" size="6" maxlength="8" name="mobileoperator" id="mobileoperator" onblur="AddNetValue(this.id);" value="<?=$row->mobileoperator!="0.00"?$row->mobileoperator:"0";?>" />&nbsp;<span class="a">%</span> (Na sua moeda: <span id="dinarmobileoperator">0</span>)</td>
		  </tr>
		  <tr>
			<td>SMS gateway</td>
			<td><input type="text" size="6" maxlength="8" name="smsgateway" id="smsgateway"  onblur="AddNetValue(this.id);" value="<?=$row->smsgateway!="0.00"?$row->smsgateway:"0";?>" />&nbsp;<span class="a">%</span> (Na sua moeda: <span id="dinarsmsgateway">0</span>)</td>
		  </tr>
		  <tr>
			<td>Outros Custos</td>
			<td><input type="text" size="6" maxlength="8" name="othercost" id="othercost" onblur="AddNetValue(this.id);" value="<?=$row->othercost!="0.00"?$row->othercost:"0";?>" />&nbsp;<span class="a">%</span> (Na sua moeda: <span id="dinarothercost">0</span>)</td>
		  </tr>
		  <tr height="3">
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td>Diminui&ccedil;&atilde;o Total</td>
			<td><input type="text" size="6" maxlength="8" name="totaldetraction" id="totaldetraction" disabled="disabled" />&nbsp;<span class="a">%</span> (Na sua moeda: <span id="dinartotaldetraction">0</span>)</td>
			<input type="hidden" name="totaldetractionhidden" id="totaldetractionhidden" value="<?=$row->totaldetraction!="0.00"?$row->totaldetraction:"0";?>" />
		  </tr>
		<tr valign="middle">
			<td>&nbsp;</td>
		</tr>
		<tr valign="middle">
			  <td align="left" class="f-c" valign="middle">&nbsp;Rede</td>
			  <td align="left" valign="middle"><input type="text" size="6" maxlength="8" name="net" id="net" disabled="disabled" />&nbsp;<span class="a">%</span> (Na sua moeda: <span id="netsave">0</span>)</td>
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
		<td>CC Gateway taxa Fixa</td>
		<td><input type="text" size="6" maxlength="8" name="ccgatewayfixfees" id="ccgatewayfixfees"  onblur="onlineDinarCount(this.id);" value="<?=$row->ccgatewayfixfees!="0.00"?$row->ccgatewayfixfees:"0";?>" />&nbsp;<span class="a">%</span> (Na sua moeda: <span id="dinarccgatewayfixfees">0</span>)</td>
	  </tr>
		<td>CC Gateway Taxas Variaveis</td>
		<td><input type="text" size="6" maxlength="8" name="ccgatewayvariablefees" id="ccgatewayvariablefees"  onblur="onlineDinarCount(this.id);" value="<?=$row->ccgatewayvariablefees!="0.00"?$row->ccgatewayvariablefees:"0";?>" />&nbsp;<span class="a">%</span> (Na sua moeda: <span id="dinarccgatewayvariablefees">0</span>)</td>
	  </tr>
	<tr valign="middle">
	<td>&nbsp;</td>
	</tr>
  <tr>
  	<td><strong>Pre&ccedil;o m&iacute;nimo: </strong></td>
  </tr>
  <tr>
  	<td>Pre&ccedil;o do Lance:</td>
    <td><input type="text" value="<?=$row->min_bid_price;?>" name="minbidprice" maxlength="8" size="6" />
  </tr>
  <tr>
  	<Td>&nbsp;</Td>
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
