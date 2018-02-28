<!-- REQUIRED JS SCRIPTS -->

<!-- jQuery 2.1.4 -->
<!--<script src="{{ asset('la-assets/plugins/jQuery/jQuery-2.1.4.min.js') }}"></script>-->
<!-- Bootstrap 3.3.2 JS -->
<script src="{{ asset('la-assets/js/bootstrap.min.js') }}" type="text/javascript"></script>

<!-- jquery.validate + select2 -->
<script src="{{ asset('la-assets/plugins/jquery-validation/jquery.validate.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('la-assets/plugins/select2/select2.full.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('la-assets/plugins/bootstrap-datetimepicker/moment-with-locales.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('la-assets/plugins/bootstrap-datetimepicker/bootstrap-datetimepicker.js') }}" type="text/javascript"></script>

<!-- AdminLTE App -->
<script src="{{ asset('la-assets/js/app.min.js') }}" type="text/javascript"></script>

<script src="{{ asset('la-assets/plugins/stickytabs/jquery.stickytabs.js') }}" type="text/javascript"></script>
<script src="{{ asset('la-assets/plugins/slimScroll/jquery.slimscroll.min.js') }}" type="text/javascript"></script>

<script src="{{ asset('/la-assets/js/bootstrap-colorpicker.min.js') }}"></script>

<script src="{{ asset('/la-assets/js/moment.min.js') }}"></script>

<script src="{{ asset('/la-assets/js/fullcalendar.min.js') }}"></script>

<script src="{{ asset('/la-assets/js/fullcalendar-locale-all.js') }}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js"></script>


<!-- JavaScript -->
<script src="//cdn.jsdelivr.net/npm/alertifyjs@1.11.0/build/alertify.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.13/jquery.mask.min.js"></script>

<script type="text/javascript">
	function confirmacao(){
		alertify.confirm('Excluindo...', 'Tem certeza que deseja excluir?', function(){ alertify.success('Sim') }
			, function(){ alertify.error('Não')});
	};
</script>

<script>
	$(function () {
		$('.consultoria').mask('00000/0000');
		$('.data').mask('00/00/0000');
		$('.start_date').mask('00/00/0000 00:00');
		$('.end_date').mask('00/00/0000 00:00');
		$('.tempo').mask('00:00:00');
		$('.data_tempo').mask('00/00/0000 00:00:00');
		$('.cep').mask('00000-000');
		$('.telefone').mask('(00) 0000-0000');
		var CelularMaskBehavior = function (val) {
			return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00000';
		},
		celularOptions = {
			onKeyPress: function (val, e, field, options) {
				field.mask(CelularMaskBehavior.apply({}, arguments), options);
			}
		};

		$('.celular').mask(CelularMaskBehavior, celularOptions);
		$('.cnpj').mask('00.000.000/0000-00', {reverse: true});
		$('.cpf').mask('000.000.000-00', {reverse: true});
		$('.dinheiro').mask('#.##0,00', {reverse: true});
	});
</script>

<script type="text/javascript" >
	$(document).ready(function () {
		$(".semnumeros").keyup(function () {
			this.value = this.value.replace(/[^A-Za-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ ]/g, '');
		});
	});
</script>

<script type="text/javascript" >

	function limpa_formulário_cep() {
                //Limpa valores do formulário de cep.
                document.getElementById('rua').value = ("");
                document.getElementById('bairro').value = ("");
                document.getElementById('cidade').value = ("");
                document.getElementById('estado').value = ("");
            }

            function meu_callback(conteudo) {
            	if (!("erro" in conteudo)) {
                    //Atualiza os campos com os valores.
                    document.getElementById('rua').value = (conteudo.logradouro);
                    document.getElementById('bairro').value = (conteudo.bairro);
                    document.getElementById('cidade').value = (conteudo.localidade);
                    document.getElementById('estado').value = (conteudo.uf);
                } //end if.
                else {
                    //CEP não Encontrado.
                    limpa_formulário_cep();
                    alert("CEP não encontrado.");
                }
            }

            function pesquisacep(valor) {

                //Nova variável "cep" somente com dígitos.
                var cep = valor.replace(/\D/g, '');

                //Verifica se campo cep possui valor informado.
                if (cep != "") {

                    //Expressão regular para validar o CEP.
                    var validacep = /^[0-9]{8}$/;

                    //Valida o formato do CEP.
                    if (validacep.test(cep)) {

                        //Preenche os campos com "..." enquanto consulta webservice.
                        document.getElementById('rua').value = "...";
                        document.getElementById('bairro').value = "...";
                        document.getElementById('cidade').value = "...";
                        document.getElementById('estado').value = "...";

                        //Cria um elemento javascript.
                        var script = document.createElement('script');

                        //Sincroniza com o callback.
                        script.src = '//viacep.com.br/ws/' + cep + '/json/?callback=meu_callback';

                        //Insere script no documento e carrega o conteúdo.
                        document.body.appendChild(script);

                    } //end if.
                    else {
                        //cep é inválido.
                        limpa_formulário_cep();
                        alert("Formato de CEP inválido.");
                    }
                } //end if.
                else {
                    //cep sem valor, limpa formulário.
                    limpa_formulário_cep();
                }
            }
            ;

        </script>

<!-- Optionally, you can add Slimscroll and FastClick plugins.
      Both of these plugins are recommended to enhance the
      user experience. Slimscroll is required when using the
      fixed layout. -->

      @stack('scripts')