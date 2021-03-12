<?
	include("connect.php");
	include("admin.config.inc.php");
	include("security.php");

	function AcceptDateFunctionStatus($date,$validity)
	{
		$year = substr($date,0,4);
		$month = substr($date,5,2);
		$day = substr($date,8,2) + $validity;	
		$newdate = explode(" ",$date);
		$exdate = explode("-",$newdate[0]);
		$newyear = $exdate[0];
		$newmonth = $exdate[1];
		$newday = $exdate[2];
		$newtime = explode(":",$newdate[1]);
		$newhour = $newtime[0];
		$newmin = $newtime[1];
		$newsec = $newtime[2];
		$returndate1 = date("Y-m-d H:i:s",mktime($newhour,$newmin,$newsec,$newmonth,$newday+$validity,$newyear));
		
		$newdate1 = explode(" ",$returndate1);
		$exdate1 = explode("-",$newdate1[0]);
		$newyear1 = $exdate1[0];
		$newmonth1 = $exdate1[1];
		$newday1 = $exdate1[2];
		$newtime1 = explode(":",$newdate1[1]);
		$newhour1 = $newtime1[0];
		$newmin1 = $newtime1[1];
		$newsec1 = $newtime1[2];
		
		$returndate = array("Hour"=>$newhour1,"Min"=>$newmin1,"Sec"=>$newsec1,"Month"=>$newmonth1,"Day"=>$newday1,"Year"=>$newyear1);

		return $returndate1;
	}	

	$qrylang = "select * from language";
	$reslang = mysql_query($qrylang);
	$totallang = mysql_num_rows($reslang);

	if($_POST["issuevoucher"]!="")
	{
		$userinfo = $_POST["userinfo"];
		$voucherid = $_POST["vouchername"];
		
		$qryvoucher = "select * from vouchers where id='".$voucherid."'";
		$resvoucher = mysql_query($qryvoucher);
		$objvoucher = mysql_fetch_array($resvoucher);
		$voucherdesc = $objvoucher["voucher_title"];
		
		if($objvoucher["validity"]>0)
		{
			$expirydate = AcceptDateFunctionStatus(date("Y-m-d H:i:s",time()),$objvoucher["validity"]);
			$validityflag = 1;
			$voucherdesc .= " (valid for ".$objvoucher["validity"]." days)";
		}
		
		if($userinfo=="alluser")
		{
			$qryreg = "select * from registration where account_status='1' and member_status='0' and user_delete_flag!='d'";
			$resreg = mysql_query($qryreg);
			$totalreg = mysql_num_rows($resreg);
			$i = 0;
			while($objreg = mysql_fetch_object($resreg))
			{
				$userid = $objreg->id;
				
				$qryins = "insert into user_vouchers (voucherid,user_id,issuedate,expirydate,voucher_status,voucher_desc) values('".$voucherid."','".$userid."',NOW(),'".$expirydate."','0','".$voucherdesc ."')";
				mysql_query($qryins) or die(mysql_error());
				if($i==0)
				{
					$idarr = "'".mysql_insert_id()."'";
				}
				else
				{
					$idarr .= ",'".mysql_insert_id()."'";
				}
				$i++;
			}
			if($totallang>0)
			{
				for($i=1;$i<=$totallang;$i++)
				{
					$objlang = mysql_fetch_object($reslang);
					include("../language/".$objlang->language_name.".php");
					$voucherdesc = $objvoucher[$objlang->language_prefix."_voucher_title"];
					if($validityflag==1)
					{
						$voucherdesc .= $lng_vouvalidfor.$objvoucher["validity"].$lng_vouvaliddays;
					}
					$qryupd = "update user_vouchers set ".$objlang->language_prefix."_voucher_desc='".$voucherdesc."' where id in (".$idarr.")";
					mysql_query($qryupd) or die(mysql_error());
					$voucherdesc = '';
				}
			}
			header("location: message.php?msg=70");
			exit;
		}

		elseif($userinfo=="alluserexcept")
		{
			$qryreg = "select *,r.id as userid from registration r left join bid_account ba on ba.user_id=r.id where ba.bid_flag='c' and account_status='1' and member_status='0' and user_delete_flag!='d' group by ba.user_id";
			$resreg = mysql_query($qryreg);
			$totalreg = mysql_num_rows($resreg);
			$i = 0;
			while($objreg = mysql_fetch_object($resreg))
			{
				$userid = $objreg->userid;
				
				$qryins = "insert into user_vouchers (voucherid,user_id,issuedate,expirydate,voucher_status,voucher_desc) values('".$voucherid."','".$userid."',NOW(),'".$expirydate."','0','".$voucherdesc ."')";
				mysql_query($qryins) or die(mysql_error());
				if($i==0)
				{
					$idarr = "'".mysql_insert_id()."'";
				}
				else
				{
					$idarr .= ",'".mysql_insert_id()."'";
				}
				$i++;
			}
			if($totallang>0)
			{
				for($i=1;$i<=$totallang;$i++)
				{
					$objlang = mysql_fetch_object($reslang);
					include("../language/".$objlang->language_name.".php");
					$voucherdesc = $objvoucher[$objlang->language_prefix."_voucher_title"];
					if($validityflag==1)
					{
						$voucherdesc .= $lng_vouvalidfor.$objvoucher["validity"].$lng_vouvaliddays;
					}
					$qryupd = "update user_vouchers set ".$objlang->language_prefix."_voucher_desc='".$voucherdesc."' where id in (".$idarr.")";
					mysql_query($qryupd) or die(mysql_error());
					$voucherdesc = '';
				}
			}
			header("location: message.php?msg=70");
			exit;
		}

		elseif($userinfo=="selecteduser")
		{
			$userlist = explode(",",$_POST["userlist"]);
			$userlistcount = count($userlist);
			for($i=0;$i<$userlistcount;$i++)
			{
				$qryreg1 = "select * from registration where username='".$userlist[$i]."'";
				$resreg1 = mysql_query($qryreg1);
				$objreg1 = mysql_fetch_object($resreg1);

				$userid = $objreg1->id;

				$qryins = "insert into user_vouchers (voucherid,user_id,issuedate,expirydate,voucher_status,voucher_desc) values('".$voucherid."','".$userid."',NOW(),'".$expirydate."','0','".$voucherdesc ."')";
				mysql_query($qryins) or die(mysql_error());
				if($i==0)
				{
					$idarr = "'".mysql_insert_id()."'";
				}
				else
				{
					$idarr .= ",'".mysql_insert_id()."'";
				}
			}
			if($totallang>0)
			{
				for($i=1;$i<=$totallang;$i++)
				{
					$objlang = mysql_fetch_object($reslang);
					include("../language/".$objlang->language_name.".php");
					$voucherdesc = $objvoucher[$objlang->language_prefix."_voucher_title"];
					if($validityflag==1)
					{
						$voucherdesc .= $lng_vouvalidfor.$objvoucher["validity"].$lng_vouvaliddays;
					}
					$qryupd = "update user_vouchers set ".$objlang->language_prefix."_voucher_desc='".$voucherdesc."' where id in (".$idarr.")";
					mysql_query($qryupd) or die(mysql_error());
					$voucherdesc = '';
				}
			}
			header("location: message.php?msg=70");
			exit;
		}
	}
	
	
	if($_POST["submit"]!="")
	{
		$voucherid = $_POST["vouchername"];
		
		$qrysel = "select * from vouchers where newuser_flag='1'";
		$ressel = mysql_query($qrysel);
		$total = mysql_num_rows($ressel);
		if($total>0)
		{
			$objupd = mysql_fetch_object($ressel);
			$qryupd1 = "update vouchers set newuser_flag='0' where id='".$objupd->id."'";
			mysql_query($qryupd1) or die(mysql_error());
		}
		
		$qryupd = "update vouchers set newuser_flag='1' where id='".$voucherid."'";
		mysql_query($qryupd) or die(mysql_error());
		header("location: message.php?msg=69");
		exit;
	}

	$qrynvou = "select * from vouchers where newuser_flag='1'";
	$resnvou = mysql_query($qrynvou);
	$totalnvou = mysql_num_rows($resnvou);
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
		if(document.f1.vouchername.value=='none')
		{
			alert("Por favor selecione voucher!");
			document.f1.vouchername.focus();
			return false;
		}
	}
	
	function Check1(f2)
	{
		if(document.f2.vouchername.value=='none')
		{
			alert("Por favor selecione voucher!");
			document.f2.vouchername.focus();
			return false;
		}	
		if(document.f2.userinfo.value=='none')
		{
			alert("Por favor selecione user information!");
			document.f2.userinfo.focus();
			return false;
		}
		if(document.f2.userinfo.value=='selecteduser' && document.getElementById('userlist').value=="")
		{
			alert("Por favor selecione users!");
			document.getElementById('username').focus();
			return false;
		}
	}
	
	function AddUserList()
	{
		seluser = document.getElementById('username');
		userlist = document.getElementById('userlist');

		if(seluser.value=='none')
		{
			alert("Por favor selecione username!");
			document.getElementById('username').focus();
			return false
		}
		else
		{
			temp = seluser.value;
			userinfo = temp.split("|");
			if(userlist.value=="")
			{
				userlist.value = userinfo[1];
			}
			else
			{
				oldvalue = userlist.value;
				userlist.value = oldvalue + "," + userinfo[1];
				seluser.focus();
			}
		}
	}
	
	function ShowUserInfo(id)
	{
		if(id=='selecteduser')
		{
			if(navigator.appName!="Microsoft Internet Explorer")
			{
			document.getElementById('firstrow').style.display='table-row';
			document.getElementById('firstrow1').style.display='table-row';
			}
			else
			{
			document.getElementById('firstrow').style.display='block';
			document.getElementById('firstrow1').style.display='block';
			}
		}
		else
		{
			document.getElementById('firstrow').style.display='none';
			document.getElementById('firstrow1').style.display='none';
		}
	}
</script>
</head>

<BODY bgColor=#ffffff>   
<table width="100%" cellpadding="0" cellSpacing="10">
  <tr>
	<td class="H1">Enviar Bonus</td>
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
		<form name="f1" action="voucherissue.php" method="post" onsubmit="return Check(f1)">
	    <tr valign="middle">
          <td class="H1" colspan="2">Novos assinantes </td>
	   </tr>
	    <tr valign="middle">
          <td>&nbsp;</td>
	   </tr>
	    <tr valign="middle">
          <td class=f-c align=right valign="middle" width="191"><font class=a>*</font> Bonus :</td>
		  <td>
		  	<?
				$qrysel = "select * from vouchers";
				$ressel = mysql_query($qrysel);
				$total = mysql_num_rows($ressel);
			 ?>
			 <select name="vouchername" style="width: 450px;">
			 	<option value="none">-- Selecione --</option>
			 	<option value="selnone" <?=$totalnvou==0 &&$total>0?"selected":"";?>>Nenhum</option>
			<?
				while($obj = mysql_fetch_object($ressel))
				{
			?>
				<option <?=$obj->newuser_flag=="1"?"selected":"";?> value="<?=$obj->id;?>"><?=stripslashes($obj->voucher_title);?></option>
			<?
				}
			?>
			</select>
		  </td>
		</tr>
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
	   <tr>
	   	<td colspan="2" align="center"><input type="submit" name="submit" value="Envair" class="bttn" style="width: 80px;" /></td>
  	   </tr>	
	   </form>
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
		<form name="f2" action="voucherissue.php" method="post" onsubmit="return Check1(f2)">
		<tr>
			<td class="H1">Todos Usu&aacute;rios</td>
		</tr>
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
	    <tr valign="middle">
          <td class=f-c align=right valign="middle"><font class=a>*</font> Bonus :</td>
		  <td>
		  	<?
				$qrysel = "select * from vouchers";
				$ressel = mysql_query($qrysel);
				$total = mysql_num_rows($ressel);
			 ?>
			 <select name="vouchername" style="width: 450px;">
			 	<option value="none">-- Selecione --</option>
			<?
				while($obj = mysql_fetch_object($ressel))
				{
			?>
				<option value="<?=$obj->id;?>"><?=stripslashes($obj->voucher_title);?></option>
			<?
				}
			?>
			</select>
		  </td>
		</tr>
		<tr>
          <td class=f-c align=right valign="middle"><font class=a>*</font> Usu&aacute;rios :</td>
		  <td>
		  	<select name="userinfo" onchange="ShowUserInfo(this.value);">
				<option value="none">-- Selecione --</option>
				<option value="alluser">Todos</option>
				<option value="alluserexcept">Todos Exceto Inativos</option>
				<option value="selecteduser">Selecionados</option>
			</select>
		  </td>
		</tr>
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
		<tr align="center" id="firstrow" style="display: none;">
          <td class="f-c" align="right" nowrap="nowrap" valign="middle"><font class=a>*</font> Usuarios:</td>
			<td align="left">
				<select name="username" id="username">
					<option value="none">-- Selecione --</option>
					<?
						$qry = "select * from registration where account_status='1' and user_delete_flag!='d' and member_status='0'";
						$rs = mysql_query($qry);
						
						while($ob = mysql_fetch_object($rs))
						{
					?>
						<option value="<?=$ob->id;?>|<?=$ob->username;?>"><?=$ob->username;?></option>
					<?
						}
					?>
				</select>&nbsp;&nbsp;<input type="button" name="adduser" id="adduser" value="Adicionar" class="bttn" onclick="AddUserList();" />
			</td>
		</tr>
		<tr align="center" id="firstrow1" style="display: none;">
			<td align="center" colspan="2" style="padding-left: 80px;">
				<textarea name="userlist" id="userlist" cols="50" rows="3"></textarea>
			</td>
		</tr>
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
		<tr align="center">
			<td colspan="2"><input type="submit" name="issuevoucher" value="Enviar" class="bttn" /></td>
		</tr>
	  </form>
 	  </table>
	</td>
  </tr>
</table>
</BODY>
</html>
