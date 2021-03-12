<?php
    include_once("config/connect.php");
    include_once("sendmail.php");
    include_once("functions.php");
    include("header.php");
    if($_POST['enviar_fale_conosco']!=''){

		$resp=SendHTMLMail($adminemailadd,$_POST['assunto'],$_POST['mensagem'],$_POST['email']);       
        if($resp){
            echo '<div style="float: left; position: relative; margin:5%;">
                    Obrigado pelo contato, seu e-mail foi enviado com sucesso, 
                    em breve entraremos em contato.</div>';
        }else{
            echo '<div style="float: left; position: relative; margin:5%">
                    Infelizmente ocorreu um erro, <a href="contato.html">tente novamente</a>!</div>';
        }
    } else {
?>
    <script language="javascript">
	    function Check(){
		    if(document.frm_fale_conosco.mensagem.value==""){
			    alert("<?=$lng_fale_conosco_mensagem;?>");
			    document.frm_fale_conosco.mensagem.focus();
			    return false;
		    }
		    if(document.frm_fale_conosco.nome.value==""){
			    alert("<?=$lng_fale_conosco_nome;?>");
			    document.frm_fale_conosco.nome.focus();
			    return false;
		    }
		    if(document.frm_fale_conosco.assunto.value==""){
			    alert("<?=$lng_fale_conosco_assunto;?>");
			    document.frm_fale_conosco.assunto.focus();
			    return false;
		    }
		    if(document.frm_fale_conosco.email.value==""){
			    alert("<?=$lng_fale_conosco_email;?>");
			    document.frm_fale_conosco.email.focus();
			    return false;
		    }else{
			    if(!validar_email(document.frm_fale_conosco.email,"<?=$lng_fale_conosco_email;?>")){
				    document.frm_fale_conosco.email.select();
				    return false;
			    }
		    }
            return true;
        }
        function validar_email(field,alerttxt){
		    with (field){
			    apos=value.indexOf("@");
			    dotpos=value.lastIndexOf(".");
			    if (apos<1||dotpos-apos<2){
				    alert(alerttxt);
                    return false;
			    }
		    }
			return true;
	    }
    </script>

    <br /><p>Entre em contato conosco:</p> <br />          
                
    <div class="boxDestque">
        <form action="contato.php" method="post" name="frm_fale_conosco" id="frm_fale_conosco" onsubmit="return Check()">                
            <div style="float: left; position: relative; width:50%; min-height:250px;">
                <label>Mensagem :</label><br /><textarea name="mensagem" cols="40" rows="10" class="inputPadrao" style="height:200px" ></textarea>                    
                <div class="clear"></div>
            </div>

            <div style="float: left; position: relative;">         
                <div class="clear"><br /></div>                    
                <label>Nome :</label><br /><input type="text" name="nome" value="" class="inputPadrao"  /> 

                <div class="clear"><br /></div>                    
                <label>Assunto :</label><br /><input type="text" name="assunto" value="" class="inputPadrao"  /> 
                	                
                <div class="clear"><br /></div>                    
                <label>Email :</label><br /><input type="text" name="email" value="" class="inputPadrao"  />              
                <div class="clear"><br /></div>                    
                <input type="hidden" name="acao" value="enviar" />
                <div class="btnEnviar"><input name="enviar_fale_conosco" type="submit" value="enviar" id="enviar_fale_conosco" /></div>  
            </div>                         
        </form>                    
        <div class="clear"></div>
    </div> <!--boxDestaque -->
<?php } include("footer.php"); ?>