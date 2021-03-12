<?
	include("session.php");

	$head_tag = '<script type="text/javascript" src="js/leilao.js"></script>';
	include("header.php");

	require_once('leftside.php'); 
?>
	<div id="conteudo-conta">

				<div id="areaLeiloes" style="width:96%;"> 
						<div class="ttlPadraoHome"  style="width:100%"><div class="texto"><?=$lng_myauctionsavenue;?> - <?=$lng_aucbiddingon;?></div></div>
						<div class="leiloesAtuais">
		<?

		$qrysel = "select *,".$lng_prefix."bidpack_name as bidpack_name,".$lng_prefix."bidpack_banner as bidpack_banner from bidpack order by id";
		$rssel = mysql_query($qrysel);
		$totalbpack = mysql_num_rows($rssel);
		if($totalbpack>0){
			$selected = ceil($totalbpack/2);
		}
				
		$qryselauc = "select *,p.".$lng_prefix."name as name,".$lng_prefix."short_desc as short_desc 
						from bid_account ba left join auction a on ba.auction_id=a.auctionID 
						left join products p on ba.product_id=p.productID 
						left join auc_due_table adt on a.auctionID=adt.auction_id 
							where a.auc_status='2' and adt.auc_due_time!=0 and ba.user_id=$uid 
						group by ba.auction_id order by auc_due_time";
		$resselauc = mysql_query($qryselauc);
		$totalauc = mysql_num_rows($resselauc);
		$totalpage=ceil($totalauc/$PRODUCTSPERPAGE_MYACCOUNT);
		if($totalpage>=1){
			$startrow=$PRODUCTSPERPAGE_MYACCOUNT*($PageNo-1);
			$qryselauc.=" LIMIT $startrow,$PRODUCTSPERPAGE_MYACCOUNT";
			$resselauc=mysql_query($qryselauc);
			$totalauc=mysql_num_rows($resselauc);
		}
		if($totalauc>0){
			while($objauc = mysql_fetch_array($resselauc)){
				include 'inc_leilao_atual.php';	
			}
		?>
						 </div></div><!--.leiloesAtuais -->
						<div class="clear"></div>              
	   <div style="height: 10px;"></div>
		<div class="strip">
			<div style="padding-top: 2px;">
				<?
				if($PageNo>1){
				$PrevPageNo = $PageNo-1;
				?>
				<A class="alink" href="myaccount_<?=$PrevPageNo; ?>.html">&lt; <?=$lng_previouspage;?></A>
				<?
				if($totalpage>2 && $totalpage!=$PageNo){
				?>
				<span class="paging">&nbsp;|</span>
				<?
				}
				}
				?>&nbsp;
				<?php
				if($PageNo<$totalpage){
				$NextPageNo = $PageNo + 1;
				?>
				<A class="alink" id="next" href="myaccount_<?=$NextPageNo;?>.html"><?=$lng_nextpage;?> &gt;</A>
				<?
				}
				?>
			</div>
		</div>	
		<?
		}else{
		?>		
		<div>&nbsp;</div>
		<div class="noauction_message" align="center"><?=$lng_notbiddingany;?></div>
		<div>&nbsp;</div>
		<?
		}
		?>

<!-- comprar creditos -->
		<h3 id="comprar-tit"><?=$lng_myauctionsavenue;?> - <?=$lng_tabbuybids;?></h3>
		<ul id="pacotes">
		<?
			$i = 1;
			$a = 1;
			while($obj = mysql_fetch_array($rssel)){
				$bname = $obj["bidpack_name"];
			$Item++;
		?>
<div id="pacotes">
	<div class="bidpackimage" style="width:260px; float:left"><img src="uploads/bidpack/<?=$obj["bidpack_banner"];?>" border="0" /></div>
	<span class="pacote-escolha"><p>
		<span class="pacote-escolha-tit"><? echo $obj['bidpack_name'];?></span>
		<span class='pacote-escolha-info'><b><? echo $obj['bid_size']." Lances / ".$Currency.$obj['bid_price'] ;?></b></span>
		<form name="payment_<? echo $Item;?>" action="buybidspayment.php" method="post">
			<span class="finalizar-compra-bt">
				<input name="cnfbuybids" value="" type="image" src="imagens/comprarlances.gif" 
					width="115" height="54" hspace="0" vspace="0" border="0" 
					onmouseover="this.style.margin='-27px 0 0 0'" 
					onmouseout="this.style.margin='0 0 0 0'" />
			</span>
			<input type="hidden" name="acao" value="cl" />
			<input type="hidden" name="bpid" value="<?=base64_encode($obj['id']);?>" />
		</form>                 
	</span>
</div> <!-- Fim pacotes -->
<hr style="border:1px solid; margin:10px 0;" />

	<? } ?>
		</ul>



	</div>
<script language="javascript" src="js/jquery.js"></script>
<script language="javascript" src="js/effect.js"></script>
<script language="javascript" src="js/default.js"></script>
<script language="javascript" src="js/jqModal.js"></script>
<?
	include("footer.php");
?>