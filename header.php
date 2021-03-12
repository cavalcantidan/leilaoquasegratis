<?php
	include_once("config/connect.php");
	$uid = $_SESSION["userid"];
	$ipaddress = $_SERVER['REMOTE_ADDR'];
	$categoria='';
	if(isset($_GET['cat']) && $_GET['cat']>0){$categoria=' and p.categoryID='.$_GET['cat'];}

	include_once("functions.php");
	include_once("tempo_sql.php");
	include_once("sendmail.php");
	if($_SESSION["ipid"]=="" && $_SESSION["login_logout"]==""){
		$qryipins = "Insert into login_logout (ipaddress,load_time) values('".$ipaddress."',NOW())";
		mysql_query($qryipins) or die(mysql_error());
		$ipid = mysql_insert_id();
		$qryipsel = "select * from login_logout where id='$ipid'";
		$rsip = mysql_query($qryipsel);
		$obj = mysql_fetch_object($rsip);
		$_SESSION["ipid"] = $obj->load_time;
		$_SESSION["ipaddress"] = $ipaddress;
	}
	$PageNo = 1;
	if(isset($_GET['pgno'])) $PageNo = $_GET['pgno'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=<?=$lng_characset;?>" />
		<title><?php echo $AllPageTitle;?></title>
		<link rel="Shortcut Icon" type="image/x-icon" href="img/layout/favicon.ico" />
		<meta name="author" content="SISTEMAS BRASILEIROS LTDA - http://www.sistemasbrasileiros.com.br" />
		<script type="text/javascript">
			var base_url = '<?php echo $SITE_URL;?>';
			var digital = new Date(<?php  echo Date("Y, m, d, H, i, s"); // hora inicial do servidor ?>, 0);    
		</script>

		<script type="text/javascript" src="js/ajaxupload.3.5.js"></script>
		<script type="text/javascript" src="js/jquery.js"></script>
		<script type="text/javascript" src="js/jquery_ui.js"></script>
		<script type="text/javascript" src="js/util.js"></script>
		<script type="text/javascript" src="js/login.js"></script>
		<script language="JavaScript">
			<!--
			function MM_jumpMenu(targ,selObj,restore){ //v3.0
				eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
				if (restore) selObj.selectedIndex=0;
			}
			//-->
		</script>
		<?php if(isset($head_tag)) echo $head_tag;?>
		<link rel="stylesheet" media="all" type="text/css" href="css/layout.css" />
		<link rel="stylesheet" media="all" type="text/css" href="css/extra.css" />
		<link rel="stylesheet" media="all" type="text/css" href="css/estilo.css" />
	</head>

	<body onload="atualizaHoraServidor();<?php 
	if(isset($body_onload)) echo $body_onload;
	echo '" ';
	if(isset($Imagem_Fundo)) echo 'style="background: '.$Imagem_Fundo.'"';
	?>>
         <div style="<?php if($Fundo_Central!='') echo "background:$Fundo_Central;"; ?>width: 972px;margin-left: auto;margin-right: auto;">
		<div id="main">
			<div class="conteudo" <?php if(isset($Fundo_Topo)) echo 'style="background: '.$Fundo_Topo.'"';?>>
<?
	if($_SESSION['url'] && $_SESSION['url']!=$SITE_URL){
		session_destroy();
		echo "<script language='javascript'>window.location.href='index.html';</script>";
		exit;
	}

	function checkaucstatus($status){
		$st = $status;
		$qryauc = "select * from auction where auc_status='".$st."'";
		if($st=="2"){
			$qryauc = "select * from auction a left join auc_due_table adt on a.auctionID=adt.auction_id where adt.auc_due_time!=0 and auc_status='".$st."'";
		}
		$rsauc = mysql_query($qryauc);
		$totalauc = mysql_num_rows($rsauc);
		return $totalauc;
	}
	function getcatname($category){
			$qrysel = "select *,c.".$lng_prefix."name as catname from auction a left join products p on a.productID=p.productID left join categories c on a.categoryID=c.categoryID where a.categoryID=".$category." and auc_status='2'";
			$rssel = mysql_query($qrysel);
			$totalsel = mysql_num_rows($rssel);
			return $totalsel;
	}
?>
	   <div id="topo">
			<!-- Nome do site -->
			<div id="logo"><a href="index.html" title="<?php echo $AllPageTitle; ?>">
				<img src="img/layout/logo.png" />
			</a></div>
			<div id="meioTopo">   
				<div class="icones">
				<?php if($facebook!=''){?>
					<a href="<?php echo $facebook;?>" target="_blank" title="Abrir em nova Janela"><img src="img/layout/topoFacebook.png" /></a>
				<?php } if($orkut!=''){?>
					<a href="<?php echo $orkut;?>" target="_blank" title="Abrir em nova Janela"><img src="img/layout/topoOrkut.png" /></a>
				<?php } if($twitter!=''){?>
					<a href="<?php echo $twitter;?>" target="_blank" title="Abrir em nova Janela"><img src="img/layout/topoTwitter.png" /></a>
				<?php } if($youtube!=''){?>
					<a href="<?php echo $youtube;?>" target="_blank" title="Abrir em nova Janela"><img src="img/layout/topoYouTube.png" /></a>
				<?php } if($blogger!=''){?>
					<a href="<?php echo $blogger;?>" target="_blank" title="Abrir em nova Janela"><img src="img/layout/topoBlogger.png" /></a>
				<?php } if($chat!=''){?>
					<a href="<?php echo $chat;?>" target="_blank" title="Abrir em nova Janela"><img src="img/layout/chat-on.png" /></a> 
				<?php } ?>
				</div><!--.icones -->
				<?php 
				if(isset($pgPrinc)&&$NomeBannerTopo!=''){
						  echo '
				<div class="clear"></div>
			
				<div class="bannerSuperior">
					<img src="img/layout/'.$NomeBannerTopo.'" />
				</div><!--.bannerSuperior --> ';}?>
			
			</div><!--#meioTopo -->

			<div id="menuLogin">
				<? if($_SESSION["userid"]==""){ ?>
				<div id="menuTopo">
					<div class="texto">Ol&aacute; Visitante</div>
					<div class="cadastre"><a href="registration.html">Cadastre-se</a></div>
					<div class="login"><a href="#" onclick="javascript:abreMenuLogin();">Fa&ccedil;a seu login</a></div>
				<? } else { ?>
				<div id="menuLogado">
					<div class="user"><?=$lng_welcome.' '.getUserName($_SESSION["userid"]);?></div>
					<div class="lance"><?=$lng_availablebids.': <span class="atual">'.GetUserFinalBids($_SESSION["userid"]).'</span>';?></div>
					<div class="sair"><a href="logout.html"><?=$lng_logout;?></a></div> 		
				<? } ?>
				</div><!--#menu topo -->
												 
				<div id="menuLoginAjax" class="hide">
					<form action="password.html" method="post" name="frm_login" id="frm_login">
						<div class="titulo_geral">Fa&ccedil;a seu login</div>
						<div class="titulo_usuario">Usu&aacute;rio </div><div class="inputA"><input class="input_txt" type="text" name="username" value="" maxlength="12"  /></div>
						<div class="titulo_senha">Senha </div><div class="inputB"><input class="input_txt" type="password" name="password" value="" maxlength="20"  /></div>

						<input type="hidden" name="acao" value="login" />
 
						<div class="clear"></div>
						<div class="botao"><button name="login" type="submit" class="login_button" ></button></div>
						<div class="senha"><a href="forgotpassword.html">Esqueci a senha</a></div>
						<div class="clear"></div>
						<div class="cadastre"><a href="registration.html">Cadastre-se</a></div>
						<div class="fechar"><a href="#" title="Fechar" onclick="javascript:fechaMenuLogin();">X</a></div>                
					</form>              
				</div><!--#menuLoginAjax -->
			  
							
				<div class="clear"></div>		
			  
				<div id="horarioServidor">
					<div class="horarioRelogio"></div>
				</div><!--#horarioServidor -->  	
			  
			</div><!--#menuLogin -->

		</div><!--#topo -->    	
		
		<div class="clear"></div> 
		
		<div id="menu">
			<ul>
				<li class="item"><a href="index.html">home</a></li>  <!-- item_ativo -->
				<!-- <li class="item"><a href="categorias">categorias</a></li> -->
				<li class="item"><a href="all_ended_auctions_3.html">arrematados</a></li> 
				<li class="item"><a href="all_ended_auctions_1.html">futuros</a></li>
				<? if($_SESSION["userid"]==""){ ?>
				<li class="item"><a href="registration.html">cadastrar</a></li>                                  
				<? }else{ ?>              
				<li class="item"><a href="myaccount.html">minha conta</a></li>
				<? } ?> 
				<!-- <li class="item"><a href="suporte">fale conosco</a></li> -->
				<li class="item"><a href="help.html">ajuda</a></li> 
				<li class="item"><a href="how_it_works.html">como funciona</a></li>                                 
				<li class="item"><a href="contato.html">contato</a></li>                                 
				<!--li class="item"><a><select onChange="MM_jumpMenu('parent',this,0)" id="menu_cat" style="background:transparent;margin-top:5px;padding-botton:0;">
					<?php
						$tabela = mysql_query('Select categoryID, name from categories order by name');
						$link = "<option value='index.html?cat=0'style='background:transparent;'>TODAS CATEGORIAS </option>";
						
						while ($linha = mysql_fetch_array($tabela)){
							$selecionada='';
							if($categoria!='' && $linha['categoryID']==$_GET['cat']){
								$selecionada = " selected";       
							}
							$link .= "<option value='index.html?cat={$linha['categoryID']}' $selecionada>CATEGORIA: {$linha['name']}</option>";
						}
						echo $link;
					?>
				</select></a></li-->                                 
				<!-- <li class="item"><a href="vencedores">arrematantes</a></li> -->                                
							
			</ul>               
		</div><!--.menu -->

		<div id="idUsuario" style="display:none;"><?php echo $_SESSION["userid"];?></div>

		<?php 
			if(isset($pgPrinc)){
				echo '
					<div id="banner">
						<a href="'.$UrlBannerPrincipal.'"><img src="img/layout/'.$NomeBannerPrincipal.'"> </a>
					</div><!--#banner -->
					<div id="bannerCadastrado">
						<a href="'.$UrlBannerLateral.'"><img src="img/layout/'.$NomeBannerLateral.'" border="0"></a>
					</div> <!--#bannerCadastrado -->

					<div class="clear"></div>  
		
					<div id="marquee">
						<marquee id="textoMarquee">
							'.$FraseMarquee.'
						</marquee>        
					</div><!--#marquee -->';
			}
		?>