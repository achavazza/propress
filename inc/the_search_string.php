<?php
function plural( $amount, $singular = '', $plural = 's' ) {
    if ( $amount == 1 ){
        return $singular;
    } else {
        return $plural;
    }
}

function get_search_string($wp_query){
    $args = array('order'=>'DESC','hide_empty'=>false);

    $tipoTax   = get_query_var('tipo');
    $opTax     = get_query_var('operacion');
    $locTax    = get_query_var('location');

    $tipoTerms = get_terms('tipo', $args);
    $opTerms   = get_terms('operacion', $args);
    $tax       = '';

    // para definir los terminos en femenino;
    $termFem = array(
        'casa',
        'Propiedad',
    );

    foreach ($tipoTerms as $tipoTerm) {
        if($tipoTerm->slug == $tipoTax){
            $tipo = $tipoTerm->name;
        };
    }

    foreach ($opTerms as $opTerm) {
        if($opTerm->slug == $opTax){
            $op = $opTerm->name;
        };
    }

    $count  = $wp_query->found_posts;
    //$count  = $wp_query->post_count;
    $search = get_search_query();

    /*
    $out    = '<b>';
    $out    .= $count;
    if(isset($tipo) && !empty($tipo)){
        //if($count > 1){ $plural = 's'; }
        $out .= ' ' . plural($count, $tipo, $tipo.'s');
    }else{
        if($count > 1){ $plural = 'es'; }
        $out .= ' ' . plural($count, 'Propiedad', 'Propiedades');
    }
    $out     .= '</b>';
    if($tipoTax == 'departamento'){
        $out .= ' '. plural($count, 'encontrado', 'encontrados');
    }else{
        $out .= ' '. plural($count, 'encontrada', 'encontradas');
    }
    if($search){
        $out .= ' con '.$search;
    }
    if(isset($op) && !empty($op)){
        $out .= ' en <b>'. $op.'</b>';
    }
    return $out;
    */

    if(isset($tipo) && !empty($tipo)){
        $tipoLabel = plural($count, $tipo, $tipo.'s');
    }else{
        $tipoLabel = plural($count, 'Propiedad', 'Propiedades');
    }
    //if(in_array ($tipoTax, $termFem) || in_array ('Propiedad', $termFem)){
    if($tipoTax){
        if( $tipoTax && in_array($tipoTax, $termFem)){
            $foundLabel = plural($count, 'encontrada', 'encontradas');
        }else{
            $foundLabel = plural($count, 'encontrado', 'encontrados');
        }
    }else{
        $foundLabel = plural($count, 'encontrada', 'encontradas');
    }
    $searchLabel = '';
    if($search){
        $searchLabel = ' con '.$search;
    }
    $opLabel = '';
    if(isset($op) && !empty($op)){
        $opLabel = sprintf('en <b>%s</b>', $op);
    }

    return sprintf('<b>%u  %s</b> %s %s %s', $count, $tipoLabel, $foundLabel, $searchLabel, $opLabel);
}
 ?>
