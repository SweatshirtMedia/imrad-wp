<?php
/*
Template Name: Register
 */

?>

<?php get_header();

if ($_POST) {

    global $wpdb;

//We shall SQL escape all inputs
    $username = $wpdb->escape($_REQUEST['username']);
    $password = $wpdb->escape($_REQUEST['password']);
    $remember = $wpdb->escape($_REQUEST['rememberme']);

    if ($remember) {
        $remember = "true";
    } else {
        $remember = "false";
    }

    $login_data = array();
    $login_data['user_login'] = $username;
    $login_data['user_password'] = $password;
    $login_data['remember'] = $remember;

    $user_verify = wp_signon($login_data, false);

    if (is_wp_error($user_verify)) {
        echo '<span class="mine">Invlaid Login Details</span>';
    } else {
        wp_redirect( home_url() );
        exit();
    }

} else {}
?>

<main>
<container class="banner login">
<section class="login__card">
<h1>Create An Account</h1>

<form name="loginform" id="loginform" method="post">

			<p class="register-username">
				<label for="user_login">Email Address</label>
				<input type="text" name="log" id="user_login" class="input" value="">
			</p>
			<p class="register-password">
				<label for="user_pass">Password</label>
				<input type="password" name="pwd" id="user_pass" class="input" value="">
			</p>

            <p class="register-confirm">
				<label for="user_pass">Confirm Password</label>
				<input type="password" name="pwd" id="user_pass" class="input" value="">
			</p>
            <p class="register-newsletter">

    <input type="checkbox" name="newsletter" id="newsletter">
    <label for="newsletter">Receive News and Updates via Email?</label>
            </p>


			<p class="login-submit">
				<input type="submit" name="wp-submit" id="wp-submit" class="button button-primary" value="Create Account">
			</p>

		</form>


<hr />

<a href="<?=home_url()?>/login" class="need">Already Have An Account? Login &raquo;</a>

</section>
</container>

	</main>

<?php get_footer();?>

