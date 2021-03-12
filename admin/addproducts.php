<?php
	include("connect.php");
	include("admin.config.inc.php");
	include("resize.php");
	include("security.php");
//include("category_function.php");
	include("imgsize.php");
	$type1 = "1";
	$type3 = "3";
	include("pagepermission.php");

	$qrylang = "select * from language";
	$reslang = mysql_query($qrylang);
	$totallang = mysql_num_rows($reslang);

function update_products_Count_Value_For_Categories_Delete($catid)
{
	$qrysel = "select products_count from categories where categoryID='$catid'";
	$ressel = mysql_query($qrysel);
	$totalsel = mysql_affected_rows();
	if($totalsel>0)
	{
		$rowsel = mysql_fetch_object($ressel);
		$totproduct = $rowsel->products_count;
		$totproducts = $totproducts = $totproduct - 1;
		$qryupd = "update categories set products_count=".$totproducts." where categoryID='$catid'";
		mysql_query($qryupd) or die (mysql_error());
	}
}	

function update_products_Count_Value_For_Categories($catid)
	{
		$qrysel = "select products_count from categories where categoryID='$catid'";
		$ressel = mysql_query($qrysel);
		$totalsel = mysql_affected_rows();
		if($totalsel>0)
		{
			$rowsel = mysql_fetch_object($ressel);
			$totproduct = $rowsel->products_count;
			$totproducts = $totproduct + 1;
			$qryupd = "update categories set products_count=".$totproducts." where categoryID='$catid'";
			mysql_query($qryupd) or die (mysql_error());
		}
	}
?>
<?
include("gd.inc.php");

$ex='';
$msg='';
$parents=$_GET['parents'];
if(!isset($parents) || $parents==""){$parents=0;}

		//*** ADD PRODUCT ***//
		if($_POST['addproduct'])
		{
			$qryselcat = "select * from products where productID='".$_POST['edit']."'";
			$resselcat = mysql_query($qryselcat);
			$objcat = mysql_fetch_object($resselcat);
		
			$pcode=$_POST['productcode'];
			$categoryID=$_REQUEST["category"];
			$name=addslashes($_POST['productname1']);
			$productstatus=$_REQUEST["status"];

/*selection for short_desc
			$long_desc = addslashes($_POST["content"]);
			$length=160;
			$totallen = strlen($long_desc);
			for($i=$length;$i<$totallen;$i++){
				if(substr($long_desc,$i,1)==" "){
					$length = $i;
					break;
				}
			}
			if(strlen($long_desc)>$length){
				$short_desc = nl2br(substr($long_desc,0,$length));
				$short_desc .= "...";
			}else{
				$short_desc = nl2br($long_desc);
			}	
//selection over*/
			$actualcost = $_REQUEST["actualcost"];
			$short_desc=addslashes($_REQUEST["short_desc1"]);
			$metatags = addslashes($_REQUEST["metatags"]);
			$metadescription = addslashes($_REQUEST["metadescription"]);
			$long_desc=addslashes($_REQUEST["description1"]);
			$aucstartprice=$_REQUEST["aucstartprice"];
			$aucstartdate=$_REQUEST["aucstartyear"]."-".$_REQUEST["aucstartmonth"]."-".$_REQUEST["aucstartdate"];
			$aucenddate=$_REQUEST["aucendyear"]."-".$_REQUEST["aucendmonth"]."-".$_REQUEST["aucenddate"];
			$aucstarttime=$_REQUEST["aucstarthours"].":".$_REQUEST["aucstartminutes"].":".$_REQUEST["aucstartseconds"];
			$aucendtime=$_REQUEST["aucendhours"].":".$_REQUEST["aucendminutes"].":".$_REQUEST["aucendseconds"];
			$aucstatus=$_REQUEST["aucstatus"];
			$auctype=$_REQUEST["auctype"];
			$picture=addslashes($_REQUEST[""]);
			$picture_thumb=addslashes($_REQUEST[""]);
			
			if (!isset($_POST["price"]) || !$_POST["price"] || $_POST["price"] < 0)
			$_POST["price"] = 0; //price can not be negative
			$price = str_replace(",",".",$_POST['price']);
			
			
			// CHECK DUBPLICATE //
			$q=mysql_query("SELECT * from products WHERE categoryID='".$parents."' and product_code='".$pcode."'");
			
			$row = mysql_fetch_row($q);
			$ex=0;
			if($row)
			{
				$ex=1;
				$msg="Este produto ".$pcode.", j&aacute; existe na categoria ".getcategory($parents)." !";			
			}
			
			if($ex!=1)
			{
				//add new product
				$qry="INSERT INTO products (categoryID,name,custmer_rating,price,enabled,product_code,short_desc,long_desc,picture1,picture2,picture3,picture4,picture_thumb,metatags,metadescription,actual_cost)  VALUES(".$categoryID.",'".$name."','','".$price."','".$productstatus."','".$pcode."','".$short_desc."','".$long_desc."','','','','','','$metatags','$metadescription','$actualcost')";
				mysql_query($qry) or die (mysql_error());
				$pid = mysql_insert_id();
				
				if($totallang>0)
				{
					for($i=1;$i<=$totallang;$i++)
					{
						$objlang = mysql_fetch_object($reslang);
						$qryupd = "update products set ".$objlang->language_prefix."_name='".addslashes($_REQUEST["productname$i"])."',".$objlang->language_prefix."_short_desc='".addslashes($_REQUEST["short_desc$i"])."',".$objlang->language_prefix."_long_desc='".addslashes($_REQUEST["description$i"])."' where productID='".$pid."'";
						mysql_query($qryupd) or die(mysql_error());
					}
				}
				
				// PRODUCT IMAGE UPLOAD FILE //
				for($i=1;$i<=4;$i++)
				{
				  if(isset($_FILES["image".$i]))
				  {	
					if (isset($_FILES["image".$i]) && $_FILES["image".$i]["name"] && preg_match('/\.(jpg|jpeg|gif|jpe|pcx|bmp|png)$/i', $_FILES["image".$i]["name"]))
					{		
						$time = time();		
						$logo = $i."_".$time."_".$_FILES["image".$i]["name"];
						$logo_temp = $_FILES["image".$i]["tmp_name"];
						productimage($logo,$pid,$logo_temp);
						mysql_query("update products set picture".$i."='".$logo."' where productID=$pid") or die (mysql_error());
					}
				  }
				}
				update_products_Count_Value_For_Categories($categoryID);
				?>
				<script language="javascript">
					window.location.href="message.php?msg=7";
				</script>			
				<?
				exit;
			} 
			
		} 
		
		//*** UPDATE PRODUCT****//
		elseif($_POST['editproduct'])
		{
			$qryselcat = "select * from products where productID='".$_POST['edit']."'";
			$resselcat = mysql_query($qryselcat);
			$objcat = mysql_fetch_object($resselcat);

			$pcode=$_POST['productcode'];
			$categoryID=$_REQUEST["category"];
			$name=addslashes($_REQUEST['productname1']);
			$productstatus=$_REQUEST["status"];

/*selection for short_desc
			$long_desc = addslashes($_POST["content"]);
			$length=160;
			$totallen = strlen($long_desc);
			for($i=$length;$i<$totallen;$i++){
				if(substr($long_desc,$i,1)==" "){
					$length = $i;
					break;
				}
			}
			if(strlen($long_desc)>$length){
				$short_desc = nl2br(substr($long_desc,0,$length));
				$short_desc .= "...";
			}else{
				$short_desc = nl2br($long_desc);
			}	
//selection over*/
			$actualcost = $_REQUEST["actualcost"];
			$short_desc=addslashes($_REQUEST["short_desc1"]);
			$metatags = addslashes($_REQUEST["metatags"]);
			$metadescription = addslashes($_REQUEST["metadescription"]);
			$long_desc=addslashes($_REQUEST["description1"]);
			$aucstartprice=$_REQUEST["aucstartprice"];
			$aucstartdate=$_REQUEST["aucstartyear"]."-".$_REQUEST["aucstartmonth"]."-".$_REQUEST["aucstartdate"];
			$aucenddate=$_REQUEST["aucendyear"]."-".$_REQUEST["aucendmonth"]."-".$_REQUEST["aucenddate"];
			$aucstarttime=$_REQUEST["aucstarthours"].":".$_REQUEST["aucstartminutes"].":".$_REQUEST["aucstartseconds"];
			$aucendtime=$_REQUEST["aucendhours"].":".$_REQUEST["aucendminutes"].":".$_REQUEST["aucendseconds"];
			$aucstatus=$_REQUEST["aucstatus"];
			$auctype=$_REQUEST["auctype"];
			$picture=addslashes($_REQUEST[""]);
			$picture_thumb=addslashes($_REQUEST[""]);
			
			if (!isset($_POST["price"]) || !$_POST["price"] || $_POST["price"] < 0)
			$_POST["price"] = 0; //price can not be negative
			$price=$_POST['price'];
		
//		duplication check			
			$pid = $_POST['edit'];

			$qryselect = "select * from products where product_code='$pcode' and categoryID='$categoryID' and productID<>".$pid;
			$resselect = mysql_query($qryselect);
			$totalcount = mysql_affected_rows();
			
			if($totalcount>0)
			{
				header("location: message.php?msg=10");
				exit;
			}				

			$qryupd= "update products set categoryID='$categoryID', name='$name', custmer_rating='', price='$price',enabled='$productstatus', product_code='$pcode', short_desc='$short_desc', long_desc='$long_desc',metatags='$metatags',metadescription='$metadescription',actual_cost='$actualcost'";

			if($totallang>0)
			{
				for($i=1;$i<=$totallang;$i++)
				{
					$objlang = mysql_fetch_object($reslang);
					$qryupd .= ",".$objlang->language_prefix."_name='".addslashes($_REQUEST["productname$i"])."',".$objlang->language_prefix."_short_desc='".addslashes($_REQUEST["short_desc$i"])."',".$objlang->language_prefix."_long_desc='".addslashes($_REQUEST["description$i"])."'";
				}
			}
			$qryupd .= " where productID='".$pid."'";
			mysql_query($qryupd) or die(mysql_error());
			$pid = $_POST['edit'];
			update_products_Count_Value_For_Categories_Delete($objcat->categoryID);
			update_products_Count_Value_For_Categories($categoryID);
			for($i=1;$i<=4;$i++)
			{
			  if(isset($_FILES["image".$i]))
			  {	
				if (isset($_FILES["image".$i]) && $_FILES["image".$i]["name"] && preg_match('/\.(jpg|jpeg|gif|jpe|pcx|bmp|png)$/i', $_FILES["image".$i]["name"]))
				{		
					if($_FILES["image".$i]["name"]!="")
					{
						$time = time();		
						$logo = $i."_".$time."_".$_FILES["image".$i]["name"];
						$logo_temp = $_FILES["image".$i]["tmp_name"];
						productimage($logo,$pid,$logo_temp);
					mysql_query("update products set picture".$i."='".$logo."' where productID=$pid") or die (mysql_error());
				    }
				}
			  }
			}
		?>
				<script language="javascript">
					window.location.href="message.php?msg=8";
				</script>			
		<?
		exit;
  	 	}				

//delete from products
		if($_REQUEST["product_delete"]!="")
		{
			$selauc ="select * from auction where productID='".$_REQUEST["product_delete"]."'";
			$resauc = mysql_query($selauc);
			$totalauc = mysql_num_rows($resauc);
			$selaucobj = mysql_fetch_object($resauc);
			
			if($totalauc>0)
			{
			?>
				<script language="javascript">
					window.location.href="message.php?msg=41";
				</script>			
			<?
				exit;
			}
			$qrydel = "delete from products where productID=".$_REQUEST["product_delete"];
			mysql_query($qrydel) or dir(mysql_error());
			$categoryID = $_REQUEST["product_cid"];
			update_products_Count_Value_For_Categories_Delete($categoryID);
			?>
				<script language="javascript">
					window.location.href="message.php?msg=9";
				</script>			
			<?
			exit;
		}
		
//selection for edit
		if($_REQUEST["product_edit"]!="" or $_REQUEST["product_delete"]!="")
		{
			if($_REQUEST["product_edit"]!=""){$pid=$_REQUEST["product_edit"];}
			if($_REQUEST["product_delete"]!=""){$pid=$_REQUEST["product_delete"];}
			$qry = "select * from products where productID=".$pid;
			$resqry = mysql_query($qry);
			$row = mysql_fetch_array($resqry);
			
			$actualcost = str_replace(",",".",$row["actual_cost"]);
			$pcode = $row["product_code"];
			$ccode = $row["categoryID"];
			$name = $row["name"];
			$status = $row["enabled"];
			$metatags = $row["metatags"];
			$metadescription = $row["metadescription"];
			$price = $row["price"];
			$short_desc = stripslashes($row["short_desc"]);
			$long_desc = stripslashes($row["long_desc"]);
			$aucstartprice = $row["auc_start_price"];
			$aucstartdate = $row["auc_start_date"];
				$aucstmonth = substr($aucstartdate,8);	
				$aucstdate = substr($aucstartdate,5,2);	
				$aucstyear = substr($aucstartdate,0,4);	
			$aucenddate = $row["auc_end_date"];
				$aucendyear = substr($aucenddate,0,4);	
				$aucendmonth = substr($aucenddate,8);	
				$aucenddate = substr($aucenddate,5,2);	
			$aucstarttime = $row["auc_start_time"];
				$aucsthours = substr($aucstarttime,0,2);	
				$aucstmin = substr($aucstarttime,3,2);	
				$aucstsec = substr($aucstarttime,6,2);	
			$aucendtime = $row["auc_end_time"];
				$aucendhours = substr($aucstarttime,0,2);	
				$aucendmin = substr($aucstarttime,3,2);	
				$aucendsec = substr($aucstarttime,6,2);	
			$aucstatus = $row["auct_status"];
			$auctype = $row["auction_type"];
		}
?>
<HTML>
<HEAD>
<TITLE></TITLE>
<META http-equiv=Content-Type content="text/html; charset=<?=$lng_characset;?>">
<LINK href="main.css" type=text/css rel=stylesheet>
<script language="javascript" src="validation.js"></script>
<script language="javascript" src="popupimage.js"></script>
<script language="javascript" type="text/javascript" src="editor/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script language="javascript" type="text/javascript" src="editor.js"></script>
<script type="text/javascript">

/*function checknumber(num)
{
	//alert(num.value);
	//a=substring(num.value);
	//alert(a);
	var str=num.value;
	var c=str.length;
	if(isNaN(str.charAt(c-1)))
	{
		str.length=str.length-1
	}
	
}*/

function checknumber(e)
{
// 46 and 49 to 57 
var keynum;
var keychar;
var numcheck;
if(window.event) // IE
  {
  keynum = e.keyCode;
  }
else if(e.which) // Netscape/Firefox/Opera
  {
  keynum = e.which;
  }
    
keychar = String.fromCharCode(keynum);
numcheck = /\d/;
return numcheck.test(keychar);
}

function delconfirm(loc)
{
	if(confirm("Are you sure do you want to delete this?"))
	{
		window.location.href=loc;
	}
	return false;
}

function gotocategory(cat)
{
	if(trim(cat)!="")
	{
		window.location.href="addproducts.php?parents="+cat;
	}
}

function Check(f1)
{
	if(document.f1.productcode.value=="")
	{
		alert("Por favor informe o código do produto!!!");
		document.f1.productcode.focus();
		return false;
	}
	
	if(document.f1.category.value=="none")
	{
		alert("Por favor selecione a categoria!!!");
		document.f1.category.focus();
		return false;
	}

/*	if(document.f1.productname.value=="")
	{
		alert("Por favor informe o nome do produto!!!");
		document.f1.productname.focus();
		return false;
	}*/
	countervalue = Number(document.f1.countervalue.value) - 1;
	if(countervalue>0)
	{
		for(i=1;i<=countervalue;i++)
		{
			obj = document.getElementById('productname' + i);
			obj1 = document.getElementById('short_desc' + i);
			if(obj.value=="")
			{
			alert("Por favor informe o nome do produto!!!");
			obj.focus();
			return false;
			}
			if(obj1.value=="")
			{
			alert("Por favor informe um pequena descrição do produto!!!");
			obj1.focus();
			return false;
			}
		}
	}
	if(document.f1.price.value=="")
	{
		alert("Por favor informe o preço do produto!!!");
		document.f1.price.focus();
		return false;
	}
	if(document.f1.actualcost.value=="")
	{
		alert("Por favor informe o preço atual do produto!!!");
		document.f1.actualcost.focus();
		return false;
	}
	
	if(document.f1.editimage.value=="")
	{
		if(document.f1.image1.value=="")
		{
			alert("Por favor informe a imagem do produto!!!");
			document.f1.image1.focus();
			return false;
		}
	}
}

function ChangeCategory(val)
{

	ChangeCategorylist(val);
	//ChangeBrand(val);
}
function ChangeBrand(Newval)
{
	//alert(Newval);
	ChangeBrandlist(Newval);
}
</script>
<script language="javascript" src="function.js"></script>
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
</HEAD>
<BODY bgColor=#ffffff>   
<form name="f1" action='addproducts.php' method='POST' enctype="multipart/form-data" onSubmit="return Check(this)">
<table width="100%" cellpadding="0" cellSpacing="10">
	<tr>
		<td class="H1"><? if($_GET['product_edit']!="") { ?> Editar Produtos<? } else { if($_GET['product_delete']!=""){ ?> Confirmar Exclus&atilde;o do 
	    Produto<? }else { ?> Adicionar Produtos
	    <? } } ?></td>
	</tr>
	<TR>
		<TD background="<?=DIR_WS_ICONS?>vdots.gif"><IMG height=1 src="<?=DIR_WS_ICONS?>spacer.gif" width=1 border=0></TD>
	</TR>
	
	<? if($msg!="") {?>
	<tR>
		<td align="center"><font color="#FF0000"><?=$msg;?></font></td>
	</tR>
	<? } ?>
	
	<tr>
		<td class="a" align="right" colspan=2 >* Campos Obrigatorios</td>
  	</tr>
	
	<tr>
		<td>
			<table cellpadding="1" cellspacing="2">
			<tr>
				<TD class="f-c" align="right"  ><font class="a">*</font>C&oacute;digo do Produto:</TD>
				
				<TD ><input type="text" name="productcode" size="12" class="solidinput" value="<? echo $pcode; ?>"> </TD>
				
			</tr>

			<TR > 
			  <TD class="f-c" align="right"><font class=a>*</font>Categoria :</TD>
			  <td id="AddCategoryList">
			 <!--onChange="gotocategory(document.f1.parents.value)"-->
			  <select name="category" class="solidinput">
				<option value="none" selected="selected">-- Selecione --</option>
				<?
					$qrycat = "select * from categories where status='1'";
					$rescat = mysql_query($qrycat);
					while($catval = mysql_fetch_array($rescat))
					{
				?>					
					<option <?=$ccode==$catval["categoryID"]?"selected":"";?> value="<?=$catval["categoryID"];?>"><?=stripslashes($catval["name"]);?></option>
				<?
					}
				?>
				</select>
			  
			  </td>
			</TR>
		
<?php /*?>			<tr>
				<TD class="f-c" align="right" ><font class="a">*</font>Product Name :</TD>
				<? $lengthname = strlen($name);
					$newlength = 40 - $lengthname;
				 ?>
				<TD ><input type="text" name="productname" size="32" class="solidinput" value="<? echo stripslashes($name); ?>" maxlength="40" ONKEYUP="TrackCount(this,'textcount1',40)" ONKEYPRESS="LimitText(this,40)"> Total Characters: <input type="text" readonly size="2" value="<?=$newlength;?>" name="textcount1" class="textbox"> </TD>
				
			</tr>
<?php */?>			<?
				$qrysl = "select * from language";
				$ressl = mysql_query($qrysl);
				$totalsl = mysql_num_rows($ressl);
				if($totalsl>0)
				{
					for($i=1;$i<=$totalsl;$i++)
					{
						$objsl = mysql_fetch_object($ressl);
						$selprefix = $objsl->language_prefix;
			?>
			<tr>
				<TD class="f-c" align="right" ><font class="a">*</font>Nome do Produto (<?=$objsl->language_name;?>):</TD>
				<? $lengthname = strlen($row[$selprefix."_name"]);
					$newlength = 40 - $lengthname;
				 ?>
				<TD ><input type="text" name="productname<?=$i;?>" size="32" class="solidinput" value="<? echo stripslashes($row[$selprefix."_name"]); ?>" id="productname<?=$i;?>" maxlength="40" ONKEYUP="TrackCount(this,'textcount<?=$i;?>',40)" ONKEYPRESS="LimitText(this,40)"> 
				Total de Caracteres: 
				  <input type="text" readonly size="2" value="<?=$newlength;?>" name="textcount<?=$i;?>" class="textbox"> </TD>
				
			</tr>
			<?
						$lengthname = "";
					}
				}
			?>
			
			<tr>
				<TD class="f-c" align="right"><font class="a">*</font>Status do Produto :</TD>
				<td>
				
				<select name="status" class="solidinput">
				<option value="1" <?php if($status==1){ echo " selected";} ?> selected="selected">Ativo</option>
				<option value="0" <?php if($status!="" and $status==0){ echo " selected";} ?>>Inativo</option>
				</select>
				</td>
			</tr>

              <tr valign="middle">
                <td class=f-c align=right valign="middle" width="191"><font class=a>*</font> Pre&ccedil;o de Mercado :</td>
                <td><input name="price" type="text" class="solidinput" id="member_name" value="<?=$price?>" size="12" maxlength="10">&nbsp;<font color="#FF0000"><?=$Currency;?></font></td>
              </tr>
              <tr valign="middle">
                <td class=f-c align=right valign="middle" width="191"><font class=a>*</font> Pre&ccedil;o Atual:</td>
                <td><input name="actualcost" type="text" class="solidinput" value="<?=$actualcost?>" size="12" maxlength="10">&nbsp;<font color="#FF0000"><?=$Currency;?></font></td>
              </tr>

<?php /*?>			  <tr valign="middle">
                <td class="f-c" align="right" valign="middle" width="191">Short Description:</td>
                <td><textarea rows="5" cols="60" name="short_desc"><?=$short_desc;?></textarea></td>
              </tr>
			  <tr valign="middle">
                <td class="f-c" align="right" valign="middle" width="191">Full Description:</td>
                <td><textarea rows="20" cols="75" name="description"><?=$long_desc;?></textarea></td>
              </tr>
<?php */?>			  <?
			  	if($totallang>0)
				{
					for($i=1;$i<=$totallang;$i++)
					{
						$objlang = mysql_fetch_object($reslang);
			  ?>
			  <tr valign="middle">
                <td class="f-c" align="right" valign="middle" width="191"><font class=a>*</font> Pequena Descri&ccedil;&atilde;o(<?=$objlang->language_name;?>):</td>
                <td><textarea rows="5" cols="60" id="short_desc<?=$i;?>" name="short_desc<?=$i;?>"><?=stripslashes($row[$objlang->language_prefix."_short_desc"]);?></textarea></td>
              </tr>
			  <tr valign="middle">
                <td class="f-c" align="right" valign="middle" width="191"><font class=a>*</font> Descri&ccedil;&atilde;o Completa(<?=$objlang->language_name;?>):</td>
                <td><textarea rows="20" cols="75" id="description<?=$i;?>" name="description<?=$i;?>"><?=stripslashes($row[$objlang->language_prefix."_long_desc"]);?></textarea></td>
              </tr>
			  <?
					}
				}
			  ?>
			  <input type="hidden" name="countervalue" value="<?=$i;?>">
			  <tr valign="middle">
                <td class="f-c" align="right" valign="middle" width="191">Meta Tags(Palavras Chaves):</td>
                <td><textarea rows="3" cols="60" name="metatags"><?=$metatags;?></textarea></td>
              </tr>
			  <tr valign="middle">
                <td class="f-c" align="right" valign="middle" width="191">Meta Tags(Descri&ccedil;&atilde;o):</td>
                <td><textarea rows="3" cols="60" name="metadescription"><?=$metadescription;?></textarea></td>
              </tr>
			<tr>
				<td class="f-c"  align="right">Imagens do Produto:</td>
				<td>
				<table>
					<tr>
					<td><input name="image1" type="file" class="solidinput"  value="<? echo $image;?>" size="35">
					</td>
					</tr>
					<tr>
					<td ><input name="image2" type="file" class="solidinput"  value="<? echo $image;?>" size="35">
					</td>
					</tr>
					<tr>
					<td ><input name="image3" type="file" class="solidinput"  value="<? echo $image;?>" size="35">
					</td>
					</tr>
					<tr>
					<td ><input name="image4" type="file" class="solidinput"  value="<? echo $image;?>" size="35">
					</td>
					</tr>
					<tr>
					<td class="a">(Tamanho da Imagem Recomenda: 350 &times; 275)</td>
					</tr>
				</table>
				</td>
			</tr>
			
<!--			<tr>
				<td class="f-c" align="right" >Image Description :</td>
				<td ><input type="hidden" class="solidinput" size="50" maxlength="50" name="imagedesc" value=""></td>
			</tr>-->
			
			<!---------THIS PART OF EXTRA FIELD -->
			<tr>
			<td colspan="2" >
			
			<table cellpadding="2" cellspacing="2" class="extrafieldsblock" width="57%" >
			</table>
			
			</td>
			</tr>
			<!--***********EXTRA FIELD****************--> 
			  
			<tr>
				<td>&nbsp;</td>
					<input type="hidden" name="editimage" value="<?=$_GET['product_edit']?>">
			</tr>  
			<tr >
					<td>&nbsp;</td>
					<td >
					<?php
					if($_GET['product_delete']!="" and $pid!="")
					{ 
					?>
					<input type='button' name='<? if($_GET['product_delete']!=""){?>deleteproduct<? }else {?>addproduct<? } ?>' value='<? if($_GET['product_delete']!="") {?> Apagar Produto <? }else{ ?> Adicionar Produto <? } ?>' class="bttn" onClick="delconfirm('addproducts.php?delete=<?=$pid?>&product_cid=<?=$_REQUEST["product_cid"];?>')">
					<?php 
					}
					else
					{ 
					?>
					<input type='submit' name='<? if($_GET['product_edit']!=""){?>editproduct<? }else {?>addproduct<? } ?>' value='<? if($_GET['product_edit']!=""){?> Editar Produto <? }else{ ?> Adicionar Produto <? } ?>' class="bttn">
					<?php 
					}
					?>
					</td>
			</tr>
			<tr >
				<td colspan="2">&nbsp;</td>
			</tr>
			</table>
			
<? if($_GET['product_edit']!="" || $_GET["product_cid"]!="") {?>
<input type="hidden" name="edit" value="<?=$_GET['product_edit']?>">
<? } ?>

		</td>
	</tr>
</table>
</form>
<br><br>
</BODY>
</HEAD>
</HTML>
