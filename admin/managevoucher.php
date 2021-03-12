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
	$query = "select * from vouchers where voucher_title like '$order%' order by id";
}
else
{
	$query = "select * from vouchers order by id";
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
  <TR> 
    <TD class="H1">Adminstrar B&ocirc;nus</TD>
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
             <IMG height=11 src="images/001.gif" width=8 ><A class=la href="addvoucher.php"> Adicionar B&ocirc;nus. </A> 
           <!--/options-->
        	 </TD>
          </TR>
	    </TBODY>
	   </TABLE>
	 </TD>
  </TR>
<Tr>
<td>
	<FORM id="form1" name="form1" action="managevoucher.php" method="post">
      <TABLE cellSpacing="0" cellPadding="1">
        <TBODY>
        <TR>
          <TD><a class="la" href="managevoucher.php">Todos</a></TD>
          <TD class="lg">|</TD>
          <TD><a class="la" href="managevoucher.php?order=A">A</a></TD>
          <TD class="lg">|</TD>
          <TD><a class="la" href="managevoucher.php?order=B">B</a></TD>
          <TD class="lg">|</TD>
          <TD><a class="la" href="managevoucher.php?order=C">C</a></TD>
          <TD class="lg">|</TD>
          <TD><a class="la" href="managevoucher.php?order=D">D</a></TD>
          <TD class="lg">|</TD>
          <TD><a class="la" href="managevoucher.php?order=E">E</a></TD>
          <TD class="lg">|</TD>
          <TD><A class="la" href="managevoucher.php?order=F">F</A></TD>
          <TD class="lg">|</TD>
          <TD><A class="la" href="managevoucher.php?order=G">G</A></TD>
          <TD class="lg">|</TD>
          <TD><A class="la" href="managevoucher.php?order=H">H</A></TD>
          <TD class="lg">|</TD>
          <TD><A class="la" href="managevoucher.php?order=I">I</A></TD>
          <TD class="lg">|</TD>
          <TD><A class="la" href="managevoucher.php?order=J">J</A></TD>
          <TD class="lg">|</TD>
          <TD><A class="la" href="managevoucher.php?order=K">K</A></TD>
          <TD class="lg">|</TD>
          <TD><A class="la" href="managevoucher.php?order=L">L</A></TD>
          <TD class="lg">|</TD>
          <TD><A class="la" href="managevoucher.php?order=M">M</A></TD>
          <TD class="lg">|</TD>
          <TD><A class="la" href="managevoucher.php?order=N">N</A></TD>
          <TD class="lg">|</TD>
          <TD><A class="la" href="managevoucher.php?order=O">O</A></TD>
          <TD class="lg">|</TD>
          <TD><A class="la" href="managevoucher.php?order=P">P</A></TD>
          <TD class="lg">|</TD>
          <TD><A class="la" href="managevoucher.php?order=Q">Q</A></TD>
          <TD class="lg">|</TD>
          <TD><A class="la" href="managevoucher.php?order=R">R</A></TD>
          <TD class="lg">|</TD>
          <TD><A class="la" href="managevoucher.php?order=S">S</A></TD>
          <TD class="lg">|</TD>
          <TD><A class="la" href="managevoucher.php?order=T">T</A></TD>
          <TD class="lg">|</TD>
          <TD><A class="la" href="managevoucher.php?order=U">U</A></TD>
          <TD class="lg">|</TD>
          <TD><A class="la" href="managevoucher.php?order=V">V</A></TD>
          <TD class="lg">|</TD>
          <TD><A class="la" href="managevoucher.php?order=W">W</A></TD>
          <TD class="lg">|</TD>
          <TD><A class="la" href="managevoucher.php?order=X">X</A></TD>
          <TD class="lg">|</TD>
          <TD><A class="la" href="managevoucher.php?order=Y">Y</A></TD>
          <TD class="lg">|</TD>
          <TD><A class="la" href="managevoucher.php?order=Z">Z</A></TD>
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
              <div align="center">Sem Informa&ccedil;&otilde;es Para Exibir</div>
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
			  <td width="50">Titulo</td>
			  <td width="10%" align="center">Tipo</td>
			  <td width="10%" align="center">Valor</td>
			  <td width="10%" align="center">Validade</td>
			  <td width="10%" align="center">Combinavel</td>
			  <td width="16%" align="center">Ac&atilde;o</td>
			</TR>
<?
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
				$id=$row->id;
				$title=stripslashes($row->voucher_title);
			  	 if($row->voucher_type==2) { $amount=$Currency.$row->bids_amount; }
				 if($row->voucher_type==1) { $amount = $row->bids_amount; }
				$combinable1=$row->combinable;
					if($combinable1==1) { $combinable = "Sim"; }
					if($combinable1==0) { $combinable = "N&atilde;o"; }
				if($row->voucher_type==2) { $voutype = "B&ocirc;nus em Dinheiro"; }
				if($row->voucher_type==1) { $voutype = "B&ocirc;nus Lance Livre"; }
				$cellColor = "";
				$cellColor = ConfigcellColor($i);
				?>
		  	<tr class="<?=$cellColor?>">
			  <td align="center">
				<?=$srno;?></td>	
			  <td><?=$title?></td>
			  <td align="center"><?=$voutype;?></td>
			  <td align="right"><?=$amount;?></td>
			  <td align="right"><?=$row->validity>0?$row->validity."&nbsp;days":"--";?></td>
			  <td align="right"><?=$combinable;?></td>
			  <td align="center">
			<input class="bttn-s" onClick="window.location.href='addvoucher.php?voucher_edit=<?=$id;?>'" type="button" value="Editar">			            <input name="button" type="button" class="bttn-s" value="Excluir" onClick="window.location.href='addvoucher.php?voucher_delete=<?=$id;?>'"></td>
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
	  <A class="paging" href="managevoucher.php?order=<? echo $iid ?>&pgno=<?php echo $PrevPageNo; ?>">&lt; P&aacute;gina Anterior</A>
	  <?
	   }
	  ?> &nbsp;&nbsp;&nbsp;
	  <?php
        if($PageNo<$totalpages)
        {
         $NextPageNo = 	$PageNo + 1;
      ?>
	  <A class="paging" href="managevoucher.php?order=<? echo $iid ?>&pgno=<?php echo $NextPageNo;?>">Pr&amp;oacute;xima P&amp;aacute;gina &gt;</A>
	  <?
       }
      ?>
</table>
</body>
</html>
