<?
if(!isset($_SESSION['logedin'])){
    echo "<script language='javascript'>window.parent.location.href='index.php';</script>";
    exit;
}
?>