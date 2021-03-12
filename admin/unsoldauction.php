<?
	include("connect.php");
	include_once("admin.config.inc.php");
	include("security.php");
	include("config_setting.php");
	$type1 = "1";
	$type3 = "3";
	include("pagepermission.php");

$PRODUCTSPERPAGE = 15; 
if(!$_GET['order'])
$order = "";
else
$order = $_GET['order'];
if($_REQUEST['aucstatus'])
{
	$aucstatus = $_REQUEST['aucstatus'];
}
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
$query = "select *,p.name as productname,date_format(w.won_date,'%d/%m/%Y') as wondate from won_auctions w left join auction a on w.auction_id=a.auctionID left join products p on a.productID=p.productID left join registration r on r.id=w.userid 
          where a.auc_status='3' and a.buy_user='0' and p.name like '$order%' order by w.won_date desc";

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
<script type="text/javascript" language="javascript">
function Submitform()
{
	document.form3.submit();
}
</script>
</head>

<body bgcolor="#ffffff" style="padding-left:10px">
<table width="100%" cellPadding="0" cellSpacing="10">
  <!--DWLayoutTable-->
  <TR> 
    <TD class="H1">Administra&ccedil;&atilde;o de Leil&otilde;es N&atilde;o Vendidos</TD>
  </TR>
  <TR>
    <TD background="images/vdots.gif"><IMG height=1 src="images/spacer.gif" width=1 ></TD>  </TR>
  <TR>
    <TD><!--content-->
	    <TABLE cellSpacing="2" cellPadding="2" width="100%" >
    	 <TBODY>
		  <tr>
            <td class="tdTextBold"><B>Visualizar produtos por:</B></td>
		  </tr>
	    </TBODY>
	   </TABLE>
	   <br>
	<FORM id="form1" name="form1" action="unsoldauction.php" method="post">
      <TABLE cellSpacing="0" cellPadding="1">
        <TBODY>
        <TR>
          <TD><a class="la" href="unsoldauction.php">Todos</a></TD>
          <TD class="lg">|</TD>
          <TD><a class="la" href="unsoldauction.php?order=A">A</a></TD>
          <TD class="lg">|</TD>
          <TD><a class="la" href="unsoldauction.php?order=B">B</a></TD>
          <TD class="lg">|</TD>
          <TD><a class="la" href="unsoldauction.php?order=C">C</a></TD>
          <TD class="lg">|</TD>
          <TD><a class="la" href="unsoldauction.php?order=D">D</a></TD>
          <TD class="lg">|</TD>
          <TD><a class="la" href="unsoldauction.php?order=E">E</a></TD>
          <TD class="lg">|</TD>
          <TD><A class="la" href="unsoldauction.php?order=F">F</A></TD>
          <TD class="lg">|</TD>
          <TD><A class="la" href="unsoldauction.php?order=G">G</A></TD>
          <TD class="lg">|</TD>
          <TD><A class="la" href="unsoldauction.php?order=H">H</A></TD>
          <TD class="lg">|</TD>
          <TD><A class="la" href="unsoldauction.php?order=I">I</A></TD>
          <TD class="lg">|</TD>
          <TD><A class="la" href="unsoldauction.php?order=J">J</A></TD>
          <TD class="lg">|</TD>
          <TD><A class="la" href="unsoldauction.php?order=K">K</A></TD>
          <TD class="lg">|</TD>
          <TD><A class="la" href="unsoldauction.php?order=L">L</A></TD>
          <TD class="lg">|</TD>
          <TD><A class="la" href="unsoldauction.php?order=M">M</A></TD>
          <TD class="lg">|</TD>
          <TD><A class="la" href="unsoldauction.php?order=N">N</A></TD>
          <TD class="lg">|</TD>
          <TD><A class="la" href="unsoldauction.php?order=O">O</A></TD>
          <TD class="lg">|</TD>
          <TD><A class="la" href="unsoldauction.php?order=P">P</A></TD>
          <TD class="lg">|</TD>
          <TD><A class="la" href="unsoldauction.php?order=Q">Q</A></TD>
          <TD class="lg">|</TD>
          <TD><A class="la" href="unsoldauction.php?order=R">R</A></TD>
          <TD class="lg">|</TD>
          <TD><A class="la" href="unsoldauction.php?order=S">S</A></TD>
          <TD class="lg">|</TD>
          <TD><A class="la" href="unsoldauction.php?order=T">T</A></TD>
          <TD class="lg">|</TD>
          <TD><A class="la" href="unsoldauction.php?order=U">U</A></TD>
          <TD class="lg">|</TD>
          <TD><A class="la" href="unsoldauction.php?order=V">V</A></TD>
          <TD class="lg">|</TD>
          <TD><A class="la" href="unsoldauction.php?order=W">W</A></TD>
          <TD class="lg">|</TD>
          <TD><A class="la" href="unsoldauction.php?order=X">X</A></TD>
          <TD class="lg">|</TD>
          <TD><A class="la" href="unsoldauction.php?order=Y">Y</A></TD>
          <TD class="lg">|</TD>
          <TD><A class="la" href="unsoldauction.php?order=Z">Z</A></TD>
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
			  <td width="6%">Leil&atilde;o ID</td>
  			  <td width="22%">Nome</td>
			  <td align="center" width="10%">Pre&ccedil;o</td>
			  <td align="center" width="11%">Status</td>
			  <TD align="center" width="19%">Vencido</TD>
			  <td align="center" width="11%">O&ccedil;&otilde;es</td>
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
				$id=$row->auctionID;
				$pname=$row->productname;
				$fprice=$row->auc_final_price;
				$status=$row->accept_denied;
				$paymentdate = $row->payment_date;
				$won_date = $row->wondate;
				$accept_date = $row->accept_date;
				$auctype = $row->auc_type;
					if($auctype=="fpa"){$auctype="Fixed Price Auction";}
					if($auctype=="pa"){$auctype="Cent Auction";}
					if($auctype=="nba"){$auctype="NailBiter Auction ";}
					if($auctype=="off"){$auctype="100% off";}
					if($auctype=="na"){$auctype="Night Auction";}
					if($auctype=="oa"){$auctype="Open Auction";}
					if($auctype=="20sa"){$auctype="20-Second Auction";}
					if($auctype=="15sa"){$auctype="15-Second Auction";}
					if($auctype=="10sa"){$auctype="10-Second Auction";}
				$winner = $row->username;
				$userid = $row->userid;
				$cellColor = "";
				$cellColor = ConfigcellColor($i);
				?>
		  	<tr class="<?=$cellColor?>">
			  <td align="center">
				<?=$srno;?></td>	
			  <td align="center"><?=$id?></td>
			  <td><?=stripslashes($pname)?></td>
			  <td align="right"><?=$fprice==""?"&nbsp":$Currency.$fprice;?></td>
			  <td align="center"><?
			   echo "<font color=blue>N&atilde;o Vendido</font>";
			  	
			  ?>
			  </td>
			  <TD align="center" width="19%"><?
			  echo $won_date=="0000-00-00 00:00:00"?"&nbsp;":$won_date;
			  ?></TD>
			  <td align="center"><input class="bttn-s" type="button" name="resetauction" value="Reiniciar" onclick="window.location.href='addauction.php?auction_edit=<?=$id?>'" /></td>
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
	  <A class="paging" href="unsoldauction.php?order=<? echo $iid ?>&pgno=<?php echo $PrevPageNo; ?>">&lt; P&aacute;gina Anterior</A>
	  <?
	   }
	  ?> &nbsp;&nbsp;&nbsp;
	  <?php
        if($PageNo<$totalpages)
        {
         $NextPageNo = 	$PageNo + 1;
      ?>
	  <A class="paging" href="unsoldauction.php?order=<? echo $iid ?>&pgno=<?php echo $NextPageNo;?>">Pr&amp;oacute;xima P&amp;aacute;gina &gt;</A>
	  <?
       }
      ?>
</TD>
</TR>
</table>
</body>
</html>
