 <div class="itemLeiao" id="leilao_<?=$objauc["auctionID"];?>" title="<?=$objauc["auctionID"];?>">
    <div class="bordaSuperior"></div>
    <div class="areaMeioBorda">
        <center>	
                            
            <div class="areaNome"><a href="auction_<?=str_replace("/","",str_replace(" ","_",strtolower(stripslashes($objauc["name"]))));?>_<?=$objauc["auctionID"];?>.html" 
                 alt="<?php echo stripslashes($objauc["name"]); ?>" title="<?php echo stripslashes($objauc["name"]); ?>">
                <?php echo resumir_frase($objauc["name"],22); ?>
            </a></div>                        
                               
            <div class="areaFoto"><img src="uploads/products/thumbs_big/thumbbig_<?=$objauc["picture1"];?>" alt="<?php echo stripslashes($objauc["name"]); ?>" title="<?php echo stripslashes($objauc["name"]); ?>" width="110" height="110" /></div>
            <div class="areaTempo"><span class="areaTextoTempo">
                <?php echo " ".date('d/m/Y', strtotime($objauc["auc_start_date"]))." ".date('H:i:s', strtotime($objauc["auc_start_time"])); ?></span></div>
            <div class="areaContagem"><?php
   	                    $horas = substr("00".(($objauc["auc_due_time"] / 3600) % 24), -2);
	                    $minutos = substr("00".(($objauc["auc_due_time"] / 60) % 60), -2);
	                    $segundos = substr("00".($objauc["auc_due_time"] % 60), -2);

	                    echo "$horas:$minutos:$segundos" ;
            ?></div>
            <div class="areaValor"><?=$Currency.str_replace(".",",",$objauc["auc_due_price"]);?></div>

            <? if($_SESSION["userid"]==""){ ?>
            <div class="btnLogin"><a href="" class="btnLogin" onclick="javascript:abreMenuLogin();return false;"></a></div>
            <? } else { ?>
            <div class="btnLance"><a href="" onclick="javascript:inserirLance(<?=$objauc["auctionID"];?>);return false;"></a></div>  
            <? } ?>

            <div class="usuario"><img src="img/layout/user.png"><a>Sem lances</a></div>
                                
        </center>
        <div class="clear"></div>
    </div> <!-- areaMeioBorda-->

    <div class="bordaInferior"></div>
</div> <!--.itemLeilao -->  