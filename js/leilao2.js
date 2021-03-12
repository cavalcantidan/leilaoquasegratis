
function inserirLance(id_leilao){
    var campo_lance = $('#menuLogin #menuLogado .lance .atual');
    if (campo_lance.text() <= 0) {
        alert('Seu saldo terminou, adquira mais e continue participando!');
    } else {
        $.ajax({
	        url: 'getbid.php',
	        dataType: 'json',
	        type: 'POST',
	        data: 'aid=' + id_leilao,
	        global: false,
	        success: function (data) {
                $.each(data, function (j, item) {
                    if (item.resultado == 'sucesso') {
                        campo_lance.text(item.total_lances);
                    } else {
                        alert(item.motivo);
                    }
                });
            }
        });
    }
}

function atualizaLeilao(){
	var leiloes = '';

	$.ajaxSetup({ cache: false });
	$('.itemLeiao').each(function () {
		var auctionId = $(this).attr('title');
		if (leiloes != '') leiloes = leiloes + ',';
		leiloes = leiloes + auctionId;
	});

	if(leiloes){
	    $.ajax({
	        url: 'update_information.php',
	        dataType: 'json',
	        type: 'POST',
	        data: 'leiloes=' + leiloes,
	        global: false,
	        success: function (data) {
	            var id_usuario = parseInt($('#idUsuario').text());
	            $.each(data, function (j, item) {

	                var leilao_id = item.leilao.id_leilao;
	                var leilao_cronometro = item.leilao.tempo_leilao;
	                var leilao_jogador_id = item.leilao.id_pessoa;
	                var leilao_jogador_nome = item.leilao.usuario;
	                var leilao_preco = "R$ " + item.leilao.preco;

	                //alert(leilao_cronometro);
	                var campo_preco = $('#leilao_' + leilao_id + ' #Valor');
	                var campo_cronometro = $('#leilao_' + leilao_id + ' #Contagem');
	                var campo_data = $('#leilao_' + leilao_id + ' .areaTempo');
	                var campo_jogador_nome = $('#leilao_' + leilao_id + ' #usuario');
	                var campo_jogador_nome_a = $('#leilao_' + leilao_id + ' #usuario a');
	                var campo_btn_lance = $('#leilao_' + leilao_id + ' .btnLance');
	                var campo_btn_lance_a = $('#leilao_' + leilao_id + ' .btnLance a');
	                var campo_btn_lance_esp_a = $('#leilao_' + leilao_id + ' .espacamento .btnLance a');
	                var campo_btn_lance_fut_a = $('#leilao_' + leilao_id + '.itemLeilaoFuturo .btnLance a');

	                // alterando na tela
	                campo_jogador_nome_a.text(leilao_jogador_nome); // nome jogador ultimo lance

	                // alterando botao de lance
	                if (id_usuario == leilao_jogador_id && id_usuario != NaN) {
	                    campo_btn_lance_a.attr('style', 'background-image:none;left:-20px;position:relative;');
	                    campo_btn_lance_fut_a.attr('style', 'background-image:none;top:5px;left:-25px;position:relative;');
	                    campo_btn_lance_a.html("<img src='" + base_url + "/img/layout/voce-esta-vencendo.png'>");
	                    campo_btn_lance_esp_a.attr('style', 'margin-left:-10px;background:none;');
	                    campo_btn_lance_esp_a.html("<img src='" + base_url + "/img/layout/voce-esta-vencendo-pequeno.png'>");
	                } else {
	                    campo_btn_lance_a.removeAttr('style', 'background-image:none;left:-20px;position:relative;');
	                    campo_btn_lance_a.attr('style', 'cursor:pointer');
	                    campo_btn_lance_a.css('visibility', 'visible');
	                    campo_btn_lance_a.html('');
	                }

	                //alert(campo_preco.text());

	                if (campo_preco.text() != leilao_preco) {
	                    campo_preco.fadeIn().animate({ 'backgroundColor': 'red' }, 500);
	                    campo_preco.text(leilao_preco);         // novo preco
	                    atualizaLista(leilao_id);
	                } else {
	                    campo_preco.css('background-color', '');
	                }


	                //alert("ID_Leilão:" + leilao_id + "Tempo:" + leilao_cronometro);

	                if (leilao_cronometro > 0) {

	                    var horas = Math.floor(leilao_cronometro / 3600) % 24;
	                    var minutos = Math.floor(leilao_cronometro / 60) % 60;
	                    var segundos = Math.floor(leilao_cronometro % 60);

	                    if (horas < 10) horas = "0" + horas;
	                    if (minutos < 10) minutos = "0" + minutos;
	                    if (segundos < 10) segundos = "0" + segundos;

	                    var hora_exibe = horas + ":" + minutos + ":" + segundos;

	                    if (leilao_cronometro <= 5) {
	                        campo_cronometro.attr('style', 'color:#FF0000');
	                    } else {
	                        campo_cronometro.removeAttr('style', 'color:#FF0000');
	                    }
	                    if (hora_exibe != campo_cronometro.text()) {
	                        //alert(hora_exibe + ' :: ' + campo_cronometro.text());
	                        campo_data.css('visibility', 'hidden');
	                        campo_cronometro.text(hora_exibe);
	                    }

	                }

	                if (leilao_cronometro == 0) {
	                    campo_btn_lance.css('visibility', 'hidden');
	                    campo_data.css('visibility', 'hidden');
	                    campo_cronometro.text("Finalizado");
	                }

	            });
	        }, error: function (XMLHttpRequest, textStatus, errorThrown) {
	            //				alert(XMLHttpRequest);
	            //				alert(textStatus);
	            //				alert(errorThrown);
	        }
	    });           // fim ajax
    } // fim if
	setTimeout('atualizaLeilao()',500);
}

function atualizaLista(id_leilao) {
    if (id_leilao) {
        $.ajax({
            url: 'updatehistory.php',
            dataType: 'json',
            type: 'POST',
            data: 'id_leilao=' + id_leilao,
            global: false,
            success: function (data) {
                for (i = 0; i < data.histories.length; i++) {
                    biddingprice = data.histories[i].history.bprice;
                    biddingusername = data.histories[i].history.username;
                    biddingtime = data.histories[i].history.time;
                    
                    document.getElementById('bid_price_' + i).innerHTML = "R$" + biddingprice;
                    document.getElementById('bid_user_name_' + i).innerHTML = biddingusername;
                    document.getElementById('bid_time_' + i).innerHTML = biddingtime;
                }
                if (data.myhistories.length) {
                    for (j = 0; j < data.myhistories.length; j++) {
                        biddingprice1 = data.myhistories[j].myhistory.bprice;
                        biddingusername1 = data.myhistories[j].myhistory.time;

                        document.getElementById('my_bid_price_' + j).innerHTML = "R$ " + biddingprice1;
                        document.getElementById('my_bid_time_' + j).innerHTML = biddingusername1;
                    }
                }

            }, error: function (XMLHttpRequest, textStatus, errorThrown) {
                //				alert(XMLHttpRequest);
                //				alert(textStatus);
                //				alert(errorThrown);
            }
        });          // fim ajax
    } // fim if
}

$(document).ready(function () {
    atualizaLeilao();
});