@extends("la.layouts.app")

@section("contentheader_title")
<a href="{{ url(config('laraadmin.adminRoute') . '/events') }}">Event</a> :
@endsection
@section("contentheader_description", $event->$view_col)
@section("section", "Events")
@section("section_url", url(config('laraadmin.adminRoute') . '/events'))
@section("sub_section", "Editar")

@section("htmlheader_title", "Listagem de Events Edição : ".$event->$view_col)

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
					@la_input($module, 'dow')
					@la_input($module, 'tempo_de_atendimento')
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
	<script>
		$( document ).ready(function() {
			document.getElementById('paciente').setAttribute("onchange", "buscaPacientes(this.value);");
			document.getElementById('start_date').setAttribute("onchange", "calculaAutomatico();");
			document.getElementById('end_date').setAttribute("onchange", "calculaAutomatico();");
			document.getElementById('dow').setAttribute("onchange", "calculaAutomatico();");
			document.getElementById('dow').options[0].innerHTML = "Segunda";
			document.getElementById('dow').options[1].innerHTML = "Terça";
			document.getElementById('dow').options[2].innerHTML = "Quarta";
			document.getElementById('dow').options[3].innerHTML = "Quinta";
			document.getElementById('dow').options[4].innerHTML = "Sexta";
			document.getElementById('dow').options[5].innerHTML = "Sábado";
		});
	</script>
	<script>
		function buscaPacientes(str) {
			if (str=="") {

			}
			if (window.XMLHttpRequest) {
    			// code for IE7+, Firefox, Chrome, Opera, Safari
    			xmlhttp=new XMLHttpRequest();
    		} else { 
  				// code for IE6, IE5
  				xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  			}
  			xmlhttp.onreadystatechange=function() {
  				if (this.readyState==4 && this.status==200) {
  					alertify.alert('ATENÇÃO!', this.responseText);
  				}
  			}
  			xmlhttp.open("GET","{{ url(config('laraadmin.adminRoute') . '/ajaxpacientes2?q=') }}"+str,true);
  			xmlhttp.send();
  		}
  	</script>

  	<script>
  		function calculaAutomatico(){

  			var data_inicial = document.getElementById('start_date').value;
  			var data_final = document.getElementById('end_date').value;
  			var recurrencia = $('#dow').val();

  			function converteData(data){
  				var dateTime = data.split(" ");
  				var date = dateTime[0].split("/");
  				var time = dateTime[1].split(":");
  				var newdate = date.reverse().join(",");
  				var newtime = time.join(":");
  				var novadata = newdate+' '+newtime;
  				return novadata;
  			}

  			function converteSoAHora(data){
  				var dateTime = data.split(" ");
  				var time = dateTime[1].split(":");
  				var newtime = time.join(":");
  				return newtime;
  			}	

  			function diff_hours(dt1, dt2){

  				var diff =(dt2.getTime() - dt1.getTime()) / 1000;
  				diff /= (60 * 60);
  				return diff;
  				//return Math.abs(Math.round(diff));

  			}

  			var hora1 = converteSoAHora(data_inicial);
  			var hora2 = converteSoAHora(data_final);

  			var dt1 = new Date("01/01/2007 " + hora1);
  			var dt2 = new Date("01/01/2007 " + hora2);

  			var total_de_horas = diff_hours(dt1, dt2);

  			function countCertainDays( days, d0, d1 ) {
  				var ndays = 1 + Math.round((d1-d0)/(24*3600*1000));
  				var sum = function(a,b) {
  					return a + Math.floor( ( ndays + (d0.getDay()+6-b) % 7 ) / 7 ); 
  				};
  				return days.reduce(sum,0);
  			}

  			function converteSoAData(data){
  				var dateTime = data.split(" ");
  				var date = dateTime[0].split("/");
  				var newdate = date.reverse().join(",");
  				return newdate;
  			}

  			var sodata1 = converteSoAData(data_inicial);
  			var sodata2 = converteSoAData(data_final);

  			var total_de_dias = countCertainDays(recurrencia,new Date(sodata1),new Date(sodata2));

  			var calculototal = total_de_dias * total_de_horas;

  			var tempo_de_atendimento = document.getElementById('tempo_de_atendimento');

  			tempo_de_atendimento.value = calculototal;
  		}
  	</script>
  	@endpush