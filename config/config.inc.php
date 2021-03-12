<?php
    session_start();
    date_default_timezone_set("America/Sao_Paulo");

    $DBSERVER ="ec2-54-162-119-125.compute-1.amazonaws.com";  //servidor "localhost"
    $USERNAME = "crwcxvygkbhmwc";  // usuario .."root"
    $PASSWORD = "8a9e977c59af500429c8914b26d5952629b5ef0a16d41a97dc667bc15e695b15";  //senha
    $DATABASENAME = "deknapmv354jqd";  //banco de dados
    $SITE_URL = "https://www.leilaoquasegratis.com";  // endereco do seu site
    $AllPageTitle = "Bem Vindo ao leil&atilde;o";  // Titulo geral
    $adminemailadd = "dancavalcanti.bjj@gmail.com";  // e-mail para clientes entrarem em contato
    $ADMIN_MAIN_SITE_NAME="webmaster";  // nome que deseja que apareca para o cliente
    $use_stored = true;
    $aceite_lance_futuro =  true;
    $qt_leiloes_eminentes = 20;

    // se possuir algum dos canais abaixo preencha o endereco 
    // e o icone correspondente aparecera no topo da pagina
    $facebook  = '#';
    $twitter   = '#';
    $youtube   = '#';
    $blogger   = '#';
    $chat      = '#';

    // Opcionalmente informe uma cor de fundo e/ou imagem para ser o fundo do site seguindo o exemplo:
    // transparent url('img/layout/fundo.png')      ou #F0A3D7 url('img/layout/fundo.png')  ou red url('img/layout/outro.png')
    $Imagem_Fundo = "";
    $Fundo_Topo = "";
    $Fundo_Central = "transparent;border-width: 2px;border-color:black;border-left-style: solid;border-right-style: solid;";

    // Imagens Logo'
    $NomeBannerTopo = '';//'banner_topo.jpg';
    $NomeBannerPrincipal = 'banner.jpg';
    $NomeBannerLateral   = 'bannerLateral.png';
    $NomeBannerColunaLateral   = 'bannerColunaLateral.png.gif';

    // Link dos banner na tela principal
    $UrlBannerPrincipal = 'registration.html';
    $UrlBannerLateral   = 'registration.html';
    $FraseMarquee       = 'Cadastre-se agora mesmo!<a href="registration.html"> clique aqui </a>
                           e ganhe 5 cr&eacute;ditos gr&aacute;tis para come&ccedil;ar a participar do melhor site de web lances da internet.';

    // os dados abaixo nao foram testados nem implementados por nos.
    $SMSUSERNAME = "";
    $SMSPASSWORD = "";
    $SMSIPPAGE = "";

    $PRODUCTSPERPAGE = 10;
    $PRODUCTSPERPAGE_MYACCOUNT = 20;
    $total_per_ini2 = 10;
    $max_pages2=100;
    $items_per_page2 = 5;

    $Currency = "R$ ";
    $SMSrate = 1.50;
    $SMSsendnumber = "";

    $paypaltoken = "";
?>