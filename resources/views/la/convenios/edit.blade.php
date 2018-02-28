@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/convenios') }}">Convenio</a> :
@endsection
@section("contentheader_description", $convenio->$view_col)
@section("section", "Convenios")
@section("section_url", url(config('laraadmin.adminRoute') . '/convenios'))
@section("sub_section", "Editar")

@section("htmlheader_title", "Listadem de Convenios Edit : ".$convenio->$view_col)

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
				{!! Form::model($convenio, ['route' => [config('laraadmin.adminRoute') . '.convenios.update', $convenio->id ], 'method'=>'PUT', 'id' => 'convenio-edit-form']) !!}
					@la_form($module)
					
					{{--
					@la_input($module, 'nome')
					@la_input($module, 'cnpj')
					@la_input($module, 'endereco')
					@la_input($module, 'telefone')
					@la_input($module, 'contato')
					@la_input($module, 'email')
					--}}
                    <br>
					<div class="form-group">
						{!! Form::submit( 'Atualizar', ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('laraadmin.adminRoute') . '/convenios') }}">Cancelar</a></button>
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
	$("#convenio-edit-form").validate({
		
	});
});
</script>
@endpush
