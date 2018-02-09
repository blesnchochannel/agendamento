@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/agendas') }}">Agenda</a> :
@endsection
@section("contentheader_description", $agenda->$view_col)
@section("section", "Agendas")
@section("section_url", url(config('laraadmin.adminRoute') . '/agendas'))
@section("sub_section", "Editar")

@section("htmlheader_title", "Listadem de Agendas Edit : ".$agenda->$view_col)

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

<div class="box">
	<div class="box-header">
		
	</div>
	<div class="box-body">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				{!! Form::model($agenda, ['route' => [config('laraadmin.adminRoute') . '.agendas.update', $agenda->id ], 'method'=>'PUT', 'id' => 'agenda-edit-form']) !!}
					@la_form($module)
					
					{{--
					@la_input($module, 'nome')
					@la_input($module, 'aplicador')
					@la_input($module, 'agendamentos')
					--}}
                    <br>
					<div class="form-group">
						{!! Form::submit( 'Atualizar', ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('laraadmin.adminRoute') . '/agendas') }}">Cancelar</a></button>
					</div>
				{!! Form::close() !!}
			</div>
		</div>
	</div>
</div>

@endsection

@push('scripts')
<script>
$(function () {
	$("#agenda-edit-form").validate({
		
	});
});
</script>
@endpush
