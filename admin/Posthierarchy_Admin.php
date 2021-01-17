<?php

class Posthierarchy_Admin extends Posthierarchy_Abstruct {

	public function enqueue_styles() {
		wp_enqueue_style( $this->plugin_name . '-style', plugin_dir_url( __FILE__ ) . 'css/webdevhelper-admin.css', array(), $this->version, 'all' );
	}

	public function enqueue_scripts() {
		wp_enqueue_script( $this->plugin_name . '-script', plugin_dir_url( __FILE__ ) . 'js/webdevhelper-admin.js', array( 'jquery' ), $this->version, true );
	}

    public function enable_hierarchy_fields($post_type, $post_type_object){
        if($post_type== 'post' ){
            $post_type_object->hierarchical = true;
            $GLOBALS['_wp_post_type_features']['post']['page-attributes']=true;
        }
    }
    public function enable_hierarchy_fields_for_js($labels){
        $labels->parent_item_colon='Parent Post';
        return $labels;
    }
    public function change_permalinks($permalink, $post=false, $leavename=false){
        $postTypes = ['post'];
        foreach ($postTypes  as $each_post_type){
            if($post->post_type == $each_post_type){
                // return if %postname% tag is not present in the url:
                if ( false === strpos( $permalink, '%postname%'))
                    return $permalink;
                $permalink = $this->remove_extra_slashes('/'. $this->get_parents_slugpath($post). '/'. '%postname%' );
                 $GLOBALS['wp_rewrite']->flush_rules();
                 flush_rewrite_rules();
            }
        }
        return $permalink;
    }
    public function get_parents_slugpath($post){
        $final_SLUGG = '';
        if (!empty($post->post_parent)){
            $parent_post= get_post($post->post_parent);
            while(!empty($parent_post)){
                $final_SLUGG =  $parent_post->post_name .'/'.$final_SLUGG;
                if (!empty($parent_post->post_parent) ) { $parent_post = get_post( $parent_post->post_parent); } else{ break ;}
            }
        }
        return $final_SLUGG;
    }
    public function remove_extra_slashes($path){
        return  str_replace( '//', '/', $path);
    }

    public function method__modify_post_obj($post_type, $post_type_object){
        $Type = 'post';
        if($post_type==$Type){
            $post_type_object->rewrite = ['with_front'=>false, 'slug'=>'/', 'feeds' => 1];
            $post_type_object->query_var =  'post';
            add_action('init', function(){
                $GLOBALS['wp_post_types']['post']->	add_rewrite_rules();
            } );
        }
    }
    public function activation_redirect( $plugin ) {
        if( $plugin == basename(plugin_dir_path(dirname(  __FILE__  , 1))) . '/post-hirarchy.php') {
            update_option('developer_api_activate_child_option_in_post', true);
            wp_redirect(admin_url('/options-general.php?page=developer_api'));
            die();
        }
    }

}

