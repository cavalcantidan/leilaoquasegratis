<?
	include("connect.php");
	include_once("admin.config.inc.php");
	include("security.php");
	include("config_setting.php");

$PRODUCTSPERPAGE = 10; 
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
/***********************************************/
if($order!="")
{
	$query = "select * from bidpack where bidpack_name like '$order%' order by id";
}
else
{
	$query = "select * from bidpack order by id";
}
	$result=mysql_query($query) or die (mysql_error());
	$totalrows=mysql_num_rows($result);
	$totalpages=ceil($totalrows/$PRODUCTSPERPAGE);
	$query .= " LIMIT $StartRow,$PRODUCTSPERPAGE";
	$result =mysql_query($query);
	$total = mysql_num_rows($result);
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?=$lng_characset;?>" />
<title></title>
<link rel="stylesheet" href="main.css" type="text/css">
</head>

<body bgcolor="#ffffff" style="padding-left:10px">
<table width="100%" cellPadding="0" cellSpacing="10">
  <!--DWLayoutTable-->
  <TR> 
    <TD class="H1">Administrar Pacotes de Bids</TD>
  </TR>
  <TR>
    <TD background="images/vdots.gif"><IMG height=1 src="images/spacer.gif" width=1 ></TD>  </TR>
  <TR>
    <TD><!--content-->
	    <TABLE cellSpacing="2" cellPadding="2" width="100%" >
    	 <TBODY>
           <TR>
             <TD colspan="2"> 
           <!--options-->
             <IMG height=11 src="images/001.gif" width=8 ><A class=la href="addbidpack.php"> Adicionar um Pacote. </A> 
           <!--/options-->
        	 </TD>
          </TR>
	    </TBODY>
	   </TABLE>
	   <br>
	<FORM id="form1" name="form1" action="managebidpack.php" method="post">
      <TABLE cellSpacing="0" cellPadding="1">
        <TBODY>
        <TR>
          <TD><a class="la" href="managebidpack.php">Todos</a></TD>
          <TD class="lg">|</TD>
          <TD><a class="la" href="managebidpack.php?order=A">A</a></TD>
          <TD class="lg">|</TD>
          <TD><a class="la" href="managebidpack.php?order=B">B</a></TD>
          <TD class="lg">|</TD>
          <TD><a class="la" href="managebidpack.php?order=C">C</a></TD>
          <TD class="lg">|</TD>
          <TD><a class="la" href="managebidpack.php?order=D">D</a></TD>
          <TD class="lg">|</TD>
          <TD><a class="la" href="managebidpack.php?order=E">E</a></TD>
          <TD class="lg">|</TD>
          <TD><A class="la" href="managebidpack.php?order=F">F</A></TD>
          <TD class="lg">|</TD>
          <TD><A class="la" href="managebidpack.php?order=G">G</A></TD>
          <TD class="lg">|</TD>
          <TD><A class="la" href="managebidpack.php?order=H">H</A></TD>
          <TD class="lg">|</TD>
          <TD><A class="la" href="managebidpack.php?order=I">I</A></TD>
          <TD class="lg">|</TD>
          <TD><A class="la" href="managebidpack.php?order=J">J</A></TD>
          <TD class="lg">|</TD>
          <TD><A class="la" href="managebidpack.php?order=K">K</A></TD>
          <TD class="lg">|</TD>
          <TD><A class="la" href="managebidpack.php?order=L">L</A></TD>
          <TD class="lg">|</TD>
          <TD><A class="la" href="managebidpack.php?order=M">M</A></TD>
          <TD class="lg">|</TD>
          <TD><A class="la" href="managebidpack.php?order=N">N</A></TD>
          <TD class="lg">|</TD>
          <TD><A class="la" href="managebidpack.php?order=O">O</A></TD>
          <TD class="lg">|</TD>
          <TD><A class="la" href="managebidpack.php?order=P">P</A></TD>
          <TD class="lg">|</TD>
          <TD><A class="la" href="managebidpack.php?order=Q">Q</A></TD>
          <TD class="lg">|</TD>
          <TD><A class="la" href="managebidpack.php?order=R">R</A></TD>
          <TD class="lg">|</TD>
          <TD><A class="la" href="managebidpack.php?order=S">S</A></TD>
          <TD class="lg">|</TD>
          <TD><A class="la" href="managebidpack.php?order=T">T</A></TD>
          <TD class="lg">|</TD>
          <TD><A class="la" href="managebidpack.php?order=U">U</A></TD>
          <TD class="lg">|</TD>
          <TD><A class="la" href="managebidpack.php?order=V">V</A></TD>
          <TD class="lg">|</TD>
          <TD><A class="la" href="managebidpack.php?order=W">W</A></TD>
          <TD class="lg">|</TD>
          <TD><A class="la" href="managebidpack.php?order=X">X</A></TD>
          <TD class="lg">|</TD>
          <TD><A class="la" href="managebidpack.php?order=Y">Y</A></TD>
          <TD class="lg">|</TD>
          <TD><A class="la" href="managebidpack.php?order=Z">Z</A></TD>
		  </TR></TBODY></TABLE>
		</form>
<?
	if($total<=0)
	{
?>
	<table width="70%" border="0" cellspacing="1" cellpadding="1" align="center" bgcolor="#000000">
      <tr> 
        <td> 
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
           <tr> 
             <td class=th-a> 
              <div align="center">Sem dados para exibir</div>
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
		<form id="form2" name="form2" action="" method="post">  
          <table width="100%"  cellSpacing="0" class="t-a" border="1">
           <tbody>
		    <TR class="th-a"> 
			  <td width="6%">No</td>
			  <td width="22">Imagem</td>
  			  <td width="22%">Nome do pacote</td>
			  <td width="10%">Quantidade</td>
			  <td width="11%">Pre&ccedil;o</td>
			  <td width="15%">Pre&ccedil;o do Pacote</td>
			  <td width="16%" align="center">A&ccedil;&atilde;o</td>
		    </TR>
			<?
			  for($i=0;$i<$total;$i++)
			  {
				$row = mysql_fetch_object($result);
				$id=$row->id;
				$banner=$row->bidpack_banner;
				$bidname=stripslashes($row->bidpack_name);
				$bidsize=$row->bid_size;
				$bidprice=$row->bid_price;
				$bidpackprice=$row->bidpack_price;
				$banner = $row->bidpack_banner;
				
				$cellColor = "";
				$cellColor = ConfigcellColor($i);
				?>
		  	<tr class="<?=$cellColor?>">
			  <td align="center">
				<? if($i!=""){ echo $i+1; }else{echo "1";} ?></td>	
			  <td align="center"><?=$banner!=""?'<img src="../uploads/bidpack/'.$banner.'" />':"&nbsp;";?></td>
			  <td align="center"><?=$bidname;?></td>
			  <td align="center"><?=$bidsize;?></td>
			  <td align="center"><?=$Currency.$bidprice;?></td>
			  <td align="center"><?=$Currency.$bidpackprice;?></td>
			  <td align="center">
			<input class="bttn-s" onClick="window.location.href='addbidpack.php?bidpack_edit=<?=$id;?>'" type="button" value="Editar">			            <input name="button" type="button" class="bttn-s" value="Excluir" onClick="window.location.href='addbidpack.php?bidpack_delete=<?=$id;?>'"></td>
			</tr>
			 <?
			 }
			 ?>
			</tbody>
		</table>
	</form>
</td>
</tr>
</table>
<?
}
?>
	  <?php
		if($PageNo>1)
		{
                  $PrevPageNo = $PageNo-1;

	    ?>
	  <A class="paging" href="managebidpack.php?order=<? echo $iid ?>&pgno=<?php echo $PrevPageNo; ?>">&lt; P&aacute;gina Anterior</A>
	  <?
	   }
	  ?> &nbsp;&nbsp;&nbsp;
	  <?php
        if($PageNo<$totalpages)
        {
         $NextPageNo = 	$PageNo + 1;
      ?>
	  <A class="paging" href="managebidpack.php?order=<? echo $iid ?>&pgno=<?php echo $NextPageNo;?>">Pr&oacute;xima P&aacute;gina &gt;</A>
	  <?
       }
      ?>
</TD>
</TR>
  <TR>
    <TD><!--DWLayoutEmptyCell-->&nbsp;</TD>
  </TR>
</table>
</body>
</html>
