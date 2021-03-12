<?php 
	// FETCH LIST MANUFACTURER ARRAY //
	
    $manufacturers_query = mysql_query("select manufacturers_id, manufacturers_name from manufacturers order by manufacturers_name") or die (mysql_error());

	while ($manufacturers = mysql_fetch_array($manufacturers_query)) 
	{
		//echo $manufacturers['manufacturers_id'];
    	$manufacturers_array[] = array($manufacturers['manufacturers_id'],
                                     $manufacturers['manufacturers_name']);
	}
	//*********************************//
	
/*for ($i=0; $i<sizeof($manufacturers_array); $i++)
{
	for($j=0;$j<count($manufacturers_array[$i]);$j++)
	{
		echo $manufacturers_array[$i][$j];
		echo "<br>";
	}
}
exit;

foreach ($manufacturers_array as $k => $v) 
{
	foreach($v as $i => $m)
	{
	    print "\$v[$i] => $m.\n";
	}
}
exit;
print_r($manufacturers_array);*/


// FILL COMBO OPTION VALUE //
function FILL_MANUFACTURE_NAME_COMBO($manufacturers_array,$tmp)
{
	for ($i=0; $i<sizeof($manufacturers_array); $i++)
	{
		$count=count($manufacturers_array[$i])-1;
		for($j=0;$j<$count;$j++)
		{
			
			?>
			<option value="<?=$manufacturers_array[$i][$j]?>" <?php if ($tmp == $manufacturers_array[$i][$j]) echo " selected" ?>>
			<?
				echo $manufacturers_array[$i][$j+1];
			?>
			</option>
			<?
		}
	}
}
// ***************************//


// IMAGE UPLOAD //
function SetRightsToUploadedFile1( $file_name )
{
	@chmod( $file_name, 0666);
}
// *********** //
?>