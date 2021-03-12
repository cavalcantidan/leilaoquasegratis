<?
	include("config/connect.php");
	include("session.php");
	include("functions.php");
	$uid = $_SESSION["userid"];
	$qrysel = "select *,".$lng_prefix."bidpack_banner as bidpack_banner,".$lng_prefix."bidpack_name as bidpack_name from bidpack order by id";
	$rssel = mysql_query($qrysel);
	$totalbpack = mysql_num_rows($rssel);
	if($totalbpack>0){
		$selected = ceil($totalbpack/2);
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?=$lng_characset;?>" />
<title><?=$AllPageTitle;?></title>
<link href="css/style_youbid.css" rel="stylesheet" type="text/css" />
<link href="css/estilo.css" rel="stylesheet" type="text/css" />
<!--[if IE 8]>
<link href="css/estiloie8.css" rel="stylesheet" type="text/css" />
<![endif]-->
<!--[if IE 7]>
<link href="css/estiloie7.css" rel="stylesheet" type="text/css" />
<![endif]-->
<script language="javascript" type="text/javascript" src="js/function.js"></script>
<script language="javascript">
	function setname(name){
		var temp = document.getElementById('bidpackname'+name).value;
		document.getElementById('bidpackname').innerHTML = temp;
	}
</script>
</head>
<?
    $bodyIni='';
	if($_POST["buybids"]=="" and $_GET["pkg"]=="" and $selected!=""){ $bodyIni=' onload="setname('.$selected.'"'; }
?>
<body <?=$bodyIni;?>>

<div id="conteudo-principal">
    <? include("header.php"); ?>
    <? include("leftside.php"); ?>
    <div id="conteudo-conta">
	<?
	if($_POST["buybids"]!="" or $_GET["pkg"]!=""){
		$id = $_GET["pkg"];
		$qrysel = "select *,".$lng_prefix."bidpack_name as bidpack_name from bidpack where id=$id";
		$ressel = mysql_query($qrysel);
		$obj = mysql_fetch_object($ressel);
	?>
        <div id="pacotes">
            <h3 id="comprar-tit"><?=$lng_myauctionsavenue;?> - <?=$lng_tabbuybids;?></h3>
            <span class="pacote"></span>
            <span class="pacote-escolha"><p>
                <span class="pacote-escolha-voce"><?=$lng_youchoosen1;?></span><br />
                <span class="pacote-escolha-tit"><? echo $obj->bidpack_name;?></span>
                <span class='pacote-escolha-info'><b><? echo $obj->bid_size." Lances / ".$Currency.$obj->bid_price ;?></b></span>
                <?=$lng_youchoosen2;?>
            </span>
        </div> <!-- Fim pacotes -->

        <!-- meio de pagamento -->
        <h3 id="comprar-tit" style="margin-top:60px;"><?=$lng_paymentmethod;?></h3>
        <script>
        function teste1(){				
        	for(i=0; i<document.payment.paymentmethod.length; i++){ 
        		if(document.payment.paymentmethod[i].checked==true){
        			if(document.payment.paymentmethod[i].value == "pagseguro"){
        				bpid = document.payment.bidpackid.value;
        				window.location.href='buybidspayment.php?bpid='  + bpid;
        			}
        			if(document.payment.paymentmethod[i].value == "paypal"){
        				bpid = document.payment.bidpackid.value;
        				window.location.href='_buybidspayment2.php?bpid='  + bpid;
        			}
        		}
        	}
        }
        </script>
        <form name="payment" action="javascript:teste1();" method="post">
            <input type="radio" name="paymentmethod" value="pagseguro"/>
            <img border="0" src="img/pgseg.jpg" width="365" height="57" />
            <hr style="border:1px solid; margin:10px 0;" />
            <input type="radio" name="paymentmethod" value="paypal" style="display:none;" />
            <img border="0" src="img/pay.jpg" style="display:none;" />
            <input type="hidden" name="bidpackid" value="<?=base64_encode($id);?>" />
            <input type="hidden" name="bidpacksize" value="<?=$obj->bid_size;?>" />
            <span class="finalizar-compra-bt"><input name="cnfbuybids" value="" type="image" src="imagens/comprarlances.gif" width="115" height="54" hspace="0" vspace="0" border="0" onmouseover="this.style.margin='-27px 0 0 0'" onmouseout="this.style.margin='0 0 0 0'" /></span>
        </form>
    <? }else{ ?>
        <h3 id="comprar-tit"><?=$lng_myauctionsavenue;?> - <?=$lng_tabbuybids;?></h3>
        <ul id="pacotes">
        <?
    	$i = 1;
    	$a = 1;
    	while($obj = mysql_fetch_array($rssel)){
    		$bname = $obj["bidpack_name"];
    		$separavalor = explode(" ",$bname); 
        ?>
            <li><span class="pacote"></span>
                <a href='buybids.html?pkg=<?=$obj["id"];?>' class="pacotelink">
                    <p class="txt-pacote"><?=$separavalor[0];?></p>
                    <p class="txt-titulo"><?=$separavalor[1];?></p>
                    <p class="txt-lance"><?=$obj["bid_size"];?> <?=$lng_bidsfor;?></p>
                    <p class="txt-valor"> <?=$Currency;?><?=$obj["bid_price"];?></p>
                    <p class="pacote-comprar">COMPRAR</p>
                </a>
                <input type="hidden" value="<?=$obj["bidpack_name"];?>" name="bidpackname<?=$i;?>" id="bidpackname<?=$i;?>" />
            </li>	
        <?
    		$i++;
    		$a++;
    	}
        ?>
        </ul>
    <?
    }
    ?>
    </div>
<? include("footer.php"); ?>
</div>
</body>
</html>
