<!-- JavaScript -->
@yield('script')

<!-- jQuery -->
<script src="{{ asset('assets/vendors/bower_components/jquery/dist/jquery.min.js') }}"></script>

<!-- Bootstrap Core JavaScript -->
<script src=" {{asset('assets/vendors/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>

<!-- Data table JavaScript -->
<script src="{{ asset('assets/vendors/bower_components/datatables/media/js/jquery.dataTables.min.js') }}"></script>

<!-- Slimscroll JavaScript -->
<script src=" {{ asset('assets/js/jquery.slimscroll.js') }}"></script>

<!-- simpleWeather JavaScript -->
<script src="{{ asset('assets/vendors/bower_components/moment/min/moment.min.js') }}"></script>
<script src="{{ asset('assets/vendors/bower_components/simpleWeather/jquery.simpleWeather.min.js') }}"></script>
<script src="{{ asset('assets/js/simpleweather-data.js') }}"></script>

<!-- Progressbar Animation JavaScript -->
<script src=" {{ asset('assets/vendors/bower_components/waypoints/lib/jquery.waypoints.min.js') }}"></script>
<script src=" {{ asset('assets/vendors/bower_components/jquery.counterup/jquery.counterup.min.js') }}"></script>

<!-- Fancy Dropdown JS -->
<script src=" {{ asset('assets/js/dropdown-bootstrap-extended.js') }}"></script>

<!-- Sparkline JavaScript -->
<script src="{{ asset('assets/vendors/jquery.sparkline/dist/jquery.sparkline.min.js') }}"></script>

<!-- Owl JavaScript -->
<script src="{{ asset('assets/vendors/bower_components/owl.carousel/dist/owl.carousel.min.js') }}"></script>

<!-- Toast JavaScript -->
<script src="{{ asset('assets/vendors/bower_components/jquery-toast-plugin/dist/jquery.toast.min.js') }}"></script>

<!-- EChartJS JavaScript -->
<script src="{{ asset('assets/vendors/bower_components/echarts/dist/echarts-en.min.js') }}"></script>
<script src="{{ asset('assets/vendors/echarts-liquidfill.min.js') }}"></script>

<!-- Switchery JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

<script src="{{ asset('assets/vendors/bower_components/switchery/dist/switchery.min.js') }}"></script>

<!-- Init JavaScript -->
<script src="{{ asset('assets/js/init.js') }}"></script>

<script>
	$(document).ready(function() {
		function formatState (opt) {
    	if (!opt.id) {
    	    return opt.text.toUpperCase();
    	} 

    	var optimage = $(opt.element).attr('data-icon'); 
    	console.log( opt.text.toUpperCase().trim())
    	if(!optimage){
    	   return opt.text.toUpperCase();
    	} else {                    
    	    var $opt = $(
				  '<span><i class="cc '+optimage+'" title="'+optimage+'"></i> ' + opt.text.toUpperCase().trim() + '</span>'
    	    );
    	    return $opt;
    	}
	};

    	$('.select-crypto').select2({ 
			 templateResult: formatState,
    		templateSelection: formatState
		});
	});

	

	$(window).on("load", function () {
	window.setTimeout(function () {
		$.toast({
			heading: "Hello {!! Auth::user()->name !!}",
			text: 'Ici tu peux voir le cours de la crypto ainsi que ton solde sur Kraken !',
			position: 'bottom-left',
			loaderBg: '#e3c94b',
			icon: '',
			hideAfter: 3500,
			stack: 6
		});
	}, 3000);
});
</script>

<script src="{{ asset('assets/js/dashboard-data.js') }}"></script>