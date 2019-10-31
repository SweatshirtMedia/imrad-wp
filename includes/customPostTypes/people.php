<?php

// Peoples Custom Post Type

function people_post_type()
{

    $labels = array(
        'name' => _x('People', 'Post Type General Name', 'imrad'),
        'singular_name' => _x('People', 'Post Type Singular Name', 'imrad'),
        'menu_name' => __('People', 'imrad'),
        'name_admin_bar' => __('People', 'imrad'),
        'archives' => __('Directory', 'imrad'),
        'attributes' => __('People Attributes', 'imrad'),
        'parent_item_colon' => __('Parents:', 'imrad'),
        'all_items' => __('All People', 'imrad'),
        'add_new_item' => __('Add New Person', 'imrad'),
        'add_new' => __('Add New', 'imrad'),
        'new_item' => __('New Person', 'imrad'),
        'edit_item' => __('Edit Person', 'imrad'),
        'update_item' => __('Update Person', 'imrad'),
        'view_item' => __('View Person', 'imrad'),
        'view_items' => __('View People', 'imrad'),
        'search_items' => __('Search People', 'imrad'),
        'not_found' => __('Not found', 'imrad'),
        'not_found_in_trash' => __('Not found in Trash', 'imrad'),
        'featured_image' => __('Headshot', 'imrad'),
        'set_featured_image' => __('Set Headshot', 'imrad'),
        'remove_featured_image' => __('Remove Headshot', 'imrad'),
        'use_featured_image' => __('Use as Headshot', 'imrad'),
        'insert_into_item' => __('Insert into people', 'imrad'),
        'uploaded_to_this_item' => __('Uploaded to this person', 'imrad'),
        'items_list' => __('Directory', 'imrad'),
        'items_list_navigation' => __('Directory navigation', 'imrad'),
        'filter_items_list' => __('Filter directory', 'imrad'),
    );
    $args = array(
        'label' => __('People', 'imrad'),
        'description' => __('Elected Officials in the USA', 'imrad'),
        'labels' => $labels,
        'supports' => array('title', 'editor', 'thumbnail', 'revisions'),
        'hierarchical' => false,
        'public' => true,
        'menu_icon' => 'dashicons-businessman',
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 7,
        'show_in_admin_bar' => true,
        'show_in_nav_menus' => true,
        'can_export' => true,
        'has_archive' => 'people',
        'query_var' => true,
        'rewrite' => true,
        'hierarchical' => true,
        'exclude_from_search' => false,
        'publicly_queryable' => true,
        'taxonomies' => ['title'],
    );
    register_post_type('people', $args);

}
add_action('init', 'people_post_type', 0);

function people_add_meta_boxes($post)
{
    add_meta_box('people_info', __('People Info', 'imrad'), 'people_build_info_meta_box', 'people', 'normal', 'high');
    add_meta_box('people_info', __('State & District', 'imrad'), 'people_build_state_meta_box', 'people', 'normal', 'high');

    add_meta_box('people_stats', __('People Stats', 'imrad'), 'people_build_stats_meta_box', 'people', 'side', 'high');
    add_meta_box('people_social', __('People Social Links', 'imrad'), 'people_build_social_meta_box', 'people', 'side', 'high');

}
add_action('add_meta_boxes_people', 'people_add_meta_boxes');

function people_build_state_meta_box($post)
{



    wp_nonce_field(basename(__FILE__), 'people_meta_box_nonce');

    $current_state = get_post_meta($post->ID, 'state', true);

    ?>

    <div class='inside'>
    <p>
        State: <select name="state" id="state">

    <option <?=(!$current_state ? "selected" : "") ?> disabled>Select A State</option>

        <?php // WP_Query arguments
    $args = array(
        'post_type' => array('state'),
        'order' => 'ASC',
        'orderby' => 'menu_order',
    );

// The Query
    $states = new WP_Query($args);

// The Loop
    if ($states->have_posts()) {
        while ($states->have_posts()) {
            $states->the_post();
            // do something
            $abbr = get_post_meta(get_the_id(), 'abbreviation', true);

    
    echo sprintf('<option %s value="%s">%s - %s</option>',($current_state == $abbr ? "selected": ""), $abbr, $abbr, get_the_title());

        }
    } else {
        // no posts found
    }

// Restore original Post Data
    wp_reset_postdata(); ?>

        </select>
	</p>




</div>



<?php

}

function people_build_stats_meta_box($post)
{
    // our code here

    wp_nonce_field(basename(__FILE__), 'people_meta_box_nonce');

    $current_population = get_post_meta($post->ID, 'population', true);
    $current_districts_count = get_post_meta($post->ID, 'districts_count', true);

    ?>

    <div class='inside'>
    <p>
        Population: <input type="number" placeholder="e.g. 2,123,412" name="population" value="<?php echo $current_population; ?>" />
	</p>

	<p>
        # of Districts: <input type="number" placeholder="e.g. 12" name="districts_count" value="<?php echo $current_districts_count; ?>" />
    </p>


</div>



<?php

}

function people_build_social_meta_box($post)
{
    // our code here

    wp_nonce_field(basename(__FILE__), 'people_meta_box_nonce');

    $current_website = get_post_meta($post->ID, 'website', true);
    $current_facebook = get_post_meta($post->ID, 'facebook', true);
    $current_twitter = get_post_meta($post->ID, 'twitter', true);

    ?>

    <div class='inside'>
    <p>
        Website: <input type="text" placeholder="e.g. https://IsMyRepADipshit.com" name="website" value="<?php echo $current_website; ?>" />
    </p>
    <p>
        Facebook Username: <input type="text" placeholder="e.g. DipShitRep" name="facebook" value="<?php echo $current_facebook; ?>" />
    </p>
    <p>
        Twitter Username: <input type="text" placeholder="e.g. DipShitRep" name="twitter" value="<?php echo $current_twitter; ?>" />
	</p>


</div>



<?php

}

function people_build_info_meta_box($post)
{
    // our code here

    wp_nonce_field(basename(__FILE__), 'people_meta_box_nonce');

    $current_abbreviation = get_post_meta($post->ID, 'abbreviation', true);
    $current_motto = get_post_meta($post->ID, 'motto', true);

    ?>

    <div class='inside'>
    <p>
	Abbreviation: <input type="text" maxlength="2" placeholder="e.g. NM" name="abbreviation" value="<?php echo $current_abbreviation; ?>" />
	</p>

	<p>
	People Motto: <input type="text" placeholder="e.g. Land of Enchantment" name="motto" value="<?php echo $current_motto; ?>" />
    </p>

</div> <?php

}

function people_save_meta_boxes_data($post_id)
{
    if (!isset($_POST['people_meta_box_nonce']) || !wp_verify_nonce($_POST['people_meta_box_nonce'], basename(__FILE__))) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;

    }

    if (isset($_REQUEST['state'])) {
        update_post_meta($post_id, 'state', sanitize_text_field($_POST['state']));
    }
///////////
    // Stats //
    ///////////
    if (isset($_REQUEST['population'])) {
        update_post_meta($post_id, 'population', sanitize_text_field($_POST['population']));
    }

    if (isset($_REQUEST['districts_count'])) {
        update_post_meta($post_id, 'districts_count', sanitize_text_field($_POST['districts_count']));
    }

///////////
    // Info  //
    ///////////

    if (isset($_REQUEST['abbreviation'])) {
        update_post_meta($post_id, 'abbreviation', strtoupper(sanitize_text_field($_POST['abbreviation'])));
    }

    if (isset($_REQUEST['motto'])) {
        update_post_meta($post_id, 'motto', sanitize_text_field($_POST['motto']));
    }

    // Social Links

    if (isset($_REQUEST['website'])) {
        update_post_meta($post_id, 'website', sanitize_text_field($_POST['website']));
    }

    if (isset($_REQUEST['facebook'])) {
        update_post_meta($post_id, 'facebook', sanitize_text_field($_POST['facebook']));
    }

    if (isset($_REQUEST['twitter'])) {
        update_post_meta($post_id, 'twitter', sanitize_text_field($_POST['twitter']));
    }
}
add_action('save_post_people', 'people_save_meta_boxes_data', 10, 2);




// Banner Image for People

add_action('after_setup_theme', 'people_banner_setup');


function people_banner_setup()
{
    add_action('add_meta_boxes', 'people_banner_meta_box');
    add_action('save_post', 'people_banner_save');
}

function people_banner_meta_box()
{

    //on which post types should the box appear?
    $post_types = array('people');
    foreach ($post_types as $pt) {
        add_meta_box('people_banner_meta_box', __('Banner Image', 'imrad'), 'people_banner_meta_box_func', $pt, 'side', 'low');
    }
}

function people_banner_meta_box_func($post)
{

    //an array with all the images (ba meta key). The same array has to be in custom_postimage_meta_box_save($post_id) as well.
    $meta_keys = array('banner_image');

    foreach ($meta_keys as $meta_key) {
        $image_meta_val = get_post_meta($post->ID, $meta_key, true);
        ?>
        <div class="custom_logo_wrapper" id="<?php echo $meta_key; ?>_wrapper" style="margin-bottom:20px;">
            <img src="<?php echo ($image_meta_val != '' ? wp_get_attachment_image_src($image_meta_val)[0] : ''); ?>" style="width:100%;display: <?php echo ($image_meta_val != '' ? 'block' : 'none'); ?>" alt="">
            <a class="addimage button" onclick="custom_logo_add_image('<?php echo $meta_key; ?>');"><?php _e('Add Image', 'imrad');?></a><br>
            <a class="removeimage" style="color:#a00;cursor:pointer;display: <?php echo ($image_meta_val != '' ? 'block' : 'none'); ?>" onclick="custom_logo_remove_image('<?php echo $meta_key; ?>');"><?php _e('remove image', 'imrad');?></a>
            <input type="hidden" name="<?php echo $meta_key; ?>" id="<?php echo $meta_key; ?>" value="<?php echo $image_meta_val; ?>" />
        </div>
    <?php }?>
    <script>
    function custom_logo_add_image(key){

        var $wrapper = jQuery('#'+key+'_wrapper');

        custom_logo_uploader = wp.media.frames.file_frame = wp.media({
            title: '<?php _e('Select Banner', 'imrad');?>',
            button: {
                text: '<?php _e('Select Banner', 'imrad');?>'
            },
            multiple: false
        });
        custom_logo_uploader.on('select', function() {

            var attachment = custom_logo_uploader.state().get('selection').first().toJSON();
            var img_url = attachment['url'];
            var img_id = attachment['id'];
            $wrapper.find('input#'+key).val(img_id);
            $wrapper.find('img').attr('src',img_url);
            $wrapper.find('img').show();
            $wrapper.find('a.removeimage').show();
        });
        custom_logo_uploader.on('open', function(){
            var selection = custom_logo_uploader.state().get('selection');
            var selected = $wrapper.find('input#'+key).val();
            if(selected){
                selection.add(wp.media.attachment(selected));
            }
        });
        custom_logo_uploader.open();
        return false;
    }

    function custom_logo_remove_image(key){
        var $wrapper = jQuery('#'+key+'_wrapper');
        $wrapper.find('input#'+key).val('');
        $wrapper.find('img').hide();
        $wrapper.find('a.removeimage').hide();
        return false;
    }
    </script>
    <?php
wp_nonce_field('custom_logo_meta_box', 'custom_logo_meta_box_nonce');
}

function people_banner_save($post_id)
{

    if (!current_user_can('edit_posts', $post_id)) {return 'not permitted';}

    if (isset($_POST['custom_logo_meta_box_nonce']) && wp_verify_nonce($_POST['custom_logo_meta_box_nonce'], 'custom_logo_meta_box')) {

        //same array as in custom_postimage_meta_box_func($post)
        $meta_keys = array('banner_image');
        foreach ($meta_keys as $meta_key) {
            if (isset($_POST[$meta_key]) && intval($_POST[$meta_key]) != '') {
                update_post_meta($post_id, $meta_key, intval($_POST[$meta_key]));
            } else {
                update_post_meta($post_id, $meta_key, '');
            }
        }
    }
}