
	//**********************************************************************************
			//**********  IGOR A. BRANDÃO 2016 ©
			//**********
			//**********  PGM: KMS - Karate Management System
			//**********
			//**********  CLIENTE:	AKC - Associação Karate Cidadão
			//**********
			//**********  IGOR AUGUSTO BRANDÃO
			//**********  VERSÃO:	1.0
			//**********
			//**********  JUN/2016 - Criação
			//**********
	//**********************************************************************************

	/** Function to apply custom mask to form fields
	 *
	 * @return => void
	*/
	function applyCustomMasks()
	{
		$('.date').mask('00/00/0000');
		$('.time').mask('00:00:00');
		$('.date_time').mask('00/00/0000 00:00:00');
		$('.cep').mask('00000-000');
		$('.phone').mask('0000-0000');
		$('.phone_with_ddd').mask('(00) 0000-0000');
		$('.phone_us').mask('(000) 000-0000');
		$('.mixed').mask('AAA 000-S0S');
		$('[name="CPF"]').mask('999.999.999-99');
		$('.cnpj').mask('00.000.000/0000-00', {reverse: true});
		$('.money').mask('000.000.000.000.000,00', {reverse: true});
		$('.money2').mask("#.##0,00", {reverse: true});
		$('.ip_address').mask('0ZZ.0ZZ.0ZZ.0ZZ', {
		translation: {
		  'Z': {
		    pattern: /[0-9]/, optional: true
		  }
		}
		});
		$('.ip_address').mask('099.099.099.099');
		$('.percent').mask('##0,00%', {reverse: true});
		$('.clear-if-not-match').mask("00/00/0000", {clearIfNotMatch: true});
		$('.placeholder').mask("00/00/0000", {placeholder: "__/__/____"});
		$('.fallback').mask("00r00r0000", {
		  translation: {
		    'r': {
		      pattern: /[\/]/,
		      fallback: '/'
		    },
		    placeholder: "__/__/____"
		  }
		});
		$('.selectonfocus').mask("00/00/0000", {selectOnFocus: true});
	}