<?php
/**
 * The template for displaying categories
 *
  */
global $params;


$context = Timber::get_context();
$context['wp_title'] = $params['title'];

Timber::render('category.twig',$context);

?>