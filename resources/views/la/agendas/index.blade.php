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

<div id="demo2"></div>
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

				var xmlhttp = new XMLHttpRequest();
				xmlhttp.onreadystatechange = function() {
					if (this.readyState == 4 && this.status == 200) {
						var myObj, i, j, data = "";
						var myObjData;

						myObj = JSON.parse(this.responseText);
						for (i = 0; i < myObj.data.length; i++) {
							for (j = 0; j < myObj.data[i].length; j++) {

								/*if (myObj.data[i][j] == myObj.data[i][2]){
									var aplicador = myObj.data[i][j];
								}

								if (myObj.data[i][j] == myObj.data[i][3]){
									var paciente = myObj.data[i][j];
								}*/

								if (myObj.data[i][j] == myObj.data[i][1]){
									var a = new Date(myObj.data[i][j]);
									var ano = a.getFullYear();
									var mes = a.getMonth();
									var dia = a.getDate();
									var hora = a.getHours();
									var minutos = a.getMinutes();								

									data = {
										[ano]: {
											[mes]: {
												[dia]: [
												{
													startTime: [hora + ":" + minutos],
													endTime: "14:00",
													text: "Teste"
												}
												]
											}
										}
									}
									myObjData += JSON.stringify(data);
									
								}
								document.getElementById("demo").innerHTML = myObjData;							
							}
						}
						//document.getElementById("demo").innerHTML = myObjData;

						return data;
					}
				};
				xmlhttp.open("GET", "{{ url(config('laraadmin.adminRoute') . '/agenda_dados') }}", true);
				xmlhttp.send();			
			}

			/*function createDummyData() {
				var data = {};
				var myObjData;

				data = {
					2018: {
						2: {
							13: [
							{
								startTime: "10:00",
								endTime: "16:00",
								text: "Christmas"
							}
							]
						}
					}
				}

				myObjData += JSON.stringify(data);
				document.getElementById("demo").innerHTML = myObjData;

				return data;
			}*/

			// creating the dummy static data
			var data = createDummyData();

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

			/*var xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					var myObj, i, j, data = "";
					var myObjData;
					
					myObj = JSON.parse(this.responseText);
					for (i = 0; i < myObj.data.length; i++) {
						for (j = 0; j < myObj.data[i].length; j++) {

							if (myObj.data[i][j] == myObj.data[i][2]){
								var aplicador = myObj.data[i][j];
							}

							if (myObj.data[i][j] == myObj.data[i][3]){
								var paciente = myObj.data[i][j];
							}

							if (myObj.data[i][j] == myObj.data[i][1]){
								var a = new Date(myObj.data[i][j]);
								var ano = a.getFullYear();
								var mes = a.getMonth();
								var dia = a.getDate();
								var hora = a.getHours();
								var minutos = a.getMinutes();								

								data = {
									[ano]: {
										[mes]: {
											[dia]: [
											{
												startTime: [hora + ":" + minutos],
												endTime: "14:00",
												text: ["Aplicador: " + aplicador + " | Paciente: " + paciente]
											}
											]
										}
									}
								}
								myObjData += JSON.stringify(data);
							}
							document.getElementById("demo").innerHTML = myObjData;
						}
					}
					//document.getElementById("demo").innerHTML = data.length;
				}
			};
			xmlhttp.open("GET", "{{ url(config('laraadmin.adminRoute') . '/agenda_dados') }}", true);
			xmlhttp.send();*/
			
		</script>
		@endpush
