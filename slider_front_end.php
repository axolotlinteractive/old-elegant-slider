<?php
function showPublishedimages_1($id)
{
global $wpdb;

	$images = getSliderImages($id);
	$query=$wpdb->prepare("SELECT * FROM ".$wpdb->prefix."huge_itslider_sliders where id = '%d' order by id ASC",$id);
	$slider=$wpdb->get_results($query);
	$query="SELECT * FROM ".$wpdb->prefix."huge_itslider_params";
    $rowspar = $wpdb->get_results($query);
    $paramssld = array();
    foreach ($rowspar as $rowpar) {
        $key = $rowpar->name;
        $value = $rowpar->value;
        $paramssld[$key] = $value;
    }
	return front_end_slider($images, $paramssld, $slider);		
}

