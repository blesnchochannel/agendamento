@extends("la.layouts.app")

@section("contentheader_title", "Agendamentos")
@section("contentheader_description", "Listagem de Agendamentos")
@section("section", "Agendamentos")
@section("sub_section", "Listagem")
@section("htmlheader_title", "Listagem de Agendamentos")

@section("headerElems")
@la_access("Events", "create")
<button id="adicionar_agendamento" class="btn btn-success btn-sm pull-right hidden-print nao-imprimir" data-toggle="modal" data-target="#AddModal">Adicionar Agendamento</button>
@endla_access
@endsection

@section("main-content")

@if (count($errors) > 0)
<div class="alert alert-danger hidden-print nao-imprimir">
	<ul>
		@foreach ($errors->all() as $error)
		<li>{{ $error }}</li>
		@endforeach
	</ul>
</div>
@endif

<div class="aplicadores col-lg-4 hidden-print nao-imprimir">
	<label class="hidden-print nao-imprimir">Aplicadores: </label><br>
	<form class="hidden-print nao-imprimir">
		<select class="form-control hidden-print nao-imprimir" name="aplicadores" onchange="showAplicadores(this.value)">
			<option value="">Selecione uma opção</option>
			<option value="all">Todas as agendas</option>
			@foreach( $aplicadores as $aplicador )      
			<option value="{{ $aplicador->id }}" style="background-color: {{ $aplicador->cor }}">{{ $aplicador->nome }}</option>
			@endforeach
		</select>
	</form>
</div>
<br>
<div class="col-lg-12">
	<button type="button" class="btn btn-default printBtn hidden-print">
		<i class="fa fa-print"></i>
		Imprimir
	</button>
	{!! $calendar->calendar() !!}
	{!! $calendar->script() !!}
</div>
<br>
<div class="box box-success col-lg-12 hidden-print nao-imprimir">
	<!--<div class="box-header"></div>-->
	<div class="box-body hidden-print nao-imprimir">
		<table id="example1" class="table table-bordered hidden-print nao-imprimir">
			<thead>
				<tr class="success">
					@foreach( $listing_cols as $col )
					<th>{{ $module->fields[$col]['label'] or ucfirst($col) }}</th>
					@endforeach
					@if($show_actions)
					<th>Ações</th>
					@endif
				</tr>
			</thead>
			<tbody>

			</tbody>
		</table>
	</div>
</div>

@la_access("Events", "create")
<div class="modal fade" id="AddModal" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Adicionar Agendamento</h4>
			</div>
			{!! Form::open(['action' => 'LA\EventsController@store', 'id' => 'event-add-form']) !!}
			<div class="modal-body">
				<div class="box-body">
					@la_form($module)
					
					{{--
						@la_input($module, 'aplicador')
						@la_input($module, 'paciente')
						@la_input($module, 'all_day')
						@la_input($module, 'start_date')
						@la_input($module, 'end_date')
						@la_input($module, 'dow')
						@la_input($module, 'tempo_de_atendimento')
						--}}
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
					{!! Form::submit( 'Enviar', ['class'=>'btn btn-success']) !!}
				</div>
				{!! Form::close() !!}
			</div>
		</div>
	</div>
	@endla_access

	@endsection

	@push('styles')
	<link rel="stylesheet" type="text/css" href="{{ asset('la-assets/plugins/datatables/datatables.min.css') }}"/>
	@endpush

	@push('scripts')
	<script src="{{ asset('la-assets/plugins/datatables/datatables.min.js') }}"></script>
	<script>
		$(function () {
			$("#example1").DataTable({
				processing: true,
				serverSide: true,
				ajax: "{{ url(config('laraadmin.adminRoute') . '/event_dt_ajax') }}",
				language: {
					"sEmptyTable": "Nenhum registro encontrado",
					"sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
					"sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
					"sInfoFiltered": "(Filtrados de _MAX_ registros)",
					"sInfoPostFix": "",
					"sInfoThousands": ".",
					"sLengthMenu": "_MENU_ resultados por página",
					"sLoadingRecords": "Carregando...",
					"sProcessing": "Processando...",
					"sZeroRecords": "Nenhum registro encontrado",
					"sSearch": "Pesquisar",
					"oPaginate": {
						"sNext": "Próximo",
						"sPrevious": "Anterior",
						"sFirst": "Primeiro",
						"sLast": "Último"
					},
					"oAria": {
						"sSortAscending": ": Ordenar colunas de forma ascendente",
						"sSortDescending": ": Ordenar colunas de forma descendente"
					}
				},
				@if($show_actions)
				columnDefs: [ { orderable: false, targets: [-1] }],
				@endif
			});
			$("#event-add-form").validate({
				
			});
		});
	</script>
	<script type="text/javascript">
		$('.printBtn').on('click', function (){
			window.print();
		});
	</script>

	<script>
		function showAplicadores(str) {
			window.location.href = "?q="+str;
		}
	</script>
	<script>
		$( document ).ready(function() {
			document.getElementsByTagName("SELECT")[3].setAttribute("onchange", "buscaPacientes(this.value);");
			document.getElementById('start_date').setAttribute("onchange", "calculaAutomatico();");
			document.getElementById('end_date').setAttribute("onchange", "calculaAutomatico();");
			document.getElementById('dow').setAttribute("onchange", "calculaAutomatico();");
			document.getElementById('dow').options[0].innerHTML = "Segunda";
			document.getElementById('dow').options[1].innerHTML = "Terça";
			document.getElementById('dow').options[2].innerHTML = "Quarta";
			document.getElementById('dow').options[3].innerHTML = "Quinta";
			document.getElementById('dow').options[4].innerHTML = "Sexta";
			document.getElementById('dow').options[5].innerHTML = "Sábado";
			document.getElementById('adicionar_agendamento').setAttribute("onclick", "mascaraDias();");
			
		});
	</script>

	<script>
		
		function mascaraDias(){
			document.getElementById('dow').options[0].innerHTML = "Segunda";
			document.getElementById('dow').options[1].innerHTML = "Terça";
			document.getElementById('dow').options[2].innerHTML = "Quarta";
			document.getElementById('dow').options[3].innerHTML = "Quinta";
			document.getElementById('dow').options[4].innerHTML = "Sexta";
			document.getElementById('dow').options[5].innerHTML = "Sábado";
		}

	</script>

	<script>
		function buscaPacientes(str) {
			if (str=="") {

			}
			if (window.XMLHttpRequest) {
    			// code for IE7+, Firefox, Chrome, Opera, Safari
    			xmlhttp=new XMLHttpRequest();
    		} else { 
  				// code for IE6, IE5
  				xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  			}
  			xmlhttp.onreadystatechange=function() {
  				if (this.readyState==4 && this.status==200) {
  					alertify.alert('ATENÇÃO!', this.responseText);
  				}
  			}
  			xmlhttp.open("GET","{{ url(config('laraadmin.adminRoute') . '/ajaxpacientes2?q=') }}"+str,true);
  			xmlhttp.send();
  		}
  	</script>

  	<script>
  		function calculaAutomatico(){

  			var data_inicial = document.getElementById('start_date').value;
  			var data_final = document.getElementById('end_date').value;
  			var recurrencia = $('#dow').val();

  			function converteData(data){
  				var dateTime = data.split(" ");
  				var date = dateTime[0].split("/");
  				var time = dateTime[1].split(":");
  				var newdate = date.reverse().join(",");
  				var newtime = time.join(":");
  				var novadata = newdate+' '+newtime;
  				return novadata;
  			}

  			function converteSoAHora(data){
  				var dateTime = data.split(" ");
  				var time = dateTime[1].split(":");
  				var newtime = time.join(":");
  				return newtime;
  			}	

  			function diff_hours(dt1, dt2){

  				var diff =(dt2.getTime() - dt1.getTime()) / 1000;
  				diff /= (60 * 60);
  				return diff;
  				//return Math.abs(Math.round(diff));

  			}

  			var hora1 = converteSoAHora(data_inicial);
  			var hora2 = converteSoAHora(data_final);

  			var dt1 = new Date("01/01/2007 " + hora1);
  			var dt2 = new Date("01/01/2007 " + hora2);

  			var total_de_horas = diff_hours(dt1, dt2);

  			function countCertainDays( days, d0, d1 ) {
  				var ndays = 1 + Math.round((d1-d0)/(24*3600*1000));
  				var sum = function(a,b) {
  					return a + Math.floor( ( ndays + (d0.getDay()+6-b) % 7 ) / 7 ); 
  				};
  				return days.reduce(sum,0);
  			}

  			function converteSoAData(data){
  				var dateTime = data.split(" ");
  				var date = dateTime[0].split("/");
  				var newdate = date.reverse().join(",");
  				return newdate;
  			}

  			var sodata1 = converteSoAData(data_inicial);
  			var sodata2 = converteSoAData(data_final);

  			var total_de_dias = countCertainDays(recurrencia,new Date(sodata1),new Date(sodata2));

  			var calculototal = total_de_dias * total_de_horas;

  			var tempo_de_atendimento = document.getElementById('tempo_de_atendimento');

  			tempo_de_atendimento.value = calculototal;
  		}
  	</script>

  	@endpush