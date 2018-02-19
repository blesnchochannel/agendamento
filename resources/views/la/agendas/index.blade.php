@extends("la.layouts.app")

@section("contentheader_title", "Agendas")
@section("contentheader_description", "Listagem de Agendas")
@section("section", "Agendas")
@section("sub_section", "Listagem")
@section("htmlheader_title", "Listadem de Agendas")

@section("headerElems")
@la_access("Agendas", "create")
<button class="btn btn-success btn-sm pull-right" data-toggle="modal" data-target="#AddModal">Adicionar Agenda</button>
@endla_access
@endsection

@section("main-content")

<div></div>

<div id="demo"></div>

<section class="content">
	<!-- Small boxes (Stat box) -->
	<!-- Main row -->
	<div class="row">
		<section class="col-lg-12 connectedSortable">

			<div id='calendar'></div>

			<!--<div class="agenda-calendario">
				<div id="calendarContainer"></div>
				<div id="organizerContainer"></div>
			</div>-->
		</section>
	</div>
	<div class="row">
		<hr>
	</div>
	<!--
	<div class="row">
		<section class="col-lg-12 connectedSortable">
			@if (count($errors) > 0)
			<div class="alert alert-danger">
				<ul>
					@foreach ($errors->all() as $error)
					<li>{{ $error }}</li>
					@endforeach
				</ul>
			</div>
			@endif

			<div class="box box-success">
				<div class="box-body">
					<table id="example1" class="table table-bordered">
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
		</section>
	</div>
-->
</section>

@la_access("Agendas", "create")
<!--
<div class="modal fade" id="AddModal" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Adicionar Agenda</h4>
			</div>
			{!! Form::open(['action' => 'LA\AgendasController@store', 'id' => 'agenda-add-form']) !!}
			<div class="modal-body">
				<div class="box-body">
					@la_form($module)

					{{--
						@la_input($module, 'nome')
						@la_input($module, 'aplicador')
						@la_input($module, 'agendamentos')
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
-->
@endla_access

@endsection

@push('styles')
	<!--
	<link rel="stylesheet" type="text/css" href="{{ asset('la-assets/plugins/datatables/datatables.min.css') }}"/>
-->
<link rel="stylesheet" type="text/css" href="{{ asset('la-assets/css/pages/agendas.css') }}"/>
@endpush

@push('scripts')
	<!--
	<script src="{{ asset('la-assets/plugins/datatables/datatables.min.js') }}"></script>
-->
<!-- agendamentos -->
<script src="{{ asset('la-assets/js/pages/agendas.js') }}"></script>
<script>

	$(document).ready(function() {
		var initialLocaleCode = 'pt-br';

		$('#calendar').fullCalendar({
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,agendaWeek,agendaDay,listMonth'
			},
			defaultDate: '2018-02-12',
			locale: initialLocaleCode,
      buttonIcons: false, // show the prev/next text
      weekNumbers: true,
      navLinks: true, // can click day/week names to navigate views
      editable: true,
      eventLimit: true, // allow "more" link when too many events
      events: "{{ url(config('laraadmin.adminRoute') . '/agenda_dados') }}",
      /*events: [
      {
      	title: 'All Day Event',
      	start: '2018-02-01'
      },
      {
      	title: 'Long Event',
      	start: '2018-02-07',
      	end: '2018-02-10'
      },
      {
      	id: 999,
      	title: 'Repeating Event',
      	start: '2018-02-09T16:00:00'
      },
      {
      	id: 999,
      	title: 'Repeating Event',
      	start: '2018-02-16T16:00:00'
      },
      {
      	title: 'Conference',
      	start: '2018-02-11',
      	end: '2018-02-13'
      },
      {
      	title: 'Meeting',
      	start: '2018-02-12T10:30:00',
      	end: '2018-02-12T12:30:00'
      },
      {
      	title: 'Lunch',
      	start: '2018-02-12T12:00:00'
      },
      {
      	title: 'Meeting',
      	start: '2018-02-12T14:30:00'
      },
      {
      	title: 'Happy Hour',
      	start: '2018-02-12T17:30:00'
      },
      {
      	title: 'Dinner',
      	start: '2018-02-12T20:00:00'
      },
      {
      	title: 'Birthday Party',
      	start: '2018-02-13T07:00:00'
      },
      {
      	title: 'Click for Google',
      	url: 'http://google.com/',
      	start: '2018-02-28'
      }
      ]*/
  });

    // build the locale selector's options
    $.each($.fullCalendar.locales, function(localeCode) {
    	$('#locale-selector').append(
    		$('<option/>')
    		.attr('value', localeCode)
    		.prop('selected', localeCode == initialLocaleCode)
    		.text(localeCode)
    		);
    });

    // when the selected option changes, dynamically change the calendar option
    $('#locale-selector').on('change', function() {
    	if (this.value) {
    		$('#calendar').fullCalendar('option', 'locale', this.value);
    	}
    });
});

</script>

	<!--
	<script>
		"use strict";

		var myjson;
		var dados = {};
		var myObjData = "";
		var date = new Date();
		var data;

		$(document).ready(function (e) {

			/*$.ajax({
				url: "{{ url(config('laraadmin.adminRoute') . '/agenda_dados') }}",
				type: "GET",
				data: "data",
				async: false,
				success: function (data) {
					loadDados(data);
				}
			});*/

			$.get("{{ url(config('laraadmin.adminRoute') . '/agenda_dados') }}", function(data, status){
				if (status === "success"){
					loadDados(data);
				}				
			});

			//$.getJSON("{{ url(config('laraadmin.adminRoute') . '/agenda_dados') }}", loadDados);

		});
		
		function loadDados(data){

			myjson = data;
			
			var a = "";
			var b = "";
			var c = "";
			var d = "";
			var e = "";
			var i = 0;
			var j = 0;
			var k = 0;
			var inicio = [];
			var fim = [];
			var ano = [];
			var mes = [];
			var dia = [];
			var aplicador = [];
			var paciente = [];
			var datas = [];			

			for (i = 0; i < myjson.data.length; i++) {

				for (j = 0; j < myjson.data[i].length; j++) {

					if (myjson.data[i][j] == myjson.data[i][1]){
						c = new Date(myjson.data[i][j]);
						ano.push(c.getFullYear());
						mes.push(c.getMonth()+1);
						dia.push(c.getDate()+1);	
					}

					if (myjson.data[i][j] == myjson.data[i][2]){
						a = myjson.data[i][j];
						a = a.substr(0, 5);
						inicio.push(a);
					}

					if (myjson.data[i][j] == myjson.data[i][3]){
						b = myjson.data[i][j];
						b = b.substr(0, 5);
						fim.push(b);
					}

					if (myjson.data[i][j] == myjson.data[i][4]){
						d = myjson.data[i][j];
						aplicador.push(d);
					}

					if (myjson.data[i][j] == myjson.data[i][5]){
						e = myjson.data[i][j];
						paciente.push(e);
					}

				}

			}

			for (var i = 0; i < 10; i++) {
				dados[date.getFullYear() + i] = {};					

				for (var j = 0; j < 12; j++) {
					dados[date.getFullYear() + i][j + 1] = {};					
				}
			}

			for (var k = 0; k < ano.length; k++) {

				try {
					dados[ano[k]][mes[k]][dia[k]].push({
						startTime: [inicio[k]],
						endTime: [fim[k]],
						text: ["Aplicador: " + aplicador[k] + " Paciente: " + paciente[k]]
					});
				} catch (e) {
					dados[ano[k]][mes[k]][dia[k]] = [];
					dados[ano[k]][mes[k]][dia[k]].push({
						startTime: [inicio[k]],
						endTime: [fim[k]],
						text: ["Aplicador: " + aplicador[k] + " Paciente: " + paciente[k]]
					});
				}
			}

			function createDummyData(dados) {

				return dados;
			}

			data = createDummyData(dados);

			// initializing a new calendar object, that will use an html container to create itself
			var calendar = new Calendar("calendarContainer", // id of html container for calendar
				"small", // size of calendar, can be small | medium | large
				[
					"Domingo", // left most day of calendar labels
					3 // maximum length of the calendar labels
					],
					[
					"#10cfbd", // primary color
					"#0eb7a7", // primary dark color
					"#ffffff", // text color
					"#3cf0df" // text dark color
					]
					);

		// initializing a new organizer object, that will use an html container to create itself
			var organizer = new Organizer("organizerContainer", // id of html container for calendar
				calendar, // defining the calendar that the organizer is related to
				data // giving the organizer the static data that should be displayed
				);

			
		}

	</script>

	<script>
		$(function () {
			$("#example1").DataTable({
				processing: true,
				serverSide: true,
				ajax: "{{ url(config('laraadmin.adminRoute') . '/agenda_dt_ajax') }}",
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
			$("#agenda-add-form").validate({

			});
		});
	</script>
-->			
@endpush
