<div class="itemLeilaoFuturo" id="leilao_19">
    <div class="areaImagem">
        <center>
            <div class="areaFoto"><a href="auction_<?=str_replace(" ","_",strtolower(stripslashes($objauc["name"])));?>_<?=$objauc["auctionID"];?>.html">
                <img src="uploads/products/thumbs_big/thumbbig_<?=$objauc["picture1"];?>" alt="<?php echo stripslashes($objauc["name"]); ?>" title="<?php echo stripslashes($objauc["name"]); ?>" width="110" height="110">
            </a></div>
         <!--   <div class="areaTempo"><span class="areaTextoTempo"><?php echo " ".date('d/m/Y', strtotime($objauc["auc_start_date"]))." ".date('G:i',strtotime($objauc["auc_start_time"])); ?></span></div> -->
        </center>
    </div><!--areaImagem -->                    
    <div class="textosProduto">
        <div class="nomeProduto"><a href="auction_<?=str_replace(" ","_",strtolower(stripslashes($objauc["name"])));?>_<?=$objauc["auctionID"];?>.html" alt="<?php echo stripslashes($objauc["name"]); ?>" title="<?php echo stripslashes($objauc["name"]); ?>"><?php echo stripslashes($objauc["name"]); ?></a></div>
        <div class="areaTempo"><span class="areaTextoTempo"><?php echo " ".date('d/m/Y', strtotime($objauc["auc_start_date"]))." ".date('H:i:s',strtotime($objauc["auc_start_time"])); ?></span></div>
        <div class="descProduto"><?php echo stripslashes($objauc["short_desc"]);?></div>
    </div> <!--textosProduto -->  <!-- 
    <div class="latDireita">
        <center>
            <div class="areaValor"><?=$Currency;?> 0,00</div>
            <div class="btnLogin"><a href="usuarios/login" class="btnLogin"></a></div>
            <div class="usuario"><img src="img/layout/user.png"><a>sem Lances</a></div>
        </center>
    </div>         -->                 
    <div class="clear"></div>       
</div><!--.itemLeilaoFuturo -->                        
