<?


	if($_GET["aid"]!=""){$id=$_GET["aid"];}
	if($_GET["id"]!=""){$id=$_GET["id"];}
	//$PRODUCTSPERPAGE2 = 1;
		if(!$_GET['pgno2'])
		{
			$PageNo2 = 1;
		}
		else
		{
			$PageNo2 = $_GET['pgno2'];
		}
		//QUery First
		if($_GET["aid"]==3)
		{
		$qryselC2 = "select Count(*) as total2 from auction a left join products p on a.productID=p.productID  left join categories c on p.categoryID=c.categoryID left join registration r on r.id=a.buy_user where a.auc_status=".$id." order by a.auctionID desc";
		}
		else
		{
		$qryselC2 = "select Count(*) as total2 from auction a left join products p on a.productID=p.productID left join categories c on p.categoryID=c.categoryID  left join registration r on r.id=a.buy_user where a.auc_status=3 and a.categoryID='".$id."' order by a.auctionID desc";
		}
		$resultC2=mysql_query($qryselC2) or die ("1:====".mysql_error());
		$rowC2 = mysql_fetch_array($resultC2);
		$newpage2 = 1;	
	
		if($PageNo2 == 1){
			$newpage2 = '' ;	
			$inc2 =  $PageNo2.$newpage2;
			$newinc2 = $items_per_page2;
		}else{
			$nxtpage2 = $PageNo2 -1 ;
			$inc2 =  $nxtpage2.$newpage2;
			$newinc2 = $inc2 + 9;
		}
		$totalC2 = $rowC2['total2'];
		//echo "TotalC3".$totalC3;
		//echo "<br>";
		
		$from2 = ($PageNo2-1)*$items_per_page2;
		//End Query First
		if($_GET["aid"]==3)
		{
		$qrysel2 = "select *, p.".$lng_prefix."name as prdname,".$lng_prefix."short_desc as short_desc from auction a left join products p on a.productID=p.productID  left join categories c on p.categoryID=c.categoryID left join registration r on r.id=a.buy_user where a.auc_status=".$id." order by a.auc_final_end_date desc";
		}
		else
		{
		$qrysel2 = "select *, c.".$lng_prefix."name as catname, p.".$lng_prefix."name as prdname,".$lng_prefix."short_desc as short_desc from auction a left join products p on a.productID=p.productID left join categories c on p.categoryID=c.categoryID  left join registration r on r.id=a.buy_user where a.auc_status=3 and a.categoryID='".$id."' order by a.auc_final_end_date desc";
		}
		$qrysel2 .= " limit $from2, $items_per_page2";
		//echo $qrysel3;
		//echo "<br>";
		$ressel2=mysql_query($qrysel2) or die ("2:====".mysql_error());
		$totalrecords2 = mysql_num_rows($ressel2);
		//$answers = $rs->getrows();
		
		$start_num2 = $from2 + 1;
		$end_num2 = $from2 + $totalrecords2;
		/*$ressel2 = mysql_query($qrysel2);
		$total2 = mysql_num_rows($ressel2);
		$totalpage2=ceil($total2/$PRODUCTSPERPAGE2);

		if($totalpage2>=2)
		{
		$startrow2=$PRODUCTSPERPAGE2*($PageNo2-1);
		$qrysel2.=" LIMIT $startrow2,$PRODUCTSPERPAGE2";
		//echo $qrysel2;
		$ressel2=mysql_query($qrysel2);
		$total2=mysql_num_rows($ressel2);
		}*/
		//QUery Third
		if($_GET["aid"]==3)
		{
		$qryselC2 = "select Count(*) as total2 from auction a left join products p on a.productID=p.productID  left join categories c on p.categoryID=c.categoryID left join registration r on r.id=a.buy_user where a.auc_status=".$id." order by a.auctionID desc";
		}
		else
		{
		$qryselC2 = "select Count(*) as total2 from auction a left join products p on a.productID=p.productID left join categories c on p.categoryID=c.categoryID  left join registration r on r.id=a.buy_user where a.auc_status=3 and a.categoryID='".$id."' order by a.auctionID desc";
		}
		$total_results2 = mysql_result(mysql_query("$qryselC2"),0);
		if (ceil($total_results2 / $items_per_page2) < $total_per_ini2)
		{
			$no_of_page_numbers2 = ceil($total_results2 / $items_per_page2);
		}
		else
		{
			$no_of_page_numbers2 = $total_per_ini2;
		}
		// Figure out the total number of pages. Always round up using ceil()
		$nextval2 = $PageNo2+$total_per_ini2;
		$total_pages2 = ceil($total_results2 / $items_per_page2);
		if($total_pages2>=$nextval2)
		{
			$start2 = $PageNo2;
			$stop2 = $nextval2;
		}
		elseif($total_pages2<$nextval2)
		{
			if($total_pages2>$total_per_ini2)
			{
				$start2 = $total_pages2-$total_per_ini2+1;
				$stop2 = $total_pages2+1;		
			}
			else
			{
				$start2 = 1;
				$stop2 = $total_pages2+1;
			}
		}
		$max2 = $stop2;
?>
<a name="EndedAuction" id="EndedAuction"></a>
<h3 id="conta-tit">Listando todos os Leiloes arrematados</h3>
		<?
		if($totalC2>0)
		{
		?>
					   <?
						  $i = 1;
						  while($obj = mysql_fetch_array($ressel2))
							{
								$qrybid = "select *,sum(bid_count) as bidcount from bid_account where bid_flag='d' and auction_id=".$obj['auctionID']." and user_id=".$obj["buy_user"]." group by auction_id";
								$resbid = mysql_query($qrybid);
								$total = mysql_num_rows($resbid);
								$objbid = mysql_fetch_object($resbid);
								$totbid = $objbid->bidcount; 
								$totbidprice = $totbid * 0.50;
					
								$price = $obj["price"];
								if($obj["fixedpriceauction"]==1) { $fprice = $obj["auc_fixed_price"];}
								elseif($obj["offauction"]==1) { $fprice = "0.01"; }
								else { $fprice = $obj["auc_final_price"];}
								$saving_price = $price-$totbidprice-$fprice;
								$saving_percent = ($saving_price*100/$price);
						?>
<div class="leilao-f-conteudo">
							<!-- foto -->
<span class="lm-titulos" style="top:-16px; left:7px;"><span class="lm-sombra"></span><span class="lm-titulo">Imagem</span></span>
<span class="lm-foto"><a href="auction_<?=str_replace(" ","_",strtolower(stripslashes($obj["prdname"])));?>_<?=$obj["auctionID"];?>.html"><img src="uploads/products/thumbs_big/thumbbig_<?=$obj["picture1"];?>" width="120" height="110" border="0" /></a></span>


<!-- descricao -->
<div class="lf-descricao"><span class="lm-titulos" style="top:-16px; left:0;"><span class="lm-sombra"></span><span class="lm-titulo">Produto</span></span>
<a href="auction_<?=str_replace(" ","_",strtolower(stripslashes($obj["prdname"])));?>_<?=$obj["auctionID"];?>.html" class="lm-produto"><?=stripslashes($obj["prdname"]);?></a></p>
</div>

<!-- leilao -->
<div class="lf-info-lance">
<span class="lm-titulos" style="top:-16px; left:0;"><span class="lm-sombra"></span><span class="lm-titulo">Leil&atilde;o:</span></span>
<p class="lf-preco-loja" >Na loja custa <?=$Currency.$obj["price"];?></p>
<p class="lf-arremate">Foi arrematado por<span id="price_index_page_<?=$obj["auctionID"];?>"><?=$Currency.$obj["auc_final_price"];?></span></p>
<p class="lf-hora">FINALIZADO AS <?=substr($obj["auc_final_end_date"],10);?></p>
</div>

<!-- vencedor -->
<div class="lf-vencedor">
<span class="lm-titulos" style="top:-16px; left:0;"><span class="lm-sombra"></span><span class="lm-titulo">Vencedor:</span></span>
<p>Parab&eacute;ns, <span id="product_bidder_<?=$obj["auctionID"];?>" class="lf-nome-vencedor"><?=$obj["username"]!=""?$obj["username"]:"---";?>.</span></p>
<?
////////////////////////////////////////////////////////////////////////////////////
$preco = $obj["price"];
$FatorDivisor = $preco / 100;
$vlEconomia = $preco - $obj["auc_final_price"];
$valorEconomia = $vlEconomia / $FatorDivisor;
////////////////////////////////////////////////////////////////////////////////////
?>
<p>Arrematou este produto<br /><span class="lf-desconto"><?=number_format($valorEconomia,2)."%";?></span> mais barato que na loja.</p>
</div>

<!-- / leilao-f-conteudo -->
</div>
<div style="height:10px;"></div>
						<?
								$i++;
							}
						?>
<p class="lm-paginacao">
							<? if($PageNo2>1){ ?>
                                      <? $npage2 = $PageNo2-1;
									  	if($_GET['aid']==3)
										{
									  ?>
                                      <span class="paging_page"><a class="page_link" href="all_ended_auctions_<?=$_GET['aid'];?>_1_EndedAuction.html" style="text-decoration: none;">&lt;&lt; </a></span> <span class="style8"><a class="page_link" href="all_ended_auctions_<?=$_GET['aid'];?>_<?=$npage2;?>_EndedAuction.html" style="text-decoration: none;">&lt; </a></span>
                                      <?
									  	}
										else
										{
										?>
                                      <span  class="paging_page"><a class="page_link" href="all_auctions_<?=$id?>_1_EndedAuction.html" style="text-decoration: none;">&lt;&lt; </a></span> <span class="style8"><a class="page_link" href="all_auctions_<?=$id?>_<?=$npage2;?>_EndedAuction.html" style="text-decoration: none;">&lt; </a></span>
                                      <?
										} 
									  }else{?>
                                      <span class="paging_page">&lt;&lt; </span> <span class="paging_page"> &lt; </span>
                                      <? }?>
                                      <span class="paging_page">
									  <? for($j=$start2;$j<$max2;$j++)
									  {
										if($j==$PageNo2)
										{
									  ?>
										| <span class="paging_page"><?=$j?></span>
									 <? }
										else
										{
											if($_GET['aid']==3)
											{
									?>	
											<span class="paging_page"> | <a class="page_link" href="all_ended_auctions_<?=$_GET['aid'];?>_<?=$j;?>_EndedAuction.html" style="text-decoration: none;"><?=$j;?></a></span>
									<?	
											}
											else
											{
									?>	
											<span class="paging_page"> | <a class="page_link" href="all_auctions_<?=$id?>_<?=$j;?>_EndedAuction.html" style="text-decoration: none;"><?=$j;?></a></span>
									<?		
											}	
										} 
									  } ?>
                                      <? if($PageNo2 < $total_pages2){?>
                                      <? $npage2 = $PageNo2+1;
									  	if($_GET['aid']==3)
										{
									  ?>
                                      <span  class="paging_page"> |<a class="page_link" href="all_ended_auctions_<?=$_GET['aid'];?>_<?=$npage2;?>_EndedAuction.html" style="text-decoration: none;"> &gt;</a></span> <a class="page_link" href="all_ended_auctions_<?=$_GET['aid'];?>_<?=$total_pages2;?>_EndedAuction.html" style="text-decoration: none;"> &gt;&gt; </a>
                                      <? }
									     else
									  	 {
										?>
                                       <span class="paging_page"> |<a class="page_link" href="all_auctions_<?=$id?>_<?=$npage2;?>_EndedAuction.html" style="text-decoration: none;"> &gt;</a></span> <a class="page_link" href="all_auctions_<?=$id?>_<?=$total_pages2;?>_EndedAuction.html" style="text-decoration: none;"> &gt;&gt; </a>
                                      <? 
										 }	
									  
									  }else{?>
                                      | &gt; &gt;&gt;
                                      <? }?>
                                      </span>
</p>					
		<?
		}
		else
		{
		?>
				<div style="height: 15px;">&nbsp;</div>
				<div align="center" class="noauction_message"><? if($_GET["id"]!="") { echo $lng_noendedauctioncat; } else { echo $lng_noendedauction; } ?></div>
				<div style="height: 15px;">&nbsp;</div>
		<?
		}
		?>
 </div>