<?
	include("connect.php");
	include("admin.config.inc.php");
	include("security.php");

	$shipping = $_REQUEST["shippingcharge"];
	$title = $_REQUEST["shippingchargetitle"];

	if($_REQUEST["addshipping"])
	{
		$qrysel = "select * from shipping where shipping_title='$title'";
		$ressel = mysql_query($qrysel);
		$totalrow = mysql_affected_rows();
		if($totalrow>0)
		{
			header("location: message.php?msg=47");
			exit;		
		}
		else
		{
			$qryins = "insert into shipping (shipping_title,shippingcharge) values ('$title','$shipping')";
			mysql_query($qryins) or die(mysql_error());
			header("location: message.php?msg=45");
			exit;
		}
	}
	
	if($_POST["editshipping"]!="")
	{
		$id = $_POST["editid"];
		$qrysel = "select * from shipping where shipping_title='$title' and id<>$id";
		$ressel = mysql_query($qrysel);
		$totalrow = mysql_affected_rows();
		if($totalrow>0)
		{
			header("location: message.php?msg=47");
			exit;		
		}
		else
		{
			$qryupd = "update shipping set shipping_title='$title',shippingcharge='$shipping' where id='$id'";
			mysql_query($qryupd) or die(mysql_error());
			header("location: message.php?msg=48");
			exit;
		}
	}

	if($_GET["delid"]!="")
	{
		$qryauc = "select * from auction where shipping_id='".$_GET["delid"]."'";
		$resauc = mysql_query($qryauc);
		$totalauc = mysql_num_rows($resauc);
		if($totalauc>0)
		{
		header("location: message.php?msg=49");
		exit;
		}
		else
		{
		$qryd = "delete from shipping where id='".$_GET["delid"]."'";
		mysql_query($qryd) or die(mysql_error());
		header("location: message.php?msg=46");
		exit;
		}
	}

	if($_REQUEST["shipping_edit"]!="" || $_REQUEST["shipping_delete"]!="")
	{
		if($_REQUEST["shipping_edit"]!="")
		{
			$id = $_REQUEST["shipping_edit"];
		}
		else
		{
			$id = $_REQUEST["shipping_delete"];
		}
		$qrysel = "select * from shipping where id='$id'";
		$res = mysql_query($qrysel);
		$totalrow = mysql_affected_rows();
		$row = mysql_fetch_object($res);
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
	if(document.f1.shippingchargetitle.value=="")
	{
		alert("Por favor informe a transportadora!");
		document.f1.shippingchargetitle.focus();
		return false;
	}
	if(document.f1.shippingcharge.value=="")
	{
		alert("Por favor informe o valor da carga.");
		document.f1.shippingcharge.focus();
		return false;
	}
}
</script>
<script language="javascript">
function TrackCount(fieldObj,countFieldName,maxChars){
  var countField = eval("fieldObj.form."+countFieldName);
  var diff = maxChars - fieldObj.value.length;

  // Need to check & enforce limit here also in case user pastes data
  if (diff < 0)
  {
    fieldObj.value = fieldObj.value.substring(0,maxChars);
    diff = maxChars - fieldObj.value.length;
  }
  countField.value = diff;
}

function LimitText(fieldObj,maxChars){
  var result = true;
  if (fieldObj.value.length >= maxChars)
    result = false;
  
  if (window.event)
    window.event.returnValue = result;
  return result;
}
</script>
</head>

<body>
<form name="f1" id="f1" action="addshippingcharge.php" method="post" onsubmit="return Check(this)">
<table width="100%" cellpadding="0" cellSpacing="10">
  <tr>
	<td class="H1">Adicionar Transportadora</td>
  </tr>
  <tr>
	<td background="<?=DIR_WS_ICONS?>vdots.gif"><IMG height=1 src="<?=DIR_WS_ICONS?>spacer.gif" width=1 border=0></td>
  </tr>
  <tr>
	<td class="a" align="right" colspan=2 >* Campos Obrigatorios</td>
  </tr>
  <tr>
 	<td>
 	  <table cellpadding="1" cellspacing="2">
	    <tr valign="middle">
          <td class=f-c align=right valign="middle" width="191"><font class=a>*</font> Nome :</td>
				<? $lengthname = strlen($row->shipping_title);
					$newlength = 30 - $lengthname;
				 ?>
				<TD ><input type="text" name="shippingchargetitle" size="32" class="solidinput" value="<? echo stripslashes($row->shipping_title); ?>" maxlength="30" ONKEYUP="TrackCount(this,'textcount1',30)" ONKEYPRESS="LimitText(this,30)">
				&nbsp;&nbsp;Caracteres Restantes: 
				<input type="text" readonly size="2" value="<?=$newlength;?>" name="textcount1" class="textbox"> </TD>
		</tr>
	    <tr valign="middle">
          <td class=f-c align=right valign="middle" width="191"><font class=a>*</font> Valor da carga:</td>
		  <td><input type="text" name="shippingcharge" size="10" value="<?=$row->shippingcharge!=""?number_format($row->shippingcharge,2):"";?>" />&nbsp;&nbsp;<font color="#FF0000"><?=$Currency;?></font></td>
		</tr>
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
		<tr valign="middle">
			<td colspan="2" align="center">
			<?
				if($_REQUEST["shipping_edit"])
				{
			?>
				<input type="submit" name="editshipping" value="Editar" class="bttn" />
				<input type="hidden" name="editid" value="<?=$id?>" />
			<?
				}
				elseif($_REQUEST["shipping_delete"])
				{
			?>
			<input type="button" name="deleteshipping" value="Excluir" class="bttn" onclick="javascript: window.location.href='addshippingcharge.php?delid=<?=$id?>';" />
			<?
				}
				else
				{
			?>	
				<input type="submit" name="addshipping" value="Adicionar" class="bttn" />
			<?
				}
			?>
			</td>
		</tr>
	 </table>
</table>
</form>
</body>
</html>
