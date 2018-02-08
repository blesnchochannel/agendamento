@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/planos') }}">Plano</a> :
@endsection
@section("contentheader_description", $plano->$view_col)
@section("section", "Planos")
@section("section_url", url(config('laraadmin.adminRoute') . '/planos'))
@section("sub_section", "Edit")

@section("htmlheader_title", "Planos Edit : ".$plano->$view_col)

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
				{!! Form::model($plano, ['route' => [config('laraadmin.adminRoute') . '.planos.update', $plano->id ], 'method'=>'PUT', 'id' => 'plano-edit-form']) !!}
					@la_form($module)
					
					{{--
					@la_input($module, 'nome')
					@la_input($module, 'descricao')
					--}}
                    <br>
					<div class="form-group">
						{!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('laraadmin.adminRoute') . '/planos') }}">Cancel</a></button>
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
	$("#plano-edit-form").validate({
		
	});
});
</script>
@endpush
