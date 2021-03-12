<?
	include("connect.php");
	if($_GET["crid"]!="")
	{
		$content = '<select name="product" style="100pt;" onchange="setprice(this.value);">							
		<option value="none">selecione</option>';
		$crid = $_GET["crid"];
		$qryp = "select * from products where enabled='1' and categoryID='".$crid."'";
		$resp = mysql_query($qryp);
		$totalp = mysql_affected_rows();
		if($totalp>0)
		{
			while($objp = mysql_fetch_array($resp))
			{
				if($product==$objp["productID"])
				{
					$content .= '<option selected value="'.$objp["productID"].'">'.stripslashes($objp["name"]).'</option>';
				}
				else
				{
					$content .= '<option value="'.$objp["productID"].'">'.stripslashes($objp["name"]).'</option>';
				}	
			}
		}
		else
		{
			$content .= '<option value="">Por favor selecione</option>';
		}	
		$content .= '</select>';
		echo $content;
	}
?>