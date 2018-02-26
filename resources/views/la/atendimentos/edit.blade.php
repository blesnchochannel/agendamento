@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/atendimentos') }}">Atendimento</a> :
@endsection
@section("contentheader_description", $atendimento->$view_col)
@section("section", "Atendimentos")
@section("section_url", url(config('laraadmin.adminRoute') . '/atendimentos'))
@section("sub_section", "Editar")

@section("htmlheader_title", "Listadem de Atendimentos Edit : ".$atendimento->$view_col)

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
				{!! Form::model($atendimento, ['route' => [config('laraadmin.adminRoute') . '.atendimentos.update', $atendimento->id ], 'method'=>'PUT', 'id' => 'atendimento-edit-form']) !!}
					@la_form($module)
					
					{{--
					@la_input($module, 'aplicador')
					@la_input($module, 'paciente')
					@la_input($module, 'data')
					@la_input($module, 'observacoes')
					--}}
                    <br>
					<div class="form-group">
						{!! Form::submit( 'Atualizar', ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('laraadmin.adminRoute') . '/atendimentos') }}">Cancelar</a></button>
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
	$("#atendimento-edit-form").validate({
		
	});
});
</script>
@endpush
