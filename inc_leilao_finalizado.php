<!-- btnComprar -->
    <div class="itemLeilaoFuturo">

        <div class="areaImagem">
            <center>
                <div class="areaFoto"><a target="_parent" href="auction_<?=str_replace(" ","_",strtolower(stripslashes($objaucEND["name"])));?>_<?=$objaucEND["auctionID"];?>.html">
                    <img src="uploads/products/thumbs_big/thumbbig_<?=$objaucEND["picture1"];?>" alt="<?=stripslashes($objaucEND["name"]);?>" title="<?=stripslashes($objaucEND["name"]);?>" width="110" height="110">
                </a></div>
            </center>
        </div><!--areaImagem -->

        <div class="textosProduto">

            <div class="nomeProduto">
                <a target="_parent" href="auction_<?=str_replace(" ","_",strtolower(stripslashes($objaucEND["name"])));?>_<?=$objaucEND["auctionID"];?>.html" 
                    alt="<?=stripslashes($objaucEND["name"]);?>" title="<?=stripslashes($objaucEND["name"]);?>">
                    <?=stripslashes($objaucEND["name"]);?>
                </a>
            </div>
            <div class="descProduto"><?php echo stripslashes($objaucEND["short_desc"]);?></div>
        </div> <!--textosProduto -->

        <div class="latDireita">
            <center>
                <div class="descProduto" style="width:100px;"><center>Pre&ccedil;o de varejo:<br><b><?=$Currency.str_replace(".",",",$objaucEND["price"]);?></b></center></div>
                <div class="descProduto" style="width:100px;"><center>Vendido por:<br><span class="areaValor" id="price_index_page_<?=$objaucEND["auctionID"];?>"><?=$Currency.str_replace(".",",",$objaucEND["auc_final_price"]);?></center></span></div>
                <div class="usuario"><img src="img/layout/user.png"><a><?=$username_NOME!=""?$username_NOME:"---";?></a></div><br />
                <div class="descProduto" style="width:100px;">Finalizado em <center>
                <span class="areaValor"><?=date('d/m/Y', strtotime($objaucEND["auc_final_end_date"]));?>
                <br /> as <?=date('H:i:s', strtotime($objaucEND["auc_final_end_date"]));?></span></center></div>						            
            </center>
        </div>

        <div class="clear"></div>

    </div><!--.itemLeilaoFuturo -->

    <div class="clear"></div>