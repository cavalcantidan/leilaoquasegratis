<?php

	include("connect.php");
    include_once("admin.config.inc.php");
	include("security.php");
    $msg=$_REQUEST['msg'];
    $id=$_GET['id'];
    
  if($msg==1)
  {
    $Message1 = "Sucesso!!!<Br>";
    $Message2 = "Usu&aacute;rio apagado com sucesso!!<a href=manage_members.php> Clique Aqui </a> para voltar";
  }
  elseif($msg==2)
  {
    $Message1 = "Sucesso!!!<br>";
    $Message2 = "Usu&aacute;rio adicionado com sucesso!!!<a href='manage_members.php'> Clique Aqui </a> para voltar";
  }
  elseif($msg==3)
  {
    $Message1 = "Sucesso!!!<br>";
    $Message2 = "Informa&ccedil;&otilde;es do usu&aacute;rio atualizada com sucesso!!!<a href='manage_members.php'> Clique Aqui </a> go back";
  }
  elseif($msg==4)
  {
    $Message1 = "Desculpe!!!<br>";
    $Message2 = "Usu&aacute;rio ou Email j&aacute; existe!!!<a href='addmembers.php'> Clique Aqui </a> para voltar";
  }  
  elseif($msg==5)
  {
    $Message1 = "Sucesso!!!<br>";
    $Message2 = "Categoria adicionado com sucesso!!!<a href='managecat.php'> Clique Aqui </a> para voltar";
  }
  elseif($msg==6)
  {
    $Message1 = "Sucesso!!!<br>";
    $Message2 = "Categoria atualizado com sucesso!!!<a href='managecat.php'> Clique Aqui </a> para voltar";
  }
  elseif($msg==7)
  {
    $Message1 = "Sucesso!!!<br>";
    $Message2 = "Produto adicionado com sucesso!!!<a href='manageproducts.php'> Clique Aqui </a> para voltar";
  }
  elseif($msg==8)
  {
    $Message1 = "Sucesso!!!<br>";
    $Message2 = "Produto atualizado com sucesso!!!<a href='manageproducts.php'> Clique Aqui </a> para voltar";
  }
  elseif($msg==9)
  {
    $Message1 = "Sucesso!!!<br>";
    $Message2 = "Produto apagada com sucesso!!!<a href='manageproducts.php'> Clique Aqui </a> para voltar";
  }
  elseif($msg==10)
  {
    $Message1 = "Sucesso!!!<br>";
    $Message2 = "Este produto j&aacute; existe!!!<a href='manageproducts.php'> Clique Aqui </a> para voltar";
  }
  elseif($msg==11)
  {
    $Message1 = "Desculpe!!!<br>";
    $Message2 = "Esta categoria est&aacute; relacionado a produtos!!!<a href='managecat.php'> Clique Aqui </a> para voltar";
  }
  elseif($msg==12)
  {
    $Message1 = "Sucesso!!!<br>";
    $Message2 = "Categoria apagada com sucesso!!!<a href='managecat.php'> Clique Aqui </a> para voltar";
  }
  elseif($msg==13)
  {
    $Message1 = "Sucesso!!!<br>";
    $Message2 = "Leil&atilde;o apagada com sucesso!!!<a href='manageauction.php'> Clique Aqui </a> para voltar";
  }
  elseif($msg==14)
  {
    $Message1 = "Sucesso!!!<br>";
    $Message2 = "Leil&atilde;o adicionado com sucesso!!!<a href='manageauction.php'> Clique Aqui </a> para voltar";
  }
  elseif($msg==15)
  {
    $Message1 = "Sucesso!!!<br>";
    $Message2 = "Leil&atilde;o atualizado com sucesso!!!<a href='manageauction.php'> Clique Aqui </a> para voltar";
  }
  elseif($msg==16)
  {
    $Message1 = "Desculpe!!!<br>";
    $Message2 = "Este Leil&atilde;o Is Running!!!<a href='manageauction.php'> Clique Aqui </a> para voltar";
  }
  elseif($msg==17)
  {
    $Message1 = "Desculpe!!!<br>";
    $Message2 = "Este pacote de lance j&aacute; existe!!!<a href='managebidpack.php'> Clique Aqui </a> para voltar";
  }
  elseif($msg==18)
  {
    $Message1 = "Sucesso!!!<br>";
    $Message2 = "Pacote de lance adicionado com sucesso!!!<a href='managebidpack.php'> Clique Aqui </a> para voltar";
  }
  elseif($msg==19)
  {
    $Message1 = "Sucesso!!!<br>";
    $Message2 = "Pacote de lance atualizado com sucesso!!!<a href='managebidpack.php'> Clique Aqui </a> para voltar";
  }
  elseif($msg==20)
  {
    $Message1 = "Sucesso!!!<br>";
    $Message2 = "Pacote de lance apagada com sucesso!!!<a href='managebidpack.php'> Clique Aqui </a> para voltar";
  }
  elseif($msg==21)
  {
    $Message1 = "Desculpe!!!<br>";
    $Message2 = "Este t&oacute;pico de ajuda j&acute; existe!!!<a href='managehelptopic.php'> Clique Aqui </a> para voltar";
  }
  elseif($msg==22)
  {
    $Message1 = "Sucesso!!!<br>";
    $Message2 = "T&oacute;pico de ajuda adicionado com sucesso!!!<a href='managehelptopic.php'> Clique Aqui </a> para voltar";
  }
  elseif($msg==23)
  {
    $Message1 = "Sucesso!!!<br>";
    $Message2 = "T&oacute;pico de ajuda atualizado com sucesso!!!<a href='managehelptopic.php'> Clique Aqui </a> para voltar";
  }
  elseif($msg==24)
  {
    $Message1 = "Sucesso!!!<br>";
    $Message2 = "T&oacute;pico de ajuda apagada com sucesso!!!<a href='managehelptopic.php'> Clique Aqui </a> para voltar";
  }
  elseif($msg==25)
  {
    $Message1 = "Sucesso!!!<br>";
    $Message2 = "FAQ adicionado com sucesso!!!<a href='manageFAQ.php'> Clique Aqui </a> para voltar";
  }
  elseif($msg==26)
  {
    $Message1 = "Sucesso!!!<br>";
    $Message2 = "FAQ atualizado com sucesso!!!<a href='manageFAQ.php'> Clique Aqui </a> para voltar";
  }
  elseif($msg==27)
  {
    $Message1 = "Desculpe!!!<br>";
    $Message2 = "Esta FAQ j&acute; existe!!!<a href='manageFAQ.php'> Clique Aqui </a> para voltar";
  }
  elseif($msg==28)
  {
    $Message1 = "Sucesso!!!<br>";
    $Message2 = "FAQ apagada com sucesso!!!<a href='manageFAQ.php'> Clique Aqui </a> para voltar";
  }
  elseif($msg==29)
  {
    $Message1 = "Sucesso!!!<br>";
    $Message2 = "Conte&uacute;do atualizado com sucesso!!!<a href='staticpages.php?id=".$_GET["id"]."'> Clique Aqui </a> para voltar";
  }
  elseif($msg==30)
  {
    $Message1 = "Sucesso!!!<br>";
    $Message2 = "Not&iacute;cia adicionada com sucesso!!!<a href='managenews.php'> Clique Aqui </a> para voltar";
  }
  elseif($msg==31)
  {
    $Message1 = "Sucesso!!!<br>";
    $Message2 = "Not&iacute;cia exite para essa data!!!<a href='managenews.php'> Clique Aqui </a> para voltar";
  }
  elseif($msg==32)
  {
    $Message1 = "Sucesso!!!<br>";
    $Message2 = "Not&iacute;cia atualizada com sucesso!!!<a href='managenews.php'> Clique Aqui </a> para voltar";
  }
  elseif($msg==33)
  {
    $Message1 = "Sucesso!!!<br>";
    $Message2 = "Not&iacute;cia apagada com sucesso!!!<a href='managenews.php'> Clique Aqui </a> para voltar";
  }
  elseif($msg==34)
  {
    $Message1 = "Sucesso!!!<br>";
    $Message2 = "Produto j&acute; existe !!!<a href='manageauctiontime.php'> Clique Aqui </a> para voltar";
  }
  elseif($msg==35)
  {
    $Message1 = "Sucesso!!!<br>";
    $Message2 = "Produto adicionado com sucesso!!!<a href='manageauctiontime.php'> Clique Aqui </a> para voltar";
  }
  elseif($msg==36)
  {
    $Message1 = "Sucesso!!!<br>";
    $Message2 = "Produto atualizado com sucesso!!!<a href='manageauctiontime.php'> Clique Aqui </a> para voltar";
  }
  elseif($msg==37)
  {
    $Message1 = "Sucesso!!!<br>";
    $Message2 = "Produto apagada com sucesso!!!<a href='manageauctiontime.php'> Clique Aqui </a> para voltar";
  }
  elseif($msg==38)
  {
    $Message1 = "Sucesso!!!<br>";
    $Message2 = "Leil&atilde;o Setting atualizado com sucesso!!!<a href='manageauctiontime.php'> Clique Aqui </a> para voltar";
  }
  elseif($msg==39)
  {
    $Message1 = "Sucesso!!!<br>";
    $Message2 = "Transportadora atualizado com sucesso!!!<a href='manageshippingcharge.php'> Clique Aqui </a> para voltar";
  }
  elseif($msg==40)
  {
    $Message1 = "Sucesso!!!<br>";
    $Message2 = "Leil&atilde;o tempo de pausa atualizado com sucesso!!!<a href='#'> Clique Aqui </a> para voltar";
  }
  elseif($msg==41)
  {
    $Message1 = "Desculpe!!!<br>";
    $Message2 = "Esta Produto exite no leil&atilde;o!!!<a href='manageproducts.php'> Clique Aqui </a> para voltar";
  }
  elseif($msg==42)
  {
    $Message1 = "Sucesso!!!<br>";
    $Message2 = "Boletim informativo apagada com sucesso!!!<a href='managenewslatters.php'> Clique Aqui </a> para voltar";
  }
  elseif($msg==43)
  {
    $Message1 = "Sucesso!!!<br>";
    $Message2 = "Boletim informativo Send com sucesso!!!<a href='managenewslatters.php'> Clique Aqui </a> para voltar";
  }
  elseif($msg==44)
  {
    $Message1 = "Sucesso!!!<br>";
    $Message2 = "Lance Cr/Dr com sucesso!!!<a href='addbonusbid.php'> Clique Aqui </a> para voltar";
  }
  elseif($msg==45)
  {
    $Message1 = "Sucesso!!!<br>";
    $Message2 = "Transportadora adicionado com sucesso!!!<a href='manageshippingcharge.php'> Clique Aqui </a> para voltar";
  }
  elseif($msg==46)
  {
    $Message1 = "Sucesso!!!<br>";
    $Message2 = "Transportadora apagada com sucesso!!!<a href='manageshippingcharge.php'> Clique Aqui </a> para voltar";
  }
  elseif($msg==47)
  {
    $Message1 = "Desculpe!!!<br>";
    $Message2 = "Esta Transportadora j&acute; existe !!!<a href='manageshippingcharge.php'> Clique Aqui </a> para voltar";
  }
  elseif($msg==48)
  {
    $Message1 = "Sucesso!!!<br>";
    $Message2 = "Transportadora atualizado com sucesso !!!<a href='manageshippingcharge.php'> Clique Aqui </a> para voltar";
  }
  elseif($msg==49)
  {
    $Message1 = "Desculpe!!!<br>";
    $Message2 = "Esta Transportadora est&aacute; em uso no Leil&atilde;o !!!<a href='manageshippingcharge.php'> Clique Aqui </a> para voltar";
  }
  elseif($msg==50)
  {
    $Message1 = "Desculpe!!!<br>";
    $Message2 = "Usu&aacute;rio j&acute; existe!!!<a href='addadminmember.php'> Clique Aqui </a> go back";
  }
  elseif($msg==51)
  {
    $Message1 = "Sucesso!!!<br>";
    $Message2 = "Usu&aacute;rio adicionado com sucesso!!!<a href='manageadminmember.php'> Clique Aqui </a> para voltar";
  }
  elseif($msg==52)
  {
    $Message1 = "Sucesso!!!<br>";
    $Message2 = "Usu&aacute;rio Information atualizado com sucesso!!!<a href='manageadminmember.php'> Clique Aqui </a> go back";
  }
  elseif($msg==53)
  {
    $Message1 = "Sucesso!!!<Br>";
    $Message2 = "Membro apagado com sucesso!!!<a href=manageadminmember.php> Clique Aqui </a> para voltar";
  }
  elseif($msg==54)
  {
    $Message1 = "Desculpe!!!<Br>";
    $Message2 = "Acesso Negado!!!<a href=manageadminmember.php> Clique Aqui </a> para voltar";
	if(strpos($_SERVER['HTTP_REFERER'],'paypalsetting.php')){
		$Message1 = "Sucesso!!!<Br>";
		$Message2 = "Altera&ccedil;&atilde;o Conclu&iacute;da!!!<a href=paypalsetting.php> Clique Aqui </a> para voltar";
	}
	if(strpos($_SERVER['HTTP_REFERER'],'pagsegurosetting.php')){
		$Message1 = "Sucesso!!!<Br>";
		$Message2 = "Altera&ccedil;&atilde;o Conclu&iacute;da!!!<a href=pagsegurosetting.php> Clique Aqui </a> para voltar";
	}
  }
  elseif($msg==55)
  {
    $Message1 = "Sucesso!!!<Br>";
    $Message2 = "Senha alterada com sucesso!!!<a href=editaccount.php> Clique Aqui </a> para voltar";
  }
  elseif($msg==56)
  {
    $Message1 = "Desculpe!!!<Br>";
    $Message2 = "Este Leil&atilde;o j&acute; existe!!!<a href=addauction.php> Clique Aqui </a> para voltar";
  }
  elseif($msg==57)
  {
    $Message1 = "Sucesso!!!<br>";
    $Message2 = "Arremessa de lance b&ocirc;nus atualizado com sucesso!!!<a href='managereferralbid.php'> Clique Aqui </a> para voltar";
  }
  elseif($msg==58)
  {
    $Message1 = "Sucesso!!!<br>";
    $Message2 = "Arremessa de lance b&ocirc;nus adicionado com sucesso!!!<a href='managereferralbid.php'> Clique Aqui </a> para voltar";
  }
  elseif($msg==59)
  {
    $Message1 = "Sucesso!!!<br>";
    $Message2 = "Email de verifica&ccedil;&atilde;o re-enviado com sucesso!!!<a href='manage_members.php'> Clique Aqui </a> para voltar";
  }
  elseif($msg==60)
  {
    $Message1 = "Sucesso!!!<br>";
    $Message2 = "Caracter&iacute;stica do Leil&atilde;o adicionado com sucesso!!!<a href='managefeatureauction.php'> Clique Aqui </a> para voltar";
  }
  elseif($msg==61)
  {
    $Message1 = "Sucesso!!!<br>";
    $Message2 = "Caracter&iacute;stica do Leil&atilde;o atualizado com sucesso!!!<a href='managefeatureauction.php'> Clique Aqui </a> para voltar";
  }
  elseif($msg==62)
  {
    $Message1 = "Desculpe!!!<br>";
    $Message2 = "Esta caracter&iacute;stica do Leil&atilde;o est&aacute; rodando!!!<a href='managefeatureauction.php'> Clique Aqui </a> para voltar";
  }
  elseif($msg==63)
  {
    $Message1 = "Sucesso!!!<br>";
    $Message2 = "Caracter&iacute;stica do Leil&atilde;o apagada com sucesso!!!<a href='managefeatureauction.php'> Clique Aqui </a> para voltar";
  }
  elseif($msg==64)
  {
    $Message1 = "Desculpe!!!<br>";
    $Message2 = "Este Cupom j&acute; existe!!!<a href='managevoucher.php'> Clique Aqui </a> para voltar";
  }
  elseif($msg==65)
  {
    $Message1 = "Sucesso!!!<br>";
    $Message2 = "Cupom adicionado com sucesso!!!<a href='managevoucher.php'> Clique Aqui </a> para voltar";
  }
  elseif($msg==66)
  {
    $Message1 = "Sucesso!!!<br>";
    $Message2 = "Cupom atualizado com sucesso!!!<a href='managevoucher.php'> Clique Aqui </a> para voltar";
  }
  elseif($msg==67)
  {
    $Message1 = "Sucesso!!!<br>";
    $Message2 = "Cupom apagada com sucesso!!!<a href='managevoucher.php'> Clique Aqui </a> para voltar";
  }
  elseif($msg==68)
  {
    $Message1 = "Sucesso!!!<br>";
/*    $Message2 = "Manage Currency atualizado com sucesso!!!<a href='currencymanage.php'> Clique Aqui </a> para voltar";*/
    $Message2 = "Valor de lance m&iacute;nimo atualizado com sucesso!!!<a href='generalsetting.php'> Clique Aqui </a> para voltar";
  }
  elseif($msg==69)
  {
    $Message1 = "Sucesso!!!<br>";
    $Message2 = "Novo Usu&aacute;rio Cupom Set com sucesso!!!<a href='voucherissue.php'> Clique Aqui </a> para voltar";
  }
  elseif($msg==70)
  {
    $Message1 = "Sucesso!!!<br>";
    $Message2 = "Cupom emitido com sucesso!!!<a href='voucherissue.php'> Clique Aqui </a> para voltar";
  }
  elseif($msg==71)
  {
    $Message1 = "Sucesso!!!<br>";
    $Message2 = "Boletim informativo enviado e salvo com sucesso!!!<a href='managenewslatters.php'> Clique Aqui </a> para voltar";
  }
  elseif($msg==72)
  {
    $Message1 = "Sucesso!!!<br>";
    $Message2 = "Boletim informativo salvo com sucesso!!!<a href='managenewslatters.php'> Clique Aqui </a> para voltar";
  }
  elseif($msg==73)
  {
    $Message1 = "Sucesso!!!<br>";
    $Message2 = "Configura&ccedil&otilde;es SMS atualizado com sucesso!!!<a href='perdaysms.php'> Clique Aqui </a> para voltar";
  }
  elseif($msg==74)
  {
    $Message1 = "Desculpe!!!<br>";
    $Message2 = "Este Cupom foi emitido para o Usu&aacute;rio voc&ecirc; n&atilde;o pode apag&aacute;-lo.!!!<a href='managevoucher.php'> Clique Aqui </a> para voltar";
  }
  elseif($msg==75)
  {
    $Message1 = "Sucesso!!!<br>";
    $Message2 = "Bidding Usu&aacute;rio adicionado com sucesso!!!<a href='managebiddinguser.php'> Clique Aqui </a> para voltar";
  }
  elseif($msg==76)
  {
    $Message1 = "Desculpe!!!<br>";
    $Message2 = "Usu&aacute;rio or Email j&acute; existe!!!<a href='managebiddinguser.php'> Clique Aqui </a> go back";
  }
  elseif($msg==77)
  {
    $Message1 = "Sucesso!!!<br>";
    $Message2 = "Informa&ccedil;&otilde;es de lances do Usu&aacute;rio atualizado com sucesso!!!<a href='managebiddinguser.php'> Clique Aqui </a> para voltar";
  }
  elseif($msg==78)
  {
    $Message1 = "Sucesso!!!<br>";
    $Message2 = "Lances do Usu&aacute;rio apagados com sucesso!!!<a href='managebiddingusuer.php'> Clique Aqui </a> para voltar";
  }

  elseif($msg==79)
  {
    $Message1 = "Sucesso!!!<br>";
    $Message2 = "Conte&uacute;do do Google Addsens atualizado com sucesso!!!<a href='manageaddsens.php'> Clique Aqui </a> para voltar";
  }
  elseif($msg==80)
  {
    $Message1 = "Sucesso!!!<br>";
    $Message2 = "Usu&aacute;rio verificado com sucesso!!!<a href='manage_members.php'> Clique Aqui </a> para voltar";
  }
  elseif($msg==81)
  {
    $Message1 = "Sucesso!!!<br>";
    $Message2 = "Arremessa de lance b&ocirc;nus adicionado com sucesso!!!<a href='managecadbid.php'> Clique Aqui </a> para voltar";
  }elseif($msg==82){
    $Message1 = "Alerta!!!<br>";
    $Message2 = "Configura&ccedil;&atilde;o de acesso ao PagSeguro n&atilde;o definida pelo administrador do site, por favor entre em contato com o suporte!";
  }else{
	$Message1 = "Sucesso!!!<br>";
    $Message2 = "Configura&ccedil;&otilde;es Salvas com Sucesso!!";
  }
?>

<html>

<head>

<title>Bem vindo ao <?php echo $ADMIN_MAIN_SITE_NAME ?></title>

<meta http-equiv="Content-Type" content="text/html; charset=<?=$lng_characset;?>">

<LINK 
href="main.css" type=text/css rel=stylesheet><LINK 
href="demo.css" type=text/css rel=stylesheet>

<script language="JavaScript">

<!--

function MM_reloadPage(init) {  //reloads the window if Nav4 resized

  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {

    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}

  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();

}

MM_reloadPage(true);

// -->

</script>

</head>



<body bgcolor="<?php echo $ADMIN_MAIN_PAGES_BG_COLOR ?>" text="<?php echo $ADMIN_MAIN_PAGES_TEXT_COLOR ?>" link="<?php echo $ADMIN_MAIN_PAGES_LINKS_COLOR ?>" vlink="<?php echo $ADMIN_MAIN_PAGES_LINKS_COLOR ?>" alink="<?php echo $ADMIN_MAIN_PAGES_LINKS_COLOR ?>" leftmargin="0" marginwidth="0" marginheight="0">
<table width="80%" bordercolor="#000000" bgcolor="#eeeeee" cellspacing="0" cellpadding="0" align="center" border="1" style="margin-top: 2cm;">
        <tr>
          <td>
		  <table border="0" cellpadding="0" cellspacing="0" align="center">
		  <tr>
          <td>
            <div align="center"><font face="Verdana" size="2">
              <?php echo $Message1 ?>
              </font></div>
          </td>
        </tr>
		<tr>
          <td>
            <div align="center"><font face="Verdana" size="2">
              <?php echo $Message2 ?>
              </font></div>
				</td>
        		</tr>  
			  </table>
          </td>
        </tr>
      </table>
</body>

</html>

