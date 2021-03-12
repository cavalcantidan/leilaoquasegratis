<?
	include("connect.php") ;
	include_once("admin.config.inc.php");
	include("security.php");
	$type1 = "1";
	$type3 = "3";
	include("pagepermission.php");
	include("functions.php");
//	include("common.inc.php");

$ex="";
$msg="";

/***************************
Function hesk_input()
***************************/

	$qrylang = "select * from language";
	$reslang = mysql_query($qrylang);
	$totallang = mysql_num_rows($reslang);

		if($_POST['addcategory'])
		{
			$category=addslashes($_POST["categoryname"]);
			$desc=addslashes($_POST["description"]);
			$status=$_POST["status"];
			
			$categoryname1 = hesk_input($_POST["categoryname1"]);
				
			// CHECK DUBPLICATE //
//			$q=mysql_query("SELECT * FROM categories WHERE name='".$category."'");
			$q=mysql_query("SELECT * FROM categories WHERE name='".addslashes($categoryname1)."'");
			
			$rows=mysql_fetch_array($q);
			if($rows)
			{
				$ex=1;
				$msg='This Category Already Exists !';
			}
			// CHECK DUBPLICATE //
			
			if($ex!=1)
			{		
//				$q = mysql_query("INSERT INTO categories (language_id,name, products_count, description,status) VALUES ('1','".$category."','0','".$desc."','".$status."')") or die ("insert error".mysql_error());

				$q = mysql_query("INSERT INTO categories (language_id,name, products_count, description,status) VALUES ('1','".hesk_input($_POST["categoryname1"])."','0','".hesk_input($_POST["description1"])."','".$status."')") or die ("insert error".mysql_error());
				
				$pid = mysql_insert_id();
				if($totallang>0)
				{
					for($i=1;$i<=$totallang;$i++)
					{
						$objlang = mysql_fetch_object($reslang);
						$qryupd = "update categories set ".$objlang->language_prefix."_name='".hesk_input($_POST["categoryname$i"])."',".$objlang->language_prefix."_description='".hesk_input($_POST["description$i"])."' where categoryID='".$pid."'";
						mysql_query($qryupd) or die(mysql_error());
					}
				}
				?>
				<script language="javascript">
					window.location.href="message.php?msg=5";
				</script>				
				<?
				exit;
			}
		}
		
		//*** SECOND CATEGORY UPDATE ****//

		elseif($_POST['editcategory'])
		{
			$category=hesk_input($_POST["categoryname"]);
			$desc=hesk_input($_POST["description"]);
			$status=$_POST["status"];
			
			if(isset($_POST['edit']))
			{
				// CHECK DUBPLICATE //
//				$q=mysql_query("SELECT * FROM categories WHERE name='".$category."' and categoryID<>'".$_POST['edit']."'");

				$q=mysql_query("SELECT * FROM categories WHERE name='".addslashes($_POST["categoryname1"])."' and categoryID<>'".$_POST['edit']."'");
				
				$rows=mysql_fetch_array($q);
				if($rows)
				{
					$ex=1;
					$msg="This Category Already Exists !";					
				}
			}
			
			if ($ex!=1)
			{	
				if(isset($_POST['edit']))
				{
//						mysql_query("UPDATE categories SET name='".str_replace("<","&lt;",$category)."', description='".$desc."', status='".$status."' WHERE categoryID='".$_POST['edit']."'") or die (mysql_error());

						mysql_query("UPDATE categories SET name='".str_replace("<","&lt;",hesk_input($_POST["categoryname1"]))."', description='".hesk_input($_POST["description1"])."', status='".$status."' WHERE categoryID='".$_POST['edit']."'") or die (mysql_error());
					
				$pid = $_POST['edit'];

				if($totallang>0)
				{
					for($i=1;$i<=$totallang;$i++)
					{
						$objlang = mysql_fetch_object($reslang);
						$qryupd = "update categories set ".$objlang->language_prefix."_name='".hesk_input($_POST["categoryname$i"])."',".$objlang->language_prefix."_description='".hesk_input($_POST["description$i"])."' where categoryID='".$pid."'";
						mysql_query($qryupd) or die(mysql_error());
					}
				}
		?>
				<script language="javascript">
					window.location.href="message.php?msg=6";
				</script>				
				<?
				exit;
			}
			
			} //end if $ex
		}
		
		else
		{
			//*** THIRD CATEGORY DELETE ****//			
				if(isset($_GET['delete']))
				{
					$q = mysql_query("SELECT * FROM categories WHERE categoryID='".$_GET['delete']."' and categoryID<>0") or die (mysql_error());
					$row = mysql_fetch_row($q);
					$totalrow = mysql_affected_rows();
					if($totalrow>0)
					{
						$qryp = "select * from products where categoryID=".$_GET['delete'];
						$resp = mysql_query($qryp);
						$totalp = mysql_affected_rows();
						if($totalp>0)
						{
							header("location: message.php?msg=11");
							exit;
						}
						else
						{
							$qryd = "delete from categories where categoryID=".$_GET['delete'];
							mysql_query($qryd) or die(mysql_error());
							header("location: message.php?msg=12");
							exit;
						}
					}
				}
	
		// EXIST FETCH THE VALUE FOR GET EDIT TIME FROM MANAGE CATEGORY //
		if($_GET["category_edit"] || $_GET["category_delete"])
		{
			
			if(isset($_GET["category_edit"]))
			{
				$cid=$_GET["category_edit"];
			}
			if(isset($_GET["category_delete"]))
			{
				$cid=$_GET["category_delete"];
			}
			
			$q = mysql_query("SELECT * FROM categories WHERE categoryID='".$cid."'") or die (mysql_error());
			$row = mysql_fetch_array($q);
			if (!$row) //can't find category....
			{
				echo "<center><font color=red>ERROR CAN NOT FIND REQUIRED PAGE</font>\n<br><br>\n";
				exit;
			}
		}
}
?>
<HTML>
<HEAD>
<TITLE></TITLE>
<META http-equiv=Content-Type content="text/html; charset=<?=$lng_characset;?>">
<LINK href="main.css" type="text/css" rel="stylesheet">
<script type="text/javascript">

function delconfirm(loc)
{
	if(confirm("Are you sure do you want to delete this?"))
	{
		window.location.href=loc;
	}
	return false;
}

function checkform(f1)
{
/*	if(f1.categoryname.value=="")
	{
		alert("Por favor informe o nome da categoria.");
		f1.categoryname.focus();
		return false;
	}*/
	if(f1.status.value=="")
	{
		alert("Por favor selecione a situação da categoria.");
		f1.status.focus();
		return false;
	}
	countervalue = Number(f1.countervalue.value) - 1;
	if(countervalue>0)
	{
		for(i=1;i<=countervalue;i++)
		{
			obj = document.getElementById('categoryname' + i);
			if(obj.value=="")
			{
			alert("Por favor informe o nome da categoria.");
			obj.focus();
			return false;
			}
		}
	}
}
function popImage(img){
  foto1= new Image();
  foto1.src=(img);
  Controlla(img);
}
function Controlla(img){
  if((foto1.width!=0)&&(foto1.height!=0)){
    viewFoto(img);
  }
  else{
    funzione="Controlla('"+img+"')";
    intervallo=setTimeout(funzione,20);
  }
}
function viewFoto(img){
  largh=foto1.width+20;
  altez=foto1.height+20;
  PositionX = 100;
  PositionY = 350;
  stringa="width="+largh+",height="+altez+",top="+PositionX+",left="+PositionY;
  finestra=window.open(img,"",stringa);
}
</script>
</HEAD>
<BODY>      
<form action='' method='POST' enctype="multipart/form-data" onSubmit="return checkform(this);">
<table width="100%" cellpadding="0" cellSpacing="10">
	<tr>
		<td class="H1"><? if($_GET['category_edit']!="") { ?> Editar Categorias<? } else { if($_GET['category_delete']!=""){ ?> Confirmar Exclus&atilde;o de Categorias <? }else { ?> Adicionar Categorias <? } } ?></td>
	</tr>
	<TR>
		<TD background="images/vdots.gif"><IMG height=1 src="images/spacer.gif" width=1 border=0></TD>
	</TR>
	
	<? if($msg!="") {?>
	<tR>
		<td align="center"><font color="#FF0000"><?=$msg;?></font></td>
	</tR>
	<? } ?>
	<tr>
		<td class="a" align="right" colspan="2">* Campos Obrigatorios</td>
	</tr>
	
	<tr>
		<td>
			<table cellpadding="2" cellspacing="2" width="100%">
<?php /*?>			<tr>
				<TD class="f-c" align="right"><font class="a">*</font>Category Name :</TD>
				
				<TD><input type="text" name="categoryname" size="32" class="solidinput" value="<? echo $row["name"]; ?>"> </TD>
			</tr>
			
			<tr>
				<td class="f-c" align="right">Description :</td>
				<td><textarea name="description" rows="3" cols="30"><?php echo $row["description"]; ?></textarea></td>
			</tr>
<?php */?>			<?
				if($totallang>0)
				{
					$i=1;
					while($objlang = mysql_fetch_object($reslang))
					{	
			?>
			<tr>
				<TD class="f-c" align="right"><font class="a">*</font>Nome da Categoria(
		      <?=$objlang->language_name;?>):</TD>
				
				<TD><input type="text" id="categoryname<?=$i;?>" name="categoryname<?=$i;?>" size="32" class="solidinput" value="<? echo $row[$objlang->language_prefix."_name"]; ?>"> </TD>
			</tr>
			<tr>
				<td class="f-c" align="right">Descri&ccedil;&atilde;o (<?=$objlang->language_name;?>):</td>
				<td><textarea name="description<?=$i;?>" rows="3" cols="30"><?php echo $row[$objlang->language_prefix."_description"] ; ?></textarea></td>
			</tr>			
			<?
						$i++;
					}
				}
			?>
			<input type="hidden" name="countervalue" value="<?=$i;?>">
			<tr>
				<TD class="f-c" align="right"><font class="a">*</font>Status da Categoria :</TD>
				<td>
				
				<select name="status" class="solidinput">
				<!--<option value="" selected="selected">---Select---</option>-->
				<option value="1" <?php if($row["status"]==1){ echo " selected";} ?> selected="selected">Ativa</option>
				<option value="0" <?php if($row["status"]!="" and $row["status"]==0){ echo " selected";} ?>>Inativa</option>
				</select>
				</td>
			</tr>

<?php /*?>			<tr>
				<td class="f-c" align="right">Logo :</td>
				<td>
				<table>
					<tr>
					<?php if(trim($row["picture"])<>""){ ?><td><img src="images/categories/thumbs/<?=$row["picture"];?>" height="70" width="90"><? } ?><br>
					<? if(trim($logo)<>""){ ?>
					<IMG SRC="<?=DIR_WS_ICONS?>magnifier.gif" WIDTH="12" HEIGHT="14" BORDER=0 ALT="">&nbsp;<a class="viewclass" href="javascript:popImage('<?=DIR_WS_CATEGORIES.$logo;?>')">View Large
</a>
					</td><?php } ?>
					<td ><input name="logo" type="file" class="solidinput"  value="<? echo $logo;?>" size="35" maxlength="50">
					</td>
					</tr>
				</table>
				</td>
			</tr>
<?php */?>			
			<tr>
				<td>&nbsp;</td><td>&nbsp;</td>
			</tr>
			  
			<tr>
					<td>&nbsp;</td>
					<td>
					<?php
					if($_GET['category_delete']!="" and $cid!="")
					{ 
					
					?>
					<input type='button' name='<? if($_GET['category_delete']!="" or $cid!=""){?>deletecategory<? }else {?>addcategory<? } ?>' value='<? if($_GET['category_delete']!="" or $cid!="") {?> Excluir Categoria <? }else{ ?> Adicionar Categoria<? } ?>' class="bttn" onClick="delconfirm('addcategory.php?delete=<?=$cid?>')">
					<?php 
					}
					else
					{ 
					
					?>
					<input type='submit' name='<? if($_GET['category_edit']!="" or $cid!=""){?>editcategory<? }else {?>addcategory<? } ?>' value='<? if($_GET['category_edit']!="" or $cid!="") {?> Editar Categoria <? }else{ ?> Adicionar Categoria <? } ?>' class="bttn">
					<?php 
					}
					?>
					</td>
			</tr>
			<tr>
				<td colspan="2">&nbsp;</td>
			</tr>
			</table>
			
<? if($_GET['category_edit']!="") {?>
<input type="hidden" name="edit" value="<?=$_GET['category_edit']?>">

<? if($tmpnew!="1") {?>
<input type="hidden" name="parents" value="0">
<? } ?>
<? } ?>

		</td>
	</tr>
</table>
</form>
<br><br>
</BODY>
</HEAD>
</HTML>
