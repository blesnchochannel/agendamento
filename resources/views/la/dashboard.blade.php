@extends('la.layouts.app')

@section('htmlheader_title') Início @endsection
@section('contentheader_title') Início @endsection
@section('contentheader_description') Sistema de Agendamento @endsection

@section('main-content')

<div class="agendamentos col-lg-3">
  @foreach( $data as $dados )
  <div>
    <span>{{ $dados->id }}</span>
    <span>{{ $dados->start_date }}</span>
    <span>{{ $dados->end_date }}</span>
  </div>
  @endforeach
</div>

<div>
  <div id="myfirstchart" style="height: 250px;"></div>
</div>

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
<!-- Morris.js charts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="{{ asset('la-assets/plugins/morris/morris.min.js') }}"></script>
<!-- Sparkline -->
<script src="{{ asset('la-assets/plugins/sparkline/jquery.sparkline.min.js') }}"></script>
<!-- jvectormap -->
<script src="{{ asset('la-assets/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
<script src="{{ asset('la-assets/plugins/jvectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
<!-- jQuery Knob Chart -->
<script src="{{ asset('la-assets/plugins/knob/jquery.knob.js') }}"></script>
<!-- daterangepicker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
<script src="{{ asset('la-assets/plugins/daterangepicker/daterangepicker.js') }}"></script>
<!-- datepicker -->
<script src="{{ asset('la-assets/plugins/datepicker/bootstrap-datepicker.js') }}"></script>
<script src="{{ asset('la-assets/plugins/datepicker/locales/bootstrap-datepicker.pt-BR.js') }}"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="{{ asset('la-assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}"></script>
<!-- FastClick -->
<script src="{{ asset('la-assets/plugins/fastclick/fastclick.js') }}"></script>
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
  new Morris.Bar({
  // ID of the element in which to draw the chart.
  element: 'myfirstchart',
  // Chart data records -- each entry in this array corresponds to a point on
  // the chart.
  data: [
  { y: '2006', a: 100, b: 90 },
  { y: '2007', a: 75,  b: 65 },
  { y: '2008', a: 50,  b: 40 },
  { y: '2009', a: 75,  b: 65 },
  { y: '2010', a: 50,  b: 40 },
  { y: '2011', a: 75,  b: 65 },
  { y: '2012', a: 100, b: 90 }
  ],
  // The name of the data record attribute that contains x-values.
  xkey: 'y',
  // A list of names of data record attributes that contain y-values.
  ykeys: ['a', 'b'],
  // Labels for the ykeys -- will be displayed when you hover over the
  // chart.
  labels: ['Series A', 'Series B']
});
</script>
@endpush