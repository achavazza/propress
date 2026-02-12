<div id="gallery" class="block">
    <figure class="big-thumb">
        <?php
        $i = 0;
        $postThumbnailID = get_post_thumbnail_id($post->ID);
        $postThumbnail   = wp_get_attachment_image_src( $postThumbnailID, 'full');
        if(isset($postThumbnail) && !empty($postThumbnail)): ?>
                <a class="thumb" data-index="<?php echo $i ?>" href="<?php echo $postThumbnail[0] ?>" itemprop="contentUrl" data-size="<?php echo $postThumbnail[1].'x'.$postThumbnail[2] ?>">
                    <?php echo get_the_post_thumbnail($post->ID, 'large'); ?>
                </a>
            <?php $i++; ?>
        <?php else: ?>
            <img src="<?php echo get_attachment_url_by_slug('default', 'large') ?>" />
        <?php endif; ?>
        <?php
            $btns = get_post_meta( get_the_ID(), '_prop_map-buttons', 1);
            if($btns): ?>
            <ul class="thumb-btns">
                <?php if(in_array('map', $btns)): ?>
                    <li>
                        <?php /*
                        <a class="btn btn-lg btn-secondary" data-bs-toggle="modal" data-bs-target="#map_lightbox" href="#">
                        */ ?>
                        <a class="button is-primary is-large modal-button" data-target="#modal-lightbox">
                            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-geo-alt" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                            </svg>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if(in_array('street', $btns)): ?>
                    <li>
                        <?php /*
                        <a class="btn btn-lg btn-secondary" data-bs-toggle="modal" data-bs-target="#street_lightbox" href="#">
                        */ ?>
                        <a class="button is-primary is-large modal-button" data-target="#modal-streetview">
                            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-map" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M15.817.613A.5.5 0 0 1 16 1v13a.5.5 0 0 1-.402.49l-5 1a.502.502 0 0 1-.196 0L5.5 14.51l-4.902.98A.5.5 0 0 1 0 15V2a.5.5 0 0 1 .402-.49l5-1a.5.5 0 0 1 .196 0l4.902.98 4.902-.98a.5.5 0 0 1 .415.103zM10 2.41l-4-.8v11.98l4 .8V2.41zm1 11.98l4-.8V1.61l-4 .8v11.98zm-6-.8V1.61l-4 .8v11.98l4-.8z"/>
                            </svg>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
            <?php /*
            migrando de lity a bootstrap
            <ul class="thumb-btns">
                <?php if(in_array('map', $btns)): ?>
                    <li><a class="btn" href="#map_lightbox" id="map_lightbox_trigger"><i class="icon cofasa-linear icon-map"></i></a></li>
                <?php endif; ?>
                <?php if(in_array('street', $btns)): ?>
                    <li><a class="btn" href="#street_lightbox" id="street_lightbox_trigger"><i class="icon cofasa-linear icon-marker"></i></a></li>
                <?php endif; ?>
            </ul>
            */ ?>
        <?php endif; ?>
    </figure>

    <?php

    $block = '';
    $gallery_images = get_post_meta( get_the_ID(), '_prop_images', 1);
    // Fixed: Check if option exists before accessing array key
    $tnb_setup_options = get_option('tnb_setup_options');
    $thumb_limit = isset($tnb_setup_options['tnb_setup_options_gallery']) ? $tnb_setup_options['tnb_setup_options_gallery'] : 6; // Default 6 images
    $limit = $thumb_limit; //5+1
    //$limit = 5; //5+1

    if($thumb_limit){
        $limit = intval($thumb_limit);
    }

    if ( ! empty( $gallery_images ) ) :

        $count = count($gallery_images);

        echo '<span class="img-list">';
            foreach ( $gallery_images as $gallery_image ) :
                $image = wp_get_attachment_image_src( attachment_url_to_postid($gallery_image), 'large');
                $thumb = wp_get_attachment_image(attachment_url_to_postid( $gallery_image), 'thumbnail' );
                //$thumb = wp_get_attachment_image( $gallery_image, 'thumbnail' );
                //$img   = wp_get_attachment_image_src( $gallery_image[0], 'thumbnail');
                //$thumb = '<img src="'.$img[0].'" width="'.$img[1].'" height="'.$img[2].'" />';
                if($postThumbnailID == $gallery_image){
                    continue;
                }
                if($i > $limit){
                    $block  = '<figure class="img-limit">';
                    $block .= '<a class="thumb limit" data-index="'.$i.'" href="'.$image[0].'" itemprop="contentUrl" data-size="'.$image[1].'x'.$image[2].'">';
                    $block .= $thumb;
                    //$block .= wp_get_attachment_image( $gallery_image, 'thumbnail' );
                    $block .= '<span>'.($count - $limit).' más ...'.'</span>';
                    $block .= '</a>';
                    $block .= '</figure>';

                    $style  = 'style="display:none"';
                }

                $figure = '<figure '.$style.' >';
                    $figure .= '<a class="thumb" data-index="'. $i .'" href="'. $image[0] .'" itemprop="contentUrl" data-size="'. $image[1].'x'.$image[2] .'">';
                        $figure .= $thumb;
                    $figure .= '</a>';
                $figure .= '</figure>';

                echo $figure;

                $i++;
            endforeach;
            echo $block;

        echo '</span>';
    endif;
    ?>
</div>
