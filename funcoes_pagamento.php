<?php

include_once("sendmail.php");

function EnviarEmailCredito($email,$nome,$qt,$motivo){
		$from = $adminemailadd;
		$subject = "Lances Creditados em sua Conta";

		$content1= "<font style='font-size: 10px;font-family: Arial, Helvetica, sans-serif;color: #333333;'>
        Membro,</font><br><br><p align='center' style='font-size: 14px;font-family: Arial, Helvetica, sans-serif;font-weight:bold;'>
        {$nome}</p><br>".	
	
	"<table border='0' cellpadding='3' cellspacing='0' width='100%' align='center' class='style13'>
        <tr style='font-size: 10px;font-family: Arial, Helvetica, sans-serif;color: #333333;'>
		    <td colspan='2'>Aviso de credito de lances por compra aprovada.</td>
		</tr>
        <tr style='font-size: 10px;font-family: Arial, Helvetica, sans-serif;color: #333333;'>
			<td>Quantidade :</td><td>{$qt}</td>
		</tr>
        <tr style='font-size: 10px;font-family: Arial, Helvetica, sans-serif;color: #333333;'>
			<td>Motivo :</td><td>{$motivo}</td>
		</tr>
        <tr style='font-size: 10px;font-family: Arial, Helvetica, sans-serif;color: #333333;'>
		<td colspan='2'>&nbsp;</td>
		</tr>
		</table>";

		SendHTMLMail2($email,$subject,$content1,$from);
	}

?>