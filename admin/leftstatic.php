﻿<?php  
    include_once("admin.config.inc.php"); 
	include("config.inc.php");
	include("security.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML><HEAD>
<META http-equiv=Content-Type content="text/html; charset=<?=$lng_characset;?>">
<LINK href="main.css" type=text/css rel=stylesheet>
<LINK href="menu.css" type=text/css rel=stylesheet>
<SCRIPT language=javascript src="main.js" type=text/javascript>
</SCRIPT>
<SCRIPT language=javascript src="menu.js" type=text/javascript>
</SCRIPT>
</HEAD>
<BODY bgColor=#eeeeee leftmargin="5">
<TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
  <TBODY>
  <tr><td height="5"></td></tr>
  <TR>
    <TD vAlign=top>
      <DIV id=mnpMenuTop>
      <DIV class=mnpInherit><!--menu-->
	  <?php
	  ///////////////////////
	  //incldue here links.txt.php
	  ////////////////
  include("static.txt.php");

  $MainLinksSize = sizeof($MainLinksArray);

  for($i=0;$i<$MainLinksSize;$i++)
  {
    //$LayerId= $i+2;
    $LinkTitle = $MainLinksArray[$i][0];
    $HREF = $MainLinksArray[$i][1];
    $HasChild = $MainLinksArray[$i][2];
    if($HasChild==1)
    { 
	?>      
	 <DIV class="MenuHead" nowrap><font class="MenuHead"> 
              <strong><?php echo $LinkTitle; ?></strong></font>
             </DIV>
	  <?php
      $ChildLinksSize = sizeof($ChildLinksArray);
      
      for($j=0;$j<$ChildLinksSize;$j++)
      {
        $MainLinkID= $ChildLinksArray[$j][2];
        if($MainLinkID == $i)
        {
        	$ChildLinkTitle = $ChildLinksArray[$j][0];
        	$ChildHREF = $ChildLinksArray[$j][1];
		?>
		    <DIV class=mnpMenuRow  style="width: 188" align="left">&nbsp;<A class=menu_item 
		  href="<?php echo $ChildHREF ?>" target="body">
              <?php echo $ChildLinkTitle;?>
              </A></DIV>
            <?php
        }
      }
    }
    else
    {
	?>
            <DIV ><a HREF="<?php echo $HREF ?>" target="body" class="menuhead">
              <?php echo $LinkTitle ?>
              </a></DIV>
	 <?php
	}
  } 

	  ///////////////////////
	  //incldue here links.txt.php
	  ////////////////
  include("static.txt.php");

  $MLinksSize = sizeof($MLinksArray);

  for($k=0;$k<$MLinksSize;$k++)
  {
    //$LayerId= $i+2;
    $LTitle = $MLinksArray[$k][0];
    $LHREF = $MLinksArray[$k][1];
    $HChild = $MLinksArray[$k][2];
    if($HChild==1)
    { 
	?>      
	 <DIV class="MenuHead"><br><font class="MenuHead"> 
              <strong><?php echo $LTitle; ?></strong></font>
             </DIV>
	  <?php
      $ChLinksSize = sizeof($ChLinksArray);
      
      for($p=0;$p<$ChLinksSize;$p++)
      {
        $MLinkID= $ChLinksArray[$p][2];
        if($MLinkID == $k)
        {
        	$ChLinkTitle = $ChLinksArray[$p][0];
        	$ChHREF = $ChLinksArray[$p][1];
		?>
		    <DIV class=mnpMenuRow  style="width: 188"><br>&nbsp;<A class=menu_item 
		  href="<?php echo $ChHREF ?>" target="body">
              <?php echo $ChLinkTitle;?>
              </A></DIV>
            <?php
        }
      }
    }
    else
    {
	?>
            <DIV ><a HREF="<?php echo $LHREF ?>" target="body" class="menuhead">
              <?php echo $LTitle ?>
              </a></DIV>
	 <?php
	}
  }
 ?>
   <!--/menu--></DIV></DIV></TD></TR></TBODY></TABLE>
</BODY></HTML>