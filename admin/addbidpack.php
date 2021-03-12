<?
	include("connect.php");
	include("admin.config.inc.php");
	include("security.php");

	$qrylang = "select * from language";
	$reslang = mysql_query($qrylang);
	$totallang = mysql_num_rows($reslang);

function uploadimage()
{
	$time = time();
	$imagename = $time."_".$_FILES["image1"]["name"];
	$dest = "../uploads/bidpack/";
    if($_FILES['image1']['tmp_name']!='')
	@copy($_FILES['image1']['tmp_name'],"../uploads/bidpack/".$imagename);
}

function uploadimagelang($languageprefix,$filenumber)
{
	$time = time();
	$imagename = $languageprefix."_".$time."_".$_FILES["image".$filenumber]["name"];
	$dest = "../uploads/bidpack/";
    if($_FILES['image1']['tmp_name']!='')
	@copy($_FILES['image'.$filenumber]['tmp_name'],"../uploads/bidpack/".$imagename);
}

	$name = $_REQUEST["bidname1"];
	$size = $_REQUEST["bidsize"];
	$price = $_REQUEST["bidprice"];
	$bidpackprice = $_REQUEST["bidpackprice"];
	$bidpackdetail = $_REQUEST["bidpackdetail"];
	if($_POST["addbidpack"]!="")
	{
		//duplication check
		$qrysel = "select * from bidpack where bidpack_name='$name'";
		$ressel = mysql_query($qrysel);
		$totalrow = mysql_affected_rows();
		if($totalrow>0)
		{
			header("location: message.php?msg=17");
			exit;		
		}
		else
		{
			uploadimage();
			$imagenameb = time()."_".$_FILES["image1"]["name"];
			$qryins = "Insert into bidpack (bidpack_name,bid_size,bid_price,bidpack_price,bidpack_banner, bidpack_details) values('$name','$size','$price','$bidpackprice','$imagenameb', '$bidpackdetail')";
			mysql_query($qryins) or die(mysql_error());
			$insertid = mysql_insert_id();
			if($totallang>0)
			{
				for($i=1;$i<=$totallang;$i++)
				{
					$objlang = mysql_fetch_object($reslang);
					uploadimagelang($objlang->language_prefix,$i);				
					$imagenamelang = $objlang->language_prefix."_".time()."_".$_FILES["image$i"]["name"];
					$qryupd = "update bidpack set ".$objlang->language_prefix."_bidpack_banner='".addslashes($imagenamelang)."',".$objlang->language_prefix."_bidpack_name='".addslashes($_POST["bidname$i"])."', bidpack_details = '$bidpackdetail' where id='".$insertid."'";
					mysql_query($qryupd) or die(mysql_error());
				}
			}
			header("location: message.php?msg=18");
			exit;
		}
	}
	elseif($_REQUEST["editbidpack"])
	{
		$id = $_REQUEST["editid"];
		//duplication check
		$imagenameb = time()."_".$_FILES["image1"]["name"];
		$qrysel = "select * from bidpack where bidpack_name='".$name."' and id<>$id";
		$ressel = mysql_query($qrysel);
		$totalrow = mysql_affected_rows();
		if($totalrow>0)
		{
			header("location: message.php?msg=17");
			exit;		
		}
		else
		{
			uploadimage();
			if($_FILES["image1"]["name"]=="")
			{
			$qryupd = "update bidpack set bidpack_name='".$name."', bid_size='$size',bid_price='$price', bidpack_price='$bidpackprice', bidpack_details = '$bidpackdetail'";
			}
			else
			{
			$qryupd = "update bidpack set bidpack_name='".$name."', bid_size='$size',bid_price='$price', bidpack_price='$bidpackprice', bidpack_banner='$imagenameb', bidpack_details = '$bidpackdetail'";
			}

			if($totallang>0)
			{
				for($i=1;$i<=$totallang;$i++)
				{
					$objlang = mysql_fetch_object($reslang);
					uploadimagelang($objlang->language_prefix,$i);				
					$imagenamelang = $objlang->language_prefix."_".time()."_".$_FILES["image$i"]["name"];
					if($_FILES["image$i"]["name"]=="")
					{
						$qryupd .= ",".$objlang->language_prefix."_bidpack_name='".addslashes($_POST["bidname$i"])."'";
					}
					else
					{
						$qryupd .= ",".$objlang->language_prefix."_bidpack_banner='".$imagenamelang."',".$objlang->language_prefix."_bidpack_name='".($_POST["bidname$i"])."'";
					}
				}
			}
			$qryupd .= ", bidpack_details = '$bidpackdetail' where id=$id";
			mysql_query($qryupd) or die(mysql_error());
			header("location: message.php?msg=19");
			exit;
		}
	}

	if($_GET["delid"]!="")
	{
		$qryd = "delete from bidpack where id='".$_GET["delid"]."'";
		mysql_query($qryd) or die(mysql_error());
		header("location: message.php?msg=20");
		exit;
	}
	
	if($_REQUEST["bidpack_edit"]!="" || $_REQUEST["bidpack_delete"]!="")
	{
		if($_REQUEST["bidpack_edit"]!="")
		{
			$id = $_REQUEST["bidpack_edit"];
		}
		else
		{
			$id = $_REQUEST["bidpack_delete"];
		}
		$qry = "select * from bidpack where id='$id'";
		$res = mysql_query($qry);
		$rowqry = mysql_fetch_array($res);
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
/*	if(document.f1.bidname.value=="")
	{
		alert("Por favor informe o nome do pacote de lances");
		document.f1.bidname.focus();
		return false;
	}*/
	countervalue = Number(f1.countervalue.value) - 1;
	if(countervalue>0)
	{
		for(i=1;i<=countervalue;i++)
		{
			obj = document.getElementById('bidname' + i);
			if(obj.value=="")
			{
			alert("Por favor informe o nome do pacote de lances.");
			obj.focus();
			return false;
			}
		}
	}

	if(document.f1.bidsize.value=="")
	{
		alert("Por favor informe o tamanho do pacote de lances");
		document.f1.bidsize.focus();
		return false;
	}
	if(document.f1.bidprice.value=="")
	{
		alert("Por favor informe o preço do pacote de lances");
		document.f1.bidprice.focus();
		return false;
	}
}
</script>
</head>

<BODY bgColor=#ffffff>   
<form name="f1" action="addbidpack.php" method="post" enctype="multipart/form-data" onsubmit="return Check(f1)">
<table width="100%" cellpadding="0" cellSpacing="10">
  <tr>
	<td class="H1"><? if($_GET['bidpack_edit']!="") { ?> Editar Pacote de Lances<? } else { if($_GET['bidpack_delete']!=""){ ?> Confirmar Exclus&atilde;o de Bid
	  <? }else { ?> 
	  Adicionar Pacote de Lances
	  <? } } ?></td>
  </tr>
  <tr>
	<td background="<?=DIR_WS_ICONS?>vdots.gif"><IMG height=1 src="<?=DIR_WS_ICONS?>spacer.gif" width=1 border=0></td>
  </tr>
  <tr>
	<td class="a" align="right" colspan=2 >* Campos Obrigat&oacute;rios</td>
  </tr>
  <tr>
 	<td>
 	  <table cellpadding="1" cellspacing="2">
<?php /*?>	    <tr valign="middle">
          <td class=f-c align=right valign="middle" width="191"><font class=a>*</font> Lances Pack Name :</td>
		  <td><input type="text" name="bidname" size="25" value="<?=$rowqry["bidpack_name"]!=""?$rowqry["bidpack_name"]:"";?>" /></td>
		</tr>
<?php */?>		<?
			$qrysl = "select * from language";
			$ressl = mysql_query($qrysl);
			$totalsl = mysql_num_rows($ressl);
			if($totalsl>0)
			{
				for($i=1;$i<=$totalsl;$i++)
				{
					$objsl = mysql_fetch_object($ressl);
		?>
	    <tr valign="middle">
          <td class=f-c align=right valign="middle" width="191"><font class=a>*</font> Nome do Pacote:</td>
		  <td><input type="text" name="bidname<?=$i;?>" size="25" value="<?=$rowqry[$objsl->language_prefix."_bidpack_name"]!=""?stripslashes($rowqry[$objsl->language_prefix."_bidpack_name"]):"";?>" /></td>
		</tr>
		<?
				}
			}
		?>
	    <tr valign="middle">
          <td class=f-c align=right valign="middle" width="191"><font class=a>*</font> Quantidade de Lances:</td>
		  <td>
		  	<input type="text" name="bidsize" value="<?=$rowqry["bid_size"];?>" size="10" />
		  </td>
		</tr>
	    <tr valign="middle">
          <td class=f-c align=right valign="middle" width="191"><font class=a>*</font> Pre&ccedil;o do Lance:</td>
		  <td><input type="text" name="bidprice" size="25" value="<?=$rowqry["bid_price"]!=""?$rowqry["bid_price"]:"";?>" />&nbsp;&nbsp;<font color="#FF0000"><?=$Currency;?></font></td>
		</tr>
	    <tr valign="middle">
          <td class=f-c align=right valign="middle" width="191"><font class=a>*</font> Pre&ccedil;o do pacote:</td>
		  <td><input type="text" name="bidpackprice" size="25" value="<?=$rowqry["bidpack_price"]!=""?$rowqry["bidpack_price"]:"";?>" />&nbsp;&nbsp;<font color="#FF0000"><?=$Currency;?></font></td>
		</tr>
	    <tr valign="middle">
	      <td class=f-c align=right valign="middle">Detalhes:</td>
	      <td><input type="text" name="bidpackdetail" size="25" value="<?=$rowqry["bidpack_details"]!=""?$rowqry["bidpack_details"]:"";?>" /></td>
	      </tr>
<?php /*?>	    <tr valign="middle">
          <td class=f-c align=right valign="middle" width="191"> Lance Pack Banner :</td>
		  <td><input type="file" name="image" size="25"/></td>
		</tr>
<?php */?>		<?
			if($totallang>0)
			{
				for($i=1;$i<=$totallang;$i++)
				{
					$objlang = mysql_fetch_object($reslang);
		?>
	    <tr valign="middle">
          <td class=f-c align=right valign="middle" width="191"> Imagem do Pacote(<?=$objlang->language_name;?>):</td>
		  <td><input type="file" name="image<?=$i;?>" size="25"/></td>
		</tr>
		<?
				}
			}
		?>
		<input type="hidden" name="countervalue" value="<?=$i;?>" />
		<tr>
			<td>&nbsp;</td>
		</tr>
		<tr valign="middle">
			<td colspan="2" align="center">
			<?
				if($_REQUEST["bidpack_edit"])
				{
			?>
				<input type="submit" name="editbidpack" value="Editar" class="bttn" />
				<input type="hidden" name="editid" value="<?=$id?>" />
			<?
				}
				elseif($_REQUEST["bidpack_delete"])
				{
			?>
			<input type="button" name="deletebidpack" value="Excluir" class="bttn" onclick="javascript: window.location.href='addbidpack.php?delid=<?=$id?>';" />
			<?
				}
				else
				{
			?>	
				<input type="submit" name="addbidpack" value="Adicionar" class="bttn" />
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
