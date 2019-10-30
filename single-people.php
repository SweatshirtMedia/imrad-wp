<?php get_template_part("includes/inc.people");?>
<?php get_header();?>
<?php $current_fp = get_query_var('fpage');?>
<main>
	<article class="single single-people">


	<?php
if (have_posts()) {
    while (have_posts()) {
        the_post();

        $post_id = get_the_id();

        $person = new Person(get_post());

        //
        // Post Content here
        //
        ?>


<header class="people__header">

<section class="header__content">

<h2 class="people__title"><?=$person->title?> from <a href="<?=$person->stateLink()?>"><?=$person->stateName()?></a></h2>
<h1 class="people__name"><?=$person->name?></h1>

<ul class="people__actions"> 
    <li><button class="follow-button btn-alt">Follow</button></li>


    <?php

        // $url, $icon, $label
        $link_template = "<li><a href='%s' class='social-link'><i class='fa-fw %s'></i>%s</a></li>";?>

<?=($person->website ? sprintf($link_template, $person->website, "fas fa-globe", "Website") : "");?>
<?=($person->facebook ? sprintf($link_template, "https://facebook.com/" . $person->facebook, "fab fa-facebook-f", "Facebook") : "");?>
<?=($person->twitter ? sprintf($link_template, "https://twitter.com/" . $person->twitter, "fab fa-twitter", "Twitter") : "");?>

    </ul>


<img src="<?=$person->headshotUrl?>" alt="<?=$person->name?>" class="people__headshot">

    </section>



</header>

<nav class="people__subpage-nav">

<ul>
    <li><a href="<?=$person->url?>" <?= (!$current_fp ? "class='current'" : "") ?>>Overview</a></li>
    <li><a href="<?=$person->url?>voting-history/" <?= ($current_fp == 'voting-history' ? "class='current'" : "") ?>>Voting History</a></li>
    <li><a href="<?=$person->url?>donations/" <?= ($current_fp == 'donations' ? "class='current'" : "") ?>>Donation History</a></li>
    <li><a href="<?=$person->url?>bio/" <?= ($current_fp == 'bio' ? "class='current'" : "") ?>>About</a></li>

    </ul>

    </nav>

    

<?php if (!$current_fp) {
            get_template_part('single', 'people-index');
        } else if ($current_fp == 'voting-history') {
            get_template_part('single', 'people-voting-history');
        } else if ($current_fp == 'donations') {
            get_template_part('single', 'people-donations');
        } else if ($current_fp == 'bio') {
            get_template_part('single', 'people-bio');
        }
        ;?>



<?php
} // end while
} // end if
?>

</article>
	</main>
<?php get_footer();?>