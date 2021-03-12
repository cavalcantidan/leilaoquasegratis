<?
	if($_POST["searchtext"]!="" || $_GET["st"]!="")
	{
		if($_GET["st"]!="")
		{
			$searchdata = $_GET["st"];
		}
		else
		{
		$searchdata = $_POST["searchtext"];	
		}
	}
    $body_onload="OnloadPage(); jump_to_anchor('{$_REQUEST[hashtag]}');";
    $head_tag='<link href="css/style_youbid.css" rel="stylesheet" type="text/css" />
<link href="css/menu.css" rel="stylesheet" type="text/css" />

<script language="javascript" type="text/javascript">
function jump_to_anchor(hashtag)
{
	if(hashtag!="")
	{
		location.hash = hashtag;
	}
}
</script>
<script language="javascript" src="js/function.js"></script>
';
			include("header.php");
		?>
		<div id="middle_div">
		<?
			if($_GET["aid"]==2 || $_GET["id"]!="" || $searchdata!="" || $_GET["st"]!="")
			{
				include("allliveauction.php");
			}
		?>
		<div id="cleaner"></div>
		<?

			if($_GET["aid"]==1 || $_GET["id"]!="")
			{
			include("futureauctions.php");
			}
		?>
		<div id="cleaner"></div>
		<?
			if($_GET["aid"]==3 || $_GET["id"]!="")
			{
			include("endedauctions.php");
			}
		?>
		</div>
<label style="display: none" id="zoomimagename"></label>
<script language="javascript" src="js/jquery.js"></script>
<script language="javascript" src="js/effect.js"></script>
<script language="javascript" src="js/default.js"></script>
<script language="javascript" src="js/jqModal.js"></script>	    
<?php include("footer.php");?>