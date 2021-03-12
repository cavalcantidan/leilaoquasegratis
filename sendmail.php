<?php
  function SendMail($to,$subject,$mailcontent,$from){
    $fromnew = "From: $from\nReply-To:$from\nX-Mailer: PHP";
    $res=@mail($to,$subject,$mailcontent,$fromnew);
    return $res;
  }
  function SendHTMLMail($to,$subject,$mailcontent,$from){
    $headers = "From: $from\nReply-To:$from\nX-Mailer: PHP\n";

    $limite = "_parties_".md5 (uniqid (rand()));

    $headers .= "Date: ".date("l j F Y, G:i")."\n";
    $headers .= "MIME-Version: 1.0\n";
    $headers .= "Content-Type: text/html;\n";
    $headers .= " boundary=\"----=$limite\"\n\n";

	/*$eol = "\n";
	$headers .= 'From: Contato <contato@localhost.com.br>'.$eol; 
	$headers .= 'Reply-To: Contato <contato@localhost.com.br>'.$eol; 
	$headers .= 'Return-Path: Contato <contato@localhost.com.br>'.$eol;    /* 
	
	/*$mime_boundary=md5(time()); 
	
	# HTML Version 
	$msg .= "--".$mime_boundary.$eol; 
	$msg .= "Content-Type: text/html; charset=<?=$lng_characset;?>".$eol; 
	$msg .= "Content-Transfer-Encoding: 8bit".$eol; 
	$msg .= $mailcontent.$eol.$eol; 
	*/
    $res=@mail($to,$subject,$mailcontent,$headers);
    return $res;
  }

?>