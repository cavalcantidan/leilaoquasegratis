<?php
	include("session.php");
    include("header.php"); 

	$uid = $_SESSION["userid"];
	
	$fname = $_POST["name"];
	$add1 = $_POST["address1"];
	$add2 = $_POST["address2"];
	$city = $_POST["city"];
	$state = $_POST["state"];
	$country = $_POST["country"];
	$zip = $_POST["zip"];
	$phone = $_POST["phone"];
	
	if($_POST["del_confirm"]!=""){
		$qryupd = "update registration set delivery_name='$fname',  delivery_addressline1='$add1', delivery_addressline2='$add2', delivery_city='$city', delivery_state='$state', delivery_country='$country', delivery_postcode='$zip', delivery_phone='$phone' where id='$uid'";
		mysql_query($qryupd) or die(mysql_error());
		$msg = 1;
	}

	if($_POST["edit_confirm"]!=""){
		$qryselcou = "select * from countries where countryId='".$country."'";
		$resselcou = mysql_query($qryselcou);
		$objselcou = mysql_fetch_object($resselcou);
		$fullmobileno = "+".$objselcou->countrycode.$_POST["mobileno"];
		
		$qryupd = "update registration set firstname='$fname', addressline1='$add1', addressline2='$add2', city='$city', state='$state', country='$country', postcode='$zip', phone='$phone',full_mobileno='$fullmobileno' where id='$uid'";
		mysql_query($qryupd) or die(mysql_error());
		$msg = 1;
	}

	$qr = "select * from registration r left join countries c on r.country=c.countryId where r.id='".$uid."'";
	$rs = mysql_query($qr);
	$total = mysql_num_rows($rs);
	$row = mysql_fetch_object($rs);
?>

<script language="javascript" type="text/javascript" src="js/function.js"></script>
<script language="javascript">
function HideDisplay(edit){
	var ed = edit;
	if(ed==1){
		document.getElementById('edit_address').style.display = 'block';
		document.getElementById('billing_address').style.display = 'none';
	}else{
		obj = document.getElementById('delivery_address');
		if(obj.style.display=='none'){
			obj.style.display='block';
		}else{
			obj.style.display='none';
		}
	}
}

function HideDisplayDeliveryAddress(edit){
	var ed = edit;
	if(ed==1){
		document.getElementById('delivery_address_exp1').style.display = 'block';
		document.getElementById('delivery_address_exp').style.display = 'none';
	}else{
		obj = document.getElementById('delivery_address');
		if(obj.style.display=='none'){
			obj.style.display='block';
		}else{
			obj.style.display='none';
		}
	}
}

function check(){
	if(document.address.name.value==""){
		alert("<?=$lng_plsentername;?>");
		document.address.name.focus();
		return false;
	}
	if(document.address.address1.value==""){
		alert("<?=$lng_plsenteradd;?>");
		document.address.address1.focus();
		return false;
	}
	if(document.address.city.value=="")
	{
		alert("<?=$lng_plsentercity;?>");
		document.address.city.focus();
		return false;
	}

	if(document.address.zip.value=="")
	{
		alert("<?=$lng_plsenterpostcode;?>");
		document.address.zip.focus();
		return false;
	}
	if(document.address.phone.value=="")
	{
		alert("<?=$lng_plsenterphoneno;?>");
		document.address.phone.focus();
		return false;
	}
}

function check1(){
	if(document.editaddress.name.value==""){
		alert("<?=$lng_plsentername;?>");
		document.editaddress.name.focus();
		return false;
	}
	if(document.editaddress.address1.value==""){
		alert("<?=$lng_plsenteradd;?>");
		document.editaddress.address1.focus();
		return false;
	}
	if(document.editaddress.city.value=="")
	{
		alert("<?=$lng_plsentercity;?>");
		document.editaddress.city.focus();
		return false;
	}

	if(document.editaddress.zip.value=="")
	{
		alert("<?=$lng_plsenterpostcode;?>");
		document.editaddress.zip.focus();
		return false;
	}
	if(document.editaddress.phone.value=="")
	{
		alert("<?=$lng_plsenterphoneno;?>");
		document.editaddress.phone.focus();
		return false;
	}
}
</script>

<?
    include("leftside.php");
?>
<div id="conteudo-conta">
    <h3 id="conta-tit"><?=$lng_myauctionsavenue;?> - <?=$lng_addresses;?></h3>
        <div id="meus-detalhes">

            <div id="meus-detalhes-tit">
                <p class="muda-titulo-1" style="padding:6px 0 0 15px;"><?=$lng_hereeditadd;?></p>
                <span class="md-titulo" style="top:24px">
                <? if($row->delivery_addressline1==""){ ?>
                    <a style="color:#00F; text-decoration:underline;" 
                       href="javascript: HideDisplay();"><?=$lng_enternewadd;?></a>
	            <? } 
		           if($msg==1){
	            ?>
                    <span style="background:#C00; padding:8px; width:300px; display:block; margin-top:40px; margin-left:300px;">
                        <?=$lng_addresschanged;?>
                    </span>
	            <? } ?>
                </span>
                <span class="md-computer"></span>
                <!-- / meus detalhes-tit -->
            </div>

<!-- forms e info -->
<? if($row->delivery_addressline1==""){ ?>
    <div id="delivery_address" style="display: none;">
        <form name="address" action="" method="post" onsubmit="return check();">
        <h3 class="muda-titulo-3"><?=$lng_enternewadd;?> :
            <span class="muda-titulo-2">Preencha os campos obrigat&oacute;rios para inclu&atilde;o de endere&ccedil;o
        </h3>
        <p><select name="delivery">
        <option value="delivery"><?=$lng_deliveryaddress;?></option></select></p>
        <p><label><?=$lng_onlyname;?> </label><input type="text" name="name" size="20" class="campo1" value="<?=$row->delivery_name;?>" /></p><p><label>  <?=$lng_addressline1;?>: </label><input type="text" name="address1" size="20" class="campo1" value="<?=$row->delivery_addressline1;?>" /></p>
        <p><label><?=$lng_addressline2;?> :</label><input type="text" name="address2" size="20" class="campo1" value="<?=$row->delivery_addressline2;?>" /></p>
        <p><label><?=$lng_towncity;?>: </label><input type="text" name="city" size="20" class="campo1" value="<?=$row->delivery_city;?>" /></p>
        <p><label><?=$lng_country;?> : </label><select name="country" style="width: 220px;">
	        <?
		        $qrc1 = "select * from countries order by printable_name";
		        $rsc1 = mysql_query($qrc1);
		        while($v1 = mysql_fetch_array($rsc1))
		        {
	        ?>
		        <option <?=$row->country==$v1["countryId"]?"selected":"";?> value="<?=$v1["countryId"];?>"><?=$v1["printable_name"];?></option>
	        <?
		        }
	        ?>
		    </select></p>
        <p><label><?=$lng_postcode;?> : </label><input type="text" name="zip" size="20" class="campo1" value="<?=$row->delivery_postcode;?>" /></p>
        <p><label><?=$lng_phoneno;?> : </label><input type="text" name="phone" size="20" class="campo1" value="<?=$row->delivery_phone;?>" /></p>
        <p><span class="red-text-12-b">*</span> <?=$lng_mandatoryfield;?></p>
        <p><span class="enviar">
            <input type="image" name="delconfirm" value="confirm" src="imagens/enviar.gif" width="54" height="53" 
                   onmouseout="this.style.margin='0 0 0 0'" onmouseover="this.style.margin='-26px 0 0 0'" />
        </span></p>
        <input type="hidden" value="Confirm" name="del_confirm" />
        </form>
    </div>
<? } ?>

<div id="billing_address">
    <h3 class="muda-titulo-3"><?=$lng_billingaddress;?> :</h3>
    <p class="p-data"><span><?=$lng_onlyname;?></span><?=$row->firstname;?></p>
    <p class="p-data"><span><?=$lng_addressline1;?> : </span><?=$row->addressline1;?></p>
    <p class="p-data"><span><?=$lng_addressline2;?> : </span><?=$row->addressline2;?></p>
    <p class="p-data"><span><?=$lng_towncity;?> : </span><?=$row->city;?></p>
    <p class="p-data"><span><?=$lng_country;?> : </span><select name="country" style="width: 220px;" disabled="disabled">
	    <?
		    $qrc = "select * from countries order by printable_name";
		    $rsc = mysql_query($qrc);
		    while($v=mysql_fetch_array($rsc))
		    {
	    ?>
		    <option <?=$row->country==$v["countryId"]?"selected":"";?> value="<?=$v["countryId"];?>"><?=$v["printable_name"];?></option>
	    <?
		    }
	    ?>
		    </select></p>
    <p class="p-data"><span><?=$lng_postcode;?> : </span><?=$row->postcode;?></p>
    <p class="p-data"><span><?=$lng_phoneno;?> : </span><?=$row->phone;?></p>
    <p><span class="editar-dados">
        <input type="image" name="edit" value="Edit" src="imagens/editar-dados.gif" width="94" height="53" 
        onmouseout="this.style.margin='0 0 0 0'" onmouseover="this.style.margin='-26px 0 0 0'" 
        onclick="HideDisplay(1)" />
    </span></p>
</div>

<!-- atualizando dados de novo -->
<div id="edit_address" style="display: none">
    <form name="editaddress" action="" method="post" onsubmit="return check1();">
    <h3 class="muda-titulo-3"><?=$lng_billingaddress;?> :
        <span class="muda-titulo-2">Preencha os campos obrigat&oacute;rios para mudan&ccedil;a de endere&ccedil;o</span>
    </h3>
    <p><label><?=$lng_onlyname;?></label><input type="text" name="name" size="20" value="<?=$row->firstname;?>"  class="campo1"/>&nbsp;<font class="red-text-12-b">*</font></p>
    <p><label><?=$lng_addressline1;?> : </label><input type="text" name="address1" size="20" value="<?=$row->addressline1;?>" class="campo1" /></p>
    <p><label><?=$lng_addressline2;?> : </label><input type="text" name="address2" size="20" value="<?=$row->addressline2;?>" class="campo1" /></p>
    <p><label><?=$lng_towncity;?> : </label><input type="text" name="city" size="20" value="<?=$row->city;?>" class="campo1" />&nbsp;<font class="red-text-12-b">*</font></p>
    <p><label><?=$lng_country;?> : </label><select name="country" style="width: 220px;">
		<?
			$qrc2 = "select * from countries order by printable_name";
			$rsc2 = mysql_query($qrc2);
			while($v2 = mysql_fetch_array($rsc2))
			{
		?>
			<option <?=$row->country==$v2["countryId"]?"selected":"";?> value="<?=$v2["countryId"];?>"><?=$v2["printable_name"];?></option>
		<?
			}			
		?>
		</select></p>
    <p><label><?=$lng_postcode;?> : </label><input type="text" name="zip" size="20" value="<?=$row->postcode;?>" class="campo1" />&nbsp;<font class="red-text-12-b">*</font></p>
    <p><label><?=$lng_phoneno;?> : </label><input type="text" name="phone" size="20" value="<?=$row->phone;?>" class="campo1" />&nbsp;<font class="red-text-12-b">*</font></p>
    <p><span class="red-text-12-b">*</span> <?=$lng_mandatoryfield;?></p>
    <p><span class="enviar">
        <input type="image" value="confirm" name="editconfirm" src="imagens/enviar.gif" width="54" height="53" 
               onmouseout="this.style.margin='0 0 0 0'" onmouseover="this.style.margin='-26px 0 0 0'" />
        <input type="hidden" value="<?=$row->mobile_no;?>" name="mobileno" />
		<input type="hidden" name="edit_confirm" value="Confirm" /></span>
    </p>
    </form>
</div>




<!-- atualizando dados de novo 2 -->
<? if($row->delivery_addressline1!=""){ ?>
    <div id="delivery_address_exp">
        <h3 class="muda-titulo-3"><?=$lng_deliveryaddress;?> : </h3>
        <p class="p-data"><span><?=$lng_onlyname;?></span><?=$row->delivery_name;?></p>
        <p class="p-data"><span><?=$lng_addressline1;?> : </span><?=$row->delivery_addressline1;?></p>
        <p class="p-data"><span><?=$lng_addressline2; ?> : </span><?=$row->delivery_addressline2;?></p>
        <p class="p-data"><span><?=$lng_towncity;?> : </span><?=$row->delivery_city;?></p>
        <p class="p-data"><span><?=$lng_country;?> : </span><select name="country" style="width: 220px;" disabled="disabled">
		    <?
			    $qrc = "select * from countries order by printable_name";
			    $rsc = mysql_query($qrc);
			    while($v=mysql_fetch_array($rsc))
			    {
		    ?>
			    <option <?=$row->delivery_country==$v["countryId"]?"selected":"";?> value="<?=$v["countryId"];?>"><?=$v["printable_name"];?></option>
		    <?
			    }
		    ?>
			    </select></p>
        <p class="p-data"><span><?=$lng_postcode;?> : </span><?=$row->delivery_postcode;?></p>
        <p class="p-data"><span><?=$lng_phoneno;?> : </span><?=$row->delivery_phone;?></p>
        <p><span class="editar-dados">
            <input type="image" name="edit" value="Edit" src="imagens/editar-dados.gif" width="94" height="53" 
                   onmouseout="this.style.margin='0 0 0 0'" onmouseover="this.style.margin='-26px 0 0 0'" 
                   onclick="HideDisplayDeliveryAddress(1)" />
        </span></p>
        <br />
    </div>


    <!-- atualizando form 3 -->
    <div id="delivery_address_exp1" style="display: none;">
        <form name="address" action="" method="post" onsubmit="return check();">
        <h3 class="muda-titulo-3"><?=$lng_deliveryaddress;?> :
            <span class="muda-titulo-2">Preencha os campos obrigat&oacute;rios para mudan&ccedil;a de endere&ccedil;o</span>
        </h3>
        <p><label><?=$lng_onlyname;?></label><input type="text" name="name" size="20" class="campo1" value="<?=$row->delivery_name;?>" />&nbsp;<span class="red-text-12-b">*</span></p>
        <p><label><?=$lng_addressline1; ?> : </label><input type="text" name="address1" size="20" class="campo1" value="<?=$row->delivery_addressline1;?>" />&nbsp;<span class="red-text-12-b">*</span></p>
        <p><label><?=$lng_addressline2; ?> : </label><input type="text" name="address2" size="20" class="campo1" value="<?=$row->delivery_addressline2;?>" /></p>
        <p><label><?=$lng_towncity;?> : </label><input type="text" name="city" size="20" class="campo1" value="<?=$row->delivery_city;?>" />&nbsp;<span class="red-text-12-b">*</span></p>
        <p><label><?=$lng_country;?> : </label><select name="country" style="width: 220px;">
			<?
				$qrc1 = "select * from countries order by printable_name";
				$rsc1 = mysql_query($qrc1);
				while($v1 = mysql_fetch_array($rsc1))
				{
			?>
				<option <?=$row->delivery_country==$v1["countryId"]?"selected":"";?> value="<?=$v1["countryId"];?>"><?=$v1["printable_name"];?></option>
			<?
				}
			?>
			</select></p>
        <p><label><?=$lng_postcode;?>: </label><input type="text" name="zip" size="20" class="campo1" value="<?=$row->delivery_postcode;?>" />  <span class="red-text-12-b">*</span></p>
        <p><label><?=$lng_phoneno;?> : </label><input type="text" name="phone" size="20" class="campo1" value="<?=$row->delivery_phone;?>" />  <span class="red-text-12-b">*</span></p>
        <p><?=$lng_mandatoryfield;?></p>
        <p><span class="enviar">
            <input type="image" name="delconfirm" value="confirm" src="imagens/enviar.gif" width="54" height="53" 
                    onmouseout="this.style.margin='0 0 0 0'" onmouseover="this.style.margin='-26px 0 0 0'" 
                    onclick="HideDisplayDeliveryAddress(1)" />
            <input type="hidden" value="Confirm" name="del_confirm" />
        </span></p>
	    </form>	
    </div>	
<? } ?>

</div> <!-- / meus detalhes -->

</div>									
<?
	include("footer.php");
?>		
</body>
</html>
