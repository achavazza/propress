<?php
function the_breadcrumb() {
    // Fixed: Declare global $post
    global $post;
    
	echo '<nav class="breadcrumb" aria-label="breadcrumb">';
	echo '<ul>';
	if (!is_home()) {
		echo '<li>';
            // Fixed: Use home_url() instead of deprecated get_option('home')
            echo '<a href="'. home_url() . '">'. 'Inicio' . "</a>";
        echo "</li>";
		//if (is_category() || is_single()) {
			//echo '<li>';
			//the_category(' </li><li> ');
		if (is_single() && $post) {
            $tax      = 'operacion';
            $terms    = get_the_terms($post->ID, $tax);
            // Fixed: Check if terms exist before accessing
            $term     = $terms && !is_wp_error($terms) && isset($terms[0]) ? $terms[0] : null;
            
            // Fixed: Only generate term link if term exists
            if(isset($term) && !empty($term)){
                $termlink = get_term_link($term->term_id, $tax);
                echo "<li>";
                    echo '<a href="'.$termlink.'" title="'.$term->name.'">'.$term->name.'</a>';
                echo "</li>";
            }
            echo '<li class="is-active">';
			echo '<a href="#">';
			    the_title();
            echo '</a>';
			echo '</li>';
		} elseif (is_page()) {
			echo '<li class="is-active">';
			echo '<a href="#">';
    			the_title();
			echo '</a>';
			echo '</li>';
		}
	}
    /*
	elseif (is_tag()) {
        single_tag_title();
    }
	elseif (is_day()) {
        echo"<li>Archive for "; the_time('F jS, Y'); echo'</li>';
    }
	elseif (is_month()) {
        echo"<li>Archive for "; the_time('F, Y'); echo'</li>';
    }
	elseif (is_year()) {
        echo"<li>Archive for "; the_time('Y'); echo'</li>';
    }
	elseif (is_author()) {
        echo"<li>Author Archive"; echo'</li>';
    }
	elseif (isset($_GET['paged']) && !empty($_GET['paged'])) {
        echo "<li>Blog Archives"; echo'</li>';
    }
    */
	if (is_search()) {
        echo '<li class="is-active">';
        $search = get_search_query();
        if(isset($search) && !empty($search)){
            echo '<a href="#">Búsqueda de '. get_search_query().'</a>';
        }else{
            echo '<a href="#">Buscar</a>';
        }
        echo'</li>';
    }
	echo '</ul>';
	echo '</nav>';
}
/*
function the_breadcrumb() {
    echo '<ul>';
        $term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'operacion' ) );
        // Create a list of all the term's parents
            $parent = $term->parent;
            while ($parent):
                $parents[] = $parent;
                $new_parent = get_term_by( 'id', $parent, get_query_var( 'operacion' ));
                $parent = $new_parent->parent;
            endwhile;
            if(!empty($parents)):
                $parents = array_reverse($parents);
                // For each parent, create a breadcrumb item
                foreach ($parents as $parent):
                    $item = get_term_by( 'id', $parent, get_query_var( 'operacion' ));
                    $url  = get_bloginfo('url').'/'.$item->taxonomy.'/'.$item->slug;
                    echo '<li><a href="'.$url.'">'.$item->name.'</a></li>';
            endforeach;
        endif;
        pr(get_the_terms($post->ID,'operacion')[0]);
        //pr($term);
        // Display the current term in the breadcrumb
    echo '<li>'.$term->name.'</li>';
    echo '</ul>';
}
*/
?>
