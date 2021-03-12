<?
	$perstatus = 0;
	if($_SESSION["type"]==$type1 && $type1!=""){
		$perstatus = 1;
	}elseif($_SESSION["type"]==$type2 && $type2!=""){
		$perstatus = 1;
	}elseif($_SESSION["type"]==$type3 && $type3!=""){
		$perstatus = 1;
	}else{
		$perstatus = 0;
	}
	
	if($perstatus==0){
		echo "<script language='javascript'>
				window.parent.location.href='index.php';
			</script>";
		exit;
	}
?>