<?
	include("connect.php");
	include_once("admin.config.inc.php");
	include("security.php");
	include("config_setting.php");
	$type1 = "1";
	$type3 = "3";
	include("pagepermission.php");

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
	$query = "select *,p.name from auction a left join products p on a.productID=p.productID left join registration r on r.id=a.buy_user where p.name like '$order%' and featured_flag='1' order by p.name";
}
else
{
	$query = "select *,p.name from auction a left join products p on a.productID=p.productID left join registration r on r.id=a.buy_user where featured_flag='1' order by p.name";
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
    <TD class="H1">Manage Featured Auctions</TD>
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
             <IMG height=11 src="images/001.gif" width=8 ><A class=la href="addfeatureauction.php"> Add a new feature auction. </A> 
           <!--/options-->
        	 </TD>
          </TR>
		  <tr>
		  	<td colspan="2">&nbsp;</td>
		  </tr>
		  <tr>
            <td class="tdTextBold"><B>View By Main Product</B></td>
		  </tr>
	    </TBODY>
	   </TABLE>
	   <br>
	<FORM id="form1" name="form1" action="managefeatureauction.php" method="post">
      <TABLE cellSpacing="0" cellPadding="1">
        <TBODY>
        <TR>
          <TD><a class="la" href="managefeatureauction.php">All</a></TD>
          <TD class="lg">|</TD>
          <TD><a class="la" href="managefeatureauction.php?order=A">A</a></TD>
          <TD class="lg">|</TD>
          <TD><a class="la" href="managefeatureauction.php?order=B">B</a></TD>
          <TD class="lg">|</TD>
          <TD><a class="la" href="managefeatureauction.php?order=C">C</a></TD>
          <TD class="lg">|</TD>
          <TD><a class="la" href="managefeatureauction.php?order=D">D</a></TD>
          <TD class="lg">|</TD>
          <TD><a class="la" href="managefeatureauction.php?order=E">E</a></TD>
          <TD class="lg">|</TD>
          <TD><A class="la" href="managefeatureauction.php?order=F">F</A></TD>
          <TD class="lg">|</TD>
          <TD><A class="la" href="managefeatureauction.php?order=G">G</A></TD>
          <TD class="lg">|</TD>
          <TD><A class="la" href="managefeatureauction.php?order=H">H</A></TD>
          <TD class="lg">|</TD>
          <TD><A class="la" href="managefeatureauction.php?order=I">I</A></TD>
          <TD class="lg">|</TD>
          <TD><A class="la" href="managefeatureauction.php?order=J">J</A></TD>
          <TD class="lg">|</TD>
          <TD><A class="la" href="managefeatureauction.php?order=K">K</A></TD>
          <TD class="lg">|</TD>
          <TD><A class="la" href="managefeatureauction.php?order=L">L</A></TD>
          <TD class="lg">|</TD>
          <TD><A class="la" href="managefeatureauction.php?order=M">M</A></TD>
          <TD class="lg">|</TD>
          <TD><A class="la" href="managefeatureauction.php?order=N">N</A></TD>
          <TD class="lg">|</TD>
          <TD><A class="la" href="managefeatureauction.php?order=O">O</A></TD>
          <TD class="lg">|</TD>
          <TD><A class="la" href="managefeatureauction.php?order=P">P</A></TD>
          <TD class="lg">|</TD>
          <TD><A class="la" href="managefeatureauction.php?order=Q">Q</A></TD>
          <TD class="lg">|</TD>
          <TD><A class="la" href="managefeatureauction.php?order=R">R</A></TD>
          <TD class="lg">|</TD>
          <TD><A class="la" href="managefeatureauction.php?order=S">S</A></TD>
          <TD class="lg">|</TD>
          <TD><A class="la" href="managefeatureauction.php?order=T">T</A></TD>
          <TD class="lg">|</TD>
          <TD><A class="la" href="managefeatureauction.php?order=U">U</A></TD>
          <TD class="lg">|</TD>
          <TD><A class="la" href="managefeatureauction.php?order=V">V</A></TD>
          <TD class="lg">|</TD>
          <TD><A class="la" href="managefeatureauction.php?order=W">W</A></TD>
          <TD class="lg">|</TD>
          <TD><A class="la" href="managefeatureauction.php?order=X">X</A></TD>
          <TD class="lg">|</TD>
          <TD><A class="la" href="managefeatureauction.php?order=Y">Y</A></TD>
          <TD class="lg">|</TD>
          <TD><A class="la" href="managefeatureauction.php?order=Z">Z</A></TD>
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
              <div align="center">No Featured Auctions To Display</div>
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
			  <td width="6%">No</td>
  			  <td width="22%">Product Name</td>
			  <td width="15%">Auction Final Price</td>
			  <td width="5%">Status</td>
			  <td width="15%">Auction Type</td>
			  <!--<TD  width="10%">InStock</TD>-->
			  <td width="11%">Winner</td>
			  <td width="20%" align="center">Action</td>
		    </TR>
			<?
			  for($i=0;$i<$total;$i++)
			  {
				$row = mysql_fetch_object($result);
				$id=$row->auctionID;
				$pname=$row->name;
				$fprice=$row->auc_final_price;
				$status=$row->auc_status;
				$auctype = $row->auc_type;
					if($row->fixedpriceauction=="1"){$auctype="Fixed Price Auction";}
					if($row->pennyauction=="1"){$auctype="Cent Auction";}
					if($row->nailbiterauction=="1"){$auctype="NailBiter Auction ";}
					if($row->offauction=="1"){$auctype="100% off";}
					if($row->nightauction=="1"){$auctype="Night Auction";}
					if($row->openauction=="1"){$auctype="Open Auction";}
					if($row->time_duration=="20sa"){$auctype="20-Second Auction";}
					if($row->time_duration=="15sa"){$auctype="15-Second Auction";}
					if($row->time_duration=="10sa"){$auctype="10-Second Auction";}
				$winner = $row->username;
				$cellColor = "";
				$cellColor = ConfigcellColor($i);
				?>
		  	<tr class="<?=$cellColor?>">
			  <td align="center">
				<? if($i!=""){ echo $i+1; }else{echo "1";} ?></td>	
			  <td align="center"><?=$id?></td>
			  <td align="center"><?=$pname?></td>
			  <td align="right"><?=$fprice==""?"&nbsp":$Currency.$fprice;?></td>
			  <td align="center">
			  <?	
			  	if($status==1){ echo "<font color=green>Future</font>";}
			  	if($status==2){ echo "<font color=red>Active</font>";}
			  	if($status==3){ echo "<font color=blue>Sold</font>";}
				if($status==4){ echo "<font color=green>Pending</font>";}
			  ?>
			  </td>
			  <td nowrap="nowrap" align="center"><?=$auctype==""?"&nbsp":$auctype;?></td>
			  <td align="center"><?=$winner==""?"&nbsp":$winner;?></td>
			  <td align="left">
			<input class="bttn-s" onClick="window.location.href='addfeatureauction.php?auction_edit=<?=$id;?>'" type="button" value="Editar">			            <input name="button" type="button" class="bttn-s" value="Excluir" onClick="window.location.href='addfeatureauction.php?auction_delete=<?=$id;?>'">
			<? if($status==3){ ?>
            <input name="button" type="button" class="bttn-s" value="Clone" onClick="window.location.href='addfeatureauction.php?auction_clone=<?=$id;?>'">
			<? } ?>
			</td>
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
	  <A class="paging" href="manageauction.php?order=<? echo $iid ?>&pgno=<?php echo $PrevPageNo; ?>">&lt; P&aacute;gina Anterior</A>
	  <?
	   }
	  ?> &nbsp;&nbsp;&nbsp;
	  <?php
        if($PageNo<$totalpages)
        {
         $NextPageNo = 	$PageNo + 1;
      ?>
	  <A class="paging" href="manageauction.php?order=<? echo $iid ?>&pgno=<?php echo $NextPageNo;?>">Pr&amp;oacute;xima P&amp;aacute;gina &gt;</A>
	  <?
       }
      ?>
</TD>
</TR>
</table>
</body>
</html>
