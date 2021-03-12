<?
	include_once("admin.config.inc.php");
	include("connect.php");
	include("functions.php");
	include("security.php");
	$PRODUCTSPERPAGE = 50;
    
    if(!isset($_GET['pgno'])){$PageNo = 1;}else{$PageNo=$_GET['pgno'];}
    
	if($_POST["submit"]!="" ){
	// || $_GET["sdate"]!=""
    	if($_POST["submit"]!=""){
    		$startdate =$_POST["datefrom"]!=""?ChangeDateFormat($_POST["datefrom"]):'';
    		$enddate = $_POST["dateto"]!=""?ChangeDateFormat($_POST["dateto"]):'';
    		
    	}else{
    		$startdate = $_GET["sdate"]!=""?ChangeDateFormat($_GET["sdate"]):'';
    		$enddate = $_GET["edate"]!=""?ChangeDateFormat($_GET["edate"]):'';
    	}

        $filro = '';
 		if($startdate!="") $filro .= ($filro!=''?' and ':'')."DtCad>='$startdate'";
		if($enddate!="")   $filro .= ($filro!=''?' and ':'')."DtCad<='$enddate'";
       	if($filro!='') $filro = " where ".$filro;
        //$qrysel = "select * from pagseguro where situacao = 3 and TipoVenda = 'cl'";
        $qrysel = "select p.*, r.username from pagseguro p left join registration r on p.CliCod=r.id $filro order by situacao desc, TipoVenda";
		
		$ressel = mysql_query($qrysel);
		$total = mysql_num_rows($ressel);
		$totalpage=ceil($total/$PRODUCTSPERPAGE);
		if($totalpage>=1){
    		$startrow=$PRODUCTSPERPAGE*($PageNo-1);
    		$qrysel.=" LIMIT $startrow,$PRODUCTSPERPAGE";
            //echo $qrysel;
    		$ressel=mysql_query($qrysel);
    		$total=mysql_num_rows($ressel);
		}
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?=$lng_characset;?>" />
<link rel="stylesheet" href="main.css" type="text/css" />
<title><? echo $ADMIN_MAIN_SITE_NAME." - Relat&oacute;rio Financeiro PagSeguro"; ?></title>
<link href="zpcal/themes/aqua.css" rel="stylesheet" type="text/css" media="all" title="Calendar Theme - aqua.css" />
<script type="text/javascript" src="zpcal/src/utils.js"></script>
<script type="text/javascript" src="zpcal/src/calendar.js"></script>
<script type="text/javascript" src="zpcal/lang/calendar-en.js"></script>
<script type="text/javascript" src="zpcal/src/calendar-setup.js"></script>
<script language="javascript">
	function Check(f1){	
        return true;
	}
	function OpenPopup(url){
		window.open(url,'popupWindow','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=no,copyhistory=no,width=100,height=100,screenX=300,screenY=350,top=300,left=350');
	}
</script>
</head>

<body>
<table width="100%"  border="0" cellpadding="0" cellspacing="10">
  <!--DWLayoutTable-->
    <tr><td width="100%" class="H1">Relat&oacute;rio Financeiro</td></tr>
  	<tr><td background="images/vdots.gif"><img height="1" src="images/spacer.gif" width="1" border="0" /></td></tr>
	<tr><td height="10"></td></tr>
	<tr><td height="5"></td></tr>
	<tr><td align="center" class="h2"><b>Por Favor Selecione a Data</b></td></tr>
	<tr><td height="5"></td></tr>
    
	<form name="f1" action="" method="post" onsubmit="return Check(this)">	
    	<tr>
    		<td align="center">
                <b>De</b> : <input class="textbox" type="text" name="datefrom" id="datefrom" size="12" value="<?=$startdate!=""?ChangeDateFormatSlash($startdate):"";?>" />
                &nbsp;&nbsp;<img src="images/pmscalendar.gif" align="absmiddle" width="20" height="20" id="vfrom" />
                &nbsp;&nbsp;-&nbsp;&nbsp; <b>&agrave;</b> : <input class="textbox" type="text" name="dateto" size="12" id="dateto" value="<?=$enddate!=""?ChangeDateFormatSlash($enddate):"";?>" />
                &nbsp;&nbsp;<img src="images/pmscalendar.gif" align="absmiddle" width="20" height="20" id="zfrom" />&nbsp;&nbsp;</font>
                &nbsp;&nbsp;<input type="submit" name="submit" value="Buscar" class="bttn-s" />
            </td>
    	</tr>
    	<tr>
    		<td height="5"></td>
    	</tr>
    </form>	
	<tr>
    	<td><!--content-->
		<? 
        if(isset($total)){
			 if($total==0){
		?>
		<table width="70%" border="0" cellspacing="1" cellpadding="1" align="center"> 
		<tr><td height="8"></td></tr>
		<tr> 
			<td class="th-a"> 
			  <div align="center">Sem Informa&ccedil;&otilde;es Para Exibir.</div>
			</td>
		</tr>			
      </table>
	 <?
        }else{
	?>
          <table width="100%" border="1" cellspacing="0" class="t-a">
              <tr class="th-a"> 
				<td nowrap="nowrap" align="left" width="7%">Refer&ecirc;ncia</td>
				<td nowrap="nowrap" align="left">Transa&ccedil;&atilde;o ID</td>
				<td nowrap="nowrap" align="left">Tipo de Pagamento</td>
				<td nowrap="nowrap" align="left">Situa&ccedil;&atilde;o</td>
				<td nowrap="nowrap" align="center">Usu&aacute;rio</td>
				<td nowrap="nowrap" align="center">Email</td>
				<td nowrap="nowrap" align="left">Produto</td>
				<td nowrap="nowrap" align="right">Valor</td></td>
				<td nowrap="nowrap" align="center" width="4%">Cadastro</td>
                <!--td nowrap="nowrap" align="center">Op&ccedil;&otilde;es</td-->
			 </tr>
		<?
			while($obj = mysql_fetch_object($ressel)){
				if ($colorflg==1){
					$colorflg=0;
					echo "<tr bgcolor=\"#f4f4f4\"> ";
				}else{
					$colorflg=1;
				  	echo "<tr> ";
				}
		?>
				<td nowrap="nowrap" align="right"><?=$obj->Referencia;?></td>
				<td nowrap="nowrap" align="left"> <?=$obj->TransacaoID;?>
				<td nowrap="nowrap" align="center"><?=$obj->TipoPagamento?></td>
				<td nowrap="nowrap" align="center"><?=$obj->StatusTransacao;?></td>
				<td nowrap="nowrap" align="center"><input type="button" name="button" class="bttn" value="<?=$obj->username;?>" onclick="window.location.href='view_member_statistics.php?uid=<?=$obj->CliCod;?>'" /></td>
				<td nowrap="nowrap" align="center"><?=$obj->CliEmail;?></td>
				<td align="center"><?=$obj->ProdDescricao_1;?></td>
				<td nowrap="nowrap" align="right"><?=$obj->ProdValor_1!=""?$Currency." ". number_format($obj->ProdValor_1,2,',','.'):$Currency." 0,00";?></td>
				<td nowrap="nowrap" align="center"><?=$obj->DtCad;?></td>
				<!--td width="21%" align="center" nowrap="nowrap">
					<input type="button" name="details" class="bttn" value="Detalhes" onclick="window.location.href='pagSeguroDetalhes.php?aid=<?=$obj->Referencia;?>'" />
				</td-->
			</tr>
		<?
			}
		?>		
		 </table>
		  <?
			if($PageNo>1){ $PrevPageNo = $PageNo-1;
		  ?>
		  <a class='paging' href="finan_pagseg.php?pgno=<?=$PrevPageNo;?>&<?=$urldata;?>">&lt; P&aacute;gina Anterior</a>
		  <?
		   }
            echo '&nbsp;&nbsp;&nbsp;';
			if($PageNo<$totalpage){ $NextPageNo = 	$PageNo + 1;
		  ?>
		      <a class='paging' id='next' href="finan_pagseg.php?pgno=<?=$NextPageNo;?>&<?=$urldata;?>">Pr&amp;oacute;xima P&amp;aacute;gina &gt;</a>
		  <?
		   }
		}
	}
		if($total>0){
			?>
			<br /><br /> <!--
			<table align="center">
			<tr>
			<td><input type="button" name="submit" class="bttn" value="Exportar em CSV" onclick="OpenPopup('download.php?export=financial&datefrom=<?=$_POST["datefrom"]?>&dateto=<?=$_POST["dateto"]?>&products=<?=$_POST["products"]?>')" /></td>
			</tr>
			</table> -->
			<?
		}
		?>
	 </td>
	 </tr>
</table>
<script type="text/javascript">
var cal = new Zapatec.Calendar.setup({ 
    inputField:"datefrom",
    ifFormat:"%d/%m/%Y",
    button:"vfrom",
    showsTime:false 
});
</script>
<script type="text/javascript">
var cal = new Zapatec.Calendar.setup({ 
    inputField:"dateto",
    ifFormat:"%d/%m/%Y",
    button:"zfrom",
    showsTime:false 
});
</script>	
</body>
</html>
