<?php
	//include("function.php");
	include("connect.php");
	include_once("admin.config.inc.php");
	include("resize.php");
	include("security.php");
//	include("category_function.php");
	include("config_setting.php");
	$type1 = "1";
	$type3 = "3";
	include("pagepermission.php");

if($perpage['manageProductPage'])
{
	$PRODUCTSPERPAGE = 10; 
}
else
{
	if(trim($PRODUCTSPERPAGE)=="")
	{
		$PRODUCTSPERPAGE=10;
	}
}

if(!$_GET['order'])
$order = "";
else
$order = $_GET['order'];
if(!$_GET['pgno'])
{
	$PageNo = 1;
}
else
{
	$PageNo = $_GET['pgno'];
}
/********************************************************************
     Get how many products  are to be displayed according to the  Events
********************************************************************/
	$StartRow =   $PRODUCTSPERPAGE * ($PageNo-1);
/***********************************************
display search results
***********************************************/
 /*********************************************

  Display all Products

  *********************************************/
	//$prodID=$_GET['prodID'];
	$catID=$_GET['catID'];
	//echo $prodID;
	//exit;

	if(!isset($catID))
	{
		$catID=0;
	}

	if($catID>0)
	{
	$query="select * from products where categoryID='$catID' and name like '$order%' order by categoryID";
	$result=mysql_query($query) or die (mysql_error());
	$totalrows=mysql_num_rows($result);
	$totalpages=ceil($totalrows/$PRODUCTSPERPAGE);
	$query .= " LIMIT $StartRow,$PRODUCTSPERPAGE";
	$result =mysql_query($query);
	$total = mysql_num_rows($result);
		$getcat = "select name from categories where categoryID='$catID'";
		$resnew = mysql_query($getcat);
		$catrow = mysql_fetch_object($resnew);
	$SubCat="<a class='header-cattb-link' href='manageproducts.php'>"."Home"." >> "."</a><span class=header-cattb-link>".$catrow->name."</span>";
	}
	else
	{
		$query="select * from categories where name like '$order%' order by categoryID";
		$result=mysql_query($query) or die (mysql_error());
		$totalrows=mysql_num_rows($result);
		$totalpages=ceil($totalrows/$PRODUCTSPERPAGE);
		$query .= " LIMIT $StartRow,$PRODUCTSPERPAGE";
		$result =mysql_query($query);
		$totalcat = mysql_num_rows($result);		
		$SubCat="<a class='header-cattb-link' href='manageproducts.php'>"."Home"." >> "."</a>";		
	}
 ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML><HEAD>
<meta http-equiv="Content-Type" content="text/html; charset=<?=$lng_characset;?>" />
<META content="MSHTML 6.00.2600.0" name=GENERATOR>
<link rel="stylesheet" href="main.css" type="text/css">
<script language="javascript" src="popupimage.js"></script>
<script language="JavaScript">
	//function gotocategory(cat)
//	{
//		if(trim(cat)!="")
//		{
//			window.location.href="manageproducts.php?catID="+cat;
//		}
//	}
	function delconfirm(loc)
	{
		if(confirm("Are you Sure Do You Want To Delete"))
		{
			window.location.href=loc;
		}
		return false;
	}
</script>
<script language="JavaScript">
	function gotocategory(cat)
	{
		if(cat!="")
		{
			window.location.href="manageproducts.php?catID="+cat;
		}
	}
</script>
<script language="javascript" type="text/javascript">
	function OnDeleteAction(id)
	{
		if(confirm("Are you sure do you want to delete this?"))
		{
			prid = document.getElementById('product_delete_id_' + id).value;
			crid = document.getElementById('product_delete_cid_' + id).value;
			locat = 'addproducts.php?product_delete=' + prid +'&product_cid=' + crid;
			window.location.href=locat;
		}
	}
</script>
</HEAD>
<BODY bgcolor="#ffffff" style="padding-left:10px">
<TABLE width="100%" cellPadding="0" cellSpacing="10">
  <!--DWLayoutTable-->
    <TR> 
      <TD class="H1">Administrar Produtos</TD>
    </TR>
  <TR>
    <TD background="images/vdots.gif"><IMG height=1 
      src="images/spacer.gif" width=1 ></TD></TR>
  <TR>
    <TD><!--content-->

      <TABLE cellSpacing="2" cellPadding="2" width="100%" >
        <TBODY>
            <TR>
              <TD colspan="2"> 
                <!--options-->
                <IMG height=11 src="images/001.gif" width=8 ><A class=la href="addproducts.php"> Adicionar Novo Produto</A> 
                <!--/options-->
              </TD>
              </TR>
			  <tr>
			  	<td colspan="2">&nbsp;</td>
			  </tr>
			  <tr >
	          <td class="tdTextBold"><B>Visualizar Produto Por:</B>

				</td>
				
			  </tr>
			 
			  </TBODY>
			  </TABLE>
			  <br>
	<FORM id="form1" name="form1" action="manageproducts.php" method="post">
      <TABLE cellSpacing="0" cellPadding="1">
        <TBODY>
        <TR>
          <TD><a class="la" href="manageproducts.php?catID=<?=$catID?>">Todos</a></TD>
          <TD class="lg">|</TD>
          <TD><a class="la" href="manageproducts.php?order=A&catID=<?=$catID?>">A</a></TD>
          <TD class="lg">|</TD>
          <TD><a class="la" href="manageproducts.php?order=B&catID=<?=$catID?>">B</a></TD>
          <TD class="lg">|</TD>
          <TD><a class="la" href="manageproducts.php?order=C&catID=<?=$catID?>">C</a></TD>
          <TD class="lg">|</TD>
          <TD><a class="la" href="manageproducts.php?order=D&catID=<?=$catID?>">D</a></TD>
          <TD class="lg">|</TD>
          <TD><a class="la" href="manageproducts.php?order=E&catID=<?=$catID?>">E</a></TD>
          <TD class="lg">|</TD>
          <TD><A class="la" href="manageproducts.php?order=F&catID=<?=$catID?>">F</A></TD>
          <TD class="lg">|</TD>
          <TD><A class="la" href="manageproducts.php?order=G&catID=<?=$catID?>">G</A></TD>
          <TD class="lg">|</TD>
          <TD><A class="la" href="manageproducts.php?order=H&catID=<?=$catID?>">H</A></TD>
          <TD class="lg">|</TD>
          <TD><A class="la" href="manageproducts.php?order=I&catID=<?=$catID?>">I</A></TD>
          <TD class="lg">|</TD>
          <TD><A class="la" href="manageproducts.php?order=J&catID=<?=$catID?>">J</A></TD>
          <TD class="lg">|</TD>
          <TD><A class="la" href="manageproducts.php?order=K&catID=<?=$catID?>">K</A></TD>
          <TD class="lg">|</TD>
          <TD><A class="la" href="manageproducts.php?order=L&catID=<?=$catID?>">L</A></TD>
          <TD class="lg">|</TD>
          <TD><A class="la" href="manageproducts.php?order=M&catID=<?=$catID?>">M</A></TD>
          <TD class="lg">|</TD>
          <TD><A class="la" href="manageproducts.php?order=N&catID=<?=$catID?>">N</A></TD>
          <TD class="lg">|</TD>
          <TD><A class="la" href="manageproducts.php?order=O&catID=<?=$catID?>">O</A></TD>
          <TD class="lg">|</TD>
          <TD><A class="la" href="manageproducts.php?order=P&catID=<?=$catID?>">P</A></TD>
          <TD class="lg">|</TD>
          <TD><A class="la" href="manageproducts.php?order=Q&catID=<?=$catID?>">Q</A></TD>
          <TD class="lg">|</TD>
          <TD><A class="la" href="manageproducts.php?order=R&catID=<?=$catID?>">R</A></TD>
          <TD class="lg">|</TD>
          <TD><A class="la" href="manageproducts.php?order=S&catID=<?=$catID?>">S</A></TD>
          <TD class="lg">|</TD>
          <TD><A class="la" href="manageproducts.php?order=T&catID=<?=$catID?>">T</A></TD>
          <TD class="lg">|</TD>
          <TD><A class="la" href="manageproducts.php?order=U&catID=<?=$catID?>">U</A></TD>
          <TD class="lg">|</TD>
          <TD><A class="la" href="manageproducts.php?order=V&catID=<?=$catID?>">V</A></TD>
          <TD class="lg">|</TD>
          <TD><A class="la" href="manageproducts.php?order=W&catID=<?=$catID?>">W</A></TD>
          <TD class="lg">|</TD>
          <TD><A class="la" href="manageproducts.php?order=X&catID=<?=$catID?>">X</A></TD>
          <TD class="lg">|</TD>
          <TD><A class="la" href="manageproducts.php?order=Y&catID=<?=$catID?>">Y</A></TD>
          <TD class="lg">|</TD>
          <TD><A class="la" href="manageproducts.php?order=Z&catID=<?=$catID?>">Z</A></TD>
		  </TR></TBODY></TABLE>
		</form>
		<?
        if(($totalcat<=0 && !$total) or ($total<=0 && !totalcat))
        {
		?>
		<table width="70%" border="0" cellspacing="1" cellpadding="1" align="center" bgcolor="#000000">
        <tr> 
          <td> 
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr> 
                <td class=th-a> 
                  <div align="center">Nenhum Produto para exibir</div>
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
	  	<table cellpadding="0" cellspacing="0" width="100%" border="0">
		    <tr>
				<td>
		
		<FORM id="form2" name="form2" action="" method="post">  
          <TABLE width="100%"  cellSpacing="0" class="t-a" border="1">
            <!--DWLayoutTable-->
            <TBODY>
			  <tr bgcolor="#484848"><tD colspan="8">&nbsp;<?=$SubCat?>  
			  </td></tr>
			  <tr>
				<!-- DISPLAY THE SUBCATEGORIES AND ON CLICK GO TO SUB CATEGORIES -->
			  <?
				if($totalcat!="")
				{
					while($catdisp = mysql_fetch_array($result))
					{
			  ?>
			 <td><? if($catdisp["products_count"]>0){?><a class="folder" href="manageproducts.php?catID=<?=$catdisp["categoryID"];?>"><img class="folder" src="<?='images/icons/folder.gif'?>">&nbsp;&nbsp;<?=$catdisp["name"];?></a><? } else{?> <img class="folder" src="<?='images/icons/folder.gif'?>">&nbsp;&nbsp;<?=$catdisp["name"];?><? }?>&nbsp;&nbsp;Produtos : <?=$catdisp["products_count"];?></td>
			 </tr>
			 	<?
					}
				}
				?>
				<TR>
					<TD colspan="8">
				<!--END DISPLAY CATEGORIES-->	
			  <?php 
			  if($total>0)
			  {
			  ?>	
				  <TR class="th-a"> 
					<TD  width="6%" align="center">No</TD>
					<TD  width="19%" align="center">Imagem</TD>
					<TD  width="11%">C&oacute;digo</TD>
					<TD  width="22%">Produto</TD>
					<TD  width="15%">Pre&ccedil;o</TD>
					<!--<TD  width="10%">InStock</TD>-->
					<TD  width="11%">Status</TD>
					<TD  width="16%" align="center">A&ccedil;&atilde;o</TD>
				  </TR>
				  <?php
			  }
			  ?>
			  
              <?php
			  for($i=0;$i<$total;$i++)
			  {
				 if($PageNo>1)
				 {
					$srno = ($PageNo-1)*$PRODUCTSPERPAGE+$i+1;
				 }
				 else
				 {
					$srno = $i+1;
				 }
			  
				$row = mysql_fetch_object($result);
				$id=$row->productID;
				$catID=$row->categoryID;
				$image = $row->picture1;		
				$code=$row->product_code;
		
				$name = $row->name;
				$price= $Currency.$row->price;
				$status = $row->enabled;
			
				$cellColor = "";
				$cellColor = ConfigcellColor($i);
				?>
			  	<TR class="<?=$cellColor?>">
			  	
				<TD    height="37" width="6%" align="center">
				<?=$srno;?></TD>	
				<TD   height="37" width="19%" align="center">
				<? if($image!=""){ echo "<img src='../uploads/products/thumbs/thumb_".$image."'>";}else{ echo "&nbsp;";} ?>
				</TD>
				
				<TD    height="37" width="11%">
					<? if($code!=""){ echo $code; }else{ echo "&nbsp;"; }?>				</TD>
				
				<TD    height="37" width="22%">
				<a href="manageproducts.php?prodID=<?=$id?>&catID=<?=$catID?>" class="link-cat"><? if($name!=""){ echo stripslashes($name); }else{echo "&nbsp;";} ?></a>				</TD>
				
				<TD    height="37" width="15%">
					<? if($price!=""){echo $price;}else{ echo "0.00"; } ?>				</TD>
				
				<TD    height="37" width="11%">
					<? if($status!=""){ if($status==1){echo "<font color='green'>Ativo</font>";}else{ echo "<font color='red'>Inativo</font>";} }else{ echo "<font color='red'>Not Defined</font>";} ?>				</TD>
				
				<TD  width="16%" align="center">
			<INPUT class="bttn-s" onClick="window.location.href='addproducts.php?product_edit=<?=$id;?>'" type="button" value="Editar">
				<input name="button" type="button" class="bttn-s" value="Excluir" onClick="return OnDeleteAction(<?=$id;?>);">
				<input type="hidden" id="product_delete_id_<?=$id;?>" name="product_delete_id" value="<?=$id;?>">
				<input type="hidden" id="product_delete_cid_<?=$id;?>" name="product_delete_cid" value="<?=$catID;?>">
                </TD>
              </TR>
              <?
			  }
		  }
			  ?>
          </TABLE>
         <!-- <A 
      class=paging id=first disabled>&lt; First Page</A> -->&nbsp; 
	  <?php
		if($PageNo>1)
		{
                  $PrevPageNo = $PageNo-1;

	    ?>
	  <A class="paging" href="manageproducts.php?order=<? echo $iid ?>&pgno=<?php echo $PrevPageNo; ?>&catID=<?=$catID?>">&lt; P&aacute;gina Anterior</A>
	  <?
	   }
	  ?> &nbsp;&nbsp;&nbsp;
	  <?php
        if($PageNo<$totalpages)
        {
         $NextPageNo = 	$PageNo + 1;
      ?>
	  <A class="paging" href="manageproducts.php?order=<? echo $iid ?>&pgno=<?php echo $NextPageNo;?>&catID=<?=$catID?>">Pr&oacute;xima P&aacute;gina &gt;</A>
	  <?
       }
      ?>
	   &nbsp; 
         <!-- <A class=paging id=last 
      href="javascript:__doPostBack('last','')" disabled>Last Page &gt;</A>--> 
        </FORM>
	</td>
	</tr>
</table>	
		<!--/content--></TD></TR></TBODY></TABLE></BODY></HTML>