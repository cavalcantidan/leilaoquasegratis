<?php

 include("admin.config.inc.php");
 include("connect.php");
 include("security.php");	
 
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
//$PRODUCTSPERPAGE = 2;
/********************************************************************
     Get how many products  are to be displayed according to the  Events
********************************************************************/

	$StartRow =   $PRODUCTSPERPAGE * ($PageNo-1);
/***********************************************
display search results
***********************************************/
 /*********************************************

  Display all  products

  *********************************************/
	if($order!="")
	{
		$query="select * from brands where brandname like '$order%' order by brandname";
	}
	else
	{
		$query="select * from brands order by brandname";
	}
	//$query="select t.*,s.stname as sttitle from taxclass t left join pdcastate s on t.title=s.id";
  $result=mysql_query($query,$db);
  $totalrows= mysql_affected_rows();
  $totalpages = (int) ($totalrows / $PRODUCTSPERPAGE);
  if(($totalrows % $PRODUCTSPERPAGE)!=0)
    $totalpages++;
    $query .= " LIMIT $StartRow,$PRODUCTSPERPAGE";
    $result=mysql_query($query,$db);
    $total = mysql_affected_rows();

	if(!$total)
      $Error = 1;

 ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<HTML><HEAD>
<META http-equiv=Content-Type content="text/html; charset=<?=$lng_characset;?>">
<META content="MSHTML 6.00.2600.0" name=GENERATOR>
<link rel="stylesheet" href="main.css" type="text/css">
<script language="JavaScript">
	
	function delconfirm(loc)
	{
		if(confirm("Are you Sure Do You Want To Delete"))
		{
			window.location.href=loc;
		}
		return false;
	}
	function movechild(loc)
	{
		window.location.href=loc;
	}
</script>
</HEAD>
<BODY bgColor=#ffffff style="padding-left:10px">


<TABLE width="78%"  border=0 cellPadding=0 cellSpacing=10>
  <!--DWLayoutTable-->
    <TR> 
      <TD width="100%" class=h1>Manage Brand</TD>
    </TR>
  <TR>
    <TD background="images/vdots.gif"><IMG height=1 
      src="images/spacer.gif" width=1 border=0></TD></TR>
  <TR>
    <TD><!--content-->

      <TABLE cellSpacing=2 cellPadding=2 width="100%" border=0>
        <TBODY>
            <TR>
              <TD align="left"> 
                <!--options-->
                <IMG height=11 src="images/001.gif" width=8 border=0><A class=la href="addbrand.php"> Add a new Brand</A><BR><BR> 
                <!--/options-->
              </TD>
          </TR>
			  <tr>
	          <td><b>View By Brandname</b></td>
			  </tr>
			 
	    </TBODY>
	  </TABLE>
			  <FORM id="form1" name="form1" action="managebrand.php" method="post">
      <TABLE cellSpacing=0 cellPadding=1 border=0 >
        <TBODY>
        <TR>
          <TD><a class=la href="managebrand.php">All</a></TD>
          <TD class=lg>|</TD>
                
          <TD><a class=la href="managebrand.php?order=A">A</a></TD>
          <TD class=lg>|</TD>
          <TD><a class=la href="managebrand.php?order=B">B</a></TD>
          <TD class=lg>|</TD>
          <TD><a class=la href="managebrand.php?order=C">C</a></TD>
          <TD class=lg>|</TD>
          <TD><a class=la href="managebrand.php?order=D">D</a></TD>
          <TD class=lg>|</TD>
          <TD><a class=la href="managebrand.php?order=E">E</a></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="managebrand.php?order=F">F</A></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="managebrand.php?order=G">G</A></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="managebrand.php?order=H">H</A></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="managebrand.php?order=I">I</A></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="managebrand.php?order=J">J</A></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="managebrand.php?order=K">K</A></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="managebrand.php?order=L">L</A></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="managebrand.php?order=M">M</A></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="managebrand.php?order=N">N</A></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="managebrand.php?order=O">O</A></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="managebrand.php?order=P">P</A></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="managebrand.php?order=Q">Q</A></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="managebrand.php?order=R">R</A></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="managebrand.php?order=S">S</A></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="managebrand.php?order=T">T</A></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="managebrand.php?order=U">U</A></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="managebrand.php?order=V">V</A></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="managebrand.php?order=W">W</A></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="managebrand.php?order=X">X</A></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="managebrand.php?order=Y">Y</A></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="managebrand.php?order=Z">Z</A></TD></TR></TBODY></TABLE>
			</form>
			 <?php
        if(!$total)

        {
        ?>
		<table width="70%" border="0" cellspacing="1" cellpadding="1" align="center" bgcolor="#000000">
        <tr> 
          <td > 
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr> 
                <td class=th-a > 
                  <div align="center">No Brand To Display</div>
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
          
          <TABLE width="100%" border=1 cellSpacing=0 class=t-a>
            <!--DWLayoutTable-->
            <TBODY>
              <TR class=th-a> 
				<td width="67%">Brand Name</td>
				<TD width="33%" >Options</TD>
              </TR>
              <?php
			  $colorflg=0;
			  for($i=0;$i<$total;$i++)
			  {
				$row = mysql_fetch_object($result);
				$brandname = stripslashes($row->brandname);
				$id = $row->id;
				if ($colorflg==1){
					$colorflg=0;
					echo "<TR bgcolor=\"#f4f4f4\"> ";
				}else{
					$colorflg=1;
				  	echo "<TR> ";
				}?>
			<TD noWrap align="left" valign="middle" height="37"><?=$brandname;?></TD>
			  <TD noWrap width="33%" >
			<INPUT class="bttn-s" onClick="window.location.href='addbrand.php?id=<?php echo $id;?>'" type="button" value="Editar"> 
            <input name="button" type="button" class="bttn-s" value="Excluir" onClick="return delconfirm('addbrand.php?delid=<?php echo $id;?>')">
              </TD>
              </TR>
              <?
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
	  <A class=paging href="managebrand.php?order=<? echo $order ?>&pgno=<?php echo $PrevPageNo; ?>">&lt; P&aacute;gina Anterior</A>
	  <?
	   }
	  ?> &nbsp;&nbsp;&nbsp;
	  <?php
        if($PageNo<$totalpages)
        {
         $NextPageNo = 	$PageNo + 1;
      ?>
	  <A class=paging 
      id=next href="managebrand.php?order=<? echo $order ?>&pgno=<?php echo $NextPageNo;?>">Pr&amp;oacute;xima P&amp;aacute;gina &gt;</A>
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
<!--/content--></TD></TR></TBODY></TABLE><br><br><br></BODY></HTML>