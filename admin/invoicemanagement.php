<?
    include_once("admin.config.inc.php");
    include("connect.php");
    include("functions.php");
    include("security.php");
    $type1 = "1";
    $type2 = "2";
    include("pagepermission.php");

    if(!$_GET['pgno'])
    {
        $PageNo = 1;
    }
    else
    {
        $PageNo = $_GET['pgno'];
    }
    
    if($_REQUEST['order'])
    {
    $order=$_REQUEST['order'];
    }
    
    if($order)
    {
        $qrysel = "select * from won_auctions w left join auction a on w.auction_id=a.auctionID left join registration r on w.userid=r.id left join products p on a.productID=p.productID  left join shipping s on a.shipping_id=s.id where payment_date!='0000-00-00 00:00:00' and p.name like '".$order."%'";
    }
    else
    {
    $qrysel = "select * from won_auctions w left join auction a on w.auction_id=a.auctionID left join registration r on w.userid=r.id left join products p on a.productID=p.productID  left join shipping s on a.shipping_id=s.id where payment_date!='0000-00-00 00:00:00'";
    }
    $result = mysql_query($qrysel);
    $total=mysql_num_rows($result);
    $totalpage=ceil($total/$PRODUCTSPERPAGE);

    if($totalpage>=1)
    {
        $startrow=$PRODUCTSPERPAGE*($PageNo-1);
        $qrysel .= " LIMIT $startrow,$PRODUCTSPERPAGE";
        $result=mysql_query($qrysel);
        $total=mysql_num_rows($result);
    }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?=$lng_characset;?>" />
<META content="MSHTML 6.00.2600.0" name=GENERATOR>
<link rel="stylesheet" href="main.css" type="text/css">
<title><? echo $ADMIN_MAIN_SITE_NAME." - Auctionwise Report"; ?></title>
</head>
<body>
<TABLE width="100%"  border=0 cellPadding=0 cellSpacing=10>
  <!--DWLayoutTable-->
    <TR> 
      <TD width="100%" class="H1">Administrar Faturas</TD></TR><TR><TD background="images/vdots.gif"><!--DWLayoutEmptyCell-->&nbsp;</TD>
    </TR>
    <tr>
        <td height="10"></td>
    </tr>
    <tr>
        <td height="5"></td>
    </tr>
<Tr>
<td>

<FORM id="form1" name="form1" action="manage_members.php" method="post">
      <TABLE cellSpacing=0 cellPadding=1 border=0 >
        <TBODY>
        <TR>
          <TD><a class=la href="invoicemanagement.php">Todos</a></TD>
          <TD class=lg>|</TD>
                
          <TD><a class=la href="invoicemanagement.php?order=A">A</a></TD>
          <TD class=lg>|</TD>
          <TD><a class=la href="invoicemanagement.php?order=B">B</a></TD>
          <TD class=lg>|</TD>
          <TD><a class=la href="invoicemanagement.php?order=C">C</a></TD>
          <TD class=lg>|</TD>
          <TD><a class=la href="invoicemanagement.php?order=D">D</a></TD>
          <TD class=lg>|</TD>
          <TD><a class=la href="invoicemanagement.php?order=E">E</a></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="invoicemanagement.php?order=F">F</A></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="invoicemanagement.php?order=G">G</A></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="invoicemanagement.php?order=H">H</A></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="invoicemanagement.php?order=I">I</A></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="invoicemanagement.php?order=J">J</A></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="invoicemanagement.php?order=K">K</A></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="invoicemanagement.php?order=L">L</A></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="invoicemanagement.php?order=M">M</A></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="invoicemanagement.php?order=N">N</A></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="invoicemanagement.php?order=O">O</A></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="invoicemanagement.php?order=P">P</A></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="invoicemanagement.php?order=Q">Q</A></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="invoicemanagement.php?order=R">R</A></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="invoicemanagement.php?order=S">S</A></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="invoicemanagement.php?order=T">T</A></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="invoicemanagement.php?order=U">U</A></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="invoicemanagement.php?order=V">V</A></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="invoicemanagement.php?order=W">W</A></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="invoicemanagement.php?order=X">X</A></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="invoicemanagement.php?order=Y">Y</A></TD>
          <TD class=lg>|</TD>
          <TD><A class=la href="invoicemanagement.php?order=Z">Z</A></TD></TR></TBODY></TABLE>
            </form>
        </td>
    </Tr>
    <tr>
        <td>
             <? if(!$total){?>
        <table width="95%" border="0" cellspacing="1" cellpadding="1" align="center" bgcolor="#000000">
        <tr> 
          <td > 
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr> 
                <td class=th-a > 
                  <div align="center">Sem Informa&ccedil;&otilde;es Para Exibir</div>
                </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
      <?php }else{?>
        <TABLE width="95%" border="1" cellSpacing="0" class="t-a" align="center">
              <TR class="th-a"> 
                <TD width="5%" nowrap="nowrap">No</TD>
                <TD width="20%" nowrap="nowrap">Leil&atilde;o</TD>
                <td width="15%" nowrap="nowrap">Ganhador</td>
                <TD width="10%" nowrap="nowrap">Data do Pagamento</TD>
                <TD width="30%" nowrap="nowrap">Pre&ccedil;o Atual</TD>
                <td width="15%" nowrap="nowrap">Valor Arrecadado</td>
                <td width="15%" nowrap="nowrap">Entrega</td>
                <TD width="10%" nowrap="nowrap">Total</TD>
                <TD width="10%" nowrap="nowrap">Detalhes</TD>
              </TR>
            <?
                while($obj = mysql_fetch_array($result))
                {
                    if ($colorflg==1){
                        $colorflg=0;
                        $colorid = "#F2F6FD";
                        echo "<TR bgcolor=\"#F2F6FD\"> ";
                    }else{
                        $colorflg=1;
                        $colorid = "#FFFFFF";
                        echo "<TR> ";
                         }
                    if($obj["fixedpriceauction"]==1) { $fprice = $obj["auc_fixed_price"]; }
                    elseif($obj["offauction"]==1) { $fprice = "0.00"; }
                    else { $fprice = $obj["auc_final_price"]; }
            ?>
                <TD width="5%" nowrap="nowrap" align="center"><?=$obj["auctionID"];?></TD>
                <TD width="20%" nowrap="nowrap" align="center"><?=$obj["name"];?></TD>
                <td width="15%" nowrap="nowrap" align="center"><?=$obj["username"];?></td>
                <TD width="10%" nowrap="nowrap" align="center"><?=arrangedate(substr($obj["payment_date"],0,10));?></TD>
                <TD width="30%" nowrap="nowrap" align="right"><?=$Currency.$obj["price"];?></TD>
                <td width="15%" nowrap="nowrap" align="right"><?=$Currency.$fprice;?></td>
                <td width="15%" nowrap="nowrap" align="right"><?=$Currency.$obj["shippingcharge"];?></td>
                <TD width="10%" nowrap="nowrap" align="right"><?=$Currency.number_format($fprice + $obj["shippingcharge"],2) ?></TD>
                <TD width="10%" nowrap="nowrap"><input type="button" name="button" value="Detalhes" class="bttn" onclick="javascript: window.location.href='details.php?aid=<?=$obj["auctionID"];?>'" /></TD>
              </TR>
            <? } ?>
          </TABLE>
         </td>
        </tr>
            <!-- Paging start -->
           <?php
            if($PageNo>1)
            {
                      $PrevPageNo = $PageNo-1;
    
            ?>
          <A class=paging href="invoicemanagement.php?pgno=<?=$PrevPageNo;?>">&lt; P&aacute;gina Anterior</A>
          <?
           }
          ?> &nbsp;&nbsp;&nbsp;
          <?php
            if($PageNo<$totalpage)
            {
             $NextPageNo = 	$PageNo + 1;
          ?>
          <A class=paging 
          id=next href="invoicemanagement.php?pgno=<?=$NextPageNo;?>">Pr&amp;oacute;xima P&amp;aacute;gina &gt;</A>
          <?
           }
          ?>
              <!-- paging ends -->
    <? } ?>
</body>
</html>
