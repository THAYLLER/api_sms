
// Use jQuery com a variavel $j(...)
$(document).ready(function(){
	$('#mensagem_camp').keyup(function() {
		var len = this.value.length;
		if (len == 160) { //VERIFICA SE TEM MAIS DE 350 CARACTERES
			this.value = this.value.substring(0, 160);
		}
		$('#resta').text(160 - len); //EXIBE OS CARACTERES RESTANTES
	});
	$('#mensagem_encerrado').keyup(function() {
		var len = this.value.length;
		if (len == 160) { //VERIFICA SE TEM MAIS DE 350 CARACTERES
			this.value = this.value.substring(0, 160);
		}
		$('#resta2').text(160 - len); //EXIBE OS CARACTERES RESTANTES
	});
});
function cancelar(idSms){
	$.post("acoes_sms.php",{ acao: 'altera_status', idSms:idSms},function(response) {
		console.log(response);
		var retorno = response.split(";");
		 if (retorno[0]!='erro') {
		 	location.reload();
		 }
	});
}
function baixar(){
	$.post("acoes_sms.php",{ acao: 'dar_baixa', campanha:$("#campanha").val(),idCupom:$("#idCupom").val()},function(response) {
		console.log(response);
		var retorno = response.split(";");
		 if (retorno[0]!='erro') {
		 	location.reload();
		 }
	});
}
$(document).ready(function(){ 
      /*########VALIDAÇÃO PERSONALIZADA########*/
      $('#frm').submit(function(event){
           var cont = 0;
            event.preventDefault();
            console.log($(".usuario").val().length);
            if($(".cpf").val().length === 0 && ($(".usuario").val().length == 0 && $(".senha").val().length === 0 )){
            	$(".senha").css("background-color","#f2dede");
                $(".senha").css("border","2px solid red"); 
                $(".senha").focus();

                $(".cpf").css("background-color","#f2dede");
                $(".cpf").css("border","2px solid red");

                $(".usuario").css("background-color","#f2dede");
                $(".usuario").css("border","2px solid red");
                cont = -2;

                return false;
            }
            if(cont != -1 || cont != -2){  $(this).unbind('submit').submit(); this.submit(); }
      });
     
});
/*
Function: Calendário Data
Descrição: Usado para mostrar um calendário e selecionar a data
*/
$(function() {
	$.datepicker.regional['pt-BR'] = {
		closeText: 'Fechar',
		prevText: '&#x3c;Anterior',
		nextText: 'Pr&oacute;ximo&#x3e;',
		currentText: 'Hoje',
		monthNames: ['Janeiro','Fevereiro','Mar&ccedil;o','Abril','Maio','Junho',
		'Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
		monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun',
		'Jul','Ago','Set','Out','Nov','Dez'],
		dayNames: ['Domingo','Segunda-feira','Ter&ccedil;a-feira','Quarta-feira','Quinta-feira','Sexta-feira','S&aacute;bado'],
		dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','S&aacute;b'],
		dayNamesMin: ['Dom','Seg','Ter','Qua','Qui','Sex','S&aacute;b'],
		weekHeader: 'Sm',
		dateFormat: 'dd/mm/yy',
		firstDay: 0,
		isRTL: false,
		showMonthAfterYear: false,
		yearSuffix: ''
	};
	$.datepicker.setDefaults($.datepicker.regional['pt-BR']);
	$(".data" ).datepicker();
	$(".data" ).datepicker( "option", $.datepicker.regional["pt-BR"] );

	$(".data" ).datepicker( "option", "dateFormat", 'dd/mm/yy' );
	$(".data" ).datepicker( "option", "monthNames", ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'] );
	$(".data" ).datepicker( "option", "dayNamesMin", ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'] );
});
/*
	Function: Campos formatados
	Descrição: Formata qualquer campo
*/
	$(document).ready( function() {
		// mask
		$.mask.definitions['~']='[+-]';
		$(".data").mask("99/99/9999");
		$(".horario").mask("99:99");
		$(".hora").mask("99:99:99");
		$(".dtHr").mask("99/99/9999 99:99");
		$(".ddmm").mask("99/99");
		$(".telefone").mask("(99)9999-9999");
		$(".cpf").mask("999.999.999-99");
		$(".cnpj").mask("99.999.999/9999-99");
		$('.numero').numeric(",");
		/*$('.peso').numeric(",");
		$('.peso').floatnumber(",",3);*/
		$('.preco').numeric(",");
		$('.preco').floatnumber(",",2);
		$(".peso").maskMoney({thousands:'.', decimal:',', defaultZero: true, precision:3});
		$(".real").maskMoney({symbol:'R$ ', showSymbol:false, thousands:'.', decimal:',', symbolStay: false, defaultZero: true});
		$('.celular').focusout(function(){
			var phone, element;
			element = $(this);
			element.unmask();
			phone = element.val().replace(/\D/g, '');
			if(phone.length > 10) {
				element.mask("(99)99999-999?9");
			} else {
				element.mask("(99)9999-9999?9");
			}
		}).trigger('focusout');
	});
