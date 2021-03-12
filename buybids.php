<?
	include("config/connect.php");
	include("session.php");
	include("functions.php");

    $head_tag = '<link href="css/menu.css" rel="stylesheet" type="text/css" />
    <link href="css/style_youbid.css" rel="stylesheet" type="text/css" />
    <link href="css/estilo.css" rel="stylesheet" type="text/css" />'; 


	$uid = $_SESSION["userid"];
	
	$qrysel = "select *,".$lng_prefix."bidpack_banner as bidpack_banner,".$lng_prefix."bidpack_name as bidpack_name from bidpack order by id";
	$rssel = mysql_query($qrysel);
	$totalbpack = mysql_num_rows($rssel);
	if($totalbpack>0){$selected = ceil($totalbpack/2);}
    include("header.php");
?>
<div id="conteudo-principal">
    <?
       include("leftside.php");  
    ?>
    <div id="conteudo-conta" style="width:74%;">
            <h3 id="comprar-tit"> <?=$lng_tabbuybids;//$lng_myauctionsavenue;?></h3>
            <!-- explicacao do meio de pagamento -->
            <img border="0" src="img/pgseg.jpg" width="365" height="57" /><br />
            <?=$lng_youchoosen2;?> <hr style="border:1px solid; margin:10px 0;" />
            <!-- fim da explicacao do meio de pagamento -->
	<?
		$qrysel = "select * from bidpack";
		$ressel = mysql_query($qrysel);
		$obj = mysql_fetch_object($ressel);
        $Item=0;
        while($obj = mysql_fetch_array($rssel)){
            $Item++;
	?>
        <div id="pacotes">
            <div class="bidpackimage" style="width:260px; float:left"><img src="uploads/bidpack/<?=$obj["bidpack_banner"];?>" border="0" /></div>
            <span class="pacote-escolha"><p>
                <span class="pacote-escolha-tit"><? echo $obj['bidpack_name'];?></span>
                <span class='pacote-escolha-info'><b><? echo $obj['bid_size']." Lances / ".$Currency.$obj['bid_price'] ;?></b></span>
                <form name="payment_<? echo $Item;?>" action="buybidspayment.php" method="post">
                    <span class="finalizar-compra-bt">
                        <input name="cnfbuybids" value="" type="image" src="imagens/comprarlances.gif" width="115" height="54" hspace="0" vspace="0" border="0" onmouseover="this.style.margin='-27px 0 0 0'" onmouseout="this.style.margin='0 0 0 0'" />
                    </span>
                    <input type="hidden" name="acao" value="cl" />
                    <input type="hidden" name="bpid" value="<?=base64_encode($obj['id']);?>" />
                </form>                 
                
            </span>
        </div> <!-- Fim pacotes -->
        <hr style="border:1px solid; margin:10px 0;" />

    <? } ?>
    </div>
</div>
<? include("footer.php"); ?>