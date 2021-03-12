<?php
if($_SESSION["type"]=="1")
{
  $MainLinksArray = array (
   array("Leil&atilde;o","#",1),
/* array("Featured Leil&atilde;o Mng","#",1),*/
   array("Lances","#",1),
   array("Cupons de B&ocirc;nus","#",1),
   array("Fatura","#",1),
);
  
  
  
   $ChildLinksArray = array(
	array("Adicionar Leil&atilde;o","addauction.php",0),
	array("Gerenciar Leil&atilde;o","manageauction.php",0),
	array("Leil&atilde;o Vendidos","soldauction.php",0),
	array("Leil&atilde;o N&atilde;o Vendidos","unsoldauction.php",0),
/*	array("AdicionarFeatured Leil&atilde;o","addfeatureauction.php",1),
	array("Gerenciar Featured Leil&atilde;o","managefeatureauction.php",1),*/
	array("Creditar/Debitar Lances","addbonusbid.php",1),
	array("Adicionar B&ocirc;nus","addvoucher.php",2),
	array("Gerenciar B&ocirc;nus","managevoucher.php",2),
	array("Emitir B&ocirc;nus","voucherissue.php",2),
	array("Gerenciar Faturas","invoicemanagement.php",3),
);
}
elseif($_SESSION["type"]=="2")
{
  $MainLinksArray = array (
   array("Gerenciar Lances Credito/Debito","#",1),
   array("Gerenciar Bonus","#",1),
   array("Gerenciar Faturas","#",1),
);
  
  
  
   $ChildLinksArray = array(
	array("Lances Credito/Debito","addbonusbid.php",0),
	array("Adicionar Voucher","addvoucher.php",1),
	array("Gerenciar B&ocirc;nus","managevoucher.php",1),
	array("Emitir B&ocirc;nus","voucherissue.php",1),
	array("Gerenciar Faturas","invoicemanagement.php",2),
);
}
elseif($_SESSION["type"]=="3")
{
  $MainLinksArray = array (
   array("Gerenciar Leil&oacute;es","#",1),
/* array("Featured Leil&atilde;o Mng","#",1),*/
   array("Gerenciar B&ocirc;nus","#",1),
);
  
  
  
   $ChildLinksArray = array(
	array("Adicionar Leil&atilde;o","addauction.php",0),
	array("Gerenciar Leil&atilde;o","manageauction.php",0),
	array("Leil&atilde;o Vendidos","soldauction.php",0),
	array("Leil&atilde;o N&atilde;o Vendidos","unsoldauction.php",0),
/*	array("Adicionar Featured Leil&atilde;o","addfeatureauction.php",1),
	array("Gerenciar Featured Leil&atilde;o","managefeatureauction.php",1),*/
	array("Adicionar B&ocirc;nus","addvoucher.php",1),
	array("Gerenciar B&ocirc;nus","managevoucher.php",1),
	array("Emitir B&ocirc;nus","voucherissue.php",1),
);
}
?>