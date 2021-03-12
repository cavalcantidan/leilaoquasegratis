<?
	include("admin.config.inc.php");
 	include("connect.php");
	include("security.php");
	if(isset($_GET['id']))
	{
		
		$taxid = $_GET['id'];
		
		$query = "Select * from taxclass where id = '$taxid'";
		$result = mysql_query($query) or die(mysql_error());
		$row = mysql_fetch_object($result);
		$title = stripslashes($row->title);
		$description = stripslashes($row->description);
		$taxvalue = $row->taxvalue;
		
	}
	elseif(isset($_POST['submit']) and trim($_POST['submit']) == "Add")
	{
		
		$title = addslashes($_POST["state"]);
		
		$description = addslashes($_POST["description"]);
		$taxvalue = $_POST["taxvalue"];
		if(trim($title)=="" || trim($taxvalue)==""){
			$Error = 1;
		}else{
			$query ="Insert into taxclass(title,description,taxvalue) values('$title','$description','$taxvalue')";
			mysql_query($query) or die(mysql_error());
			header("location:message.php?msg=56");
			exit;
		}
	}
	elseif(isset($_POST['submit']) and trim($_POST['submit']) == "Edit")
	{
		$id = $_POST["taxid"];
		$title = addslashes($_POST["state"]);
		$description = addslashes($_POST["description"]);
		$taxvalue = $_POST["taxvalue"];
		if(trim($title)=="" || trim($taxvalue)==""){
			$Error = 1;
		}else{
			$query = "Update taxclass set title='$title',description='$description',taxvalue='$taxvalue' where id='$id'";
			mysql_query($query) or die(mysql_error());
			header("location:message.php?msg=57");
			exit;
		}
	}
	elseif(isset($_GET["delid"])){
		$delid = $_GET["delid"];
		$query = "Delete from taxclass where id='$delid'";
		mysql_query($query) or die(mysql_error());
		header("location:message.php?msg=58");
		exit;
	}
?>

<html>
<head>
<title><? if(isset($faq_id)) {?>Edit Tax<? }else { ?>Add Tax<? }?></title>
<meta http-equiv="Content-Type" content="text/html; charset=<?=$lng_characset;?>">
<link rel="stylesheet" href="main.css" type="text/css">
</head>
<script language="javascript">
	function formsubmit(f1)
	{
		if(f1.state.value=="")
		{
			alert("Please enter State.");
			f1.state.focus();
			return false;
		}
		if(f1.taxvalue.value=="")
		{
			alert("Please enter tax value");
			f1.taxvalue.select();
			return false;
		}
		if(!Number(f1.taxvalue.value)){
			alert("please enter valid tax value");
			f1.taxvalue.select();
			return false;
		}
		return true;
	}
</script>
<link rel=stylesheet type="text/css" href="rte.css">

<body>
	
		<form name="f1" action="addtax.php" method="post" enctype="multipart/form-data" onSubmit="return formsubmit(this)">
		
		<TABLE cellSpacing=10 cellPadding=0  border=0 width="697">
		<TR>
			<TD width="677" class=H1><? if (!isset($taxid)) {?>
			  Nova Taxa
		    <? }else { ?>
		    Editar Taxa		    <? }?></TD>
		</TR>
		<TR>
			<TD background="images/vdots.gif"><IMG height=1 src="images/spacer.gif" width=1 border=0></TD>
		</TR>
		<tr>
			<td>
				<?php
	      if($Error)
          {
            if($Error==1)
            {
              $msg = "Form Is Not Completely Filled Up!!!";
            }


        ?>
		<table width="80%" bordercolor="#000000" bgcolor="#ffffff" cellspacing="0" cellpadding="0" align="center" border="1">
          <tr>
          <td>
		  <table border="0" cellpadding="0" cellspacing="0" align="center">
		  <tr>
          <td>
            <div align="center"><font face="Verdana" size="2" color="#990000">
              <?php echo $msg; ?>
              </font></div>
          </td>
        </tr>
		
			  </table>
          </td>
        </tr>
      </table>
	 <?php }?>
			</td>
		</tr>
		  
		  <TR>
		  	<TD>
			
			<TABLE cellSpacing=2 cellPadding=2 width="697" border=0>
          <TBODY>
            <TR align="right"> 
              <TD colSpan=3 class="a">* Campos Obrigatorios</TD>
            </TR>
            <TR> 
              <TD class=th-d colSpan=3>Informa&ccedil;&otilde;es Basicas</TD>
            </TR>
			
			<TR> 
              <TD width="148" align=right></TD>
              <TD width="539"> </TD>
            </TR>
			
            <TR valign="middle"> 
              <TD class=f-c align=right valign="middle" width="148"><font class=a>*</font>Estado:</TD>
              <TD>
			  	<input type="text" name="state"  class="solidinput" value="<?=$title?>">
			  	<?php /*?><? 
					$Squery = "Select * from pdcastate";
					$Sresult = mysql_query($Squery) or die(mysql_error());
					
					$Stotalrows = mysql_num_rows($Sresult);
				?>
			  	<select name="state" class="solidinput">
					<?
						for($i=0;$i<$Stotalrows;$i++){
						$Srow = mysql_fetch_object($Sresult);
					?>
						<option value="<?=$Srow->id?>"><?=$Srow->stname;?></option>
					<?
						}
					?>
			  	</select><?php */?>
			</td>
            </TR>
			<TR valign="middle"> 
              <TD class=f-c align=right valign="middle" width="148">Descri&ccedil;&atilde;o:</TD>
              <TD><textarea name="description" class="solidinput" rows="3" cols="55"><?=stripslashes($description);?></textarea></td>
            </TR>
			<TR valign="middle"> 
              <TD class=f-c align=right valign="middle" width="148"><font class=a>*</font>Valor da Taixa:</TD>
              <TD><input type="text" name="taxvalue" class="solidinput" maxlength="5" value="<?=stripslashes($taxvalue);?>">&nbsp;<font class="a">%</font></td>
            </TR>
			</TBODY>
			</TABLE>
			
				</TD>
				</TR>
			</TABLE>
			<br><br>
			  	
			<table border="0" width="50%" align="left">   
           
            <TR align="center"> 
              <TD> 
			  	<INPUT type="submit" value="       <? if (!isset($taxid)) {?>Adicionar<? }else { ?>Editar<? }?>       " class="bttn" name="submit"
				> 	
				<? if(isset($taxid)) { ?>
				<input type="hidden" value="<? echo $taxid; ?>" name="taxid">
				<? } ?>
			  </TD>
            </TR>
            
          
        </TABLE>
		</form>
</body>
</html>
