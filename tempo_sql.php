<?php

    if(isset($use_stored)&&$use_stored==true){

        //$tp=@mysqli_connect($DBSERVER, $USERNAME, $PASSWORD,$DATABASENAME);
        //$leilao = mysqli_multi_query($tp,"call cron_tempo()");
        $tp = mysql_connect($DBSERVER, $USERNAME, $PASSWORD,true,65536+131072)or die("Erro Banco");
        mysql_select_db($DATABASENAME,$tp);
        $leilao = mysql_query("call cron_tempo()",$tp);   
        mysql_close($tp);
        $db=mysql_connect($DBSERVER, $USERNAME, $PASSWORD);
        if (!$db) {die('N&atilde;o foi possivel conectar: ' . mysql_error());}
        mysql_select_db($DATABASENAME,$db);

    }else{
    
        include_once("config/connect.php");
        $agora=date("Y-m-d H:i:s");
        $tp=mysql_connect($DBSERVER, $USERNAME, $PASSWORD,true);
        mysql_select_db($DATABASENAME,$tp);
        ini_set("max_execution_time",45000);
        $novo = false;
        // Verificar se existe ultima consulta no cron
        $leilao = mysql_query("SELECT now()-tempo as total FROM cron",$db);
        if(!$leilao||mysql_num_rows($leilao)==0){
            $ressel = mysql_query("insert into cron (tempo) values(now())",$db);
            $leilao = mysql_query("SELECT now()-tempo as total FROM cron",$db);
            $novo=true;
        }    

        $objLeilao = mysql_fetch_object($leilao);

        if ($objLeilao->total>=1||$novo==true){

            // atualiza a data da ultima consulta
            $ressel = mysql_query("update cron set tempo = now()",$db);


            mysql_query("BEGIN",$db);


            // contagem regressiva dos leiloes ativos
            $ressel = mysql_query("update auc_due_table adt left join auction a on a.auctionID=adt.auction_id
                 set adt.auc_due_time=adt.auc_due_time-1 
                 where adt.auc_due_time>0 and a.pause_status=0 and a.auc_status=2",$db);
            if(!$ressel){ mysql_query("ROLLBACK",$db); echo "Falha 1"; exit; }



            // ativar os leiloes futuros que estao no horario de inicio 
            // :: deve criar auc_due_table se nao existir
            $ressel = mysql_query("update auction a set auc_status=2 where pause_status=0 and auc_status=1 and 
                 (TIMEDIFF(DATE_FORMAT(concat(concat(auc_start_date,' '), auc_start_time),'%Y-%m-%d %T'),DATE_FORMAT('$agora','%Y-%m-%d %T'))+0)<0",$db);
            if(!$ressel){ mysql_query("ROLLBACK",$db); echo "Falha 2"; exit; }
            $ressel = mysql_query("Insert Into auc_due_table(auction_id,auc_due_time,auc_due_price,auc_limite_total)
                 SELECT a.auctionID,m.auc_plus_time,m.auc_plus_price,a.max_robot_consec FROM auction a inner join auction_management m on
                    a.time_duration=m.auc_manage left join auc_due_table t on a.auctionID=t.auction_id
                    where t.auc_due_time is null and (a.auc_status=2 or a.auc_status=1) and a.pause_status=0",$db);
            if(!$ressel){ mysql_query("ROLLBACK",$db); echo "Falha 3"; exit; }





            /* robo mantendo o preco minimo 
               robo -> admin_user_flag = 1 and user_delete_flag != 'd'     */
            $seg = rand(2,8); // :: rand( minimo, maximo );
            if ($seg<2){$seg=2;}
            // listar os leiloes em aberto cujo valor minimo nao foi alcancado 
            // e o tempo esteja terminando com ultimo usuario que lancou
            $leilao = mysql_query("SELECT * from c_cron_tempo
                         where (auc_due_time = $seg or auc_due_time <2)",$tp);

            if(!$leilao){ mysql_query("ROLLBACK",$db); echo "Falha 4"; exit; }
            $x=0;// para cada leilao da lista
            while($objLeilao = mysql_fetch_object($leilao)){
	            $proxValor=$objLeilao->auc_due_price+$objLeilao->auc_plus_price;
	
                // verificar se o leilao esta sendo disputado so por robos a mais de 
                // 5.000 lances e entao cancelar o leilao, aproximadamente meio dia


	            // robos disponiveis qt
	            $robos = mysql_query("SELECT * FROM registration where admin_user_flag='1'
                                      and user_delete_flag != 'd' and id != ".$objLeilao->ultUserId,$db);
	            if(!$robos){ mysql_query("ROLLBACK",$db); echo "Falha 5"; exit; }
	            $totalrobos = mysql_num_rows($robos);
	            if($totalrobos<1){mysql_query("ROLLBACK",$db); echo "Falha 6"; exit;}
	            // sorteio do robo
	            $roboSort=rand( 0, $totalrobos-1 );
	            $robos = mysql_query("SELECT * FROM registration where admin_user_flag='1'
                                    and user_delete_flag != 'd' and id != ".$objLeilao->ultUserId." limit $roboSort,1",$db);
	            if(!$robos){ mysql_query("ROLLBACK",$db); echo "Falha 7"; exit; }
	            $objRobo = mysql_fetch_object($robos);
	
	            // dar lance
	            $ressel = mysql_query("Insert into bid_account (user_id,bidpack_buy_date,bid_count,auction_id,product_id,bid_flag,bidding_price,bidding_type,bidding_time)
                                values('{$objRobo->id}','$agora','1','{$objLeilao->auctionID}','{$objLeilao->productID}','d',$proxValor,'s',{$objLeilao->auc_due_time})",$db);
	            if(!$ressel){ mysql_query("ROLLBACK",$db); echo "Falha 8"; exit; }
	            // retornar o tempo e aumentar o preco
	            $ressel = mysql_query("Update auc_due_table set auc_limite_atual=auc_limite_atual+1, auc_due_time='".$objLeilao->auc_plus_time."',auc_due_price=$proxValor where auction_id='{$objLeilao->auctionID}'",$db);
	            if(!$ressel){ mysql_query("ROLLBACK",$db); echo "Falha 9"; exit; }
            }



            // listar os leiloes em aberto que nao possuem lance
            $leilao = mysql_query("SELECT a.*,m.auc_plus_time,m.auc_plus_price, 0 as ultUserId, t.auc_due_time, t.auc_due_price
                    FROM auction a inner join auction_management m on a.time_duration=m.auc_manage left join auc_due_table t on a.auctionID=t.auction_id 
                    left join bid_account l on a.auctionID = l.auction_id
                    where a.auc_status=2 and a.pause_status=0 and l.auction_id is null and t.auc_due_time < 3",$tp);
            if(!$leilao){ mysql_query("ROLLBACK",$db); echo "Falha 11"; exit; }
            while($objLeilao = mysql_fetch_object($leilao)){
	            $proxValor=$objLeilao->auc_due_price+$objLeilao->auc_plus_price;
	            $robos = mysql_query("SELECT * FROM `registration` where admin_user_flag='1' and `user_delete_flag` != 'd'",$db);
	            if(!$robos){ mysql_query("ROLLBACK",$db); echo "Falha 12"; exit; }
	            $totalrobos = mysql_num_rows($robos);
	            if($totalrobos<1){mysql_query("ROLLBACK",$db); echo "Falha 13"; exit;}
	            // sorteio do robo
	            $roboSort=rand( 0, $totalrobos-1 );
	            $robos = mysql_query("SELECT * FROM registration where admin_user_flag='1'
                                    and user_delete_flag != 'd' and id != ".$objLeilao->ultUserId." limit $roboSort,1",$db);
	            if(!$robos){ mysql_query("ROLLBACK",$db); echo "Falha 14"; exit; }
	            $objRobo = mysql_fetch_object($robos);
	            // dar lance
	            $ressel = mysql_query("Insert into bid_account (user_id,bidpack_buy_date,bid_count,auction_id,product_id,bid_flag,bidding_price,bidding_type,bidding_time)
                                values('{$objRobo->id}','$agora','1','{$objLeilao->auctionID}','{$objLeilao->productID}','d',$proxValor,'s',{$objLeilao->auc_due_time})",$db);
	            if(!$ressel){ mysql_query("ROLLBACK",$db); echo "Falha 15"; exit; }
	            // retornar o tempo e aumentar o preco
	            $ressel = mysql_query("Update auc_due_table set auc_due_time='".$objLeilao->auc_plus_time."',auc_due_price=$proxValor where auction_id='{$objLeilao->auctionID}'",$db);
	            if(!$ressel){ mysql_query("ROLLBACK",$db); echo "Falha 16"; exit; }
            }



            // fechar os leiloes q esgotaram o tempo :: avisar ganhador 
            // auc_final_price 	auc_final_end_date buy_user
            $codigo="update auc_due_table adt left join 
                        auction a on a.auctionID=adt.auction_id left join 
                        (select g.auction_id, d.user_id from 
                            (select max(id) as id, auction_id from bid_account 
                                where bid_flag = 'd' and bidding_type = 's' 
                                group by auction_id) g inner join 
                            bid_account d on g.id=d.id) b on a.auctionID=b.auction_id
                        set a.auc_status=3, a.auc_final_price = adt.auc_due_price,
                            a.auc_final_end_date='$agora', a.buy_user = COALESCE(b.user_id,0)
                        where adt.auc_due_time=0 and a.pause_status=0 and a.auc_status=2";
            // echo "<br><br>$codigo<br>";
            $ressel = mysql_query($codigo,$db);
            if(!$ressel){ mysql_query("ROLLBACK",$db); echo "Falha 17"; exit; }
            mysql_query("COMMIT",$db);



            // cadastrar a opcao de pagamento dos leiloes q venceram
            mysql_query("BEGIN",$db);
            $codigo = "Insert into won_auctions (auction_id,userid,won_date) 
                            Select a.auctionID,buy_user,'$agora' from auction a left join won_auctions w on a.auctionID=w.auction_id 
                            where w.auction_id is null and auc_status=3 and situacao = 0";
            $ressel = mysql_query($codigo,$db);
            if(!$ressel){ mysql_query("ROLLBACK",$db); echo "Falha 18"; exit; }
            mysql_query("COMMIT",$db);
        }   
    }
?>