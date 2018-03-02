@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/usuarios') }}">Usuario</a> :
@endsection
@section("contentheader_description", $usuario->$view_col)
@section("section", "Usuarios")
@section("section_url", url(config('laraadmin.adminRoute') . '/usuarios'))
@section("sub_section", "Editar")

@section("htmlheader_title", "Listadem de Usuarios Edit : ".$usuario->$view_col)

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
				{!! Form::model($usuario, ['route' => [config('laraadmin.adminRoute') . '.usuarios.update', $usuario->id ], 'method'=>'PUT', 'id' => 'usuario-edit-form']) !!}
					@la_form($module)
					
					{{--
					@la_input($module, 'nome')
					@la_input($module, 'context_id')
					@la_input($module, 'email')
					@la_input($module, 'password')
					@la_input($module, 'tipo')
					@la_input($module, 'valor')
					@la_input($module, 'cor')
					@la_input($module, 'profissao')
					--}}
                    <br>
					<div class="form-group">
						{!! Form::submit( 'Atualizar', ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('laraadmin.adminRoute') . '/usuarios') }}">Cancelar</a></button>
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
	$("#usuario-edit-form").validate({
		
	});
});
</script>
@endpush