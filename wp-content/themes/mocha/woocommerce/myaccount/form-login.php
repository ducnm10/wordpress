<?php
/**
 * Login Form
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>

<?php wc_print_notices(); ?>

<?php do_action( 'woocommerce_before_customer_login_form' ); ?>
<?php
	global $mocha_detect;
	$mobile_check   = mocha_options()->getCpanelValue( 'mobile_enable' );
	if( !empty( $mocha_detect ) && ( $mocha_detect->isMobile() ) && $mobile_check )  : ?>

<div class="col2-set row" id="customer_login">

	<div class="col-lg-6 col-md-6 col-sm-12">
		<div class="image-login">
			<img class="img_logo" alt="404" src="<?php echo get_template_directory_uri(); ?>/assets/img/icon-myaccount.png">
		</div>
		
		<h2><?php esc_html_e( 'Login', 'mocha' ); ?></h2>
		
		<form method="post" class="login">

			<?php do_action( 'woocommerce_login_form_start' ); ?>

			<p class="form-row form-row-wide">
				<label for="username"><?php esc_html_e( 'Username or email address', 'mocha' ); ?><span class="required">*</span></label>
				<input type="text" class="input-text" name="username" id="username" value="admin" />
			</p>
			<p class="form-row form-row-wide">
				<label for="password"><?php esc_html_e( 'Password', 'mocha' ); ?><span class="required">*</span></label>
				<input class="input-text" type="password" name="password" id="password" value="templates"/>
			</p>

			<?php do_action( 'woocommerce_login_form' ); ?>
			<p class="form-row">
				<label for="rememberme" class="inline">
					<input name="rememberme" type="checkbox" id="rememberme" value="forever" /> <?php esc_html_e( 'Remember me', 'mocha' ); ?>
				</label>
			</p>
			<p class="form-row">
				<?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
				<input type="submit" class="button" name="login" value="<?php esc_html_e( 'Login', 'mocha' ); ?>" /> 
			</p>
			<p class="lost_password">
				<a href="<?php echo esc_url( wc_lostpassword_url() ); ?>"><?php esc_html_e( 'Lost your password?', 'mocha' ); ?></a>
			</p>

			<?php do_action( 'woocommerce_login_form_end' ); ?>

		</form>
	</div>
<?php if ( get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' ) : ?>

	<div class="col-lg-6 col-md-6 col-sm-12">

		<h2><?php esc_html_e( 'Register', 'mocha' ); ?></h2>

		<form method="post" class="register">

			<?php do_action( 'woocommerce_register_form_start' ); ?>

			<?php if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) ) : ?>

				<p class="form-row form-row-wide">
					<label for="reg_username"><?php esc_html_e( 'Username', 'mocha' ); ?> <span class="required">*</span></label>
					<input type="text" class="input-text" name="username" id="reg_username" value="<?php if ( ! empty( $_POST['username'] ) ){ echo esc_attr( $_POST['username'] ) ;} else { echo esc_html_e( 'admin', 'mocha' ); } ?>" />
				</p>

			<?php endif; ?>

			<p class="form-row form-row-wide">
				<label for="reg_email"><?php esc_html_e( 'Email address', 'mocha' ); ?> <span class="required">*</span></label>
				<input type="email" class="input-text" name="email" id="reg_email" value="<?php if ( ! empty( $_POST['email'] ) ) { echo esc_attr( $_POST['email'] ); } else{ echo esc_html_e( 'ytc@smartaddon.com', 'mocha' ); }?>" />
			</p>

			<?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>

				<p class="form-row form-row-wide">
					<label for="reg_password"><?php esc_html_e( 'Password', 'mocha' ); ?> <span class="required">*</span></label>
					<input type="password" class="input-text" name="password" id="reg_password" value="templates" />
				</p>

			<?php endif; ?>

			<!-- Spam Trap -->
			<div style="<?php echo ( ( is_rtl() ) ? 'right' : 'left' ); ?>: -999em; position: absolute;"><label for="trap"><?php esc_html_e( 'Anti-spam', 'mocha' ); ?></label><input type="text" name="email_2" id="trap" tabindex="-1" /></div>

			<?php do_action( 'woocommerce_register_form' ); ?>
			<?php do_action( 'register_form' ); ?>

			<p class="form-row">
				<?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ); ?>
				<input type="submit" class="button" name="register" value="<?php esc_html_e( 'Register', 'mocha' ); ?>" />
			</p>

			<?php do_action( 'woocommerce_register_form_end' ); ?>

		</form>
					<!-- Social -->
		<?php mocha_get_social() ?>
	</div>
	</div>
<?php endif; ?>
</div>
<?php else :?>
<?php if ( get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' ) : ?>

<div class="col2-set row" id="customer_login">

	<div class="col-lg-6 col-md-6 col-sm-12">

<?php endif; ?>

		<h2><?php esc_html_e( 'Login', 'mocha' ); ?></h2>

		<form method="post" class="login">

			<?php do_action( 'woocommerce_login_form_start' ); ?>

			<p class="form-row form-row-wide">
				<label for="username"><?php esc_html_e( 'Username or email address', 'mocha' ); ?> <span class="required">*</span></label>
				<input type="text" class="input-text" name="username" id="username" value="admin" />
			</p>
			<p class="form-row form-row-wide">
				<label for="password"><?php esc_html_e( 'Password', 'mocha' ); ?> <span class="required">*</span></label>
				<input class="input-text" type="password" name="password" id="password" value="templates" />
			</p>

			<?php do_action( 'woocommerce_login_form' ); ?>
			<p class="form-row">
				<label for="rememberme" class="inline">
					<input name="rememberme" type="checkbox" id="rememberme" value="forever" /> <?php esc_html_e( 'Remember me', 'mocha' ); ?>
				</label>
			</p>
			<p class="form-row">
				<?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
				<input type="submit" class="button" name="login" value="<?php esc_html_e( 'Login', 'mocha' ); ?>" /> 
			</p>
			<p class="lost_password">
				<a href="<?php echo esc_url( wc_lostpassword_url() ); ?>"><?php esc_html_e( 'Lost your password?', 'mocha' ); ?></a>
			</p>

			<?php do_action( 'woocommerce_login_form_end' ); ?>

		</form>

<?php if ( get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' ) : ?>

	</div>

	<div class="col-lg-6 col-md-6 col-sm-12">

		<h2><?php esc_html_e( 'Register', 'mocha' ); ?></h2>

		<form method="post" class="register">

			<?php do_action( 'woocommerce_register_form_start' ); ?>

			<?php if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) ) : ?>

				<p class="form-row form-row-wide">
					<label for="reg_username"><?php esc_html_e( 'Username', 'mocha' ); ?> <span class="required">*</span></label>
					<input type="text" class="input-text" name="username" id="reg_username" value="<?php if ( ! empty( $_POST['username'] ) ){ echo esc_attr( $_POST['username'] ); } else { echo esc_html_e( 'admin', 'mocha' ); }?>" />
				</p>

			<?php endif; ?>

			<p class="form-row form-row-wide">
				<label for="reg_email"><?php esc_html_e( 'Email address', 'mocha' ); ?> <span class="required">*</span></label>
				<input type="email" class="input-text" name="email" id="reg_email" value="<?php if ( ! empty( $_POST['email'] ) ) { echo esc_attr( $_POST['email'] ); } else{ echo esc_html_e( 'ytc@smartaddon.com', 'mocha' ); }?>" />
			</p>

			<?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>

				<p class="form-row form-row-wide">
					<label for="reg_password"><?php esc_html_e( 'Password', 'mocha' ); ?> <span class="required">*</span></label>
					<input type="password" class="input-text" name="password" id="reg_password" />
				</p>

			<?php endif; ?>

			<!-- Spam Trap -->
			<div style="<?php echo ( ( is_rtl() ) ? 'right' : 'left' ); ?>: -999em; position: absolute;"><label for="trap"><?php esc_html_e( 'Anti-spam', 'mocha' ); ?></label><input type="text" name="email_2" id="trap" tabindex="-1" /></div>

			<?php do_action( 'woocommerce_register_form' ); ?>
			<?php do_action( 'register_form' ); ?>

			<p class="form-row">
				<?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ); ?>
				<input type="submit" class="button" name="register" value="<?php esc_html_e( 'Register', 'mocha' ); ?>" />
			</p>

			<?php do_action( 'woocommerce_register_form_end' ); ?>

		</form>
	</div>
</div>
<?php endif; ?>
<?php endif; ?>

<?php do_action( 'woocommerce_after_customer_login_form' ); ?>