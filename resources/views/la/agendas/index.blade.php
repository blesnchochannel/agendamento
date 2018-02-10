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

<div id="demo"></div>

<section class="content">
	<!-- Small boxes (Stat box) -->
	<!-- Main row -->
	<div class="row">
		<section class="col-lg-12 connectedSortable">
			<div class="agenda-calendario">
				<div id="calendarContainer"></div>
				<div id="organizerContainer"></div>
			</div>
		</section>
	</div>
	<div class="row">
		<hr>
	</div>
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
				<!--<div class="box-header"></div>-->
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
</section>

@la_access("Agendas", "create")
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
	@endla_access

	@endsection

	@push('styles')
	<link rel="stylesheet" type="text/css" href="{{ asset('la-assets/plugins/datatables/datatables.min.css') }}"/>
	<link rel="stylesheet" type="text/css" href="{{ asset('la-assets/css/pages/agendas.css') }}"/>
	@endpush

	@push('scripts')
	<script src="{{ asset('la-assets/plugins/datatables/datatables.min.js') }}"></script>
	<!-- agendamentos -->
	<script src="{{ asset('la-assets/js/pages/agendas.js') }}"></script>
	<script>
		"use strict";

			// function that creates dummy data for demonstration
			function createDummyData() {
				var date = new Date();
				var data = {};

				for (var i = 0; i < 10; i++) {
					data[date.getFullYear() + i] = {};

					for (var j = 0; j < 12; j++) {
						data[date.getFullYear() + i][j + 1] = {};

						for (var k = 0; k < Math.ceil(Math.random() * 10); k++) {
							var l = Math.ceil(Math.random() * 28);

							try {
								data[date.getFullYear() + i][j + 1][l].push({
									startTime: "10:00",
									endTime: "12:00",
									text: "Some Event Here"
								});
							} catch (e) {
								data[date.getFullYear() + i][j + 1][l] = [];
								data[date.getFullYear() + i][j + 1][l].push({
									startTime: "10:00",
									endTime: "12:00",
									text: "Some Event Here"
								});
							}
						}
					}
				}

				return data;
			}

			// INSTEAD OF GRABBING THE DATA FROM AN AJAX REQUEST
			// I WILL BE DEMONSTRATING THE SAME EFFECT THROUGH MEMORY
			// THIS DEFEATS THE PURPOSE BUT IS SIMPLER TO UNDERSTAND
			var serverData = createDummyData();

			// stating variables in order for them to be global
			var calendar, organizer;

			// initializing a new calendar object, that will use an html container to create itself
			calendar = new Calendar("calendarContainer", // id of html container for calendar
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

			// This is gonna be similar to an ajax function that would grab
			// data from the server; then when the data for a this current month
			// is grabbed, you just add it to the data object of the form
			// { year num: { month num: { day num: [ array of events ] } } }
			function dataWithAjax(date, callback) {
				var data = {};

				try {
					data[date.getFullYear()] = {};
					data[date.getFullYear()][date.getMonth() + 1] = serverData[date.getFullYear()][date.getMonth() + 1];
				} catch (e) {}

				callback(data);
			};

			window.onload = function() {
				dataWithAjax(new Date(), function(data) {
					// initializing a new organizer object, that will use an html container to create itself
					organizer = new Organizer("organizerContainer", // id of html container for calendar
						calendar, // defining the calendar that the organizer is related
						data // small part of the data of type object
						);

					// after initializing the organizer, we need to initialize the onMonthChange
					// there needs to be a callback parameter, this is what updates the organizer
					organizer.onMonthChange = function(callback) {
						dataWithAjax(organizer.calendar.date, function(data) {
							organizer.data = data;
							callback();
						});
					};
				});
			};
		</script>
		<script>
			$(function () {
				$("#example1").DataTable({
					processing: true,
					serverSide: true,
					ajax: "{{ url(config('laraadmin.adminRoute') . '/agenda_dt_ajax') }}",
					language: {
						lengthMenu: "_MENU_",
						search: "_INPUT_",
						searchPlaceholder: "Procurar"
					},
					@if($show_actions)
					columnDefs: [ { orderable: false, targets: [-1] }],
					@endif
				});
				$("#agenda-add-form").validate({

				});
			});
		</script>
		<script>

			var xmlhttp = new XMLHttpRequest();

			xmlhttp.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					myObj = JSON.parse(this.responseText);
					document.getElementById("demo").innerHTML = myObj.data;
				}
			};
			xmlhttp.open("GET", "{{ url(config('laraadmin.adminRoute') . '/agenda_dados') }}", true);
			xmlhttp.send();

		</script>
		@endpush
