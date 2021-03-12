<?
	include("connect.php");
	include_once("admin.config.inc.php");
	include("security.php");
	include("config_setting.php");

	$PRODUCTSPERPAGE = 10;
	if(!$_GET['pgno'])
	{
		$PageNo = 1;
	}
	else
	{
		$PageNo = $_GET['pgno'];
	}
/********************************************************************
     Get how many products  are to be displayed according to the  Events
********************************************************************/
	$StartRow =   $PRODUCTSPERPAGE * ($PageNo-1);
/***********************************************/
			$query = "select * from newslatter_email order by id";
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
</head>

<body bgcolor="#ffffff" style="padding-left:10px">
<table width="100%" cellPadding="0" cellSpacing="10">
  <TR> 
    <TD class="H1">Administrar NewsLetter</TD>
  </TR>
  <TR>
    <TD background="images/vdots.gif"><IMG height=1 src="images/spacer.gif" width=1 ></TD>  </TR>
  <TR>
    <TD><!--content-->
	    <TABLE cellSpacing="2" cellPadding="2" width="100%" >
    	 <TBODY>
           <TR>
             <TD colspan="2"> 
           <!--options-->
             <IMG height=11 src="images/001.gif" width=8 ><A class=la href="newsletter.php"> Adicionar Newsletter. </A> 
           <!--/options-->
        	 </TD>
          </TR>
	    </TBODY>
	   </TABLE>
	 </TD>
  </TR>
<Tr>
<td>
<?
	if($total<=0)
	{
?>
	<table width="70%" border="0" cellspacing="1" cellpadding="1" align="center" bgcolor="#000000">
      <tr> 
        <td> 
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
           <tr> 
             <td class=th-a> 
              <div align="center">Sem Informa&ccedil;&otilde;es Para Exibir</div>
             </td>
           </tr>
         </table>
        </td>
      </tr>
    </table>
<?
	}
	else
	{
?>
	<table cellpadding="0" cellspacing="0" width="100%" border="0">
	  <tr>
		<td>
		<form id="form2" name="form2" action="" method="post">  
          <table width="100%"  cellSpacing="0" class="t-a" border="1">
           <tbody>
		    <TR class="th-a"> 
			  <td width="2%">No</td>
			  <td width="10%">Data</td>
			  <td width="20%">Assunto</td>
<?php /*?>			  <td width="35%">Content</td>
<?php */?>			  <td width="15%" align="center">A&ccedil;&atilde;o</td>
			</TR>
<?
			  for($i=0;$i<$total;$i++)
			  {
				 if($PageNo>1)
				 {
					$srno = ($PageNo-1)*$PRODUCTSPERPAGE+$i+1;
				 }
				 else
				 {
					$srno = $i+1;
				 }
			  
				$row = mysql_fetch_object($result);
				$id=$row->id;
				$subject=$row->subject;
				$newsdate=$row->date;
				$newscontent=$row->content;

				$cellColor = "";
				$cellColor = ConfigcellColor($i);
				?>
		  	<tr class="<?=$cellColor?>">
			  <td align="center">
				<?=$srno;?></td>	
			  <td><?=substr($newsdate,8,2)."-".substr($newsdate,5,2)."-".substr($newsdate,0,4)?></td>
			  <td><?=stripslashes($subject)?></td>
<?php /*?>			  <td><?=stripslashes(substr($newscontent,0,150));?></td>
<?php */?>			  <td align="center">
			<input name="button" type="button" class="bttn-s" value="Reenviar" onClick="window.location.href='newsletter.php?newsletter_resend=<?=$id;?>'">
			<input name="button" type="button" class="bttn-s" value="Excluir" onClick="window.location.href='newsletter.php?newsletter_delete=<?=$id;?>'">
			</td>
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
?>
	  <?php
		if($PageNo>1)
		{
                  $PrevPageNo = $PageNo-1;

	    ?>
	  <A class="paging" href="managenewslatters.php?pgno=<?php echo $PrevPageNo; ?>">&lt; P&aacute;gina Anterior</A>
	  <?
	   }
	  ?> &nbsp;&nbsp;&nbsp;
	  <?php
        if($PageNo<$totalpages)
        {
         $NextPageNo = 	$PageNo + 1;
      ?>
	  <A class="paging" href="managenewslatters.php?pgno=<?php echo $NextPageNo;?>">Pr&oacute;xima P&aacute;gina &gt;</A>
	  <?
       }
      ?>
</table>
</body>
</html>
