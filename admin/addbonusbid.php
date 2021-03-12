<?
	include("connect.php");
	include("admin.config.inc.php");
	include("security.php");
	$type1 = 1;
	$type2 = 2;
	include("pagepermission.php");

	$qrylang = "select * from language";
	$reslang = mysql_query($qrylang);
	$totallang = mysql_num_rows($reslang);
	
	if($_POST["addbonusbid"]!="")
	{
		$user_id = $_POST["username"];
		$bonusbid = $_POST["bonusbids"];
		$reason = $_POST["reason1"];

		$qrysel1 = "select * from registration where id='".$user_id."'";
		$ressel1 = mysql_query($qrysel1);
		$total1 = mysql_num_rows($ressel1);
		$obj1 = mysql_fetch_object($ressel1);
		
		$final_bids = $obj1->final_bids;
		$totalbids = $final_bids + $bonusbid;

		$qryupd = "update registration set final_bids='".$totalbids."' where id='".$user_id."'";
		mysql_query($qryupd) or die(mysql_error());

		$qryins = "Insert into bid_account (user_id,bidpack_buy_date,bid_count,bid_flag,recharge_type,credit_description) values
                                            ('".$user_id."',NOW(),'".$bonusbid."','c','ad','".$reason."')";
		mysql_query($qryins) or die(mysql_error());
		$insertid = mysql_insert_id();
		
		if($totallang>0)
		{
			for($i=1;$i<=$totallang;$i++)
			{
				$objlang = mysql_fetch_object($reslang);
				$reasonsr = $_POST["reason$i"];
				$qryupd = "update bid_account set ".$objlang->language_prefix."_credit_description='".addslashes($reasonsr)."' where id='".$insertid."'";
				mysql_query($qryupd) or die(mysql_error());
			}
		}
		
		header("location: message.php?msg=44");
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?=$lng_characset;?>" />
<title></title>
<LINK href="main.css" type=text/css rel=stylesheet>
<script language="javascript">
	function Check(f1)
	{
		if(document.f1.username.value=="none")
		{
			alert("Por favor selecione o usuário!")
			document.f1.username.focus();
			return false;
		}
		if(document.f1.bonusbids.value=="")
		{
			alert("Por favor digite a quantidade!")
			document.f1.bonusbids.focus();
			return false;
		}
/*		if(document.f1.reason.value=="")
		{
			alert("Por favor digite o motivo!");
			document.f1.reason.focus();
			return false;
		}
*/
	countervalue = Number(f1.countervalue.value) - 1;
	if(countervalue>0)
	{
		for(i=1;i<=countervalue;i++)
		{
			obj = document.getElementById('reason' + i);
			if(obj.value=="")
			{
			alert("Por favor digite o motivo!");
			obj.focus();
			return false;
			}
		}
	}
	}
</script>
</head>

<BODY bgColor=#ffffff>   
<form name="f1" action="" method="post" onsubmit="return Check(this)">
<table width="100%" cellpadding="0" cellSpacing="10">
  <tr>
	<td class="H1">Credito/Debito Lances</td>
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
          <td class=f-c align=right valign="middle" width="191"><font class=a>*</font> Usu&aacute;rio :</td>
		  <td>
			<select name="username" style="width: 150px;">
				<option value="none">-- Selecione --</option>
		  	<?
				$qrysel = "select * from registration where account_status='1' and member_status='0' and user_delete_flag!='d'";
				$ressel = mysql_query($qrysel);
				$total = mysql_num_rows($ressel);
				while($obj = mysql_fetch_object($ressel))
				{
			?>
			<option value="<?=$obj->id;?>"><?=$obj->username;?></option>
			<?
				}
			?>
			</select>
		  </td>
		</tr>
	    <tr>
          <td class=f-c align="right" width="191"><font class=a>*</font> Cr/Db Lances :</td>
		  <td>
		  	<input type="text" name="bonusbids" size="10" maxlength="10" /><br />
		  	<font class="a">Nota: Se o valor for negativo, os lances ser&atilde;o deduzidos da conta do usu&aacute;rio caso contr&aacute;rio os lances ser&atilde;o adicionado na conta de usu&aacute;rio.</font>
		  </td>
		</tr>
<?php /*?>	    <tr valign="middle">
          <td class=f-c align=right valign="middle" width="191"><font class=a>*</font> Reason :</td>
		  <td>
		  	<textarea name="reason" cols="50" rows="3"></textarea>
		  </td>
		</tr>
<?php */?>		<?
			if($totallang>0)
			{
				for($i=1;$i<=$totallang;$i++)
				{
					$objlang = mysql_fetch_object($reslang);
		?>
	    <tr valign="middle">
          <td class=f-c align=right valign="middle" width="191"><font class=a>*</font> Motivo (<?=$objlang->language_name;?>):</td>
		  <td>
		  	<textarea name="reason<?=$i;?>" id="reason<?=$i;?>" cols="50" rows="3"></textarea>
		  </td>
		</tr>
		<?
				}
			}
		?>
		<input type="hidden" name="countervalue" value="<?=$i;?>" />
		<tr valign="middle">
			<td>&nbsp;</td>
		</tr>
		<tr valign="middle">
			<td colspan="2" align="center">
				<input type="submit" name="addbonusbid" value="Enviar" class="bttn" />
			</td>
		</tr>
	 </table>
	</td>
  </tr>
</table>
</form>
</BODY>
</html>
