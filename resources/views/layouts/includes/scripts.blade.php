<!-- General JS Scripts -->
<script src="{{ asset('assets/js/app.min.js')  }}"></script>
<!-- JS Libraies -->
@yield('scripts')
<!-- Page Specific JS File -->
<!-- Template JS File -->
<script src="{{ asset('assets/js/scripts.js')  }}"></script>

<!-- Custom JS File -->
<script src="{{ asset('assets/js/custom.js')  }}"></script>

<script>
	x = $('.alert-autohide').length

	if(x > 0) {

    
        setTimeout(function() {
                console.log('s')
                $('.alert-autohide').fadeOut();
        }, 10000); // <-- time in milliseconds
    }
</script>