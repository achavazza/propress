<form action="<?php echo home_url('/'); ?>" id="searchform" method="get" class="form">
    <?php //if(!is_front_page()): ?>
        <?php /*
        <div class="panel-head">
            <h3 class="h4">Buscador de propiedades</h3>
        </div>
        */ ?>
        <?php //endif; ?>
            <ul class="search-fields">
                <?php
                $inputContent  = '<label class="label" for="s">Buscar</label>';
                $inputContent .= '<div class="control">';
                $inputContent .= '<input class="input" type="text" id="s" name="s" value="'. get_search_query() .'" placeholder="Buscar"/>';
                //$inputContent .= '<input type="hidden" name="post_type" value="propiedad" />';
                $inputContent .= '<input type="hidden" name="search" value="advanced">';
                $inputContent .= '</div>';
            /*
            if($_GET['search'] == 'advanced'){
                echo '<input class="invisible" type="hidden" name="search" value="advanced">';
            }
            */
            // Security issue: Direct access to $_GET without sanitization
            // Recommended fix:
            // if(sanitize_text_field($_GET['search'] ?? '') == 'advanced'){

            echo sprintf('<li class="field field-search">%s</li>', $inputContent);

            $taxonomies = array('tipo','operacion','location','features');
            $args = array('order'=>'DESC','hide_empty'=>true);
            echo get_terms_dropdown($taxonomies, $args);

            function get_terms_dropdown($taxonomies, $args){
                foreach($taxonomies as $taxonomy){
                    $label     = '';
                    $thisQuery = get_query_var($taxonomy);
                    $terms     = get_terms($taxonomy, $args);
                    switch($taxonomy){
                        case 'tipo';
                        $empty = 'Elija un Tipo';
                        $label = 'Propiedad';
                        $plural = 'propiedades';
                        //$label = 'Tipo de propiedad';
                        break;

                        case 'operacion';
                        $empty = 'Elija una Operación';
                        $label = 'Operación';
                        $plural = 'Operaciones';
                        //$label = 'Tipo de operación';
                        break;

                        case 'features';
                        $empty = 'Elija una Prestación';
                        $label = 'Prestaciones';
                        $plural = 'Prestaciones';
                        //$label = 'Tipo de operación';
                        break;

                        case 'location';
                        $empty = 'Localidad';
                        //$empty = 'Elija una Localidad';
                        $label = 'Localidad';
                        $plural = 'Localidades';
                        break;
                    }

                    if($taxonomy == 'location'){
                        $terms = get_terms($taxonomy, array('orderby' => 'term_group', 'hierarchical' => true));
                        if ( !empty( $terms ) && !is_wp_error( $terms ) ){
                            // Build the select with proper optgroup handling and escaping
                            $inputContent = '';
                            $inputContent .= '<label for="'.esc_attr($taxonomy).'" class="label">'.esc_html($label).'</label>';
                            $inputContent .= '<div class="control">';
                            $inputContent .= '<span class="select is-fullwidth">';
                            $inputContent .= '<select id="'.esc_attr($taxonomy).'" name="'.esc_attr($taxonomy).'">';
                            $inputContent .= '<option value="" disabled selected>'.esc_html($label).'</option>';
                            $inputContent .= '<option value="">Todas las '.esc_html($plural).'</option>';

                            $openOptgroup = false;
                            foreach($terms as $term){
                                $selected = selected($thisQuery, $term->slug, false);
                                if ($term->parent == 0 ) {
                                    if ($openOptgroup) {
                                        $inputContent .= '</optgroup>';
                                    }
                                    $inputContent .=  '<optgroup label="Localidad '.esc_attr($term->name).'">';
                                    // Parent option
                                    $inputContent .= '<option name="'.esc_attr($term->slug).'" value="'.esc_attr($term->slug).'" '.$selected.'>Ciudad de '.esc_html($term->name).'</option>';
                                    $openOptgroup = true;
                                } else {
                                    $inputContent .=  '<option name="'.esc_attr($term->slug).'" value="'.esc_attr($term->slug).'" '.$selected.'>'.esc_html($term->name).'</option>';
                                }
                            }

                            if ($openOptgroup) {
                                $inputContent .= '</optgroup>';
                            }

                            // Close select and wrappers
                            $inputContent .= '</select>';
                            $inputContent .= '</span>';
                            $inputContent .= '</div>';

                            echo sprintf('<li class="field">%s</li>', $inputContent);
                        } else {
                            // No terms: render a disabled select so layout doesn't break
                            $inputContent = '<label for="'.esc_attr($taxonomy).'" class="label">'.esc_html($label).'</label>';
                            $inputContent .= '<div class="control">';
                            $inputContent .= '<span class="select is-fullwidth">';
                            $inputContent .= '<select id="'.esc_attr($taxonomy).'" name="'.esc_attr($taxonomy).'" disabled>';
                            $inputContent .= '<option value="">'.sprintf( __('No hay %s disponibles', 'tnb'), esc_html($plural)).'</option>';
                            $inputContent .= '</select>';
                            $inputContent .= '</span>';
                            $inputContent .= '</div>';

                            echo sprintf('<li class="field">%s</li>', $inputContent);
                        }
                    }else{
                        // Check that $terms is valid to avoid breaking when no terms exist
                        if ( !empty( $terms ) && !is_wp_error( $terms ) ) {
                            // Build the select when terms exist
                            $inputContent = '<label for="'.$taxonomy.'" class="label">'.$label.'</label>';
                            $inputContent .= '<div class="control">';
                            $inputContent .= '<span class="select is-fullwidth">';
                            $inputContent .= '<select id="'.$taxonomy.'" name="'.$taxonomy.'">';
                            $inputContent .= '<option value="" disabled selected>'.$label.'</option>';
                            $inputContent .= '<option value="">Todas las '.$plural.'</option>';
                            //<option value="">'.$empty.'</option>';
                            foreach($terms as $term){
                                $selected = '';
                                if($thisQuery == $term->slug){
                                    $selected = 'selected';
                                }
                                $inputContent .=  '<option name="'.$term->slug.'" value="'.$term->slug.'" '.$selected.'>'.$term->name.'</option>';
                            }
                            $inputContent .= '</select>';
                            $inputContent .= '</span>';
                            $inputContent .= '</div>';
                            echo sprintf('<li class="field">%s</li>', $inputContent);
                        } else {
                            // No terms: render a disabled select so layout doesn't break
                            $inputContent = '<label for="'.$taxonomy.'" class="label">'.$label.'</label>';
                            $inputContent .= '<div class="control">';
                            $inputContent .= '<span class="select is-fullwidth">';
                            $inputContent .= '<select id="'.$taxonomy.'" name="'.$taxonomy.'" disabled>';
                            $inputContent .= '<option value="">' . sprintf( __('No %s disponibles', 'tnb'), $plural ) . '</option>';
                            $inputContent .= '</select>';
                            $inputContent .= '</span>';
                            $inputContent .= '</div>';
                            echo sprintf('<li class="field">%s</li>', $inputContent);
                        }
                    }
                }
            }
            ?>
            <li class="field">
                <label for="bedrooms" class="label">Dormitorios</label>
                <?php
                function sel($v = null){
                    if(!empty($v)){
                        // Security issue: Direct access to $_GET without sanitization
                        if(($_GET['dormitorios'] ?? '') == $v){
                            echo 'selected="selected"';
                        }
                        // Recommended fix:
                        // if(sanitize_text_field($_GET['dormitorios'] ?? '') == $v){
                    }
                }
                ?>
                <div class="control">
                <span class="select is-fullwidth">
                    <select id="bedrooms" name="dormitorios" value="<?php // Security issue: Direct output of $_GET without sanitization
                        echo $_GET['dormitorios'] ?>">
                        <option <?php sel() ?> value="">Dormitorios</option>
                        <option <?php sel(1) ?> value="1">Monoambiente</option>
                        <option <?php sel(2) ?> value="2">1 Dormitorio</option>
                        <option <?php sel(3) ?> value="3">2 Dormitorios</option>
                        <option <?php sel(4) ?> value="4">3 Dormitorios</option>
                        <option <?php sel(5) ?> value="5">4+ Dormitorios</option>
                    </select>
                </span>
                </div>
            </li>
            <?php /*
            <li class="col-auto flex-fill">
                <label for="priceLow" class="form-label">Example range</label>
                <input id="priceLow" type="range" class="form-range" min="0" max="5" step="1" placeholder="Ej. 1100000" name="price_low"  value="<?php // Security issue: Direct output of $_GET without sanitization
                echo $_GET['price_low'] ?>">
            </li>
            <li class="col-auto flex-fill">
                <label for="priceHigh" class="form-label">Example range</label>
                <input for="priceHigh" type="range" class="form-range" min="0" max="5" step="1" placeholder="Ej. 2200000" name="price_high" value="<?php // Security issue: Direct output of $_GET without sanitization
                echo $_GET['price_high'] ?>">
            </li>
            */ ?>


            <li class="field field-button">
                <span class="control">
                <button type="submit" id="searchsubmit" class="button is-primary is-fullwidth">
                    <i class="qs-icon icon-search"></i>
                    <?php echo __('Buscar Propiedades', 'tnb') ?>
                </button>
                </span>
            </li>
        </ul>
        <div class="field-body is-align-items-flex-end">
            <?php
            /*wp_nav_menu( array(
            'theme_location'  => 'search-menu',
            'container'       => false,
            'menu_class'      => 'flush',
            'fallback_cb'     => false,
        ));*/
        $i = 0;
        $menuName = '';
        // Fixed: Check if search-menu exists before accessing it
        $nav_locations = get_nav_menu_locations();
        if (isset($nav_locations['search-menu']) && $nav_locations['search-menu']) {
            $menu_term = get_term($nav_locations['search-menu'], 'nav_menu');
            if (!is_wp_error($menu_term) && $menu_term) {
                $menuName = $menu_term->name;
                $items   = wp_get_nav_menu_items($menuName);
            } else {
                $items = array();
            }
        } else {
            $items = array();
        }
        if($items):
            $count   = count($items);
            if($menuName):
                ?>
                <ul class="search-menu row">
                    <?php foreach($items as $item): ?>
                        <?php $i++; ?>
                        <li class="col-auto flex-fill">
                            <a href="<?php echo $item->url; ?>">
                                <?php echo $item->title; ?>
                            </a>
                            <?php echo ($i < $count) ? '<span class="center">|</span>' : '' ; ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</form>