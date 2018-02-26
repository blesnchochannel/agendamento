@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/fechamentos') }}">Fechamento</a> :
@endsection
@section("contentheader_description", $fechamento->$view_col)
@section("section", "Fechamentos")
@section("section_url", url(config('laraadmin.adminRoute') . '/fechamentos'))
@section("sub_section", "Editar")

@section("htmlheader_title", "Listadem de Fechamentos Edit : ".$fechamento->$view_col)

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
				{!! Form::model($fechamento, ['route' => [config('laraadmin.adminRoute') . '.fechamentos.update', $fechamento->id ], 'method'=>'PUT', 'id' => 'fechamento-edit-form']) !!}
					@la_form($module)
					
					{{--
					@la_input($module, 'aplicador')
					@la_input($module, 'ano')
					--}}
                    <br>
					<div class="form-group">
						{!! Form::submit( 'Atualizar', ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('laraadmin.adminRoute') . '/fechamentos') }}">Cancelar</a></button>
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
	$("#fechamento-edit-form").validate({
		
	});
});
</script>
@endpush
