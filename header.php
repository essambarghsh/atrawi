<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class('atrawi-theme'); ?>>
    <?php wp_body_open(); ?>
    <?php get_template_part( 'components/header/v1/index' );?>
    <div id="appContent" class="app-content">