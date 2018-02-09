@extends("la.layouts.app")

@section("contentheader_title", "Agendamentos")
@section("contentheader_description", "Listagem de Agendamentos")
@section("section", "Agendamentos")
@section("sub_section", "Listagem")
@section("htmlheader_title", "Listadem de Agendamentos")

@section("headerElems")
@la_access("Agendamentos", "create")
<button class="btn btn-success btn-sm pull-right" data-toggle="modal" data-target="#AddModal">Adicionar Agendamento</button>
@endla_access
@endsection

@section("main-content")

<section class="content">
	<!-- Small boxes (Stat box) -->
	<!-- Main row -->
	<div class="row">
		<section class="col-lg-5 connectedSortable">
			<div class="box box-solid bg-green-gradient">
				<div class="box-header">
					<i class="fa fa-calendar"></i>
					<h3 class="box-title">Calendário</h3>
					<!-- tools box -->
					<div class="pull-right box-tools">
						<!-- button with a dropdown -->
						<div class="btn-group">
							<button class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bars"></i></button>
							<ul class="dropdown-menu pull-right" role="menu">
								<li><a href="#">Add new event</a></li>
								<li><a href="#">Clear events</a></li>
								<li class="divider"></li>
								<li><a href="#">View calendar</a></li>
							</ul>
						</div>
						<button class="btn btn-success btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
						<button class="btn btn-success btn-sm" data-widget="remove"><i class="fa fa-times"></i></button>
					</div><!-- /. tools -->
				</div><!-- /.box-header -->
				<div class="box-body no-padding">
					<!--The calendar -->
					<div id="calendar" style="width: 100%"></div>
				</div><!-- /.box-body -->
			</div><!-- /.box -->
		</section>

		<section class="col-lg-7 connectedSortable">
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

@la_access("Agendamentos", "create")
<div class="modal fade" id="AddModal" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Adicionar Agendamento</h4>
			</div>
			{!! Form::open(['action' => 'LA\AgendamentosController@store', 'id' => 'agendamento-add-form']) !!}
			<div class="modal-body">
				<div class="box-body">
					@la_form($module)
					
					{{--
						@la_input($module, 'data')
						@la_input($module, 'aplicador')
						@la_input($module, 'paciente')
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
	<!-- Date Picker -->
	<link rel="stylesheet" href="{{ asset('la-assets/plugins/datepicker/datepicker3.css') }}">
	@endpush

	@push('scripts')
	<script src="{{ asset('la-assets/plugins/datatables/datatables.min.js') }}"></script>
	<!-- datepicker -->
	<script src="{{ asset('la-assets/plugins/datepicker/bootstrap-datepicker.js') }}"></script>
	<script src="{{ asset('la-assets/plugins/datepicker/locales/bootstrap-datepicker.pt-BR.js') }}"></script>
	<!-- agendamentos -->
	<script src="{{ asset('la-assets/js/pages/agendamentos.js') }}"></script>
	<script>
		$(function () {
			$("#example1").DataTable({
				processing: true,
				serverSide: true,
				ajax: "{{ url(config('laraadmin.adminRoute') . '/agendamento_dt_ajax') }}",
				language: {
					lengthMenu: "Exibindo _MENU_ entradas por página",
            		zeroRecords: "Nada encontrado - desculpe",
           			info: "Exibindo _PAGE_ de _PAGES_ página(s)",
            		infoEmpty: "Não há nenhuma entrada",
            		infoFiltered: "(filtrado de um total de _MAX_ entradas)",					
					search: "_INPUT_",
					searchPlaceholder: "Procurar"
				},
				@if($show_actions)
				columnDefs: [ { orderable: false, targets: [-1] }],
				@endif
			});
			$("#agendamento-add-form").validate({

			});
		});
	</script>
	@endpush
