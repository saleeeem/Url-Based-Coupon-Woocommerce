<?php 

/**
 * Apply a WooCommerce discount code to cart via URL parameter.
 * This code is adapted from: https://www.webroomtech.com/apply-coupon-via-url-in-woocommerce/
 */
function my_woocommerce_apply_cart_coupon_in_url() {
	// Return early if WooCommerce or sessions aren't available.
	if ( ! function_exists( 'WC' ) || ! WC()->session ) {
		return;
	}

	// Return if there is no coupon in the URL, otherwise set the variable.
	if ( empty( $_REQUEST['coupon'] ) ) {
		return;
	} else {
		$coupon_code = esc_attr( $_REQUEST['coupon'] );
	}

	// Set a session cookie to remember the coupon if they continue shopping.
	WC()->session->set_customer_session_cookie(true);

	// Apply the coupon to the cart if necessary.
	if ( ! WC()->cart->has_discount( $coupon_code ) ) {

		// WC_Cart::add_discount() sanitizes the coupon code.
		WC()->cart->add_discount( $coupon_code );
	}
}
add_action('wp_loaded', 'my_woocommerce_apply_cart_coupon_in_url', 30);
add_action('woocommerce_add_to_cart', 'my_woocommerce_apply_cart_coupon_in_url');

