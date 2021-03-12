<?
	include("session.php");

	$head_tag = '<script type="text/javascript" src="js/leilao.js"></script>';
	include("header.php");
	
	if(!$_GET['pgno']){	$PageNo = 1;}else{$PageNo = $_GET['pgno'];}

	$qryselauc = "select *,p.".$lng_prefix."name as name,".$lng_prefix."short_desc as short_desc from bid_account ba left join auction a on ba.auction_id=a.auctionID left join products p on ba.product_id=p.productID left join auc_due_table adt on a.auctionID=adt.auction_id where a.auc_status='2' and adt.auc_due_time!=0 and ba.user_id=$uid group by ba.auction_id order by auc_due_time";
	$resselauc = mysql_query($qryselauc);
	$totalauc = mysql_num_rows($resselauc);
	$totalpage=ceil($totalauc/$PRODUCTSPERPAGE_MYACCOUNT);

	if($totalpage>=1){
    	$startrow=$PRODUCTSPERPAGE_MYACCOUNT*($PageNo-1);
    	$qryselauc.=" LIMIT $startrow,$PRODUCTSPERPAGE_MYACCOUNT";
    	$resselauc=mysql_query($qryselauc);
    	$totalauc=mysql_num_rows($resselauc);
	}
    require_once('leftside.php');
?>
    <div id="conteudo-conta">
				<div id="areaLeiloes" style="width:96%;"> 
						<div class="ttlPadraoHome"  style="width:100%"><div class="texto"><?=$lng_myauctionsavenue;?> - <?=$lng_aucbiddingon;?></div></div>
						<div class="leiloesAtuais">
        <? if($totalauc>0){
			while($objauc = mysql_fetch_array($resselauc)){
				include 'inc_leilao_atual.php';	
			}
		 ?>	
                  
                </div></div><!--.leiloesAtuais -->                
<div style="height: 10px;"></div>
					<div class="strip">
						<div style="padding-top: 2px;">
					<?
					if($PageNo>1)
					{
					  $PrevPageNo = $PageNo-1;
					?>
						  <A class="alink" href="myaccount_<?=$PrevPageNo; ?>.html">&lt; <?=$lng_previouspage;?></A>
					<?
						if($totalpage>2 && $totalpage!=$PageNo)
						{
					 ?>
						<span class="paging">&nbsp;|</span>
					 <?
						}
					  }
				     ?>&nbsp;
				     <?php
			 		  if($PageNo<$totalpage)
					  {
						 $NextPageNo = 	$PageNo + 1;
					  ?>
						  <A class="alink" id="next" href="myaccount_<?=$NextPageNo;?>.html"><?=$lng_nextpage;?> &gt;</A>
					  <?
					   }
					  ?>
					     </div>
					</div>	
					<?
					}
					else
					{
					?>		
					<div>&nbsp;</div>
					<div class="noauction_message" align="center"><?=$lng_notbiddingany;?></div>
					<div>&nbsp;</div>
					<?
					}
					?>

</div>
<script language="javascript" src="js/effect.js"></script>
<script language="javascript" src="js/default.js"></script>
<script language="javascript" src="js/jqModal.js"></script>
<?
	include("footer.php");
?>