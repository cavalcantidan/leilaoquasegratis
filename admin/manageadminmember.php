<?
	include("connect.php");
	include("security.php");
	$type1 = 1;
	include("pagepermission.php");

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
			$sql="select * from admin where username<>'admin' and username like '$order%' order by id";
		}
		else
		{
			$sql="select * from admin where username<>'admin' order by id";
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
<title><? echo $ADMIN_MAIN_SITE_NAME." - Manage Members"; ?></title>
<link href="main.css" type="text/css" rel="stylesheet">
</head>
<body bgcolor="#ffffff" style="padding-left:10px">
<TABLE cellSpacing=10 cellPadding=0  border=0 width="100%">
		<TR>
			<TD class=H1>Administrar usu&aacute;rios</TD>
		</TR>
		<TR>
			<TD background="images/vdots.gif"><IMG height=1 
			  src="images/spacer.gif" width=1 border=0></TD>
		</TR>
		<tr>
		  <td>&nbsp;&nbsp; <IMG height=11 src="images/001.gif" width=8 border=0> 
                <A class=la href="addadminmember.php">Inserir novo usu&aacute;rio</A> </td>
		</tr>
<Tr>
<td>
<FORM id="form1" name="form1" action="manage_members.php" method="post">
      <TABLE cellSpacing=0 cellPadding=1 border=0 >
        <TBODY>
        <TR>
          <TD><a class=la href="manageadminmember.php">Todos</a></TD>
          <TD class=lg>|</TD>
                
          <TD><a class=la href="manageadminmember.php?order=A">A</a></TD>
          <TD class=lg>|</TD>
          <TD><a class=la href="manageadminmember.php?order=B">B</a></TD>
          <TD class=lg>|</TD>
          <TD><a class=la href="manageadminmember.php?order=C">C</a></TD>
          <TD class=lg>|</TD>
          <TD><a class=la href="manageadminmember.php?order=D">D</a></TD>
          <TD class=lg>|</TD>
          <TD><a class=la href="manageadminmember.php?order=E">E</a></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="manageadminmember.php?order=F">F</A></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="manageadminmember.php?order=G">G</A></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="manageadminmember.php?order=H">H</A></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="manageadminmember.php?order=I">I</A></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="manageadminmember.php?order=J">J</A></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="manageadminmember.php?order=K">K</A></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="manageadminmember.php?order=L">L</A></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="manageadminmember.php?order=M">M</A></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="manageadminmember.php?order=N">N</A></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="manageadminmember.php?order=O">O</A></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="manageadminmember.php?order=P">P</A></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="manageadminmember.php?order=Q">Q</A></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="manageadminmember.php?order=R">R</A></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="manageadminmember.php?order=S">S</A></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="manageadminmember.php?order=T">T</A></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="manageadminmember.php?order=U">U</A></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="manageadminmember.php?order=V">V</A></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="manageadminmember.php?order=W">W</A></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="manageadminmember.php?order=X">X</A></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="manageadminmember.php?order=Y">Y</A></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="manageadminmember.php?order=Z">Z</A></TD></TR></TBODY></TABLE>
			</form>
			 <? if($total==0){?>
		<table width="95%" border="0" cellspacing="1" cellpadding="1" align="center" bgcolor="#000000">
        <tr> 
          <td > 
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr> 
                <td class=th-a > 
                  <div align="center">Sem usu&aacute;rios para exibir</div>
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
			  	<TD width="20%" nowrap="nowrap">Nome de usu&aacute;rio</TD>
				<TD width="30%" nowrap="nowrap">Primeiro nome</TD>
                <TD width="10%" nowrap="nowrap">Ultimo nome</TD>
				<td width="25%" nowrap="nowrap">Email</td>
				<TD width="10%" nowrap="nowrap">Telefone</TD>
				<TD width="10%" nowrap="nowrap">Categoria</TD>
				<TD width="15%" nowrap="nowrap">Op&ccedil;&otilde;es</TD>
              </TR>
		<?
			  $colorflg=0;
			  for($i=0;$i<=$total;$i++)
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

				if($row->type=="1") { $cat = "Supervisor"; }
				elseif($row->type=="2") { $cat = "Financeiro"; }
				elseif($row->type=="3") { $cat = "Marketing"; }
				else{ $cat = "&nbsp;"; }

				if($row->id=="1")
				{
					continue;
				}
		?>	
			  	<TD width="20%" nowrap="nowrap"><?=$row->username!=""?$row->username:"&nbsp;";?></TD>
				<TD width="30%" nowrap="nowrap"><?=$row->firstname!=""?$row->firstname:"&nbsp;";?></TD>
                <TD width="10%" nowrap="nowrap"><?=$row->lastname!=""?$row->lastname:"&nbsp;";?></TD>
				<td width="25%" nowrap="nowrap"><?=$row->email!=""?$row->email:"&nbsp;";?></td>
				<TD width="10%" nowrap="nowrap"><?=$row->phoneno!=""?$row->phoneno:"&nbsp;";?></TD>
				<TD width="10%" nowrap="nowrap"><?=$cat;?></TD>
				<TD width="15%" nowrap="nowrap">
			<INPUT class="bttn" onClick="window.location.href='addadminmember.php?editid=<?=$row->id;?>'" type="button" value="Editar">
			<?
				if($row->id!="1"){
			?> 
            <input name="button" type="button" class="bttn" value="Excluir" onClick="window.location.href='addadminmember.php?delid=<?=$row->id;?>'">
			<? } ?>
				</TD>
			</TR>
		<?
			}
		?>
	</TABLE>
	</form>
	<?
		}
	?>
</td>
</Tr>
</TABLE>
</body>
</html>
