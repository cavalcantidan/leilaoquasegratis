<?
	include("admin.config.inc.php");
 	include("connect.php");
	include("security.php");
	include("imgsize.php");
	
	if(isset($_GET['id']))
	{
		
		$bid = $_GET['id'];
		
		$query = "Select * from brands where id = '$bid'";
		$result = mysql_query($query) or die(mysql_error());
		$row = mysql_fetch_object($result);
		$brandname = stripslashes($row->brandname);
		$pcat = explode("|",$row->parentcategories);
		$sinlmenu = $row->show_in_leftmenu;
		$brandlogo = $row->brand_logo;	
		$brandlogothumb = $row->brand_logo_thumb;	
	}
	elseif(isset($_POST['submit']) and trim($_POST['submit']) == "Add")
	{
		$brandname = addslashes($_POST["brandname"]);
		$showinlmenu = $_POST["showinlmenu"];
		$totalcat = $_POST["totalcat"];
		$pcategories='';
		for($l=0;$l<$totalcat;$l++)
		{
			if($_POST['chk'.$l]!="")
			{	
				if($pcategories=="")
				{
				   $pcategories= $_POST['chk'.$l];
				}
				else
				{
					$pcategories .= "|".$_POST['chk'.$l];
				}	
			}
		}
		//if($_FILES['image']['name']!="")
//		{
//			
//			$time = time();
//			$imagename = $time."_".$_FILES['image']["name"];
//			$imgname = "";//$time."_".$imagename.".jpg";
//			if(file_exists($_FILES['image']['tmp_name']))
//			{
//				copy($_FILES['image']['tmp_name'],"images/brands/".$imagename);
//				$imgname = $imagename;
//			}
//		}
		if(trim($brandname)==""){
			$Error = 1;
		}else{
			$query ="Insert into brands(brandname,show_in_leftmenu,parentcategories) values('$brandname','$showinlmenu','$pcategories')";
			mysql_query($query) or die(mysql_error());
			
			$bidnew = mysql_insert_id();
				
				// LOGO UPLOAD FILE //
			logoimage(1,$bidnew);
			
			
			header("location:message.php?msg=61");
			exit;
		}
	}
	elseif(isset($_POST['submit']) and trim($_POST['submit']) == "Edit")
	{
		$id = $_POST["bid"];
		$brandname = $_POST["brandname"];
		$showinlmenu = $_POST["showinlmenu"];
		$totalcat = $_POST["totalcat"];
		$pcategories='';
		for($l=0;$l<$totalcat;$l++)
		{
			if($_POST['chk'.$l]!="")
			{	
				if($pcategories=="")
				{
				   $pcategories= $_POST['chk'.$l];
				}
				else
				{
					$pcategories .= "|".$_POST['chk'.$l];
				}	
			}
		}	
		//if($_FILES['image']['name']!="")
//		{		
//			$time = time();
//			$imagename = $time."_".$_FILES['image']['name'];
//			$imgname = "";
//			if(file_exists($_FILES['image']['tmp_name']))
//			{
//				copy($_FILES['image']['tmp_name'],"images/brands/".$imagename);
//				$imgname = $imagename;
//			}
//		}
		if(trim($brandname)==""){
			$Error = 1;
		}else{
		//if($_FILES['image']['name']!="")
//		{
//			$query = "Update brands set brandname='$brandname',show_in_leftmenu='$showinlmenu',parentcategories='$pcategories' where id='$id'";
//		}
//		else
//		{
			$query = "Update brands set brandname='$brandname',show_in_leftmenu='$showinlmenu',parentcategories='$pcategories' where id='$id'";
		//}	
			mysql_query($query) or die(mysql_error());
			
			$bidnew = $id;
				
			// LOGO UPLOAD FILE //
			logoimage(1,$bidnew);

			
			header("location:message.php?msg=62");
			exit;
		}
	}
	elseif(isset($_GET["delid"])){
		$delid = $_GET["delid"];
		$query = "Delete from brands where id='$delid'";
		mysql_query($query) or die(mysql_error());
		header("location:message.php?msg=63");
		exit;
	}
	
	function logoimage($logo,$bidnew)
		{
			//$logo;
			//exit;
			
			if($logo==1)
			{
				if (isset($_FILES["image"]) && $_FILES["image"]["name"] && preg_match('/\.(jpg|jpeg|gif|jpe|pcx|bmp)$/i', $_FILES["image"]["name"])) //upload category thumbnail
				{
					$time = time();
					$imagename = $time."_".$_FILES["image"]["name"];
					$imgname = "";//$time."_".$imagename.".jpg";
					$imgthumbname = "";
				if(file_exists($_FILES['image']['tmp_name']))
				{
					
					copy($_FILES['image']['tmp_name'],"images/brands/".$imagename);
				$dest = "images/brands/thumbs/";
				ImageResizenew($_FILES['image']['tmp_name'],$dest,'thumb_'.$imagename);
					$imgname = $imagename;
					$imgthumbname = 'thumb_'.$imagename;
				}
				if($bidnew!="")
				{
					mysql_query("UPDATE brands SET brand_logo='".$imgname."',brand_logo_thumb='".$imgthumbname."' WHERE id='$bidnew'") or die (mysql_error());
				
				}
				
			} // IF SET LOGO END
		} // IF LOGO END
	} // END FUNCTION 
//		//*************************END*************************//
	
?>

<html>
<head>
<title><? if(isset($faq_id)) {?>Edit Brand<? }else { ?>Add Brand<? }?></title>
<meta http-equiv="Content-Type" content="text/html; charset=<?=$lng_characset;?>">
<link rel="stylesheet" href="main.css" type="text/css">
</head>
<script language="javascript">
	function formsubmit(f1)
	{
		if(f1.brandname.value=="")
		{
			alert("Please enter Brand Name");
			f1.brandname.select();
			return false;
		}
		//if(f1.taxvalue.value=="")
//		{
//			alert("Please enter tax value");
//			f1.taxvalue.select();
//			return false;
//		}
//		if(!Number(f1.taxvalue.value)){
//			alert("please enter valid tax value");
//			f1.taxvalue.select();
//			return false;
//		}
		return true;
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
<link rel=stylesheet type="text/css" href="rte.css">

<body bgcolor="#ffffff">
	
		<form name="f1" action="addbrand.php" enctype="multipart/form-data" method="post" onSubmit="return formsubmit(this)">
		
		<TABLE cellSpacing=10 cellPadding=0  border=0 width="697">
		<TR>
			<TD width="677" class=H1><? if (!isset($bid)) {?>Add Brand<? }else { ?>Edit Brand<? }?></TD>
		</TR>
		<TR>
			<TD background="images/vdots.gif"><IMG height=1 src="images/spacer.gif" width=1 border=0></TD>
		</TR>
		<tr>
			<td>
				<?php
	      if($Error)
          {
            if($Error==1)
            {
              $msg = "Form Is Not Completely Filled Up!!!";
            }


        ?>
		<table width="80%" bordercolor="#000000" bgcolor="#ffffff" cellspacing="0" cellpadding="0" align="center" border="1">
          <tr>
          <td>
		  <table border="0" cellpadding="0" cellspacing="0" align="center">
		  <tr>
          <td>
            <div align="center"><font face="Verdana" size="2" color="#990000">
              <?php echo $msg; ?>
              </font></div>
          </td>
        </tr>
		
			  </table>
          </td>
        </tr>
      </table>
	 <?php }?>
			</td>
		</tr>
		  
		  <TR>
		  	<TD>
			
			<TABLE cellSpacing=2 cellPadding=2 width="697" border=0>
          <TBODY>
            <TR align="right"> 
              <TD colSpan=3 class="a">* Campos Obrigatorios</TD>
            </TR>
            <TR> 
              <TD class=th-d colSpan=3>Informa&ccedil;&otilde;es B&aacute;sicas</TD>
            </TR>
			<TR> 
              <TD width="148" align=right></TD>
              <TD width="539"> </TD>
            </TR>
			<tr>
				<td class=f-c align=right valign="middle" width="148">Categorias :</td>
				<td>
					<?
						$qrr="select * from categories where parents='0'";
						$res = mysql_query($qrr) or die(mysql_error());
						$tott=mysql_num_rows($res);
						if($tott > "0")
						{
							$i=0;
							while($roww=mysql_fetch_array($res))
							{			
					?>
							<input type="checkbox" name="chk<?=$i?>" class="solidinput" value="<?=$roww["categoryID"]?>" <? if(is_array($pcat)){ if(array_keys($pcat,trim($roww["categoryID"]))){ echo "checked"; } } ?>>&nbsp;&nbsp;<?=$roww["name"];?>&nbsp;&nbsp;	
							
					<?	
							$i++;	
							}
							$tcat=$i;
						}
					?>
					<input type="hidden" name="totalcat" value="<?=$tcat?>">
				</td>
			</tr>
			<tr>
				<td class=f-c align=right valign="middle" width="148">Exibir no Menu Esquerdo:</td>	
				<td><input type="checkbox" name="showinlmenu" <? if($sinlmenu=="1"){ echo "checked"; }?> value="1" class="solidinput"></td>
			</tr>
			<TR valign="middle"> 
              <TD class=f-c align=right valign="middle" width="148"><font class=a>*</font>Brand Name:</TD>
              <TD><input type="text" name="brandname" class="solidinput" value="<?=stripslashes($brandname);?>"></td>
            </TR>
			<tr>
				<td class=f-c align=right valign="middle" width="148">Brand Logo :</td>
				<td><? if($brandlogothumb!=""){?><img height="70" width="90" src="images/brands/thumbs/<?=$brandlogothumb;?>"><? } ?><br>
				<? if($brandlogo!=""){?>
					<IMG SRC="images/icons/magnifier.gif" WIDTH="12" HEIGHT="14" BORDER=0 ALT="">&nbsp;<a class="viewclass" href="javascript:popImage('images/brands/<?=$brandlogo;?>')">Ver Tamanho Maior
</a><? } ?>&nbsp;&nbsp;&nbsp;&nbsp;<input class="solidinput" type="file" name="image" size="35"></td>
			</tr>
			</TBODY>
			</TABLE>
			
				</TD>
				</TR>
			</TABLE>
			<br><br>
			  	
			<table border="0" width="50%" align="left">   
           
            <TR align="center"> 
              <TD> 
			  	<INPUT type="submit" value="       <? if (!isset($bid)) {?>Adicionar<? }else { ?>Editar<? }?>       " class="bttn" name="submit"
				> 	
				<? if(isset($bid)) { ?>
				<input type="hidden" value="<? echo $bid; ?>" name="bid">
				<? } ?>
			  </TD>
            </TR>
            
          
        </TABLE>
		</form>
</body>
</html>
