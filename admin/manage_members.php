<?
include("connect.php");
$PRODUCTSPERPAGE=20;
include("security.php");
include('../sendmail.php');

if($_GET['sendemail']!=""){
		$sqlsendemail = "select * from registration where user_delete_flag!='d' and id='".$_GET['sendemail']."'";
		$ressendemail = mysql_query($sqlsendemail) or die(mysql_error());
		$rowsendemail = mysql_fetch_array($ressendemail);
		$email = $rowsendemail['email'];
		$content='';
		$content.= "<font style='font-size: 10px;font-family: Arial, Helvetica, sans-serif;color: #333333;'>Dear Member,"."</font><br>"."<br>"."<p align='center' style='font-size: 14px;font-family: Arial, Helvetica, sans-serif;font-weight:bold;'>Account Information</p>"."<br>".	
	
	"<table border='0' cellpadding='3' cellspacing='0' width='100%' align='center' class='style13'>";

		$content.="<tr style='font-size: 10px;font-family: Arial, Helvetica, sans-serif;color: #333333;'>
		<td>Hi ".$rowsendemail['firstname'].", </td>
		</tr>";

		$content.="<tr style='font-size: 10px;font-family: Arial, Helvetica, sans-serif;color: #333333;'>
		<td>Here is the login information that you requested:</td>
		</tr>";
		
		$content.="<tr style='font-size: 10px;font-family: Arial, Helvetica, sans-serif;color: #333333;'>
		<td>SnaBid username: ".$rowsendemail['username']."</td>
		</tr>";

		$content.="<tr style='font-size: 10px;font-family: Arial, Helvetica, sans-serif;color: #333333;'>
		<td>SnaBid user ID: ".$rowsendemail['id']."</td>
		</tr>";

		$content.="<tr style='font-size: 10px;font-family: Arial, Helvetica, sans-serif;color: #333333;'>
		<td>To enable your account <a href='".$SITE_URL."password.php?auc_key=".$rowsendemail['verify_code']."'>Click Here</a></td>
		</tr>
		</table>";

		$subject="Account Information @ SnaBid.com";
		$from=$adminemailadd;
		//$ADMIN_EMAIL = "scah@comcast.net";
		//$ADMIN_EMAIL = "testmailfunction@gmail.com";
		SendHTMLMail($email,$subject,$content,$from);
		header("location:message.php?msg=59");
		exit;
}

if($_GET["verifyit"]!=""){
	$userverify = $_GET["verifyit"];
	$qryupd = "update registration set account_status='1' where id='".$userverify."'";
	mysql_query($qryupd) or die(mysql_error());
	header("location: message.php?msg=80");
	exit;
}

if($_POST['ChangeStatus'])
{
	if(is_array($_POST['enable_disable'])){
		for($j=0;$j<count($_POST['enable_disable']);$j++){
			$cvariable = explode("|",$_POST['enable_disable'][$j]);
			$m_id = $cvariable[0];
			$c_status = $cvariable[1];
			if(trim($c_status)=="0" or trim($c_status)==""){
				$chag_status = "1";
			}
			elseif(trim($c_status)=="1"){
				$chag_status = "0";
			}
			$udpatestatus = "update registration set member_status='".$chag_status."' where id='".$m_id."'";
			mysql_query($udpatestatus) or die(mysql_error());
		}
	}
}


// calculation for order
if($_REQUEST['order']){
    $order=$_REQUEST['order'];
}
//calculation for page no
if(!$_GET['pgno']){
	$PageNo = 1;
}else{
	$PageNo = $_GET['pgno'];
}
if($order){
    if($_REQUEST['memstatus']!=""){
    	if($_REQUEST['memstatus']=="0" || $_REQUEST['memstatus']=="1" || $_REQUEST['memstatus']=="2")	{
    		$addquery = " and account_status='".$_REQUEST['memstatus']."' ";
    	}elseif($_REQUEST['memstatus']=="d"){
    		$addquery = " and member_status='1' ";
    	}
        $memstatus = $_REQUEST['memstatus'];	
    }
    if($_REQUEST["stext"]!=""){
    	$searchdata = $_REQUEST["stext"];
    	$addquery2 = "and (username like '%".$searchdata."%' or firstname like '%".$searchdata."%' or lastname like '%".$searchdata."%')";
    }
    $sql="select * from registration where admin_user_flag='0' and username like '$order%' and user_delete_flag!='d'  ".$addquery.$addquery2." order by id";
}else{
    if($_REQUEST['memstatus']!=""){
    	if($_REQUEST['memstatus']=="0" || $_REQUEST['memstatus']=="1" || $_REQUEST['memstatus']=="2"){
    		$addquery = " and account_status='".$_REQUEST['memstatus']."' ";
    	}elseif($_REQUEST['memstatus']=="d"){
    		$addquery = " and member_status='1' ";
    	}
        $memstatus = $_REQUEST['memstatus'];	
    }
    if($_REQUEST["stext"]!=""){
    	$searchdata = $_REQUEST["stext"];
    	$addquery2 = "and (username like '%".$searchdata."%' or firstname like '%".$searchdata."%' or lastname like '%".$searchdata."%')";
    }
    $sql="select * from registration where admin_user_flag='0' and user_delete_flag!='d' ".$addquery.$addquery2." order by id";
}
$PRODUCTSPERPAGE=40;
$result=mysql_query($sql);
$total=mysql_num_rows($result);
$totalpage=ceil($total/$PRODUCTSPERPAGE);
//echo $totalpage;
if($totalpage>=1){
    $startrow=$PRODUCTSPERPAGE*($PageNo-1);
    $sql.=" LIMIT $startrow,$PRODUCTSPERPAGE";
    //echo $sql;
    $result=mysql_query($sql);
    $total=mysql_num_rows($result);
}

//todos os usuarios que nao foram excluidos
$qrycount = "select * from registration where admin_user_flag='0' and user_delete_flag!='d'";
$rescount = mysql_query($qrycount);
$totalcount = mysql_num_rows($rescount);

//usuarios nao verificados
$qrycount1 = "select * from registration where admin_user_flag='0' and user_delete_flag!='d' and account_status='0' and member_status='0'";
$rescount1 = mysql_query($qrycount1);
$totalcount1 = mysql_num_rows($rescount1);

//usuarios ativos
$qrycount2 = "select * from registration where admin_user_flag='0' and user_delete_flag!='d' and account_status='1' and member_status='0'";
$rescount2 = mysql_query($qrycount2);
$totalcount2 = mysql_num_rows($rescount2);

//usuarios descadastrados

$qrycount3 = "select * from registration where admin_user_flag='0' and user_delete_flag!='d' and account_status='2'";
$rescount3 = mysql_query($qrycount3);
$totalcount3 = mysql_num_rows($rescount3);

//usuarios suspensos
$qrycount4 = "select * from registration where admin_user_flag='0' and user_delete_flag!='d' and member_status='1'";
$rescount4 = mysql_query($qrycount4);
$totalcount4 = mysql_num_rows($rescount4);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/tr/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=<?=$lng_characset;?>" />
    <title><? echo $ADMIN_MAIN_SITE_NAME." - Gerenciamento dos membros"; ?></title>
    <script language="JavaScript">
    	
    	function delconfirm(loc){
    		if(confirm("Deseja realmente excluir este usuário?")){
    			window.location.href=loc;
    		}
    		return false;
    	}
        function Submitform(){
        	document.form1.submit();
        }	
        function EnterData(){
        	if(document.searchuser.stext.value==""){
        		alert("Por Favor, digite um texto para buscar");
        		document.searchuser.stext.focus();
        		return false;
        	}
        }	
    </script>
    <link href="main.css" type="text/css" rel="stylesheet" />
</head>

<body bgcolor="#ffffff" style="padding-left:10px">
    <table cellspacing="10" cellpadding="0"  border="0" width="100%">
		<tr>
			<td>
				<table border="0" width="770">
				<tr>
					<td class='H1' width="600">Administrar Usu&aacute;rios</td>
					<td>
						<table border="0">
							<tr>
								<td>Ativos:</td>
								<td align="right"><?=$totalcount2;?></td>
							</tr>
							<tr>
								<td>Descadastrados :</td>
								<td align="right"><?=$totalcount3;?></td>
							</tr>
							<tr>
								<td>N&atilde;o Verificados:</td>
								<td align="right"><?=$totalcount1;?></td>
							</tr>
							<tr>
								<td>Suspensos :</td>
								<td align="right"><?=$totalcount4;?></td>
							</tr>
							<tr>
								<td>Total:</td>
								<td align="right"><?=$totalcount;?></td>
							</tr>
						</table>
					</td>
				</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td background="images/vdots.gif"><img src="images/spacer.gif" height="1" width="1" border="0" /></td>
		</tr>
		<tr>
			<td>
				<table border="0" width=" 770">
				<tr>
					<form name="searchuser" action="" method="post" onsubmit="return EnterData();">
					<td width="515">&nbsp;&nbsp; <img height="11" src="images/001.gif" width="8" border="0" /> 
                        <a class="la" href="edit_member.php">Inserir novo Usu&aacute;rio</a> </td>
					<td>Buscar : 
					  <input type="text" name="stext" value="<?=$searchdata;?>" />&nbsp;&nbsp;
                      <input type="submit" name="searchsubmit" value="Buscar" class="bttn" />
                      <input type="hidden" name="memstatus" value="<?=$memstatus;?>" /></td>
					</form>
			    </tr>
				</table>
			</td>
		</tr>
        <tr>
<td>
<form id="form1" name="form1" action="manage_members.php" method="post">
      <table cellspacing=0 cellpadding=1 border=0  width="780">
        <tbody>
        <tr>
		<td width="56%">
			<table border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr>
          <td><a class=la href="manage_members.php?memstatus=<?=$memstatus?>&stext=<?=$searchdata;?>">Todos</a></td>
          <td class=lg>|</td>
                
          <td><a class=la href="manage_members.php?order=A&memstatus=<?=$memstatus?>&stext=<?=$searchdata;?>">A</a></td>
          <td class=lg>|</td>
          <td><a class=la href="manage_members.php?order=B&memstatus=<?=$memstatus?>&stext=<?=$searchdata;?>">B</a></td>
          <td class=lg>|</td>
          <td><a class=la href="manage_members.php?order=C&memstatus=<?=$memstatus?>&stext=<?=$searchdata;?>">C</a></td>
          <td class=lg>|</td>
          <td><a class=la href="manage_members.php?order=D&memstatus=<?=$memstatus?>&stext=<?=$searchdata;?>">D</a></td>
          <td class=lg>|</td>
          <td><a class=la href="manage_members.php?order=E&memstatus=<?=$memstatus?>&stext=<?=$searchdata;?>">E</a></td>
          <td class=lg>|</td>
          <td><a class=la href="manage_members.php?order=F&memstatus=<?=$memstatus?>&stext=<?=$searchdata;?>">F</a></td>
          <td class=lg>|</td>
          <td><a class=la href="manage_members.php?order=G&memstatus=<?=$memstatus?>&stext=<?=$searchdata;?>">G</a></td>
          <td class=lg>|</td>
          <td><a class=la href="manage_members.php?order=H&memstatus=<?=$memstatus?>&stext=<?=$searchdata;?>">H</a></td>
          <td class=lg>|</td>
          <td><a class=la href="manage_members.php?order=I&memstatus=<?=$memstatus?>&stext=<?=$searchdata;?>">I</a></td>
          <td class=lg>|</td>
          <td><a class=la href="manage_members.php?order=J&memstatus=<?=$memstatus?>&stext=<?=$searchdata;?>">J</a></td>
          <td class=lg>|</td>
          <td><a class=la href="manage_members.php?order=K&memstatus=<?=$memstatus?>&stext=<?=$searchdata;?>">K</a></td>
          <td class=lg>|</td>
          <td><a class=la href="manage_members.php?order=L&memstatus=<?=$memstatus?>&stext=<?=$searchdata;?>">L</a></td>
          <td class=lg>|</td>
          <td><a class=la href="manage_members.php?order=M&memstatus=<?=$memstatus?>&stext=<?=$searchdata;?>">M</a></td>
          <td class=lg>|</td>
          <td><a class=la href="manage_members.php?order=N&memstatus=<?=$memstatus?>&stext=<?=$searchdata;?>">N</a></td>
          <td class=lg>|</td>
          <td><a class=la href="manage_members.php?order=O&memstatus=<?=$memstatus?>&stext=<?=$searchdata;?>">O</a></td>
          <td class=lg>|</td>
          <td><a class=la href="manage_members.php?order=P&memstatus=<?=$memstatus?>&stext=<?=$searchdata;?>">P</a></td>
          <td class=lg>|</td>
          <td><a class=la href="manage_members.php?order=Q&memstatus=<?=$memstatus?>&stext=<?=$searchdata;?>">Q</a></td>
          <td class=lg>|</td>
          <td><a class=la href="manage_members.php?order=R&memstatus=<?=$memstatus?>&stext=<?=$searchdata;?>">R</a></td>
          <td class=lg>|</td>
          <td><a class=la href="manage_members.php?order=S&memstatus=<?=$memstatus?>&stext=<?=$searchdata;?>">S</a></td>
          <td class=lg>|</td>
          <td><a class=la href="manage_members.php?order=T&memstatus=<?=$memstatus?>&stext=<?=$searchdata;?>">T</a></td>
          <td class=lg>|</td>
          <td><a class=la href="manage_members.php?order=U&memstatus=<?=$memstatus?>&stext=<?=$searchdata;?>">U</a></td>
          <td class=lg>|</td>
          <td><a class=la href="manage_members.php?order=V&memstatus=<?=$memstatus?>&stext=<?=$searchdata;?>">V</a></td>
          <td class=lg>|</td>
          <td><a class=la href="manage_members.php?order=W&memstatus=<?=$memstatus?>&stext=<?=$searchdata;?>">W</a></td>
          <td class=lg>|</td>
          <td><a class=la href="manage_members.php?order=X&memstatus=<?=$memstatus?>&stext=<?=$searchdata;?>">X</a></td>
          <td class=lg>|</td>
          <td><a class=la href="manage_members.php?order=Y&memstatus=<?=$memstatus?>&stext=<?=$searchdata;?>">Y</a></td>
          <td class=lg>|</td>
          <td><a class=la href="manage_members.php?order=Z&memstatus=<?=$memstatus?>&stext=<?=$searchdata;?>">Z</a></td>
		  </tr>
		  </table>
		  </td>
		  <td width="15%">&nbsp;</td>
		<td width="40%" align="right">
			<table border="0" cellpadding="0"  cellspacing="0" width="100%">
				<tr>
					<td align="left"><b>Status :</b>
					  <select name="memstatus" onchange="Submitform();">
					<option value="" <? if($memstatus==""){?> selected="selected"<? } ?>>Todos</option>
					<option value="2" <? if($memstatus=="2"){?> selected="selected"<? } ?>>Descadastrados</option>
					<option value="0" <? if($memstatus=="0"){?>selected="selected"<? } ?>>N&atilde;o verificados</option>
					<option value="1" <? if($memstatus=="1"){?>selected="selected"<? } ?>>Ativos</option>
					<option value="d" <? if($memstatus=="d"){?>selected="selected"<? } ?>>Suspensos</option>
					</select>
					</td>
				</tr>
			</table>
		  </td>		
		  </tr></tbody></table>
		<input type="hidden" name="stext" value="<?=$searchdata;?>" />		  
			</form>
			 <? if(!$total){?>
		<table width="95%" border="0" cellspacing="1" cellpadding="1" align="center" bgcolor="#000000">
        <tr> 
          <td > 
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr> 
                <td class=th-a > 
                  <div align="center">Nenhum Usu&aacute;rio para exibir</div>
                </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
      <?php }else{?>
<form id="form2" name="form2" action="" method="post">	  
		<table width="95%" border="1" cellspacing="0" class="t-a" align="center">
              <tr class="th-a"> 
			  	<td width="5%" nowrap="nowrap">&nbsp;</td>
			  	<td width="20%" nowrap="nowrap">ID</td>
			  	<td width="20%" nowrap="nowrap">Nome de Usu&aacute;rio</td>
				<td width="30%" nowrap="nowrap">Nome</td>
                <td width="10%" nowrap="nowrap">Cidade</td>
				<td width="15%" nowrap="nowrap">Pa&iacute;s</td>
				<td width="25%" nowrap="nowrap">Email</td>
				<td width="10%" nowrap="nowrap">Status</td>
				<td width="10%" nowrap="nowrap">Patrocinador</td>
				<td width="15%" nowrap="nowrap">Op&ccedil;&otilde;es</td>
              </tr>
              <?php
			  $colorflg=0;
			  for($i=0;$i<$total;$i++){
				$row = mysql_fetch_object($result);
				$id=$row->id;
				$fname = stripslashes($row->firstname);
				$lname = stripslashes($row->lastname);
				$city=$row->city;
				$member_status = $row->member_status;
				$account_status = $row->account_status;				
				$country=$row->country;
					$qrycou = "select * from countries";
					$rescou = mysql_query($qrycou);
					while($cou=mysql_fetch_array($rescou)){
						if($country==$cou["countryId"]){
							$country = $cou["printable_name"];
						}					
					}
					if($row->sponser!='0'){
						$qryreg = "select * from registration where id='".$row->sponser."'";
						$resreg = mysql_query($qryreg);
						$objreg = mysql_fetch_object($resreg);
						$sponsername = $objreg->username;
					}
				$email=stripslashes($row->email);
				$username=stripslashes($row->username);
				$userid= $row->id;
				
				if ($colorflg==1){
					$colorflg=0;
					$colorid = "#F2F6FD";
					echo "<tr bgcolor=\"#F2F6FD\"> ";
				}else{
					$colorflg=1;
					$colorid = "#FFFFFF";
				  	echo "<tr> ";
				}?>
				<tr>
                    <td align="left" valign="middle"><input type="checkbox" name="enable_disable[]" value="<?=$id."|".$member_status;?>" style="border:none; background-color:<?=$colorid?>" /></td>
                    <td align="left" valign="middle"><?=$userid."&nbsp;"; ?></td>
                    <td align="left" valign="middle"><?=$username."&nbsp;"; ?></td>
    				<td align="left" valign="middle"><?=$fname."&nbsp;".$lname; ?></td>
    				<td align="left" valign="middle"><?=$city."&nbsp;"; ?></td>
    				<td align="left" valign="middle"><?=$country."&nbsp;"; ?></td>
    				<td align="left" valign="middle"><?=$email."&nbsp;"; ?></td>
    				<td align="left" valign="middle"><? if($member_status==0 && $account_status==1){ echo "<font color='green'>Ativo</font>";} elseif($member_status==0 && $account_status==2){ echo "<font color='red'>Fechado</font>"; }elseif($member_status==1){ echo "<font color='red'>Inativo</font>";} elseif($member_status==0 && $account_status==0){ echo "<font color='green'>Ativo</font>"; } ?></td>
    				<td align="center" valign="middle"><?=$sponsername!=""?$sponsername:"--"; ?></td>
                    <td width="32%" nowrap >
                        <input type="button" name="editar" class="bttn" value="Editar" onclick="window.location.href='edit_member.php?editid=<?=$id;?>'" /> 
                        <input type="button" name="button" class="bttn" value="Excluir" onclick="return delconfirm('edit_member.php?delid=<?=$id;?>')" />
                        <input type="button" name="button" class="bttn" value="Estatistica" onclick="window.location.href='view_member_statistics.php?uid=<?=$id;?>'" />
                        <? if($account_status=='0'){?>
                        <br /><br />
                        <input type="button" name="re_sent" class="bttn" value="Enviar email de Verifica&ccedil;&atilde;o" onclick="window.location.href='manage_members.php?sendemail=<?=$id;?>'" />&nbsp;
                        <input type="button" name="verify_it" class="bttn" value="Verificar" onclick="window.location.href='manage_members.php?verifyit=<?=$id;?>'" />
                        <? } ?>
                    </td>
              </tr>
              <? $sponsername = ""; } ?>
            </table><br />
		  <input type="submit" class="bttn" name="ChangeStatus" value="Ativar/Desativar" />
		  </form><br />
		  <? } ?>
    <br /><!-- paging starts -->
    <?php if($PageNo>1){ $PrevPageNo = $PageNo - 1; ?>
        <a class="paging" href="manage_members.php?pgno=<?=$PrevPageNo; ?>&order=<?=$order?>&memstatus=<?=$memstatus?>&stext=<?=$searchdata;?>">&lt; P&aacute;gina Anterior</a>
	<? } if($PageNo<$totalpage){ $NextPageNo = $PageNo + 1; ?>
	  &nbsp;&nbsp;&nbsp;<a class="paging" id="next" href="manage_members.php?pgno=<?=$NextPageNo;?>&order=<?=$order?>&memstatus=<?=$memstatus?>&stext=<?=$searchdata;?>">Pr&oacute;xima P&aacute;gina &gt;</a>
	<? } ?><!-- paging ends -->
</td></tr></tbody></table></body>
</html>
