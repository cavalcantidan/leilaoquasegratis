<?
	include("config/connect.php");
	include("functions.php");
    $head_tag = '<link href="css/menu.css" rel="stylesheet" type="text/css" />
    <link href="css/style_youbid.css" rel="stylesheet" type="text/css" />'; 

    $body_onload = "ShowMainTitle('1');ShowAnsTitle('1')";
	function getsubque()
	{
		$qr1 = "select * from faq order by id";
		$resqr1 = mysql_query($qr1);
		$total1 = mysql_num_rows($resqr1);
		return $total1;
	}
	function getmainheader()
	{
		$qrys = "select * from helptopic order by topic_id";
		$ress = mysql_query($qrys);
		$total = mysql_num_rows($ress);
		return $total;
	}
?>

<script language="javascript" type="text/javascript" src="js/function.js"></script>
<script language="javascript">
function ShowMainTitle(div_id)
{
	var obj1 = document.getElementById('GetGlobalID');
	//var obj = document.getElementById('');
	if(obj1.innerHTML=="")
	{
		obj1.innerHTML=div_id;
		var obj = document.getElementById('subtitle_'+div_id);
		if(navigator.appName!="Microsoft Internet Explorer")
		{
			obj.style.display = 'table-row';
		}
		else
		{
			obj.style.display = 'block';
		}
	}
	else
	{
		var obj2 = document.getElementById('subtitle_'+obj1.innerHTML);
		obj2.style.display = 'none';
		obj1.innerHTML=div_id;
		var obj3 = document.getElementById('subtitle_'+div_id);
		if(navigator.appName!="Microsoft Internet Explorer")
		{
			obj3.style.display = 'table-row';
		}
		else
		{
			obj3.style.display = 'block';
		}
	}
}
function ShowAnsTitle(ans_id)
{
	var obj4 = document.getElementById('GetGlobalAnsID');
	//var obj = document.getElementById('');
	if(obj4.innerHTML=="")
	{
		obj4.innerHTML=ans_id;
		var obj5 = document.getElementById('answer_'+ans_id);
		if(navigator.appName!="Microsoft Internet Explorer")
		{
			obj5.style.display = 'table-row';
		}
		else
		{
			obj5.style.display = 'block';
		}
	}
	else
	{
		var obj6 = document.getElementById('answer_'+obj4.innerHTML);
		obj6.style.display = 'none';
		obj4.innerHTML=ans_id;
		var obj7 = document.getElementById('answer_'+ans_id);
		if(navigator.appName!="Microsoft Internet Explorer")
		{
			obj7.style.display = 'table-row';
		}
		else
		{
			obj7.style.display = 'block';
		}
	}
}
</script>

<?
	include("header.php");
?>
<div id="help-menu-conteudo">

			<?
				$qrys = "select *,".$lng_prefix."topic_title as topic_title from helptopic order by topic_id";
				$ress = mysql_query($qrys);
				$totals = mysql_num_rows($ress);
				$counter = 1;
				$countersub = 1;
				while($rows = mysql_fetch_array($ress)){
			?>
        <h3 style="margin-bottom:-7px;"><?=stripslashes($rows["topic_title"]);?></h3>
				<span id="subtitle_<?=$counter;?>" align="left">					
        <dl class="help-menu-dl">
					
			<?
				$qr = "select *,".$lng_prefix."que_title as que_title from faq where parent_topic='".$rows["topic_id"]."' order by id";
				$resqr = mysql_query($qr);
				$totalqr = mysql_num_rows($resqr);

				while($rowsqr = mysql_fetch_array($resqr)){
			?>
				 <dd id='subque_<?=$countersub?>'><a href="javascript: ShowAnsTitle('<?=$countersub;?>')" <? if($countersub=="1"){?>class="first"<? } if($totalqr==$countersub) { ?><? } ?>><?=stripslashes($rowsqr["que_title"]);?></a>
			<?
					$countersub++;
				}
			?>
			</span>	
			</dl>
            <span class="help-menu-bottom"></span>

			<?
					$counter++;
				}
			?>
	
        <h3><?=$lng_quicklinks;?></h3>
		<ul id="links-rapidos">
			<li><a href="editpassword.html"><?=$lng_changepassword;?></a></li>
			<li><a href="forgotpassword.html"><?=$lng_lostpassword;?></a></li>
			<li><a href="newsletter.html"><?=$lng_subunsubnewslet;?></a></li>
			<li><a href="forgotpassword.html"><?=$lng_lostuserdata;?></a></li>
			<li><a href="addresses.html"><?=$lng_changeaddress;?></a></li>
			<li><a href="wonauctions.html"><?=$lng_confirmwon;?></a></li>
			<li><a href="contato.html"><?=$lng_reportabuse;?></a></li>
		</ul>
        <span class="help-menu-bottom"></span> 
</div>			

<div id="conteudo-help">
    <div id="ajuda-topo">
        <h3 class="historico-tit" style="display:none;"><?=$lng_tabhelp;?></h3>
    </div>

    <div class="container" >
        <div style="width: 540px;">
    			
		<?
			$qr2 = "select *,".$lng_prefix."que_content as que_content,".$lng_prefix."que_title as que_title from faq order by parent_topic,id";
			$resqr2 = mysql_query($qr2);
			$totalqr = mysql_num_rows($resqr2);
			$counterans = 1;
			while($v=mysql_fetch_array($resqr2)){
				if($counterans==1){
		?>
    			<span id="answer_<?=$counterans;?>">
    				<h3 class="help-pergunta"><span><?=stripslashes($v["que_title"]);?></span></h3>
    				<span><?=stripslashes($v["que_content"]);?></span>
    			</span>
		<?	
				}else{
		?>
				<span id="answer_<?=$counterans;?>" style="display:none">
					<h3 class="help-pergunta"><span><?=$v["que_title"];?></span></h3>
					<span><?=stripslashes($v["que_content"]);?></span>
				</span>
		<?		
				}
				$counterans++;
			}
		?>
        </div>
    </div>

</div>			
<label id="GetGlobalID" style="display: none;"></label>
<label id="GetGlobalAnsID" style="display: none;"></label>

<?
	include("footer.php");
?>