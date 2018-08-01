<?php
/**
 * The template for displaying the archives
 *
  */
global $wp_query;

$context = Timber::get_context();
Timber::render('archive.twig',$context);

?>