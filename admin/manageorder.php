<?php
	include_once("admin.config.inc.php");
	include("connect.php");
	include("security.php");
	include("category_function.php");
	include("config_setting.php");
	
	
	if(isset($_REQUEST["submit"]))
	{
		$Oid1 = $_REQUEST["oidnew"];
		$Oquery1 = "Update order_total set order_status='2|2' where id='$Oid1'";
		mysql_query($Oquery1) or die(mysql_error());
		//header("location:manageorder.php");
		//exit;
	}
	if(isset($_REQUEST["submit1"]))
	{
		$Oid2 = $_REQUEST["oidnew"];
		$Oquery2 = "Update order_total set order_status='2|3' where id='$Oid2'";
		mysql_query($Oquery2) or die(mysql_error());
		//header("location:manageorder.php");
		//exit;
	}
/*	if(isset($_REQUEST["submit2"]))
	{
		$Oid3 = $_REQUEST["oidnew"];
		$Oquery3 = "Update orders set order_status='2|1' where id='$Oid3'";
		mysql_query($Oquery3) or die(mysql_error());
		//header("location:manageorder.php");
		//exit;
	}*/
	
	
	
	
	
	
	// Paging Inforamtion
$PRODUCTSPERPAGE = 10;
if(isset($_GET['order']))
{
	$order = $_GET['order'];
}
else
{
	$order = "";
}

if(!$_GET['pageno'])
{
	$Pageno = 1;
}
elseif(isset($_GET['pageno']))
{
	$Pageno = $_GET['pageno'];
	//$order = $_GET['order'];
	
}

	#echo $Pageno."    ".$PRODUCTSPERPAGE;
	$StartRow =   $PRODUCTSPERPAGE * ($Pageno-1);
	if(trim($order)!="")
	$query="select o.*,o.grandtotal as value,DATE_FORMAT(o.purchasedate,'%m/%d/%Y') as dpdate from order_total o left join order_products t on o.id=t.order_id where custmer_name like '$order%' and order_status='2|1' order by id desc";
	else
	$query = "select o.*,o.grandtotal as value,DATE_FORMAT(o.purchasedate,'%m/%d/%Y %h:%m:%s') as dpdate from order_total o left join order_products t on o.id=t.order_id where  order_status='2|1' order by o.id desc";
	
  $result=mysql_query($query);
  $totalrows= mysql_affected_rows();
  $totalpages = (int) ($totalrows / $PRODUCTSPERPAGE);
  if(($totalrows % $PRODUCTSPERPAGE)!=0)
    $totalpages++;
    $query .= " LIMIT $StartRow,$PRODUCTSPERPAGE";
    $result =mysql_query($query) or die("Query not Success");
    $total = mysql_affected_rows();
	if(!$total)
      $Error = 1;
	//End Pageing Inforamtion
	//echo $query;
	//exit;
?>



<html>
<head>

<meta http-equiv="Content-Type" content="text/html; charset=<?=$lng_characset;?>">
</head>

<link href="main.css" type="text/css" rel="stylesheet">
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
<body bgcolor="#ffffff" style="padding-left:10px">
	
	<TABLE cellSpacing=10 cellPadding=0  border=0 width="94%">
		<TR>
			<TD class=H1>Manage Order</TD>
		</TR>
		<TR>
			<TD background="images/vdots.gif"><IMG height=1 
			  src="images/spacer.gif" width=1 border=0></TD>
		</TR>
		<tr>	 
		<td>
		<TABLE cellSpacing=2 cellPadding=2 width="100%" border=0>
        <TBODY>
            
			  <tr>
	          <td><b>View By Custmer Name</b></td>
			  </tr>
			 
		  </TBODY>
		  </TABLE>
			  <FORM id="form1" name="form1" action="manageorder.php" method="post">
      <TABLE cellSpacing=0 cellPadding=1 border=0 >
        <TBODY>
        <TR>
          <TD><a class=la href="manageorder.php">All</a></TD>
          <TD class=lg>|</TD>
                
          <TD><a class=la href="manageorder.php?order=A">A</a></TD>
          <TD class=lg>|</TD>
          <TD><a class=la href="manageorder.php?order=B">B</a></TD>
          <TD class=lg>|</TD>
          <TD><a class=la href="manageorder.php?order=C">C</a></TD>
          <TD class=lg>|</TD>
          <TD><a class=la href="manageorder.php?order=D">D</a></TD>
          <TD class=lg>|</TD>
          <TD><a class=la href="manageorder.php?order=E">E</a></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="manageorder.php?order=F">F</A></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="manageorder.php?order=G">G</A></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="manageorder.php?order=H">H</A></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="manageorder.php?order=I">I</A></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="manageorder.php?order=J">J</A></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="manageorder.php?order=K">K</A></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="manageorder.php?order=L">L</A></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="manageorder.php?order=M">M</A></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="manageorder.php?order=N">N</A></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="manageorder.php?order=O">O</A></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="manageorder.php?order=P">P</A></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="manageorder.php?order=Q">Q</A></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="manageorder.php?order=R">R</A></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="manageorder.php?order=S">S</A></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="manageorder.php?order=T">T</A></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="manageorder.php?order=U">U</A></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="manageorder.php?order=V">V</A></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="manageorder.php?order=W">W</A></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="manageorder.php?order=X">X</A></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="manageorder.php?order=Y">Y</A></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="manageorder.php?order=Z">Z</A></TD></TR></TBODY></TABLE>
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
                  <div align="center">No Order To Display</div>
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
	<FORM id="form2" name="form2" action="" method="post">
	<table border="1" width="100%" class="t-a" cellspacing="0">
		<tbody>
		<TR class=th-a> 
          <TD width="17%" nowrap>Custmer Name</TD>
		  <TD width="11%" align="right" nowrap>Order Total</TD>
		  <TD width="22%" nowrap>Date Purchased</TD>
		  <TD width="12%" nowrap>Order Status</TD>
		  <TD width="12%">Options</TD>
		  <td width="26%">Delivered Status</td>
        </TR>
		<?php
		$colorflg=0;
    	for($i=0;$i<$total;$i++){
			$row = mysql_fetch_object($result);
			$id = $row->id;
			$Cname = stripslashes($row->custmer_name);
			$Value = "&pound;".stripslashes($row->value);
			$Date_purchased = $row->dpdate;
			$st = substr($row->order_status,2);
			if($st == 1) $Status = "Pending";
			elseif($st == 2)$Status ="Delivered";
			elseif($st == 3)$Status = "Cancel";
			if ($colorflg==1){
				$colorflg=0;?>
				<TR bgcolor="#f4f4f4"> 
			<? }else{
				$colorflg=1;?>
				<TR> 
			<? } ?>
					<TD noWrap align="left"><?=$Cname?></TD>
					<td align="right"><?=$Value?></td>
					<TD align="left"><?=$Date_purchased?></TD>
					<td align="left"><?=$Status?></td>
					<TD><input type="button" value="Detalhes" class="bttn-s" onClick="location.href='orderdetails.php?oid=<?=$id?>'"></TD>
					<form name="delivered" method="post" action="manageorder.php">
					<td><input type="submit" value="Delivered" class="bttn-s" name="submit">&nbsp;<input type="submit" value="Cancel" name="submit1" class="bttn-s">&nbsp;<input type="hidden" name="oidnew" value="<?=$id?>">
					</td>
					</form>
		    </TR>
           <?
		    }
		  ?>
		
	</table>
	<?php
		if($Pageno>1)
		{
                  $PrevPageNo = $Pageno-1;

	    ?>
	  <A class=paging href="manageorder.php?order=<? echo $order ?>&pageno=<?php echo $PrevPageNo; ?>">&lt; P&aacute;gina Anterior</A>
	  <?
	   }
	  ?> &nbsp;&nbsp;&nbsp;
	  <?php
        if($Pageno<$totalpages)
        {
         $NextPageNo = 	$Pageno + 1;
      ?>
	  <A class=paging 
      id=next href="manageorder.php?order=<? echo $order ?>&pageno=<?php echo $NextPageNo;?>">Pr&amp;oacute;xima P&amp;aacute;gina &gt;</A>
	  <?
       }
      ?>
	   &nbsp; 
         <!-- <A class=paging id=last 
      href="javascript:__doPostBack('last','')" disabled>Last Page &gt;</A>--> 
       </form>
		<?php

      }

      ?>
	  </td>
	</tr>
	</tbody>
</table>
	<br><br>
</body>
</html>
