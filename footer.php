            </div><!--.conteudo -->      
        </div> <!--#main -->
    <!-- <span style="display: none;" class="firstimagebold" id="firstimage_bold"><?=$totalauc;?></span> -->

    <div class="clear"></div>
    <div id="rodape">
        <div class="conteudoR">
            <!-- <img src="img/layout/forma_pgto.jpg" class="right" /> -->
            <div class="menuRodape">
                <div class="institucional">
                    <img src="img/layout/icoRodape.png" /><a href="terms_and_conditions.html">Termos e condi&ccedil;&otilde;es</a> <br />
                    <img src="img/layout/icoRodape.png" /><a href="privacy_policy.html">Pol&iacute;tica de privacidade</a><br />
                    <img src="img/layout/icoRodape.png" /><a href="about_us.html">Sobre n&oacute;s</a><br />
                </div> <!--empresa -->

                <div class="servicos">
                    <img src="img/layout/icoRodape.png" /><a href="contact.html">Fale Conosco</a><br />
                    <img src="img/layout/icoRodape.png" /><a href="jobs.html">Trabalhe Conosco</a><br />
                    <!--img src="img/layout/icoRodape.png" /><a href="leilao/aovivo">Leil&otilde;es iniciados</a><br /-->
                    <img src="img/layout/icoRodape.png" /><a href="all_ended_auctions_3.html">Leil&otilde;es finalizados</a><br />
                            
                </div> <!--cadastro -->  
            
                <div class="atendimento">
                    <!-- <img src="img/layout/icoRodape.png" /><a href="suporte">Fale conosco</a><br /> -->
                    <? if($_SESSION["userid"]==""){ ?>
                    <img src="img/layout/icoRodape.png" /><a href="registration.html">Cadastre-se</a><br />
                    <? }else{ ?>
                    <img src="img/layout/icoRodape.png" /><a href="myaccount.html">Minha Conta</a><br />
                    <? } ?> 
                    <img src="img/layout/icoRodape.png" /><a href="how_it_works.html">Como Funciona</a><br />    
                    <img src="img/layout/icoRodape.png" /><a href="help.html">Ajuda</a><br />    
                </div> <!--leiloes -->
            
                <div class="pagamento">
                    <img src="img/layout/icoRodape.png" />Cart&atilde;o de cr&eacute;dito<br />
                    <img src="img/layout/icoRodape.png" />Cart&atilde;o de d&eacute;bito<br />
                    <img src="img/layout/icoRodape.png" />Boleto banc&aacute;rio<br />
                    <img src="img/layout/icoRodape.png" />D&eacute;bito em conta<br />     
                </div> <!--servicos -->
                <div class="clear"><br /></div>
                <p style="line-height:170%;">
                    <?php echo $AllPageTitle; ?> © Copyright 2011 - Todos os direitos reservados <a href="http://designmp.net"> Design MP </a>
                </p>
            </div><!--menurodape -->
            <div class="clear"><br /></div>
            
	    </div><!--.conteudo -->   
        <div class="clear"><br /></div>
        <div class="clear"><br /></div>
        <div class="clear"><br /></div>
        <div class="clear"><br /></div>
        <div class="clear"><br /></div>
        <div class="clear"><br /></div>
        </div>
        <script type="text/javascript">
            var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
            document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));

            try {
            var pageTracker = _gat._getTracker("UA-10499663-4");
            pageTracker._trackPageview();
            } catch(err) {}
        </script>
    </body>
</html>