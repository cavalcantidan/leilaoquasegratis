// JavaScript Document
// JavaScript Document
var xmlhttp = false;
var xmlhttp1 = false;
//Check if we are using IE.
try {
	xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
	xmlhttp1 = new ActiveXObject("Msxml2.XMLHTTP");
} catch (e) {
try {
	xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	xmlhttp1 = new ActiveXObject("Microsoft.XMLHTTP");
} catch (E) {
	xmlhttp = false;
	xmlhttp1 = false;
	}
}
//If we are using a non-IE browser, create a JavaScript instance of the object.
if (!xmlhttp && typeof XMLHttpRequest != 'undefined') {
	xmlhttp = new XMLHttpRequest();
}
if (!xmlhttp1 && typeof XMLHttpRequest != 'undefined') {
	xmlhttp1 = new XMLHttpRequest();
}

function ChangeCategorylist(parentid){
	var objId = "AddCategoryList";
	var ServerPage = "getcategorylist.php?parentid="+parentid;
	var objNew = document.getElementById(objId)
	xmlhttp.open("GET",ServerPage)
	xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			objNew.innerHTML = xmlhttp.responseText;
		}
	}
xmlhttp.send(null);
}

function ChangeBrandlist(p1){
	var objId1 = "AddBrandList";
	var ServerPage1 = "getbrandlist.php?p1="+p1;
	var objNew1 = document.getElementById(objId1)
	xmlhttp1.open("GET",ServerPage1)
	xmlhttp1.onreadystatechange = function() {
		if (xmlhttp1.readyState == 4 && xmlhttp1.status == 200) {
			objNew1.innerHTML = xmlhttp1.responseText;
		}
	}
xmlhttp1.send(null);
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
