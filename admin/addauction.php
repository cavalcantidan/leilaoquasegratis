<?
	include("connect.php");
	include("admin.config.inc.php");
	include("security.php");

	if($_POST["statusLeilao"]!="2"){
		$aucstartdate = $_REQUEST["aucstartdate"];
		$auc_start_time = $_REQUEST["aucstarthours"].":".$_REQUEST["aucstartminutes"].":".$_REQUEST["aucstartseconds"];
	}else{
		$aucstartdate = date("d/m/Y");
		$auc_start_time = date("H:i:s");
	}
	
	$auc_start_date_ex = explode("/",$aucstartdate);
	$auctionsplittime  = explode(":",$auc_start_time);
	$auc_start_date = $auc_start_date_ex[2]."-".$auc_start_date_ex[1]."-".$auc_start_date_ex[0];
	$aucstarthour = $auctionsplittime[0];
	$aucstartmin = $auctionsplittime[1];
	$aucstartsec = $auctionsplittime[2];

	$categoryID = $_REQUEST["category"];
	$productID = $_REQUEST["product"];
	$auc_start_price = $_REQUEST["aucstartprice"];
	$auc_start_price = str_replace(",",".",$auc_start_price);

	$auc_status = $_REQUEST["statusLeilao"];
	$duration = $_REQUEST["auctionduration"];
	$shippingmethod = $_REQUEST["shippingmethod"];
	
	$pa = 1;
	$minimumaucprice = 0;
	if($_POST["minimum_auction"]!=""){ $minimumaucprice = $_POST["auctionminimumprice"]; }
	$minimumaucprice = number_format($minimumaucprice,0,',','');

	$max_robot_consec = 0;
	if($_POST["max_robot_consec"]!=""){ $max_robot_consec = $_POST["max_robot_consec"]; }
	$max_robot_consec = number_format($max_robot_consec,0,',','');

	$auc_due_time = 0;
	if($duration==""){$duration="none";}
	$ress = mysql_query("Select * from auction_management where auc_manage = '{$duration}'" );
	$total = mysql_affected_rows();
	$rows = mysql_fetch_object($ress);
	if($total>0){$auc_due_time=$rows->auc_plus_time;}
	if($_REQUEST["addauction"]!=""){		
		$auc_status = 1;
		$qryins = "Insert into auction (categoryID,productID,auc_start_price,auc_start_date,auc_start_time,auc_status,time_duration,shipping_id,auction_min_price,auc_final_price,pennyauction,total_time,max_robot_consec)
								values('$categoryID','$productID',$auc_start_price,'$auc_start_date','$auc_start_time','$auc_status','$duration','$shippingmethod','$minimumaucprice','','1','$auc_due_time','$max_robot_consec')";
		mysql_query($qryins) or die(mysql_error());
		header("location: message.php?msg=14");
		exit;
	}	
	
	if($_GET["auction_edit"]!="" || $_GET["auction_delete"]!="" || $_GET["auction_clone"]){
		if($_REQUEST["auction_edit"]!=""){$aid=$_REQUEST["auction_edit"];}
		if($_REQUEST["auction_delete"]!=""){$aid=$_REQUEST["auction_delete"];}
		if($_REQUEST["auction_clone"]!=""){$aid=$_REQUEST["auction_clone"];}
		$qrys = "select * from auction a left join products p on a.productID=p.productID where auctionID=".$aid;
		$ress = mysql_query($qrys);
		$total = mysql_affected_rows();
		$rows = mysql_fetch_object($ress);
		if($total>0){
			$category = $rows->categoryID;		
			$product = $rows->productID;
			$pprice = str_replace(".",",",$rows->price);
			$aucstartprice = str_replace(".",",",$rows->auc_start_price);		
			$aucstartdate = $rows->auc_start_date;
			$aucstarttime = $rows->auc_start_time;
				$aucsthours = substr($aucstarttime,0,2);
				$aucstmin =  substr($aucstarttime,3,2);
				$aucstsec =  substr($aucstarttime,6,2);
			$aucstatus = $rows->auc_status;
			$aucduration= $rows->time_duration;
			$shippingchargeid = $rows->shipping_id;
			$minimumaucprice=number_format($rows->auction_min_price,0,',','');
			$max_robot_consec=number_format($rows->max_robot_consec,0,',','');
			$userid = $rows->buy_user;
		}
	}

	
	if($_POST["editando"]){
		if($_REQUEST["aucstatus"]=="4"){ $auc_status = 4; }
		$editid = $_POST["editando"];
		$userid = $_POST["userid"];
		if($_REQUEST["auc_back_status"]=="3"){
			//delete record from won_auctions and bid_account and 
			$delwonentry = "delete from won_auctions where auction_id='".$editid."'";
			mysql_query($delwonentry) or die(mysql_error());
			$delbidaccentry = "delete from bid_account where auction_id='".$editid."'";
			mysql_query($delbidaccentry) or die(mysql_error());
			$delaucdueentry = "delete from auc_due_table where auction_id='".$editid."'";			
			mysql_query($delaucdueentry) or die(mysql_error());
			//$auc_due_time = getHours($aucstartdate,$aucenddate,$aucstarthour,$aucendhour,$aucstartmin,$aucendmin,$aucstartsec,$aucendsec);
			$sql_extra = ", buy_user='',auc_final_end_date='0000-00-00 00:00:00',auc_final_price='' ";
		}
		/* isso agora eh feito pelo tempo_sql
		if($auc_status==2){	
			$q = "select * from auc_due_table where auction_id=$editid";
			$r = mysql_query($q);
			$to = mysql_num_rows($r);
				
			if($to>0){
				$qry = "update auc_due_table set auc_due_time=$auc_due_time, auc_due_price=$auc_start_price where auction_id=$editid";
			}else{	
				$qry = "Insert into auc_due_table(auction_id,auc_due_time,auc_due_price) values($editid,'$auc_due_time',$auc_start_price)";
			}
			mysql_query($qry) or die(mysql_error());
		} */

		$qryupd = "update auction set categoryID='$categoryID', productID='$productID',
						  auc_start_price='$auc_start_price',auc_start_date='$auc_start_date',
						  auc_end_date='$auc_end_date', auc_start_time='$auc_start_time', 
						  auc_end_time='$auc_end_time', auc_status='$auc_status', time_duration='$duration',
						  total_time='$auc_due_time', shipping_id='$shippingmethod',
						  max_robot_consec='$max_robot_consec', 
						  auction_min_price='$minimumaucprice' {$sql_extra} 
						  where auctionID='$editid'";
		mysql_query($qryupd) or die(mysql_error());
		//echo $qryupd.'<br/><br/>SQL 1<br/><br/>'; exit;
		header("location: message.php?msg=15");
		exit;
	}
	
	if($_POST["apagando"]){
		$delid = $_POST["apagando"];

		$qryseld = "select auc_status from auction where auctionID=".$delid;
		$resseld = mysql_query($qryseld);
		$totalrow = mysql_affected_rows();
		$del = mysql_fetch_object($resseld);
		if($del->auc_status==2){
			header("location: message.php?msg=16");
			exit;
		}

		$qrydel = "delete from auction where auctionID='$delid'";
		//echo $qrydel;exit;
		mysql_query($qrydel) or dir(mysql_error());
		header("location: message.php?msg=13");
	}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?=$lng_characset;?>" />
<title></title>
<link href="main.css" type=text/css rel=stylesheet>
<link href="zpcal/themes/aqua.css" rel="stylesheet" type="text/css" media="all" title="Calendar Theme - aqua.css" />
<script type="text/javascript" src="zpcal/src/utils.js"></script>
<script type="text/javascript" src="zpcal/src/calendar.js"></script>
<script type="text/javascript" src="zpcal/lang/calendar-en.js"></script>
<script type="text/javascript" src="zpcal/src/calendar-setup.js"></script>
<script language="javascript">

// USE FOR AJAX //
function GetXmlHttpObject(){
	var xmlHttp=null;
	try{
	  // Firefox, Opera 8.0+, Safari
	  xmlHttp=new XMLHttpRequest();
	}catch (e){
	  // Internet Explorer
	  try{
		xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
	  }catch (e){
		xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	}
	return xmlHttp;
}

function delconfirm(){
	if(confirm("Tem certeza que deseja excluir?")){
		return true;
	}
	return false;
}

function Check(f1){
	if(document.f1.category.value=="none"){
		alert("Por favor selecione uma categoria!!!");
		document.f1.category.focus();
		return false;
	}

	if(document.f1.product.value=="none"){
		alert("Por favor selecione um produto!!!");
		document.f1.product.focus();
		return false;
	}

	if(document.f1.aucstartprice.value==""){
		alert("Por favor informe o preço inicial !!!");
		document.f1.aucstartprice.focus();
		return false;
	}


	if(document.f1.aucstartdate.disabled==false && document.f1.aucstartdate.value==""){
		alert("Por favor selecione a data inicial !!!");
		document.f1.aucstartdate.focus();
		return false;
	}else if(document.f1.aucstartdate.disabled==false){
		var aucsdate = condate(document.f1.aucstartdate.value);
		var newaucsdate = new Date(aucsdate);

		var curdate = condate(document.f1.curdate.value); 
		var newcurdate = new Date(curdate);
	
		var newtime = document.f1.curtime.value;
		var temptime = newtime.split(":");
		var newtimehour = temptime[0];
		var newtimeminute = temptime[1];
		var newtimeseconds = temptime[2];
		   
	<? if($aucstatus==2 || $aucstatus==1 || $aucstatus=="" || $_REQUEST["auction_clone"]!="" || $_REQUEST["auction_edit"]){	?>
		if(newcurdate>newaucsdate){
			alert("A data inicial não pode ser anterior à data atual!")
			document.f1.aucstartdate.focus();
			return false;
		}
		if(newaucsdate>newcurdate){
			document.f1.changestatusval.value = "1";
		}
 
		if(document.f1.changestatusval.value != "1"){
			if(document.f1.aucstarthours.value<newtimehour){
				alert("A hora de início não deve ser anterior à atual!");
				document.f1.aucstarthours.focus();
				return false;
			}else{
				if(document.f1.aucstarthours.value==newtimehour){
					if(document.f1.aucstartminutes.value<newtimeminute){
						alert("A hora de início não deve ser anterior à atual!");
						document.f1.aucstartminutes.focus();
						return false;
					}
				}
			}
		}
	  
	 
	<? } ?>	
	
		if(document.f1.aucstarthours.value==""){
			alert("Por favor selecione a hora inicial!!!");
			document.f1.aucstarthours.focus();
			return false;
		}
		
		if(document.f1.aucstartminutes.value==""){
			alert("Por favor selecione o minuto inicial!!!");
			document.f1.aucstartminutes.focus();
			return false;
		}
	
		if(document.f1.aucstartseconds.value=="")
		{
			alert("Por favor selecione o segundo inicial!!!");
			document.f1.aucstartseconds.focus();
			return false;
		}
	}
	
	if(document.f1.shippingmethod.value=="none"){
		alert("Por favor escolha o método de entrega!");
		document.f1.shippingmethod.focus();
		return false;
	}
}
function condate(dt){
	var ndate= new String(dt);
	//alert(dt);
	var fdt=ndate.split("/");
	var nday=fdt[0];
	var nmon=fdt[1];
	var nyear=fdt[2];
	
	var finaldate=nmon+"/"+nday+"/"+nyear;
	return finaldate;
}
function CampoDataHora(valor){
	var bloqueio;
	bloqueio = false;
	if(valor == 2||valor == 3){
	   bloqueio = true;
	   document.f1.datacal.style.visibility = 'hidden';
	} else { 
	   document.f1.datacal.style.visibility = 'visible'; 
	}
	document.f1.aucstarthours.disabled = bloqueio;
	document.f1.aucstartminutes.disabled = bloqueio;
	document.f1.aucstartseconds.disabled = bloqueio;
	document.f1.aucstartdate.disabled = bloqueio;
}

function setprice(prid){
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null){
	  alert ("Seu navegador não suporta AJAX!");
	  return;
	} 
	var url="getprice.php";
	url=url+"?prid="+prid
	xmlHttp.onreadystatechange=changedprice;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
}
function changedprice(){
	if (xmlHttp.readyState==4){ 
		var temp=xmlHttp.responseText
		document.getElementById("getprice").innerHTML = temp;
	}
}

function ChangeProduct(crid){
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null){
	  alert ("Seu navegador não suporta AJAX!");
	  return;
	} 
	var url="getproductlist.php";
	url=url+"?crid="+crid
	xmlHttp.onreadystatechange=ChangedProduct;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
}
function ChangedProduct(){
	if (xmlHttp.readyState==4)	{ 
		var tempproduct=xmlHttp.responseText
		document.getElementById("Productlist").innerHTML = tempproduct;
	}
}

function SetAuctinoMinimum(){
	if(document.getElementById('minimum_auction').checked == true){
		if(navigator.appName!="Microsoft Internet Explorer"){
			document.getElementById('auctionminimumpricetr2').style.display = 'table-row';
			document.getElementById('auctionminimumpricetr1').style.display = 'table-row';
		}else{
			document.getElementById('auctionminimumpricetr2').style.display = 'block';
			document.getElementById('auctionminimumpricetr1').style.display = 'block';
		}
	}else{
		document.getElementById('auctionminimumpricetr2').style.display = 'none';
		document.getElementById('auctionminimumpricetr1').style.display = 'none';
	}
}
</script>
</head>

<body bgcolor="#ffffff" >   
	<form name="f1" action='addauction.php' method='POST' enctype="multipart/form-data" 
	onsubmit="return <?php if($_REQUEST["auction_delete"]!=""){echo "delconfirm()";}else{echo "Check(this)";}?>">
<table width="100%" cellpadding="0" cellspacing="10">
  <tr>
	<td class="H1">
	<? 
	if($_GET['auction_edit']!="") {
		echo "Editar Leil&atilde;o"; 
	} elseif($_GET['auction_delete']!=""){
		echo "Excluir Leil&atilde;o"; 
	}else { 
		echo "Adicionar Leil&atilde;o";  
	} ?>
	</td>
  </tr>
  <tr>
	<td background="<?=DIR_WS_ICONS?>vdots.gif"><img height="1" src="<?=DIR_WS_ICONS?>spacer.gif" width="1" border="0" /></td>
  </tr>
  <tr>
	<td class="a" align="right" colspan="2" > </td>
  </tr>
<? if($aucstatus=="2"){ ?>
<tr>
	<td><font class="a">(Aten&ccedil;&atilde;o: Este leil&atilde;o est&aacute; aberto, ent&atilde;o voc&ecirc; n&atilde;o pode modific&aacute;-lo no momento.)</font></td>
</tr>
<tr>
	<td></td>
</tr>
<?  }
	if($aid!="" && $_REQUEST["auction_clone"]==""){
	}
?>  <tr>
	<td>
	  <table cellpadding="1" cellspacing="2">
		<tr valign="middle">
		  <td class="f-c" align="right" valign="middle" width="191"> Categoria :</td>
		  <td>
			<select name="category" style="100pt;" onchange="ChangeProduct(this.value);">
				<option value="none">Selecione</option>
				<?
				$qryc = "select * from categories where status='1'";
				$resc = mysql_query($qryc);
				$totalc = mysql_affected_rows();
				while($namec = mysql_fetch_array($resc)){
					echo '<option '.($category==$namec["categoryID"]?" selected ":"").'value="'.$namec["categoryID"].'">'.stripslashes($namec["name"]).'</option>';
				}
				?>
			</select>
		  </td>
		  <td class="f-c" align="right" valign="middle" width="191"> Produto :</td>
		  <td id="Productlist">
			<select name="product" style="width: 150pt;" onchange="setprice(this.value);">
				<option value="none">Selecione</option>
				<?
				$qryp = "select * from products";
				$resp = mysql_query($qryp);
				$totalp = mysql_affected_rows();
				while($objp = mysql_fetch_array($resp)){
				?>
				<option <?=$product==$objp["productID"]?" selected ":"";?> value="<?=$objp["productID"];?>"><?=stripslashes($objp["name"]);?></option>
				<?
				}
				?>
			</select>
		  </td>
		  <td class="f-c" align="right" valign="middle" width="191"> Valor do Produto:</td>
		  <td id="getprice"><?=$pprice!=""?$pprice:"";?></td>
		</tr>

		<tr valign="middle">
			<td class="f-c" align="right" valign="middle" width="191"> Pre&ccedil;o inicial:</td>
			<td><font color="#FF0000"><?=$Currency;?>&nbsp;</font><input name="aucstartprice" type="text" class="solidinput" id="member_name" value="<?=$aucstartprice?>" size="12" maxlength="20" /></td>
			<td class="f-c" align="right" valign="middle" width="191">Data :</td>
			<td>
				<input type="text" size="12" name="aucstartdate" id="aucstartdate" value="<?=$aucstartdate!=""?date("d/m/Y",strtotime($aucstartdate)):date("d/m/Y");?>" />
				<img name="datacal" src="images/pmscalendar.gif" align="absmiddle" width="20" height="20" id="vfrom" />
			</td>
			<td class="f-c"  align="right">Hor&aacute;rio :</td>
			<td>
			 <? if($aucstatus=="3" and $userid==3){ ?>
				 <select name="aucstarthours">
					<option value="">hh</option>
				 <? for ($h=0;$h<=23;$h++){ ?>
					<option <?=date("H")==$h?" selected ":"";?> value="<?=str_pad($h,2,"0",STR_PAD_LEFT);?>"><?=$h;?></option>
				 <? } ?>
				 </select> :
			 <? }else{ ?>
				 <select name="aucstarthours">
					<option value="">hh</option>
				 <? for ($h=0;$h<=23;$h++){ ?>
					<option <?=$aucsthours==$h?" selected ":"";?> value="<?=str_pad($h,2,"0",STR_PAD_LEFT);?>"><?=str_pad($h,2,"0",STR_PAD_LEFT);?></option>
				 <? } ?>
				 </select> :
			 <? } ?>
			 <? if($aucstatus=="3" and $userid==3){ ?>
				 <select name="aucstartminutes">
					<option value="">mm</option>
				 <? for ($m=0;$m<=59;$m++){ ?>
					<option <?=date("i")==$m?" selected ":"";?> value="<?=str_pad($m,2,"0",STR_PAD_LEFT);?>"><?=str_pad($m,2,"0",STR_PAD_LEFT);?></option>
				 <? } ?>
				 </select> :
			 <? }else{ ?>
				 <select name="aucstartminutes">
					<option value="">mm</option>
				 <? for ($m=0;$m<=59;$m++){ ?>
					<option <?=$aucstmin==$m?" selected ":"";?> value="<?=str_pad($m,2,"0",STR_PAD_LEFT);?>"><?=str_pad($m,2,"0",STR_PAD_LEFT);?></option>
				 <? } ?>
				 </select> :
			 <? } ?>
			 <? if($aucstatus=="3" and $userid==3){ ?>
				 <select name="aucstartseconds">
					<option value="">ss</option>
				 <? for ($s=0;$s<=59;$s++){ ?>
					<option <?=date("s")==$s?" selected ":"";?> value="<?=str_pad($s,2,"0",STR_PAD_LEFT);?>"><?=str_pad($s,2,"0",STR_PAD_LEFT);?></option>
				 <? } ?>
				 </select>
			 <? }else{ ?>
				 <select name="aucstartseconds">
					<option value="">ss</option>
				 <? for ($s=0;$s<=59;$s++){ ?>
					<option <?=$aucstsec==$s?" selected ":"";?> value="<?=str_pad($s,2,"0",STR_PAD_LEFT);?>"><?=str_pad($s,2,"0",STR_PAD_LEFT);?></option>
				 <? } ?>
				 </select>
			 <? } ?>
			</td>
		</tr>
		<tr>
			<td>&nbsp;</td><? if($aucstatus==""){$aucstatus="1";} ?>
			<td><input type="radio" name="statusLeilao" value="1" <?=($aucstatus=="1")?"checked":"";?> onchange="CampoDataHora(this.value);" />&nbsp;Escolher data</td>
			<td><input type="radio" name="statusLeilao" value="2" <?=($aucstatus=="2")?"checked":"";?> onchange="CampoDataHora(this.value);" />&nbsp;Iniciar imediatamente</td>
			<td><input type="radio" name="statusLeilao" value="4" <?=($aucstatus=="4")?"checked":"";?> onchange="CampoDataHora(this.value);" />&nbsp;Deixar pendente</td>
			<td><?	if($_REQUEST["auction_edit"]!="" && $aucstatus=="3"){ ?>	
			<input type="radio" name="statusLeilao" value="3" <?=($aucstatus=="3")?"checked":"";?> onchange="CampoDataHora(this.value);" />&nbsp;Vendido
			<?	} ?></td>	
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td class="f-c"  align="right">Informa&ccedil;&otilde;es :</td>
			<td colspan="5">
				<font class="a">
				Se estiver pendente ent&atilde;o o leil&atilde;o n&atilde;o ser&aacute; salvo para venda, altere a op&ccedil;&atilde;o para coloc&aacute;-lo &agrave; venda.
				</font>
			</td>
		</tr>
		<tr>
			<td class="f-c"  align="right">Dura&ccedil;&atilde;o :</td>
			<td>
				<select name="auctionduration">
					<?
					$qryc = "select * from auction_management where id=1 order by auc_title";
					$resc = mysql_query($qryc);
					$totalc = mysql_affected_rows();
					while($namec = mysql_fetch_array($resc)){
						echo '<option '.($rows->time_duration==$namec["auc_manage"]?" selected ":"").' value="'.$namec["auc_manage"].'">'.stripslashes($namec["auc_title"])." ({$namec[auc_plus_time]})".'</option>';
					}
					$qryc = "select * from auction_management where id>1 order by auc_title";
					$resc = mysql_query($qryc);
					$totalc = mysql_affected_rows();
					while($namec = mysql_fetch_array($resc)){
						echo '<option '.($rows->time_duration==$namec["auc_manage"]?" selected ":"").' value="'.$namec["auc_manage"].'">'.stripslashes($namec["auc_title"]).'</option>';
					}
					?>
				</select>
			</td>
			<td>&nbsp;</td>
		  <td class="f-c"  align="right">Forma de Entrega:</td>
		  <td>
			  <select name="shippingmethod" style="width: 180px;">
				  <option value="none">Selecione uma</option>
					<?
						$qryshipping = "select * from shipping";
						$resshipping = mysql_query($qryshipping);
						while($objshipping = mysql_fetch_object($resshipping))
						{
					?>
					<option <?=$objshipping->id==$shippingchargeid?" selected ":"";?> value="<?=$objshipping->id;?>"><?=stripslashes($objshipping->shipping_title);?></option>
					<?
						}
					?>
			  </select>
		  </td>
			<td>&nbsp;</td>
		</tr>
		<tr><td colspan="6"></td></tr>
		<tr>
			<td>&nbsp;</td>
			<td colspan="4" align="left"><input <? if($minimumaucprice>0) { echo "checked"; } ?> type="checkbox" value="minimum" id="minimum_auction" name="minimum_auction" onclick="SetAuctinoMinimum();" />
					&nbsp;Definir Lance M&iacute;nimo.</td>
			<td>&nbsp;</td>
		</tr>
		<tr id="auctionminimumpricetr1" <? if($minimumaucprice<=0) {  ?> style="display: none;" <? } ?>>
			<td class="f-c"  align="right">Quantidade m&iacute;nima de lances :</td>
			<td align="left" colspan="5"><input type="text" name="auctionminimumprice" size="10" maxlength="8" value="<?=$minimumaucprice>0?$minimumaucprice:"";?>" />&nbsp;<font class="a">Lances</font><br />
			<font class="a">
				Nota: Leil&atilde;o n&atilde;o fechar&aacute; enquanto os lances reais n&atilde;o chegarem ao valor definido aqui.
			</font></td>
		</tr>
		<tr id="auctionminimumpricetr2" <? if($minimumaucprice<=0) {  ?> style="display: none;" <? } ?>>
			<td class="f-c"  align="right">Quantidade m&aacute;xima de lances rob&oacute;ticos consecutivos :</td>
			<td align="left" colspan="5"><input type="text" name="max_robot_consec" size="10" maxlength="8" value="<?=$minimumaucprice>0?$max_robot_consec:"";?>" />&nbsp;<font class="a">Lances</font><br />
			<font class="a">
				Nota: Caso apenas rob&ocirc;s estejam disputando lances seguidamente, ao atingir o valor acima o rob&ocirc; vencer&aacute; e terminar&aacute; o leil&atilde;o.
			</font></td>
		</tr>
		<tr>
			<td colspan="6">&nbsp;</td>
		</tr>
		<tr>
			<td align="center" colspan="6">
				<?
				$Desabilitar = '';
				if($aucstatus=="3"||$aucstatus=="2"){
					//$Desabilitar = ' disabled ';
				}    			
				if($_REQUEST["auction_edit"]!="" && $userid!=""){

					echo '<input type="submit" name="editauction" value="Editar" class="bttn" '. $Desabilitar .' />';
				?>
				<input type="hidden" name="editando" value="<?=$_REQUEST["auction_edit"];?>" />
				<input type="hidden" name="auc_back_status" value="<?=$aucstatus;?>" />
				<input type="hidden" name="userid" value="<?=$userid;?>" />
				<?php
				}elseif($_REQUEST["auction_delete"]!=""){
					$delid = $_REQUEST["auction_delete"];
				?>
				<input type="hidden" name="apagando" value="<?=$delid;?>" />
				<input type="submit" name="deleteauction" value="Excluir" class="bttn" <?php echo $Desabilitar; ?> />
				<?php
				}else{
				?>
				<input type="submit" name="addauction" value="Adicionar" class="bttn" />
				<?php
				}
				?>
			</td>
		</tr>
		</table>
	</td>
	</tr>
</table>
<input type="hidden" name="curdate" value="<?=date("d/m/Y");?>" />
<input type="hidden" name="changestatusval" value="" />
<input type="hidden" name="curtime" value="<?=date("H:i:s");?>" />
</form>
<script type="text/javascript">
	var cal = new Zapatec.Calendar.setup({ inputField:"aucstartdate", ifFormat:"%d/%m/%Y", button:"vfrom", showsTime:false });
	CampoDataHora(<?=$aucstatus;?>);
</script>
</body>
</html>