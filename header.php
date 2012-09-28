<?php
$ql_layout = get_option('ql_layout');
?>
<!DOCTYPE html>
<html lang="<?php bloginfo('language') ?>">
<head>

	<meta charset="<?php bloginfo('charset') ?>">
	
	<title><?php bloginfo('title') ?></title>
	
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url') ?>">
	<link rel="stylesheet" href="<?php bloginfo('template_url') ?>/add-on/slider/coin-slider-styles.css">

	<!--[if lt IE 9]>
	<script src="<?php bloginfo('template_url') ?>/js/html5.js"></script>
	<![endif]-->
	
	<?php wp_head() ?>

</head>
<body>

	<!-- Page Wrapper -->
	<div id="wrap" class="pos-<?php echo $ql_layout['position']?$ql_layout['position']:'center'; ?>" >
		<div id="wrap-inner">
	
