@extends("la.layouts.app")

@section("contentheader_title", "Edit Field: ".$field->label)
@section("contentheader_description", "Listagem de from ".$module->model." module")
@section("section", "Module ".$module->name)
@section("section_url", url(config('laraadmin.adminRoute') . '/modules/'.$module->id))
@section("sub_section", "Edit Field")

@section("htmlheader_title", "Listagem de Field Edição : ".$field->label)

@section("main-content")
<div class="box">
	<div class="box-header">
		
	</div>
	<div class="box-body">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				{!! Form::model($field, ['route' => [config('laraadmin.adminRoute') . '.module_fields.update', $field->id ], 'method'=>'PUT', 'id' => 'field-edit-form']) !!}
					{{ Form::hidden("module_id", $module->id) }}
					
					<div class="form-group">
						<label for="label">Nome do Campo :</label>
						{{ Form::text("label", null, ['class'=>'form-control', 'placeholder'=>'Nome do Campo', 'data-rule-minlength' => 2, 'data-rule-maxlength'=>20, 'required' => 'required']) }}
					</div>
					
					<div class="form-group">
						<label for="colname">Nome da Coluna :</label>
						{{ Form::text("colname", null, ['class'=>'form-control', 'placeholder'=>'Nome da Coluna (minúsculo)', 'data-rule-minlength' => 2, 'data-rule-maxlength'=>20, 'data-rule-banned-words' => 'true', 'required' => 'required']) }}
					</div>
					
					<div class="form-group">
						<label for="field_type">Tipo de Dado:</label>
						{{ Form::select("field_type", $ftypes, null, ['class'=>'form-control', 'required' => 'required']) }}
					</div>
					
					<div id="unique_val">
						<div class="form-group">
							<label for="unique">Único:</label>
							{{ Form::checkbox("unique", "unique") }}
							<div class="Switch Round Off" style="vertical-align:top;margin-left:10px;"><div class="Toggle"></div></div>
						</div>
					</div>

					<div class="form-group">
						<label for="defaultvalue">Valor Padrão :</label>
						{{ Form::text("defaultvalue", null, ['class'=>'form-control', 'placeholder'=>'Valor Padrão a ser exibido']) }}
					</div>
					
					<div id="length_div">
						<div class="form-group">
							<label for="minlength">Tamanho Mínimo :</label>
							{{ Form::number("minlength", null, ['class'=>'form-control', 'placeholder'=>'Valor Padrão a ser exibido']) }}
						</div>
						
						<div class="form-group">
							<label for="maxlength">Tamanho Máximo :</label>
							{{ Form::number("maxlength", null, ['class'=>'form-control', 'placeholder'=>'Valor Padrão a ser exibido']) }}
						</div>
					</div>
					
					<div class="form-group">
						<label for="required">Obrigatório:</label>
						{{ Form::checkbox("required", "required") }}
						<div class="Switch Round Off" style="vertical-align:top;margin-left:10px;"><div class="Toggle"></div></div>
					</div>
					
					<div class="form-group values">
						<label for="popup_vals">Valores :</label>
						<?php
						$default_val = "";
						$popup_value_type_table = false;
						$popup_value_type_list = false;
						if(starts_with($field->popup_vals, "@")) {
							$popup_value_type_table = true;
							$default_val = str_replace("@", "", $field->popup_vals);
						} else if(starts_with($field->popup_vals, "[")) {
							$popup_value_type_list = true;
							$default_val = json_decode($field->popup_vals);
						}
						?>
						<div class="radio" style="margin-bottom:20px;">
							<label>{{ Form::radio("popup_value_type", "table", $popup_value_type_table) }} De uma tabela</label>
							<label>{{ Form::radio("popup_value_type", "list", $popup_value_type_list) }} De uma lista</label>
						</div>
						{{ Form::select("popup_vals_table", $tables, $default_val, ['class'=>'form-control', 'rel' => '']) }}
						
						<select class="form-control popup_vals_list" rel="taginput" multiple="1" data-placeholder="Adicione Múltiplos Valores (Pressione Enter para adicionar)" name="popup_vals_list[]">
							@if(is_array($default_val))
								@foreach ($default_val as $value)
									<option selected>{{ $value }}</option>
								@endforeach
							@endif
						</select>
						
						<?php
						// print_r($tables);
						?>
					</div>
					
                    <br>
					<div class="form-group">
						{!! Form::submit( 'Atualizar', ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('laraadmin.adminRoute') . '/modules/'.$module->id) }}">Cancelar</a></button>
					</div>
				{!! Form::close() !!}
				
				@if($errors->any())
				<ul class="alert alert-danger">
					@foreach($errors->all() as $error)
						<li>{{ $error }}</li>
					@endforeach
				</ul>
				@endif
			</div>
		</div>
	</div>
</div>

@endsection

@push('scripts')
<script>
$(function () {
	$("select.popup_vals_list").show();
	$("select.popup_vals_list").next().show();
	$("select[name='popup_vals_table']").hide();
	
	function showValuesSection() {
		var ft_val = $("select[name='field_type']").val();
		if(ft_val == 7 || ft_val == 15 || ft_val == 18 || ft_val == 20) {
			$(".form-group.values").show();
		} else {
			$(".form-group.values").hide();
		}
		
		$('#length_div').removeClass("hide");
		if(ft_val == 2 || ft_val == 4 || ft_val == 5 || ft_val == 7 || ft_val == 9 || ft_val == 11 || ft_val == 12 || ft_val == 15 || ft_val == 18 || ft_val == 21 || ft_val == 24 ) {
			$('#length_div').addClass("hide");
		}
		
		$('#unique_val').removeClass("hide");
		if(ft_val == 1 || ft_val == 2 || ft_val == 3 || ft_val == 7 || ft_val == 9 || ft_val == 11 || ft_val == 12 || ft_val == 15 || ft_val == 18 || ft_val == 20 || ft_val == 21 || ft_val == 24 ) {
			$('#unique_val').addClass("hide");
		}
	}

	$("select[name='field_type']").on("change", function() {
		showValuesSection();
	});
	showValuesSection();

	function showValuesTypes() {
		console.log($("input[name='popup_value_type']:checked").val());
		if($("input[name='popup_value_type']:checked").val() == "list") {
			$("select.popup_vals_list").show();
			$("select.popup_vals_list").next().show();
			$("select[name='popup_vals_table']").hide();
		} else {
			$("select[name='popup_vals_table']").show();
			$("select.popup_vals_list").hide();
			$("select.popup_vals_list").next().hide();
		}
	}
	
	$("input[name='popup_value_type']").on("change", function() {
		showValuesTypes();
	});
	showValuesTypes();

	$.validator.addMethod("data-rule-banned-words", function(value) {
		return $.inArray(value, ['files']) == -1;
	}, "Column name not allowed.");

	$("#field-edit-form").validate({
		
	});
});
</script>
@endpush