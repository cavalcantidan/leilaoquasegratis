<?

	include("connect.php");
	include("config.inc.php");
	include("security.php");
	$type1 = 1;
	include("pagepermission.php");
	
	$acao = $_REQUEST["acao"];
	$iddepo = $_REQUEST["id"];
	switch ($acao) {
		case "excluir":
			$bann = mysql_query("select * from depoimentos where Id=$iddepo");
			$imgbann = mysql_fetch_array($bann);
			$img = $imgbann["img"];			
			$qrydel = "delete from depoimentos where Id=".$iddepo."";			
			if(!empty($img)){
				unlink("../uploads/imgusers/".$img."");
			}
			mysql_query($qrydel) or die(mysql_error());
			echo "<script>alert('Depoimento Excluido com sucesso!!');window.location.href='manage_depo.php';</script>";
			break;					
		case "ativa":
			$qryupd = "update depoimentos set status = 1 where Id=".$iddepo."";
			mysql_query($qryupd) or die(mysql_error());
			echo "<script>alert('Depoimento Alterado com sucesso!!');window.location.href='manage_depo.php';</script>";
			break;					
		case "inativa":			
			$qryupd = "update depoimentos set status = 0 where Id=".$iddepo."";
			mysql_query($qryupd) or die(mysql_error());
			echo "<script>alert('Depoimento Alterado com sucesso!!');window.location.href='manage_depo.php';</script>";
			break;
		
	}
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?=$lng_characset;?>" />
<title></title>
<LINK href="main.css" type=text/css rel=stylesheet>
</head>

<BODY bgColor=#ffffff>   
<form name="f1" action="manage_depo.php" method="post" enctype="multipart/form-data"  onsubmit="return Check(f1)">
<table width="100%" cellpadding="0" cellSpacing="10">
  <tr>
	<td class="H1">Depoimentos</td>
  </tr>
  <tr>
	<td background="<?=DIR_WS_ICONS?>vdots.gif"><IMG height=1 src="<?=DIR_WS_ICONS?>spacer.gif" width=1 border=0></td>
  </tr>

  <tr>
 	<td>
 
      <TABLE width="95%" border="1" cellSpacing="0" class="t-a" align="center">
 	    <TR class="th-a">
 	      <th>Foto</th>
 	      <th>Usuario</th>
 	      <th>Titulo</th>
 	      <th>Status</th>
 	      <th width="20%">A&ccedil;&atilde;o</th>
 	      </tr>
      <?
	  $cons= "SELECT * FROM depoimentos ORDER BY date desc";
	  $qdepo = mysql_query($cons);
      if (mysql_num_rows($qdepo)>0){		
	  while($linha = mysql_fetch_array($qdepo)){
		 $idusu = $linha["userid"];
		 $cons2= mysql_query("SELECT * FROM registration WHERE Id = $idusu");
	  	 $qusu = mysql_fetch_array($cons2);
	  ?>
 	  
 	    <tr>
 	      <td align="center">
          <? if(empty($linha["img"])){?>				
          <img src="../uploads/imgusers/no_image.gif" width="100"/>
          <? }else{?>
          <img src="../uploads/imgusers/<? echo $linha["img"]; ?>" width="100"/>
          <? }?>
          </td>
 	      <td align="center"><? echo $qusu["username"]; ?></td>
 	      <td align="center"><a href="manage_depo_ver.php?id=<? echo $linha["Id"]; ?>"><? echo $linha["titulo"]; ?></a></td>
 	      <td align="center"><? 
		  if($linha["status"] == 0){
			  echo "<font color='red'>Inativo</font>";
		  }
		  if($linha["status"] == 1){
			  echo "<font color='blue'>Ativo</font>";
		  }
		  ?>
		  </td>
 	      <td align="center">
 	        
 	        <? if($linha["status"] == 1){?>
 	        <input name="button2" type="button" class="bttn" value="Inativa" onclick="if(confirm('Deseja realmente inativar este depoimento?')){window.location.href='manage_depo.php?acao=inativa&id=<? echo $linha["Id"];?>'}" />
 	        <? }else{?>
 	        <input name="button2" type="button" class="bttn" value="Ativa" onclick="if(confirm('Deseja realmente ativar este depoimento?')){window.location.href='manage_depo.php?acao=ativa&id=<? echo $linha["Id"];?>'}" />
 	        <? }?>
 	        &nbsp;<input name="button" type="button" class="bttn" value="Excluir" onClick="if(confirm('Deseja realmente excluir este depoimento?')){window.location.href='manage_depo.php?acao=excluir&id=<? echo $linha["Id"]?>'}"></td>
            
 	      </tr>
       <? } } ?> 
         
      </table>  
            </td>
  </tr>
</table>
</form>
</BODY>
</html>
