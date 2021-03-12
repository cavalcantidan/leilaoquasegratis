<?
	include_once("admin.config.inc.php");
	include("connect.php");
	include("security.php");
	
	$PRODUCTSPERPAGE=1;

	if(!$_GET['pageno'])
	{
		$Pageno = 1;
	}
	elseif(isset($_GET['pageno']))
	{
		$Pageno = $_GET['pageno'];
		//$order = $_GET['order'];	
	}
	$StartRow =   $PRODUCTSPERPAGE * ($Pageno-1);
	
	$group_data = array();
		$group_data[] = array(
			'text'  => 'Year',
			'value' => 'year',
		);
	
		$group_data[] = array(
			'text'  => 'Month',
			'value' => 'month',
		);
	
		$group_data[] = array(
			'text'  => 'Week',
			'value' => 'week',
		);
	
		$group_data[] = array(
			'text'  => 'Days',
			'value' => 'dayofweek',
		);
		$groups=$group_data;
		
		// STATUS
		$order_status = array();
		$order_status[] = array(
			'text'  => 'All Status',
			'value' => '0',
		);
		$order_status[] = array(
			'text'  => 'Pending',
			'value' => '1',
		);
		$order_status[] = array(
			'text'  => 'Delivered',
			'value' => '2',
		);
		$order_status[] = array(
			'text'  => 'Cancelled',
			'value' => '3',
		);
		
		
		$order_statuses=$order_status;
		
		
		// DATE
		$date = explode('/', date('d/m/Y', time()));
		$date_from = array(
			'day'   => $date[0],
			'month' => ($date[1] != '01') ? $date[1] - 1 : $date[1],
			'year'  => $date[2]
		);
	
		$date_to = array(
			'day'   => $date[0] + 1,
			'month' => $date[1],
			'year'  => $date[2]
		);
		$date_from_day=$date_from['day'];
		$date_from_month=$date_from['month'];
		$date_from_year=$date_from['year'];
		
		$date_to_day=$date_to['day'];
		$date_to_month=$date_to['month'];
		$date_to_year=$date_to['year'];
	
		
		// MONTH
		$month_data = array();
		$month_data[] = array(
			'value' => '01',
			'text'  => 'January'
		);
	
		$month_data[] = array(
			'value' => '02',
			'text'  => 'February'
		);
	
		$month_data[] = array(
			'value' => '03',
			'text'  => 'March'
		);
	
		$month_data[] = array(
			'value' => '04',
			'text'  => 'April'
		);
	
		$month_data[] = array(
			'value' => '05',
			'text'  => 'May'
		);
	
		$month_data[] = array(
			'value' => '06',
			'text'  => 'June'
		);
	
		$month_data[] = array(
			'value' => '07',
			'text'  => 'July'
		);
	
		$month_data[] = array(
			'value' => '08',
			'text'  => 'August'
		);
	
		$month_data[] = array(
			'value' => '09',
			'text'  => 'September'
		);
	
		$month_data[] = array(
			'value' => '10',
			'text'  => 'October'
		);
	
		$month_data[] = array(
			'value' => '11',
			'text'  => 'November'
		);
	
		$month_data[] = array(
			'value' => '12',
			'text'  => 'December'
		);
		$months=$month_data;
	
	
if($_REQUEST['submit']!="")
{
		// SHOW 
				
		
		$sql = "select min(o.date_purchased) as date_from_als, max(o.date_purchased) as date_to_als, count(o.id) as orders, sum(ot.value) as amount from orders o left join order_total ot on o.id=ot.order_id where ot.sortorder='4' and o.order_status!='0'";
		
		// SQL DATE 
		if($_POST['date_from'] && $_POST['date_to'])
		{
			
			$date_from_day=$_POST['date_from']['day'];
			$date_from_month=$_POST['date_from']['month'];
			$date_from_year=$_POST['date_from']['year'];
			$from = date('Y-m-d',strtotime($date_from_year . '/' . $date_from_month . '/' . $date_from_day));
			
			$date_to_day=$_POST['date_to']['day'];
			$date_to_month=$_POST['date_to']['month'];
			$date_to_year=$_POST['date_to']['year'];
			$to = date('Y-m-d',strtotime($date_to_year . '/' . $date_to_month . '/' . $date_to_day));
	
			$sql .=" and date_purchased between '".$from."' and '".$to."'";
		}
		else
		{
			$date_from_day=$date_from['day'];
			$date_from_month=$date_from['month'];
			$date_from_year=$date_from['year'];
			$from = date('Y-m-d',strtotime($date_from_year . '/' . $date_from_month . '/' . $date_from_day));
			
			$date_to_day=$date_to['day'];
			$date_to_month=$date_to['month'];
			$date_to_year=$date_to['year'];
			$to = date('Y-m-d',strtotime($date_to_year . '/' . $date_to_month . '/' . $date_to_day));
			
			$sql .=" and date_purchased between '".$from."' and '".$to."'";
		}
		
		// SQL STATUS
			$StatusArr = array(
					'0',
					'1',
					'2',
					'3'
			);
			
			if (in_array($_POST['order_status_id'], $StatusArr)) 
			{
				if($_POST['order_status_id']!='0')
				{
					$sql .= "  and order_status='" .$_POST['order_status_id']."' ";
				}
				else
				{
					$order_status_id='0';
				}
			} 
			else 
			{
				$order_status_id='0';
			}
			
			// SQL SHOW
			$groupArr = array(
					'year',
					'month',
					'week',
					'dayofweek'
			);
			
			if (in_array($_POST['group'], $groupArr)) 
			{
				$sql .= " group by " .$_POST['group']. "(date_purchased)";
			} 
			else 
			{
				$sql .= " group by week(date_purchased)";
				$group='week';
			}
			
			
		
		$result=mysql_query($sql) or die (mysql_error());
		$totalrows=mysql_num_rows($result);
		
		$totalpages=ceil($totalrows/$PRODUCTSPERPAGE);
		
		$sql .= " LIMIT $StartRow,$PRODUCTSPERPAGE";
		
		
		$result =mysql_query($sql);
		$total = mysql_num_rows($result);
		
		$rowt=mysql_fetch_object($result);
		$dt_frm=$rowt->date_from_als;
		$dt_to=$rowt->date_to_als;
		$ords=$rowt->orders;
		$amt=$rowt->amt;
		
		if($dt_frm=="" && $dt_to=="" && $ords=='0' && $amt=="")
		{
			$total="";
		}
		
		$result =mysql_query($sql);
}		

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?=$lng_characset;?>" />
<title>Hair Angels</title>
</head>
<link href="main.css" type="text/css" rel="stylesheet">
<body>
<table cellpadding="0" cellspacing="0" border="0" width="92%">
	<tr>
		<td class="H1">Sales Report</td>
	</tr>
	<tr><td>&nbsp;&nbsp;&nbsp;</td></tr>
	<TR>
		<TD background="images/vdots.gif"><IMG height=1 
		  src="images/spacer.gif" width=1 border=0></TD>
	</TR>
	<tr><td>&nbsp;&nbsp;&nbsp;</td></tr>
	<tr>
		<td>
			<form action="salesreport.php" method="post" enctype="multipart/form-data">
      <TABLE cellSpacing="2" cellPadding="2" width="100%">
        <TBODY>
			  <tr>
				
				<td class="copyText">Show:
				  <select name="group" class="solidinput">
					<?php foreach ($groups as $groups) { ?>
					<?php if ($groups['value'] == $group) { ?>
					<option value="<?php echo $groups['value']; ?>" selected><?php echo $groups['text']; ?></option>
					<?php } else { ?>
					<option value="<?php echo $groups['value']; ?>"><?php echo $groups['text']; ?></option>
					<?php } ?>
					<?php } ?>
				  </select></td>
				<td class="copyText">Status:
				  <select name="order_status_id" class="solidinput">
					<?php foreach ($order_statuses as $order_status) { ?>
					<?php if ($order_status['value'] == $order_status_id) { ?>
					<option value="<?php echo $order_status['value']; ?>" selected><?php echo $order_status['text']; ?></option>
					<?php } else { ?>
					<option value="<?php echo $order_status['value']; ?>"><?php echo $order_status['text']; ?></option>
					<?php } ?>
					<?php } ?>
				  </select>
			    </td>
				
				<td class="copyText">Date:
				  <input name="date_from[day]" value="<?php echo $date_from_day; ?>" size="2" maxlength="2"  class="solidinput" />
				  <select name="date_from[month]" class="solidinput">
					<?php foreach (@$months as $month) { ?>
					<?php if ($month['value'] == $date_from_month) { ?>
					<option value="<?php echo $month['value']; ?>" selected><?php echo $month['text']; ?></option>
					<?php } else { ?>
					<option value="<?php echo $month['value']; ?>"><?php echo $month['text']; ?></option>
					<?php } ?>
					<?php } ?>
				  </select>
				  <input name="date_from[year]" value="<?php echo $date_from_year; ?>" size="4" maxlength="4"  class="solidinput" />
				  -
				  <input name="date_to[day]" value="<?php echo $date_to_day; ?>" size="2" maxlength="2"  class="solidinput" />
				  <select name="date_to[month]"  class="solidinput">
					<?php foreach (@$months as $month) { ?>
					<?php if ($month['value'] == $date_to_month) { ?>
					<option value="<?php echo $month['value']; ?>" selected><?php echo $month['text']; ?></option>
					<?php } else { ?>
					<option value="<?php echo $month['value']; ?>"><?php echo $month['text']; ?></option>
					<?php } ?>
					<?php } ?>
				  </select>
				  <input name="date_to[year]" value="<?php echo $date_to_year; ?>" size="4" maxlength="4"  class="solidinput"/>
				</td>
				<td class="copyText"><input type="submit" value="Buscar" name="submit" class="bttn-manage" /></td>
			  </tr>
			 
		  </TBODY>
			  </TABLE>
		  </form>
		</td>
	</tr>
	<tr>	 
		<td>
		<?php 
		if(!$total)
        {
        ?>
		<br><br><br>
		<table width="70%" border="0" cellspacing="1" cellpadding="1" align="center" bgcolor="#000000">
        <tr> 
          <td > 
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr> 
                <td class=th-a > 
                  <div align="center">No Sales To Display</div>
                </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
      <?php
      }
      else
      {
      ?>
	<FORM id="form2" name="form2" action="" method="post">
	<table border="1" width="100%" class="t-a" cellspacing="0">
		<tbody>
		<TR class=th-a> 
          <TD width="71%" align="left" nowrap>Date</TD>
		  <TD width="10%" align="right" nowrap>Orders</TD>
		  <TD width="19%" align="right" nowrap>Amount</TD>
        </TR>
		<?php
		$colorflg=0;
    	for($i=0;$i<$total;$i++){
			$row = mysql_fetch_object($result);
			//$id = $row->id;
			
			$date_form=date("Y-m-d",strtotime($row->date_from_als));
			$date_to=date("Y-m-d",strtotime($row->date_to_als));
			
			//$date_form=date('j F Y',$row->date_from_als);
			//$date_to=date('j F Y',$row->date_to_als);
			
			$date=$date_form." - ".$date_to;
			$orders_count=$row->orders;
			$amount=number_format($row->amount,2); // function
			
							
			
			if ($colorflg==1){
				$colorflg=0;?>
				<TR bgcolor="#f4f4f4"> 
			<? }else{
				$colorflg=1;?>
				<TR> 
			<? } ?>
				<TD  height="37" width="70%">
					<? if($date!=""){ echo $date; }else{echo "&nbsp;";} ?>
				</TD>	
				
				<TD height="37" width="10%" align="right">
					<? if($orders_count!=""){ echo $orders_count; }else{ echo "&nbsp;"; }?>		
				</TD>
			
				<TD  height="37" width="20%" align="right">
					<? if($amount!=""){?>&pound;<?=$amount;?><? }else{ echo "&nbsp;"; }?>
				</TD>
		    </TR>
           <?
		    }
		  ?>
		
	</table>
	</form>
	<?php
		if($Pageno>1)
		{
                  $PrevPageNo = $Pageno-1;

	    ?>
	  <A class=paging href="salesreport.php?pageno=<?php echo $PrevPageNo; ?>">&lt; P&aacute;gina Anterior</A>
	  <?
	   }
	  ?> &nbsp;&nbsp;&nbsp;
	  <?php
        if($Pageno<$totalpages)
        {
         $NextPageNo = 	$Pageno + 1;
      ?>
	  <A class=paging 
      id=next href="salesreport.php?pageno=<?php echo $NextPageNo;?>">Pr&amp;oacute;xima P&amp;aacute;gina &gt;</A>
	  <?
       }
      ?>
	   &nbsp; 
         <!-- <A class=paging id=last 
      href="javascript:__doPostBack('last','')" disabled>Last Page &gt;</A>--> 
       
		<?php

      }

      ?>
	  </td>
	</tr>
</table>
</body>
</html>
