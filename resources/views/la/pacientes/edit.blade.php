@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/pacientes') }}">Paciente</a> :
@endsection
@section("contentheader_description", $paciente->$view_col)
@section("section", "Pacientes")
@section("section_url", url(config('laraadmin.adminRoute') . '/pacientes'))
@section("sub_section", "Editar")

@section("htmlheader_title", "Listagem de Pacientes Edição : ".$paciente->$view_col)

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
				{!! Form::model($paciente, ['route' => [config('laraadmin.adminRoute') . '.pacientes.update', $paciente->id ], 'method'=>'PUT', 'id' => 'paciente-edit-form']) !!}
					@la_form($module)
					
					{{--
					@la_input($module, 'nome')
					@la_input($module, 'cpf')
					@la_input($module, 'email')
					@la_input($module, 'data_nascimento')
					@la_input($module, 'telefone')
					@la_input($module, 'celular')
					@la_input($module, 'responsavel')					
					@la_input($module, 'cep')
					@la_input($module, 'rua')
					@la_input($module, 'bairro')
					@la_input($module, 'numero')
					@la_input($module, 'cidade')
					@la_input($module, 'estado')
					@la_input($module, 'convenio')
					@la_input($module, 'plano')
					@la_input($module, 'inicio')
					@la_input($module, 'local')
					@la_input($module, 'codigo')
					@la_input($module, 'indicacao')
					@la_input($module, 'observacoes')
					--}}
                    <br>
					<div class="form-group">
						{!! Form::submit( 'Atualizar', ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('laraadmin.adminRoute') . '/pacientes') }}">Cancelar</a></button>
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
	$("#paciente-edit-form").validate({
		
	});
});
</script>
@endpush