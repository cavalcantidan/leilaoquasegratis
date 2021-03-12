<?php
	header('Content-Type: text/html; charset=<?=$lng_characset;?>');
    $agora = Date("Y-m-d H:i:s") ;
	include_once("config/connect.php");
    include_once("funcoes_pagamento.php");
    include_once("functions.php");
	$ressel = mysql_query("select * from pagseguro_info order by id desc limit 1");
	if (mysql_num_rows($ressel)>0){
		$row = mysql_fetch_object($ressel);
		define('TOKEN', $row->token);
		define('URL_VERIF', $row->url_verificacao);
	}else{
		define('TOKEN', '');
		define('URL_VERIF', '');
	}
	


class PagSeguroNpi {
	
	private $timeout = 20; // Timeout em segundos
	
	public function notificationPost() {
		$postdata = 'Comando=validar&Token='.TOKEN;
		foreach ($_POST as $key => $value) {
			$valued    = $this->clearStr($value);
			$postdata .= "&$key=$valued";
		}
		return $this->verify($postdata);
	}
	
	private function clearStr($str) {
		if (!get_magic_quotes_gpc()) {
			$str = addslashes($str);
		}
		return $str;
	}
	
	private function verify($data) {
		$curl = curl_init();
		//curl_setopt($curl, CURLOPT_URL, "https://pagseguro.uol.com.br/pagseguro-ws/checkout/NPI.jhtml");
		curl_setopt($curl, CURLOPT_URL, URL_VERIF);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_HEADER, false);
		curl_setopt($curl, CURLOPT_TIMEOUT, $this->timeout);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		$result = trim(curl_exec($curl));
		curl_close($curl);
		return $result;
	}

}

function logpag($mensagem, $data, $arq) {
    $f=fopen ("pagseguro_$arq.log", 'a'); # o "a" eh para ele "appendar" o conteudo, ou seja, colocar ao final
    fwrite($f, "$mensagem\n\r\n\r"); # escrevendo a mensagem, mais uma quebra de linha
    fwrite($f, var_export($data, true)); # imprime os dados no arquivo de log
    fwrite($f, "\n\r\n\r\n\r---------\n\r\n\r"); # um espaco para separar as ocorrencias
    fclose($f);
}
if (count($_POST) > 0) {
	
	// POST recebido, indica que eh a requisicao do NPI.
	$npi = new PagSeguroNpi();
	$result = $npi->notificationPost();
	
	$transacaoID = isset($_POST['TransacaoID']) ? $_POST['TransacaoID'] : '';
	
	if ($result == "VERIFICADO") {
		//O post foi validado pelo PagSeguro.
        logpag('O post foi validado pelo PagSeguro.', $_POST, $result);
        
        $tipoVenda = '';
        $SQL = "Select * from pagseguro where Referencia = '{$_POST['Referencia']}'";
        $res=mysql_query($SQL);
        $total = mysql_num_rows($res);
        if ($total==1){ // atualizar o status da transacao
            $dados = mysql_fetch_array($res);
            $uid = $dados['CliCod'];
            $pid = $dados['ProdID_1'];
            $pvl = $dados['ProdValor_1'];
            $tipoVenda=$dados['TipoVenda'];
            if($dados['situacao']==0 or $dados['situacao']==1){ //situacao 0- aguardando ps   1- ps aguardando   2- ps cancelado   3- ps concluido
                $situacao = 1; // Aguardando Pagto ou Em Analise
                if($_POST['StatusTransacao']=='Completo' or $_POST['StatusTransacao']=='Aprovado'){ 
                    $situacao = 3;
                }elseif($_POST['StatusTransacao']=='Cancelado'){ 
                    $situacao = 2; 
                }
                $SQL = "update pagseguro set TransacaoID = '{$_POST['TransacaoID']}', StatusTransacao='{$_POST['StatusTransacao']}', TipoPagamento = '{$_POST['TipoPagamento']}',
                    DataTransacao = '". ChangeDateBT($_POST['DataTransacao'],'-')."', Anotacao = '{$_POST['Anotacao']}', ProdValor_1 = '{$_POST['ProdValor_1']}',
                    Extras = '{$_POST['Extras']}', situacao = '$situacao' where Referencia = '{$_POST['Referencia']}'";
            	$res = mysql_query($SQL); 
                if($res && $situacao==3){
                    // sem erro
                    if($tipoVenda=='cl'){ // creditar os lances comprados
                        $res=mysql_query("select * from bidpack where id = '$pid'");
                        $prod =  mysql_fetch_array($res);
                        $qt = $prod['bid_size'];
                        
       					$qryins = "Insert into bid_account (user_id, bidpack_buy_date, bid_count, bid_flag, recharge_type, bidpack_id, credit_description,bidding_price ) values
                                    ('$uid','$agora','$qt','c','re','$pid','Compra de Lance','$pvl')";
    					mysql_query($qryins);
    					$insertid = mysql_insert_id();
				        $qryupd = "update registration set final_bids=final_bids+$qt where id='$uid'";
				        mysql_query($qryupd);

				        $qryupd = "select * from registration where id='$uid'";
				        $res = mysql_query($qryupd);
                        $dados = mysql_fetch_array($res);
                        // *** enviar e-mail de aviso
                        EnviarEmailCredito($dados['email'],$dados['username'],$qt,'Compra de Crédito');

                        // bonus por indicacao
                        if($dados["sponser"]!=0){
                            $qryaff = "select * from registration where id='{$dados["sponser"]}'";
					        $resaff = mysql_query($qryaff);
                            if(mysql_num_rows($resaff)>0){
					            $objaff = mysql_fetch_object($resaff);
					            $fbid = $objaff->final_bids;
		                        $bonusbids = 0;
        	                    $qrybonus = "select * from general_setting";
	                            $resbonus = mysql_query($qrybonus) or die(mysql_error());
	                            if(mysql_num_rows($resbonus)>0){
		                            $objbonus = mysql_fetch_array($resbonus);
		                            $bonusbids = $objbonus["bonus_indicacao"];
	                            }
                                if($bonusbids>0){		
					                $updaff = "update registration set final_bids='".($fbid + $bonusbids)."' where id='{$dados["sponser"]}'";
					                mysql_query($updaff) or die(mysql_error());			
					
					                $insaff = "Insert into bid_account (user_id, bidpack_buy_date, bid_count, bid_flag, recharge_type, referer_id, credit_description) 
                                                                values('".$obj->sponser."',NOW(),'$bonusbids','c','af','$uid','Bônus de indicação')";
					                mysql_query($insaff) or die(mysql_error());
					                $insertidaff = mysql_insert_id();
                                    // enviar e-mail de aviso de bonus por indicacao
                                    EnviarEmailCredito($objaff->email,$objaff->username,$bonusbids,'Bônus de indicação');
                                }
                            }                        
                        }


                    }elseif($tipoVenda=='pl'){
                        $r = mysql_query("update won_auctions set payment_date = '$agora', situacaodescr ='Preparando Envio'
                                            where userid=$uid and id = $pid ");
                        // enviar e-mail de aviso de pagamento recebido
                        $qryupd = "select * from registration where id='$uid'";
				        $res = mysql_query($qryupd);
                        $dados = mysql_fetch_array($res);
                        //EnviarEmail??? ($dados['email'],$dados['username'],'Pagamento Confirmado!');
                    }
                    
                }
            }
            
        }else{
            // Erro - quantidade de transacoes invalidas
        }
        // fim das validacoes
	} else if ($result == "FALSO") {
		//O post nao foi validado pelo PagSeguro.
        logpag('O post n&atilde;o foi validado pelo PagSeguro.', $_POST, $result);
	} else {
		//Erro na integracao com o PagSeguro.
        logpag('Erro na integra&ccedil;&atilde;o com o PagSeguro. '.$result, $_POST, 'ERRO');
	}
	
} else {
	// POST nao recebido, indica que a requisicao eh o retorno do Checkout PagSeguro.
	// No termino do checkout o usuario eh redirecionado para este bloco.
	include_once("session.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="refresh" content="0;url=<?=$_SESSION['ServidorEnvio'];?>" />
</head>
    <?php
}

?>