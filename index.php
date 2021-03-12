<?php
    $head_tag = '<script type="text/javascript" src="js/leilao.js"></script>';
    $pgPrinc=1; include("header.php"); 
?>
                <div id="areaLeiloes"> 
                    <div class="lateralEsquerdaHome">
                        <div class="leiloesAtuais">
<?php
    $a = 1;$co="";$arr="";$prr="";
    $tpLeilao = 1;
    $txtTempo = "Finaliza em";
    $qryauc   = "select *, p.productID as pid, p.name as name, short_desc 
                from auction a left join products p on a.productID=p.productID left join 
                auc_due_table adt on a.auctionID=adt.auction_id 
                where adt.auc_due_time!=0 and a.auc_status='2' and featured_flag='0' {$categoria} 
                order by a.auctionID asc ";
    $resauc = mysql_query($qryauc);
    $totalauc = mysql_num_rows($resauc);
    if($totalauc>0){
        while($objauc=mysql_fetch_array($resauc)){
            include("inc_leilao_atual.php");
        } 
    }
    $qtf=0;
    if($qt_leiloes_eminentes>0){     //  if($totalauc<$qt_leiloes_eminentes){
        $qtf=$qt_leiloes_eminentes;  //$qtf=$qt_leiloes_eminentes-$totalauc;
        $qryauc   = "SELECT *, p.productID as pid, p.name as name, short_desc 
                    FROM auction a left join products p on a.productID=p.productID left join 
                    auc_due_table adt on a.auctionID=adt.auction_id 
                    WHERE a.auc_status=1  {$categoria} 
                    ORDER BY a.auc_start_date, a.auc_start_time ASC LIMIT {$qtf}";
        $resauc = mysql_query($qryauc);
        $total_fut = mysql_num_rows($resauc);
        while($objauc=mysql_fetch_array($resauc)){
            include("inc_leilao_atual.php");
        }
        $qtf--;
    }
?>
                        </div><!--.leiloesAtuais -->
                        <div class="clear"></div>              
                        <div class="leiloesFuturos">
                            <div class="ttlPadraoHome"><div class="texto">LEIL&Otilde;ES FUTUROS</div></div>
                            <div class="bordaMeio">	
<?php
    $tpLeilao = 2; $qt = 1 ;
    $txtTempo = "Aguardando";
    $qryauc   = "SELECT *, p.productID as pid, p.name as name, short_desc 
                FROM auction a left join products p on a.productID=p.productID left join 
                auc_due_table adt on a.auctionID=adt.auction_id 
                WHERE a.auc_status=1  {$categoria} 
                ORDER BY a.auc_start_date, a.auc_start_time ASC LIMIT {$qtf},10";
    $resauc = mysql_query($qryauc);
    $totalauc = mysql_num_rows($resauc);
    if($totalauc>0){
        while($objauc = mysql_fetch_array($resauc)){
            if($qt >1){
                echo '<div class="clear"></div>
                      <center><div class="divisaoHome"></div></center>                    	
                      <div class="clear"></div>';
            }
            include("inc_leilao_futuro.php");
            $qt++ ;
        } 
    }
?>
        
                            </div><!--.bordaMeio -->
                            <div class="bordaBaixo"></div>

                        </div><!--.leiloesFuturos -->
                
                        <div class="leiloesFuturos"><!-- LEILOES FINALIZADOS -->

                            <div class="ttlPadraoHome"><div class="texto">LEILOES FINALIZADOS</div></div>
                            <div class="bordaMeio">			
            
            
    <?php
        $qryaucEND = "SELECT *, p.productID as pid, p.name as name, short_desc 
                        FROM auction a left join products p on a.productID=p.productID left join 
                        auc_due_table adt on a.auctionID=adt.auction_id 
                        WHERE adt.auc_due_time=0 AND a.auc_status=3 
                        ORDER BY a.auc_final_end_date DESC LIMIT 3";
        $resaucEND = mysql_query($qryaucEND);
        $totalaucEND = mysql_num_rows($resaucEND);
        if($totalaucEND>0){
            //echo '<h3 id="conta-tit">Leiloes Finalizados</h3>';
            $qt = 1;
            while($objaucEND = mysql_fetch_array($resaucEND)){
                if($qt >1){
                    echo '<div class="clear"></div>
                          <center><div class="divisaoHome"></div></center>                    	
                          <div class="clear"></div>';
                }
                $qryuname_NOME = "select * from bid_account ba left join registration r on ba.user_id=r.id 
                                    where ba.auction_id=".$objaucEND["auctionID"]." and bid_flag='d' 
                                    order by ba.id desc limit 0,1";
                $resuname_NOME = mysql_query($qryuname_NOME);
                $totalname_NOME = mysql_num_rows($resuname_NOME);
                $objname_NOME = mysql_fetch_object($resuname_NOME);
                $username_NOME = $objname_NOME->username;
                        
                include("inc_leilao_finalizado.php");
                $qt++;				
            } 
        }
        ?>
                    
                            </div><!--.bordaMeio -->
                            <div class="bordaBaixo"></div>
                        </div><!--.leiloesFuturos -->

                    </div><!--.lateralEsquerdaHome -->

                    <div class="lateralDireitaHome">
                        <div id="destaquesLateral"><!--
                            <div class="titulo"><center>BANNER</center></div>
                            <div class="bordaLateral">
                                <center></center>
                            </div>
                            <div class="bordaInferiorLateral"></div> -->
                            <div id="bannercoluna">
                        	    <img src="img/layout/<?=$NomeBannerColunaLateral;?>">
                    	    </div>
                        </div><!--#destaquesLateral-->
                    </div><!--.lateralDireitaHome --> 
                                
                </div><!--#areaLeiloes -->

        <?php include("footer.php"); ?>