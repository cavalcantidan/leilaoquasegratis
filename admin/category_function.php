<?php
//frequently used category tree functions
function processCategories($level, $path, $sel)
{
	//returns an array of categories, that will be presented by the category_navigation.tpl.html template

	//$categories[] - categories array
	//$level - current level: 0 for main categories, 1 for it's subcategories, etc.
	//$path - path from root to the selected category (calculated by calculatePath())
	//$sel -- categoryID of a selected category

	//returns an array of (categoryID, name, level)

	//category tree is being rolled out "by the path", not fully

	$out = array();
	$cnt = 0;

	$q = mysql_query("select categoryID, name from categories where parents=$path[$level] order by name") or die (mysql_error());
	while ($row = mysql_fetch_array($q))
	{
		$out[$cnt][0] = $row[0];
		$out[$cnt][1] = $row[1];
		$out[$cnt][2] = $level;
		$cnt++;

		//process subcategories?
		if ($level+1<count($path) && $row[0] == $path[$level+1])
		{
			$sub_out = processCategories($level+1,$path,$sel);
			//add $sub_out to the end of $out
			for ($j=0; $j<count($sub_out); $j++)
			{
				$out[] = $sub_out[$j];
				$cnt++;
			}
		}

	}

	return $out;

} //processCategories

function fillTheCList($parents,$level,$b) //completely expand category tree
{
	if($b==true)
	{
		$q = "SELECT categoryID, name, products_count, products_count_admin, parents FROM categories WHERE categoryID<>0 and parents=$parents ORDER BY name" or die (mysql_error());
	}
	else
	{
		if($parents<>0)
		{
			$q = "SELECT categoryID, name, products_count, products_count_admin, parents FROM categories WHERE categoryID<>0 and parents=$parents ORDER BY name" or die (mysql_error());
		}
		else
		{
			$q = "SELECT categoryID, name, products_count, products_count_admin, parents FROM categories WHERE categoryID<>0 and parents<>'0' ORDER BY name" or die (mysql_error());		
		}
	
	}
	
	$rr=mysql_query($q) or die(mysql_error());
	
	$a = array(); //parents
	while ($row = mysql_fetch_array($rr))
	{
		$row[5] = $level;
		$a[] = $row;
		//process subcategories
		$b = fillTheCList($row[0],$level+1);
		//add $b[] to the end of $a[]
		for ($j=0; $j<count($b); $j++)
		{
			$a[] = $b[$j];
		}
	}
	return $a;

} //fillTheCList

function update_products_Count_Value_For_Categories($parents)
{
	//updates products_count and products_count_admin values for each category
	//echo $parents;
	//exit;
	
	$q = mysql_query("SELECT categoryID FROM categories WHERE parents=$parents AND categoryID<>0") or die (mysql_error());
	$cnt = array();
	$cnt[0] = 0;
	$cnt[1] = 0;

	while ($row = mysql_fetch_array($q))
	{

		//process subcategories

		//products_count of current category ($count[0]) surpluses it's subcategories' productsCounts
		$t = update_products_Count_Value_For_Categories($row[0]);
		$cnt[0] += $t[0];
		$cnt[1]  = $t[1];

	}
	//echo "SELECT count(*) FROM ".PRODUCTS_TABLE." WHERE categoryID=$parents";
	//exit;

	$p = mysql_query("SELECT count(*) FROM products WHERE categoryID=$parents") or die (mysql_error());
	$t = mysql_fetch_array($p); $t = $t[0];
	$p = mysql_query("SELECT count(*) FROM products WHERE categoryID=$parents AND enabled=1") or die (mysql_error());
	$c = mysql_fetch_array($p); $c = $c[0];
	$cnt[0] += $c;
	$cnt[1]  = $t;
	
	//$r="UPDATE ".CATEGORIES_TABLE." SET products_count=$cnt[0], products_count_admin=$cnt[1] WHERE categoryID=".$parents;
	//echo $r;
	//exit;
	
	//save calculations
	if ($parents)
	$up = mysql_query("UPDATE categories SET products_count=$cnt[0], products_count_admin=$cnt[1] WHERE categoryID=".$parents) or die (mysql_error());
	//echo $up;
	//exit;
	return $cnt;

} //update_products_Count_Value_For_Categories

function SetRightsToUploadedFile( $file_name )
{
	@chmod( $file_name, 0666);
}


function deleteSubCategories($parents) //deletes all subcategories of category with categoryID=$parents
	{

		//subcategories
		$q = mysql_query("SELECT categoryID FROM categories WHERE parents='".$parents."' and categoryID<>0") or die (mysql_error());
		while ($row = mysql_fetch_array($q))
		{
			deleteSubCategories($row[0]); //recurrent call
		}
		$q = mysql_query("DELETE FROM categories WHERE parents='".$parents."' and categoryID<>0") or die (mysql_error());

		//move all product of this category to the root category
		$q = mysql_query("UPDATE products SET categoryID=0 WHERE categoryID='".$parents."'") or die (mysql_error());
	}

function category_Moves_To_Its_SubDirectories($cid, $new_parents)
{
		//return true/false

		$a = false;
		$q = mysql_query("SELECT categoryID FROM categories WHERE parents='".$cid."' and categoryID<>0") or die (mysql_error());
		while ($row = mysql_fetch_array($q))
		{
			if ($row[0] == $new_parents) $a = true;
			else
			  $a = category_Moves_To_Its_SubDirectories($row[0],$new_parents);
		}
		return $a;
}

// THIS FUNCTION RETURN SUB CATEGORIES ARRAY // 
function SubCatArray($catid)
{
	
	$q = mysql_query("SELECT parents, name,categoryID FROM categories WHERE categoryID<>0 and categoryID=$catid ORDER BY categoryID") or die (mysql_error());
	$a = array(); //parents
	//global $a;
	while ($row = mysql_fetch_array($q))
	{
		//echo $row[1];
		//exit;
		//$row[5] = $level;
		
		$a[]=$row[2];
		$a[]=$row[1];
		$a[]=$row[0];
		
		//process subcategories
		//$b = fillTheCList($row[0],$level+1);
		$b=SubCatArray($row[0]);
		//add $b[] to the end of $a[]
		for ($j=0; $j<sizeof($b); $j++)
		{
			$a[] = $b[$j];
		}
	}
	$myarr=array_reverse($a,true);

	return $myarr;
}
/****************************************/

function SubCatListArray($catid)
{
	if($catid<>0)
	{
		$q = mysql_query("SELECT categoryID,name,parents FROM categories WHERE  parents=$catid ORDER BY categoryID") or die (mysql_error());
	}
	else
	{
		$q = mysql_query("SELECT categoryID,name,parents FROM categories WHERE  parents<>'0' ORDER BY categoryID") or die (mysql_error());
	}
	
	$a = array(); //parents
	while($row = mysql_fetch_row($q))
	{
		$id=$row[0];
		$ParentID=$row[2];
		$parentsyes[]=$id;	
	
		if(!in_array($ParentID,$parentsyes))
		{
			$a[]=$row[0];
			$a[]=$row[1];
		}
	}
	//$myarr=array_reverse($a,true);
	$myarr=$a;
	//print_r($myarr);
	//exit;
	return $myarr;
}

// **** FILL COMBO VALUE ***************/
function FILL_CATEGORY_NAME_COMBO($tmp,$b=true)
{
	$cats = fillTheCList(0,0,$b);	
	for ($i=0; $i<count($cats); $i++)
	{
		echo "<option value=\"".$cats[$i][0]."\"";
		if ($tmp == $cats[$i][0]) //select category
			echo " selected";
		echo ">";
		for ($j=0;$j<$cats[$i][5];$j++) echo "&nbsp;&nbsp;";
		echo $cats[$i][1];
		echo "</option>";
	}
}
//*************************************************//



// GET CATEGORY VALUE //
function getcategory($catid)
{
	$a=0;
	$q = mysql_query("SELECT name FROM categories WHERE categoryID<>0 and language_id='1' and categoryID=$catid ORDER BY categoryID") or die (mysql_error());
	
	$r=mysql_num_rows($q);	
	if($r)
	{
		$row = mysql_fetch_array($q);
		$a=$row[0];
	}
	return $a;
}

// FETCH COUNT SUB CATEGORIES //
function CountCategories($id)
{
	$qry="select count(*) as c from categories where parents='".$id."'";
	$res=mysql_query($qry);
	$countrow=mysql_fetch_object($res);
	$parents = $countrow->c;
	return $parents;
}
//***************************//

// FETCH COUNT SUB CATEGORIES //
function CountSubProducts($id)
{
	$qry="select count(*) as c from products where categoryID='".$id."'";
	$res=mysql_query($qry);
	$countrow=mysql_fetch_object($res);
	$parents = $countrow->c;
	return $parents;
}
//***************************//
//*******************************************************
//********************************************************

// FETCH LIST COUNTRY LIST ARRAY GROUP ID AND NAME  STORE ARRAY[] //
$country_query = mysql_query("select countryId,printable_name from countries where printable_name<>'' order by printable_name") or die (mysql_error());

while ($country = mysql_fetch_array($country_query)) 
{
	
	$country_array[] = array($country['countryId'],
								 $country['printable_name']);
}

//*********************************//


// FETCH LIST TAXE CLASSES ARRAY GROUP ID AND NAME STORE ARRAY[]//
/*$taxclass_query = mysql_query("select tax_class_id,tax_class_title  from tax_class where tax_class_title<>'' order by tax_class_title ") or die (mysql_error());

while ($taxclass = mysql_fetch_array($taxclass_query)) 
{
	
	$taxclass_array[] = array($taxclass['tax_class_id'],
								 $taxclass['tax_class_title']);
}
*/
//********************************//


// FETCH LIST DATE ARRAY //
//$dateformat_query = mysql_query("select format from ".DATE_TIME_FORMAT_TABLE." where date_time='date' order by date_time_format_id") or die (db_error());
//
//while ($date_format_row = db_fetch_array($dateformat_query)) 
//{
//	
//	$dateformat_array[] = array($date_format_row['format'],
//								 $date_format_row['format']);
//}
//**************************//
	
// FETCH LIST TIME ARRAY //
//$timeformat_query = db_query("select format from ".DATE_TIME_FORMAT_TABLE." where date_time='time' order by date_time_format_id") or die (db_error());
//
//while ($time_format_row = db_fetch_array($timeformat_query)) 
//{
//	$timeformat_array[] = array($time_format_row['format'],
//								 $time_format_row['format']);
//}
//**************************//

// FETCH LIST SHIPPING METHODS ARRAY[]//
//$shippingmethods_query = db_query("SELECT m_id,shipping_method,destination from ".REALTIME_SHIPPINGLMETHODS_TABLE." as rs left join ".REALTIME_SHIPPINGLIST_TABLE." as rsl ON rs.real_id=rsl.real_id WHERE rs.active='1' order by rs.real_id") or die (db_error());
//
//while ($shippingmethods = db_fetch_array($shippingmethods_query)) 
//{
//	
//	$shippingmethods_array[] = array($shippingmethods['m_id'],
//								 $shippingmethods['shipping_method'],$shippingmethods['destination']);
//}

//********************************//


// FETCH LIST SHIPPING ZONES ARRAY[]//
//$shippingzones_query = db_query("SELECT shipping_zone_id,shipping_zone from ".SHIPPING_ZONE_TABLE." order by shipping_zone_id") or die (db_error());
//
//while ($shippingzones = db_fetch_array($shippingzones_query)) 
//{
//	
//	$shippingzones_array[] = array($shippingzones['shipping_zone_id'],
//								 $shippingzones['shipping_zone']);
//}

//********************************//

// FILL COMBO COUNTRY NAME //
function FILL_COUNTRY_NAME($country_array,$tmp,$notfor)
{
	for ($i=0; $i<sizeof($country_array); $i++)
	{
		$count=sizeof($country_array[$i])-1;
		for($j=0;$j<$count;$j++)
		{
			if(!in_array($country_array[$i][$j],$notfor))
			{
				?>
				<option value="<?=$country_array[$i][$j]?>" <?php if ($tmp == $country_array[$i][$j]) echo " selected" ?>>
				<?
					echo $country_array[$i][$j+1];
				?>
				</option>
				<?
			}
			
		}
		
	}
}

// FILL COMBO ZONE NAME //
function FILL_ZONE_NAME($zonevalues_array,$tmp,$countrynm)
{
	// FETCH LIST ZONE ARRAY //
    $zone_values_query = db_query("select * from ".STATEZONE_TABLE." WHERE countryId='".$countrynm."' order by name") or die (db_error());
	
	while ($zone_values = db_fetch_array($zone_values_query)) 
	{
		
		$zonevalues_array[] = array($zone_values['id'],
									 $zone_values['name']);
	}
	//*********************************//
	
	
	for ($i=0; $i<sizeof($zonevalues_array); $i++)
	{
		$count=sizeof($zonevalues_array[$i])-1;
		for($j=0;$j<$count;$j++)
		{
			?>
			<option value="<?=$zonevalues_array[$i][$j]?>" <?php if ($tmp==$zonevalues_array[$i][$j]) echo " selected" ?>>
			<?
				echo $zonevalues_array[$i][$j+1];
			?>
			</option>
			<?
		}
	}
}


// THIS FUNCTION RETURN COUNTRY ARRAY // 
function SubCountryArray($conid)
{
	$q = db_query("SELECT printable_name,countryId  FROM ".COUNTRY_TABLE." WHERE countryId<>0 and countryId=$conid ORDER BY countryId") or die (db_error());
	$a = array(); //parents
	
	while ($row = db_fetch_row($q))
	{	
		$a[]=$row[1];
		$a[]=$row[0];
		break;
	}
	$myarr=array_reverse($a,true);
	return $myarr;
}
/****************************************/

// FILL COMBO TAX CLASS //
function FILL_TAXCLASS_NAME($taxclass_array,$tmp)
{
	for ($i=0; $i<sizeof($taxclass_array); $i++)
	{
		$count=sizeof($taxclass_array[$i])-1;
		for($j=0;$j<$count;$j++)
		{
			?>
			<option value="<?=$taxclass_array[$i][$j]?>" <?php if ($tmp == $taxclass_array[$i][$j]) echo " selected" ?>>
			<?
				echo $taxclass_array[$i][$j+1];
			?>
			</option>
			<?
		}
	}
}

// FILL DATE FORMAT COMBOBOX
function FILL_DATE_FORMATS($dateformat_array,$tmp)
{
	for ($i=0; $i<sizeof($dateformat_array); $i++)
	{
		$count=sizeof($dateformat_array[$i])-1;
		for($j=0;$j<$count;$j++)
		{
			?>
			<option value="<?=$dateformat_array[$i][$j]?>" <?php if ($tmp == $dateformat_array[$i][$j]) echo " selected" ?>>
			<?
				echo $dateformat_array[$i][$j+1];
			?>
			</option>
			<?
		}
	}
}	

// FILL TIME FORMAT COMBOBOX
function FILL_TIME_FORMATS($timeformat_array,$tmp)
{
	for ($i=0; $i<sizeof($timeformat_array); $i++)
	{
		$count=sizeof($timeformat_array[$i])-1;
		for($j=0;$j<$count;$j++)
		{
			?>
			<option value="<?=$timeformat_array[$i][$j]?>" <?php if ($tmp == $timeformat_array[$i][$j]) echo " selected" ?>>
			<?
				echo $timeformat_array[$i][$j+1];
			?>
			</option>
			<?
		}
	}
}	

// FILL SHIPPING METHODS WITH DESTINATION COMBOBOX
function FILL_SHIPPING_METHODS($shippingmethods_array,$tmp)
{
	for ($i=0; $i<sizeof($shippingmethods_array); $i++)
	{
		$count=sizeof($shippingmethods_array[$i])-2;
		for($j=0;$j<$count;$j++)
		{
			?>
			<option value="<?=$shippingmethods_array[$i][$j]?>" <?php if ($tmp == $shippingmethods_array[$i][$j]) echo " selected" ?>>
			<?
				if($shippingmethods_array[$i][$j+2]=='I')
				{
					$destination='International';
				}
				else
				{
					$destination='National';
				}
				
				echo $shippingmethods_array[$i][$j+1]." (".$destination.") ";
			?>
			</option>
			<?
		}
	}
}	
// FILL SHIPPING ZONES COMBOBOX
function FILL_SHIPPING_ZONES($shippingzones_array,$tmp)
{
	for ($i=0; $i<sizeof($shippingzones_array); $i++)
	{
		$count=sizeof($shippingzones_array[$i])-1;
		for($j=0;$j<$count;$j++)
		{
			?>
			<option value="<?=$shippingzones_array[$i][$j]?>" <?php if ($tmp == $shippingzones_array[$i][$j]) echo " selected" ?>>
			<?
				echo $shippingzones_array[$i][$j+1];
			?>
			</option>
			<?
		}
	}
}

function GetCountryName($conid)
{
	$q=db_query("SELECT * FROM ".COUNTRY_TABLE." where countryId='".$conid."' ORDER BY printable_name") or die (db_error());;
	
	$row=db_fetch_array($q);
	if($row)
	{
		$nm=$row['printable_name'];
	}
	else
	{
		$nm='';
	}
	return $nm;
}

function GetStateName($sid,$withcn=false)
{
	$q=db_query("SELECT ST.name,CN.printable_name FROM ".STATEZONE_TABLE." as ST,".COUNTRY_TABLE." as CN where ST.countryId=CN.countryId and ST.id='".$sid."' ORDER BY CN.printable_name") or die (db_error());;
	
	$row=db_fetch_array($q);
	if($row)
	{
		if($withcn==true)
		{
			$nm=$row['printable_name']." ..: ".$row['name'];
		}
		else
		{
			$nm=$row['name'];
		}
	}
	else
	{
		$nm='';
	}
	return $nm;
}


function validHTML($var)
{	
	$var = htmlspecialchars($var);
	// fix a slight bug due to data storage in older versions
	$var = eregi_replace("&amp;#39;","&#39;",$var);
	return $var;
}
function formatTime ($timestamp, $format=FALSE) {
	
	global $config;
	$config['timeFormat']="%b %d %Y,<br> %H:%M %p";
	
	if($format == FALSE){
		$format = $config['timeFormat'];
	} 
	
	$sign = substr($config['timeOffset'],0,1);
	$value = substr($config['timeOffset'],1);
	
	if($sign=="+"){
		$seconds = $timestamp+$value;
	} elseif($sign=="-"){
		$seconds = $timestamp-$value;
	} else {
		$seconds = $timestamp;
	}
	return strftime($format,$seconds);
}
?>

<?php	

	// FETCH LIST EXTRA FIELD ARRAY //
   /* $extra_fields_type_query = mysql_query("select field_type_name from extra_fields_type where field_type_name<>'' and language_id='1' order by field_type_name") or die (db_error());

	while ($f_type = mysql_fetch_array($extra_fields_type_query)) 
	{
		
    	$f_type_array[] = array($f_type['field_type_name'],
                                     $f_type['field_type_name']);
	}*/
	
	//*********************************//
	
	
	// FILL COMBO EXTRA FIELD NAME //
	function FILL_EXTRA_FIELD_TYPE_COMBO($f_type_array,$tmp)
	{
		
		//exit;
		for ($i=0; $i<sizeof($f_type_array); $i++)
		{
			$count=count($f_type_array[$i])-1;
			for($j=0;$j<$count;$j++)
			{
				?>
				<option value="<?=$f_type_array[$i][$j]?>" <?php if ($tmp == $f_type_array[$i][$j]) echo " selected" ?>>
				<?
					echo $f_type_array[$i][$j+1];
				?>
				</option>
				<?
			}
		}
	}
	// *******************************************//
	
	
	// THIS FETCH OF THE VALUE FROM EXTRA FIELD TYPE OPTION VALUE //
	function fetchOptionrows($exid,$tmp)
	{
		// FETCH LIST EXTRA FIELD ARRAY //
		$qoptval = mysql_query("select fields_type_value from extra_fields_type_value WHERE extra_field_id='".$exid."'") or die (mysql_error());
	
		while ($r = mysql_fetch_array($qoptval)) 
		{
			
			$fied_array[] = array($r['fields_type_value'],
										 $r['fields_type_value']);
		}
		//*********************************//		
		//print_r($fied_array);
		//exit;
		for ($i=0; $i<sizeof($fied_array); $i++)
		{
			$count=count($fied_array[$i])-1;
			for($j=0;$j<$count;$j++)
			{
				?>
				<option value="<?=$fied_array[$i][$j+1]?>" <?php if ($tmp == $fied_array[$i][$j+1]) echo " selected" ?>>
				<?
					echo $fied_array[$i][$j+1];
				?>
				</option>
				<?
			}
		}
		
	}
	//***********************************************************//
	

	// THIS DYNAMIC DISPLAY FIELD EXITS FIELDS IN EXTRA TABLE//
	function DISPLAY_FIELDS_IN_PRODUCTS($parents,$controll)
	{
		if(!isset($controll))
		{
			$controll=0;	 
		} 
			
			//echo "SELECT field_type_name,field_name,extra_field_id FROM ".EXTRA_FIELDS_TABLE." WHERE categoryID='".$parents."' and shows='1' order by extra_field_id ";
			//exit;
						
			$q=mysql_query("SELECT field_type_name,field_name,extra_field_id FROM extra_fields WHERE categoryID='".$parents."' and shows='1' order by extra_field_id ") or die (mysql_error());
			
			
			while($row=mysql_fetch_array($q))
			{
				//unset($extra_field_value);
				// EDIT OF THE ANY EXTRA FIELD MANAGE VALUE//
				$edit_manage_query=mysql_query("SELECT extra_field_manage_id,extra_field_value FROM extra_fields_manage WHERE products_id='".$controll."' and products_id<>'0' and extra_field_id='".$row[2]."' and extra_field_id<>'0'") or die (mysql_error());
				$row_manc=mysql_num_rows($edit_manage_query);	
				if($row_manc>0)
				{
					$row_manage = mysql_fetch_row($edit_manage_query);
					$extra_field_manage_id=$row_manage[0];
					$extra_field_value=$row_manage[1];	
	
				}
				//****************************************//
					
				switch ($row[0])
				{	
					case "TEXT";
						?><tr><td class=f-c align='right' width='30%' valign='middle'><?=$row[1]?> :</td><td width='48%'><input name="<?=$row[2]?>" class='solidinput' type='TEXT' value="<?=$extra_field_value?>"></td></tr>
						<?
						break;
					case "TEXTAREA";
						?><tr><td class=f-c align='right' width='40%' valign='middle'><?=$row[1]?> :</td><td width='17%'><textarea name="<?=$row[2]?>" rows="3" cols="30"><?=$extra_field_value?></textarea></td></tr>
						<?
						break;
					case "OPTION";
						?><tr><td class=f-c align='right' width='30%' valign='middle'><?=$row[1]?> :</td><td width='48%'><select class='solidinput' name="<?=$row[2]?>"><option value='' selected='selected'>---Select---</option><? fetchOptionrows($row[2],$extra_field_value); ?></select></td></tr>
						<?
						break;
					case "CHECKBOX";
						?><tr><td class=f-c align='right' width='30%' valign='middle'><?=$row[1]?> :</td><td width='48%'><input name="<?=$row[2]?>" class='solidinput' type='CHECKBOX' <?php if ($extra_field_value > 0) echo " checked"; ?>></td></tr>
						<?
						break;
					case "RADIO";
						?><tr><td class=f-c align='right' width='30%' valign='middle'><?=$row[1]?> :</td><td width='48%'><input name="<?=$row[2]?>" class='solidinput' type='RADIO' value="<?=$extra_field_value?>"></td></tr>
						<?
						break;
					case "FILE";
						?><tr><td class=f-c align='right' width='30%' valign='middle'><?=$row[1]?> :</td><td width='48%'><input name="<?=$row[2]?>" class='solidinput' type='FILE'></td></tr>
						<?
						break;
					case "PASSWORD";
						?><tr><td class=f-c align='right' width='30%' valign='middle'><?=$row[1]?> :</td><td width='48%'><input name="<?=$row[2]?>" class='solidinput' type='PASSWORD' value="<?=$extra_field_value?>"><input name="<?=$extra_field_manage_id?>" class='solidinput' type='HIDDEN' value="<?=$extra_field_manage_id?>"></td></tr>
						<?
						break;								
				} // END SWITCH
			} // END WHILE 
			
	}
	// *******************************************************//

	// THIS FUNCTION USE OF THE ADD EXTRA VALUE IN MANAGE TABLE
	function AddExtraManage($pid,$parents)
	{
		$qry=mysql_query("SELECT extra_field_id,field_type_name FROM extra_fields WHERE categoryID='".$parents."' and shows='1' order by extra_field_id ") or die (db_error());
		
		while($row=mysql_fetch_array($qry))
		{				
				if(isset($_POST[$row[0]]))
				{
					// INSERT
					$extravalue=$_POST[$row[0]];
					if($row[1]=="CHECKBOX")
					{
						$extravalue=(isset($_POST[$row[0]]))?1:0;
					}
					$extravalueArray[]=$extravalue;
									
					$q="INSERT INTO extra_fields_manage (language_id,extra_field_id,products_id,extra_field_value) VALUES('1','".$row[0]."','".$pid."','".$extravalue."')";
			
					mysql_query($q)or die (mysql_error());
				}
		}
		//print_r($extravalueArray);
	}
	
	// THIS FUNCTION USE OF THE EDIT EXTRA VALUE IN MANAGE TABLE
	function EditExtraManage($pid,$parents)
	{
		$qry=mysql_query("SELECT extra_field_id,field_type_name FROM extra_fields WHERE categoryID='".$parents."' and shows='1' order by extra_field_id ") or die (db_error());
		
		while($row=mysql_fetch_array($qry))
		{				
				$row_array[]=$row[0];
				if(isset($_POST[$row[0]]))
				{
					// CHECK RECORD //
					$m_res=mysql_query("SELECT count(*) as c FROM ".EXTRA_FIELDS_MANAGE_TABLE." WHERE extra_field_id='".$row[0]."' and products_id='".$pid."'") or die (mysql_error());
					//**************//
					
					$m_row=mysql_fetch_row($m_res);		
					$count=$m_row[0];
					
					if($count>0)
					{
						// UPDATE
						$extravalue=$_POST[$row[0]];
						if($row[1]=="CHECKBOX")
						{
							$extravalue=(isset($_POST[$row[0]]))?1:0;
						}
						$extravalueArray[]=$extravalue;
										
						$q="UPDATE extra_fields_manage SET language_id='1',extra_field_id='".$row[0]."',products_id='".$pid."',extra_field_value='".$extravalue."' WHERE extra_field_id='".$row[0]."' and products_id='".$pid."'";			
						
						mysql_query($q)or die (mysql_error());
					}
					else
					{
						// INSERT 
						$extravalue=$_POST[$row[0]];
						if($row[1]=="CHECKBOX")
						{
							$extravalue=(isset($_POST[$row[0]]))?1:0;
						}
						$extravalueArray[]=$extravalue;
										
						$q="INSERT INTO extra_fields_manage (language_id,extra_field_id,products_id,extra_field_value) VALUES('1','".$row[0]."','".$pid."','".$extravalue."')";
						
						mysql_query($q)or die (mysql_error());
					}
				}
		}
		//print_r($row_array);
		//echo "<br>";
		//print_r($extravalueArray);
	}	
	
	
	// THIS FUNCTION USE OF THE DELETE EXTRA VALUE IN MANAGE TABLE
	function DeleteExtraManage($pid,$parents)
	{
		$qry=mysql_query("SELECT extra_field_id FROM extra_fields WHERE categoryID='".$parents."' and shows='1' order by extra_field_id ") or die (mysql_error());

		while($row=mysql_fetch_array($qry))
		{				
			// DELETE
			$q="DELETE FROM extra_fields_manage WHERE extra_field_id='".$row[0]."' and products_id='".$pid."'";
			
			mysql_query($q) or die (mysql_error());
			
		}
	}	
	
function FillCategoriesType($producttype)
{
	$sql = "select * from categories where status='1' and parents='0' order by name";
	$result = mysql_query($sql) or die(mysql_error());
	$total = mysql_num_rows($result);
	if($total>0)
	{
		$content = "";
		while($row=mysql_fetch_array($result))
		{
			if($row['categoryID']==$producttype)
			{
				$content .='<option value="'.$row['categoryID'].'" selected="selected">'.$row['name'].'</option>';
			}
			else
			{
				$content .='<option value="'.$row['categoryID'].'">'.$row['name'].'</option>';
			}	
		}
	}	
	return $content;
}
function FillCategoriescategory($tempid)
{
	$sql = "select * from categories where parents!='0' and status='1' order by name";
	$result = mysql_query($sql) or die(mysql_error());
	$total = mysql_num_rows($result);
	if($total>0)
	{
		$content = "";
		while($row=mysql_fetch_array($result))
		{
			if($row['categoryID']==$tempid)
			{
				$content .= '<option value="'.$row['categoryID'].'" selected="selected">'.$row['name'].'</option>';
			}
			else
			{
				$content .= '<option value="'.$row['categoryID'].'">'.$row['name'].'</option>';
			}
		}
	}
	return $content;	
}	
?>

