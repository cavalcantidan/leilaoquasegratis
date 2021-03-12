<?php
	$aucid = $_REQUEST["aid"];
	if($aucid==""){
		header("location: index.php");
	}
	$prid = $_REQUEST["pid"];
	$uid = $_SESSION["userid"];
	
	$head_tag = '    
		<link href="css/style_youbid.css" rel="stylesheet" type="text/css" />
		<script language="javascript" src="js/function.js"></script>
        <script type="text/javascript" src="js/leilao2.js"></script>
		<script language="javascript" type="text/javascript">';
	 $head_tag .= "
			function hideDisplayBids(id){
				if(id==1){
					document.getElementById('producthistory1_hidden').style.display='none';
					document.getElementById('producthistory1').style.display='block';
				}
				if(id==2){
					document.getElementById('producthistory1_hidden').style.display='block';
					document.getElementById('producthistory1').style.display='none';
				}
			}

			function ShowMyButler(id){
				if(id==1){
					document.getElementById('bidbutler_show_main').style.display='block';
					document.getElementById('bidbutler_hide').style.display='none';
				}
				if(id==2){
					document.getElementById('bidbutler_show_main').style.display='none';
					document.getElementById('bidbutler_hide').style.display='block';
				}
			}

			function addWatchlist(auc_id,uid){
				var url2='addwatchauction.php?aid='+auc_id+'&uid='+uid;
				xmlhttp.open('GET',url2);
				xmlhttp.onreadystatechange=changeWatchAuction;
				xmlhttp.send(null);
			}

			function changeWatchAuction(){
				if (xmlhttp.readyState == 4 && xmlhttp.status == 200){ 
					var temp1=xmlhttp.responseText;
					document.getElementById('added_watchlist').style.display = 'block';
					document.getElementById('notadded_watchlist').style.display = 'none';
			
				}
			}
		</script>";

	include("header.php");

	$qrysel = "select *,p.{$lng_prefix}name as name,{$lng_prefix}short_desc 
				as short_desc,{$lng_prefix}long_desc as long_desc 
				from products p left join auction a on p.productID=a.productID  left join 
				auc_due_table adt on a.auctionID=adt.auction_id left join 
				registration r on a.buy_user=r.id left join 
				shipping s on a.shipping_id=s.id  left join 
				auction_management am on am.auc_manage=a.time_duration 
				where a.auctionID='$aucid'";
	$ressel = mysql_query($qrysel);
	$total = mysql_num_rows($ressel);
	$obj = mysql_fetch_object($ressel);
	
	$entregasql = "select entrega from auction where auctionID='$aucid'";
	$entrega1 = mysql_query($entregasql);
	
	$qrywatch = "select * from watchlist where auc_id='$aucid' and user_id='$uid'";
	$reswatch = mysql_query($qrywatch);
	$totalwatch = mysql_num_rows($reswatch);

?>

	<!-- leilao cabecalho -->
	<div id="leilao-cabecalho">
		<div id="leilao-pag-titulo">
			<span class="pag-tit-sombra1"></span>
			<span class="pag-tit-sombra2"></span>
			<h2><?=stripslashes($obj->name);?></h2>
			<span class="leilao-id"><?=$lng_auctionid;?>: <?=$aucid;?></span>
		</div>
	</div> <!-- fim leilao cabecalho -->


	<div id="leilao-pag-conteudo">
		<div id="leilao-pag-foto-moldura">
			<span class="leilao-pag-foto-principal">
				<span id="mainimage1"><img src="uploads/products/<?=$obj->picture1;?>" /></span>
				<span id="mainimage2" style="display:none;"><?php if($obj->picture2!=""){ ?><img src="uploads/products/<?=$obj->picture2;?>"/><? }	?></span>
				<span id="mainimage3" style="display: none"><?php if($obj->picture3!=""){ ?><img src="uploads/products/<?=$obj->picture3;?>" /><? }	?></span>								
				<span id="mainimage4" style="display: none"><?php if($obj->picture4!=""){ ?><img src="uploads/products/<?=$obj->picture4;?>"/><? } ?></span>	
			</span>
			
			<div class="leilao-pag-thumbs"> <!-- miniaturas -->
				<? if($obj->picture1!=""){ ?>
				<img id="otherimageprd_1" src="uploads/products/thumbs/thumb_<?=$obj->picture1;?>" width="79" height="60" onclick="changeimage(1);" style="cursor: pointer" />
				<? } else { ?>
				<img id="otherimageprd_1" src="<?=$lng_imagepath;?>no_image.gif" style="cursor: pointer" width="79" height="60" /><? } ?>						
									
				<? if($obj->picture2!=""){ ?>									
				<img id="otherimageprd_2" src="uploads/products/thumbs/thumb_<?=$obj->picture2;?>" width="79" height="60" onclick="changeimage(2);" style="cursor: pointer" />
				<? } else { ?>
				<img id="otherimageprd_2" src="<?=$lng_imagepath;?>no_image.gif" style="cursor: pointer" width="79" height="60"/><? } ?>
									
				<? if($obj->picture3!=""){ ?>									
				<img id="otherimageprd_3" src="uploads/products/thumbs/thumb_<?=$obj->picture3;?>" width="79" height="60" onclick="changeimage(3);" style="cursor: pointer" />
				<? } else { ?>
				<img id="otherimageprd_3" src="<?=$lng_imagepath;?>no_image.gif" style="cursor: pointer" width="79" height="60" /><? } ?>									
									
				<? if($obj->picture4!=""){ ?>									
				<img id="otherimageprd_4" src="uploads/products/thumbs/thumb_<?=$obj->picture4;?>" width="79" height="60" onclick="changeimage(4);" style="cursor: pointer" />
				<? } else { ?>
				<img id="otherimageprd_4" src="<?=$lng_imagepath;?>no_image.gif" style="cursor: pointer" width="79" height="60"/><? } ?>
			</div>
		</div> <!-- fim leilao-pag-foto-moldura-->

		<div class="auction-item" style="display: none" title="<?=$obj->auctionID;?>" id="auction_<?=$obj->auctionID	;?>"></div>


        <?php
			if($obj->auc_status==2){
				$add .= ",'".$objauc->auctionID."'";
				$but = $obj->auctionID;
				$arr .= ",".$obj->auctionID;
				$prr .= ",".$obj->auc_due_price;
				$price = $obj->price;
				$fprice = $obj->auc_fixed_price;

                $dados_valor=$obj->auc_start_price!=""?$obj->auc_start_price:"0,00";
                $dados_texto_lance='&uacute;ltimo lance por ';
                $dados_valor_lance='---';
                $dados_texto_contador='CONTADOR';

                $horas = substr("00".(($obj->auc_due_time / 3600) % 24), -2);
	            $minutos = substr("00".(($obj->auc_due_time / 60) % 60), -2);
	            $segundos = substr("00".($obj->auc_due_time % 60), -2);
                $dados_valor_contador="$horas:$minutos:$segundos";
			}elseif($obj->auc_status==1){
				$proprice = $obj->price;
				$aucprice = $obj->auc_fixed_price;

                $dados_valor=$obj->auc_start_price!=""?$obj->auc_start_price:"0,00";
                $dados_texto_lance='&uacute;ltimo lance por ';
                $dados_valor_lance='---';
                $dados_texto_contador='CONTADOR';
                $dados_valor_contador='--:--:--';
			} elseif($obj->auc_status==3) {
				$qrybid = "select sum(bid_count) as bidcount from bid_account 
							where bid_flag='d' and auction_id=$aucid and 
							user_id=".$obj->buy_user." group by auction_id";
				$resbid = mysql_query($qrybid);
				$total = mysql_num_rows($resbid);
				$objbid = mysql_fetch_object($resbid); 
				$totbidprice = $objbid->bidcount;
						
				$price = $obj->price;
                $fprice = "0.00";
				if($obj->fixedpriceauction=="1") { $fprice = $obj->auc_fixed_price;}
				$saving_price = $price-$totbidprice-$fprice;
				$saving_percent = ($saving_price*100)/$price;

                $dados_valor=$obj->auc_final_price;
                $dados_texto_lance='Arrematado por ';
                $dados_valor_lance=$obj->username;
			}
		?>

		<!-- leilao-pag-valor-conteudo -->
		<div id="leilao-pag-valor-conteudo">
			<div id="leilao-pag-valor-atual"><div class="itemLeiao" id="leilao_<?=$aucid;?>"  title="<?=$aucid;?>">
				<h3><?=$lng_price;?>:</h3>
						
				<!-- valor-->
				<p style="font-size:30px; display:block; text-align:center; margin-top:15px; margin-bottom:12px;">
					<span id="Valor"><?=$Currency.number_format($dados_valor,2,',','.');?></span>
				</p>

				<!-- ? -->
				<div class="text"><?=$lng_inclvatexcl;?></div>

				<!-- ultimo lance -->
				<p class="lm-lance"><?=$dados_texto_lance;?>
                    <span id="usuario" style="margin-top:2px;"><img src="img/layout/user.png"><a>
                    <?=$dados_valor_lance;?></a></span>
                </p>

		<?php
			if($obj->auc_status==2||$obj->auc_status==1||$obj->auc_status==4){
            // [ 2 - leilao em andamento ou 1 - leilao futuro ou 4 - leilao pendente ]
		?>
				<!-- contador -->
				<p class="lm-contador"><?=$dados_texto_contador;?><span style="margin-top:2px;">
                    <span id="Contagem"><?=$dados_valor_contador;?></span> </span>
                </p>

				<center><!-- botao de lance -->
                    <? if($uid==""){ ?>
                    <div class="btnLogin"><a href="" class="btnLogin" onclick="javascript:abreMenuLogin();return false;"></a></div>
                    <? } elseif($obj->auc_status==2) { ?>
                    <div class="btnLance"><a href="" onclick="javascript:inserirLance(<?=$obj->auctionID;?>);return false;"></a></div>  
                    <? } ?>
                </center>

				<!-- aviso -->
				<p style="margin-top:20px; padding:0 10px; font-size:10px;">
					<?=$lng_witheachbid;?><?=$Currency;?><?=$obj->pennyauction=="1"?"0,01":$obj->auc_plus_price;?><br />
				</p>
			</div></div> <!-- fim leilao-pag-conteudo -->

			<!--economias -->
			<div id="leilao-pag-economia" style="margin-top:20px;">
				<h3><?=$lng_savings;?></h3>
				<p>
					<span style="color:#bf9a2a; margin-right:15px;"><?=$lng_worthupto;?></span>
					<?=$Currency;?><?=$obj->price;?>
				</p>
				<?php if($uid!="" && $obj->auc_status==2){
						$qrybid = "select sum(bid_count) as bidcount from bid_account 
										where bid_flag='d' and auction_id='$aucid' and 
										user_id='$uid' group by auction_id";
						$resbid = mysql_query($qrybid);
						$total = mysql_num_rows($resbid);
						$objbid = mysql_fetch_object($resbid);
						$totbidprice = $objbid->bidcount;
				?>
				<p>
					<span style="color:#bf9a2a; margin-right:15px;"><?=$lng_placedbids;?>:</span>
					<span id="placebidsamount"><?=number_format($totbidprice,0);?></span>
				</p>
				<?php } ?>

				<!--p>
					<span style="color:#bf9a2a; margin-right:15px;"><?=$lng_fixedprice;?></span>
					<?=$Currency;?><?=$obj->auc_fixed_price;?>
				</p-->
				<p>
					<span style="color:#bf9a2a; margin-right:15px;"><?=$lng_savings;?>:</span>
					<?=$Currency;?><span id="placebidssavingdisp"><?=number_format(($price-$fprice-$totbidprice),2);?></span>
				</p>
				
		<?php 
        	} elseif($obj->auc_status==3) {
            // [ 3 - LEILAO FINALIZADO ]
		?>
                <!-- data arremate -->
				<p style="text-align:center; margin-top:10px;">
					<?=$lng_auctionended1;?> dia <?=arrangedate(substr($obj->auc_final_end_date,0,10));?>,<?=$lng_auctionended2;?><?=substr($obj->auc_final_end_date,10);?>
				</p>
	
				<!-- parabens -->									
			<?php if($obj->username!=""){ ?>
				<div id="parabens">
					<?=$lng_congratulations;?><br />
					<?=$obj->username;?>!
				</div>				
				<?php
				$preco = $obj->price;
				$FatorDivisor = $preco / 100;
				$vlEconomia = $preco - $fprice;
				$valorEconomia = $vlEconomia / $FatorDivisor;
				?>
				<div class="row" style="padding-top: 5px;">
					<div style="font-size: 18px; color: green;" align="center">
						<?=$lng_savings;?> : <?=number_format($valorEconomia,2);?> %
					</div>										
				</div>

			<?php }	else { ?>
				<div class="row" style="padding-top: 30px; height: 50px;">
					<div class="darkblue-text-17-b" align="center">
						<?=$lng_nobidspalced;?>!
					</div>				
				</div>
			<?php } ?>

			</div></div> <!-- fim leilao-pag-valor-atual -->

			<!--economias -->
			<div id="leilao-pag-economia" style="margin-top:20px;">
				<h3><?=$lng_savings;?></h3>
				<p>
					<span style="color:#bf9a2a; margin-right:15px;"><?=$lng_worthupto;?></span>
					<?=$Currency;?><?=$obj->price;?>
				</p>
				<?php
				/////////////////////////////////////////
				//Valor em economia (valor de mercado - valor arrematado)
				$preco = $obj->price;
				$saving_priceBug = $preco - $fprice;
				/////////////////////////////////////////
				?>

				<p>
					<span style="color:#bf9a2a; margin-right:15px;"><?=$lng_placedbids;?>:</span>
					<?=number_format($totbidprice,0);?>
				</p>
				<!--p>
					<span style="color:#bf9a2a; margin-right:15px;"><?=$lng_finalprice;?>:</span>
					<?=$Currency;?><?=number_format($fprice,2);?>
				</p-->
				<p>
					<span style="color:#bf9a2a; margin-right:15px;"><?=$lng_savings;?>:</span>
					<?=$Currency;?><?=number_format($saving_priceBug,2);?>
				</p>

		<?php
			}
		?>	

				<p><?=$lng_typicalworthup;?></p>
 			</div> <!-- / leilao-pag-economia -->
		</div> <!-- / leilao-pag-valor-conteudo -->




		<div id="mais-leiloes-conteudo">
		    <div id="cleaner"></div>

		    <div id="producthistory1" style="margin-left:-50px;"> 		
			    <div class="productdetail_box">
			    <?php if($uid!="" && $obj->auc_status==2){ ?>
				    <div class="product-history-leftside" onclick="hideDisplayBids(1);">
					    <div class="autobidder_title" style="font-size: 12px;"><?=$lng_bidhistory;?></div>
				    </div>
				    <div class="product-history-rightside" onclick="hideDisplayBids(2);">
					    <div class="autobidder_title" style="font-size: 10px; padding-top: 2px;"><?=$lng_mybids;?></div>
				    </div>
			    <?php } else { ?>
				    <div class="product-history-full">
					    <div class="autobidder_title" style="color:#FFF"><?=$lng_bidhistory;?></div>
				    </div>
                <?php } ?>
				    <div class="middlepart" style="height: 275px; width:277px; background-image:none;">
					    <div class="producthistitlerow" style="padding-top: 25px; background-image:none; width:272px;">
						    <div class="cell"><?=$lng_bidhistorybid;?></div>
						    <div class="cell"><?=$lng_bidhistorybidder;?></div>
						    <div class="cell"><?=$lng_biddingtime;?></div>
					    </div>


			    <?php 
				    $qryhis = "select * from bid_account ba left join auction a on ba.auction_id=a.auctionID left join registration r on ba.user_id=r.id where ba.auction_id=$aucid and ba.bid_flag='d' order by ba.id desc limit 0,10";
				    $bidarr = $_REQUEST["aid"];
				    $reshis = mysql_query($qryhis);
				    $totalhis = mysql_num_rows($reshis);

				    $q=0;
				    for($j=1;$j<=10;$j++){
					    $objhis = mysql_fetch_object($reshis);
			    ?>
					    <div class="producthisrow" style="height: 22px; width:262px;"> 
						    <div class="cell" id="bid_price_<?=$q;?>">
							    <?=$objhis->bidding_price!=""?$Currency.$objhis->bidding_price:"&nbsp;";?>
						    </div>
						    <div class="cell" id="bid_user_name_<?=$q;?>">
						        <?php	
						        if($objhis->username!=""){echo $objhis->username; }
						        elseif($objhis->bidding_price!="" && $objhis->username==""){echo "-removido-"; }
						        ?>
						    </div>
						    <div class="cell" id="bid_time_<?=$q;?>">
                                <?=$objhis->bidding_price!=""?substr($objhis->bidpack_buy_date,10):"&nbsp;";?>
                            </div>
					    </div>		
			    <?php $q++;
				    }
			    ?>

				    </div>
			    </div>
		    </div> <!-- producthistory1 -->
		
            <div id="producthistory1_hidden" style="display: none; margin-left:-50px;">
			    <div class="productdetail_box">
				    <div class="product-history-leftside_dark" onclick="hideDisplayBids(1);">
					    <div class="autobidder_title" style="font-size: 10px; padding-top: 2px;"><?=$lng_bidhistory;?></div>
				    </div>
				    <div class="product-history-rightside_dark" onclick="hideDisplayBids(2);">
					    <div class="autobidder_title" style="font-size: 12px;"><?=$lng_mybids;?></div>
				    </div>
				    <div class="middlepart" style="height: 275px; width:277px;">
					    <div class="producthistitlerow" style="padding-top: 25px; width:272px;">
						    <div class="cell"><?=$lng_bidhistorybid;?></div>
						    <div class="cell"><?=$lng_biddingtime;?></div>
					    </div>


					    <?php 
						    if($uid!=""){
							    $qryhis1 = "select * from bid_account ba left join 
										    auction a on ba.auction_id=a.auctionID left join 
										    registration r on ba.user_id=r.id where 
										    ba.auction_id='$aucid' and ba.bid_flag='d' and 
										    ba.user_id='$uid' order by ba.id desc limit 0,10";
							    $reshis1 = mysql_query($qryhis1);
							    $totalhis1 = mysql_num_rows($reshis1);
							    $r=0;
							    for($k=1;$k<=10;$k++){
								    $objhis1=mysql_fetch_object($reshis1);
					    ?>
					    <div class="producthisrow" style="height: 22px; width:262px;">
						    <div class="cell" id="my_bid_price_<?=$r;?>"><?=$objhis1->bidding_price!=""?$Currency. number_format($objhis1->bidding_price,2,',','.'):"&nbsp;";?></div>
						    <div class="cell" id="my_bid_time_<?=$r;?>"><?=substr($objhis1->bidpack_buy_date,10);?></div>
					    </div>		
					    <?php
								    $r++;
							    }
						    }
					    ?>

				    </div>
			    </div>				
		    </div>  <!-- fim producthistory1_hidden -->

	    </div> <!-- fim mais-leiloes-conteudo -->
 
        <!-- DETALHES DO PRODUTO --> 
	    <div style="clear:both"></div>
        <div id="detalhes-produto" style="margin-top:20px;">
	        <h3 id="detalhes-produto-tit"><?=$lng_productdetails;?></h3>
	        <h3 class="help-pergunta" style="margin-left:10px;"><span>
		        <strong><?=stripslashes($obj->name);?></strong>
	        </span></h3>			
	        <div style="padding-top: 15px; padding-left: 15px; padding-bottom: 2px; width: 900px; min-height:100px; text-align: left;" align="left">
		        <?php 
			        echo stripslashes($obj->long_desc);
			        $entregasql = mysql_fetch_array($entrega1);
			        $entrega = $entregasql["entrega"];  
			        echo $entrega; //TROCAR POR echo "$entrega";
		        ?>		 
	        </div>		 
        </div>

<?php include("footer.php"); ?>