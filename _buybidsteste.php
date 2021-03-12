<?
	include("config/connect.php");
	include("session.php");
	include("functions.php");
	$uid = $_SESSION["userid"];
	$qrysel = "select *,".$lng_prefix."bidpack_banner as bidpack_banner,".$lng_prefix."bidpack_name as bidpack_name from bidpack order by id";
	$rssel = mysql_query($qrysel);
	$totalbpack = mysql_num_rows($rssel);
	if($totalbpack>0)
	{
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
	function setname(name)
	{
		var temp = document.getElementById('bidpackname'+name).value;
		document.getElementById('bidpackname').innerHTML = temp;
	}
</script>
</head>
<?
	if($_POST["buybids"]!="" or $_GET["pkg"]!="")
	{
?>
<body>
<?
	}
	else{
		if($selected!="")
		{
?>
<body onload="setname(<?=$selected;?>);">
<?
		}
	}
?>

<div id="conteudo-principal">

<?
	include("header.php");
?>

			<? include("leftside.php"); ?>
<div id="conteudo-conta">

				<?
				if($_POST["buybids"]!="" or $_GET["pkg"]!="")
				{
					$id = $_GET["pkg"];
					$qrysel = "select *,".$lng_prefix."bidpack_name as bidpack_name from bidpack where id=$id";
					$ressel = mysql_query($qrysel);
					$obj = mysql_fetch_object($ressel);
				?>
                
<div id="pacotes">
<span class="pacote"></span>
<a class="pacotelink"><p class="txt-pacote">pacote</p><p class="txt-titulo">XLS</p><p class="txt-lance">30 lances por</p><p class="txt-valor"> R$30,00</p><p class="pacote-comprar">COMPRAR</p></a>
<span class="pacote-escolha"><?=$lng_youchoosen1;?> <b><? echo $obj->bidpack_name ?></b>. <?=$lng_youchoosen2;?></span>
<!-- / pacotes -->
</div>
				<div style="height:10px;">&nbsp;</div>
				<div style="float: left; margin-left: 10px; width: 260px; height:110px; padding-right: 10px;"><img src="uploads/bidpack/<?=$obj->bidpack_banner;?>" border="0"/></div>
				<div style="float:left; text-align: left; width: 460px; padding-top: 10px;" class="buybidpacktitle"><?=$lng_buybidpack;?></div>
				<div style="padding-left: 15px; font-family: Arial, Helvetica, sans-serif; font-size: 12px; padding-right: 10px; text-align: left; padding-top: 10px;"><br /><br /></div>
			<div style="clear: both; float:left; padding-left: 7px; padding-top: 10px; text-align: left;">
				<div style="width: 720px; height: 25px; background-image: url(images/openOuction_bar-middle.jpg); background-repeat: repeat-x; border-left: 1px solid  #cddce9;  border-right: 1px solid  #cddce9;">
					<div style="font-size: 14px; padding-top: 5px; padding-left: 20px;"><?=$lng_paymentmethod;?></div>
				</div>
				<div style="clear: both; height:10px;">&nbsp;</div>
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
                    <input type="radio" name="paymentmethod" value="pagseguro"/><img border="0" src="img/pgseg.jpg" width="365" height="57"><hr style="border:1px solid; margin:10px 0;" />
                    <input type="radio" name="paymentmethod" value="paypal" /><img border="0" src="img/pay.jpg">
                    <input type="hidden" name="bidpackid" value="<?=base64_encode($id);?>" />
                    <input type="hidden" name="bidpacksize" value="<?=$obj->bid_size;?>" />
                    <input type="submit" name="cnfbuybids" value="" style="background:#ffffff url('<?=$lng_imagepath;?>buy bids-1.png') no-repeat; width:150px; height:32px; cursor: pointer; float:right; border:0;"/>
				</form>
               </div>
				<?
				}
				else
				{
				?>
<h3 id="comprar-tit"><?=$lng_myauctionsavenue;?> - <?=$lng_tabbuybids;?></h3>
						<ul id="pacotes">
						<?
							$i = 1;
							$a = 1;
							while($obj = mysql_fetch_array($rssel))
							{
								$bname = $obj["bidpack_name"];
								$separavalor = explode(" ",$bname); 
						?>

<li><span class="pacote"></span><a href='buybids.html?pkg=<?=$obj["id"];?>' class="pacotelink"><p class="txt-pacote"><?=$separavalor[0];?></p><p class="txt-titulo"><?=$separavalor[1];?></p><p class="txt-lance"><?=$obj["bid_size"];?> <?=$lng_bidsfor;?></p><p class="txt-valor"> <?=$Currency;?><?=$obj["bid_price"];?></p><p class="pacote-comprar">COMPRAR</p></a>


							
						<?
								$i++;
								$a++;
							}
						?>
</ul>
<?	}	?>
</div>
<?
	include("footer.php");
?>
</div>
</body>
</html>
