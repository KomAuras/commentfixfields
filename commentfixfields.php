<?php
/*
Plugin Name: Comment Fix Fields (hueman)
Description: Remove website & email field from comment form (hueman)
Author: SEA
Text Domain: commentfixfields
Domain Path: /languages/
Version: 1.0.0
*/

add_action('wp_enqueue_scripts', 'callback_for_setting_up_scripts',1000);
function callback_for_setting_up_scripts() {
    wp_register_style( 'commentfixfields', plugins_url( 'commentfixfields/css/style.css' ) );
    wp_enqueue_style( 'commentfixfields' );
}

function remove_comment_fields($fields) {
    unset($fields['url']);
    unset($fields['email']);
    return $fields;
}
add_filter('comment_form_default_fields', 'remove_comment_fields');

function custom_validate_comment_author() {
    if( empty( $_POST['author'] ) || ( !preg_match( '/[^\s]/', $_POST['author'] ) ) )
        wp_die( __('Ошибка! Пожалуйста, заполните поле Имя') );
}
add_action( 'pre_comment_on_post', 'custom_validate_comment_author' );

function mytheme_init() {
    add_filter('comment_form_defaults','mytheme_comments_form_defaults');
}

add_action('after_setup_theme','mytheme_init');
function mytheme_comments_form_defaults($default) {
    unset($default['comment_notes_after']);
    return $default;
}
