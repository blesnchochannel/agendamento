@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/profissoes') }}">Profissão</a> :
@endsection
@section("contentheader_description", $profisso->$view_col)
@section("section", "Profissões")
@section("section_url", url(config('laraadmin.adminRoute') . '/profissoes'))
@section("sub_section", "Editar")

@section("htmlheader_title", "Listadem de Profissoes Edição : ".$profisso->$view_col)

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
				{!! Form::model($profisso, ['route' => [config('laraadmin.adminRoute') . '.profissoes.update', $profisso->id ], 'method'=>'PUT', 'id' => 'profisso-edit-form']) !!}
					@la_form($module)
					
					{{--
					@la_input($module, 'nome')
					@la_input($module, 'descricao')
					--}}
                    <br>
					<div class="form-group">
						{!! Form::submit( 'Atualizar', ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('laraadmin.adminRoute') . '/profissoes') }}">Cancelar</a></button>
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
	$("#profisso-edit-form").validate({
		
	});
});
</script>
@endpush
