<?php
include("connect.php");
include("security.php");

function UseBidStatus($userid)
{
	$sqlbidstatus = "select * from bid_account where bid_flag='d' and user_id='".$userid."'";
	$resbidstatus = mysql_query($sqlbidstatus) or die(mysql_error());
	$total = mysql_num_rows($resbidstatus);
	return $total;
}
function UserPurchaseBid($userid)
{
	$sqlbidcount = "select SUM(bid_count) as bidcount from bid_account where bid_flag='c' and user_id='".$userid."' and recharge_type='re'";
	$resbidcount = mysql_query($sqlbidcount) or die(mysql_error());
	$totalbidcount = mysql_num_rows($resbidcount);
	if($totalbidcount>0)
	{
		$rowbidcount = mysql_fetch_array($resbidcount);
		$bidcount = $rowbidcount['bidcount'];
	}
	else
	{
		$bidcount = 0;
	}
	return $bidcount;
}
function UserAdminBid($userid)
{
	$sqlbidcount = "select SUM(bid_count) as bidcount from bid_account where bid_flag='c' and user_id='".$userid."' and recharge_type='ad'";
	$resbidcount = mysql_query($sqlbidcount) or die(mysql_error());
	$totalbidcount = mysql_num_rows($resbidcount);
	if($totalbidcount>0)
	{
		$rowbidcount = mysql_fetch_array($resbidcount);
		$bidcount = $rowbidcount['bidcount'];
	}
	else
	{
		$bidcount = 0;
	}
	return $bidcount;
}
function UserReferralBid($userid)
{
	$sqlbidcount = "select SUM(bid_count) as bidcount from bid_account where bid_flag='c' and user_id='".$userid."' and recharge_type='af'";
	$resbidcount = mysql_query($sqlbidcount) or die(mysql_error());
	$totalbidcount = mysql_num_rows($resbidcount);
	if($totalbidcount>0)
	{
		$rowbidcount = mysql_fetch_array($resbidcount);
		$bidcount = $rowbidcount['bidcount'];
	}
	else
	{
		$bidcount = 0;
	}
	return $bidcount;
}

function GetWonAuctionStatus($au_id,$au_status,$uid)
{
	if($au_status=="3")
	{
		$sqlwonauctstat = "select * from won_auctions where auction_id='".$au_id."' and userid='".$uid."'";
		$reswonauctstat = mysql_query($sqlwonauctstat) or die(mysql_error());
		if(0<mysql_num_rows($reswonauctstat))
		{
			return "<font color='green'>Won</font>";
		}
		else
		{
			return "<font color='red'>Lost</font>";
		}
	}
	else
	{
		return "-";
	}
}
$u_id = $_GET['uid'];	
$sqlquery = "select * from registration where id='".$u_id."' order by id";
$resquery = mysql_query($sqlquery) or die(mysql_error());
$rowquery = mysql_fetch_array($resquery);
?>
<html>
<head>

<meta http-equiv="Content-Type" content="text/html; charset=<?=$lng_characset;?>">
</head>

<link href="main.css" type="text/css" rel="stylesheet">
<script language="javascript">
	function OpenPopup(url){
		window.open(url,'popupWindow','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=yes,copyhistory=no,width=700,height=475,screenX=150,screenY=200,top=200,left=200')
}
</script>
<body bgcolor="#ffffff">
	
	<TABLE cellSpacing=5 cellPadding=0  border=0 width="99%">
		<TR>
			<TD class=H1>Visualizar Estatisticas de Usu&aacute;rios</TD>
		</TR>
		<TR>
			<TD background="images/vdots.gif"><IMG height=1 
			  src="images/spacer.gif" width=1 border=0></TD>
		</TR>
		<tr>
			<td align="right" width="100%">
			<table align="center" border="0" cellspacing="0" cellpadding="0" width="100%">
			<tr>
				<td>
				<table align="center" border="0" cellpadding="2" cellspacing="2" width="98%">
					<tr>
						<td colspan="2">&nbsp;</td>
					</tr>
					<tr>
						<td colspan="2"><b>Details do Usu&aacute;rio:</b></td>
					</tr>
					<tr>
						<td colspan="2">&nbsp;</td>
					</tr>
					<tr>
						<td class=f-c width="100" align="right">Nome de usu&aacute;rio:</td>
						<td><?=$rowquery['username'];?></td>
					</tr>
					<tr>
						<td class=f-c width="100" align="right">Nome:</td>
						<td><?=$rowquery['firstname'].' '.$rowquery['lastname'];?></td>
					</tr>
					<tr>
						<td class=f-c width="100" align="right">Data de Nascimento:</td>
						<td><?=str_replace("-","/",$rowquery['birth_date']);?></td>
					</tr>
					<tr>
						<td class=f-c width="100" align="right">Cidade:</td>
						<td><?=$rowquery['city'];?></td>
					</tr>
					<?
					$country=$rowquery['country'];
					$qrycou = "select * from countries";
					$rescou = mysql_query($qrycou);
					while($cou=mysql_fetch_array($rescou))
					{
						if($country==$cou["countryId"])
						{
							$country = $cou["printable_name"];
						}					
					}
					?>
					<tr>
						<td class=f-c width="100" align="right">Pa&iacute;s:</td>
						<td><?=$country;?></td>
					</tr>
					<tr>
						<td class=f-c width="100" align="right">Email:</td>
						<td><?=$rowquery['email'];?></td>
					</tr>
					<tr>
						<td class=f-c width="100" align="right">Celular:</td>
						<td><?=$rowquery['mobile_no'];?></td>
					</tr>
				</table>
				</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>
					<table align="center" border="0" cellpadding="2" cellspacing="2" width="98%">
					<tr>
						<td colspan="2"><b>Details de Bids:</b></td>
					</tr>
					<tr>
						<td colspan="2">&nbsp;</td>
					</tr>
					<tr>
						<td class="f-c" align="right" width="125">Bids Compros:</td>
						<td style="color: green;">+<b><?=UserPurchaseBid($rowquery['id'])==""?"0":UserPurchaseBid($rowquery['id']);?></b></span></td>
						
					</tr>
					<tr>
						<td class="f-c" align="right" width="125">Bonus Admin:</td>
						<td style="color: green;">+<b><?=UserAdminBid($rowquery['id'])==""?"0":UserAdminBid($rowquery['id']);?></b></td>
						
					</tr>
					<tr>
						<td class="f-c" align="right" width="125">Bonus de Indica&ccedil;&atilde;o:</td>
						<td style="color: green;">+<b><?=UserReferralBid($rowquery['id'])==""?"0":UserReferralBid($rowquery['id']);?></b></td>
						
					</tr>
					<tr>
						<td class="f-c" align="right" width="125">Bids Usados:</td>
						<td class="a"><b>-<?=UseBidStatus($rowquery['id'])?></b></td>
					</tr>
					<tr>
						<td class="f-c" align="right" width="125">Total Bids Restantes:</td>
						<td><b><?=$rowquery['final_bids']?></b></td>
						
					</tr>
				</table>	
				</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
			</tr>
<?	

// calculation for order
if($_REQUEST['order'])
{
$order=$_REQUEST['order'];
}
//calculation for page no
if(!$_GET['pgno'])
{
	$PageNo = 1;
}
else
{
	$PageNo = $_GET['pgno'];
}
?>			
			<tr>
				<td>
					<table align="center" border="0" cellpadding="2" cellspacing="2" width="98%">
					<tr>
						<td colspan="2"><b>Details:</b></td>
					</tr>
				</table>	
				</td>
			</tr>
			<tr>
				<td>
					<table align="center" border="0" cellpadding="2" cellspacing="2" width="98%">
					<tr>
						<td colspan="5">
      <TABLE cellSpacing=0 cellPadding=1 border=0>
        <TR>
          <TD><a class=la href="view_member_statistics.php?uid=<?=$_GET['uid'];?>">Todos</a></TD>
          <TD class=lg>|</TD>
          <TD><a class=la href="view_member_statistics.php?order=A&uid=<?=$_GET['uid'];?>">A</a></TD>
          <TD class=lg>|</TD>
          <TD><a class=la href="view_member_statistics.php?order=B&uid=<?=$_GET['uid'];?>">B</a></TD>
          <TD class=lg>|</TD>
          <TD><a class=la href="view_member_statistics.php?order=C&uid=<?=$_GET['uid'];?>">C</a></TD>
          <TD class=lg>|</TD>
          <TD><a class=la href="view_member_statistics.php?order=D&uid=<?=$_GET['uid'];?>">D</a></TD>
          <TD class=lg>|</TD>
          <TD><a class=la href="view_member_statistics.php?order=E&uid=<?=$_GET['uid'];?>">E</a></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="view_member_statistics.php?order=F&uid=<?=$_GET['uid'];?>">F</A></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="view_member_statistics.php?order=G&uid=<?=$_GET['uid'];?>">G</A></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="view_member_statistics.php?order=H&uid=<?=$_GET['uid'];?>">H</A></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="view_member_statistics.php?order=I&uid=<?=$_GET['uid'];?>">I</A></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="view_member_statistics.php?order=J&uid=<?=$_GET['uid'];?>">J</A></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="view_member_statistics.php?order=K&uid=<?=$_GET['uid'];?>">K</A></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="view_member_statistics.php?order=L&uid=<?=$_GET['uid'];?>">L</A></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="view_member_statistics.php?order=M&uid=<?=$_GET['uid'];?>">M</A></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="view_member_statistics.php?order=N&uid=<?=$_GET['uid'];?>">N</A></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="view_member_statistics.php?order=O&uid=<?=$_GET['uid'];?>">O</A></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="view_member_statistics.php?order=P&uid=<?=$_GET['uid'];?>">P</A></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="view_member_statistics.php?order=Q&uid=<?=$_GET['uid'];?>">Q</A></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="view_member_statistics.php?order=R&uid=<?=$_GET['uid'];?>">R</A></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="view_member_statistics.php?order=S&uid=<?=$_GET['uid'];?>">S</A></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="view_member_statistics.php?order=T&uid=<?=$_GET['uid'];?>">T</A></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="view_member_statistics.php?order=U&uid=<?=$_GET['uid'];?>">U</A></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="view_member_statistics.php?order=V&uid=<?=$_GET['uid'];?>">V</A></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="view_member_statistics.php?order=W&uid=<?=$_GET['uid'];?>">W</A></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="view_member_statistics.php?order=X&uid=<?=$_GET['uid'];?>">X</A></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="view_member_statistics.php?order=Y&uid=<?=$_GET['uid'];?>">Y</A></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="view_member_statistics.php?order=Z&uid=<?=$_GET['uid'];?>">Z</A></TD></TR></TABLE>
						</td>
					</tr>
<?
$auctionbid = "select p.name as pname,a.auctionID as aucid,a.auc_status as aucstat,Date_format(a.auc_start_date,'%d/%m/%Y') as aucstartdate,Date_format(a.auc_final_end_date,'%d/%m/%Y') as aucfinalenddate,SUM(b.bid_count) as bidtotal from bid_account b left join auction a on b.auction_id=a.auctionID left join products p on a.productID=p.productID where b.user_id='".$rowquery['id']."' and bid_flag='d' and p.name like '$order%' group by a.auctionID order by bidtotal desc";
$resauctionbid = mysql_query($auctionbid) or die(mysql_error());
$PRODUCTSPERPAGE=10;
$resauctionbid=mysql_query($auctionbid);
$total=mysql_num_rows($resauctionbid);
$totalpage=ceil($total/$PRODUCTSPERPAGE);
//echo $totalpage;
if($totalpage>=1)
{
$startrow=$PRODUCTSPERPAGE*($PageNo-1);
$auctionbid.=" LIMIT $startrow,$PRODUCTSPERPAGE";
//echo $sql;
$resauctionbid=mysql_query($auctionbid);
$totalauctionbid=mysql_num_rows($resauctionbid);
}
if(0<$totalauctionbid)
{
?>						
					<tr>
						<td>
							<TABLE width="95%" border="1" cellSpacing="0" class="t-a" align="center">
							  <TR class="th-a"> 
								<TD width="50%" nowrap="nowrap">Leil&atilde;o</TD>
								<TD align="center" width="15%" nowrap="nowrap">Data Inicial</TD>
								<TD align="center" width="15%" nowrap="nowrap">Data de Termino</TD>
								<TD align="center" width="10%" nowrap="nowrap">Status</TD>
								<TD align="center" width="10%" nowrap="nowrap">Lances Dados</TD>
								<TD width="10%" nowrap="nowrap">Status do Lance</TD>
							  </TR>
<?
						while($rowauctionbid=mysql_fetch_array($resauctionbid))
						{
?>							  
							  <TR>
								<TD align="left" valign="middle"><?=$rowauctionbid['pname']?></TD>
								<TD align="center" valign="middle">
								<?=$rowauctionbid['aucstartdate']=="00/00/0000"?"-":$rowauctionbid['aucstartdate'];?>
								</TD>
								<TD align="center" valign="middle">
								<?=$rowauctionbid['aucfinalenddate']=="00/00/0000"?"-":$rowauctionbid['aucfinalenddate'];?>
								</TD>
								<TD align="center" valign="middle">
								<?	
									if($rowauctionbid['aucstat']==1){ echo "<font color=green>Pendene</font>";}
									if($rowauctionbid['aucstat']==2){ echo "<font color=red>Iniciado</font>";}
									if($rowauctionbid['aucstat']==3){ echo "<font color=blue>Vendido</font>";}
								?></TD>
								<TD align="center" valign="middle"><?=$rowauctionbid['bidtotal'];?></TD>
								<TD align="center" valign="middle"><?=GetWonAuctionStatus($rowauctionbid['aucid'],$rowauctionbid['aucstat'],$rowquery['id'])?></TD>
							  </TR>
<?
						}
?>							  
							 </TABLE>
					  	</td>
					</tr>
					<tr>
						<td><!-- paging starts -->
		   <?php
		if($PageNo>1)
		{
                  $PrevPageNo = $PageNo-1;

	    ?>
	  <A class=paging href="view_member_statistics.php?pgno=<?=$PrevPageNo; ?>&order=<?=$order?>&uid=<?=$_GET['uid'];?>">&lt; P&aacute;gian Anterior</A>
	  <?
	   }
	  ?> &nbsp;&nbsp;&nbsp;
	  <?php
        if($PageNo<$totalpage)
        {
         $NextPageNo = 	$PageNo + 1;
      ?>
	  <A class=paging 
      id=next href="view_member_statistics.php?pgno=<?=$NextPageNo;?>&order=<?=$order?>&uid=<?=$_GET['uid'];?>">Pr&oacute;xima Pagina &gt;</A>
	  <?
       }
      ?>
		  <!-- paging ends --></td>
					</tr>
					<?
}
else
{
?>
	<tr>
		<td height="10">&nbsp;</td>
	</tr>
	<tr>
		<td>
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
		</td>
	</tr>
<?
}
?>
				</table>
					
				</td>
			</tr>
			
			</table>
			</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
	</tbody>
	</table>
	<br><br>
</body>
</html>