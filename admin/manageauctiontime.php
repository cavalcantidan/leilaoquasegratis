<?
	include("connect.php");
	include_once("admin.config.inc.php");
	include("security.php");
	include("config_setting.php");

	$PRODUCTSPERPAGE = 10; 

	$PageNo = 1;
	if($_GET['pgno']) $PageNo = $_GET['pgno'];

/********************************************************************
     Get how many products  are to be displayed according to the  Events
********************************************************************/
	$StartRow =   $PRODUCTSPERPAGE * ($PageNo-1);
/***********************************************/
	$query = "select * from auction_management order by id";

	$result=mysql_query($query) or die (mysql_error());
	$totalrows=mysql_num_rows($result);

    if($totalrows==0){
        mysql_query("Insert into auction_management (id) values (1),(2),(3),(4),(5)");
        $result=mysql_query($query);
    }

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
    <TD class="H1">Configura&ccedil;&otilde;es de Leil&otilde;es</TD>
  </TR>
  <TR>
    <TD background="images/vdots.gif"><IMG height=1 src="images/spacer.gif" width=1 ></TD>  </TR>
  <TR>
    <TD><!--content-->
	 </TD>
  </TR>
<Tr>
<td>
      <TABLE cellSpacing="0" cellPadding="1">
        <TBODY>
			<TR>
				<td class="H2">Administrar dura&ccedil;&atilde;o</td>
			</TR>
			<TR>
				<td>&nbsp;</td>
			</TR>
		</TBODY>
	</TABLE>
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
          <table width="100%"  cellSpacing="0" class="t-a" border="1">
           <tbody>
		    <TR class="th-a"> 
			  <td width="6%">No</td>
			  <td width="40%">Tipo</td>
			  <td width="10%">Pre&ccedil;o extra</td>
			  <td width="10%">Tempo Extra</td>
			  <td width="10%">A&atilde;o</td>
			</TR>
<?
			  for($i=0;$i<$total;$i++)
			  {
?>
	<form name="f<?=$i?>" action="changeauctiontime.php" method="post">
<?
				$row = mysql_fetch_object($result);
				$id=$row->id;
				$aname=$row->auc_title;
				$price=$row->auc_plus_price;
				$time=$row->auc_plus_time;
					
				$cellColor = "";
				$cellColor = ConfigcellColor($i);
				?>
		  	<tr class="<?=$cellColor?>" height="30px;">
			  <td align="center">
				<? if($i!=""){ echo $i+1; }else{echo "1";} ?></td>	
			  <? if($id==1) { ?>
			  <td><?=$aname?></td>
			  <?
			  	} else {
			  ?>
			  <td><input type="text" value="<?=$aname?>" name="auctitle" /></td>
			  <?
			  	}
			  ?>
			  <td><?=$Currency;?>&nbsp;<input type="text" value="<?=$price?>" name="aucplusprice" size="5" /></td>
			  <td><input type="text" value="<?=$time?>" name="aucplustime" size="5" /></td>
			  <td align="center">
			<input type="hidden" name="editid" value="<?=$id;?>" />
			<input class="bttn-s" type="submit" value="Editar" name="edit"></td>
			</tr>
	</form>
				 <?
			  }
				 ?>
		  </tbody>
		  </table>
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
	  <A class="paging" href="manageauctiontime.php?order=<? echo $iid ?>&pgno=<?php echo $PrevPageNo; ?>">&lt; P&aacute;gina Anterior</A>
	  <?
	   }
	  ?> &nbsp;&nbsp;&nbsp;
	  <?php
        if($PageNo<$totalpages)
        {
         $NextPageNo = 	$PageNo + 1;
      ?>
	  <A class="paging" href="manageauctiontime.php?order=<? echo $iid ?>&pgno=<?php echo $NextPageNo;?>">Pr&amp;oacute;xima P&amp;aacute;gina &gt;</A>
	  <?
       }
      ?>
</table>
</body>
</html>
