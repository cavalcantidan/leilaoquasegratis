<?php
if($_SESSION["type"]=="1")
{
  $MainLinksArray = array (
   array("Administrador","#",1),
   array("Usu&aacute;rio Rob&ocirc;","#",1),
   array("Super Usu&aacute;rio","#",1),
//   array("Tickets","#",1),
 );
  
  
   $ChildLinksArray = array(
  	array("Adicionar Administrador","addadminmember.php",0),
  	array("Gerenciar Administrador","manageadminmember.php",0),
  	array("Adicionar Usu&aacute;rio Rob&ocirc;","addbiddinguser.php",1),
  	array("Gerenciar Usu&aacute;rio Rob&ocirc;","managebiddinguser.php",1),
    array("Mudar Senha do Admin","editaccount.php",2),
  //  array("Gerenciar Central de Suporte","#",3),
);
}
elseif($_SESSION["type"]=="2")
{
  $MainLinksArray = array (
   array("Alterar Senha Admin","#",1),
 );
  
  
   $ChildLinksArray = array(
    array("Senha Admin","editaccount.php",0),
);
}

elseif($_SESSION["type"]=="3")
{
  $MainLinksArray = array (
   array("Alterar Senha Admin","#",1),
   array("Adm. Tickets","#",1),
 );
  
  /*
   $ChildLinksArray = array(
    array("Senha Admin","editaccount.php",0),
    array("Central de Suporte","#",1),
);// */
}
?>