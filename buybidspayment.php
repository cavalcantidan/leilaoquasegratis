<?php
include_once("config/connect.php");
include_once("session.php");
include_once("functions.php");
$agora=Date("Y-m-d H:i:s");
function trataTelefone($tel){
    $tel=preg_replace('/[a-w]+.*/','',$tel);
    $numeros=preg_replace('/\D/','',$tel);
    $telefone=substr($numeros,sizeof($numeros)-9);
    $ddd=substr($numeros,sizeof($numeros)-11,2);
    $retorno=array($ddd,$telefone);
    return $retorno;
}
$qrysel = "select * from pagseguro_info order by id desc limit 1";
$ressel = mysql_query($qrysel);
$config = mysql_fetch_array($ressel);
if(mysql_num_rows($ressel)==1){
	$url_site=$config['url_site'];
	$email=$config['email'];
}else{
	header("location: message.php?msg=82"); exit;
}

//list($ddd,$telefone)=trataTelefone($cliente['telefone']);

$erro = '';
$finalfrete=0;
$uid = $_SESSION['userid'];
$qrysel = "select r.*, c.iso3 as pais from registration r left join countries c on r.country=c.countryId where r.id='$uid'";
$ressel = mysql_query($qrysel);
$total = mysql_num_rows($ressel);
if($total==1){
    $usuarios = mysql_fetch_array($ressel);
    list($ddd,$telefone)=trataTelefone($usuarios['phone']==""?$usuarios['mobile_no']:$usuarios['phone']);
    
    $cli_nome  = $usuarios['firstname'];
    $cli_pais  = $usuarios['pais'];
    $cli_cep   = preg_replace('/\D/','',$usuarios['postcode']);
    $cli_uf    = $usuarios['state'];
    $cli_cid   = $usuarios['city'];
    $cli_bai   = $usuarios['addressline2'];
    $cli_end   = $usuarios['addressline1'];
    $cli_num   = $usuarios['numero'];
    $cli_comp  = $usuarios['complemento'];
    $cli_ddd   = $ddd;
    $cli_tel   = $telefone;
    $cli_email = $usuarios['email'];
    
    if($_POST['acao']=='cl'){
        $bid=base64_decode($_POST['bpid']);
        /*$businessid = getPaypalInfo(1);
        $seguroid  	= getseguroInfo(1);
        //https://www.paypal.com/us/cgi-bin/webscr */
        
        $qrysel = "select * from bidpack where id='$bid'";
        $ressel = mysql_query($qrysel);
        $total = mysql_num_rows($ressel);
        if($total==1){
        	$rowauctionname = mysql_fetch_array($ressel);
            $produto_id = $bid;
        	$produto_descr = $rowauctionname['bidpack_name'];
        	$produto_valor =  preg_replace('/\D/','',$rowauctionname['bidpack_price']);
        }else{
            $erro = "Desculpe ocorreu um erro com este produto, em breve solucionaremos! Por favor tente mais tarde!";
        }
    }elseif($_POST['acao']=='pl'){
        $auctionid = $_POST['auctionid'];
    	$qrysel = "select *, w.id as codP, DATEDIFF('$agora',won_date) AS expiry, DATEDIFF('$agora',accept_date) expirywon
         from won_auctions w left join auction a on w.auction_id=a.auctionID 
         left join products p on a.productID=p.productID left join shipping s on s.id = shipping_id
         where w.userid=$uid and w.auction_id = $auctionid and w.accept_denied=''";
        $ressel = mysql_query($qrysel);
        $total = mysql_num_rows($ressel);
                
        if($total==1){
    		$obj = mysql_fetch_array($ressel);
            $produto_id = $obj["codP"];
            $produto_descr = $obj["short_desc"];
    		$produto_valor = preg_replace('/\D/','',$obj["auc_final_price"]);
    		$finalfrete = preg_replace('/\D/','',$obj["shippingcharge"]);
            $r = mysql_query("update won_auctions w set accept_denied = 'Accepted', accept_date = '$agora', situacaodescr ='Aguardando PagSeguro'
            where w.userid=$uid and w.auction_id = $auctionid and w.accept_denied='' ");
            
        }else{
            $erro = "Desculpe ocorreu um erro com este produto, em breve solucionaremos! Por favor tente mais tarde!<br>";
        }        
    }else{
        $erro = "Desculpe n&atilde;o entendemos esta solicita&ccedil;&atilde;o, em breve solucionaremos! Por favor tente mais tarde!";
    }
}else{
	$erro = "Desculpe usu&aacute;rio '$uid' n&atilde;o foi encontrado, em breve solucionaremos! Por favor tente mais tarde!";
}

if($erro==''){
    // Cadastrar a abertura da transacao no banco
    $prodv=$produto_valor/100;
    $SQL = "insert into pagseguro (DtCad,TipoVenda,ProdID_1,ProdDescricao_1,ProdValor_1,ValorFrete,CliCod,CliEmail,StatusTransacao) values 
            ('$agora','{$_POST['acao']}','$produto_id','$produto_descr',{$prodv},$finalfrete,$uid,'$cli_email','Aguardando Pagamento')";
	$res=mysql_query($SQL);
	
    if($res){$codVenda = mysql_insert_id();}else{ $erro='Desculpe erro ao tentar registrar a transa&ccedil;&atilde;o!';}
}

if($erro!=''){ 
    include("header.php");
?>
    <div id="conteudo-principal">
        <?
           include("leftside.php");  
        ?>
        <div id="conteudo-conta">
                <h3 id="comprar-tit"> <?=$lng_tabbuybids;//$lng_myauctionsavenue;?></h3>
                <br /><br /><br />
                <h3><? echo $erro; ?></h3>
        </div>
    </div>
<?php 
    include("footer.php"); 
    exit; 
} 
///$proto = strtolower(preg_replace('/[^a-zA-Z]/','',$_SERVER['SERVER_PROTOCOL'])); //pegando so o que for letra
///$location = $proto.'://'.$_SERVER['HTTP_HOST'].'/pagsegsucesso.php';//.$_SERVER['SCRIPT_NAME'];//$_SERVER['SERVER_NAME'];

$_SESSION['ServidorEnvio']=$SITE_URL.'/pagsegsucesso.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?=$lng_characset;?>" />
<title><?=$AllPageTitle;?></title>
<script language='javascript'>
function frmnew(){ 
	document.pagseguro.submit();
}
</script>
</head>

<body onload="frmnew();">
<!-- https://pagseguro.uol.com.br/checkout/checkout.jhtml -->		

<form name="pagseguro" method="post" action="<?php echo $url_site; ?>">

<input type="hidden" name="email_cobranca" value="<?php echo $email; ?>" /><br />
<input type="hidden" name="tipo" value="CP" /><br />
<input type="hidden" name="moeda" value="BRL" /><br />
<input type="hidden" name="tipo_frete" value="EN" /><br />
<input type="hidden" name="ref_transacao" value="<? echo $codVenda;?>" /><br />

<input type="hidden" name="item_id_1" value="<? echo $produto_id;?>" /><br />
<input type="hidden" name="item_descr_1" value="<? echo $produto_descr;?>" /><br />
<input type="hidden" name="item_quant_1" value="1" /><br />
<input type="hidden" name="item_valor_1" value="<? echo $produto_valor;?>" /><br />
<input type="hidden" name="item_frete_1" value="0" /><br />
<input type="hidden" name="item_peso_1" value="0" /><br />

<!-- INICIO DOS DADOS DO USUARIO -->
<input type="hidden" name="cliente_nome" value="<? echo $cli_nome ;?>" />
<input type="hidden" name="cliente_cep" value="<? echo $cli_cep ;?>" />
<input type="hidden" name="cliente_end" value="<? echo $cli_end ;?>" />
<input type="hidden" name="cliente_num" value="<? echo $cli_num ;?>" />
<input type="hidden" name="cliente_compl" value="<? echo $cli_comp ;?>" />
<input type="hidden" name="cliente_bairro" value="<? echo $cli_bai ;?>" />
<input type="hidden" name="cliente_cidade" value="<? echo $cli_cid ;?>" />
<input type="hidden" name="cliente_uf" value="<? echo $cli_uf ;?>" />
<input type="hidden" name="cliente_pais" value="<? echo $cli_pais ;?>" />
<input type="hidden" name="cliente_ddd" value="<? echo $cli_ddd ;?>" />
<input type="hidden" name="cliente_tel" value="<? echo $cli_tel ;?>" />
<input type="hidden" name="cliente_email" value="<? echo $cli_email ;?>" />
<!-- FIM DOS DADOS DO USUARIO -->

<!--input type="submit" name="submit" /-->
</form>
 <center><h1>Comunicando com o PagSeguro, por favor aguarde ...</h1></center>
</body>
</html>