@extends("la.layouts.app")

@section("contentheader_title", "Events")
@section("contentheader_description", "Listagem de Events")
@section("section", "Events")
@section("sub_section", "Listagem")
@section("htmlheader_title", "Listadem de Events")

@section("headerElems")
@la_access("Events", "create")
<button class="btn btn-success btn-sm pull-right" data-toggle="modal" data-target="#AddModal">Adicionar  Event</button>
@endla_access
@endsection

@section("main-content")

@if (count($errors) > 0)
<div class="alert alert-danger">
	<ul>
		@foreach ($errors->all() as $error)
		<li>{{ $error }}</li>
		@endforeach
	</ul>
</div>
@endif

<div class="aplicadores col-lg-4">
	<label>Aplicadores: </label><br>
	<form>
		<select class="form-control" name="aplicadores" onchange="showAplicadores(this.value)">
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
<div class="box box-success col-lg-12">
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

@la_access("Events", "create")
<div class="modal fade" id="AddModal" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Adicionar Event</h4>
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
						@la_input($module, 'tempo')
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

	@endpush
