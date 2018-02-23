@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/events') }}">Event</a> :
@endsection
@section("contentheader_description", $event->$view_col)
@section("section", "Events")
@section("section_url", url(config('laraadmin.adminRoute') . '/events'))
@section("sub_section", "Editar")

@section("htmlheader_title", "Listadem de Events Edit : ".$event->$view_col)

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
				{!! Form::model($event, ['route' => [config('laraadmin.adminRoute') . '.events.update', $event->id ], 'method'=>'PUT', 'id' => 'event-edit-form']) !!}
					@la_form($module)
					
					{{--
					@la_input($module, 'aplicador')
					@la_input($module, 'paciente')
					@la_input($module, 'all_day')
					@la_input($module, 'start_date')
					@la_input($module, 'end_date')
					@la_input($module, 'tempo')
					--}}
                    <br>
					<div class="form-group">
						{!! Form::submit( 'Atualizar', ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('laraadmin.adminRoute') . '/events') }}">Cancelar</a></button>
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
	$("#event-edit-form").validate({
		
	});
});
</script>
@endpush
