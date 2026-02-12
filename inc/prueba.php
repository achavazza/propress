

<?php
        print_r ('adiosssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssss');
        echo '<br><hr><br>';
        echo 'Resultado del archivo XML ->';
        echo'<br>';
        $file_XML = file_get_contents(TEMPLATEPATH . '/xml/propiedades_1.xml');
        if (!empty($file_XML)){
            $xml= simplexml_load_file(TEMPLATEPATH . '/xml/propiedades_1.xml');
            echo 'para vos javi :-) <br>';

            global $wpdb;
            if (is_user_logged_in()){
                foreach ($xml as $propiedad) {
                        try {

                            $user_id = get_current_user_id();
                            $defaults = array(
                                'propiedad_id'          => 3,
                                'post_author'           => $user_id,
                                'post_content'          => $propiedad->inventario_propiedad, //
                                'post_title'            => $propiedad->calle. ' '. $propiedad->numero,
                                'post_excerpt'          => '',
                                'post_status'           => 'publish',
                                'comment_status'        => 'closed',
                                'ping_status'           => 'closed',
                                'post_password'         => '',
                                'post_name'             => $propiedad->calle. ' '. $propiedad->numero,
                                'to_ping'               => '',
                                'pinged'                => '',
                                'post_content_filtered' => '',
                                'post_parent'           => 0,
                                'guid'                  => '', /*aqui van las imagenes */
                                'menu_order'            => 0,
                                'post_type'             => 'propiedad',
                                'post_mime_type'        => '', /*para imagenes image/jpeg , sino es vacío*/
                                'comment_count'         => 0,
                            );


                            $post_id =wp_insert_post($defaults,true);
                            $res=$wpdb->update('wp_posts',array('propiedad_id'=>$propiedad->id_propiedad),array('ID'=>$post_id));

                            #- Tipo de Propiedad.-
                            // Security issue: Direct SQL query with unsanitized variable - SQL Injection risk
                            $id_tipo= $wpdb->get_var('SELECT term_id FROM wp_terms WHERE name like "%'.$propiedad->nombre_tipo_propiedad.'s%"');
                            // Recommended fix:
                            // $id_tipo= $wpdb->get_var($wpdb->prepare('SELECT term_id FROM '.$wpdb->prefix.'terms WHERE name LIKE %s', '%'.$propiedad->nombre_tipo_propiedad.'s%'));
                            if ($id_tipo)
                                $res=$wpdb->insert('wp_term_relationships',array('object_id'=> $post_id, 'term_taxonomy_id'=>$id_tipo));

                            #- Provincia
                            // Security issue: Direct SQL query with unsanitized variable - SQL Injection risk
                            $id_prov= $wpdb->get_var('SELECT term_id FROM wp_terms WHERE name like "%'.$propiedad->nombre_provincia.'%"');
                            // Recommended fix:
                            // $id_prov= $wpdb->get_var($wpdb->prepare('SELECT term_id FROM '.$wpdb->prefix.'terms WHERE name LIKE %s', '%'.$propiedad->nombre_provincia.'%'));
                            if ($id_prov)
                                $res=$wpdb->insert('wp_term_relationships',array('object_id'=> $post_id, 'term_taxonomy_id'=>$id_prov));

                            #- Gas Natural.-
                            if ($propiedad->gas_propiedad >0)
                                $res=$wpdb->insert('wp_term_relationships',array('object_id'=> $post_id, 'term_taxonomy_id'=>22));

                            #- En Venta
                            if ($propiedad->en_venta == 'SI')
                                $res=$wpdb->insert('wp_term_relationships',array('object_id'=> $post_id, 'term_taxonomy_id'=>4));
                                //$res=$wpdb->insert('wp_postmeta',array('post_id'=> $post_id, 'meta_key'=>'_prop_price_sale', 'meta_value'=>$propiedad->importe_venta));

                            #- En Alquiler.-
                            if ($propiedad->en_alquiler == 'SI'){
                                $res=$wpdb->insert('wp_term_relationships',array('object_id'=> $post_id, 'term_taxonomy_id'=>12));
                                $res=$wpdb->insert('wp_postmeta',array('post_id'=> $post_id, 'meta_key'=>'_prop_price_rent', 'meta_value'=>$propiedad->importe_alquiler));
                            }

                            #- Moneda. -
                            $res=$wpdb->insert('wp_postmeta',array('post_id'=> $post_id, 'meta_key'=>'_prop_currency', 'meta_value'=>$propiedad->id_moneda_alquiler));

                            #- Metros cuadrados.-
                            $res=$wpdb->insert('wp_postmeta',array('post_id'=> $post_id, 'meta_key'=>'_prop_sup', 'meta_value'=>$propiedad->superficie_cubierta_propiedad));

                            #- Baños.-
                            if ($propiedad->cantidad_baños_propiedad > 0)
                                $res=$wpdb->insert('wp_postmeta',array('post_id'=> $post_id, 'meta_key'=>'_prop_bathrooms', 'meta_value'=>$propiedad->cantidad_baños_propiedad));

                            #- direccion.-
                            $res=$wpdb->insert('wp_postmeta',array('post_id'=> $post_id, 'meta_key'=>'_prop_address', 'meta_value'=>$propiedad->calle. ' '. $propiedad->numero));
                            $res=$wpdb->insert('wp_postmeta',array('post_id'=> $post_id, 'meta_key'=>'_prop_map_address', 'meta_value'=>$propiedad->calle. ' '. $propiedad->numero.','.$propiedad->nombre_provincia.','.$propiedad->nombre_pais));

                            $direccion=$propiedad->calle. ' '. $propiedad->numero.','.$propiedad->nombre_provincia.','.$propiedad->nombre_pais;
                            $lat=$propiedad->latitud_propiedad;
                            $long=$propiedad->longitud_propiedad;

                            $res=$wpdb->insert('wp_postmeta',array('post_id'=> $post_id, 'meta_key'=>'_prop_map', 'meta_value'=>
                            'a:3:{s:7:"address";s:'.strlen($direccion).':"'.$direccion.'";s:8:"latitude";s:'.strlen($lat).':"'.$lat.'";s:9:"longitude";s:'.strlen($long).':"'.$long.'";}'));

                            #- precio venta

                            echo '<br>'.$res ;
                            break;
                        } catch (\Throwable $th) {
                            die ($th);
                        }
                        /*wp_insert_post( array $postarr, bool $wp_error = false )*/




                }
            }else{
                echo 'no logeado';
            }

        }else{
            die("No pudimos conectar");
        }

        echo '<br><hr><br>';

?>