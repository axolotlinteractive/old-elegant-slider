<?php
/**
 * Created by PhpStorm.
 * User: brycemeyer
 * Date: 4/28/15
 * Time: 12:16 AM
 */


?>
<script>
    var sliderEffect = '<?php echo $slidereffect;?>';
    var autoPlay = <?php echo isset($auto_play) && !$auto_play ? 0 : 1 ?>;
</script>
<?php

if ($hasvimeo==true) {
    ?>
    <script src="<?php echo plugins_url( 'js/vimeo.lib.js' , __FILE__ ) ?>"></script>
    <script>
        jQuery(function(){

            var vimeoPlayer = document.querySelector('iframe');

            var volumes = [];
            var colors = [];
            var i=0;
            <?php
            $i=0;
            foreach ($images as $key => $image_row) {
                if($image_row->sl_type=="video" and strpos($image_row->image_url,'vimeo') !== false) {
                    ?>
                    volumes[<?=$i?>] = '<?=intval($image_row->description) / 100?>';
                    colors[<?=$i?>] = '<?=$image_row->link_target?>';
                    <?php
                    $i++;
                }
            }
            ?>

            jQuery('iframe').each(function(){
                Froogaloop(this).addEvent('ready', vimeoReady);
            });
            jQuery(".sidedock,.controls").remove();
        });
        function vimeoReady(player_id) {

            froogaloop = $f(player_id);


            Froogaloop(player_id).api('setVolume',volumes[i]);
            Froogaloop(player_id).api('setColor', colors[i]);
            i++;

            froogaloop.addEvent('play', function() {
                video_is_playing_<?= $sliderID ?> = true;
            });
            froogaloop.addEvent('pause', function() {
                video_is_playing_<?= $sliderID; ?> = false;
            });
            jQuery('#huge_it_slideshow_left_<?php echo $sliderID; ?>, #huge_it_slideshow_right_<?php echo $sliderID; ?>,.huge_it_slideshow_dots_<?php echo $sliderID; ?>').click(function(){
                Froogaloop(player_id).api('pause');
            });
        }
    </script>
<?php
}
?>

<?php if ($hasyoutube==true){?>

    <script src="<?php echo plugins_url( 'js/youtube.lib.js' , __FILE__ ) ?>"></script>
    <script>
        <?php
        function get_youtube_id_from_url($url){
              if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match)) {
                  return $match[1];
              }
          }

          $i=0;
           foreach ($images as $key => $image_row) {
              if($image_row->sl_type=="video" and strpos($image_row->image_url,'youtu') !== false){
        ?>
        var player_<?php echo $image_row->id; ?>;
        <?php
                }else if (strpos($image_row->image_url,'vimeo') !== false){ ?>

        <?php
                }else{continue;}
                $i++;
            }
        ?>
        video_is_playing_<?php echo $sliderID; ?>=false;
        function onYouTubeIframeAPIReady() {
            <?php
            foreach ($images as $key => $image_row) {?>

            <?php if($image_row->sl_type=="video" and strpos($image_row->image_url,'youtube') !== false){
        ?>
            player_<?php echo $image_row->id; ?> = new YT.Player('video_id_<?php echo $sliderID; ?>_<?php echo $key;?>', {
                height: '<?php echo $sliderheight; ?>',
                width: '<?php echo $sliderwidth; ?>',
                videoId: '<?php echo get_youtube_id_from_url($image_row->image_url); ?>',
                playerVars: {
                    'controls': <?php if ($images[$key]->sl_url=="on"){ echo 1;}else{echo 0;} ?>,
                    'showinfo': <?php if ($images[$key]->link_target=="on"){ echo 1;}else{echo 0;} ?>
                },
                events: {
                    'onReady': onPlayerReady_<?php echo $image_row->id; ?>,
                    'onStateChange': onPlayerStateChange_<?php echo $image_row->id; ?>,
                    'loop':1
                }
            });
            <?php
                }else{continue;}
            }
            ?>
        }


        <?php
            foreach ($images as $key => $image_row) {
                if($image_row->sl_type=="video" and strpos($image_row->image_url,'youtube') !== false){
        ?>
        function onPlayerReady_<?php echo $image_row->id; ?>(event) {
            player_<?php echo $image_row->id; ?>.setVolume(<?php echo $images[$key]->description; ?>);
        }

        function onPlayerStateChange_<?php echo $image_row->id; ?>(event) {
            //(event.data);
            if (event.data == YT.PlayerState.PLAYING) {
                event.target.setPlaybackQuality('<?php echo $images[$key]->name; ?>');
                video_is_playing_<?php echo $sliderID; ?>=true;
            }
            else{
                video_is_playing_<?php echo $sliderID; ?>=false;
            }
        }
        <?php
                }else{continue;}

            }
        ?>
        function stopYoutubeVideo() {
            <?php
            $i=0;
            foreach ($images as $key => $image_row) {
                if($image_row->sl_type=="video" and strpos($image_row->image_url,'youtube') !== false){
            ?>
            player_<?php echo $image_row->id; ?>.pauseVideo();
            <?php
                }else{continue;}
                    $i++;
                }
            ?>
        }

    </script>
<?php } ?>


<script>
    var data_<?php echo $sliderID; ?> = [];
    var event_stack_<?php echo $sliderID; ?> = [];
    video_is_playing_<?php echo $sliderID; ?>=false;
    <?php
    //	$images=array_reverse($images);
        $recent_posts = wp_get_recent_posts( $args, ARRAY_A );

        $i=0;

        foreach($images as $image){
                  $imagerowstype=$image->sl_type;
                if($image->sl_type == ''){
                $imagerowstype='image';
                }
                switch($imagerowstype){

                    case 'image':
                        echo 'data_'.$sliderID.'["'.$i.'"]=[];';
                        echo 'data_'.$sliderID.'["'.$i.'"]["id"]="'.$i.'";';
                        echo 'data_'.$sliderID.'["'.$i.'"]["image_url"]="'.$image->image_url.'";';


                        $strdesription=str_replace('"',"'",$image->description);
                        $strdesription=preg_replace( "/\r|\n/", " ", $strdesription );
                        echo 'data_'.$sliderID.'["'.$i.'"]["description"]="'.$strdesription.'";';


                        $stralt=str_replace('"',"'",$image->name);
                        $stralt=preg_replace( "/\r|\n/", " ", $stralt );
                        echo 'data_'.$sliderID.'["'.$i.'"]["alt"]="'.$stralt.'";';
                        $i++;
                    break;

                    case 'video':
                        echo 'data_'.$sliderID.'["'.$i.'"]=[];';
                        echo 'data_'.$sliderID.'["'.$i.'"]["id"]="'.$i.'";';
                        echo 'data_'.$sliderID.'["'.$i.'"]["image_url"]="'.$image->image_url.'";';


                        $strdesription=str_replace('"',"'",$image->description);
                        $strdesription=preg_replace( "/\r|\n/", " ", $strdesription );
                        echo 'data_'.$sliderID.'["'.$i.'"]["description"]="'.$strdesription.'";';


                        $stralt=str_replace('"',"'",$image->name);
                        $stralt=preg_replace( "/\r|\n/", " ", $stralt );
                        echo 'data_'.$sliderID.'["'.$i.'"]["alt"]="'.$stralt.'";';
                        $i++;
                    break;


                    case 'last_posts':

                    foreach($recent_posts as $keyl => $recentimage){
                                            if($image->name == "0"){
                                                if(get_the_post_thumbnail($recentimage["ID"], 'thumbnail') != ''){
                                                        if($keyl < $image->sl_url){
                                                            echo 'data_'.$sliderID.'["'.$i.'"]=[];';
                                                            echo 'data_'.$sliderID.'["'.$i.'"]["id"]="'.$i.'";';
                                                            echo 'data_'.$sliderID.'["'.$i.'"]["image_url"]="'.$recentimage['guid'].'";';


                                                            $strdesription=str_replace('"',"'",$recentimage['post_content']);
                                                            $strdesription=preg_replace( "/\r|\n/", " ", $strdesription );
                                                            $strdesription=substr_replace($strdesription, "",$image->description);
                                                            echo 'data_'.$sliderID.'["'.$i.'"]["description"]="'.$strdesription.'";';


                                                            $stralt=str_replace('"',"'",$recentimage['post_title']);
                                                            $stralt=preg_replace( "/\r|\n/", " ", $stralt );
                                                            echo 'data_'.$sliderID.'["'.$i.'"]["alt"]="'.$stralt.'";';
                                                            $i++;
                                                        }
                                                    }
                                            }
                                            else{
                                                $category_id = get_cat_ID($image->name);                    //       my slider category id
                                                $category_id_from_posts = get_the_category($recentimage['ID']);  //       recent post id
    //                                            echo $category_id.' '.$category_id_from_posts[0]->term_id.'brrr';
                                                if($category_id == $category_id_from_posts[0]->term_id){
                                                    if(get_the_post_thumbnail($recentimage["ID"], 'thumbnail') != ''){
                                                        if($keyl < $image->sl_url){
                                                            echo 'data_'.$sliderID.'["'.$i.'"]=[];';
                                                            echo 'data_'.$sliderID.'["'.$i.'"]["id"]="'.$i.'";';
                                                            echo 'data_'.$sliderID.'["'.$i.'"]["image_url"]="'.$recentimage['guid'].'";';


                                                            $strdesription=str_replace('"',"'",$recentimage['post_content']);
                                                            $strdesription=preg_replace( "/\r|\n/", " ", $strdesription );
                                                            $strdesription=substr_replace($strdesription, "",$image->description);
                                                            echo 'data_'.$sliderID.'["'.$i.'"]["description"]="'.$strdesription.'";';


                                                            $stralt=str_replace('"',"'",$recentimage['post_title']);
                                                            $stralt=preg_replace( "/\r|\n/", " ", $stralt );
                                                            echo 'data_'.$sliderID.'["'.$i.'"]["alt"]="'.$stralt.'";';
                                                            $i++;
                                                        }
                                                    }
                                                }
                                            }

                    }

                    break;
            }


        }
    ?>



    var huge_it_trans_in_progress_<?php echo $sliderID; ?> = false;
    var huge_it_transition_duration_<?php echo $sliderID; ?> = <?php echo $slidechangespeed;?>;
    var huge_it_playInterval_<?php echo $sliderID; ?>;
    // Stop autoplay.
    window.clearInterval(huge_it_playInterval_<?php echo $sliderID; ?>);

    var huge_it_current_key_<?php echo $sliderID; ?> = '<?php echo (isset($current_key) ? $current_key : ''); ?>';
    function huge_it_move_dots_<?php echo $sliderID; ?>() {
        var image_left = jQuery(".huge_it_slideshow_dots_active_<?php echo $sliderID; ?>").position().left;
        var image_right = jQuery(".huge_it_slideshow_dots_active_<?php echo $sliderID; ?>").position().left + jQuery(".huge_it_slideshow_dots_active_<?php echo $sliderID; ?>").outerWidth(true);

    }
    function huge_it_testBrowser_cssTransitions_<?php echo $sliderID; ?>() {
        return huge_it_testDom_<?php echo $sliderID; ?>('Transition');
    }
    function huge_it_testBrowser_cssTransforms3d_<?php echo $sliderID; ?>() {
        return huge_it_testDom_<?php echo $sliderID; ?>('Perspective');
    }
    function huge_it_testDom_<?php echo $sliderID; ?>(prop) {
        // Browser vendor CSS prefixes.
        var browserVendors = ['', '-webkit-', '-moz-', '-ms-', '-o-', '-khtml-'];
        // Browser vendor DOM prefixes.
        var domPrefixes = ['', 'Webkit', 'Moz', 'ms', 'O', 'Khtml'];
        var i = domPrefixes.length;
        while (i--) {
            if (typeof document.body.style[domPrefixes[i] + prop] !== 'undefined') {
                return true;
            }
        }
        return false;
    }
    function huge_it_cube_<?php echo $sliderID; ?>(tz, ntx, nty, nrx, nry, wrx, wry, current_image_class, next_image_class, direction) {

        /* If browser does not support 3d transforms/CSS transitions.*/
        if (!huge_it_testBrowser_cssTransitions_<?php echo $sliderID; ?>()) {
            jQuery(".huge_it_slideshow_dots_<?php echo $sliderID; ?>").removeClass("huge_it_slideshow_dots_active_<?php echo $sliderID; ?>").addClass("huge_it_slideshow_dots_deactive_<?php echo $sliderID; ?>");
            jQuery("#huge_it_dots_" + huge_it_current_key_<?php echo $sliderID; ?> + "_<?php echo $sliderID; ?>").removeClass("huge_it_slideshow_dots_deactive_<?php echo $sliderID; ?>").addClass("huge_it_slideshow_dots_active_<?php echo $sliderID; ?>");
            return huge_it_fallback_<?php echo $sliderID; ?>(current_image_class, next_image_class, direction);
        }
        if (!huge_it_testBrowser_cssTransforms3d_<?php echo $sliderID; ?>()) {
            return huge_it_fallback3d_<?php echo $sliderID; ?>(current_image_class, next_image_class, direction);
        }
        //alert(current_image_class+' '+next_image_class);
        jQuery(current_image_class).css({'z-index': 'none'});
        jQuery(next_image_class).css({'z-index' : 2});
        huge_it_trans_in_progress_<?php echo $sliderID; ?> = true;
        /* Set active thumbnail.*/
        jQuery(".huge_it_slideshow_dots_<?php echo $sliderID; ?>").removeClass("huge_it_slideshow_dots_active_<?php echo $sliderID; ?>").addClass("huge_it_slideshow_dots_deactive_<?php echo $sliderID; ?>");
        jQuery("#huge_it_dots_" + huge_it_current_key_<?php echo $sliderID; ?> + "_<?php echo $sliderID; ?>").removeClass("huge_it_slideshow_dots_deactive_<?php echo $sliderID; ?>").addClass("huge_it_slideshow_dots_active_<?php echo $sliderID; ?>");
        jQuery(".huge_it_slide_bg_<?php echo $sliderID; ?>").css('perspective', 1000);
        jQuery(current_image_class).css({
            transform : 'translateZ(' + tz + 'px)',
            backfaceVisibility : 'hidden'
        });

        jQuery(".huge_it_slideshow_image_wrap_<?php echo $sliderID; ?>,.huge_it_slide_bg_<?php echo $sliderID; ?>,.huge_it_slideshow_image_item_<?php echo $sliderID; ?>,.huge_it_slideshow_image_second_item_<?php echo $sliderID; ?> ").css('overflow', 'visible');

        jQuery(next_image_class).css({
            opacity : 1,
            filter: 'Alpha(opacity=100)',
            backfaceVisibility : 'hidden',
            transform : 'translateY(' + nty + 'px) translateX(' + ntx + 'px) rotateY('+ nry +'deg) rotateX('+ nrx +'deg)'
        });
        jQuery(".huge_it_slider_<?php echo $sliderID; ?>").css({
            transform: 'translateZ(-' + tz + 'px)',
            transformStyle: 'preserve-3d'
        });
        /* Execution steps.*/
        setTimeout(function () {
            jQuery(".huge_it_slider_<?php echo $sliderID; ?>").css({
                transition: 'all ' + huge_it_transition_duration_<?php echo $sliderID; ?> + 'ms ease-in-out',
                transform: 'translateZ(-' + tz + 'px) rotateX('+ wrx +'deg) rotateY('+ wry +'deg)'
            });
        }, 20);
        /* After transition.*/
        jQuery(".huge_it_slider_<?php echo $sliderID; ?>").one('webkitTransitionEnd transitionend otransitionend oTransitionEnd mstransitionend', jQuery.proxy(huge_it_after_trans));
        function huge_it_after_trans() {
            /*if (huge_it_from_focus_<?php echo $sliderID; ?>) {
             huge_it_from_focus_<?php echo $sliderID; ?> = false;
             return;
             }*/
            jQuery(".huge_it_slide_bg_<?php echo $sliderID; ?>,.huge_it_slideshow_image_item_<?php echo $sliderID; ?>,.huge_it_slideshow_image_second_item_<?php echo $sliderID; ?> ").css('overflow', 'hidden');
            jQuery(".huge_it_slide_bg_<?php echo $sliderID; ?>").removeAttr('style');
            jQuery(current_image_class).removeAttr('style');
            jQuery(next_image_class).removeAttr('style');
            jQuery(".huge_it_slider_<?php echo $sliderID; ?>").removeAttr('style');
            // alert(current_image_class+' '+next_image_class);
            jQuery(current_image_class).css({'opacity' : 0, filter: 'Alpha(opacity=0)', 'z-index': 1});
            jQuery(next_image_class).css({'opacity' : 1, filter: 'Alpha(opacity=100)', 'z-index' : 2});
            // huge_it_change_watermark_container_<?php echo $sliderID; ?>();
            huge_it_trans_in_progress_<?php echo $sliderID; ?> = false;
            if (typeof event_stack_<?php echo $sliderID; ?> !== 'undefined' && event_stack_<?php echo $sliderID; ?>.length > 0) {
                key = event_stack_<?php echo $sliderID; ?>[0].split("-");
                event_stack_<?php echo $sliderID; ?>.shift();
                huge_it_change_image_<?php echo $sliderID; ?>(key[0], key[1], data_<?php echo $sliderID; ?>, true,false);
            }
        }
    }
    function huge_it_cubeH_<?php echo $sliderID; ?>(current_image_class, next_image_class, direction) {
        /* Set to half of image width.*/
        var dimension = jQuery(current_image_class).width() / 2;
        if (direction == 'right') {
            huge_it_cube_<?php echo $sliderID; ?>(dimension, dimension, 0, 0, 90, 0, -90, current_image_class, next_image_class, direction);
        }
        else if (direction == 'left') {
            huge_it_cube_<?php echo $sliderID; ?>(dimension, -dimension, 0, 0, -90, 0, 90, current_image_class, next_image_class, direction);
        }
    }
    function huge_it_cubeV_<?php echo $sliderID; ?>(current_image_class, next_image_class, direction) {
        /* Set to half of image height.*/
        var dimension = jQuery(current_image_class).height() / 2;
        /* If next slide.*/
        if (direction == 'right') {
            huge_it_cube_<?php echo $sliderID; ?>(dimension, 0, -dimension, 90, 0, -90, 0, current_image_class, next_image_class, direction);
        }
        else if (direction == 'left') {
            huge_it_cube_<?php echo $sliderID; ?>(dimension, 0, dimension, -90, 0, 90, 0, current_image_class, next_image_class, direction);
        }
    }
    /* For browsers that does not support transitions.*/
    function huge_it_fallback_<?php echo $sliderID; ?>(current_image_class, next_image_class, direction) {
        huge_it_fade_<?php echo $sliderID; ?>(current_image_class, next_image_class, direction);
    }
    /* For browsers that support transitions, but not 3d transforms (only used if primary transition makes use of 3d-transforms).*/
    function huge_it_fallback3d_<?php echo $sliderID; ?>(current_image_class, next_image_class, direction) {
        huge_it_sliceV_<?php echo $sliderID; ?>(current_image_class, next_image_class, direction);
    }
    function huge_it_none_<?php echo $sliderID; ?>(current_image_class, next_image_class, direction) {
        jQuery(current_image_class).css({'opacity' : 0, 'z-index': 1});
        jQuery(next_image_class).css({'opacity' : 1, 'z-index' : 2});

        /* Set active thumbnail.*/
        jQuery(".huge_it_slideshow_dots_<?php echo $sliderID; ?>").removeClass("huge_it_slideshow_dots_active_<?php echo $sliderID; ?>").addClass("huge_it_slideshow_dots_deactive_<?php echo $sliderID; ?>");
        jQuery("#huge_it_dots_" + huge_it_current_key_<?php echo $sliderID; ?> + "_<?php echo $sliderID; ?>").removeClass("huge_it_slideshow_dots_deactive_<?php echo $sliderID; ?>").addClass("huge_it_slideshow_dots_active_<?php echo $sliderID; ?>");
    }
    function huge_it_fade_<?php echo $sliderID; ?>(current_image_class, next_image_class, direction) {
        if (huge_it_testBrowser_cssTransitions_<?php echo $sliderID; ?>()) {

            jQuery(next_image_class).css('transition', 'opacity ' + huge_it_transition_duration_<?php echo $sliderID; ?> + 'ms linear');
            jQuery(current_image_class).css('transition', 'opacity ' + huge_it_transition_duration_<?php echo $sliderID; ?> + 'ms linear');
            jQuery(current_image_class).css({'opacity' : 0, 'z-index': 1});
            jQuery(next_image_class).css({'opacity' : 1, 'z-index' : 2});
        }
        else {

            jQuery(current_image_class).animate({'opacity' : 0, 'z-index' : 1}, huge_it_transition_duration_<?php echo $sliderID; ?>);
            jQuery(next_image_class).animate({
                'opacity' : 1,
                'z-index': 2
            }, {
                duration: huge_it_transition_duration_<?php echo $sliderID; ?>,
                complete: function () {return false;}
            });
            // For IE.
            jQuery(current_image_class).fadeTo(huge_it_transition_duration_<?php echo $sliderID; ?>, 0);
            jQuery(next_image_class).fadeTo(huge_it_transition_duration_<?php echo $sliderID; ?>, 1);
        }

        jQuery(".huge_it_slideshow_dots_<?php echo $sliderID; ?>").removeClass("huge_it_slideshow_dots_active_<?php echo $sliderID; ?>").addClass("huge_it_slideshow_dots_deactive_<?php echo $sliderID; ?>");
        jQuery("#huge_it_dots_" + huge_it_current_key_<?php echo $sliderID; ?> + "_<?php echo $sliderID; ?>").removeClass("huge_it_slideshow_dots_deactive_<?php echo $sliderID; ?>").addClass("huge_it_slideshow_dots_active_<?php echo $sliderID; ?>");
    }
    function huge_it_grid_<?php echo $sliderID; ?>(cols, rows, ro, tx, ty, sc, op, current_image_class, next_image_class, direction) {
        /* If browser does not support CSS transitions.*/
        if (!huge_it_testBrowser_cssTransitions_<?php echo $sliderID; ?>()) {
            jQuery(".huge_it_slideshow_dots_<?php echo $sliderID; ?>").removeClass("huge_it_slideshow_dots_active_<?php echo $sliderID; ?>").addClass("huge_it_slideshow_dots_deactive_<?php echo $sliderID; ?>");
            jQuery("#huge_it_dots_" + huge_it_current_key_<?php echo $sliderID; ?> + "_<?php echo $sliderID; ?>").removeClass("huge_it_slideshow_dots_deactive_<?php echo $sliderID; ?>").addClass("huge_it_slideshow_dots_active_<?php echo $sliderID; ?>");
            return huge_it_fallback_<?php echo $sliderID; ?>(current_image_class, next_image_class, direction);

        }
        huge_it_trans_in_progress_<?php echo $sliderID; ?> = true;
        /* Set active thumbnail.*/
        jQuery(".huge_it_slideshow_dots_<?php echo $sliderID; ?>").removeClass("huge_it_slideshow_dots_active_<?php echo $sliderID; ?>").addClass("huge_it_slideshow_dots_deactive_<?php echo $sliderID; ?>");
        jQuery("#huge_it_dots_" + huge_it_current_key_<?php echo $sliderID; ?> + "_<?php echo $sliderID; ?>").removeClass("huge_it_slideshow_dots_deactive_<?php echo $sliderID; ?>").addClass("huge_it_slideshow_dots_active_<?php echo $sliderID; ?>");
        /* The time (in ms) added to/subtracted from the delay total for each new gridlet.*/
        var count = (huge_it_transition_duration_<?php echo $sliderID; ?>) / (cols + rows);
        /* Gridlet creator (divisions of the image grid, positioned with background-images to replicate the look of an entire slide image when assembled)*/
        function huge_it_gridlet(width, height, top, img_top, left, img_left, src, imgWidth, imgHeight, c, r) {
            var delay = (c + r) * count;
            /* Return a gridlet elem with styles for specific transition.*/
            return jQuery('<div class="huge_it_gridlet_<?php echo $sliderID; ?>" />').css({
                width : width,
                height : height,
                top : top,
                left : left,
                backgroundImage : 'url("' + src + '")',
                backgroundColor: jQuery(".huge_it_slideshow_image_wrap_<?php echo $sliderID; ?>").css("background-color"),
                /*backgroundColor: rgba(0, 0, 0, 0),*/
                backgroundRepeat: 'no-repeat',
                backgroundPosition : img_left + 'px ' + img_top + 'px',
                backgroundSize : imgWidth + 'px ' + imgHeight + 'px',
                transition : 'all ' + huge_it_transition_duration_<?php echo $sliderID; ?> + 'ms ease-in-out ' + delay + 'ms',
                transform : 'none'
            });
        }
        /* Get the current slide's image.*/
        var cur_img = jQuery(current_image_class).find('img');
        /* Create a grid to hold the gridlets.*/
        var grid = jQuery('<div />').addClass('huge_it_grid_<?php echo $sliderID; ?>');
        /* Prepend the grid to the next slide (i.e. so it's above the slide image).*/
        jQuery(current_image_class).prepend(grid);
        /* vars to calculate positioning/size of gridlets*/
        var cont = jQuery(".huge_it_slide_bg_<?php echo $sliderID; ?>");
        var imgWidth = cur_img.width();
        var imgHeight = cur_img.height();
        var contWidth = cont.width(),
            contHeight = cont.height(),
            imgSrc = cur_img.attr('src'),/*.replace('/thumb', ''),*/
            colWidth = Math.floor(contWidth / cols),
            rowHeight = Math.floor(contHeight / rows),
            colRemainder = contWidth - (cols * colWidth),
            colAdd = Math.ceil(colRemainder / cols),
            rowRemainder = contHeight - (rows * rowHeight),
            rowAdd = Math.ceil(rowRemainder / rows),
            leftDist = 0,
            img_leftDist = (jQuery(".huge_it_slide_bg_<?php echo $sliderID; ?>").width() - cur_img.width()) / 2;
        /* tx/ty args can be passed as 'auto'/'min-auto' (meaning use slide width/height or negative slide width/height).*/
        tx = tx === 'auto' ? contWidth : tx;
        tx = tx === 'min-auto' ? - contWidth : tx;
        ty = ty === 'auto' ? contHeight : ty;
        ty = ty === 'min-auto' ? - contHeight : ty;
        /* Loop through cols*/
        for (var i = 0; i < cols; i++) {
            var topDist = 0,
                img_topDst = (jQuery(".huge_it_slide_bg_<?php echo $sliderID; ?>").height() - cur_img.height()) / 2,
                newColWidth = colWidth;
            /* If imgWidth (px) does not divide cleanly into the specified number of cols, adjust individual col widths to create correct total.*/
            if (colRemainder > 0) {
                var add = colRemainder >= colAdd ? colAdd : colRemainder;
                newColWidth += add;
                colRemainder -= add;
            }
            /* Nested loop to create row gridlets for each col.*/
            for (var j = 0; j < rows; j++)  {
                var newRowHeight = rowHeight,
                    newRowRemainder = rowRemainder;
                /* If contHeight (px) does not divide cleanly into the specified number of rows, adjust individual row heights to create correct total.*/
                if (newRowRemainder > 0) {
                    add = newRowRemainder >= rowAdd ? rowAdd : rowRemainder;
                    newRowHeight += add;
                    newRowRemainder -= add;
                }
                /* Create & append gridlet to grid.*/
                grid.append(huge_it_gridlet(newColWidth, newRowHeight, topDist, img_topDst, leftDist, img_leftDist, imgSrc, imgWidth, imgHeight, i, j));
                topDist += newRowHeight;
                img_topDst -= newRowHeight;
            }
            img_leftDist -= newColWidth;
            leftDist += newColWidth;
        }
        /* Set event listener on last gridlet to finish transitioning.*/
        var last_gridlet = grid.children().last();
        /* Show grid & hide the image it replaces.*/
        grid.show();
        cur_img.css('opacity', 0);
        /* Add identifying classes to corner gridlets (useful if applying border radius).*/
        grid.children().first().addClass('rs-top-left');
        grid.children().last().addClass('rs-bottom-right');
        grid.children().eq(rows - 1).addClass('rs-bottom-left');
        grid.children().eq(- rows).addClass('rs-top-right');
        /* Execution steps.*/
        setTimeout(function () {
            grid.children().css({
                opacity: op,
                transform: 'rotate('+ ro +'deg) translateX('+ tx +'px) translateY('+ ty +'px) scale('+ sc +')'
            });
        }, 1);
        jQuery(next_image_class).css('opacity', 1);
        /* After transition.*/
        jQuery(last_gridlet).one('webkitTransitionEnd transitionend otransitionend oTransitionEnd mstransitionend', jQuery.proxy(huge_it_after_trans));
        function huge_it_after_trans() {
            jQuery(current_image_class).css({'opacity' : 0, 'z-index': 1});
            jQuery(next_image_class).css({'opacity' : 1, 'z-index' : 2});
            cur_img.css('opacity', 1);
            grid.remove();
            huge_it_trans_in_progress_<?php echo $sliderID; ?> = false;
            if (typeof event_stack_<?php echo $sliderID; ?> !== 'undefined' && event_stack_<?php echo $sliderID; ?>.length > 0) {
                key = event_stack_<?php echo $sliderID; ?>[0].split("-");
                event_stack_<?php echo $sliderID; ?>.shift();
                huge_it_change_image_<?php echo $sliderID; ?>(key[0], key[1], data_<?php echo $sliderID; ?>, true,false);
            }
        }
    }
    function huge_it_sliceH_<?php echo $sliderID; ?>(current_image_class, next_image_class, direction) {
        if (direction == 'right') {
            var translateX = 'min-auto';
        }
        else if (direction == 'left') {
            var translateX = 'auto';
        }
        huge_it_grid_<?php echo $sliderID; ?>(1, 8, 0, translateX, 0, 1, 0, current_image_class, next_image_class, direction);
    }
    function huge_it_sliceV_<?php echo $sliderID; ?>(current_image_class, next_image_class, direction) {
        if (direction == 'right') {
            var translateY = 'min-auto';
        }
        else if (direction == 'left') {
            var translateY = 'auto';
        }
        huge_it_grid_<?php echo $sliderID; ?>(10, 1, 0, 0, translateY, 1, 0, current_image_class, next_image_class, direction);
    }
    function huge_it_slideV_<?php echo $sliderID; ?>(current_image_class, next_image_class, direction) {
        if (direction == 'right') {
            var translateY = 'auto';
        }
        else if (direction == 'left') {
            var translateY = 'min-auto';
        }
        huge_it_grid_<?php echo $sliderID; ?>(1, 1, 0, 0, translateY, 1, 1, current_image_class, next_image_class, direction);
    }
    function huge_it_slideH_<?php echo $sliderID; ?>(current_image_class, next_image_class, direction) {
        if (direction == 'right') {
            var translateX = 'min-auto';
        }
        else if (direction == 'left') {
            var translateX = 'auto';
        }
        huge_it_grid_<?php echo $sliderID; ?>(1, 1, 0, translateX, 0, 1, 1, current_image_class, next_image_class, direction);
    }
    function huge_it_scaleOut_<?php echo $sliderID; ?>(current_image_class, next_image_class, direction) {
        huge_it_grid_<?php echo $sliderID; ?>(1, 1, 0, 0, 0, 1.5, 0, current_image_class, next_image_class, direction);
    }
    function huge_it_scaleIn_<?php echo $sliderID; ?>(current_image_class, next_image_class, direction) {
        huge_it_grid_<?php echo $sliderID; ?>(1, 1, 0, 0, 0, 0.5, 0, current_image_class, next_image_class, direction);
    }
    function huge_it_blockScale_<?php echo $sliderID; ?>(current_image_class, next_image_class, direction) {
        huge_it_grid_<?php echo $sliderID; ?>(8, 6, 0, 0, 0, .6, 0, current_image_class, next_image_class, direction);
    }
    function huge_it_kaleidoscope_<?php echo $sliderID; ?>(current_image_class, next_image_class, direction) {
        huge_it_grid_<?php echo $sliderID; ?>(10, 8, 0, 0, 0, 1, 0, current_image_class, next_image_class, direction);
    }
    function huge_it_fan_<?php echo $sliderID; ?>(current_image_class, next_image_class, direction) {
        if (direction == 'right') {
            var rotate = 45;
            var translateX = 100;
        }
        else if (direction == 'left') {
            var rotate = -45;
            var translateX = -100;
        }
        huge_it_grid_<?php echo $sliderID; ?>(1, 10, rotate, translateX, 0, 1, 0, current_image_class, next_image_class, direction);
    }
    function huge_it_blindV_<?php echo $sliderID; ?>(current_image_class, next_image_class, direction) {
        huge_it_grid_<?php echo $sliderID; ?>(1, 8, 0, 0, 0, .7, 0, current_image_class, next_image_class);
    }
    function huge_it_blindH_<?php echo $sliderID; ?>(current_image_class, next_image_class, direction) {
        huge_it_grid_<?php echo $sliderID; ?>(10, 1, 0, 0, 0, .7, 0, current_image_class, next_image_class);
    }
    function huge_it_random_<?php echo $sliderID; ?>(current_image_class, next_image_class, direction) {
        var anims = ['sliceH', 'sliceV', 'slideH', 'slideV', 'scaleOut', 'scaleIn', 'blockScale', 'kaleidoscope', 'fan', 'blindH', 'blindV'];
        /* Pick a random transition from the anims array.*/
        this["huge_it_" + anims[Math.floor(Math.random() * anims.length)] + "_<?php echo $sliderID; ?>"](current_image_class, next_image_class, direction);
    }

    function iterator_<?php echo $sliderID; ?>() {
        var iterator = 1;

        return iterator;
    }

    function huge_it_change_image_<?php echo $sliderID; ?>(current_key, key, data_<?php echo $sliderID; ?>, from_effect,clicked) {

        if (data_<?php echo $sliderID; ?>[key]) {

            if(video_is_playing_<?php echo $sliderID; ?> && !clicked){
                return false;
            }



            if (!from_effect) {
                // Change image key.
                jQuery("#huge_it_current_image_key_<?php echo $sliderID; ?>").val(key);
                // if (current_key == '-2') { /* Dots.*/
                current_key = jQuery(".huge_it_slideshow_dots_active_<?php echo $sliderID; ?>").attr("image_key");
                //  }
            }

            if (huge_it_trans_in_progress_<?php echo $sliderID; ?>) {
                //errorlogjQuery(".huge_it_slideshow_image_wrap_<?php echo $sliderID; ?>").after(" --IN TRANSACTION-- <br />");
                event_stack_<?php echo $sliderID; ?>.push(current_key + '-' + key);
                return;
            }

            var direction = 'right';
            if (huge_it_current_key_<?php echo $sliderID; ?> > key) {
                var direction = 'left';
            }
            else if (huge_it_current_key_<?php echo $sliderID; ?> == key) {
                return false;
            }

            // Set active thumbnail position.

            huge_it_current_key_<?php echo $sliderID; ?> = key;
            //Change image id, title, description.
            jQuery("#huge_it_slideshow_image_<?php echo $sliderID; ?>").attr('image_id', data_<?php echo $sliderID; ?>[key]["id"]);


            jQuery(".huge_it_slideshow_title_text_<?php echo $sliderID; ?>").html(data_<?php echo $sliderID; ?>[key]["alt"]);
            jQuery(".huge_it_slideshow_description_text_<?php echo $sliderID; ?>").html(data_<?php echo $sliderID; ?>[key]["description"]);

            var current_image_class = "#image_id_<?php echo $sliderID; ?>_" + data_<?php echo $sliderID; ?>[current_key]["id"];
            var next_image_class = "#image_id_<?php echo $sliderID; ?>_" + data_<?php echo $sliderID; ?>[key]["id"];



            if(jQuery(current_image_class).find('.huge_it_video_frame_<?php echo $sliderID; ?>').length>0) {
                var streffect='<?php echo $slidereffect; ?>';
                if(streffect=="cubeV" || streffect=="cubeH" || streffect=="none" || streffect=="fade"){
                    huge_it_<?php echo $slidereffect; ?>_<?php echo $sliderID; ?>(current_image_class, next_image_class, direction);
                }else{
                    huge_it_fade_<?php echo $sliderID; ?>(current_image_class, next_image_class, direction);
                }
            }else{
                huge_it_<?php echo $slidereffect; ?>_<?php echo $sliderID; ?>(current_image_class, next_image_class, direction);
            }


            jQuery('.huge_it_slideshow_title_text_<?php echo $sliderID; ?>').removeClass('none');
            if(jQuery('.huge_it_slideshow_title_text_<?php echo $sliderID; ?>').html()==""){jQuery('.huge_it_slideshow_title_text_<?php echo $sliderID; ?>').addClass('none');}

            jQuery('.huge_it_slideshow_description_text_<?php echo $sliderID; ?>').removeClass('none');
            if(jQuery('.huge_it_slideshow_description_text_<?php echo $sliderID; ?>').html()==""){jQuery('.huge_it_slideshow_description_text_<?php echo $sliderID; ?>').addClass('none');}



            jQuery(current_image_class).find('.huge_it_slideshow_title_text_<?php echo $sliderID; ?>').addClass('none');
            jQuery(current_image_class).find('.huge_it_slideshow_description_text_<?php echo $sliderID; ?>').addClass('none');




            //errorlogjQuery(".huge_it_slideshow_image_wrap_<?php echo $sliderID; ?>").after("--cur-key="+current_key+" --cur-img-class="+current_image_class+" nxt-img-class="+next_image_class+"--");
            huge_it_move_dots_<?php echo $sliderID; ?>();
            <?php foreach ($images as $key => $image_row) {if($image_row->sl_type=="video" and strpos($image_row->image_url,'youtube') !== false){	?>
            stopYoutubeVideo();
            <?php } } ?>
            window.clearInterval(huge_it_playInterval_<?php echo $sliderID; ?>);
            play_<?php echo $sliderID; ?>();
        }

    }

    function huge_it_popup_resize_<?php echo $sliderID; ?>() {

        var staticsliderwidth=<?php echo $sliderwidth;?>;
        var sliderwidth=<?php echo $sliderwidth;?>;
        var overflowVisible=<?php echo $overflowVisible?>

        var bodyWidth=jQuery(window).width();
        var parentWidth = jQuery(".huge_it_slideshow_image_wrap_<?php echo $sliderID; ?>").parent().width();
        //if responsive js late responsive.js @  take body size and not parent div
        if(sliderwidth>parentWidth){sliderwidth=parentWidth;}
        if(sliderwidth>bodyWidth){sliderwidth=bodyWidth;}

        var str=(<?php echo $sliderheight;?>/staticsliderwidth);

        var newHeight = (sliderwidth) * str;

        jQuery(".huge_it_slideshow_image_wrap_<?php echo $sliderID; ?>").css({width: (sliderwidth)});
        jQuery(".huge_it_slideshow_image_wrap_<?php echo $sliderID; ?>").css({height: (newHeight)});
        jQuery(".huge_it_slideshow_image_container_<?php echo $sliderID; ?>").css({width: overflowVisible ? '100%' : (sliderwidth)});
        jQuery(".huge_it_slideshow_image_container_<?php echo $sliderID; ?>").css({height: (newHeight)});
        jQuery.each(jQuery(".huge_it_slideshow_image_container_<?php echo $sliderID; ?> img"), function(index, img){
            var currentHeight = jQuery(img).height();
            var currentWidth = jQuery(img).width();
            var newWidth = newHeight * currentWidth / currentHeight;
            jQuery(img).width(newWidth);
            jQuery(img).height(newHeight);
        });
        if(sliderEffect == "slideCenter")
            changeLeftPosition();

        if("<?php echo $slideshow_title_position[1]; ?>"=="middle"){var titlemargintopminus=jQuery(".huge_it_slideshow_title_text_<?php echo $sliderID; ?>").outerHeight()/2;}
        if("<?php echo $slideshow_title_position[0]; ?>"=="center"){var titlemarginleftminus=jQuery(".huge_it_slideshow_title_text_<?php echo $sliderID; ?>").outerWidth()/2;}
        jQuery(".huge_it_slideshow_title_text_<?php echo $sliderID; ?>").css({cssText: "margin-top:-" + titlemargintopminus + "px; margin-left:-"+titlemarginleftminus+"px;"});

        if("<?php echo $slideshow_description_position[1]; ?>"=="middle"){var descriptionmargintopminus=jQuery(".huge_it_slideshow_description_text_<?php echo $sliderID; ?>").outerHeight()/2;}
        if("<?php echo $slideshow_description_position[0]; ?>"=="center"){var descriptionmarginleftminus=jQuery(".huge_it_slideshow_description_text_<?php echo $sliderID; ?>").outerWidth()/2;}
        jQuery(".huge_it_slideshow_description_text_<?php echo $sliderID; ?>").css({cssText: "margin-top:-" + descriptionmargintopminus + "px; margin-left:-"+descriptionmarginleftminus+"px;"});
        jQuery("#huge_it_loading_image_<?php echo $sliderID; ?>").css({display: "none"});
        jQuery(".huge_it_slideshow_image_wrap1_<?php echo $sliderID; ?>").css({display: "block"});
        jQuery(".huge_it_slideshow_image_wrap_<?php echo $sliderID; ?>").removeClass("nocolor");



        jQuery('.huge_it_video_frame_<?php echo $sliderID; ?>').each(function (e) {
            jQuery(this).width(sliderwidth);
            jQuery(this).height(sliderwidth * str);
        });
    }

    jQuery(window).load(function () {

        var width = 0;
        jQuery.each(jQuery(".elegant_slider_item"), function(index, sliderItem) {
            width+= jQuery(sliderItem).width();
        });
        width+= 20;//extra width doesnt hurt, and it helps us on firefox/ie
        jQuery(".elegant_slider").width(width);
        <?=$fancybox && $startFancy ? 'jQuery(".fancybox").fancybox();' : '' ?>
        jQuery(window).resize(function() {
            huge_it_popup_resize_<?php echo $sliderID; ?>();
        });

        jQuery('#huge_it_slideshow_left_<?php echo $sliderID; ?>').on('click',function(){
            switch (sliderEffect) {
                case "slideCenter":
                    moveCenterSlide(jQuery(this), -1);
                    break;
                default:
                    huge_it_change_image_<?php echo $sliderID; ?>(parseInt(jQuery('#huge_it_current_image_key_<?php echo $sliderID; ?>').val()), (parseInt(jQuery('#huge_it_current_image_key_<?php echo $sliderID; ?>').val()) - iterator_<?php echo $sliderID; ?>()) >= 0 ? (parseInt(jQuery('#huge_it_current_image_key_<?php echo $sliderID; ?>').val()) - iterator_<?php echo $sliderID; ?>()) % data_<?php echo $sliderID; ?>.length : data_<?php echo $sliderID; ?>.length - 1, data_<?php echo $sliderID; ?>, false, true);
                    break;
            }
            return false;
        });

        jQuery('#huge_it_slideshow_right_<?php echo $sliderID; ?>').on('click',function(){
            switch (sliderEffect) {
                case "slideCenter":
                    moveCenterSlide(jQuery(this), 1);
                    break;
                default:
                    huge_it_change_image_<?php echo $sliderID; ?>(parseInt(jQuery('#huge_it_current_image_key_<?php echo $sliderID; ?>').val()), (parseInt(jQuery('#huge_it_current_image_key_<?php echo $sliderID; ?>').val()) + iterator_<?php echo $sliderID; ?>()) % data_<?php echo $sliderID; ?>.length, data_<?php echo $sliderID; ?>, false, true);
                    break;
            }
            return false;
        });

        huge_it_popup_resize_<?php echo $sliderID; ?>();
        /* Disable right click.*/
        jQuery('div[id^="huge_it_container"]').bind("contextmenu", function () {
            return false;
        });

        /*HOVER SLIDESHOW*/
        var pausehover="<?php echo $sliderpauseonhover;?>";
        if(pausehover=="on"){
            jQuery("#huge_it_slideshow_image_container_<?php echo $sliderID; ?>, .huge_it_slideshow_image_container_<?php echo $sliderID; ?>, .huge_it_slideshow_dots_container_<?php echo $sliderID; ?>,#huge_it_slideshow_right_<?php echo $sliderID; ?>,#huge_it_slideshow_left_<?php echo $sliderID; ?>").hover(function(){
                window.clearInterval(huge_it_playInterval_<?php echo $sliderID; ?>);
            },function(){
                window.clearInterval(huge_it_playInterval_<?php echo $sliderID; ?>);
                play_<?php echo $sliderID; ?>();
            });
        }
        play_<?php echo $sliderID; ?>();
    });

    function play_<?php echo $sliderID; ?>() {
        if(autoPlay) {
            /* Play.*/
            //errorlogjQuery(".huge_it_slideshow_image_wrap_<?php echo $sliderID; ?>").after(" -- paly  ---- ");
            huge_it_playInterval_<?php echo $sliderID; ?> = setInterval(function () {
                //errorlogjQuery(".huge_it_slideshow_image_wrap_<?php echo $sliderID; ?>").after(" -- time left ---- ");
                var iterator = 1;
                var activeImage = parseInt(jQuery('#huge_it_current_image_key_<?php echo $sliderID; ?>').val());
                var nextImage = (parseInt(jQuery('#huge_it_current_image_key_<?php echo $sliderID; ?>').val()) + iterator) % data_<?php echo $sliderID; ?>.length;
                huge_it_change_image_<?php echo $sliderID; ?>(activeImage, nextImage, data_<?php echo $sliderID; ?>,false,false);
            }, '<?php echo $slidepausetime; ?>');
        }
    }

    jQuery(window).focus(function() {
        /*event_stack_<?php echo $sliderID; ?> = [];*/
        var i_<?php echo $sliderID; ?> = 0;
        jQuery(".huge_it_slider_<?php echo $sliderID; ?>").children("div").each(function () {
            if (jQuery(this).css('opacity') == 1) {
                jQuery("#huge_it_current_image_key_<?php echo $sliderID; ?>").val(i_<?php echo $sliderID; ?>);
            }
            i_<?php echo $sliderID; ?>++;
        });
    });
    jQuery(window).blur(function() {
        event_stack_<?php echo $sliderID; ?> = [];
        window.clearInterval(huge_it_playInterval_<?php echo $sliderID; ?>);
    });

    //start better code
    function moveCenterSlide($arrow, direction) {
        var $dotsContainer = $arrow.parent(".elegant_slideshow_dots_container");
        var $imageContainer = $dotsContainer.siblings(".elegant_slideshow_image_container");
        var $activeImageContainer = $imageContainer.find(".active");
        var $sliderItems = $imageContainer.find(".elegant_slider_item");
        var currentPosition = $activeImageContainer.data("position") - 0;
        var nextPosition = currentPosition + direction;
        if(nextPosition == $sliderItems.length)
            nextPosition = 0;
        if(nextPosition < 0)
            nextPosition = $sliderItems.length - 1;
        var nextImageContainer = $sliderItems[nextPosition];
        $activeImageContainer.removeClass("active");
        jQuery(nextImageContainer).addClass("active");

        changeLeftPosition();
    }

    function changeLeftPosition() {

        var  $elegantSlideshowContainer = jQuery(".elegant_slideshow_image_container");
        var  activeContainer = $elegantSlideshowContainer.find(".active");
        var $elegantSlider = $elegantSlideshowContainer.find(".elegant_slider");

        var  newLeft =  activeContainer.get(0).offsetLeft -
            ($elegantSlideshowContainer.width() / 2 - jQuery(activeContainer).find("img").width() / 2);
        $elegantSlider.clearQueue();
        $elegantSlider.stop();
        $elegantSlider.animate({left : - newLeft});
    }
</script>