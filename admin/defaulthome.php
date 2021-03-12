<?php
//	session_start();
    include ("config.inc.php");
	include_once("admin.config.inc.php");
	include("security.php");
?>
<html>
  <head>
	<meta http-equiv="Content-Type" content="text/html; charset=<?=$lng_characset;?>">
	<link href="main.css" type="text/css" rel="stylesheet"/>
	<link href="demo.css" type="text/css" rel="stylesheet"/>
	<script language="javascript" src="body.js"></script>
  </head>
<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<script language="JavaScript" src="body.js" type="text/javascript">
framecheck('home')
function SearchContacts(){}
function SearchAccounts(){}
</script>
<table width="100%" border="0" cellspacing="10" cellpadding="0">
<tr><td class="H1">Bem Vindo <? echo $_SESSION["UsErOfAdMiN"];?></td></tr>
<tr><td background="images/vdots.gif"><img src="images/spacer.gif" width="1" height="1" border="0"></td></tr>
<tr><td>
 <table width="100%" border="0" cellspacing="10" cellpadding="0">
  <tr>
   <?php
	  include("headlinks.txt.php");
  		$MainLinksSize = sizeof($HeadLinksArray);
		
		  for($k=1;$k<$MainLinksSize;$k++){
			$LinkTitle = $HeadLinksArray[$k][0];
			$headHREF = $HeadLinksArray[$k][1];
   		 ?>
          <td valign="top" nowrap> 
            <!--c 001-->
            <table width="100%" border="0" cellspacing="5" cellpadding="0">
  			<tr>
    			<td width="12" nowrap="nowrap"><img src="images/basics.gif" width="11" height="22"></td>
     			<td class="H2" nowrap="nowrap"><?php echo $LinkTitle; ?></td>
  			</tr>
  			<tr> 
    			<td width="1">&nbsp;</td>
    			<td><?php
			  	if($HeadLinksArray[$k][2]==1){
					$havingorder=0;
					include($HeadLinksArray[$k][3]);
					$MainLinksSize1 = sizeof($MainLinksArray);
					?>
                  <table width="100%" border="0" cellspacing="0" cellpadding="3">
                    <?php
 					 for($i=0;$i<$MainLinksSize1;$i++){
						    $LinkTitle = $MainLinksArray[$i][0];
						    $HREF = $MainLinksArray[$i][1];
							$HasChild = $MainLinksArray[$i][2];
						    if($HasChild==1){ 
					  		?>
							<tr> 
							  <td colspan="2" class="g" nowrap="nowrap"><b><? echo $LinkTitle; ?></b></td>
							</tr>
							<?php
							$ChildLinksSize = sizeof($ChildLinksArray);
      
						      for($j=0;$j<$ChildLinksSize;$j++){
						        $MainLinkID= $ChildLinksArray[$j][2];
						        if($MainLinkID == $i){
						        	$ChildLinkTitle = $ChildLinksArray[$j][0];
						        	$ChildHREF = $ChildLinksArray[$j][1];
								?>
								<tr> 
								  <td width="1%"><img src="images/arrow_grey.gif" width="7" height="7" border="0"></td>
								  <td nowrap="nowrap">
								  <?php 	if($LinkTitle=="Static Page Management"){
									?>
								    <a target="_top" style="text-decoration:none;" href="<? echo $headHREF; ?>"><? echo $ChildLinkTitle; ?></a>
								    <?php
										}else{
								   ?>
								 <?php if($ChildHREF!='#'){?>
									  <a target="_top" href="<? echo $headHREF; ?>?default=<? echo $ChildHREF; ?>"><? echo $ChildLinkTitle; ?></a>
								  <? }else{ 
								  	$usrpwd = base64_encode($_SESSION["UsErOfAdMiN"])
								  ?>
									  <a target="_parent" href="innerhome.php" onClick="window.open('../helpdesk/admin.php?usrpwd=<?=$usrpwd;?>');"><? echo $ChildLinkTitle; ?></a>
									  <? } ?>
								  <? } ?>
								  </td>
								</tr>
								<?
								}//end of if 
							  }//end of for j
								?>
							<tr> 
							  <td height="10"> </td>
							</tr>
							<?
							}//end of if
						  }//end of for i
						  ?>
                    </table>
				
			   <? 
			   	if ($havingorder==1){ 
					// when in order list then it is include a file 
					//include("ordersummary.php");
				}
			   }// end of include ?>
			   </td>
			</tr>
			</table>
    </td>
    <td  width="1" rowspan="2" background="images/dots.gif"><img src="images/spacer.gif" width="1" height="1" border="0" /></td>
	<?php
	}
 	?>	
	<td>&nbsp;</td>	
  </tr>
 </table>
</td></tr>
</table>
</body>
</html>