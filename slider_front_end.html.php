<?php
//TODO put in auto loader
require("classes/AssetPipeline.php");
require("classes/CSSAsset.php");

use WordWrap\CSSAsset;

function front_end_slider($images, $paramssld, $slider)
{
    $imageLink = false;//TODO make dynamic
 ob_start();
    $fancybox = $slider[0]->fancybox;
    $overflowVisible = true;
    $startFancy = $slider[0]->default_fancybox;
    $auto_play = $slider[0]->autoplay;
	$sliderID=$slider[0]->id;
	$slidertitle=$slider[0]->name;
	$sliderheight=$slider[0]->sl_height;
	$sliderwidth=$slider[0]->sl_width;
	$slidereffect=$slider[0]->slider_list_effects_s;
	$slidepausetime=($slider[0]->description+$slider[0]->param);
	$sliderpauseonhover=$slider[0]->pause_on_hover;
	$sliderposition=$slider[0]->sl_position;
	$slidechangespeed=$slider[0]->param;
	$sliderloadingicon=$slider[0]->sl_loading_icon;
	
	$trim_slideshow_title_position =trim($paramssld['slider_title_position']);
	$slideshow_title_position = explode('-', $trim_slideshow_title_position);
	$trim_slideshow_description_position = trim($paramssld['slider_description_position']);
	$slideshow_description_position = explode('-', $trim_slideshow_description_position);


    if ($fancybox) {
        wp_enqueue_script("fancy_box_js", plugins_url("js/jquery.fancybox.pack.js", __FILE__), FALSE);
        wp_enqueue_style("fancy_box_css", plugins_url("style/jquery.fancybox.css", __FILE__), FALSE);
    }

	$hasyoutube=false;
	$hasvimeo=false;
	foreach ($images as $key => $image_row) {
		if(strpos($image_row->image_url,'youtube') !== false || strpos($image_row->image_url,'youtu.be') !== false){$hasyoutube=true;}
		if(strpos($image_row->image_url,'vimeo') !== false){$hasvimeo=true;}
	}

    require("slider_front_end.js.php");
	require("slider_front_end.css.old.php");

    $cssAssets = new CSSAsset(plugin_dir_path( __FILE__ ) . "style/");
    if($slidereffect == "fade")
        $cssAssets->addAsset("sliders/" . $slidereffect);
    $cssAssets->dumpAssets();
		  	  $args = array(
    'numberposts' => 10,
    'offset' => 0,
    'category' => 0,
    'orderby' => 'post_date',
    'order' => 'DESC',
    'post_type' => 'post',
    'post_status' => 'draft, publish, future, pending, private',
    'suppress_filters' => true );

    $recent_posts = wp_get_recent_posts( $args, ARRAY_A );
	//print_r($recent_posts);
	//echo get_the_post_thumbnail(1, 'thumbnail');
 $image = wp_get_attachment_image_src( get_post_thumbnail_id( 1 ), 'thumbnail' );

	?>
<?php if($sliderloadingicon == "on")	{ ?>
<div class="elegant_slideshow_image_wrap huge_it_slideshow_image_wrap_<?php echo $sliderID; ?> nocolor">
<?php } else { ?>
<div class="elegant_slideshow_image_wrap huge_it_slideshow_image_wrap_<?php echo $sliderID; ?> ">
<?php } ?>
	<?php if($sliderloadingicon == "on")	{ ?>
		<div id="huge_it_loading_image_<?php echo $sliderID;  ?>" class="display" ><img  src="<?php echo plugins_url('', __FILE__).'/Front_images/loading/loading'.$paramssld["loading_icon_type"].'.gif'; ?>"/> </div>
		<div class="huge_it_slideshow_image_wrap1_<?php echo $sliderID; ?> nodisplay">
	<?php } else { ?>
		<div id="huge_it_loading_image_<?php echo $sliderID; ?>" class="nodisplay"> <img src="<?php echo plugins_url('', __FILE__).'/Front_images/loading/loading'.$paramssld["loading_icon_type"].'.gif'; ?>" width="100" height="100" style=" margin: 0px auto;" /> </div>
		<div class="huge_it_slideshow_image_wrap1_<?php echo $sliderID; ?>"class="display">
	<?php } ?>
      <?php
      $current_pos = 0;
      ?>
		<!-- ##########################DOTS######################### -->
        <div class="elegant_slideshow_dots_container huge_it_slideshow_dots_container_<?php echo $sliderID; ?>">
			  <div class="elegant_dots_container huge_it_slideshow_dots_thumbnails_<?php echo $sliderID; ?>">
				<?php
				$current_image_id=0;
				$current_pos =0;
				$current_key=0;
				$stri=0;
				foreach ($images as $key => $image_row) {
			  	$imagerowstype=$image_row->sl_type;
				if($image_row->sl_type == ''){
				$imagerowstype='image';
				}
				switch($imagerowstype){
							
							case 'image':
											
							  if ($image_row->id == $current_image_id) {
								$current_pos = $stri;
								$current_key = $stri;
							  }

							?>
								<div id="huge_it_dots_<?php echo $stri; ?>_<?php echo $sliderID; ?>" class="huge_it_slideshow_dots_<?php echo $sliderID; ?> <?php echo (($key==$current_image_id) ? 'huge_it_slideshow_dots_active_' . $sliderID : 'huge_it_slideshow_dots_deactive_' . $sliderID); ?>" onclick="huge_it_change_image_<?php echo $sliderID; ?>(parseInt(jQuery('#huge_it_current_image_key_<?php echo $sliderID; ?>').val()), '<?php echo $stri; ?>', data_<?php echo $sliderID; ?>,false,true);return false;" image_id="<?php echo $image_row->id; ?>" image_key="<?php echo $stri; ?>"></div>
							<?php
							  $stri++;
							break;
							case 'video':
											
							  if ($image_row->id == $current_image_id) {
								$current_pos = $stri;
								$current_key = $stri;
							  }
							
							?>
								<div id="huge_it_dots_<?php echo $stri; ?>_<?php echo $sliderID; ?>" class="huge_it_slideshow_dots_<?php echo $sliderID; ?> <?php echo (($key==$current_image_id) ? 'huge_it_slideshow_dots_active_' . $sliderID : 'huge_it_slideshow_dots_deactive_' . $sliderID); ?>" onclick="huge_it_change_image_<?php echo $sliderID; ?>(parseInt(jQuery('#huge_it_current_image_key_<?php echo $sliderID; ?>').val()), '<?php echo $stri; ?>', data_<?php echo $sliderID; ?>,false,true);return false;" image_id="<?php echo $image_row->id; ?>" image_key="<?php echo $stri; ?>"></div>
							<?php
							  $stri++;
							break;
							case 'last_posts':
							
							foreach($recent_posts as $lkeys => $last_posts){
                                                            if($image_row->name == "0"){
                                                                if($lkeys < $image_row->sl_url){
                                                                    if(get_the_post_thumbnail($last_posts["ID"], 'thumbnail') != ''){
                                                                    $imagethumb = wp_get_attachment_image_src( get_post_thumbnail_id($last_posts["ID"]), 'thumbnail-size', true );

                                                                      if ($image_row->id == $current_image_id) {
                                                                            $current_pos = $stri;
                                                                            $current_key = $stri;
                                                                      }
                                                                    ?>
                                                                            <div id="huge_it_dots_<?php echo $stri; ?>_<?php echo $sliderID; ?>" class="huge_it_slideshow_dots_<?php echo $sliderID; ?> <?php echo (($stri==$current_image_id) ? 'huge_it_slideshow_dots_active_' . $sliderID : 'huge_it_slideshow_dots_deactive_' . $sliderID); ?>" onclick="huge_it_change_image_<?php echo $sliderID; ?>(parseInt(jQuery('#huge_it_current_image_key_<?php echo $sliderID; ?>').val()), '<?php echo $stri; ?>', data_<?php echo $sliderID; ?>,false,true);return false;" image_id="<?php echo $image_row->id; ?>" image_key="<?php echo $stri; ?>"></div>
                                                                    <?php
                                                                      $stri++;
                                                                    }
                                                                }
                                                            }
                                                            else{
                                                                $category_id = get_cat_ID($image_row->name);                    //       my slider category id
                                                                $category_id_from_posts = get_the_category($last_posts['ID']);  //       recent post id
                                                                if($category_id == $category_id_from_posts[0]->term_id){
                                                                    if($lkeys < $image_row->sl_url){
                                                                            if(get_the_post_thumbnail($last_posts["ID"], 'thumbnail') != ''){
                                                                            $imagethumb = wp_get_attachment_image_src( get_post_thumbnail_id($last_posts["ID"]), 'thumbnail-size', true );

                                                                              if ($image_row->id == $current_image_id) {
                                                                                    $current_pos = $stri;
                                                                                    $current_key = $stri;
                                                                              }
                                                                            ?>
                                                                                    <div id="huge_it_dots_<?php echo $stri; ?>_<?php echo $sliderID; ?>" class="huge_it_slideshow_dots_<?php echo $sliderID; ?> <?php echo (($stri==$current_image_id) ? 'huge_it_slideshow_dots_active_' . $sliderID : 'huge_it_slideshow_dots_deactive_' . $sliderID); ?>" onclick="huge_it_change_image_<?php echo $sliderID; ?>(parseInt(jQuery('#huge_it_current_image_key_<?php echo $sliderID; ?>').val()), '<?php echo $stri; ?>', data_<?php echo $sliderID; ?>,false,true);return false;" image_id="<?php echo $image_row->id; ?>" image_key="<?php echo $stri; ?>"></div>
                                                                            <?php
                                                                              $stri++;
                                                                            }
                                                                    }
                                                                }
                                                            }
							
							}
							
							break;
					}
				}
				?>
			  </div>
			
			<?php
			   if ($paramssld['slider_show_arrows']=="on") {
			 ?>
				<a class="elegant_slideshow_arrow elegant_left_arrow" id="huge_it_slideshow_left_<?php echo $sliderID; ?>" href="#">
					<div id="huge_it_slideshow_left-ico_<?php echo $sliderID; ?>">
					<div><i class="huge_it_slideshow_prev_btn_<?php echo $sliderID; ?> fa"></i></div></div>
				</a>
				
				<a class="elegant_slideshow_arrow elegant_right_arrow" id="huge_it_slideshow_right_<?php echo $sliderID; ?>" href="#">
					<div id="huge_it_slideshow_right-ico_<?php echo $sliderID;?> , data_<?php echo $sliderID;?>">
					<div><i class="huge_it_slideshow_next_btn_<?php echo $sliderID; ?> fa"></i></div></div>
				</a>
			<?php
			}
			?>
		</div>
	  <!-- ##########################IMAGES######################### -->
      <div id="huge_it_slideshow_image_container_<?php echo $sliderID; ?>" style="width: <?=$overflowVisible ? '100%' : $sliderwidth . 'px'?>; height:<?=$sliderheight?>px" class="elegant_slideshow_image_container huge_it_slideshow_image_container_<?php echo $sliderID; ?>">
            <div class="elegant_slider huge_it_slider_<?php echo $sliderID; ?>">
			  <?php
			  $i=0;
			  foreach ($images as $key => $image_row) {
			  	$imagerowstype=$image_row->sl_type;
				if($image_row->sl_type == ''){
				$imagerowstype='image';
				}
				switch($imagerowstype){
					case 'image':
					$target="";
					?>
					  <div data-position="<?=$i?>" class="<?= $i == 0 ? 'active' : '' ?> elegant_slider_item huge_it_slideshow_image_item_<?php echo $sliderID; ?>" id="image_id_<?php echo $sliderID.'_'.$i ?>">
						<?php
                        if($image_row->sl_url!="" && $imageLink){
							if ($image_row->link_target=="on"){$target='target="_blank'.$image_row->link_target.'"';}
							echo '<a href="'.$image_row->sl_url.'" '.$target.'>';
						}
                        elseif($fancybox) {
                            echo '<a class="fancybox" rel="group" href="' . $image_row->image_url . '" title="' . $image_row->name . '" data-description="' . wpautop($image_row->description) . '">';
                        }
                        ?>

                            <img id="huge_it_slideshow_image_<?php echo $sliderID; ?>" class="elegant_slideshow_image huge_it_slideshow_image_<?php echo $sliderID; ?>" src="<?php echo $image_row->image_url; ?>" image_id="<?php echo $image_row->id; ?>" />
                            <span class="slider_overlay"></span>
						<?php
                        if($image_row->sl_url!="" && $imageLink || $fancybox) {
                            echo '</a>';
                        }
                        ?>
                          <span class="elegant_slideshow_text_wrapper">
                            <div class="elegant_slideshow_title huge_it_slideshow_title_text_<?php echo $sliderID; ?> <?php if(trim($image_row->name)=="") echo "none"; ?>">
                                <?php echo $image_row->name; ?>
                            </div>
                            <div class="elegant_slideshow_description huge_it_slideshow_description_text_<?php echo $sliderID; ?> <?php if(trim($image_row->description)=="") echo "none"; ?>">
                                <?php echo $image_row->description; ?>
                            </div>
                          </span>
					  </div>
					  <?php
					$i++;
					break;
					
					case 'last_posts':
					foreach($recent_posts as $lkeys => $last_posts){
                                            if($image_row->name == "0"){
                                                if($lkeys < $image_row->sl_url){
                                                    $imagethumb = wp_get_attachment_image_src( get_post_thumbnail_id($last_posts["ID"]), 'thumbnail-size', true );

                                                    if(get_the_post_thumbnail($last_posts["ID"], 'thumbnail') != ''){
                                                    $target="";
                                                    ?>
                                                      <li class="huge_it_slideshow_image<?php if ($i != $current_image_id) {$current_key = $key; echo '_second';} ?>_item_<?php echo $sliderID; ?>" id="image_id_<?php echo $sliderID.'_'.$i ?>">      
                                                            <?php if ($image_row->sl_postlink=="1"){
                                                                            if ($image_row->link_target=="on"){$target='target="_blank'.$image_row->link_target.'"';}
                                                                            echo '<a href="'.$last_posts["guid"].'" '.$target.'>';
                                                            } ?>
                                                            <img id="huge_it_slideshow_image_<?php echo $sliderID; ?>" class="huge_it_slideshow_image_<?php echo $sliderID; ?>" src="<?php echo $imagethumb[0]; ?>" image_id="<?php echo $image_row->id; ?>" />
                                                            <?php if($image_row->sl_postlink=="1"){ echo '</a>'; }?>		
                                                            <div class="huge_it_slideshow_title_text_<?php echo $sliderID; ?> <?php if(trim($last_posts["post_title"])=="") echo "none";  if($image_row->sl_stitle!="1") echo " hidden"; ?>">
                                                                            <?php echo $last_posts["post_title"]; ?>
                                                            </div>
                                                            <div class="huge_it_slideshow_description_text_<?php echo $sliderID; ?> <?php if(trim($last_posts["post_content"])=="") echo "none"; if($image_row->sl_sdesc!="1") echo " hidden"; ?>">
                                                                    <?php 
                                                                    echo substr_replace($last_posts["post_content"], "", $image_row->description); ?>
                                                            </div>
                                                     </li>
                                                      <?php
                                                    $i++;
                                                    }
                                                }
                                            }
                                            else{
                                                $category_id = get_cat_ID($image_row->name);                    //       my slider category id
                                                $category_id_from_posts = get_the_category($last_posts['ID']);  //       recent post id
                                                if($category_id == $category_id_from_posts[0]->term_id){
                                                    if($lkeys < $image_row->sl_url){
                                                        $imagethumb = wp_get_attachment_image_src( get_post_thumbnail_id($last_posts["ID"]), 'thumbnail-size', true );

                                                        if(get_the_post_thumbnail($last_posts["ID"], 'thumbnail') != ''){
                                                        $target="";
                                                        ?>
                                                          <li class="huge_it_slideshow_image<?php if ($i != $current_image_id) {$current_key = $key; echo '_second';} ?>_item_<?php echo $sliderID; ?>" id="image_id_<?php echo $sliderID.'_'.$i ?>">      
                                                                <?php if ($image_row->sl_postlink=="1"){
                                                                                if ($image_row->link_target=="on"){$target='target="_blank'.$image_row->link_target.'"';}
                                                                                echo '<a href="'.$last_posts["guid"].'" '.$target.'>';
                                                                } ?>
                                                                <img id="huge_it_slideshow_image_<?php echo $sliderID; ?>" class="huge_it_slideshow_image_<?php echo $sliderID; ?>" src="<?php echo $imagethumb[0]; ?>" image_id="<?php echo $image_row->id; ?>" />
                                                                <?php if($image_row->sl_postlink=="1"){ echo '</a>'; }?>		
                                                                <div class="huge_it_slideshow_title_text_<?php echo $sliderID; ?> <?php if(trim($last_posts["post_title"])=="") echo "none";  if($image_row->sl_stitle!="1") echo " hidden"; ?>">
                                                                                <?php echo $last_posts["post_title"]; ?>
                                                                </div>
                                                                <div class="huge_it_slideshow_description_text_<?php echo $sliderID; ?> <?php if(trim($last_posts["post_content"])=="") echo "none"; if($image_row->sl_sdesc!="1") echo " hidden"; ?>">
                                                                        <?php 
                                                                        echo substr_replace($last_posts["post_content"], "", $image_row->description); ?>
                                                                </div>
                                                         </li>
                                                          <?php
                                                        $i++;
                                                        }
                                                    }
						}
                                            }
					}
					break;
					case 'video':

						?>
						<li  class="huge_it_slideshow_image<?php if ($i != $current_image_id) {$current_key = $key; echo '_second';} ?>_item_<?php echo $sliderID; ?>" id="image_id_<?php echo $sliderID.'_'.$i ?>">      
							<?php 
								if(strpos($image_row->image_url,'youtube') !== false || strpos($rowimages->image_url,'youtu') !== false){
									$video_thumb_url=get_youtube_id_from_url($image_row->image_url); 
								?>
									
									<div id="video_id_<?php echo $sliderID;?>_<?php echo $key ;?>" class="huge_it_video_frame_<?php echo $sliderID; ?>"></div>
							<?php }else {
									$vimeo = $image_row->image_url;
									$imgid =  end(explode( "/", $vimeo ));
									
							?>					
								<iframe id="player_<?php echo $key ;?>"  class="huge_it_video_frame_<?php echo $sliderID; ?>" src="//player.vimeo.com/video/<?php echo $imgid; ?>?api=1&player_id=player_<?php echo $key ;?>&showinfo=0&controls=0" frameborder="0" allowfullscreen></iframe>
							<?php } ?>
						</li>
					<?php
					$i++;
					break;
				}
			 } 
			  ?>
                <input  type="hidden" id="huge_it_current_image_key_<?php echo $sliderID; ?>" value="0" />
        </div>
      </div>
	</div>
</div>
	  <?php

	return ob_get_clean();
}  
?>

