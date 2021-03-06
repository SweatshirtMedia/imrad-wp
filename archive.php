<?php get_template_part("includes/inc.state");?>
<?php get_template_part("includes/inc.people");?>

<?php get_header();?>
<main class="page content">
<container class="banner darker page__title">
		<?php
$postType = get_post_type_object(get_post_type());
echo sprintf("<h1><a href='%s'>%s</a></h1>", home_url($postType->has_archive), $postType->labels->name);?>
							<?php
set_query_var('search_page', true);
set_query_var('placeholder', "Search for a " . $postType->labels->singular_name);
get_template_part('components/common/searchBar');
set_query_var('search_page', false);?>
		</container>
		<section class="page__content">
		<?php

the_posts_pagination(array(
    'mid_size'  => 5,
    'prev_text' => __('&laquo; Previous', 'imrad'),
    'next_text' => __('Next Page &raquo; ', 'imrad'),
));

?>
<?php
if (have_posts()) {
    echo "<section class='card-grid'>";
    while (have_posts()) {
        the_post();

        switch (get_post_type()) {

            case "people":
                $person = new Person(get_post());
                $person->personCard();
                break;
            case "state":
                $state = new State(get_post());
                $state->stateCard();
                break;

        }

    }
    echo "</section>";

} else {

    echo "No Current Senators";
}

wp_reset_postdata();

?>

<?php

the_posts_pagination(array(
    'mid_size'  => 5,
    'prev_text' => __('&laquo; Back', 'imrad'),
    'next_text' => __('Next &raquo; ', 'imrad'),
));

?>


</section>
	</main>
<?php get_footer();?>