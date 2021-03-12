<?php
	session_start();
    $usuario_admin=isset($_SESSION['UsErOfAdMiN'])?$_SESSION['UsErOfAdMiN']:'';
    if($usuario_admin==''){
        echo "<script language=javascript>window.parent.location.href='index.php'</script>";
    }
?>