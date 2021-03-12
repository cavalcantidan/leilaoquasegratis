<?
    include("connect.php");
    include_once("admin.config.inc.php");
    include("security.php");
    include("config_setting.php");
    $type1 = "1";
    $type3 = "3";
    include("pagepermission.php");
    $PRODUCTSPERPAGE = 15; 
    $agora=date("Y-m-d G:i:s");

    if(!$_GET['order']){$order = "";}else{$order = $_GET['order'];}
    if($_REQUEST['aucstatus']){ $aucstatus = $_REQUEST['aucstatus'];}
    if(!$_GET['pgno']){$PageNo = 1;}else{ if($_REQUEST["firstpage"]!=""){$PageNo = 1;}else{$PageNo = $_GET['pgno'];} }

    $StartRow =   $PRODUCTSPERPAGE * ($PageNo-1);
/***********************************************/

    if($aucstatus=="1"){
        $query = "select *,p.name as productname, DATEDIFF('$agora',won_date) AS expiry, DATEDIFF('$agora',accept_date) expirywon, w.id as cod from 
                        won_auctions w left join auction a on w.auction_id=a.auctionID left join 
                        products p on a.productID=p.productID left join registration r on r.id=w.userid 
                      where 
                        a.auc_status='3' and 
                        w.accept_denied='' and 
                        p.name like '$order%' 
                      order by w.won_date desc";
    }elseif($aucstatus=="2"){
        $query = "select *,p.name as productname, DATEDIFF('$agora',won_date) AS expiry, DATEDIFF('$agora',accept_date) expirywon, w.id as cod from 
                        won_auctions w left join auction a on w.auction_id=a.auctionID left join 
                        products p on a.productID=p.productID left join registration r on r.id=w.userid 
                      where 
                        a.auc_status='3' and 
                        w.accept_denied='Accepted' and 
                        payment_date='0000-00-00 00:00:00' and 
                        p.name like '$order%' 
                      order by w.accept_date desc";
    }elseif($aucstatus=="3"){
        $query = "select *,p.name as productname, DATEDIFF('$agora',won_date) AS expiry, DATEDIFF('$agora',accept_date) expirywon, w.id as cod from 
                        won_auctions w left join auction a on w.auction_id=a.auctionID left join 
                        products p on a.productID=p.productID left join registration r on r.id=w.userid 
                      where 
                        a.auc_status='3' and 
                        w.accept_denied='Accepted' and 
                        payment_date!='0000-00-00 00:00:00' and 
                        p.name like '$order%' 
                      order by w.payment_date desc";	
    }else{
        $query = "select *,p.name as productname, DATEDIFF('$agora',won_date) AS expiry, DATEDIFF('$agora',accept_date) expirywon, w.id as cod from 
                        won_auctions w left join auction a on w.auction_id=a.auctionID left join 
                        products p on a.productID=p.productID left join registration r on r.id=w.userid 
                      where 
                        a.auc_status='3' and 
                        p.name like '$order%' 
                      order by w.won_date desc";
    }
    if (isset($_GET['aid'])){
		$result=mysql_query("update won_auctions set dataenvio = '".$agora."', situacaodescr='Enviado' where id = ".$_GET['aid']);
    }
    $result=mysql_query($query) or die (mysql_error());
    $totalrows=mysql_num_rows($result);
    $totalpages=ceil($totalrows/$PRODUCTSPERPAGE);
    $query .= " LIMIT $StartRow,$PRODUCTSPERPAGE";
    $result =mysql_query($query);
    $total = mysql_num_rows($result);
    
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=<?=$lng_characset;?>" />
    <title></title>
    <link rel="stylesheet" href="main.css" type="text/css">
    <script type="text/javascript" language="javascript">
        function Submitform(){ document.form3.submit(); }
    </script>
</head>

<body bgcolor="#ffffff" style="padding-left:10px">
<table width="100%" cellPadding="0" cellSpacing="10">
  <TR> <TD class="H1">Administrar Leil&otilde;es Vendidos</TD> </TR>
  <TR> <TD background="images/vdots.gif"><IMG height=1 src="images/spacer.gif" width=1 ></TD> </TR>
  <TR> <TD><!--content-->
    <TABLE cellSpacing="2" cellPadding="2" width="100%" > <tr> <td class="tdTextBold"><B>Visualizar produtos por:</B></td> </tr> </TABLE> <br />
    <FORM id="form1" name="form1" action="soldauction.php" method="post">
      <TABLE cellSpacing="0" cellPadding="1">
        <TBODY>
        <TR>
          <TD><a class="la" href="soldauction.php?aucstatus=<?=$aucstatus;?>">Todos</a></TD>
          <TD class="lg">|</TD>
          <TD><a class="la" href="soldauction.php?order=A&aucstatus=<?=$aucstatus;?>">A</a></TD>
          <TD class="lg">|</TD>
          <TD><a class="la" href="soldauction.php?order=B&aucstatus=<?=$aucstatus;?>">B</a></TD>
          <TD class="lg">|</TD>
          <TD><a class="la" href="soldauction.php?order=C&aucstatus=<?=$aucstatus;?>">C</a></TD>
          <TD class="lg">|</TD>
          <TD><a class="la" href="soldauction.php?order=D&aucstatus=<?=$aucstatus;?>">D</a></TD>
          <TD class="lg">|</TD>
          <TD><a class="la" href="soldauction.php?order=E&aucstatus=<?=$aucstatus;?>">E</a></TD>
          <TD class="lg">|</TD>
          <TD><A class="la" href="soldauction.php?order=F&aucstatus=<?=$aucstatus;?>">F</A></TD>
          <TD class="lg">|</TD>
          <TD><A class="la" href="soldauction.php?order=G&aucstatus=<?=$aucstatus;?>">G</A></TD>
          <TD class="lg">|</TD>
          <TD><A class="la" href="soldauction.php?order=H&aucstatus=<?=$aucstatus;?>">H</A></TD>
          <TD class="lg">|</TD>
          <TD><A class="la" href="soldauction.php?order=I&aucstatus=<?=$aucstatus;?>">I</A></TD>
          <TD class="lg">|</TD>
          <TD><A class="la" href="soldauction.php?order=J&aucstatus=<?=$aucstatus;?>">J</A></TD>
          <TD class="lg">|</TD>
          <TD><A class="la" href="soldauction.php?order=K&aucstatus=<?=$aucstatus;?>">K</A></TD>
          <TD class="lg">|</TD>
          <TD><A class="la" href="soldauction.php?order=L&aucstatus=<?=$aucstatus;?>">L</A></TD>
          <TD class="lg">|</TD>
          <TD><A class="la" href="soldauction.php?order=M&aucstatus=<?=$aucstatus;?>">M</A></TD>
          <TD class="lg">|</TD>
          <TD><A class="la" href="soldauction.php?order=N&aucstatus=<?=$aucstatus;?>">N</A></TD>
          <TD class="lg">|</TD>
          <TD><A class="la" href="soldauction.php?order=O&aucstatus=<?=$aucstatus;?>">O</A></TD>
          <TD class="lg">|</TD>
          <TD><A class="la" href="soldauction.php?order=P&aucstatus=<?=$aucstatus;?>">P</A></TD>
          <TD class="lg">|</TD>
          <TD><A class="la" href="soldauction.php?order=Q&aucstatus=<?=$aucstatus;?>">Q</A></TD>
          <TD class="lg">|</TD>
          <TD><A class="la" href="soldauction.php?order=R&aucstatus=<?=$aucstatus;?>">R</A></TD>
          <TD class="lg">|</TD>
          <TD><A class="la" href="soldauction.php?order=S&aucstatus=<?=$aucstatus;?>">S</A></TD>
          <TD class="lg">|</TD>
          <TD><A class="la" href="soldauction.php?order=T&aucstatus=<?=$aucstatus;?>">T</A></TD>
          <TD class="lg">|</TD>
          <TD><A class="la" href="soldauction.php?order=U&aucstatus=<?=$aucstatus;?>">U</A></TD>
          <TD class="lg">|</TD>
          <TD><A class="la" href="soldauction.php?order=V&aucstatus=<?=$aucstatus;?>">V</A></TD>
          <TD class="lg">|</TD>
          <TD><A class="la" href="soldauction.php?order=W&aucstatus=<?=$aucstatus;?>">W</A></TD>
          <TD class="lg">|</TD>
          <TD><A class="la" href="soldauction.php?order=X&aucstatus=<?=$aucstatus;?>">X</A></TD>
          <TD class="lg">|</TD>
          <TD><A class="la" href="soldauction.php?order=Y&aucstatus=<?=$aucstatus;?>">Y</A></TD>
          <TD class="lg">|</TD>
          <TD><A class="la" href="soldauction.php?order=Z&aucstatus=<?=$aucstatus;?>">Z</A></TD>
          </TR></TBODY></TABLE>
        </form>
        
<table cellpadding="0" cellspacing="0" width="100%" border="0">
      <tr>
        <td>
            <form name="form3" id="form3" action="" method="post">
            <table border="0" cellpadding="0"  cellspacing="0" width="100%">
                <tr>
                    <td><b>Situa&ccedil;&atilde;o :</b>
                      <select name="aucstatus" onchange="Submitform();">
                    <option value=""  <? if($aucstatus==""){ ?>selected="selected"<? } ?>>Todos</option>
                    <option value="1" <? if($aucstatus=="1"){?>selected="selected"<? } ?>>Aceita&ccedil;&atilde;o</option>
                    <option value="2" <? if($aucstatus=="2"){?>selected="selected"<? } ?>>Pagamento</option>
                    <option value="3" <? if($aucstatus=="3"){?>selected="selected"<? } ?>>Conclus&atilde;o</option>
                    </select>
                    <input type="hidden" name="firstpage" value="1" />
                    </td>
                </tr>
            </table>
            </form>
        </td>
      </tr>	
</table>	  		
<?
    if($total<=0){
?>
              <div align="center">N&atildeo existe leil&atilde;o vendido.</div>
<?
    }else{
?>
    
    <table cellpadding="0" cellspacing="0" width="100%" border="0">
      <tr>
        <td>
        <form id="form2" name="form2" action="" method="post">  
          <table width="100%"  cellSpacing="0" class="t-a" border="1">
           <tbody>
            <TR class="th-a"> 
              <td width="6%">No</td>
              <td width="22%">Leil&atilde;o</td>
              <td align="center" width="10%">Pre&ccedil;o</td>
              <td align="center" width="11%">Situa&ccedil;&atilde;o</td>
              <TD align="center" width="19%">Vencimento / Pagamento</TD>
              <td width="11%">Ganhador</td>
            </TR>
            <?
              for($i=0;$i<$total;$i++){
                 if($PageNo>1){$srno = ($PageNo-1)*$PRODUCTSPERPAGE+$i+1;}else{$srno = $i+1;}
              
                $row = mysql_fetch_object($result);
                $id=$row->auctionID;
                $pname=$row->productname;
                $fprice=$row->auc_final_price;
                $status=$row->accept_denied;
                $paymentdate = $row->payment_date;
                $won_date = $row->won_date;
                $accept_date = $row->accept_date;
                $auctype = $row->auc_type;
                    if($auctype=="fpa"){$auctype="Fixed Price Auction";}
                    if($auctype=="pa"){$auctype="1 Centavo";}
                    if($auctype=="nba"){$auctype="NailBiter Auction ";}
                    if($auctype=="off"){$auctype="100% off";}
                    if($auctype=="na"){$auctype="Night Auction";}
                    if($auctype=="oa"){$auctype="Open Auction";}
                    if($auctype=="20sa"){$auctype="20-Second Auction";}
                    if($auctype=="15sa"){$auctype="15-Second Auction";}
                    if($auctype=="10sa"){$auctype="10-Second Auction";}
                $winner = $row->username;
                $cellColor = "";
                $cellColor = ConfigcellColor($i);
                ?>
            <tr class="<?=$cellColor?>">
              <td align="center"><?=$srno;?></td>	
              <td><?=stripslashes($pname)?></td>
              <td align="right"><?=$fprice==""?"&nbsp":$Currency.$fprice;?></td>
              <td align="center">
              <?	
                if($status==""){
                    if($row->expiry>7){
                        echo "<font color=red>Tempo para Aceita&ccedil;&atilde;o Esgotado</font>";
                    }else {
                        echo "<font color=orange>Aguardando Aceita&ccedil;&atilde;o</font>";
                    }
                }elseif($status=="Accepted"){ 
                    if($paymentdate=='0000-00-00 00:00:00' and $row->expirywon>7){ 
                        echo "<font color=DarkRed>Tempo para Pagamento Esgotado</font>";
                    }elseif($paymentdate=='0000-00-00 00:00:00'){
                        echo "<font color=DarkMagenta>Aguadando Pagamento</font>";
                    }elseif($row->dataenvio=='0000-00-00 00:00:00'){
                        echo "<font color=green>Pago e n&atilde;o enviado</font><br />";
                        echo '<input type="button" name="button" value="Marcar como enviado" class="bttn" onclick="javascript: window.location.href=\'soldauction.php?aid='.$row->cod.'\'" />';
                    }else{ 
                        echo "<font color=blue>Concluido e enviado</font>";
                    }
                }
              elseif($status=="Denied"){ 
                    echo "<font color=red>Recusado</font>";
              }
                
              ?>
              </td>
              <TD align="center" width="19%"><?
              if($status==""){
                    echo $won_date=="0000-00-00 00:00:00"?"&nbsp;":'Limite '.$won_date;
                }
                elseif($status=="Accepted"){ 
                    if($row->dataenvio=='0000-00-00 00:00:00'){ 
                        if($paymentdate=='0000-00-00 00:00:00'){
                            echo $accept_date=="0000-00-00 00:00:00"?"&nbsp;":'Aceito em '. $accept_date;
                        }else{ 
                            echo 'Pago em '.$paymentdate;
                        }
                    }else{
                        echo $accept_date=="0000-00-00 00:00:00"?"&nbsp;":'Enviado em '. $row->dataenvio;
                    }
                }
                elseif($status=="Denied"){ 
                    echo "<font color=red>Recusado pelo ganhador</font>";}
                else{
                    echo 'Aguardando at&eacute; '. $accept_date=="0000-00-00 00:00:00"?"&nbsp;":$accept_date;
                }
              ?></TD>
              <td align="center"><?=$winner==""?"&nbsp":"<a href='view_member_statistics.php?uid=".$row->userid."'>".$winner."</a>";?></td>
            </tr>
             <?
             }
             ?>
            </tbody>
        </table>
    </form>
</td>
</tr>
</table>
<?
}
        if($PageNo>1){
            $PrevPageNo = $PageNo-1;
      ?>
      <A class="paging" href="soldauction.php?order=<? echo $iid ?>&pgno=<?php echo $PrevPageNo; ?>&aucstatus=<?=$aucstatus;?>">&lt; P&aacute;gina Anterior</A>
      <? } 
        if($PageNo<$totalpages) { $NextPageNo =	$PageNo + 1;
      ?>
      <A class="paging" href="soldauction.php?order=<? echo $iid ?>&pgno=<?php echo $NextPageNo;?>&aucstatus=<?=$aucstatus;?>">&nbsp;&nbsp;&nbsp;Pr&oacute;xima P&aacute;gina &gt;</A>
      <? } ?>
</TD>
</TR>
</table>
</body>
</html>