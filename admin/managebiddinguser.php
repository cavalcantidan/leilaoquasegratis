<?
	include("connect.php");
	include("security.php");

		if($_REQUEST['order'])
		{
		$order=$_REQUEST['order'];
		}

		if(!$_GET['pgno'])
		{
			$PageNo = 1;
		}
		else
		{
			$PageNo = $_GET['pgno'];
		}

		if($order)
		{
			$sql="select * from registration where admin_user_flag='1' and user_delete_flag!='d' and username like '$order%' order by id";
		}
		else
		{
			$sql="select * from registration where admin_user_flag='1' and user_delete_Flag!='d' order by id";
		}
			$PRODUCTSPERPAGE=20;
			$result=mysql_query($sql);
			$total=mysql_num_rows($result);
			$totalpage=ceil($total/$PRODUCTSPERPAGE);
		if($totalpage>=1)
		{
			$startrow=$PRODUCTSPERPAGE*($PageNo-1);
			$sql.=" LIMIT $startrow,$PRODUCTSPERPAGE";
			$result=mysql_query($sql);
			$total=mysql_num_rows($result);
		}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?=$lng_characset;?>" />
<title><? echo $ADMIN_MAIN_SITE_NAME." - Manage Bidding Users"; ?></title>
<link href="main.css" type="text/css" rel="stylesheet">
</head>
<body bgcolor="#ffffff" style="padding-left:10px">
<TABLE cellSpacing=10 cellPadding=0  border=0 width="100%">
		<TR>
			<TD class=H1>Administrar usu&aacute;rios rob&ocirc;s</TD>
		</TR>
		<TR>
			<TD background="images/vdots.gif"><IMG height=1 
			  src="images/spacer.gif" width=1 border=0></TD>
		</TR>
		<tr>
		  <td>&nbsp;&nbsp; <IMG height=11 src="images/001.gif" width=8 border=0> 
                <A class=la href="addbiddinguser.php">Adicionar Novo</A> </td>
		</tr>
<Tr>
<td>
<FORM id="form1" name="form1" action="" method="post">
      <TABLE cellSpacing=0 cellPadding=1 border=0 >
        <TBODY>
        <TR>
          <TD><a class=la href="managebiddinguser.php">All</a></TD>
          <TD class=lg>|</TD>
                
          <TD><a class=la href="managebiddinguser.php?order=A">A</a></TD>
          <TD class=lg>|</TD>
          <TD><a class=la href="managebiddinguser.php?order=B">B</a></TD>
          <TD class=lg>|</TD>
          <TD><a class=la href="managebiddinguser.php?order=C">C</a></TD>
          <TD class=lg>|</TD>
          <TD><a class=la href="managebiddinguser.php?order=D">D</a></TD>
          <TD class=lg>|</TD>
          <TD><a class=la href="managebiddinguser.php?order=E">E</a></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="managebiddinguser.php?order=F">F</A></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="managebiddinguser.php?order=G">G</A></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="managebiddinguser.php?order=H">H</A></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="managebiddinguser.php?order=I">I</A></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="managebiddinguser.php?order=J">J</A></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="managebiddinguser.php?order=K">K</A></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="managebiddinguser.php?order=L">L</A></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="managebiddinguser.php?order=M">M</A></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="managebiddinguser.php?order=N">N</A></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="managebiddinguser.php?order=O">O</A></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="managebiddinguser.php?order=P">P</A></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="managebiddinguser.php?order=Q">Q</A></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="managebiddinguser.php?order=R">R</A></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="managebiddinguser.php?order=S">S</A></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="managebiddinguser.php?order=T">T</A></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="managebiddinguser.php?order=U">U</A></TD>

          <TD class=lg>|</TD>
          <TD><A class=la href="managebiddinguser.php?order=V">V</A></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="managebiddinguser.php?order=W">W</A></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="managebiddinguser.php?order=X">X</A></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="managebiddinguser.php?order=Y">Y</A></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="managebiddinguser.php?order=Z">Z</A></TD></TR></TBODY></TABLE>
			</form>
			 <? if($total==0){?>
		<table width="95%" border="0" cellspacing="1" cellpadding="1" align="center" bgcolor="#000000">
        <tr> 
          <td > 
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr> 
                <td class=th-a > 
                  <div align="center">Sem informa&ccedil;&otilde;es para exibir</div>
                </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
      <?php }else{?>
	<form id="form2" name="form2" action="" method="post">	  
	<TABLE width="95%" border="1" cellSpacing="0" class="t-a" align="center">
              <TR class="th-a"> 
			  	<TD width="20%" nowrap="nowrap">Nome de usuario</TD>
				<TD width="30%" nowrap="nowrap">Primeiro Nome</TD>
                <TD width="10%" nowrap="nowrap">Ultimo Nome</TD>
				<td width="25%" nowrap="nowrap">Email</td>
				<TD width="10%" nowrap="nowrap">Pais</TD>
				<?php /*?><TD width="10%" nowrap="nowrap">Phone No</TD><?php */?>
				<TD width="15%" nowrap="nowrap">Op&ccedil;&otilde;es</TD>
              </TR>
		<?
			  $colorflg=0;
			  for($i=1;$i<=$total;$i++)
			  {
			  	$row = mysql_fetch_object($result);
				if ($colorflg==1){
					$colorflg=0;
					$colorid = "#F2F6FD";
					echo "<TR bgcolor=\"#F2F6FD\"> ";
				}else{
					$colorflg=1;
					$colorid = "#FFFFFF";
				  	echo "<TR> ";
				}
				
				$qrycou1 = "select * from countries where countryID='".$row->country."'";
				$rescou1 = mysql_query($qrycou1);
				$objcou1 = mysql_fetch_object($rescou1);
		?>	
			  	<TD width="20%" nowrap="nowrap"><?=$row->username!=""?$row->username:"&nbsp;";?></TD>
				<TD width="30%" nowrap="nowrap"><?=$row->firstname!=""?$row->firstname:"&nbsp;";?></TD>
                <TD width="10%" nowrap="nowrap"><?=$row->lastname!=""?$row->lastname:"&nbsp;";?></TD>
				<td width="25%" nowrap="nowrap"><?=$row->email!=""?$row->email:"&nbsp;";?></td>
				<TD width="10%" nowrap="nowrap"><?=$objcou1->printable_name!=""?$objcou1->printable_name:"&nbsp;";?></TD>
				<?php /*?><TD width="10%" nowrap="nowrap"><?=$row->phone!=""?$row->phone:"&nbsp;";?></TD><?php */?>
				<TD width="15%" nowrap="nowrap">
			<INPUT class="bttn" onClick="window.location.href='addbiddinguser.php?editid=<?=$row->id;?>'" type="button" value="Editar">
			<?
				if($row->id!="1"){
			?> 
            <input name="button" type="button" class="bttn" value="Excluir" onClick="window.location.href='addbiddinguser.php?delid=<?=$row->id;?>'">
			<? } ?>
				</TD>
			</TR>
		<?
			}
		?>
	</TABLE>
		  <? if($totalpage>1){ ?><br /><Br />
			   <?php
                if($PageNo>1)
                {
                          $PrevPageNo = $PageNo-1;
        
                ?>
              <A class=paging href="managebiddinguser.php?pgno=<?=$PrevPageNo; ?>&order=<?=$order?>">&lt; P&aacute;gina Anterior</A>
              <?
               }
              ?> &nbsp;&nbsp;&nbsp;
              <?php
                if($PageNo<$totalpage)
                {
                 $NextPageNo = 	$PageNo + 1;
              ?>
              <A class=paging id=next href="managebiddinguser.php?pgno=<?=$NextPageNo;?>&order=<?=$order?>">Pr&amp;oacute;xima P&amp;aacute;gina &gt;</A>
              <?
               }
              ?>
		  <!-- paging ends -->
		  <? } ?>
		  <!-- paging starts -->
	</form>
	<?
		}
	?>
</td>
</Tr>
</TABLE>
</body>
</html>
