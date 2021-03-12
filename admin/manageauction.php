<?php
	include_once("connect.php");
	include_once("admin.config.inc.php");
	include_once("security.php");
	include_once("config_setting.php");

	if(isset($_GET['parar_robos'])){
		$query .= " order by a.auc_status";
		$result = mysql_query("Update auction Set auction_min_price = 0 Where auctionID = ".$_GET['parar_robos']);
	}

	$PRODUCTSPERPAGE = 15; 
	$order = "";
	if($_GET['order']) $order = $_GET['order'];
	$PageNo = 1;
	if($_GET['pgno']) $PageNo = $_GET['pgno'];

	$StartRow = $PRODUCTSPERPAGE * ($PageNo-1);

	$query = "select *,p.name from auction a left join products p on a.productID=p.productID  
					 left join registration r on r.id=a.buy_user where featured_flag='0'";
	if($order!="") $query .= " and p.name like '{$order}%'";
 
	$ast = $_REQUEST["aucstatus"];
	if($ast!="") $query .= " and auc_status='{$ast}'";
	$query .= " order by a.auc_status";
	$result = mysql_query($query) or die (mysql_error());

	$totalrows  = mysql_num_rows($result);
	$totalpages = ceil($totalrows/$PRODUCTSPERPAGE);
	$query     .= " LIMIT $StartRow,$PRODUCTSPERPAGE";
	$result     = mysql_query($query);
	$total      = mysql_num_rows($result);
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=<?=$lng_characset;?>" />
		<title></title>
		<link rel="stylesheet" href="main.css" type="text/css">
		<script language="javascript" type="text/javascript">
			function SubmitForm(){
				document.f3.submit();
			}
			function verif_robos(id){
				if(confirm("Atenção!\n\n\nO leilão poderá ser arrematado abaixo do mínimo!\n\nTem certeza que deseja cancelar os robôs neste leilão?")){
					window.location.href='manageauction.php?parar_robos='+id;
				}
			}	
		</script>
	</head>

	<body bgcolor="#ffffff" style="padding-left:10px">
		<table width="100%" cellpadding="0" cellspacing="10">
			<tr><td class="H1">Gerenciar Leil&otilde;es</td></tr>
			<tr><td background="images/vdots.gif"><img height=1 src="images/spacer.gif" width=1 /></td></tr>
			<tr><td><!--content-->
				<table cellspacing="2" cellpadding="2" width="100%" >
					<tbody>
						<tr>
							<td colspan="2"> 
								<img height=11 src="images/001.gif" width=8 />
								<A class=la href="addauction.php"> Adicionar Novo Leil&atilde;o. </A> 
							</td>
						</tr>
						<tr><td colspan="2">&nbsp;</td></tr>
						<tr>
							<td class="tdTextBold"><b>Ver produtos por</b></td>
							<td>
								<form name="f3" action="manageauction.php" method="post">
								  <table border="0" cellpadding="0" cellspacing="0" width="200" align="right">
									<tr>
										<td align="right"><strong>Status:</strong>&nbsp;</td>
										<td><select name="aucstatus" onchange="SubmitForm();">
											<option value="">Todos</option>
											<option value="1" <?=$ast=="1"?"selected":"";?>>Futuros</option>
											<option value="2" <?=$ast=="2"?"selected":"";?>>Ativos</option>
											<option value="3" <?=$ast=="3"?"selected":"";?>>Vendidos</option>
											<option value="4" <?=$ast=="4"?"selected":"";?>>Pendentes</option>
										</select>
										<input type="hidden" name="pgno" value="1" /></td></tr>
								  </table>
								</form>
							</td>
						</tr>
					</tbody>
				</table>
				<br />
	<form id="form1" name="form1" action="manageauction.php" method="post">
	  <table cellSpacing="0" cellPadding="1" border="0" width="500">
		<tbody>
		<tr>
		  <td><a class="la" href="manageauction.php?aucstatus=<?=$ast;?>">Todos</a>    </td>
		  <td class="lg">|</td>
		  <td><a class="la" href="manageauction.php?order=A&aucstatus=<?=$ast;?>">A</a></td>
		  <td class="lg">|</td>
		  <td><a class="la" href="manageauction.php?order=B&aucstatus=<?=$ast;?>">B</a></td>
		  <td class="lg">|</td>
		  <td><a class="la" href="manageauction.php?order=C&aucstatus=<?=$ast;?>">C</a></td>
		  <td class="lg">|</td>
		  <td><a class="la" href="manageauction.php?order=D&aucstatus=<?=$ast;?>">D</a></td>
		  <td class="lg">|</td>
		  <td><a class="la" href="manageauction.php?order=E&aucstatus=<?=$ast;?>">E</a></td>
		  <td class="lg">|</td>
		  <td><A class="la" href="manageauction.php?order=F&aucstatus=<?=$ast;?>">F</A></td>
		  <td class="lg">|</td>
		  <td><A class="la" href="manageauction.php?order=G&aucstatus=<?=$ast;?>">G</A></td>
		  <td class="lg">|</td>
		  <td><A class="la" href="manageauction.php?order=H&aucstatus=<?=$ast;?>">H</A></td>
		  <td class="lg">|</td>
		  <td><A class="la" href="manageauction.php?order=I&aucstatus=<?=$ast;?>">I</A></td>
		  <td class="lg">|</td>
		  <td><A class="la" href="manageauction.php?order=J&aucstatus=<?=$ast;?>">J</A></td>
		  <td class="lg">|</td>
		  <td><A class="la" href="manageauction.php?order=K&aucstatus=<?=$ast;?>">K</A></td>
		  <td class="lg">|</td>
		  <td><A class="la" href="manageauction.php?order=L&aucstatus=<?=$ast;?>">L</A></td>
		  <td class="lg">|</td>
		  <td><A class="la" href="manageauction.php?order=M&aucstatus=<?=$ast;?>">M</A></td>
		  <td class="lg">|</td>
		  <td><A class="la" href="manageauction.php?order=N&aucstatus=<?=$ast;?>">N</A></td>
		  <td class="lg">|</td>
		  <td><A class="la" href="manageauction.php?order=O&aucstatus=<?=$ast;?>">O</A></td>
		  <td class="lg">|</td>
		  <td><A class="la" href="manageauction.php?order=P&aucstatus=<?=$ast;?>">P</A></td>
		  <td class="lg">|</td>
		  <td><A class="la" href="manageauction.php?order=Q&aucstatus=<?=$ast;?>">Q</A></td>
		  <td class="lg">|</td>
		  <td><A class="la" href="manageauction.php?order=R&aucstatus=<?=$ast;?>">R</A></td>
		  <td class="lg">|</td>
		  <td><A class="la" href="manageauction.php?order=S&aucstatus=<?=$ast;?>">S</A></td>
		  <td class="lg">|</td>
		  <td><A class="la" href="manageauction.php?order=T&aucstatus=<?=$ast;?>">T</A></td>
		  <td class="lg">|</td>
		  <td><A class="la" href="manageauction.php?order=U&aucstatus=<?=$ast;?>">U</A></td>
		  <td class="lg">|</td>
		  <td><A class="la" href="manageauction.php?order=V&aucstatus=<?=$ast;?>">V</A></td>
		  <td class="lg">|</td>
		  <td><A class="la" href="manageauction.php?order=W&aucstatus=<?=$ast;?>">W</A></td>
		  <td class="lg">|</td>
		  <td><A class="la" href="manageauction.php?order=X&aucstatus=<?=$ast;?>">X</A></td>
		  <td class="lg">|</td>
		  <td><A class="la" href="manageauction.php?order=Y&aucstatus=<?=$ast;?>">Y</A></td>
		  <td class="lg">|</td>
		  <td><A class="la" href="manageauction.php?order=Z&aucstatus=<?=$ast;?>">Z</A></td>
		</tr>
	   </tbody>
	  </table>
	</form>
	<?php if($total<=0){ ?>
	<table width="70%" border="0" cellspacing="1" cellpadding="1" align="center" bgcolor="#000000">
	  <tr> 
		<td> 
		  <table width="100%" border="0" cellspacing="0" cellpadding="0">
		   <tr> 
			 <td class=th-a> 
			  <div align="center">Sem informa&ccedil;&otilde;es para exibir</div></td>
		   </tr>
		 </table>
		</td>
	  </tr>
	</table>
	<?php }else{ ?>
	<table cellpadding="0" cellspacing="0" width="100%" border="0">
	  <tr>
		<td>
		<form id="form2" name="form2" action="" method="post">  
		  <table width="100%"  cellspacing="0" class="t-a" border="1">
		   <tbody>
			<tr class="th-a"> 
			  <td width="6%">No</td>
			  <td width="6%">Leil&atilde;o ID</td>
			  <td width="22%">Produto</td>
			  <td width="15%">Pre&ccedil;o Final</td>
			  <td width="5%">Status</td>
			  <td width="15%">Tipo</td>
			  <td width="11%">Ganhador</td>
			  <td width="20%" align="center">A&ccedil;&otilde;es</td>
			</tr>
			<?php
			  for($i=0;$i<$total;$i++){
				 if($PageNo>1){
					$srno = ($PageNo-1)*$PRODUCTSPERPAGE+$i+1;
				 }else{
					$srno = $i+1;
				 }
				$row = mysql_fetch_object($result);
				$id=$row->auctionID;
				$pname=stripslashes($row->name);
				$fprice=$row->auc_final_price;
				$status=$row->auc_status;
				$qt_min=$row->auction_min_price;
				
				$auctype = $row->auc_type;
				if($row->fixedpriceauction=="1"){$auctype="Fixo";}
				if($row->pennyauction=="1"){
					$auctype="1 Centavo";
					$qryc = "select * from auction_management where auc_manage='{$row->time_duration}'";
					$resc = mysql_query($qryc);
					$totalc = mysql_affected_rows();
					if($totalc>0){$namec = mysql_fetch_array($resc);$auctype=$namec["auc_title"];}
				}
				if($row->nailbiterauction=="1"){$auctype="Preg&atilde;o ";}
				if($row->offauction=="1"){$auctype="100% off";}
				if($row->nightauction=="1"){$auctype="Noturno";}
				if($row->openauction=="1"){$auctype="Aberto";}
					
				$winner = $row->username;
				$cellColor = ConfigcellColor($i);
				?>
				<tr class="<?=$cellColor?>">
					<td align="center"><?=$srno;?></td>	
					<td align="center"><?=$id;?></td>
					<td align="center"><?=$pname?></td>
					<td align="right"><?=$fprice==""?"&nbsp":$Currency.$fprice;?></td>
					<td align="center">
					<?php	
						if($status==1){ echo "<font color=green>Futuro</font>";}
						if($status==2){ echo "<font color=red>Ativo</font>";}
						if($status==3){ echo "<font color=blue>Vendido</font>";}
						if($status==4){ echo "<font color=green>Pendente</font>";}
					?>
					</td>
					<td nowrap="nowrap" align="center"><?=$auctype==""?"&nbsp":$auctype;?></td>
					<td align="center"><?=$winner==""?"&nbsp":$winner;?></td>
					<td align="left">
					<?php if($status!=3){ ?>
						<input class="bttn-s" onClick="window.location.href='addauction.php?auction_edit=<?=$id;?>'" type="button" value="Editar">			            
					<?php } if($status==1 || $status==4){ ?>
						<input name="button" type="button" class="bttn-s" value="Excluir" onClick="window.location.href='addauction.php?auction_delete=<?=$id;?>'">
					<?php } if($status==2 && $qt_min>0){ ?>
						<input name="button" type="button" class="bttn-s" value="Cancelar Rob&ocirc;s" onClick="return verif_robos(<?=$id;?>)">
					<?php } if($status==3){ ?>
						<input name="button" type="button" class="bttn-s" value="Repetir" onClick="window.location.href='addauction.php?auction_clone=<?=$id;?>'">
					<?php } ?>
					</td>
				</tr>
				<?php } ?>
									</tbody>
								</table>
							</form>
						</td>
					</tr>
				</table>
				<?php
				}
				if($PageNo>1){
					$PrevPageNo = $PageNo-1;
				?>
					<A class="paging" href="manageauction.php?order=<?php echo $order; 
					?>&pgno=<?php echo $PrevPageNo; ?>&aucstatus=<?php echo $ast;
					?>">&lt; P&aacute;gina Anterior</A>
				<?php } 
				echo '&nbsp;&nbsp;&nbsp;';
				if($PageNo<$totalpages){
					$NextPageNo = $PageNo + 1;
				?>
					<A class="paging" href="manageauction.php?order=<?php echo $order; 
					?>&pgno=<?php echo $NextPageNo;?>&aucstatus=<?php echo $ast;
					?>">Pr&oacute;xima P&aacute;gina &gt;</A>
				<?php } ?>
				</TD>
			</TR>
		</table>
	</body>
</html>