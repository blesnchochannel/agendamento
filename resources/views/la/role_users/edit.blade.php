@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/role_users') }}">Role User</a> :
@endsection
@section("contentheader_description", $role_user->$view_col)
@section("section", "Role Users")
@section("section_url", url(config('laraadmin.adminRoute') . '/role_users'))
@section("sub_section", "Editar")

@section("htmlheader_title", "Listagem de Role Users Edição : ".$role_user->$view_col)

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
				{!! Form::model($role_user, ['route' => [config('laraadmin.adminRoute') . '.role_users.update', $role_user->id ], 'method'=>'PUT', 'id' => 'role_user-edit-form']) !!}
					@la_form($module)
					
					{{--
					@la_input($module, 'role_id')
					@la_input($module, 'user_id')
					--}}
                    <br>
					<div class="form-group">
						{!! Form::submit( 'Atualizar', ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('laraadmin.adminRoute') . '/role_users') }}">Cancelar</a></button>
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
	$("#role_user-edit-form").validate({
		
	});
});
</script>
@endpush
