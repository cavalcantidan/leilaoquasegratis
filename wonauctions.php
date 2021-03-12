<?
 	$agora=date("Y-m-d G:i:s");
	include("session.php");
	$uid = $_SESSION["userid"];

    $head_tag = '<link href="css/style_youbid.css" rel="stylesheet" type="text/css" />
                 <link href="css/menu.css" rel="stylesheet" type="text/css" />
                 <script language="javascript" type="text/javascript" src="js/function.js"></script>';

	include("header.php");

	if(!$_GET['pgno']){$PageNo = 1;}else{$PageNo = $_GET['pgno'];}
	$qrysel = "select *,".$lng_prefix."name as name,".$lng_prefix."short_desc as short_desc, 
    DATEDIFF('$agora',won_date) AS expiry, DATEDIFF('$agora',accept_date) expirywon
     from won_auctions w left join auction a on w.auction_id=a.auctionID 
     left join products p on a.productID=p.productID 
     where w.userid=$uid order by won_date desc";
	$ressel = mysql_query($qrysel);
	$total = mysql_num_rows($ressel);
	$totalpage=ceil($total/$PRODUCTSPERPAGE_MYACCOUNT);

	if($totalpage>=1){
    	$startrow=$PRODUCTSPERPAGE_MYACCOUNT*($PageNo-1);
    	$qrysel.=" LIMIT $startrow,$PRODUCTSPERPAGE_MYACCOUNT";
    	$ressel=mysql_query($qrysel);
    	$total=mysql_num_rows($ressel);
	}

	$qryvou = "select * from user_vouchers where user_id='".$uid."' and voucher_status='0'";
	$resvou = mysql_query($qryvou);
	$totalvou = mysql_num_rows($resvou);
	$totalvou1 = 0;
	while($objvou = mysql_fetch_object($resvou)){
		$expiry = strtotime($objvou->expirydate);
		$today = time();
		if($today<=$expiry){$totalvou1++;}
	}
?>


<div id="conteudo-principal">
    <?
    include("leftside.php"); 
    ?>
            
    <div id="conteudo-conta">
        <h3 id="venci-tit"><?=$lng_myauctionsavenue;?> - <?=$lng_wonauctions;?></h3>
        <?
		if($total>0){
			$counter = 1;
			while($obj = mysql_fetch_array($ressel)){
				$qryshipping = "select * from shipping where id='".$obj["shipping_id"]."'";
				$resshipping = mysql_query($qryshipping);
				$objshipping = mysql_fetch_array($resshipping);

				$finalprice = $obj["auc_final_price"];
                
				$new_status = ($obj["expiry"]>7)?"Expire":"Running";
                $new_status_won = ($obj["expirywon"]>7)?"Expire":"Running";	
        ?>	

<!-- meus leiloes -->
<div class="auction-item" style="display: none" title="<?=$obj["auctionID"];?>" id="auction_<?=$obj["auctionID"];?>"></div>                
<!-- meus leiloes -->
<div class="leilao-m-conteudo">

<span class="lm-titulos" style="top:-16px; left:7px;">
<span class="lm-sombra"></span>
<span class="lm-titulo"><?=$lng_image;?></span>
</span>

<span class="lm-foto">
<a href="auction_<?=str_replace(" ","_",strtolower($obj["name"]));?>_<?=$obj["auctionID"];?>.html">
<img src="uploads/products/thumbs_big/thumbbig_<?=$obj["picture1"];?>" border="0" />
</a>
</span>

<div class="lm-descricao">
<span class="lm-titulos" style="top:-16px; left:0;">
<span class="lm-sombra"></span>
<span class="lm-titulo"><?=$lng_description;?></span>
</span>
<a href="auction_<?=str_replace(" ","_",strtolower(stripslashes($obj["name"])));?>_<?=$obj["auctionID"];?>.html" class="lm-produto">
<?=stripslashes($obj["name"]);?>
</a>
<p class="lm-detalhes"><?=stripslashes(choose_short_desc($obj["short_desc"],110));?>
<a class="black_link" href="auction_<?=str_replace(" ","_",strtolower(stripslashes($obj["name"])));?>_<?=$obj["auctionID"];?>.html">
<?=$lng_linkmore;?>
</a>
</p>
</div>

<div class="lm-info-lance">
<span class="lm-titulos" style="top:-16px; left:0;">
<span class="lm-sombra"></span>
<span class="lm-titulo"><?=$lng_winprice;?></span>
</span>
<p class="preco-atual" >
<span style="color:#c4473a;"><?=$Currency;?><?=number_format($finalprice,2);?></span><?=$lng_inclvatexcl2;?><br />
+ <?=$lng_deliverycharge;?>&nbsp;<?=$Currency.$objshipping["shippingcharge"];?>
</p>

<div id="lance-finalizando">
                <? if($obj['accept_denied']=="Accepted"){ //Aceitou ?>
	<span class="finalizado"><?=$lng_wonaccepted;?></span>
                <? }elseif($obj['accept_denied']=="Denied"){ //Recusou ?>
	<span style="font-size:16px;color:#C00;text-align:center;"><?=$lng_wondenied;?></span>
                <? }elseif($new_status=="Running"){ //Esperando?>
	<p style="width:150px; text-align:center;">
	<?=$lng_lastdateaccept;?>(<?=AcceptDateFunction(substr($obj["won_date"],0,10));?>)
	<form action="buybidspayment.php" method="POST" class="clique-finalizar">
	    <input type="hidden" name="acao" value="pl" />
	    <input type="hidden" name="auctionid" value="<?=$obj["auction_id"];?>" />
	    <input type="submit" value="<?=$lng_efetuarcompra;?>" />
	</form>
    <form action="acceptordenied.php" method="POST" class="clique-finalizar">
	    <input type="hidden" name="Accden" value="Denied" />
	    <input type="hidden" name="auctionid" value="<?=$obj["auction_id"];?>" />
	    <input type="submit" name="Submit" value="<?=$lng_onlydenied;?>" />
	</form>
	
	</p>
                <? }else{ //Tempo de Espera Esgotado ?>
                <span class="red-text-12-b"><?=$lng_acceptperiodover;?></span>
                <? } ?>
            </div>
        
            <div class="woncountdown" align="center" style="margin-top:-30px;">
			<? if($obj['accept_denied']=="Accepted" && $obj['payment_date']=='0000-00-00 00:00:00'){
			     // Aceitou pagar pelo leilao
                echo '<span id="makepayment_'.$obj["auction_id"].'">';
                if($new_status_won=="Running"){ // Tempo ainda disponivel 
                    if($totalvou1>0){ ?>							
            			<span class="efetua-pagamento">
                            
                        </span>
        			<? } else { 
        			     echo "Aguardando Confirma&ccedil;&atilde;o Banc&aacute;ria".
                         '';
                        }
                } else {
                    echo '<div class="red-text-12-b" align="center">'.$lng_paymentperiodover.'</div>'; 
                } 
                echo '</span>';
               } elseif($obj['payment_date']!='0000-00-00 00:00:00'){
                    $paydate = arrangedate(substr($obj['payment_date'],0,10)); 
                    echo '<div align="center"><span id="wonpayment"><b>'.$paydate.'<br />'.
                            substr($obj['payment_date'],11).'</b></span></div>';
               } else { 
                    echo '<span id="paymentdate_'.$obj["auction_id"].'" style="visibility: hidden;"></span>'.
                    '<span style="visibility:hidden;" id="makepayment_'.$obj["auction_id"].'">';
                    if($totalvou1>0){ 
                        echo '<input type="image" src="'.$lng_imagepath.'make a payment_btn.png" value="Make Payment" onclick="window.location.href=\'choosevoucher.html?winid=winid='.
                                base64_encode($finalprice."&".$obj["auctionID"]).'\'" name="makepayment"  onmouseover="this.src=\''.$lng_imagepath.
                                'make a payment_hover_btn.png\'" onmouseout="this.src=\''.$lng_imagepath.'make a payment_btn.png\'" />';                        
                     } else { 
                        echo '<input type="image" src="'.$lng_imagepath.'make a payment_btn.png" value="Make Payment" onclick="window.location.href=\'payment.php?winid='.
                                base64_encode($finalprice."&".$obj["auctionID"]).'\'" name="makepayment"  onmouseover="this.src=\''.$lng_imagepath.
                                'make a payment_hover_btn.png\'" onmouseout="this.src=\''.$lng_imagepath.'make a payment_btn.png\'" />';
                     } 
                     echo '</span>';	
			   } ?>
            </div>
        <!-- /info-lance -->
        </div>
    <!-- / meus leiloes -->
    </div>
    <div style="height:10px;"></div>
    <?	}
        echo '<!-- paginacao ou pagina sem leilao  --> ';
        if($PageNo>1){
            $PrevPageNo = $PageNo-1;
            echo '<a class="alink" href="wonauctions_'.$PrevPageNo.'.html">&lt;'.$lng_previouspage.'</a>';
            if($totalpage>2 && $totalpage!=$PageNo){
                echo '<span class="paging">&nbsp;|</span>';
            }
        }
        echo "&nbsp;";
        if($PageNo<$totalpage){ 
            $NextPageNo = $PageNo + 1; 
            echo '<a class="alink" id="next" href="wonauctions_'.$NextPageNo.'.html">'.$lng_nextpage.'&gt;</a>';
        }
    }else{
        echo '<div class="noauction_message" align="center">'.$lng_nowonauctions.'</div>';
    }  ?>          
    </div>
<? include("footer.php"); ?>		
</div>
</body>
</html>
