
function atualizaHoraServidor() {

    var dia = digital.getDate();
    var mes = digital.getMonth();
    var ano = digital.getFullYear();
    var horas = digital.getHours();
    var minutos = digital.getMinutes();
    var segundos = digital.getSeconds();

    // aumenta 1 segundo
    digital.setSeconds(segundos + 1);

    // acrescento zero
    if (dia <= 9) dia = "0" + dia;
    if (mes <= 9) mes = "0" + mes;
    if (mes == 0) mes = "0" + mes;
    if (horas <= 9) horas = "0" + horas;
    if (minutos <= 9) minutos = "0" + minutos;
    if (segundos <= 9) segundos = "0" + segundos;

    dispTime = dia + "/" + mes + "/" + ano + " " + horas + ":" + minutos + ":" + segundos;
    $('#horarioServidor .horarioRelogio').text(dispTime);
    setTimeout("atualizaHoraServidor()", 1000); // chamo a função a cada 1 segundo

}

function validaEmail(email){
	er = /^[a-zA-Z0-9][a-zA-Z0-9\._-]+@([a-zA-Z0-9\._-]+\.)[a-zA-Z-0-9]{2}/;
	return er.exec(email);
}

function substituir_caracteres(src,v_atual,v_substituir){
	var novo_valor = src.value.replace(v_atual,v_substituir);
	src.value = novo_valor;
}

function validaCPF(cpf) {

	cpf = cpf.toString().replace( "-", "" );
	cpf = cpf.toString().replace( ".", "" );
	cpf = cpf.toString().replace( ".", "" );

	if(cpf.length != 11 || cpf == "00000000000" || cpf == "11111111111" ||
	cpf == "22222222222" || cpf == "33333333333" || cpf == "44444444444" ||
	cpf == "55555555555" || cpf == "66666666666" || cpf == "77777777777" ||
	cpf == "88888888888" || cpf == "99999999999"){
		return false;
	}

	soma = 0;
	for(i = 0; i < 9; i++)
	soma += parseInt(cpf.charAt(i)) * (10 - i);
	resto = 11 - (soma % 11);
	if(resto == 10 || resto == 11)
	resto = 0;
	if(resto != parseInt(cpf.charAt(9))){
		return false;
	}
	soma = 0;
	for(i = 0; i < 10; i ++)
	soma += parseInt(cpf.charAt(i)) * (11 - i);
	resto = 11 - (soma % 11);
	if(resto == 10 || resto == 11)
	resto = 0;
	if(resto != parseInt(cpf.charAt(10))){
		return false;
	}
	return true;
}

function mascaraTexto(objForm, strField, sMask, evtKeyPress) {
	//alert('1111');
	var i, nCount, sValue, fldLen, mskLen,bolMask, sCod, nTecla;
	if(window.event) { // Internet Explorer
		nTecla = evtKeyPress.keyCode;
	}else{
		nTecla = evtKeyPress.which;
	}
	sValue = objForm[strField].value;

	// Limpa todos os caracteres de formatação que
	// já estiverem no campo.
	sValue = sValue.toString().replace( "-", "" );
	sValue = sValue.toString().replace( "-", "" );
	sValue = sValue.toString().replace( ".", "" );
	sValue = sValue.toString().replace( ".", "" );
	sValue = sValue.toString().replace( "/", "" );
	sValue = sValue.toString().replace( "/", "" );
	sValue = sValue.toString().replace( "(", "" );
	sValue = sValue.toString().replace( "(", "" );
	sValue = sValue.toString().replace( ")", "" );
	sValue = sValue.toString().replace( ")", "" );
	sValue = sValue.toString().replace( " ", "" );
	sValue = sValue.toString().replace( " ", "" );
	fldLen = sValue.length;
	mskLen = sMask.length;

	i = 0;
	nCount = 0;
	sCod = "";
	mskLen = fldLen;

	while (i <= mskLen) {
		bolMask = ((sMask.charAt(i) == "-") || (sMask.charAt(i) == ".")
		|| (sMask.charAt(i) == "/"))
		bolMask = bolMask || ((sMask.charAt(i) == "(") ||
		(sMask.charAt(i) == ")") || (sMask.charAt(i) == " "))

		if (bolMask) {
			sCod += sMask.charAt(i);
			mskLen++; }
			else {
				sCod += sValue.charAt(nCount);
				nCount++;
			}

			i++;
	}

	objForm[strField].value = sCod;

	if (nTecla != 8) return true; // backspace

	if (sMask.charAt(i-1) == "9") { // apenas números...
	    return ((nTecla > 47) && (nTecla < 58)); // números de 0 a 9
    } else { // qualquer caracter...
		return true;
    }

}