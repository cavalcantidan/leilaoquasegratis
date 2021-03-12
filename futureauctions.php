<?
$total_per_ini3 = 10;
$max_pages3=100;
$items_per_page3 = 5;

	if($_GET["aid"]!=""){$id=$_GET["aid"];}
	if($_GET["id"]!=""){$id=$_GET["id"];}
	$PRODUCTSPERPAGE3 = 1;
		if(!$_GET['pgno3'])
		{
			$PageNo3 = 1;
		}
		else
		{
			$PageNo3 = $_GET['pgno3'];
		}
		//QUery First
		if($_GET["aid"]==1)
		{
		$qryselC3 = "select count(*) as total3 from auction a left join products p on a.productID=p.productID  left join categories c on p.categoryID=c.categoryID where a.auc_status=".$id;
		}
		else
		{
		$qryselC3 = "select count(*) as total3 from auction a left join products p on a.productID=p.productID left join categories c on p.categoryID=c.categoryID where a.auc_status=1 and a.categoryID='".$id."'";
		}
		$resultC3=mysql_query($qryselC3) or die ("1:====".mysql_error());
		$rowC3 = mysql_fetch_array($resultC3);
		$newpage3 = 1;	
	
		if($PageNo3 == 1){
			$newpage3 = '' ;	
			$inc3 =  $PageNo3.$newpage3;
			$newinc3 = $items_per_page3;
		}else{
			$nxtpage3 = $PageNo3 -1 ;
			$inc3 =  $nxtpage3.$newpage3;
			$newinc3 = $inc3 + 9;
		}
		$totalC3 = $rowC3['total3'];
		//echo "TotalC3".$totalC3;
		//echo "<br>";
		
		$from3 = ($PageNo3-1)*$items_per_page3;
		//End Query First
		if($_GET["aid"]==1)
		{
		$qrysel3 = "select *, p.".$lng_prefix."name as prdname,".$lng_prefix."short_desc as short_desc from auction a left join products p on a.productID=p.productID  left join categories c on p.categoryID=c.categoryID where a.auc_status=".$id;
		}
		else
		{
		$qrysel3 = "select *, c.".$lng_prefix."name as catname, p.".$lng_prefix."name as prdname,".$lng_prefix."short_desc as short_desc from auction a left join products p on a.productID=p.productID left join categories c on p.categoryID=c.categoryID where a.auc_status=1 and a.categoryID='".$id."'";
		}
		$qrysel3 .= " limit $from3, $items_per_page3";
		//echo $qrysel3;
		//echo "<br>";
		$ressel3=mysql_query($qrysel3) or die ("2:====".mysql_error());
		$totalrecords3 = mysql_num_rows($ressel3);
		//$answers = $rs->getrows();
		
		$start_num3 = $from3 + 1;
		$end_num3 = $from3 + $totalrecords3;
		/*$ressel3 = mysql_query($qrysel3);
		$total3 = mysql_num_rows($ressel3);
		$totalpage3=ceil($total3/$PRODUCTSPERPAGE3);

		if($totalpage3>=1)
		{
		$startrow3=$PRODUCTSPERPAGE3*($PageNo3-1);
		$qrysel3.=" LIMIT $startrow3,$PRODUCTSPERPAGE3";
		//echo $qrysel3;
		$ressel3=mysql_query($qrysel3);
		$total3=mysql_num_rows($ressel3);
		}*/
		//QUery Third
		if($_GET["aid"]==1)
		{
		$qryselC3 = "select count(*) as total3 from auction a left join products p on a.productID=p.productID  left join categories c on p.categoryID=c.categoryID where a.auc_status=".$id;
		}
		else
		{
		$qryselC3 = "select count(*) as total3 from auction a left join products p on a.productID=p.productID left join categories c on p.categoryID=c.categoryID where a.auc_status=1 and a.categoryID='".$id."'";
		}
		$total_results3 = mysql_result(mysql_query("$qryselC3"),0);
		if (ceil($total_results3 / $items_per_page3) < $total_per_ini3)
		{
			$no_of_page_numbers3 = ceil($total_results3 / $items_per_page3);
		}
		else
		{
			$no_of_page_numbers3 = $total_per_ini3;
		}
		// Figure out the total number of pages. Always round up using ceil()
		$nextval3 = $PageNo3+$total_per_ini3;
		$total_pages3 = ceil($total_results3 / $items_per_page3);
		if($total_pages3>=$nextval3)
		{
			$start3 = $PageNo3;
			$stop3 = $nextval3;
		}
		elseif($total_pages3<$nextval3)
		{
			if($total_pages3>$total_per_ini3)
			{
				$start3 = $total_pages3-$total_per_ini3+1;
				$stop3 = $total_pages3+1;		
			}
			else
			{
				$start3 = 1;
				$stop3 = $total_pages3+1;
			}
		}
		$max3 = $stop3;
		//Query End Third
		//echo "Start3".$start3;
		//echo "<br>";
		//echo "max3".$max3;
		
?>
<a name="FutureAuction" id="FutureAuction"></a>
<h3 id="conta-tit"><?=$lng_futureaucs;?></h3>


<?
if($totalC3>0){
?>
			<div class="H_beit">
				<div class="h_beit_image"><?=$lng_image;?></div>
				<div class="h_beit_desc"><?=$lng_description;?></div>
				<div class="h_beit_price"><?=$lng_price;?></div>
				<div class="h_beit_bidder"><?=$lng_bidder;?></div>
				<!--div class="h_beit_countdown"><?=$lng_countdown;?></div-->
			</div>
		   <?
			  $i = 1;
			  $arr = "";	
			  while($obj = mysql_fetch_array($ressel3))
				{
		   ?>
		<div class="descripton_box"> 
				<div class="decription">
						<div class="body_inner_img" style="padding: 0px; width: 155px;"><div style="float: left; clear:both; padding-left: 15px; padding-top:9px;"><a href="auction_<?=str_replace(" ","_",strtolower(stripslashes($obj["prdname"])));?>_<?=$obj["auctionID"];?>.html"><img src="uploads/products/thumbs_big/thumbbig_<?=$obj["picture1"];?>" border="0" /></a></div><div style="float: left; padding-top: 14px; width: 153px;"><img src="<?=$lng_imagepath;?>zoom1.jpg" align="left" border="0" /><img src="<?=$lng_imagepath;?>zoom2.jpg" align="right" border="0" onclick="javascript: hidedisplayzoom('prd_image_large_<?=$obj['auctionID'];?>');" style="cursor: pointer;"/></div></div>
                      <div class="auction_decri" style="width: 400px;"><span style="font-size:12px; color:#000000;"><a href="auction_<?=str_replace(" ","_",strtolower(stripslashes($obj["prdname"])));?>_<?=$obj["auctionID"];?>.html" class="black_link"><?=stripslashes($obj["prdname"]);?></a></span><br />
							<br />
							<? echo stripslashes(choose_short_desc($obj["short_desc"],165));?><a href="auction_<?=str_replace(" ","_",strtolower(stripslashes($obj["prdname"])));?>_<?=$obj["auctionID"];?>.html" class="black_link"><?=$lng_linkmore;?></a>
						</div>
                      <div class="auction_price">
                            <span class="price" style="font-size:15px; font-weight: bold;" id="price_index_page_<?=$obj["auctionID"];?>">
                                <?=$Currency.str_replace(".",",",$obj["auc_start_price"]);?>
                            </span>
							<br /><?=$lng_insteadof;?><?=$Currency.str_replace(".",",",$obj["price"]);?>)
                      </div>
                      <div class="auction_bidder">
						<span id="product_bidder_<?=$obj["auctionID"];?>"><?=date('d/m/Y', strtotime($obj["auc_start_date"])).'<br /> as '.date('H:i:s', strtotime($obj["auc_start_time"]));?></span>				  
					  </div>
                      <div class="auction_countdown">
					  
            <? if($_SESSION["userid"]==""){ ?>
            <div class="btnLogin"><a href="" class="btnLogin" onclick="javascript:abreMenuLogin();return false;"></a></div>
            <? } else { ?>
            <div class="btnLance"><a href="" onclick="javascript:inserirLance(<?=$objauc["auctionID"];?>);return false;"></a></div>  
            <? } ?>
                      </div>
  		</div>
		</div>		
					<div id="prd_image_large_<?=$obj['auctionID'];?>" style="width: 360px; height:330px; background-color: #FFFFFF; border: 2px solid; position:absolute; float:left; margin-top: -108px; margin-left: 170px; display: none;">
						<div style="height: 25px; text-align: right; width: 350px;"><img src="<?=$lng_imagepath;?>btn_closezoom.png" onclick="closezoomimage('prd_image_large_<?=$obj['auctionID'];?>')" style="cursor: pointer"/></div>
					<div id="cleaner"></div>
					<div class="zoomimagemargin">
					<img src="uploads/products/<?=$obj["picture1"];?>" style="padding-left: 5px;"/>
					</div>
					</div>					
			 <div id="cleaner"></div>
		<?
				}
		?>	
				<div class="H_beit_full" align="center">
				  <div style="padding-top: 3px;">
								<? if($PageNo3>1){ ?>
                                      <? $npage3 = $PageNo3-1;
									  	if($_GET['aid']==1)
										{
									  ?>
                                      <span class="paging_page"><a class="page_link" href="all_future_auctions_<?=$_GET['aid'];?>_1_FutureAuction.html" style="text-decoration: none;">&lt;&lt; </a></span> <span class="style8"><a class="page_link" href="all_future_auctions_<?=$_GET['aid'];?>_<?=$npage3;?>_FutureAuction.html" style="text-decoration: none;">&lt; </a></span>
                                      <?
									  	}
										else
										{
										?>
                                      <span class="paging_page"><a class="page_link" href="all_auctions_<?=$id?>_1_FutureAuction.html" style="text-decoration: none;">&lt;&lt; </a></span> <span class="style8"><a class="page_link" href="all_auctions_<?=$id?>_<?=$npage3;?>_FutureAuction.html" style="text-decoration: none;">&lt; </a></span>
                                      <?
										} 
									  }else{?>
                                      <span class="paging_page">&lt;&lt; </span> <span  class="paging_page"> &lt; </span>
                                      <? }?>
                                      <span  class="paging_page">
									  <? for($j=$start3;$j<$max3;$j++)
									  {
										if($j==$PageNo3)
										{
									  ?>
										| <span class="paging_page"><?=$j?></span>
									 <? }
										else
										{
											if($_GET['aid']==1)
											{
									?>	
											<span class="paging_page"> | <a class="page_link" href="all_future_auctions_<?=$_GET['aid'];?>_<?=$j;?>_FutureAuction.html" style="text-decoration: none;"><?=$j;?></a></span>
									<?	
											}
											else
											{
									?>	
											<span class="paging_page"> | <a class="page_link" href="all_auctions_<?=$id?>_<?=$j;?>_FutureAuction.html" style="text-decoration: none;"><?=$j;?></a></span>
									<?		
											}	
										} 
									  } ?>
                                      <? if($PageNo3 < $total_pages3){?>
                                      <? $npage3 = $PageNo3+1;
									  	if($_GET['aid']==1)
										{
									  ?>
                                      <span class="paging_page"> |<a class="page_link" href="all_future_auctions_<?=$_GET['aid'];?>_<?=$npage3;?>_FutureAuction.html" style="text-decoration: none;"> &gt;</a></span> <a class="page_link" href="all_future_auctions_<?=$_GET['aid'];?>_<?=$total_pages3;?>_FutureAuction.html" style="text-decoration: none;"> &gt;&gt; </a>
                                      <? }
									     else
									  	 {
										?>
                                       <span  class="paging_page"> |<a class="page_link" href="all_auctions_<?=$id?>_<?=$npage3;?>_FutureAuction.html" style="text-decoration: none;"> &gt;</a></span> <a class="page_link" href="all_auctions_<?=$id?>_<?=$total_pages3;?>_FutureAuction.html" style="text-decoration: none;"> &gt;&gt; </a>
                                      <? 
										 }	
									  
									  }else{?>
                                      | &gt; &gt;&gt;
                                      <? }?>
                                      </span>
		
			<?
					}
					else
					{
			?>
		<div class="noauction_message" align="center"><? if($_GET["id"]!="") {  echo $lng_nofutureauctioncat; } else { echo $lng_nofutureauction; } ?></div>
	 	<div style="height: 15px;">&nbsp;</div>
<?
		}
?>
 </div>

 <div class="openAuction_bar_bottom">
	<div class="openAuction_leftcorner"></div>
	<div class="openAuction_bar_middle"></div>
	<div class="openAuction_rightcorner"></div>
 </div>
