<?
	if($searchdata!="" || $_GET["st"]!="")
	{
		if($_GET["st"]!="")
		{
			$searchdata = $_GET["st"];
		}
		$total_per_ini = 10;
		$max_pages=100;
		$items_per_page = 5;
		
			if($_GET["aid"]!=""){$id=$_GET["aid"];}
			if($_GET["id"]!=""){$id=$_GET["id"];}
				if(!$_GET['pgno'])
				{
					$PageNo = 1;
				}
				else
				{
					$PageNo = $_GET['pgno'];
				}
				//QUery First
					$qryselC1 = "select count(*) as total from auction a left join products p on a.productID=p.productID left join categories c on p.categoryID=c.categoryID left join auc_due_table adt on a.auctionID=adt.auction_id where a.auc_status='2' and p.".$lng_prefix."name like '%".$searchdata."%' order by adt.auc_due_time";
				$resultC1=mysql_query($qryselC1) or die ("1:====".mysql_error());
				$rowC1 = mysql_fetch_array($resultC1);
				$newpage = 1;	
			
				if($PageNo == 1){
					$newpage = '' ;	
					$inc =  $PageNo.$newpage;
					$newinc = $items_per_page;
				}else{
					$nxtpage = $PageNo -1 ;
					$inc =  $nxtpage.$newpage;
					$newinc = $inc + 9;
				}
				$totalC1 = $rowC1['total'];
				
				$from = ($PageNo-1)*$items_per_page;
				//End Query FIrst
				$qrysel1 = "select *, c.".$lng_prefix."name as catname, p.".$lng_prefix."name as prdname,".$lng_prefix."short_desc as short_desc from auction a left join products p on a.productID=p.productID left join categories c on p.categoryID=c.categoryID left join auc_due_table adt on a.auctionID=adt.auction_id where a.auc_status=2 and p.".$lng_prefix."name like '%".$searchdata."%' order by adt.auc_due_time";
				$qrysel1 .= " limit $from, $items_per_page";
			
				$ressel1=mysql_query($qrysel1) or die ("2:====".mysql_error());
				$totalrecords = mysql_num_rows($ressel1);
				//$answers = $rs->getrows();
				
				$start_num = $from + 1;
				$end_num = $from + $totalrecords;
				
				//QUery Third
					$qryselC1 = "select count(*) as total from auction a left join products p on a.productID=p.productID left join categories c on p.categoryID=c.categoryID left join auc_due_table adt on a.auctionID=adt.auction_id where a.auc_status=2 and p.".$lng_prefix."name like '%".$searchdata."%' order by adt.auc_due_time";
				$total_results = mysql_result(mysql_query("$qryselC1"),0);	
				//QUery Fourth
				
				/*$ressel1 = mysql_query($qrysel1);
				$total1 = mysql_num_rows($ressel1);
				$totalpage1=ceil($total1/$PRODUCTSPERPAGE);
		
				if($totalpage1>=1)
				{
				$startrow=$PRODUCTSPERPAGE*($PageNo-1);
				$qrysel1.=" LIMIT $startrow,$PRODUCTSPERPAGE";
				//echo $sql;
				$ressel1=mysql_query($qrysel1);
				$total1=mysql_num_rows($ressel1);
				}*/
				
				//New Paging
				if (ceil($total_results / $items_per_page) < $total_per_ini)
				{
					$no_of_page_numbers = ceil($total_results / $items_per_page);
				}
				else
				{
					$no_of_page_numbers = $total_per_ini;
				}
				// Figure out the total number of pages. Always round up using ceil()
				$nextval = $PageNo+$total_per_ini;
				$total_pages = ceil($total_results / $items_per_page);
				if($total_pages>=$nextval)
				{
					$start = $PageNo;
					$stop = $nextval;
				}
				elseif($total_pages<$nextval)
				{
					if($total_pages>$total_per_ini)
					{
						$start = $total_pages-$total_per_ini+1;
						$stop = $total_pages+1;		
					}
					else
					{
						$start = 1;
						$stop = $total_pages+1;
					}
				}
				$max = $stop;
				//End New page
	}
	else
	{
		$total_per_ini = 10;
		$max_pages=100;
		$items_per_page = 5;
		
			if($_GET["aid"]!=""){$id=$_GET["aid"];}
			if($_GET["id"]!=""){$id=$_GET["id"];}
				if(!$_GET['pgno'])
				{
					$PageNo = 1;
				}
				else
				{
					$PageNo = $_GET['pgno'];
				}
				//QUery First
				if($_GET["aid"]!="")
				{
					$qryselC1 = "select count(*) as total from auction a left join products p on a.productID=p.productID  left join categories c on p.categoryID=c.categoryID left join auc_due_table adt on a.auctionID=adt.auction_id where a.auc_status=".$id." and adt.auc_due_time!=0 order by adt.auc_due_time";
				}
				else
				{
					$qryselC1 = "select count(*) as total from auction a left join products p on a.productID=p.productID left join categories c on p.categoryID=c.categoryID left join auc_due_table adt on a.auctionID=adt.auction_id where a.auc_status=2 and a.categoryID='".$id."' order by adt.auc_due_time";
				}
				$resultC1=mysql_query($qryselC1) or die ("1:====".mysql_error());
				$rowC1 = mysql_fetch_array($resultC1);
				$newpage = 1;	
			
				if($PageNo == 1){
					$newpage = '' ;	
					$inc =  $PageNo.$newpage;
					$newinc = $items_per_page;
				}else{
					$nxtpage = $PageNo -1 ;
					$inc =  $nxtpage.$newpage;
					$newinc = $inc + 9;
				}
				$totalC1 = $rowC1['total'];
				
				$from = ($PageNo-1)*$items_per_page;
				//End Query FIrst
				if($_GET["aid"]!="")
				{
				$qrysel1 = "select *, p.".$lng_prefix."name as prdname,".$lng_prefix."short_desc as short_desc from auction a left join products p on a.productID=p.productID  left join categories c on p.categoryID=c.categoryID left join auc_due_table adt on a.auctionID=adt.auction_id where a.auc_status=".$id." and adt.auc_due_time!=0 order by adt.auc_due_time";
				}
				else
				{
				$qrysel1 = "select *, c.".$lng_prefix."name as catname, p.".$lng_prefix."name as prdname,".$lng_prefix."short_desc as short_desc from auction a left join products p on a.productID=p.productID left join categories c on p.categoryID=c.categoryID left join auc_due_table adt on a.auctionID=adt.auction_id where a.auc_status=2 and a.categoryID='".$id."' order by adt.auc_due_time";
				}
				$qrysel1 .= " limit $from, $items_per_page";
			
				$ressel1=mysql_query($qrysel1) or die ("2:====".mysql_error());
				$totalrecords = mysql_num_rows($ressel1);
				//$answers = $rs->getrows();
				
				$start_num = $from + 1;
				$end_num = $from + $totalrecords;
				
				//QUery Third
				if($_GET["aid"]!="")
				{
					$qryselC1 = "select count(*) as total from auction a left join products p on a.productID=p.productID  left join categories c on p.categoryID=c.categoryID left join auc_due_table adt on a.auctionID=adt.auction_id where a.auc_status=".$id." and adt.auc_due_time!=0 order by adt.auc_due_time";
				}
				else
				{
					$qryselC1 = "select count(*) as total from auction a left join products p on a.productID=p.productID left join categories c on p.categoryID=c.categoryID left join auc_due_table adt on a.auctionID=adt.auction_id where a.auc_status=2 and a.categoryID='".$id."' order by adt.auc_due_time";
				}
				$total_results = mysql_result(mysql_query("$qryselC1"),0);	
				//QUery Fourth
				
				/*$ressel1 = mysql_query($qrysel1);
				$total1 = mysql_num_rows($ressel1);
				$totalpage1=ceil($total1/$PRODUCTSPERPAGE);
		
				if($totalpage1>=1)
				{
				$startrow=$PRODUCTSPERPAGE*($PageNo-1);
				$qrysel1.=" LIMIT $startrow,$PRODUCTSPERPAGE";
				//echo $sql;
				$ressel1=mysql_query($qrysel1);
				$total1=mysql_num_rows($ressel1);
				}*/
				
				//New Paging
				if (ceil($total_results / $items_per_page) < $total_per_ini)
				{
					$no_of_page_numbers = ceil($total_results / $items_per_page);
				}
				else
				{
					$no_of_page_numbers = $total_per_ini;
				}
				// Figure out the total number of pages. Always round up using ceil()
				$nextval = $PageNo+$total_per_ini;
				$total_pages = ceil($total_results / $items_per_page);
				if($total_pages>=$nextval)
				{
					$start = $PageNo;
					$stop = $nextval;
				}
				elseif($total_pages<$nextval)
				{
					if($total_pages>$total_per_ini)
					{
						$start = $total_pages-$total_per_ini+1;
						$stop = $total_pages+1;		
					}
					else
					{
						$start = 1;
						$stop = $total_pages+1;
					}
				}
				$max = $stop;
				//End New page
		}
?>
<div class="openAuction_bar_mainDIV">
	<div class="openAction_bar-left"></div>
	<div class="openAction_bar-middle"><div class="page_title_font"><?=$lng_liveauctions;?></div></div>
	<div class="openAction_bar-right"></div>
 </div>
 <div class="openAuction_bar_mainDIV2">
		<?
		if($totalC1>0)
		{
 		  $i=1;
		  while($obj = mysql_fetch_array($ressel1))
			{
				if($i==1)
				{
					$arr = $obj["auctionID"];
					$prr = $obj["auc_due_price"];
		?>
	 	<div style="height: 15px;">&nbsp;</div>
		<div class="H_beit">
			<div class="h_beit_image"><?=$lng_image;?></div>
			<div class="h_beit_desc"><?=$lng_description;?></div>
			<div class="h_beit_price"><?=$lng_price;?></div>
			<div class="h_beit_bidder"><?=$lng_bidder;?></div>
			<div class="h_beit_countdown"><?=$lng_countdown;?></div>
		</div>
		<div class="product-title"><? if($obj["catname"]=="" || $searchdata!=""){ echo $lng_allauctions; } else { echo $obj["catname"]; }?></div>							
		<?
				}
				else
				{
					$arr .= $obj["auctionID"];
					$prr .= $obj["auc_due_price"];
				}
		?>
			  <div class="auction-item" style="display: none" title="<?=$obj["auctionID"];?>" id="auction_<?=$obj["auctionID"];?>"></div>
			<div class="descripton_box"> 
				<div class="decription">
						<div class="body_inner_img" style="padding: 0px; width: 155px;"><div style="float: left; clear:both; padding-left: 15px; padding-top:9px;"><a href="auction_<?=str_replace(" ","_",strtolower(stripslashes($obj["prdname"])));?>_<?=$obj["auctionID"];?>.html"><img src="uploads/products/thumbs_big/thumbbig_<?=$obj["picture1"];?>" border="0" /></a></div><div style="float: left; padding-top: 14px; width: 153px;"><img src="<?=$lng_imagepath;?>zoom1.jpg" align="left" border="0" /><img src="<?=$lng_imagepath;?>zoom2.jpg" align="right" border="0" onclick="javascript: hidedisplayzoom('prd_image_large_<?=$obj['auctionID'];?>');" style="cursor: pointer;"/></div></div>
						
                      <div class="auction_decri" style="width: 400px;"><span style="font-size:12px; color:#000000;"><a href="auction_<?=str_replace(" ","_",strtolower(stripslashes($obj["prdname"])));?>_<?=$obj["auctionID"];?>.html" class="black_link"><?=stripslashes($obj["prdname"]);?></a></span><br />
							<br />
							<? echo stripslashes(choose_short_desc($obj["short_desc"],165));?><a href="auction_<?=str_replace(" ","_",strtolower(stripslashes($obj["prdname"])));?>_<?=$obj["auctionID"];?>.html" class="black_link"><?=$lng_linkmore;?></a>
						</div>
						
                      <div class="auction_price"><span class="body_inner_box_price">
					  		<span style="font-size:15px; font-weight: bold;"><span class="price" id="currencysymbol_<?=$obj["auctionID"];?>"></span><span class="price" id="price_index_page_<?=$obj["auctionID"];?>">---</span>
							</span>
							<br />
							<?=$lng_insteadof;?><?=$Currency;?><?=$obj["price"];?>)</span></div>
                      <div class="auction_bidder">
						<span id="product_bidder_<?=$obj["auctionID"];?>">---</span>					  
					  </div>
					  
                      <div class="auction_countdown">
					  <span class="body_inner_box_price_heading" id="counter_index_page_<?=$obj["auctionID"];?>">
						  <?
						echo "<script language='javascript' type='text/javascript'>
							document.getElementById('counter_index_page_".$obj["auctionID"]."').innerHTML = calc_counter_from_time('".$obj["auc_due_time"]."');
							</script>";
						  ?>					  
					  </span><br />
					 <? if($uid==""){ ?>
							<img src="<?=$lng_imagepath;?>BID_btn2.png" border="0"  alt="BID" onmouseover="this.src='<?=$lng_imagepath;?>login_btn3.png'" onmouseout="this.src='<?=$lng_imagepath;?>BID_btn2.png'" onclick="javascript: window.location.href='login.html'" id="image_main_<?=$obj["auctionID"];?>"  style="cursor: pointer; padding-left: 7px;"/>
					  <? } else { ?>
							<img src="<?=$lng_imagepath;?>BID_btn2.png" border="0" class="bid-button-link" name="getbid.php?prid=<?=$obj["productID"];?>&aid=<?=$obj["auctionID"];?>&uid=<?=$uid;?>" alt="BID" onmouseover="this.src='<?=$lng_imagepath;?>BID_btn_hover2.png'" onmouseout="this.src='<?=$lng_imagepath;?>BID_btn2.png'" id="image_main_<?=$obj["auctionID"];?>"  style="cursor: pointer;padding-left: 7px;"/>
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
				$i++;
				}
			?>
				<div class="H_beit_full" align="center">
				  <div style="padding-top: 3px;">
				  <?
				  	if($searchdata!="")
					{
				  ?>
						<? if($PageNo>1){ ?>
								  <? $npage = $PageNo-1;
									if($_GET['aid']==2)
									{
								  ?>
								  <span><a class="page_link" href="all_auctions_1_<?=$searchdata;?>.html" style="text-decoration: none;">&lt;&lt; </a></span> <span class="style8"><a class="page_link" href="all_auctions_<?=$npage;?>_<?=$searchdata;?>.html" style="text-decoration: none;">&lt; </a></span>
								  <?
									}
									else
									{
									?>
								  <span><a class="page_link" href="all_auctions_1_<?=$searchdata;?>.html" style="text-decoration: none;">&lt;&lt; </a></span> <span class="style8"><a class="page_link" href="all_auctions_<?=$npage;?>_<?=$searchdata;?>.html" style="text-decoration: none;">&lt; </a></span>
								  <?
									} 
								  }else{?>
								  <span class="paging_page">&lt;&lt; </span> <span class="paging_page"> &lt; </span>
								  <? }?>
								  <span class="paging_page">
								  <? for($i=$start;$i<$max;$i++)
								  {
									if($i==$PageNo)
									{
								  ?>
									| <span class="paging_page"><?=$i?></span>
								 <? }
									else
									{
										if($_GET['aid']==2)
										{
								?>	
										<span class="paging_page"> | <a class="page_link" href="all_auctions_<?=$i;?>_<?=$searchdata;?>.html" style="text-decoration: none;"><?=$i;?></a></span>
								<?	
										}
										else
										{
								?>	
										<span class="paging_page"> | <a class="page_link" href="all_auctions_<?=$i;?>_<?=$searchdata;?>.html" style="text-decoration: none;"><?=$i;?></a></span>
								<?		
										}	
									} 
								  } ?>
								  <? if($PageNo < $total_pages){?>
								  <? $npage = $PageNo+1;
									if($_GET['aid']==2)
									{
								  ?>
								  <span class="paging_page"> |<a class="page_link" href="all_auctions_<?=$npage;?>_<?=$searchdata;?>.html" style="text-decoration: none;"> &gt;</a></span> <a class="page_link" href="all_auctions_<?=$total_pages;?>_<?=$searchdata;?>.html" style="text-decoration: none;"> &gt;&gt; </a>
								  <? }
									 else
									 {
									?>
								   <span class="paging_page"> |<a class="page_link" href="all_auctions_<?=$npage;?>_<?=$searchdata;?>.html" style="text-decoration: none;"> &gt;</a></span> <a class="page_link" href="all_auctions_<?=$total_pages;?>_<?=$searchdata;?>.html" style="text-decoration: none;"> &gt;&gt; </a>
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
						<? if($PageNo>1){ ?>
								  <? $npage = $PageNo-1;
									if($_GET['aid']==2)
									{
								  ?>
								  <span><a class="page_link" href="all_live_auctions_<?=$_GET['aid'];?>_1.html" style="text-decoration: none;">&lt;&lt; </a></span> <span class="style8"><a class="page_link" href="all_live_auctions_<?=$_GET['aid'];?>_<?=$npage;?>.html" style="text-decoration: none;">&lt; </a></span>
								  <?
									}
									else
									{
									?>
								  <span><a class="page_link" href="all_auctions_<?=$id?>_1.html" style="text-decoration: none;">&lt;&lt; </a></span> <span class="style8"><a class="page_link" href="all_auctions_<?=$id?>_<?=$npage;?>.html" style="text-decoration: none;">&lt; </a></span>
								  <?
									} 
								  }else{?>
								  <span class="paging_page">&lt;&lt; </span> <span class="paging_page"> &lt; </span>
								  <? }?>
								  <span class="paging_page">
								  <? for($i=$start;$i<$max;$i++)
								  {
									if($i==$PageNo)
									{
								  ?>
									| <span class="paging_page"><?=$i?></span>
								 <? }
									else
									{
										if($_GET['aid']==2)
										{
								?>	
										<span class="paging_page"> | <a class="page_link" href="all_live_auctions_<?=$_GET['aid'];?>_<?=$i;?>.html" style="text-decoration: none;"><?=$i;?></a></span>
								<?	
										}
										else
										{
								?>	
										<span class="paging_page"> | <a class="page_link" href="all_auctions_<?=$id?>_<?=$i;?>.html" style="text-decoration: none;"><?=$i;?></a></span>
								<?		
										}	
									} 
								  } ?>
								  <? if($PageNo < $total_pages){?>
								  <? $npage = $PageNo+1;
									if($_GET['aid']==2)
									{
								  ?>
								  <span class="paging_page"> |<a class="page_link" href="all_live_auctions_<?=$_GET['aid'];?>_<?=$npage;?>.html" style="text-decoration: none;"> &gt;</a></span> <a class="page_link" href="all_live_auctions_<?=$_GET['aid'];?>_<?=$total_pages;?>.html" style="text-decoration: none;"> &gt;&gt; </a>
								  <? }
									 else
									 {
									?>
								   <span class="paging_page"> |<a class="page_link" href="all_auctions_<?=$id?>_<?=$npage;?>.html" style="text-decoration: none;"> &gt;</a></span> <a class="page_link" href="all_auctions_<?=$id?>_<?=$total_pages;?>.html" style="text-decoration: none;"> &gt;&gt; </a>
								  <? 
									 }	
								  
								  }else{?>
								  | &gt; &gt;&gt;
								  <? }?>
								  </span>
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
			 	<div style="height: 15px;">&nbsp;</div>
				<div class="noauction_message" align="center"><? if($_GET["id"]!="") { echo $lng_noliveauctioncat; } else { echo $lng_noliveauction; } ?></div>
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
