<?php
  $MainLinksArray = array (
  	array("Relat&oacute;rio Financeiro","#",1),
  	array("Relat&oacute;rio Geral","#",1),
  	array("Relat&oacute;rio Acesso","#",1),
	);

if($_SESSION["type"]=="1"||$_SESSION["type"]=="2"){

  $ChildLinksArray = array(
  
	array("PagSeguro","finan_pagseg.php",0),
	array("Financeiro","finincialreport.php",0),
	array("Lucro/Perca por Produto","itemfinincialreport.php",0),
	//array("Lucro/Perca por Categoria","categoryfinincialreport.php",0),
	//array("Dura&ccedil;&atilde;o de Lucro/Perca","durationfinincialreport.php",0),
     
	//array("Product Viewed","productsviewedreport.php",1),
	array("Buscar Leil&atilde;o","searchauction.php",1),
	array("Por Produto","productwisereport.php",1),
	//array("Por Leil&atilde;o","auctionwisereport.php",1),
	array("Por Leil&atilde;o","biddingreport.php",1),
	array("Lance por Categoria","categorywisereport.php",1),
	array("Lance de Valor Monetario","bidmonetaryvalue.php",1),
	//array("Lance por SMS","smsbidsreport.php",1),
	//array("Valor Monet&aacute;rio de SMS","smsmonetaryvalue.php",1),
	//array($BidButName." Ofertas","bidbutlerbidsreport.php",1),
	//array("Lance por Cart&atilde;o de Cr&eacute;dito","singlebidsreport.php",1),
	//array($BidButName." M&eacute;dio","averagebidbutler.php",1),
	array("Pacote de Lances","bidpackreport.php",1),
	array("Valores de Pacotes","bidpackagevalue.php",1),
	array("Compra Confirmada","confirmedpurchasereport.php",1),

	array("Usu&aacute;rio","userreport.php",2),
	//array("Cadastramento","registrationreport.php",2),
	array("Usuario por Leil&atilde;o","userperauctionreport.php",2),
	array("Item Preferido","prefereditemreport.php",2),
	array("Tempo de Primeiro Lance","auctiontimereport.php",2),
	array("Tempo por Categoria","categorywiseduration.php",2),
	array("Afiliados","affiliatereport.php",2),
	array("Login Di&aacute;rio","dailyloginreport.php",2),
	array("Tempo de Login/Logout","averageloginlogout.php",2),
	array("Usuario N&atilde;o Cadastrado","nonregistreduserreport.php",2),
	array("Login/Logout Por Hora","perhourreport.php",2),

 );
}elseif($_SESSION["type"]=="3"){
//****************************************************************?
//****************************************************************?
  $ChildLinksArray = array( 
    //array("Product Viewed","productsviewedreport.php",1),
	array("Buscar Leil&atilde;o","searchauction.php",1),
	array("Por Produto","productwisereport.php",1),
	//array("Por Leil&atilde;o","auctionwisereport.php",1),
	array("Por Leil&atilde;o","biddingreport.php",1),
	array("Lance por Categoria","categorywisereport.php",1),
	array("Lance de Valor Monetario","bidmonetaryvalue.php",1),
	//array("Lance por SMS","smsbidsreport.php",1),
	//array("Valor Monet&aacute;rio de SMS","smsmonetaryvalue.php",1),
	//array($BidButName." Ofertas","bidbutlerbidsreport.php",1),
	//array("Lance por Cart&atilde;o de Cr&eacute;dito","singlebidsreport.php",1),
	//array($BidButName." M&eacute;dio","averagebidbutler.php",1),
	array("Pacote de Lances","bidpackreport.php",1),
	array("Valores de Pacotes","bidpackagevalue.php",1),
	array("Compra Confirmada","confirmedpurchasereport.php",1),
 );
}


?>