<?
	include("config/connect.php");
	include("session.php");
	include("functions.php");
	$uid = $_SESSION["userid"];


	$PageNo = 1;
	if($_GET['pgno']) $PageNo = $_GET['pgno'];
	
	$qrysel = "select *,".$lng_prefix."credit_description as credit_description 
               from bid_account ba left join bidpack b on ba.bidpack_id=b.id 
               where user_id=$uid and ba.bid_flag='c' order by ba.id desc";
	$rssel = mysql_query($qrysel);
	$total = mysql_num_rows($rssel);
	$totalpage=ceil($total/$PRODUCTSPERPAGE_MYACCOUNT);

	if($totalpage>=1){
	    $startrow=$PRODUCTSPERPAGE_MYACCOUNT*($PageNo-1);
	    $qrysel.=" LIMIT $startrow,$PRODUCTSPERPAGE_MYACCOUNT";
	    $rssel=mysql_query($qrysel);
	    $total=mysql_num_rows($rssel);
	}
	
	$PageNo1 = 1;
	if($_GET['pgNo']) $PageNo1 = $_GET['pgNo'];

	$qrysel1 = "select *,sum(ba.bid_count) as bidcount, a.auc_status as aucstatus,".$lng_prefix."short_desc as short_desc,".$lng_prefix."name as name 
                from bid_account ba left join products p on ba.product_id=p.productID 
                left join auction a on ba.auction_id=a.auctionID 
                where user_id='$uid' and bidding_type!='m' and (ba.bid_flag='d' or ba.bid_flag='b') 
                group by ba.auction_id order by ba.id desc";
	$rssel1 = mysql_query($qrysel1);
	$total1 = mysql_num_rows($rssel1);
	$totalpage1=ceil($total1/$PRODUCTSPERPAGE_MYACCOUNT);
	
	if($totalpage1>=1){
	    $startrow=$PRODUCTSPERPAGE_MYACCOUNT*($PageNo1-1);
	    $qrysel1.=" LIMIT $startrow,$PRODUCTSPERPAGE_MYACCOUNT";
	    $rssel1=mysql_query($qrysel1);
	    $total1=mysql_num_rows($rssel1);
	}

?>
<script language="javascript" type="text/javascript" src="js/function.js"></script>

<?
	include("header.php");
    include("leftside.php"); 
?>
<div id="conteudo-conta">
<h3 class="historico-tit"><?=$lng_myauctionsavenue;?> - <?=$lng_purchasebids;?></h3>
			<?
			if($total!=0){
				$i = 1;
                ?>
                <table width="100%" cellpadding="2px" border="1" class="results">
                    <tr><th>Data de lan&ccedil;amento</th><th>Descri&ccedil;&atilde;o:</th><th>Quantidade:</th></tr>
                <?
				while($obj = mysql_fetch_array($rssel)){
					$date = substr($obj["bidpack_buy_date"],0,10);
				?>
                    <tr>
                        <td><?=arrangedate($date)."</span> - ".substr($obj["bidpack_buy_date"],11);?></td>
                        <td><?=$obj["credit_description"];?></td>
                        <td>
                        <? if($obj["bid_count"]>0){ ?>
	                        <font color="#00CC33"><b>+<?=$obj["bid_count"];?></b></font>
                        <? }else{ ?>
	                        <font color="#CC3300"><b><?=$obj["bid_count"];?></b></font>
                        <? } ?>
                        </td>
                    </tr>
                
				<? $i++;
				}
				?>
                </table>
					<div class="strip">
						<div style="padding-top: 2px;">
					<?
					if($PageNo>1){
					  $PrevPageNo = $PageNo-1;
					?>
						  <A class="alink" href="bid_history_<?=$PrevPageNo; ?>.html">&lt; <?=$lng_previouspage;?></A>
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
						 $NextPageNo = 	$PageNo + 1;
					  ?>
						  <A class="alink" id="next" href="bid_history_<?=$NextPageNo;?>.html"><?=$lng_nextpage;?> &gt;</A>
					  <?
					   }
					  ?>
					     </div>
					</div>	
			<?
			}
			?>
            
            
		   <?
				if($total1!=0){
		   ?>
    <h3 class="historico-tit"><?=$lng_myauctionsavenue;?> - <?=$lng_historybids;?></h3>
        <table width="100%" cellpadding="2px" border="1" class="results">
            <tr><th>Imagem</th><th>Descri&ccedil;&atilde;o:</th><th>Data</th><th>Situa&ccedil;&atilde;o</th><th>Lances</th></tr>
        <?
			$i=1;
			while($obj1 = mysql_fetch_array($rssel1)){
				$startdate = substr($obj1["auc_start_date"],0,10);
				if($obj1["aucstatus"]==1){ $status=$lng_bidfutureauction; } 
				elseif($obj1["aucstatus"]==2){ $status=$lng_bidliveauction; } 
				elseif($obj1["aucstatus"]==3){ $status=$lng_ended; } 
		?>
            <tr>
                <td>
                <a href="auction_<?=str_replace(" ","_",strtolower($obj1["name"]));?>_<?=$obj1["auctionID"];?>.html" > 
                    <img src="uploads/products/thumbs/thumb_<?=$obj1["picture1"];?>" style="border: medium none ;">
                </a>
                </td>
                <td>
                <a href="auction_<?=str_replace(" ","_",strtolower($obj1["name"]));?>_<?=$obj1["auctionID"];?>.html" class="lm-produto2">
                    <?=stripslashes($obj1["name"]);?>
                </a>
                </td>
                <td><span><?=arrangedate($startdate);?></span></td>
                <td><?=$status;?></td>
                <td><span class="red-text-12-b">-<?=getTotalPlaceBids($obj1["auctionID"]);?></span></td>
            </tr>

		    <? //getBidHistory($obj1["auctionID"],$uid) 
				}
			?>
        </table>
						 <p class="lm-paginacao">
					  <?
					  if($PageNo1>1)
					  {
					    $PrevPageNo1 = $PageNo1-1;
				 	  ?>
						 <A class="lm-anterior" href="bid_history_<?=$PrevPageNo1;?>_N.html">&lt; <?=$lng_previouspage;?></A>
					  <?
						if($totalpage1>2 && $totalpage1!=$PageNo1)
						{
					  ?>
						<span class="paging">&nbsp;|</span>
					  <?
							}
					   }
					  ?>&nbsp;
					  <?php
					  if($PageNo1<$totalpage1)
					  {
						 $NextPageNo1 =	$PageNo1 + 1;
					  ?>
					  <A class="lm-proxima" href="bid_history_<?=$NextPageNo1;?>_N.html"><?=$lng_nextpage;?> &gt;</A>
					  <?
					   }
					  ?>
					 </p>

                    
                    <?
			}
			else
			{
		    ?>
<h3 class="historico-tit"><?=$lng_myauctionsavenue;?></h3>
<p><?=$lng_donthaveanybid;?></p>
			<?
			}
			?>			

<!--                                          -->
			</div>

<?
	include("footer.php");
?>		
</div>
</body>
</html>
