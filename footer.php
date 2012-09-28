<?php
$ql_widgets = get_option('ql_widgets');
$ql_title_tagline = get_option('ql_title_tagline');
?>

		</div>
		<!-- End inner wrapper -->
	</div>
	<!-- End Page Wrapper -->

	<?php wp_footer() ?>
<?php if ( ql_is_personalizing() ): get_template_part('template-admin-palette'); endif; ?>
	<script src="http://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js"></script>
	<script type="text/javascript">
			<?php if($ql_title_tagline['font']): ?>
			WebFont.load({
				google: {
					families: ['<?php echo $ql_title_tagline['font']; ?>']
				},
				active:function(){
					var style = 'header h1{ font-family: "<?php echo $ql_title_tagline['font']; ?>"; }';
					
					var sc=document.createElement('style')
					  sc.setAttribute("type","text/css");
					  sc.innerHTML= style;
					  document.getElementsByTagName("head")[0].appendChild(sc)
				}
			});
			<?php endif; ?>
			
			<?php if($ql_widgets['slider']): ?>
			jQuery(function(){
				jQuery('#coin-slider').coinslider({width:468, links:false, navigation:false});
			});
			<?php endif; ?>
	</script>
</body>
</html>
