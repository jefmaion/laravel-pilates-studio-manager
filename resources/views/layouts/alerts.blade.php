@if ($message = Session::get('success'))
<div class="alert alert-success alert-block alert-autohide alert-dismissible fade show">
	<strong><i class="fas fa-check-circle"></i></strong> {!! $message !!}
	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	  </button>
</div>

@endif


@if ($message = Session::get('error'))
<div class="alert alert-danger alert-block alert-autohide alert-dismissible fade show">
	<strong><i class="fas fa-exclamation-circle    "></i></strong> {!! $message !!}
</div>
@endif


@if ($message = Session::get('warning'))
<div class="alert alert-warning alert-block alert-autohide alert-dismissible fade show">
	<strong><i class="fas fa-exclamation    "></i></strong> {!! $message !!}
</div>
@endif


@if ($message = Session::get('info'))
<div class="alert alert-info alert-block alert-autohide alert-dismissible fade show">
	<strong><i class="fas fa-info-circle    "></i></strong> {!! $message !!}
</div>
@endif


@if ($errors->any())
<div class="alert alert-danger">
	<i class="fas fa-exclamation-circle    "></i> Ooops! Verifique os error abaixo
</div>

{!! implode('', $errors->all()) !!}


@endif

