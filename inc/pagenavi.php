<?php
function pagenavi( $p = 2 ) { // pages will be show before and after current page
    $labelFirst = __('Primera', 'tnb');
    $labelLast  = __('Última', 'tnb');
    $labelPage  = __('Página', 'tnb');
    $class      = 'pagination-link';
    $current    = 'is-current';
    $title      = '';

    if ( is_singular() ){
        return; // don't show in single page
    }
    global $wp_query, $paged;
    $max_page = $wp_query->max_num_pages;
    //pr($wp_query);

    if ( $max_page == 1 ){
        return; // don't show when only one page
    }
    if ( empty( $paged ) ){ $paged = 1; }

    echo '<ul class="pagination-list">';
    if ( $paged > $p + 2 ){
        echo '<li>';
        echo '<a class="pagination-ellipsis" href="#">'.'&hellip;'.'</a>';
        echo '</li>';
    }
    for( $i = $paged - $p; $i <= $paged + $p; $i++ ) { // Middle pages
        echo '<li>';
        if ( $i > 0 && $i <= $max_page ){
            if($i == $paged){
                echo '<a class="'.$class.' '.$current.'">'.$i.'</a> ';
            } else {
                p_link( $i );
            }

        }
        echo '</li>';
    }
    if ( $paged < $max_page - $p - 1 ) {
        echo '<li>';
        echo '<a class="pagination-ellipsis" href="#">'.'&hellip;'.'</a>';
        echo '</li>';
    }
    echo '</ul>';

    // echo '<span class="pages">Page: ' . $paged . ' of ' . $max_page . ' </span> '; // pages
    //if ( $paged > $p + 1 ){
        $paged = 1;
        echo '<a class="pagination-previous" href="'.esc_html( get_pagenum_link( $paged , true ) ).'" title="'.$title.'">'.$labelFirst.'</a> ';
        //p_link( 1, $labelFirst );
    //}
    //if ( $paged < $max_page - $p ){
        $paged = $max_page;
        echo '<a class="pagination-next" href="'.esc_html( get_pagenum_link( $paged ) ).'" title="'.$title.'">'.$labelLast.'</a> ';
        //p_link( $max_page, $labelLast );
    //}

}
function p_link( $i, $title = '' ) {
    $labelFirst = __('Primera', 'tnb');
    $labelLast  = __('Última', 'tnb');
    $labelPage  = __('Página', 'tnb');
    $class      = 'pagination-link';
    $current    = 'is-current';

    if ( $title == '' ){
        $title = sprintf(__('Página %s','tnb'), $i);
    }
    echo '<a class="'.$class.'" href="'.esc_html( get_pagenum_link( $i ) ).'" title="'.$title.'">'.$i.'</a> ';
}
?>
