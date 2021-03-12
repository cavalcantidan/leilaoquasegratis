var flipflop=1;
var storedata;
function OnloadPage(){
	if($.browser.msie){
		//Configurar ajax
		$.ajaxSetup({
			cache: false
		});
	}
	// Padrão de freqüência para leilão atualização e sincronização de tempo
    var auctionUpdateTime = 500;    // tempo em milisegundo
	var counterUpdateTime = 1000;
    
	// Variável para armazenar dados de leilão
	var auctions = '';

    // Coleta de dados do leilão, o ID de camada e ID do Leilão
	$('.itemLeiao').each(function () {
	    var auctionId = $(this).attr('title');
	    if (auctions == '') auctions = auctions + ',';
	    auctions = auctions + auctionId;
	});

	var GlobalVar = 0;

	// Principais contagem regressiva para a atualização do leilão e piscando
	setInterval(function(){
		if(auctions){
			$.ajax({
			    url: 'update_information.php',
				dataType: 'json',
				type: 'POST',
				data: 'leiloes='+auctions,
				global: false,
				success: function(data){
					storedata = data;
					$.each(data, function(i, item){
						leilao_codigo = item.auction.id;
						leilao_preco_atual = item.auction.price;
						leilao_nome_vencendo = item.auction.username;
						leilao_cronometro = item.auction.time;
						if (leilao_nome_vencendo == "") { leilao_nome_vencendo = "-\"SEM LANCES\"-" }

						if(document.getElementById('price_index_page_' + leilao_codigo).innerHTML != leilao_preco_atual){
							if(GlobalVar == 1){
								var forhoverid = new Spry.Effect.Highlight('price_index_page_' + leilao_codigo , {duration: 500, from:'#E80000', to:'#fff', restoreColor: '#fff'});
								var forhoverid2 = new Spry.Effect.Highlight('currencysymbol_' + leilao_codigo , {duration: 500, from:'#E80000', to:'#fff', restoreColor: '#fff'});
	
								forhoverid.start();
								forhoverid2.start();
							}
							document.getElementById('price_index_page_' + leilao_codigo).innerHTML = leilao_preco_atual;
							document.getElementById('currencysymbol_' + leilao_codigo).innerHTML = "R$";
							document.getElementById('product_bidder_' + leilao_codigo).innerHTML = leilao_nome_vencendo;
						}else{
							document.getElementById('price_index_page_' + leilao_codigo).style.backgroundColor = "transparent";	
						}					  
					});
					GlobalVar = 1;
				},
				error: function(XMLHttpRequest,textStatus, errorThrown){
//						alert(XMLHttpRequest);
//						alert(textStatus);
//						alert(errorThrown);
					}
			});
		}
		if(flipflop==1) { flipflop = 2; }
		else if(flipflop==2) { flipflop = 1;}
		ChangeCountdownData(storedata);
	}, auctionUpdateTime);

	// Function for bidding
	$('.bid-button-link').click(function(){
		$.ajax({
			url: $(this).attr('name'),
			dataType: 'json',
			success: function(data){
				$.each(data, function(i, item){
				result = item.result;
				if(result=="unsuccess"){
					if(confirm(plsrechargebid)){
						window.location.href='buybids.html';
					}
				}
				if(result=="success"){
					obj = document.getElementById('bids_count');
					objvalue = document.getElementById('bids_count').innerHTML;
					if(obj.innerHTML!='0'){
						obj.innerHTML = Number(objvalue) - 1;
					}
				}
			});
			},
			error: function(XMLHttpRequest,textStatus, errorThrown){
//				alert(textStatus);
			}
		});

		return false;
	});


	if($('.productImageThumb').length){
	setInterval(function(){
		auctionhisid = document.getElementById('history_auctionid').innerHTML;

		oldprice = document.getElementById('curproductprice').innerHTML;
		newprice = document.getElementById('price_index_page_' + auctionhisid).innerHTML;
	if(oldprice!=newprice){
		getStatusUrl3 = 'updatehistory.php?aucid_new='+auctionhisid;
	$.ajax({
		url: getStatusUrl3,
		dataType: 'json',
		success: function(data){
			data1 = eval('(' + data.responseText + ')');
			for(i=0;i<data.histories.length;i++){
				biddingprice = data.histories[i].history.bprice;
				biddingusername = data.histories[i].history.username;
				biddingtype = data.histories[i].history.bidtype;

				document.getElementById('bid_price_' + i).innerHTML = "R$" + biddingprice;
				document.getElementById('bid_user_name_' + i).innerHTML = biddingusername;

				if(biddingtype=='s'){
					document.getElementById('bid_type_' + i).innerHTML = placesinglebid;
				}else if(biddingtype=='b'){
					document.getElementById('bid_type_' + i).innerHTML = placebidbuddy;
				}else if(bidding_type=='m'){
					document.getElementById('bid_type_' + i).innerHTML = placesmsbid;
				}
			}
			
			if(data.myhistories.length){
				for(j=0;j<data.myhistories.length;j++){
					biddingprice1 = data.myhistories[j].myhistory.bprice;
					biddingusername1 = data.myhistories[j].myhistory.time;
					biddingtype1 = data.myhistories[j].myhistory.bidtype;

					document.getElementById('my_bid_price_' + j).innerHTML = "R$" + biddingprice1;
					document.getElementById('my_bid_time_' + j).innerHTML = biddingusername1;
	
					if(biddingtype1=='s'){
						document.getElementById('my_bid_type_' + j).innerHTML = placesinglebid;
					}else if(biddingtype1=='b'){
						document.getElementById('my_bid_type_' + j).innerHTML = placebidbuddy;
					}else if(biddingtype1=='m'){
						document.getElementById('my_bid_type_' + j).innerHTML = placesmsbid;
					}
				}
			}
			document.getElementById('curproductprice').innerHTML = "R$" + data.histories[0].history.bprice;
		},
		error: function(XMLHttpRequest,textStatus, errorThrown){
//			alert(textStatus);	
		}
		   });
	}
	 },counterUpdateTime);
	}

	$('.bookbidbutlerbutton').click(function(){
	if(document.getElementById('bookbidbutlerbutton').name!=""){
		var bidbutstartprice;
		var bidbutendprice;
		var totalbids;
		
		bidbutstartprice = Number(document.bidbutler.bidbutstartprice.value);
		bidbutendprice = Number(document.bidbutler.bidbutendprice.value);
		totalbids = document.bidbutler.totalbids.value;
		if(bidbutstartprice==""){
			alert(entbutsprice);
			return false;
		}
		if(bidbutendprice==""){
			alert(entbuteprice);
			return false;
		}
		if(totalbids==""){
			alert(entbutbids);
			return false;
		}
		if(totalbids<=1){
			alert(entmoreone);
			return false;
		}
		if(bidbutstartprice>bidbutendprice){
			alert(spricegreat);
			return false;
		}
		if(bidbutstartprice==bidbutendprice){
			alert(endpricegreat);
			return false;
		}

		$.ajax({
			url: "addbidbutler.php?aid="+$(this).attr('name')+"&bidsp="+bidbutstartprice+"&bidep="+bidbutendprice+"&totb="+totalbids,
			dataType: 'json',
			success: function(data){
				$.each(data, function(i, item){
				result = item.result;
				if(result=="unsuccessprice"){
					alert(bidfromvalueismust);
				}else if(result=="unsuccess"){
					alert(plsrechargebid);
				}else{
					document.bidbutler.bidbutstartprice.value="";
					document.bidbutler.bidbutendprice.value="";
					document.bidbutler.totalbids.value="";
					document.getElementById('butlermessage').style.display='block';
					changeMessageTimer = setInterval("ChangeButlerImageSecond()",3000);
					changedatabutler(data,"abut",totalbids);
				}
			  });
			},
			error: function(XMLHttpRequest,textStatus, errorThrown){
//				alert(textStatus);
			}
		});

		return false;
	 }
	});
}

function DeleteBidButler(id,div_id){
	$.ajax({
		url: url = "deletebutler.php?delid=" + id,
		dataType: 'json',
		success: function(data){
		$.each(data, function(i, item){
			result = item.result;
			if(result=="unsuccess"){
				alert(youbidisrunning);
			}else{
				placebids = document.getElementById('butlerbids_' + div_id).innerHTML;
				objbids = document.getElementById('bids_count');
				objbidsvalue = document.getElementById('bids_count').innerHTML;
				if(objbids.innerHTML!='0'){
					objbids.innerHTML = Number(objbidsvalue) + Number(placebids);
				}
				changedatabutler(data,"dbut","");
			}
		});
	},
		error: function(XMLHttpRequest,textStatus, errorThrown){
//				alert(textStatus);
		}
	});
	return false;
}

function ChangeCountdownData(resdata){
	if(resdata && resdata!=""){
		data = resdata;
		var f=0;
		$.each(data, function (i, item) {
			leilao_codigo = item.auction.id;
			leilao_cronometro = item.auction.time;
			pausestatus = item.auction.pause;
			if (leilao_cronometro) {
				if (leilao_cronometro == '0') {
					document.getElementById('counter_index_page_' + leilao_codigo).style.color = '#000000';
					document.getElementById('counter_index_page_' + leilao_codigo).innerHTML = printended;
					document.getElementById('image_main_' + leilao_codigo).onclick = "";
					document.getElementById('image_main_' + leilao_codigo).name = "";
					document.getElementById('image_main_' + leilao_codigo).onmouseover = "";
					document.getElementById('image_main_' + leilao_codigo).onmouseout = "";
					if ($('.history_auctionid').length) {
						if (document.getElementById('history_auctionid').innerHTML == leilao_codigo) {
							document.getElementById('bookbidbutlerbutton').name = "";
							document.getElementById('image_main_' + leilao_codigo).src = allimagepath + "BIG_SOLD_btn.png";
						} else {
							document.getElementById('image_main_' + leilao_codigo).src = allimagepath + "SOLD_btn.png";
						}
					} else {
						if (f < firstimage_bold) {
							document.getElementById('image_main_' + leilao_codigo).src = allimagepath + "SOLD_btn.png";
						} else {
							document.getElementById('image_main_' + leilao_codigo).src = allimagepath + "SOLD_btn2.png";
						}
					}
				} else if (pausestatus == 1) {
					document.getElementById('counter_index_page_' + leilao_codigo).innerHTML = 'Pause';
					if ($('.history_auctionid').length) {
						if (document.getElementById('history_auctionid').innerHTML == leilao_codigo) {
							document.getElementById('image_main_' + leilao_codigo).src = allimagepath + "BIG_BID_btn.png";
						} else {
							document.getElementById('image_main_' + leilao_codigo).src = allimagepath + "BID_btn.png";
						}
					} else {
						if (f < firstimage_bold) {
							document.getElementById('image_main_' + leilao_codigo).src = allimagepath + "BID_btn.png";
						} else {
							document.getElementById('image_main_' + leilao_codigo).src = allimagepath + "BID_btn2.png";
						}
					}
					document.getElementById('image_main_' + leilao_codigo).onclick = "";
					document.getElementById('image_main_' + leilao_codigo).onmouseover = "";
					document.getElementById('image_main_' + leilao_codigo).name = "";
					document.getElementById('image_main_' + leilao_codigo).onmouseout = "";
				} else {
					if (leilao_cronometro < 10) {
						document.getElementById('counter_index_page_' + leilao_codigo).style.color = '#E80000';
						document.getElementById('counter_index_page_' + leilao_codigo).innerHTML = calc_counter_from_time(leilao_cronometro);
					} else {
						document.getElementById('counter_index_page_' + leilao_codigo).style.color = '#E39717';
						document.getElementById('counter_index_page_' + leilao_codigo).innerHTML = calc_counter_from_time(leilao_cronometro);
					}
				}
			}
			f++;
		}
	  );
			
	}
}
