(function($) {
	
	function uploader_files_added(uploader, files) {
		var file = files[0];
		uploader.files = [file];
		notify('Uploading File...');
		setTimeout(function() {
			uploader.start();
		}, 5);
	}
	
	function uploader_error(uploader, error) {
		alert('Upload Error.\n'+ error);
	}

	function notify(msg) {
		$('#loading-indicator').html(msg)
							   .show();
		$('#admin-save-changes').hide()
								.blur();
	}
	
	function hide_notif() {
		$('#loading-indicator').hide();
		$('#admin-save-changes').show();
	}
	
	/**
	 * @credit http://papermashup.com/read-url-get-variables-withjavascript/
	 */
	function getUrlVar(url, key) {
		var val;
		var parts = url.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,k,value) {
			if(k == key)
				val = value;
		});
		return val;
	}



	function save_changes() {
	
		var data = $('#personalization-form').serializeArray();
		
		data.push({ name: 'title', value: $('#site-title').text() });
		data.push({ name: 'desc', value: $('#site-desc').text() });
		data.push({ name: 'page-content', value: $('#page-content').html() });
		data.push({ name: 'company', value: $('#company').html() });
		
		data.push({ name: 'action', value: 'ql_save_personalization' });
		data.push({ name: '_wpnonce', value: QLAdmin.save_nonce });
		
		$.post(QLAdmin.ajaxurl, data, function(r) {
			if (r.status == 'ok') {
				window.location = window.location.href.replace('?personalize', '');
			}
			else {
				alert(r.msg);
			}
		}, 'json');
		
	}

	$(document).ready(function() {
	
		
		// Move the admin palette next to the main content
		var palette = $('#admin');
		var palette_pos;
		if (palette.length) {
		
			var palette_width = palette.width();
			var content_pos = $('#wrap').offset();
			
			if($('#wrap').hasClass('pos-left'))
				palette_pos = 'right';
			else
				palette_pos = 'left';
		}
		
		// init palette dialog
		$('#admin').dialog({
			'width':230,
			'position':palette_pos
		});
		
		// Init the bg colorpicker
		var bgcolor = $('#bgcolor');
		bgcolor.ColorPicker({
			color: bgcolor.val(),
			onShow: function(picker) {
				var offset = $('#change-bg-color > a').offset();
				$(picker).css({
					top: offset.top + bgcolor.height() + 5,
					left: offset.left
				}).show();
				return false;
			},
			onChange: function(hsb, hex, rgb) {
				hex = '#'+ hex;
				bgcolor.val(hex);
				$('body').css('background-color', hex);
			}
		});
		$('#change-bg-color a').click(function(evt) {
			evt.preventDefault();
			bgcolor.click();
		});
		
		// Init the text colorpicker
		var textcolor = $('#text-color');
		textcolor.ColorPicker({
			color: textcolor.val(),
			onShow: function(picker) {
				var offset = $('#change-text-color > a').offset();
				$(picker).css({
					top: offset.top + textcolor.height() + 5,
					left: offset.left
				}).show();
				return false;
			},
			onChange: function(hsb, hex, rgb) {
				hex = '#'+ hex;
				textcolor.val(hex);
				$('body').css('color', hex);
			}
		});
		$('#change-text-color a').click(function(evt) {
			evt.preventDefault();
			textcolor.click();
		});
		
		// Init the heading colorpicker
		var headingcolor = $('#heading-color');
		headingcolor.ColorPicker({
			color: headingcolor.val(),
			onShow: function(picker) {
				var offset = $('#change-heading-color > a').offset();
				$(picker).css({
					top: offset.top + headingcolor.height() + 5,
					left: offset.left
				}).show();
				return false;
			},
			onChange: function(hsb, hex, rgb) {
				hex = '#'+ hex;
				headingcolor.val(hex);
				$('h1').css('color', hex);
			}
		});
		$('#change-heading-color a').click(function(evt) {
			evt.preventDefault();
			headingcolor.click();
		});
		
		// Generate our upload url
		var upload_url = QLAdmin.ajaxurl + '?action=ql_upload&_wpnonce=' + QLAdmin.upload_nonce;
		
		// Create our default uploader params
		var upload_params = {
			runtimes: 'html5,flash',
			max_file_size: '10mb',
			url: upload_url,
			flash_swf_url: QLAdmin.siteurl + '/wp-includes/js/plupload/plupload.flash.swf',
			filters: [
				{ title: 'Image Files', extensions: 'jpg,gif,png' }
			]
		};
		
		// Upload logo image
		upload_params.browse_button = 'upload-logo-link';
		var bg_uploader = new plupload.Uploader(upload_params);
		bg_uploader.bind('FilesAdded', uploader_files_added);
		bg_uploader.bind('Error', uploader_error);
		bg_uploader.bind('FileUploaded', function(up, file, response) {
			var r = $.parseJSON(response.response);
			if (r.status == 'ok') {
				$('header').html('<img src="'+r.url+'" style="max-width:100%;" />');
				$('#logoimage').val(r.url);
			}
			else {
				alert('Upload Error.\n'+ r.msg);
			}
			hide_notif();
		});
		bg_uploader.init();
		
		// Upload background image
		upload_params.browse_button = 'upload-bg-link';
		var bg_uploader = new plupload.Uploader(upload_params);
		bg_uploader.bind('FilesAdded', uploader_files_added);
		bg_uploader.bind('Error', uploader_error);
		bg_uploader.bind('FileUploaded', function(up, file, response) {
			var r = $.parseJSON(response.response);
			if (r.status == 'ok') {
				$('body').css('background-image', 'url('+ r.url +')');
				$('#bgimage').val(r.url);
			}
			else {
				alert('Upload Error.\n'+ r.msg);
			}
			hide_notif();
		});
		bg_uploader.init();
		
		// Upload center image
		upload_params.browse_button = 'upload-centerimg-link';
		var bg_uploader = new plupload.Uploader(upload_params);
		bg_uploader.bind('FilesAdded', uploader_files_added);
		bg_uploader.bind('Error', uploader_error);
		bg_uploader.bind('FileUploaded', function(up, file, response) {
			var r = $.parseJSON(response.response);
			if (r.status == 'ok') {
				var html = '<img src="'+ r.url +'" alt="'+ file.name +'" width="460" />';
				$('#center-image').html(html).removeClass('hidden');
				$('#centerimage').val(r.url);
			}
			else {
				alert('Upload Error.\n'+ r.msg);
			}
			hide_notif();
		});
		bg_uploader.init();
		
		// Add editable classes to the site title, tagline and main page content
		$('#site-title,#site-desc,#page-content,#company').prop('contenteditable', true)
												 .addClass('editable');
		
		// Button Colors
		$('#btn-color').change(function(evt) {
			console.log(this.value);
			$('#newsletter-submit').attr('class', 'btn '+ this.value);
		});
						 
		// Initialize content padding slider
		$('#content-padding-slider').noUiSlider('init', {
			dontActivate: 'lower',
			startMax: parseInt($('#content-padding').val()),
			Maxvalue: 100,
			tracker: function() {
				var val = Math.round($('#content-padding-slider').noUiSlider('getValue', {point: 'upper'}));
				var content_width = 500 - (val * 2);
				$('#wrap').css({
					padding: val,
					width: content_width
				});
				$('#center-image > img').width(content_width);
				$('#content-padding').val(val);
			}
		});
		
		
		// Initialize box opacity slider
		$('#box-opacity-slider').noUiSlider('init', {
			dontActivate: 'lower',
			startMax: $('#box-opacity').val() * 100,
			Maxvalue: 100,
			tracker: function() {
				var val = Math.round($('#box-opacity-slider').noUiSlider('getValue', {point: 'upper'}));
				opacity = val/100;
				$('#wrap').css('background-color', 'rgba(255,255,255,'+opacity+')');
				$('#box-opacity').val(opacity);
			}
		});
		
		// content positioning
		$('input[name=content_position]:radio').click(function(e){
			position = this.value;
			console.log(position);
			// if position is left move the admin palette to right
			if(position=='left')
				$('#admin').css({'left':'auto', 'right':'230px'});
				
			$('#wrap').removeClass('pos-right').removeClass('pos-center').removeClass('pos-left').addClass('pos-'+position);
		});
		
		// Email options
		$('input[name=show_email]:checkbox').click(function(){
			if(this.checked)
				$('.newsletter-form').show();
			else
				$('.newsletter-form').hide();
		});
		
		// Handle save changes
		$('#admin-save-changes').click(function(evt) {
			evt.preventDefault();
			notify('Saving Changes...');
			save_changes();
		});
		
		// round box background
		$('#rounded-box-background').click(function (){
			if(this.checked){
				$('#wrap').removeClass('rounded-box-background').addClass('rounded-box-background');
			}else{
				$('#wrap').addClass('rounded-box-background').removeClass('rounded-box-background');
			}
		});
		// round box background
		$('#square-box-background').click(function (){
			if(this.checked){
				$('#wrap').removeClass('square-box-background').addClass('square-box-background');
			}else{
				$('#wrap').addClass('square-box-background').removeClass('square-box-background');
			}
		});
		
		
		// youtube video
		$('#center-video').blur(function(){
			if($(this).val() != ''){
				// embed the player
				var videoURL = $(this).val();
				
				videoId = getUrlVar(videoURL, 'v');
				
				$('#video param[name=movie]').attr('value', 'http://www.youtube.com/v/'+videoId+'&version=3&autohide=1&showinfo=0');
				$('#video embed').attr('src', 'http://www.youtube.com/v/'+videoId+'&version=3&autohide=1&showinfo=0');
				$('#video').show();
			}else{
				$('#video').hide();
			}
		});
		
		// font
		$('#google-font').change(function(){
				if($(this).val() != ''){
					// add selected font
					var font = $(this).val();
					
					WebFont.load({
						google: {
						  families: [font]
						},
						active:function(){
							var style = '<style> header h1{font-family: "'+font+'"; }</style>';
							$('head').append(style);
						}
					  });
				}else{
					
				}
		});
		
		// widgets
		$('input[name=widgets_active]:checkbox').click(function(){
			if(this.checked)
				$('#widgets').show();
			else
				$('#widgets').hide();
		});
		
	});

})(jQuery);
