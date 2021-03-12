    var GlobalVar = 0;
    var GlobalStat = 0;
	function changeimage(id){
		document.getElementById('mainimage1').style.display='none';
		document.getElementById('mainimage2').style.display='none';
		document.getElementById('mainimage3').style.display='none';
		document.getElementById('mainimage4').style.display='none';
		document.getElementById('mainimage'+id).style.display='block';
	}

	function setLogin(id)
	{
		document.getElementById(id).src='images/bid_click_login_hover.jpg';		
	}

	function setBid(id)
	{
		document.getElementById(id).src='images/bid_click_white_bid.jpg';		
	}
	
//end of part functions.js

function changeData(responseText,stat_us)
{
	var text = responseText;
	if(text!="")
	{
		counter = text.split('#');
	    for (i = 0; i < counter.length; i++)
		{
		   counter_data1 = counter[i].split(':');
		   auction_id = counter_data1[0];
		   auction_price = counter_data1[1];
		   auction_bidder_name = counter_data1[2];
		   if(auction_bidder_name=="")
		   {
			  auction_bidder_name="---" 
		   }
			if(document.getElementById('price_index_page_' + auction_id).innerHTML != "R$" + auction_price)
			{
				if(GlobalVar == 1)	
				{
					document.getElementById('price_index_page_' + auction_id).style.backgroundColor = "#f79909";
				}
		   		document.getElementById('price_index_page_' + auction_id).innerHTML = "R$" + auction_price;
		   		document.getElementById('product_bidder_' + auction_id).innerHTML = auction_bidder_name;
			}
			else
			{
				document.getElementById('price_index_page_' + auction_id).style.backgroundColor = "white";	
			}
		}
		
	}
	GlobalVar = 1;
}

function hidedisplayzoom(div_id) {
	document.getElementById(div_id).style.display = 'block';
	if(document.getElementById('zoomimagename').innerHTML!="" && document.getElementById('zoomimagename').innerHTML!=div_id)
	{
		document.getElementById(document.getElementById('zoomimagename').innerHTML).style.display	= 'none';
	}
	document.getElementById('zoomimagename').innerHTML = div_id;
}

function closezoomimage(div_id)
{
	document.getElementById(div_id).style.display='none';
}

function calc_counter_from_time(diff) {
  if (diff > 0) {
    hours=Math.floor(diff / 3600)

    minutes=Math.floor((diff / 3600 - hours) * 60)

    seconds=Math.round((((diff / 3600 - hours) * 60) - minutes) * 60)
  } else {
    hours = 0;
    minutes = 0;
    seconds = 0;
  }

  if (seconds == 60) {
    seconds = 0;
  }

  if (minutes < 10) {
    if (minutes < 0) {
      minutes = 0;
    }
    minutes = '0' + minutes;
  }
  if (seconds < 10) {
    if (seconds < 0) {
      seconds = 0;
    }
    seconds = '0' + seconds;
  }
  if (hours < 10) {
    if (hours < 0) {
      hours = 0;
    }
    hours = '0' + hours;
  }
  return hours + ":" + minutes + ":" + seconds;
}

var xmlhttp = false;
//Check if we are using IE.
try {
	xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
} catch (e) {
try {
	xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
} catch (E) {
	xmlhttp = false;
	}
}
//If we are using a non-IE browser, create a JavaScript instance of the object.
if (!xmlhttp && typeof XMLHttpRequest != 'undefined') {
	xmlhttp = new XMLHttpRequest();
}

function CheckSaveProperty(auction_ids){
	var objId = "URL"
		var ServerPage = "update_time.php?aids=" + auction_ids;
		var objNew = document.getElementById(objId)
		xmlhttp.open("GET",ServerPage)
		xmlhttp.onreadystatechange = function() {
			if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
				mainarray = xmlhttp.responseText.split('/');
				counters = mainarray[0].split('#')
				for (i = 0; i < counters.length; i++)
				{			
					counter_data = counters[i].split(':');
					auction_id = counter_data[0];
					pausestatus = counter_data[2];
					if(counter_data[1]=='0')
					{
					document.getElementById('counter_index_page_' + auction_id).innerHTML = 'Ended';					
					document.getElementById('image_main_' + auction_id).src = "images/but_sold2.jpg";
					document.getElementById('image_main_' + auction_id).onclick="";
					document.getElementById('image_main_' + auction_id).onmouseover="";
					document.getElementById('image_main_' + auction_id).onmouseout="";
					}
					else if(pausestatus==1)
					{
						document.getElementById('counter_index_page_' + auction_id).innerHTML = 'Pause';					
						document.getElementById('image_main_' + auction_id).src = "images/bid_click_white_bid_hover.jpg";
						document.getElementById('image_main_' + auction_id).onclick="";
						document.getElementById('image_main_' + auction_id).onmouseover="";
						document.getElementById('image_main_' + auction_id).onmouseout="";
					}
					else
					{
					auction_time = counter_data[1];
						if(auction_time<10)
						{
						document.getElementById('counter_index_page_' + auction_id).style.color = '#E80000';	
					document.getElementById('counter_index_page_' + auction_id).innerHTML = calc_counter_from_time(auction_time);
						}
						else
						{
						document.getElementById('counter_index_page_' + auction_id).style.color = '#6e6d6d';	
					document.getElementById('counter_index_page_' + auction_id).innerHTML = calc_counter_from_time(auction_time);
						}
					}
				}
			}
		}
xmlhttp.send(null);
}

function CheckSaveProperty1(auction_ids,auc_his_id,butlerbuttonid){
	var objId = "URL"
		var ServerPage = "update_time.php?aids=" + auction_ids + "&auc_his_id=" + auc_his_id;
		var objNew = document.getElementById(objId)
		xmlhttp.open("GET",ServerPage)
		xmlhttp.onreadystatechange = function() {
			if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
				mainarray = xmlhttp.responseText.split('/');
				counters = mainarray[0].split('#')
				for (i = 0; i < counters.length; i++)
				{			
					counter_data = counters[i].split(':');
					auction_id = counter_data[0];
					pausestatus = counter_data[2];
					if(counter_data[1]=='0')
					{
					document.getElementById('counter_index_page_' + auction_id).innerHTML = 'Ended';					
					document.getElementById('image_main_' + auction_id).src = "images/but_sold2.jpg";
					document.getElementById('image_main_' + auction_id).onclick="";
					document.getElementById('image_main_' + auction_id).onmouseover="";
					document.getElementById('image_main_' + auction_id).onmouseout="";
					if(butlerbuttonid==auction_id)
					{
						document.getElementById('bookbidbutlerbutton').disabled = true;
					}
					}
					else if(pausestatus==1)
					{
						document.getElementById('counter_index_page_' + auction_id).innerHTML = 'Pause';					
						document.getElementById('image_main_' + auction_id).src = "images/bid_click_white_bid_hover.jpg";
						document.getElementById('image_main_' + auction_id).onclick="";
						document.getElementById('image_main_' + auction_id).onmouseover="";
						document.getElementById('image_main_' + auction_id).onmouseout="";
					}
					else
					{
					auction_time = counter_data[1];
						if(auction_time<10)
						{
						document.getElementById('counter_index_page_' + auction_id).style.color = '#E80000';	
					document.getElementById('counter_index_page_' + auction_id).innerHTML = calc_counter_from_time(auction_time);
						}
						else
						{
						document.getElementById('counter_index_page_' + auction_id).style.color = '#6e6d6d';	
					document.getElementById('counter_index_page_' + auction_id).innerHTML = calc_counter_from_time(auction_time);
						}
					}
				}
			CheckProHistory(mainarray[1]);	
			}
		}
xmlhttp.send(null);
}

/* function CheckSaveProperty1(auction_ids,auc_his_id){
	var objId = "URL"
		var ServerPage = "update_time.php?aids=" + auction_ids + "&auc_his_id" + auc_his_id;
		var objNew = document.getElementById(objId)
		xmlhttp.open("GET",ServerPage)
		xmlhttp.onreadystatechange = function() {
			if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
				mainarray = xmlhttp.responseText.split('/');
				counters = mainarray[0].split('#')
				for (i = 0; i < counters.length; i++)
				{			
					counter_data = counters[i].split(':');
					auction_id = counter_data[0];
					pausestatus = counter_data[2];
					if(counter_data[1]=='0')
					{
					document.getElementById('counter_index_page_' + auction_id).innerHTML = 'Ended';					
					document.getElementById('image_main_' + auction_id).src = "images/bid_click_white_sold1.jpg";
					document.getElementById('image_main_' + auction_id).onclick="";
					document.getElementById('image_main_' + auction_id).onmouseover="";
					document.getElementById('image_main_' + auction_id).onmouseout="";
					}
					else if(pausestatus==1)
					{
						document.getElementById('counter_index_page_' + auction_id).innerHTML = 'Pause';					
						document.getElementById('image_main_' + auction_id).src = "images/bid_click_white_bid1.jpg";
						document.getElementById('image_main_' + auction_id).onclick="";
						document.getElementById('image_main_' + auction_id).onmouseover="";
						document.getElementById('image_main_' + auction_id).onmouseout="";
					}
					else
					{
					auction_time = counter_data[1];
					document.getElementById('counter_index_page_' + auction_id).innerHTML = calc_counter_from_time(auction_time);
					}
				}
			}
		}
		
xmlhttp.send(null);
}*/


function setbidding(prid,aid,uid)
{
	var url="getbid.php?prid="+prid+"&aid="+aid+"&uid="+uid;

	new Ajax.Request(url,
		{   
		method: 'get',   
		onSuccess: function(transport) 
		{     
			if(transport.status==200)
			{	
				var temp=transport.responseText;
				if(temp=="unsuccess")
				{
					if(confirm("Please recharge your bid account"))
					{
						window.location.href='buybids.html';
					}
				}	
				
				if(temp=="success")
				{
					obj = document.getElementById('bids_count');
					objvalue = document.getElementById('bids_count').innerHTML;
					if(obj.innerHTML!='0')
					{
						obj.innerHTML = Number(objvalue) - 1;
					}
				}
			}
		}
		});		
}
/*function changedbid()
{
	if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
	{ 
		var temp=xmlhttp.responseText;
		if(temp=="unsuccess")
		{
		   		
			if(confirm("Please recharge your bid account"))
			{
				window.location.href='buybids.php';
			}
		}	
		
		if(temp=="success")
		{
			obj = document.getElementById('bids_count');
			objvalue = document.getElementById('bids_count').innerHTML;
			if(obj.innerHTML!='0')
			{
				obj.innerHTML = Number(objvalue) - 1;
			}
		}
	}

}*/

function CheckProHistory(aucid_new){
		var history__data = "";
		var history____data;
		history__data = aucid_new;
//		alert(history__data);
		if(history__data!="" && history__data!="|")
		{
			history____data = history__data.split('|');
//			alert(history____data);
			counter_history = history____data[0].split('#');
			counter_history_mybid = history____data[1].split('#');
			if(counter_history!="")
			{
				for (i = 0; i < counter_history.length; i++)
				{
				   history_data = counter_history[i].split(':');
				   bidding_price = history_data[0];
				   //alert(bidding_price);
				   bidding_username = history_data[1];
				   if(bidding_username=="" && bidding_price!="")
				   {
					   bidding_username="user removed";
				   }
				   bidding_type = history_data[2];
					document.getElementById('bid_price_' + i).innerHTML = "R$" + bidding_price;
					document.getElementById('bid_user_name_' + i).innerHTML = bidding_username;
	
					if(bidding_type=='s')
					{
						document.getElementById('bid_type_' + i).innerHTML = "Einzelgebot";
					}
					else if(bidding_type=='b')
					{
						document.getElementById('bid_type_' + i).innerHTML = "BietBuddy";
					}
				}
			}
			if(counter_history_mybid!="")
			{
				for (i = 0; i < counter_history_mybid.length; i++)
				{
				   history_data1 = counter_history_mybid[i].split('!');
				   bidding_price1 = history_data1[0];
				   //alert(bidding_price);
				   bidding_time1 = history_data1[1];
				   bidding_type1 = history_data1[2];
					document.getElementById('my_bid_price_' + i).innerHTML = "R$" + bidding_price1;
					document.getElementById('my_bid_time_' + i).innerHTML = bidding_time1;
	
					if(bidding_type1=='s')
					{
						document.getElementById('my_bid_type_' + i).innerHTML = "Single Bid";
					}
					else if(bidding_type1=='b')
					{
						document.getElementById('my_bid_type_' + i).innerHTML = "AutoBidder";
					}
				}
			}
		 }
}
/*
function CheckProHistory(aucid_new){
	//var objId = "URL"
	var lprice = document.getElementById('price_index_page_' + aucid_new).innerHTML; 
	var ServerPage1 = "updatehistory.php?aucid_new=" + aucid_new + "&lprice=" + lprice;
	//var objNew = document.getElementById(objId);
	xmlhttp.open("GET",ServerPage1);
	xmlhttp.onreadystatechange = function() {
		//alert(xmlhttp.responseText);
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
		{
			var history__data = "";
			var history____data;
			history__data = xmlhttp.responseText;
		if(history__data!="")
		{
			//alert(history__data);
			history____data = history__data.split('|');
			//alert(history____data);
			counter_history = history____data[0].split('#');
			counter_history_mybid = history____data[1].split('#');
			if(counter_history!="")
			{
				for (i = 0; i < counter_history.length; i++)
				{
				   history_data = counter_history[i].split(':');
				   bidding_price = history_data[0];
				   //alert(bidding_price);
				   bidding_username = history_data[1];
				   bidding_type = history_data[2];
					document.getElementById('bid_price_' + i).innerHTML = "&pound;" + bidding_price;
					document.getElementById('bid_user_name_' + i).innerHTML = bidding_username;
	
					if(bidding_type=='s')
					{
						document.getElementById('bid_type_' + i).innerHTML = "single bid";
					}
					else if(bidding_type=='b')
					{
						document.getElementById('bid_type_' + i).innerHTML = "BidButler";
					}
				}
			}
			if(counter_history_mybid!="")
			{
				for (i = 0; i < counter_history_mybid.length; i++)
				{
				   history_data1 = counter_history_mybid[i].split('!');
				   bidding_price1 = history_data1[0];
				   //alert(bidding_price);
				   bidding_time1 = history_data1[1];
				   bidding_type1 = history_data1[2];
					document.getElementById('my_bid_price_' + i).innerHTML = "&pound;" + bidding_price1;
					document.getElementById('my_bid_time_' + i).innerHTML = bidding_time1;
	
					if(bidding_type1=='s')
					{
						document.getElementById('my_bid_type_' + i).innerHTML = "single bid";
					}
					else if(bidding_type1=='b')
					{
						document.getElementById('my_bid_type_' + i).innerHTML = "BidButler";
					}
				}
			}
		}
	 }
	}
xmlhttp.send(null);	
}*/
function PressImageDownBid(id)
{
	document.getElementById(id).src = 'images/bid_click_press.jpg';
}
function PressImageUpBid(id)
{
	document.getElementById(id).src = 'images/bid_click_bid_hover.jpg';
}
function PressImageDownLogin(id)
{
	document.getElementById(id).src = 'images/login_click_press.jpg';
}
function PressImageUpLogin(id)
{
	document.getElementById(id).src = 'images/bid_click_login_hover.jpg';
}

function changedatabutler(data,page,butlerpbids)
{
//	alert(data);
	data1 = eval('(' + data.responseText + ')');
	k = 1;
//	alert(data.butlerslength.length);
	for (j=0;j<data.butlerslength.length;j++)
	{	
//			alert(j);
			if(data.butlerslength[j].bidbutler.startprice!="")
			{	
				if(Number(j)<Number(data.butlerslength.length))
				{
					butlerstartprice = "R$"+data.butlerslength[j].bidbutler.startprice;
					butlerendprice = "R$"+data.butlerslength[j].bidbutler.endprice;
					butlerbid = data.butlerslength[j].bidbutler.bids;
					but_id = data.butlerslength[j].bidbutler.id;
					var blockst = 1;
				}
				else
				{
					butlerstartprice = "&nbsp;";
					butlerendprice = "&nbsp;";
					butlerbid ="&nbsp;";
					but_id = "";
					var blockst = 0;
				}
			}	
			else
			{
				butlerstartprice = "&nbsp;";
				butlerendprice = "&nbsp;";
				butlerbid ="&nbsp;";
				but_id = "";
				var blockst = 0;
			}
			//alert("butlerstartprice:"+butlerstartprice+"==butlerendprice:"+butlerendprice+"==butlerbid:"+butlerbid+"==but_id:"+but_id);
			if(j==0)
			{
				document.getElementById('mainbutlerbody_' + k).style.display = 'block';
				document.getElementById('butlerstartprice_1').innerHTML = butlerstartprice;
				document.getElementById('butlerendprice_1').innerHTML = butlerendprice;
				document.getElementById('butlerbids_1').innerHTML = butlerbid;
				if(blockst==1)
				{
				document.getElementById('deletebidbutler_1').style.display = 'block';
				document.getElementById('deletebidbutler_1').innerHTML = "<img src='images/btn_closezoom.png' style='cursor: pointer;' onclick='DeleteBidButler(\""+but_id+"\",\"1\");' id='butler_image_1' />";
				//document.getElementById('butler_image_1').onclick = "DeleteBidButler('"+but_id+"','1')";
				}
				else
				{
				document.getElementById('deletebidbutler_1').style.display = 'none';
				}
			}
			else if(j==1)
			{
				document.getElementById('mainbutlerbody_' + k).style.display = 'block';
				document.getElementById('butlerstartprice_2').innerHTML = butlerstartprice;
				document.getElementById('butlerendprice_2').innerHTML = butlerendprice;
				document.getElementById('butlerbids_2').innerHTML = butlerbid;
				if(blockst==1)
				{
				document.getElementById('deletebidbutler_2').style.display = 'block';
				document.getElementById('deletebidbutler_2').innerHTML = "<img src='images/btn_closezoom.png' style='cursor: pointer;' onclick='DeleteBidButler(\""+but_id+"\",\"2\");' id='butler_image_2' />";
				//document.getElementById('butler_image_2').onclick = "DeleteBidButler('"+but_id+"','2')";
				}
				else
				{
				document.getElementById('deletebidbutler_2').style.display = 'none';
				}
				
			}
			else if(j==2)
			{
				document.getElementById('mainbutlerbody_' + k).style.display = 'block';
				document.getElementById('butlerstartprice_3').innerHTML = butlerstartprice;
				document.getElementById('butlerendprice_3').innerHTML = butlerendprice;
				document.getElementById('butlerbids_3').innerHTML = butlerbid;
				if(blockst==1)
				{
				document.getElementById('deletebidbutler_3').style.display = 'block';
				document.getElementById('deletebidbutler_3').innerHTML = "<img src='images/btn_closezoom.png' style='cursor: pointer;' onclick='DeleteBidButler(\""+but_id+"\",\"3\");' id='butler_image_3' />";
				//document.getElementById('butler_image_3').onclick = "DeleteBidButler('"+but_id+"','3')";
				}
				else
				{
				document.getElementById('deletebidbutler_3').style.display = 'none';
				}
				
			}
			else if(j>2)
			{
				document.getElementById('mainbutlerbody_' + k).style.display = 'block';
				document.getElementById('butlerstartprice_' + k).innerHTML = butlerstartprice;
				document.getElementById('butlerendprice_' + k).innerHTML = butlerendprice;
				document.getElementById('butlerbids_' + k).innerHTML = butlerbid;
				if(blockst==1)
				{
				document.getElementById('deletebidbutler_' + k).style.display = 'block';
				document.getElementById('deletebidbutler_' + k).innerHTML = "<img src='images/btn_closezoom.png' style='cursor: pointer;' onclick='DeleteBidButler(\""+but_id+"\",\"" + k + "\");' id='butler_image_" + k +"' />";
				//document.getElementById('butler_image_3').onclick = "DeleteBidButler('"+but_id+"','3')";
				}
				else
				{
				document.getElementById('deletebidbutler_' + k).style.display = 'none';
				}
				
			}
			/*document.getElementById('butlerstartprice_' + i).innerHTML = butlerstartprice;
			document.getElementById('butlerendprice_' + i).innerHTML = butlerendprice;
			document.getElementById('butlerbids_' + i).innerHTML = butlerbid;
			document.getElementById('deletebidbutler_' + i).style.display = 'block';*/
//				document.getElementById('butler_image_' + i).onclick = 'DeleteBidButler(' + but_id + ')';
		k++;
	}

	for(p=data.butlerslength.length+1;p<=20;p++)
	{
		document.getElementById('mainbutlerbody_' + p).style.display = 'none';
	}
	//alert(k);		

	if(page=="abut")
	{
		document.getElementById('live_no_bidbutler').style.display = 'none';
		if(butlerpbids!="&nbsp;")
		{
			objbids = document.getElementById('bids_count');
			objbidsvalue = document.getElementById('bids_count').innerHTML;
	
			if(objbids.innerHTML!='0')
			{
				objbids.innerHTML = Number(objbidsvalue) - Number(butlerpbids);
			}
		}	
	}
}

function ChangeButlerImageSecond(){
//		document.getElementById('bidtips').style.display='block';
	document.getElementById('butlermessage').style.display='none';
	clearInterval(changeMessageTimer);
}

function onBeforeUnloadAction(){
		url1="updatelogin.php";
		xmlhttp.open("GET",url1)
		xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
				datatemp = xmlhttp.responseText;
		}
		}
	xmlhttp.send(null);
}

window.onbeforeunload = function(e){
			if(!e) e = window.event;
			if(typeof e.pageX == "number"){
				X = e.pageX;
				Y = e.pageY;
			}else{
				X = e.clientX;
				Y = e.clientY;
			}
			if((X<0) || (Y<0)){
				 return onBeforeUnloadAction();
		    }
}

function UpdateLoginLogout(){
		url1="updatelogin.php";
		xmlhttp.open("GET",url1);
		xmlhttp.onreadystatechange = function() {
    		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
    			datatemp = xmlhttp.responseText;
    		}
		}
xmlhttp.send(null);
}
