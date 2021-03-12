<?
include("connect.php");
include("admin.config.inc.php");
include("security.php");

$parentid = $_GET['parentid'];
$sql = "select * from categories where parents!='0' and parents='".$parentid."' and status='1' order by name";
$result = mysql_query($sql) or die(mysql_error());
$total = mysql_num_rows($result);
if($total>0)
{
	$content = "";
	$content .= '<select name="parents" class="solidinput">
				<option value="" selected="selected">Select one.</option>';
	while($row=mysql_fetch_array($result))
	{
		$content .= '<option value="'.$row['categoryID'].'">'.$row['name'].'</option>';
	}
	$content .="</select>";	
	
	echo $content;
}
else
{
	$content = "";
	$content .= '<select name="parents" class="solidinput"><option value="" selected="selected" style="">Select one.</option>';
	$content .="</select>";	
	
	echo $content;
}

?>