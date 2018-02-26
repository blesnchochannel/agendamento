@extends('la.layouts.app')

@section('htmlheader_title') Início @endsection
@section('contentheader_title') Início @endsection
@section('contentheader_description') Sistema de Agendamento @endsection

@section('main-content')

<div class="aplicadores col-lg-12">
  <h2>Relatórios</h2>
</div>
<br>

<div class="aplicadores col-lg-6">
  <label>Cálculo de Horas trabalhadas por aplicador:</label>
  <form>
    <select name="aplicadores" onchange="showAplicadores(this.value)">
      <option value="">Selecione um aplicador</option>
      @foreach( $aplicadores as $aplicador )      
      <option value="{{ $aplicador->id }}">{{ $aplicador->nome }}</option>
      @endforeach
    </select>
  </form>
  <div id="txtHint_aplicadores" style="background-color: white;"><b>O cálculo será exibido abaixo.</b></div>
</div>

<div class="pacientes col-lg-6">
  <label>Cálculo de Horas utilizadas por paciente:</label>
  <form>
    <select name="pacientes" onchange="showPacientes(this.value)">
      <option value="">Selecione um paciente</option>
      @foreach( $pacientes as $paciente )      
      <option value="{{ $paciente->id }}">{{ $paciente->nome }}</option>
      @endforeach
    </select>
  </form>
  <div id="txtHint_pacientes" style="background-color: white;"><b>O cálculo será exibido abaixo.</b></div>
</div>

<!--<div>
  <div id="myfirstchart" style="height: 250px;"></div>
</div>-->

@endsection

@push('styles')
<!-- Morris chart -->
<link rel="stylesheet" href="{{ asset('la-assets/plugins/morris/morris.css') }}">
<!-- jvectormap -->
<link rel="stylesheet" href="{{ asset('la-assets/plugins/jvectormap/jquery-jvectormap-1.2.2.css') }}">
<!-- Date Picker -->
<link rel="stylesheet" href="{{ asset('la-assets/plugins/datepicker/datepicker3.css') }}">
<!-- Daterange picker -->
<link rel="stylesheet" href="{{ asset('la-assets/plugins/daterangepicker/daterangepicker-bs3.css') }}">
<!-- bootstrap wysihtml5 - text editor -->
<link rel="stylesheet" href="{{ asset('la-assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}">
@endpush


@push('scripts')
<!-- jQuery UI 1.11.4 -->
<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>

<!-- dashboard -->
<script src="{{ asset('la-assets/js/pages/dashboard.js') }}"></script>
@endpush

@push('scripts')
<script>
  (function($) {
   $('body').pgNotification({
    style: 'circle',
    title: 'LaraAdmin',
    message: "Welcome to LaraAdmin...",
    position: "top-right",
    timeout: 0,
    type: "success",
    thumbnail: '<img width="40" height="40" style="display: inline-block;" src="{{ Gravatar::fallback(asset('la-assets/img/user2-160x160.jpg'))->get(Auth::user()->email, 'default') }}" data-src="assets/img/profiles/avatar.jpg" data-src-retina="assets/img/profiles/avatar2x.jpg" alt="">'
  }).show();
 })(window.jQuery);
</script>

<script>
  function showAplicadores(str) {
    if (str=="") {
      document.getElementById("txtHint_aplicadores").innerHTML="";
      return;
    }
    if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else { // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (this.readyState==4 && this.status==200) {
      document.getElementById("txtHint_aplicadores").innerHTML=this.responseText;
    }
  }
  xmlhttp.open("GET","{{ url(config('laraadmin.adminRoute') . '/ajaxaplicadores?q=') }}"+str,true);
  xmlhttp.send();
}
</script>

<script>
  function showPacientes(str) {
    if (str=="") {
      document.getElementById("txtHint_pacientes").innerHTML="";
      return;
    }
    if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else { // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (this.readyState==4 && this.status==200) {
      document.getElementById("txtHint_pacientes").innerHTML=this.responseText;
    }
  }
  xmlhttp.open("GET","{{ url(config('laraadmin.adminRoute') . '/ajaxpacientes?q=') }}"+str,true);
  xmlhttp.send();
}
</script>

<script src="{{ asset('la-assets/plugins/datatables/datatables.min.js') }}"></script>
<script>
  $(document).ready( function () {
    $('#aplicadores').DataTable();
  } );
  $(document).ready( function () {
    $('#pacientes').DataTable();
  } );
</script>
@endpush