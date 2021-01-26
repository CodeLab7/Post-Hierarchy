<?php

class Posthierarchy_Admin {

    public function enable_hierarchy_fields($post_type, $post_type_object) {
        if ($post_type == 'post') {
            $post_type_object->hierarchical = true;
            $GLOBALS['_wp_post_type_features']['post']['page-attributes'] = true;
            $post_type_object->rewrite = ['with_front' => false, 'slug' => '/', 'feeds' => 1];
            $post_type_object->query_var = 'post';
            add_action('init', function () {
                $GLOBALS['wp_post_types']['post']->add_rewrite_rules();
            });
        }
    }

    public function change_labels($labels) {
        $labels->parent_item_colon = __('Parent Post', 'post-hierarchy');
        return $labels;
    }

    public function change_permalinks($permalink, $post = false, $leavename = false) {
        $postTypes = ['post'];
        foreach ($postTypes as $each_post_type) {
            if ($post->post_type == $each_post_type) {
                // return if %postname% tag is not present in the url:
                if (false === strpos($permalink, '%postname%'))
                    return $permalink;
                $permalink = $this->remove_extra_slashes('/' . $this->get_parents_slug($post) . '/' . '%postname%');
                $GLOBALS['wp_rewrite']->flush_rules();
                flush_rewrite_rules();
            }
        }
        return $permalink;
    }

    private function get_parents_slug($post) {
        $final_SLUGG = '';
        if (!empty($post->post_parent)) {
            $parent_post = get_post($post->post_parent);
            while (!empty($parent_post)) {
                $final_SLUGG = $parent_post->post_name . '/' . $final_SLUGG;
                if (!empty($parent_post->post_parent)) {
                    $parent_post = get_post($parent_post->post_parent);
                } else {
                    break;
                }
            }
        }
        return $final_SLUGG;
    }

    private function remove_extra_slashes($path) {
        return str_replace('//', '/', $path);
    }

}

