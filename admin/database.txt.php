<?php
if($_SESSION["type"]=="1")
{
  $MainLinksArray = array (
    array("Categoria","#",1),
    array("Produtos","#",1),
  	array("Usuarios","#",1),
    array("Pacote de Lances","#",1),
    array("Transportadoras","#",1),
  	array("Newsletter","#",1),
);


//****************************************************************?
//****************************************************************?
  $ChildLinksArray = array(
   	array("Adicionar Categoria","addcategory.php",0),
   	array("Gerenciar Categoria","managecat.php",0),
	array("Adicionar Produtos","addproducts.php",1),
    array("Gerenciar Produtos","manageproducts.php",1),
  	array("Adicionar Usuarios","edit_member.php",2),
  	array("Gerenciar Usuarios","manage_members.php",2),
	array("Gerenciar Depoimentos","manage_depo.php",2),
	array("Adicionar Pacotes de Lances","addbidpack.php",3),
	array("Gerenciar Pacotes de Lances","managebidpack.php",3),
	array("Adicionar Transportadora","addshippingcharge.php",4),
	array("Gerenciar Transportadora","manageshippingcharge.php",4),
  	array("Adicionar Newsletter","newsletter.php",5),
  	array("Gerenciar Newsletter","managenewslatters.php",5),
 );
}
elseif($_SESSION["type"]=="2")
{
  $MainLinksArray = array (
  	array("Adm Usuarios","#",1),
    array("Adm Pacotes de Lances","#",1),
    array("Adm Transportadoras","#",1),
  	array("Adm Newsletter","#",1),
);


//****************************************************************?
//****************************************************************?
  $ChildLinksArray = array(
  	array("Adicionar Usuários","addmembers.php",0),
  	array("Adm Usuários","manage_members.php",0),
	array("Adicionar Pacotes de Lances","addbidpack.php",1),
	array("Adm Pacotes de Lances","managebidpack.php",1),
	array("Adicionar Transportadora","addshippingcharge.php",2),
	array("Adm Transportadoras","manageshippingcharge.php",2),
  	array("Adicionar Newsletter","newsletter.php",3),
  	array("Adm Newsletter","managenewslatters.php",3),
 );
}
elseif($_SESSION["type"]=="3")
{
  $MainLinksArray = array (
    array("Adm Categorias","#",1),
    array("Adm Produtos","#",1),
    array("Adm Pacotes de Bids","#",1),
    array("Adm Transportadora","#",1),
  	array("Adm Newsletter","#",1),
);


//****************************************************************?
//****************************************************************?
  $ChildLinksArray = array(
   	array("Adicionar Categoria","addcategory.php",0),
   	array("Adm Categoria","managecat.php",0),
	array("Adicionar Produtos","addproducts.php",1),
    array("Adm Produtos","manageproducts.php",1),
	array("Adicionar Pacote de Lances","addbidpack.php",2),
	array("Admin Pacote de Lances","managebidpack.php",2),
	array("Adicionar Transportadora","addshippingcharge.php",3),
	array("Adm Transportadoras","manageshippingcharge.php",3),
  	array("Adicionar Newsletter","newsletter.php",4),
  	array("Admin Newsletter","managenewslatters.php",4),
 );
} 
?>