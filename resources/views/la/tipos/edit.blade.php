@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/tipos') }}">Tipo</a> :
@endsection
@section("contentheader_description", $tipo->$view_col)
@section("section", "Tipos")
@section("section_url", url(config('laraadmin.adminRoute') . '/tipos'))
@section("sub_section", "Editar")

@section("htmlheader_title", "Listagem de Tipos Edição : ".$tipo->$view_col)

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
				{!! Form::model($tipo, ['route' => [config('laraadmin.adminRoute') . '.tipos.update', $tipo->id ], 'method'=>'PUT', 'id' => 'tipo-edit-form']) !!}
					@la_form($module)
					
					{{--
					@la_input($module, 'tipo')
					--}}
                    <br>
					<div class="form-group">
						{!! Form::submit( 'Atualizar', ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('laraadmin.adminRoute') . '/tipos') }}">Cancelar</a></button>
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
	$("#tipo-edit-form").validate({
		
	});
});
</script>
@endpush
