<?php
session_start();
if(isset($_SESSION["logedin"])){
	header("location:innerhome.php");
	exit;
}
include_once("admin.config.inc.php");
include ("config.inc.php");
if(isset($_GET['id']))
	$id=$_GET['id'];
?>
<html>
<head><title>Bem vindo ao <? echo $ADMIN_MAIN_SITE_NAME ;?></title>
<script>
	function Process(){
		document.all.loading.style.visibility = 'visible';
		document.all.mainbody.style.visibility = 'hidden';
	}
</script>
<style>
    #loading {
    	Z-INDEX: 2; LEFT: 38%; VISIBILITY: hidden; POSITION: absolute; TOP: 100px; 	
    }
    #loading1 {
    	VISIBILITY: hidden; POSITION: absolute; 
    }
</style>
</head>
<body bgcolor="#ffffff" leftmargin="0" topmargin="0" marginheight="0" mariginwidth="0">
    <table cellspacing="0" cellpadding="5" width="100%" border="0">
        <tbody>
        <tr>
            <td style="FONT-WEIGHT: bold; FONT-SIZE: 26px; COLOR: #999999;" height="15" bgcolor="#FFFFFF" colspan="2" align="center">
                Bem-vindo a &aacute;rea administrativa do <? echo $ADMIN_MAIN_SITE_NAME;?>
            </td>
        </tr>
        <tr bgcolor="<? echo $ADMIN_HEADER_BG_COLOR1;?>">
        	<td height="15"></td>
        </tr>
        <tr bgcolor="<? echo $ADMIN_HEADER_BG_COLOR3?>">
        	<td height="15"></td>
        </tr>
        </tbody>
    </table>
    <br />
    <form id="_cti0" name="_cti0" action="password.php" method="post">
        <div id="loading">
            <table  border="1" cellpadding="12" cellspacing="0" bgcolor="#B0B0B0" bordercolor="<? echo $ADMIN_HEADER_BG_COLOR1;?>">
              <tr> 
                <td width="314" align="middle" nowrap ><font  size="2" color="#FFFFFF">Um momento Por Favor. <b>Efetuando login..........</b></font></td>
              </tr>
            </table>
        </div>
    <center>
        <div id="mainbody" style="border-color: blue;border-style:double;width:370px;">
            <table border="0" cellspacing="0" cellpadding="5" width="370px" bgcolor="<? echo $ADMIN_TABLE_BG_COLOR;?>" style="color:<?=$ADMIN_TABLE_FONT_COLOR?>">
                <tbody>
                    <?php if($id==1){ ?>
                	<tr>
                		<td width="17"><img src="images/ALERT.gif" width="16" height="16" /></td>
                		<td align="center" width="500">
                            <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#FF0000">
                            <strong>&nbsp;&nbsp;&nbsp;</strong>Login ou Senha Inv&aacute;lida !</font>
                        </td>
                	</tr>
                    <?php } ?>
                    <tr> 
                      <td colspan="2" style="color:<? echo $ADMIN_HEADER_FONT_COLOR;?>; font-weight:bold;"> .: Login </td>
                    </tr>
                    <tr> 
                      <td align="middle" colspan="2">Informe seu login e senha abaixo </td>
                    </tr>
                    <tr> 
                      <td class="bk" align="right" width="30%">Login:</td>
                      <td width="70%"><input class="field" id="username" size="25" name="name" /></td>
                    </tr>
                    <tr> 
                      <td class="bk" align="right" width="30%">Senha:</td>
                      <td><input class="field" id="pass" type="password" size="25" name="pass" /></td>
                    </tr>
                    <tr>
                      <td colspan="2" align="center">
                        <input type="submit" name="_ctl1" value="Logar" class="bttn"
                         style="border: 2px solid #006; height: 30px; background: <? echo $ADMIN_TABLE_BG_COLOR;?>;color:<? echo $ADMIN_HEADER_FONT_COLOR;?>;font-weight:bold;"
                         onclick="Process(); if (typeof(Page_ClientValidate) == 'function') Page_ClientValidate(); " /> 
                        <input type="hidden" name="ed_type" value="" /> 
                        <input type="hidden" name="redirect" value="<? echo $redirect;?>" /></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </center>
    </form>
</body>
</html>