<div id="gallery">
<?php
$block = '';
$gallery_images = get_post_meta( get_the_ID(), '_prop_images', 1);
$thumb_limit = get_option('tnb_setup_options')['tnb_setup_options_gallery'] ?? '';
$limit = 5; //5+1
if($thumb_limit){
    $limit = intval($thumb_limit);
}
if ( ! empty( $gallery_images ) ) :
    $count = count($gallery_images);
    ?>
    <span class="img-list img-list-left img-list-big">
        <?php
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
                $block .= '<a class="thumb" data-index="'.$i.'" href="'.$image[0].'" itemprop="contentUrl" data-size="'.$image[1].'x'.$image[2].'">';
                $block .= $thumb;
                //$block .= wp_get_attachment_image( $gallery_image, 'thumbnail' );
                $block .= '<span>'.($count - $limit).' más ...'.'</span>';
                $block .= '</a>';
                $block .= '</figure>';

                $style  = 'style="display:none"';
            }
            ?>
            <figure <?php echo $style ?>>
                <a class="thumb" data-index="<?php echo $i ?>" href="<?php echo $image[0] ?>" itemprop="contentUrl" data-size="<?php echo $image[1].'x'.$image[2] ?>">
                    <?php echo $thumb; ?>
                </a>
            </figure>
            <?php $i++; ?>
        <?php endforeach; ?>
        <?php echo $block; ?>
    </span>
<?php endif; ?>
</div>
