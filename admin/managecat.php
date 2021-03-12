<?php
	include_once("admin.config.inc.php");
	include("connect.php");
	include("security.php");
	include("config_setting.php");
	$type1 = "1";
	$type3 = "3";
	include("pagepermission.php");
	
$PRODUCTSPERPAGE=10;
	
if(!$_GET['order'])
$iid = "";
else
$iid = $_GET['order'];
if(!$_GET['pgno'])
{
	$PageNo = 1;
}
else
{
	$PageNo = $_GET['pgno'];
}
//     Get how many products  are to be displayed according to the  Events
	
	$StartRow =   $PRODUCTSPERPAGE * ($PageNo-1);
//display search results
//  Display all Categories
	$catid=$_GET['catID'];
	//echo $catid;
	//exit;
	if(!isset($catid))
	{
		$catid=0;
	}

	if($catid<>0)
	{
		$query="select * from categories where name like '$iid%' order by categoryID";
	
	}
	else
	{
		$query="select * from categories where name like '$iid%' order by categoryID";
	
	}
	
	$result=mysql_query($query) or die (mysql_error());
	$totalrows=mysql_num_rows($result);
	$totalpages=ceil($totalrows/$PRODUCTSPERPAGE);
	
	$query .= " LIMIT $StartRow,$PRODUCTSPERPAGE";
	$result =mysql_query($query) or die(mysql_error());
	$total = mysql_num_rows($result);
	
	
	//End Pageing Inforamtion

?>



<html>
<head>
<title>Manage Links Category</title>
<meta http-equiv="Content-Type" content="text/html; charset=<?=$lng_characset;?>">
</head>

<link rel="stylesheet" href="main.css" type="text/css">
<script language="JavaScript">
	function conf()
	{
		if(confirm("Are You Sure"))
		{
			return true;
		}
		return false;
	}
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
			window.location.href="managecat.php?catID="+cat;
		}
	}
</script>
<body bgcolor="#ffffff" style="padding-left:10px">
	
	<TABLE cellSpacing=10 cellPadding=0  border=0 width="89%">
		<TR>
			<TD class=H1>Administrar Categoria de Produtos</TD>
		</TR>
		<TR>
			<TD background="images/vdots.gif"><IMG height=1 
			  src="images/spacer.gif" width=1 border=0></TD>
		</TR>
		<tr>	 
		<td>
		<TABLE cellSpacing=2 cellPadding=2 width="100%" border=0>
        <TBODY>
            <TR>
              <TD align="left"> 
                <!--options-->
                <IMG height=11 src="images/001.gif" width=8 border=0><A class=la href="addcategory.php"> Adicionar Nova Categoria</A><br><br> 
                <!--/options-->
              </TD>
              </TR>
			  
			  <tr>
	          <td><b>Visualizar categoria por:</b></td>
			  </tr>
			 
			  </TBODY>
			  </TABLE>
			  <FORM id="form1" name="form1" action="managecat.php" method="post">
      <TABLE cellSpacing=0 cellPadding=1 border=0 >
        <TBODY>
        <TR>
          <TD><a class=la href="managecat.php">Todas</a></TD>
          <TD class=lg>|</TD>
                
          <TD><a class=la href="managecat.php?order=A&catID=<?=$catid?>">A</a></TD>
          <TD class=lg>|</TD>
          <TD><a class=la href="managecat.php?order=B&catID=<?=$catid?>">B</a></TD>
          <TD class=lg>|</TD>
          <TD><a class=la href="managecat.php?order=C&catID=<?=$catid?>">C</a></TD>
          <TD class=lg>|</TD>
          <TD><a class=la href="managecat.php?order=D&catID=<?=$catid?>">D</a></TD>
          <TD class=lg>|</TD>
          <TD><a class=la href="managecat.php?order=E&catID=<?=$catid?>">E</a></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="managecat.php?order=F&catID=<?=$catid?>">F</A></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="managecat.php?order=G&catID=<?=$catid?>">G</A></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="managecat.php?order=H&catID=<?=$catid?>">H</A></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="managecat.php?order=I&catID=<?=$catid?>">I</A></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="managecat.php?order=J&catID=<?=$catid?>">J</A></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="managecat.php?order=K&catID=<?=$catid?>">K</A></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="managecat.php?order=L&catID=<?=$catid?>">L</A></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="managecat.php?order=M&catID=<?=$catid?>">M</A></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="managecat.php?order=N&catID=<?=$catid?>">N</A></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="managecat.php?order=O&catID=<?=$catid?>">O</A></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="managecat.php?order=P&catID=<?=$catid?>">P</A></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="managecat.php?order=Q&catID=<?=$catid?>">Q</A></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="managecat.php?order=R&catID=<?=$catid?>">R</A></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="managecat.php?order=S&catID=<?=$catid?>">S</A></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="managecat.php?order=T&catID=<?=$catid?>">T</A></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="managecat.php?order=U&catID=<?=$catid?>">U</A></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="managecat.php?order=V&catID=<?=$catid?>">V</A></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="managecat.php?order=W&catID=<?=$catid?>">W</A></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="managecat.php?order=X&catID=<?=$catid?>">X</A></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="managecat.php?order=Y&catID=<?=$catid?>">Y</A></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="managecat.php?order=Z&catID=<?=$catid?>">Z</A></TD></TR></TBODY></TABLE>
			</form>
			
		
		<?php 
		if(!$total)
        {
        ?>
		<br><br><br>
		<table width="70%" border="0" cellspacing="1" cellpadding="1" align="center" bgcolor="#000000">
        <tr> 
          <td > 
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr> 
                <td class=th-a > 
                  <div align="center">Sem Categorias para Exibir</div>
                </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
      <?php
      }
      else
      {
      ?>
	<table cellpadding="0" cellspacing="0" width="100%">
		
	    <tr>
		<td>
		
		<FORM id="form2" name="form2" action="" method="post">
          <TABLE width="100%" cellSpacing="0" class="t-a">
            <!--DWLayoutTable-->
            <TBODY>
			  <TR class="th-a"> 
				<TD  width="45%">Titulo</TD>
				<TD  width="10%">Produtos</TD>
				<!--<TD  width="10%">Logo</TD>-->
				<TD  width="10%">Status</TD>
				<? if($SubCat!="Home"){?>
				<TD  width="15%" align="center">A&ccedil;&atilde;o</TD>
				<? } ?>
              </TR>
               <?php
			 
			  for($i=0;$i<$total;$i++)
			  {
				$row = mysql_fetch_object($result);
				$id=$row->categoryID;
				$name = stripslashes($row->name);
				$products = $row->products_count;
				$logo = $row->picture;
				$status = $row->status;
		
				$cellColor = "";
				$cellColor = ConfigcellColor($i);
				
				$parentsyes[]=$id;
				
				if(!in_array($ParentID,$parentsyes))
				{
				?>
			  	<TR class="<?=$cellColor?>">
			  		
				<TD    height="37" width="40%">
				<? if($name!=""){ echo $name; }else{echo "&nbsp;";} ?>
				</TD>
				<TD    height="37" width="10%">
					<? if($products!=""){ echo $products; }else{ echo "&nbsp;"; }?>
				</TD>

				<TD    height="37" width="10%">
					<? if($status==1){ echo "<font color='green'>Ativo</font>";}else{ echo "<font color='red'>Inativo</font>";} ?>
				</TD>
				<TD  width="15%"  align="center">
			<? if($count=="-2"){ ?>	
				<INPUT class="bttn-s" onClick="window.location.href='addcategory.php?category_edit=<?=$id;?>'" type="button" value="Editar"> 	
			<? } else {?>	
			<INPUT class="bttn-s" onClick="window.location.href='addcategory.php?category_edit=<?=$id;?>&tempnew=1'" type="button" value="Editar"> 	
			<? } ?>
            <input name="button" type="button" class="bttn-s" value="Excluir" onClick="window.location.href='addcategory.php?category_delete=<?=$id;?>'">
			
                </TD>
              </TR>
              <?
			  } // in array
		  } // for loop
			  ?>
              
            
          </TABLE>
         <!-- <A 
      class=paging id=first disabled>&lt; First Page</A> -->&nbsp; 
	  <?php
		if($PageNo>1)
		{
                  $PrevPageNo = $PageNo-1;

	    ?>
	  <A class="paging" href="managecat.php?order=<? echo $iid ?>&pgno=<?php echo $PrevPageNo; ?>&catID=<?=$catid?>">&lt; P&aacute;gina Anterior</A>
	  <?
	   }
	  ?> &nbsp;&nbsp;&nbsp;
	  <?php
        if($PageNo<$totalpages)
        {
         $NextPageNo = 	$PageNo + 1;
      ?>
	  <A class="paging"  href="managecat.php?order=<? echo $iid ?>&pgno=<?php echo $NextPageNo;?>&catID=<?=$catid?>">Pr&oacute;xima P&aacute;gina&gt;</A>
	  <?
       }
      ?>
	   &nbsp; 
         <!-- <A class=paging id=last 
      href="javascript:__doPostBack('last','')" disabled>Last Page &gt;</A>--> 
        </FORM>
		<?php

      }

      ?>
	 </td>
	</tr>
</table>
	  </td>
	</tr>
	</tbody>
	</table>
	<br><br>
</body>
</html>
