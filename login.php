<?
	include("config/connect.php");
	include("functions.php");
	$uid  = $_SESSION["userid"];
	$qryauc = "select *, p.productID as pid, p.".$lng_prefix."name as name from auction a left join products p on a.productID=p.productID left join auc_due_table adt on a.auctionID=adt.auction_id where adt.auc_due_time!=0 and a.auc_status=2 order by adt.auc_due_time limit 0,3";
	$resauc = mysql_query($qryauc);
	$totalauc = mysql_num_rows($resauc);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=<?=$lng_characset;?>" />
	<title><?=$AllPageTitle;?></title>
	<link href="css/style_youbid.css" rel="stylesheet" type="text/css" />
	<link href="css/menu.css" rel="stylesheet" type="text/css" />
	<link href="css/estilo.css" rel="stylesheet" type="text/css" />
	<!--[if IE 8]>
	<link href="css/estiloie8.css" rel="stylesheet" type="text/css" />
	<![endif]-->
	<!--[if IE 7]>
	<link href="css/estiloie7.css" rel="stylesheet" type="text/css" />
	<![endif]-->
	<!--[if lte IE 6]>
	<link href="css/menu_ie.css" rel="stylesheet" type="text/css" />
	<![endif]-->
	<script language="javascript" src="js/function.js"></script>
	<script language="javascript" src="js/jquery.js"></script>
	<script language="javascript" src="js/effect.js"></script>
	<script language="javascript" src="js/default.js"></script>
	<script language="javascript" src="js/jqModal.js"></script>
</head>

<body onload="OnloadPage();">
<?
	include("header.php");
	if($totalauc>0){
?>
	<div id="cleaner"></div>
	<div class="openAuction_bar_bottom"></div>
	<?
	 }
	?>
	<div id="conteudo-principal">
		<h2 style="display:none"><?=$lng_aucavenuelogin;?></h2>
		<center><br /><br /><h2>Por favor efetue o login no sistema, caso seja um novo usu&aacute;rio registre-se.</h2><br /></center>
		<!--div id="login-user">
			<form name="f1" method="post" action="password.html">
				<p><?=$lng_alreadyregister;?></p>
				<p><?=$lng_logindata;?></p>
				<p><label><?=$lng_username;?>:</label><input type="text" name="username" id="username" class="login-input2" />
				<p><label><?=$lng_password;?>:</label><input type="password" name="password" id="password" class="login-input2" />
				<p><span id="login-entrar2"><input name="" type="image" src="imagens/login-entrar2.png" width="131" height="27" hspace="0" vspace="0" border="0" onmouseover="this.style.margin='0 0 0 -66px'" onmouseout="this.style.margin='0 0 0 0'" /></span></p>
				<p id="login-esqueceu"><a href="#"><?=$lng_forgotdata;?></a></p>
				<p id="login-esqueceu"><a href="registration.html">Registre-se</a></p>
				<p id="login-esqueceu"><a href="help.html">Saiba mais</a></p>
				< ?php $msg_erro='';
					if($_GET["err"]==1){ $msg_erro=$lng_invaliddata;}
				elseif($_GET['err']==2){$msg_erro=$lng_accountsuspend;}
				elseif($_GET['err']==3){$msg_erro=$lng_accountdelete;}
				elseif($_GET['err']==4){$msg_erro=$lng_enterdata;}
				elseif($_GET['err']==5){$msg_erro=$lng_enterpassword;}
				if($_GET['err']>0){ echo '<p class="login-aviso">'.$msg_erro.'</p>';}
				?>
			</form>
		</div-->
		<? include("footer.php"); ?>		
		<span style="display: none;" class="firstimagebold" id="firstimage_bold"><?=$totalauc;?></span>
		<div style="clear:both"></div>
	</div>
</body>
</html>
