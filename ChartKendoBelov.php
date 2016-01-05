<?php
/**
 * @package ChartKendoBelov
 * @version 1.0
 */
/*
Plugin Name: ChartKendoBelov
Plugin URI: https://github.com/evgenbel/ChartKendoBelov
Description: Plugin for view Kendo Chart with data from http://sensorrush.net/sensorrush/1234/MyPiSenseHAT/Humidity/Read/10/desc.
Author: Evgeniy Belov
Version: 1.0
Author URI:
*/

function show_kendo_belov_chart(){
    addStyles();
    $chart = '<div id="chart"></div>';
    return  $chart;
}

function addStyles(){
    wp_register_style( 'kendo-common', plugins_url( 'ChartKendoBelov/styles/kendo.common.min.css' ) );
    wp_register_style( 'kendo-rtl', plugins_url( 'ChartKendoBelov/styles/kendo.rtl.min.css' ) );
    wp_register_style( 'default-common', plugins_url( 'ChartKendoBelov/styles/default.common.min.css' ) );
    wp_register_style( 'kendo-dataviz', plugins_url( 'ChartKendoBelov/styles/kendo.dataviz.min.css' ) );
    wp_register_style( 'kendo-dataviz-default', plugins_url( 'ChartKendoBelov/styles/kendo.dataviz.default.min.css' ) );
    wp_enqueue_style( 'kendo-common' );
    wp_enqueue_style( 'kendo-rtl' );
    wp_enqueue_style( 'default-common' );
    wp_enqueue_style( 'kendo-dataviz' );
    wp_enqueue_style( 'kendo-dataviz-default' );

    wp_enqueue_script( 'jquery-min', plugins_url('ChartKendoBelov/js/jquery.min.js'), array(), '20141010', true );
    wp_enqueue_script( 'kendo-all-min', plugins_url('ChartKendoBelov/js/kendo.all.min.js'), array(), '20141010', true );
    wp_enqueue_script( 'chart', plugins_url('ChartKendoBelov/chart.js'), array(), '20141010', true );
}

add_shortcode('kendo_belov_chart', 'show_kendo_belov_chart');

class API {
    public function __construct() {
        if (isset($_GET['ajax']))
        add_action('template_redirect', array($this, 'hijackRequests'), -100);
    }

    public function hijackRequests() {
        $this->writeJsonResponse();
    }

    protected function writeJsonResponse($status = 200) {
        $data = file_get_contents('http://sensorrush.net/sensorrush/1234/MyPiSenseHAT/Humidity/Read/10/desc');
        //
        header('content-type: application/json; charset=utf-8', true, $status);
        echo($data);
        exit;
    }
}

new API();
?>
