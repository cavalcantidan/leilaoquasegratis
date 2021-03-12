<?
	include("config/connect.php");
	include("functions.php");
	include("session.php");

	$uid = $_SESSION["userid"];

	if($_POST["submit"]!="" && $_POST["phone"]!="")
	{
		$qryupd = "update registration set phone='".$_POST["phone"]."' where id='".$uid."'";
		mysql_query($qryupd) or die(mysql_error());
		header("location: mydetails.html?msg=1");
	}

	$qr = "select * from registration r left join countries c on r.country=c.countryId where id='".$uid."'";
	$rs = mysql_query($qr);
	$total = mysql_num_rows($rs);
	$row = mysql_fetch_object($rs);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?=$lng_characset;?>" />
<title><?=$AllPageTitle;?></title>
<link href="css/style_youbid.css" rel="stylesheet" type="text/css" />
<link href="css/menu.css" rel="stylesheet" type="text/css" />
<link href="css/estilo.css" rel="stylesheet" type="text/css" />
<!--[if IE 8]>
<link href="css/estiloie8.css" rel="stylesheet" type="text/css" />
<![endif]-->
<!--[if IE 7]>
<link href="css/estiloie7.css" rel="stylesheet" type="text/css" />
<![endif]-->
<!--[if lte IE 6]>
<link href="css/menu_ie.css" rel="stylesheet" type="text/css" />
<![endif]-->
<script language="javascript" type="text/javascript" src="js/function.js"></script>
<script language="javascript">
	function Check()
	{
		if(document.f1.mobileno.value=="")
		{
			alert("<?=$lng_js_plsentermobileno;?>");
			document.f1.mobileno.focus();
			return false;
		}
	}
</script>
</head>


<body>
<div id="conteudo-principal">
<?
	include("header.php");
?>
			<? include("leftside.php"); ?>
<div id="conteudo-conta">
<h3 id="conta-tit"><?=$lng_myauctionsavenue;?> - <?=$lng_mydetails;?></h3>
<form name="f1" method="post" action="" onsubmit="return Check();">

<div id="meus-detalhes">
    <div id="meus-detalhes-tit">
        <span class="muda-titulo-3" style="color:#00c;text-shadow:1px 1px 1px #33F"><?=$lng_yourdata;?></span>
        <span class="md-computer"></span>
        <!-- / meus detalhes-tit -->
    </div>
    <p class="p-data"><span><?=$lng_customerid;?></span> <?=$row->id;?></p>
    <p class="p-data"><span><?=$lng_username;?> :</span> <?=ucfirst($row->username);?></p>
    <p class="p-data"><span><?=$lng_gender;?> :</span> <? if($row->sex=='Female'){echo $lng_female;}else{echo $lng_male;}?></p>
    <p class="p-data"><span><?=$lng_firstname;?> :</span> <?=$row->firstname;?></p>
    <p class="p-data"><span><?=$lng_lastname;?> :</span> <?=$row->lastname;?></p>
    <p class="p-data"><span><?=$lng_birthdate;?> :</span> <?=$row->birth_date;?></p>
    <p class="p-data"><span><?=$lng_emailaddress;?> :</span> <?=$row->email;?></p>
    <p class="p-data"><span><?=$lng_country;?> :</span><?=$row->printable_name;?></p>
    <p>
        <label style="display:inline-block; zoom:1; *display:inline; margin-left:15px;">
            <span><?=$lng_detailmobileno;?></span>
        </label>
        <input type="text" name="phone" value="<?=$row->phone;?>" class="campo1" style="display:inline-block; zoom:1; *display:inline; margin-left:15px;" />
        <span class="enviar">
            <input type="image" name="image" value="image" src="imagens/enviar.gif" width="54" height="53" 
                   onmouseout="this.style.margin='0 0 0 0'" onmouseover="this.style.margin='-26px 0 0 0'" />
        </span>
    </p>
    <p style="margin:20px 0 10px 15px;"><?=$lng_mydetailnote;?>
        <input type="hidden" value="submit" name="submit" />
    </p>
    <!-- / meus detalhes -->
</div>
</form>
</div>
<?
	include("footer.php");
?>		
</div>
</body>
</html>
