$(document).ready(function() {

	$('.login_button').click(function(){

		var errors = '';

		if($('#frm_login input[name="login"]').val() == ''){
			errors += 'Login n�o foi preenchido\n';
		}

		if($('#frm_login input[name="senha"]').val() == ''){
			errors += 'Senha n�o foi preenchida';
		}

		if(errors == ''){
			$('#frm_login').submit();
		}else{
			alert(errors);
		}


	});

	$('.login_button_interna').click(function(){

		$('.error').text('');

		if($('#frm_login_interna input[name="login"]').val() == ''){
			$('#frm_login_interna input[name="login"]').after("<div class='error'>Login n�o foi preenchido</div>");
		}

		if($('#frm_login_interna input[name="senha"]').val() == ''){
			$('#frm_login_interna input[name="senha"]').after("<div class='error'>Senha n�o foi preenchida</div>");
		}

		if($('.error').text() == ''){
			$('#frm_login_interna').submit();
		}



	});

	

});


function abreMenuLogin(){
    $('#menuLoginAjax').show();
    $('#frm_login input[name="username"]').focus();
}

function fechaMenuLogin(){
    $('#menuLoginAjax').hide();
}




