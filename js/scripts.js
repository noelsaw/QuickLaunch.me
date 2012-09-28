(function($) {

	function is_email(email) {
		
		var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
	    return re.test(email);
		
	}

	$(document).ready(function() {
		
		$('.newsletter-form').submit(function(evt) {
			
			evt.preventDefault();
			
			var form = $(this);
			var email = $('.email', form).eq(0);
			
			if ( ! is_email(email.val()) ) {
				alert('Invalid email address.');
				email.focus();
				return;
			}
			
			$('input', form).prop('disabled', true);
			var data = {
				action: 'ql_register_email',
				email: email.val(),
				_wpnonce: QL.reg_email_nonce
			};
			$.post(QL.ajaxurl, data, function(r) {
				if (r.status == 'ok') {
					alert('Thanks for registering!');
					email.val('');
				}
				else {
					alert(r.msg);
				}
				$('input', form).prop('disabled', false);
			}, 'json');
			
		});
		
	});

})(jQuery);