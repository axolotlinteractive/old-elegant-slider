<style>
    #huge_it_loading_image_<?php echo $sliderID; ?> {
        height:<?php echo $sliderheight; ?>px;
        width:<?php  echo $sliderwidth; ?>px;
        display: table-cell;
        text-align: center;
        vertical-align: middle;
    }
    #huge_it_loading_image_<?php echo $sliderID; ?>.display {
        display: table-cell;
    }
    #huge_it_loading_image_<?php echo $sliderID; ?>.nodisplay {
        display: none;
    }
    #huge_it_loading_image_<?php echo $sliderID; ?> img {
        margin: auto 0;
        width: 20% !important;

    }

    .huge_it_slideshow_image_wrap_<?php echo $sliderID; ?> {
        height:<?php echo $sliderheight; ?>px;
        width:<?php  echo $sliderwidth; ?>px;
        position:relative;
        display: block;
        text-align: center;
        /*HEIGHT FROM HEADER.PHP*/
        clear:both;
    <?php if($sliderposition=="left"){ $position='float:left;';}elseif($sliderposition=="right"){$position='float:right;';}else{$position='float:none; margin:0px auto;';} ?>
    <?php echo $position;  ?>

        border-style:solid;
        border-left:0px !important;
        border-right:0px !important;
    }
    .huge_it_slideshow_image_wrap1_<?php echo $sliderID; ?>.display {
        width: 100%;
        height:100%;
    }
    .huge_it_slideshow_image_wrap1_<?php echo $sliderID; ?>.display {
        display:block;
    }
    .huge_it_slideshow_image_wrap1_<?php echo $sliderID; ?>.nodisplay {
        display:none;
    }
    .huge_it_slideshow_image_wrap_<?php echo $sliderID; ?> * {
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        -webkit-box-sizing: border-box;
    }


    .huge_it_slideshow_image_<?php echo $sliderID; ?> {
        max-width: <?=$sliderwidth?>px;
        max-height: <?=$sliderheight?>px;
    }

    #huge_it_slideshow_left_<?php echo $sliderID; ?>,
    #huge_it_slideshow_right_<?php echo $sliderID; ?> {
        cursor: pointer;
        display:none;
        display: block;

        height: 100%;
        outline: medium none;
        position: absolute;

        /*z-index: 10130;*/
        z-index: 13;
        bottom:25px;
        top:50%;
    }


    #huge_it_slideshow_left-ico_<?php echo $sliderID; ?>,
    #huge_it_slideshow_right-ico_<?php echo $sliderID; ?> {
        z-index: 13;
        -moz-box-sizing: content-box;
        box-sizing: content-box;
        cursor: pointer;
        display: table;
        left: -9999px;
        line-height: 0;
        margin-top: -15px;
        position: absolute;
        top: 50%;
        /*z-index: 10135;*/
    }
    #huge_it_slideshow_left-ico_<?php echo $sliderID; ?>:hover,
    #huge_it_slideshow_right-ico_<?php echo $sliderID; ?>:hover {
        cursor: pointer;
    }

    .huge_it_slideshow_image_container_<?php echo $sliderID; ?> {
        position: relative;
        top:0px;
        left:0px;
        text-align: center;
        vertical-align: middle;
        width:100%;
    }

    .elegant_slideshow_image_container {
        overflow: hidden;
    }

    .elegant_slider {
        list-style: none;
    }

    .huge_it_slideshow_title_text_<?php echo $sliderID; ?> {
        text-decoration: none;
        position: absolute;
        z-index: 11;
        display: inline-block;
    <?php  if($paramssld['slider_title_has_margin']=='on'){
            $slider_title_width=($paramssld['slider_title_width']-6);
            $slider_title_height=($paramssld['slider_title_height']-6);
            $slider_title_margin="3";
        }else{
            $slider_title_width=($paramssld['slider_title_width']);
            $slider_title_height=($paramssld['slider_title_height']);
            $slider_title_margin="0";
        }  ?>

        width:<?php echo $slider_title_width; ?>%;
        /*height:<?php echo $slider_title_height; ?>%;*/

    <?php
        if($slideshow_title_position[0]=="left"){echo 'left:'.$slider_title_margin.'%;';}
        elseif($slideshow_title_position[0]=="center"){echo 'left:50%;';}
        elseif($slideshow_title_position[0]=="right"){echo 'right:'.$slider_title_margin.'%;';}

        if($slideshow_title_position[1]=="top"){echo 'top:'.$slider_title_margin.'%;';}
        elseif($slideshow_title_position[1]=="middle"){echo 'top:50%;';}
        elseif($slideshow_title_position[1]=="bottom"){echo 'bottom:'.$slider_title_margin.'%;';}
     ?>
        padding:2%;
        text-align:<?php echo $paramssld['slider_title_text_align']; ?>;
        font-weight:bold;
        color:#<?php echo $paramssld['slider_title_color']; ?>;

        background:<?php
				list($r,$g,$b) = array_map('hexdec',str_split($paramssld['slider_title_background_color'],2));
				$titleopacity=$paramssld["slider_title_background_transparency"]/100;						
				echo 'rgba('.$r.','.$g.','.$b.','.$titleopacity.')  !important'; 		
		?>;
        border-style:solid;
        font-size:<?php echo $paramssld['slider_title_font_size']; ?>px;
        border-width:<?php echo $paramssld['slider_title_border_size']; ?>px;
        border-color:#<?php echo $paramssld['slider_title_border_color']; ?>;
        border-radius:<?php echo $paramssld['slider_title_border_radius']; ?>px;
    }

    .huge_it_slideshow_description_text_<?php echo $sliderID; ?> {
        text-decoration: none;
        position: absolute;
        z-index: 11;
        border-style:solid;
        display: inline-block;
    <?php  if($paramssld['slider_description_has_margin']=='on'){
            $slider_description_width=($paramssld['slider_description_width']-6);
            $slider_description_height=($paramssld['slider_description_height']-6);
            $slider_description_margin="3";
        }else{
            $slider_description_width=($paramssld['slider_description_width']);
            $slider_descriptione_height=($paramssld['slider_description_height']);
            $slider_description_margin="0";
        }  ?>

        width:<?php echo $slider_description_width; ?>%;
        /*height:<?php echo $slider_description_height; ?>%;*/
    <?php
        if($slideshow_description_position[0]=="left"){echo 'left:'.$slider_description_margin.'%;';}
        elseif($slideshow_description_position[0]=="center"){echo 'left:50%;';}
        elseif($slideshow_description_position[0]=="right"){echo 'right:'.$slider_description_margin.'%;';}

        if($slideshow_description_position[1]=="top"){echo 'top:'.$slider_description_margin.'%;';}
        elseif($slideshow_description_position[1]=="middle"){echo 'top:50%;';}
        elseif($slideshow_description_position[1]=="bottom"){echo 'bottom:'.$slider_description_margin.'%;';}
     ?>
        padding:3%;
        text-align:<?php echo $paramssld['slider_description_text_align']; ?>;
        color:#<?php echo $paramssld['slider_description_color']; ?>;

        background:<?php
			list($r,$g,$b) = array_map('hexdec',str_split($paramssld['slider_description_background_color'],2));	
			$descriptionopacity=$paramssld["slider_description_background_transparency"]/100;
			echo 'rgba('.$r.','.$g.','.$b.','.$descriptionopacity.') !important';
		?>;
        border-style:solid;
        font-size:<?php echo $paramssld['slider_description_font_size']; ?>px;
        border-width:<?php echo $paramssld['slider_description_border_size']; ?>px;
        border-color:#<?php echo $paramssld['slider_description_border_color']; ?>;
        border-radius:<?php echo $paramssld['slider_description_border_radius']; ?>px;
    }

    .huge_it_slideshow_title_text_<?php echo $sliderID; ?>.none, .huge_it_slideshow_description_text_<?php echo $sliderID; ?>.none,
    .huge_it_slideshow_title_text_<?php echo $sliderID; ?>.hidden, .huge_it_slideshow_description_text_<?php echo $sliderID; ?>.hidden	   {display:none;}

    .huge_it_slideshow_title_text_<?php echo $sliderID; ?> h1, .huge_it_slideshow_description_text_<?php echo $sliderID; ?> h1,
    .huge_it_slideshow_title_text_<?php echo $sliderID; ?> h2, .huge_it_slideshow_title_text_<?php echo $sliderID; ?> h2,
    .huge_it_slideshow_title_text_<?php echo $sliderID; ?> h3, .huge_it_slideshow_title_text_<?php echo $sliderID; ?> h3,
    .huge_it_slideshow_title_text_<?php echo $sliderID; ?> h4, .huge_it_slideshow_title_text_<?php echo $sliderID; ?> h4,
    .huge_it_slideshow_title_text_<?php echo $sliderID; ?> p, .huge_it_slideshow_title_text_<?php echo $sliderID; ?> p,
    .huge_it_slideshow_title_text_<?php echo $sliderID; ?> strong,  .huge_it_slideshow_title_text_<?php echo $sliderID; ?> strong,
    .huge_it_slideshow_title_text_<?php echo $sliderID; ?> span, .huge_it_slideshow_title_text_<?php echo $sliderID; ?> span,
    .huge_it_slideshow_title_text_<?php echo $sliderID; ?> ul, .huge_it_slideshow_title_text_<?php echo $sliderID; ?> ul,
    .huge_it_slideshow_title_text_<?php echo $sliderID; ?> li, .huge_it_slideshow_title_text_<?php echo $sliderID; ?> li {
        padding:2px;
        margin:0px;
    }

    .huge_it_slider_<?php echo $sliderID; ?> {
        width: 100%;/*TODO check in foster*/
        height:100%;
        position: absolute;
        left: 0;
        display:block !important;
        padding:0px !important;
        margin:0px !important;

    }
    .huge_it_slideshow_image_item_<?php echo $sliderID; ?> {
        z-index: 1;
        margin:0px !important;
        padding:0px  !important;
        border-radius: <?php echo $paramssld['slider_slideshow_border_radius']; ?>px !important;
        float: left;
    }
    .huge_it_slideshow_image_second_item_<?php echo $sliderID; ?> {
        width:100%;
        height:100%;
        _width: inherit;
        _height: inherit;
        display: table-cell;
        filter: Alpha(opacity=0);
        opacity: 0;
        position: absolute;
        top:0px !important;
        left:0px !important;
        vertical-align: middle;
        overflow:hidden;
        margin:0px !important;
        visibility:visible !important;
        padding:0px  !important;
        border-radius: <?php echo $paramssld['slider_slideshow_border_radius']; ?>px !important;
    }

    .huge_it_slideshow_image_second_item_<?php echo $sliderID; ?> a, .huge_it_slideshow_image_item_<?php echo $sliderID; ?> a {
        display:inline-block;
    }

    .huge_it_grid_<?php echo $sliderID; ?> {
        display: none;
        height: 100%;
        overflow: hidden;
        position: absolute;
        width: 100%;
    }
    .huge_it_gridlet_<?php echo $sliderID; ?> {
        opacity: 1;
        filter: Alpha(opacity=100);
        position: absolute;
    }


    .huge_it_slideshow_dots_container_<?php echo $sliderID; ?> {
        display: table;
        position: absolute;
        width:100% !important;
        height:100% !important;
    }
    .huge_it_slideshow_dots_thumbnails_<?php echo $sliderID; ?> {
        margin: 0 auto;
        overflow: hidden;
        position: absolute;
        width:100%;
        height:30px;
    }

    .huge_it_slideshow_dots_<?php echo $sliderID; ?> {
        display: inline-block;
        position: relative;
        cursor: pointer;
        box-shadow: 1px 1px 1px rgba(0,0,0,0.1) inset, 1px 1px 1px rgba(255,255,255,0.1);
        width:10px;
        height: 10px;
        border-radius: 10px;
        background: #00f;
        margin: 10px;
        overflow: hidden;
        z-index: 17;
    }

    .huge_it_slideshow_dots_active_<?php echo $sliderID; ?> {
        opacity: 1;
        filter: Alpha(opacity=100);
    }
    .huge_it_slideshow_dots_deactive_<?php echo $sliderID; ?> {

    }



    .huge_it_slideshow_image_wrap_<?php echo $sliderID; ?> {
        background:#<?php echo $paramssld['slider_slider_background_color']; ?>;
        border-width:<?php echo $paramssld['slider_slideshow_border_size']; ?>px;
        border-color:#<?php echo $paramssld['slider_slideshow_border_color']; ?>;
        border-radius:<?php echo $paramssld['slider_slideshow_border_radius']; ?>px;
    }
    .huge_it_slideshow_image_wrap_<?php echo $sliderID; ?>.nocolor {
        background: transparent;
    }
    .huge_it_slideshow_dots_thumbnails_<?php echo $sliderID; ?> {
    <?php if($paramssld['slider_dots_position']=="bottom"){?>
        bottom:0px;
    <?php }else if($paramssld['slider_dots_position']=="none"){?>
        display:none;
    <?
    }else{ ?>
        top:0px; <?php } ?>
    }

    .huge_it_slideshow_dots_<?php echo $sliderID; ?> {
        background:#<?php echo $paramssld['slider_dots_color']; ?>;
    }

    .huge_it_slideshow_dots_active_<?php echo $sliderID; ?> {
        background:#<?php echo $paramssld['slider_active_dot_color']; ?>;
    }

    <?php

    $arrowfolder=plugins_url('slider-image/Front_images/arrows');
    switch ($paramssld['slider_navigation_type']) {
        case 1:
            ?>
    #huge_it_slideshow_left_<?php echo $sliderID; ?> {
        left:0px;
        margin-top:-21px;
        height:43px;
        width:29px;
        background:url(<?php echo $arrowfolder;?>/arrows.simple.png) left  top no-repeat;
    }

    #huge_it_slideshow_right_<?php echo $sliderID; ?> {
        right:0px;
        margin-top:-21px;
        height:43px;
        width:29px;
        background:url(<?php echo $arrowfolder;?>/arrows.simple.png) right top no-repeat;
    }
    <?php
    break;
case 2:
    ?>
    #huge_it_slideshow_left_<?php echo $sliderID; ?> {
        left:0px;
        margin-top:-25px;
        height:50px;
        width:50px;
        background:url(<?php echo $arrowfolder;?>/arrows.circle.shadow.png) left  top no-repeat;
    }

    #huge_it_slideshow_right_<?php echo $sliderID; ?> {
        right:0px;
        margin-top:-25px;
        height:50px;
        width:50px;
        background:url(<?php echo $arrowfolder;?>/arrows.circle.shadow.png) right top no-repeat;
    }

    #huge_it_slideshow_left_<?php echo $sliderID; ?>:hover {
        background-position:left -50px;
    }

    #huge_it_slideshow_right_<?php echo $sliderID; ?>:hover {
        background-position:right -50px;
    }
    <?php
    break;
case 3:
    ?>
    #huge_it_slideshow_left_<?php echo $sliderID; ?> {
        left:0px;
        margin-top:-22px;
        height:44px;
        width:44px;
        background:url(<?php echo $arrowfolder;?>/arrows.circle.simple.dark.png) left  top no-repeat;
    }

    #huge_it_slideshow_right_<?php echo $sliderID; ?> {
        right:0px;
        margin-top:-22px;
        height:44px;
        width:44px;
        background:url(<?php echo $arrowfolder;?>/arrows.circle.simple.dark.png) right top no-repeat;
    }

    #huge_it_slideshow_left_<?php echo $sliderID; ?>:hover {
        background-position:left -44px;
    }

    #huge_it_slideshow_right_<?php echo $sliderID; ?>:hover {
        background-position:right -44px;
    }
    <?php
    break;
case 4:
    ?>
    #huge_it_slideshow_left_<?php echo $sliderID; ?> {
        left:0px;
        margin-top:-33px;
        height:65px;
        width:59px;
        background:url(<?php echo $arrowfolder;?>/arrows.cube.dark.png) left  top no-repeat;
    }

    #huge_it_slideshow_right_<?php echo $sliderID; ?> {
        right:0px;
        margin-top:-33px;
        height:65px;
        width:59px;
        background:url(<?php echo $arrowfolder;?>/arrows.cube.dark.png) right top no-repeat;
    }

    #huge_it_slideshow_left_<?php echo $sliderID; ?>:hover {
        background-position:left -66px;
    }

    #huge_it_slideshow_right_<?php echo $sliderID; ?>:hover {
        background-position:right -66px;
    }
    <?php
    break;
case 5:
    ?>
    #huge_it_slideshow_left_<?php echo $sliderID; ?> {
        left:0px;
        margin-top:-18px;
        height:37px;
        width:40px;
        background:url(<?php echo $arrowfolder;?>/arrows.light.blue.png) left  top no-repeat;
    }

    #huge_it_slideshow_right_<?php echo $sliderID; ?> {
        right:0px;
        margin-top:-18px;
        height:37px;
        width:40px;
        background:url(<?php echo $arrowfolder;?>/arrows.light.blue.png) right top no-repeat;
    }

    <?php
    break;
case 6:
    ?>
    #huge_it_slideshow_left_<?php echo $sliderID; ?> {
        left:0px;
        margin-top:-25px;
        height:50px;
        width:50px;
        background:url(<?php echo $arrowfolder;?>/arrows.light.cube.png) left  top no-repeat;
    }

    #huge_it_slideshow_right_<?php echo $sliderID; ?> {
        right:0px;
        margin-top:-25px;
        height:50px;
        width:50px;
        background:url(<?php echo $arrowfolder;?>/arrows.light.cube.png) right top no-repeat;
    }

    #huge_it_slideshow_left_<?php echo $sliderID; ?>:hover {
        background-position:left -50px;
    }

    #huge_it_slideshow_right_<?php echo $sliderID; ?>:hover {
        background-position:right -50px;
    }
    <?php
    break;
case 7:
    ?>
    #huge_it_slideshow_left_<?php echo $sliderID; ?> {
        left:0px;
        right:0px;
        margin-top:-19px;
        height:38px;
        width:38px;
        background:url(<?php echo $arrowfolder;?>/arrows.light.transparent.circle.png) left  top no-repeat;
    }

    #huge_it_slideshow_right_<?php echo $sliderID; ?> {
        right:0px;
        margin-top:-19px;
        height:38px;
        width:38px;
        background:url(<?php echo $arrowfolder;?>/arrows.light.transparent.circle.png) right top no-repeat;
    }
    <?php
    break;
case 8:
    ?>
    #huge_it_slideshow_left_<?php echo $sliderID; ?> {
        left:0px;
        margin-top:-22px;
        height:45px;
        width:45px;
        background:url(<?php echo $arrowfolder;?>/arrows.png) left  top no-repeat;
    }

    #huge_it_slideshow_right_<?php echo $sliderID; ?> {
        right:0px;
        margin-top:-22px;
        height:45px;
        width:45px;
        background:url(<?php echo $arrowfolder;?>/arrows.png) right top no-repeat;
    }
    <?php
    break;
case 9:
    ?>
    #huge_it_slideshow_left_<?php echo $sliderID; ?> {
        left:0px;
        margin-top:-22px;
        height:45px;
        width:45px;
        background:url(<?php echo $arrowfolder;?>/arrows.circle.blue.png) left  top no-repeat;
    }

    #huge_it_slideshow_right_<?php echo $sliderID; ?> {
        right:0px;
        margin-top:-22px;
        height:45px;
        width:45px;
        background:url(<?php echo $arrowfolder;?>/arrows.circle.blue.png) right top no-repeat;
    }
    <?php
    break;
case 10:
    ?>
    #huge_it_slideshow_left_<?php echo $sliderID; ?> {
        left:0px;
        margin-top:-24px;
        height:48px;
        width:48px;
        background:url(<?php echo $arrowfolder;?>/arrows.circle.green.png) left  top no-repeat;
    }

    #huge_it_slideshow_right_<?php echo $sliderID; ?> {
        right:0px;
        margin-top:-24px;
        height:48px;
        width:48px;
        background:url(<?php echo $arrowfolder;?>/arrows.circle.green.png) right top no-repeat;
    }

    #huge_it_slideshow_left_<?php echo $sliderID; ?>:hover {
        background-position:left -48px;
    }

    #huge_it_slideshow_right_<?php echo $sliderID; ?>:hover {
        background-position:right -48px;
    }
    <?php
    break;
case 11:
    ?>
    #huge_it_slideshow_left_<?php echo $sliderID; ?> {
        left:0px;
        margin-top:-29px;
        height:58px;
        width:55px;
        background:url(<?php echo $arrowfolder;?>/arrows.blue.retro.png) left  top no-repeat;
    }

    #huge_it_slideshow_right_<?php echo $sliderID; ?> {
        right:0px;
        margin-top:-29px;
        height:58px;
        width:55px;
        background:url(<?php echo $arrowfolder;?>/arrows.blue.retro.png) right top no-repeat;
    }
    <?php
    break;
case 12:
    ?>
    #huge_it_slideshow_left_<?php echo $sliderID; ?> {
        left:0px;
        margin-top:-37px;
        height:74px;
        width:74px;
        background:url(<?php echo $arrowfolder;?>/arrows.green.retro.png) left  top no-repeat;
    }

    #huge_it_slideshow_right_<?php echo $sliderID; ?> {
        right:0px;
        margin-top:-37px;
        height:74px;
        width:74px;
        background:url(<?php echo $arrowfolder;?>/arrows.green.retro.png) right top no-repeat;
    }
    <?php
    break;
case 13:
    ?>
    #huge_it_slideshow_left_<?php echo $sliderID; ?> {
        left:0px;
        margin-top:-16px;
        height:33px;
        width:33px;
        background:url(<?php echo $arrowfolder;?>/arrows.red.circle.png) left  top no-repeat;
    }

    #huge_it_slideshow_right_<?php echo $sliderID; ?> {
        right:0px;
        margin-top:-16px;
        height:33px;
        width:33px;
        background:url(<?php echo $arrowfolder;?>/arrows.red.circle.png) right top no-repeat;
    }
    <?php
    break;
case 14:
    ?>
    #huge_it_slideshow_left_<?php echo $sliderID; ?> {
        left:0px;
        margin-top:-51px;
        height:102px;
        width:52px;
        background:url(<?php echo $arrowfolder;?>/arrows.triangle.white.png) left  top no-repeat;
    }

    #huge_it_slideshow_right_<?php echo $sliderID; ?> {
        right:0px;
        margin-top:-51px;
        height:102px;
        width:52px;
        background:url(<?php echo $arrowfolder;?>/arrows.triangle.white.png) right top no-repeat;
    }
    <?php
    break;
case 15:
    ?>
    #huge_it_slideshow_left_<?php echo $sliderID; ?> {
        left:0px;
        margin-top:-19px;
        height:39px;
        width:70px;
        background:url(<?php echo $arrowfolder;?>/arrows.ancient.png) left  top no-repeat;
    }

    #huge_it_slideshow_right_<?php echo $sliderID; ?> {
        right:0px;
        margin-top:-19px;
        height:39px;
        width:70px;
        background:url(<?php echo $arrowfolder;?>/arrows.ancient.png) right top no-repeat;
    }
    <?php
    break;
case 16:
    ?>
    #huge_it_slideshow_left_<?php echo $sliderID; ?> {
        left:-21px;
        margin-top:-20px;
        height:40px;
        width:37px;
        background:url(<?php echo $arrowfolder;?>/arrows.black.out.png) left  top no-repeat;
    }

    #huge_it_slideshow_right_<?php echo $sliderID; ?> {
        right:-21px;
        margin-top:-20px;
        height:40px;
        width:37px;
        background:url(<?php echo $arrowfolder;?>/arrows.black.out.png) right top no-repeat;
    }
    <?php
    break;
}
?>
</style>