<?php

/**
 * Form Markup
 *
 * @param  string input filter.
 * @return data.
 */

function rioexp_form_markup() {
    ?>
        <form action="<?php esc_url( home_url( '/' ) );?>" method="post">
            <?php wp_nonce_field('add-item','cf_added'); ?>
	   
            <h1><?php esc_html_e( 'Get in touch!', 'astra' ); ?></h1>
            <select name="cf-options" required>
                <option value=""><?php esc_html_e( '-- Please choose an category --', 'astra' ); ?></option>
                <option value="<?php esc_attr_e( 'Secret Beaches', 'astra' ); ?>"><?php esc_html_e( 'Secret Beaches', 'astra' ); ?></option>
                <option value="<?php esc_attr_e( 'Wild Beaches', 'astra' ); ?>"><?php esc_html_e( 'Wild Beaches', 'astra' ); ?></option>
                <option value="<?php esc_attr_e( 'Stand-up', 'astra' ); ?>"><?php esc_html_e( 'Stand-up', 'astra' ); ?></option>
                <option value="<?php esc_attr_e( 'Surf Classes', 'astra' ); ?>"><?php esc_html_e( 'Surf Classes', 'astra' ); ?></option>
                <option value="<?php esc_attr_e( 'Custom Experience', 'astra' ); ?>"><?php esc_html_e( 'Custom Experience', 'astra' ); ?></option>      
            </select>

            <div class="wp-block-columns has-flex-wrap has-cb-flex-grow">
	            <div class="wp-block-column">    
                    <label for="cf-name">Nome</label>
	                <input type="text" name="cf-name" class="required-fields" pattern="[A-Za-z]{1,32}" placeholder="<?php esc_attr_e( 'Name', 'astra' ); ?>" value="<?php isset($_POST['cf-name']) ? esc_attr($_POST['cf-name']) : '';?>" size="40" required/>
                </div>

                <div class="wp-block-column">
                    <label for="cf-email">Email</label>
	                <input type="email" name="cf-email" class="required-fields" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" placeholder="Email" value="<?php isset($_POST['cf-email']) ? esc_attr($_POST['cf-email']) : '';?>" size="40" required/>
                </div>

                <div class="wp-block-column">
                    <label for="cf-date">Date</label>
                    <input type="date" name="cf-date" class="required-fields" pattern="[0-9]{2}-[0-9]{2}-[0-9]{4}" value="<?php isset($_POST['cf-date']) ? esc_attr($_POST['cf-date']) : '';?>" size="13" required/>
	            </div>

                <div class="wp-block-column">
                    <label for="cf-size">Phone</label>
                    <input id="cf-size" type="number" name="cf-size" placeholder="<?php esc_attr_e( 'Group Size', 'astra' ); ?>" value="<?php isset($_POST['cf-size']) ? esc_attr($_POST['cf-phone']) : '';?>" size="12" /> 
                </div>    

                <div class="wp-block-column has-full-flex-basis">
                    <label for="cf-message">Mensagem</label>
	                <textarea name="cf-message" placeholder="<?php esc_attr_e( 'Message', 'astra' ); ?>" required><?php isset($_POST['cf-message']) ? esc_textarea($_POST['cf-message']) : '';?></textarea>
                </div>  
            </div>
     
            <div class="wp-block-columns has-small-mt">
                <div class="wp-block-column">
                    <p><?php esc_html_e( 'REQUIRED FIELDS', 'astra' ); ?></p>
                </div>

                <div class="wp-block-column">
                    <button type="submit" name="cf-submitted" class="aligncenter" value="Send">
                        <span><?php esc_html_e( 'Send', 'astra' ); ?></span>
                    </button> 
                </div>
            </div>
     </form>
 <?php
}


/**
 * Function Form validation
 *
 * @param  string input filter.
 * @return data.
 */

function rioexp_validate_form() {

	if (isset($_POST[ 'content' ]) && $_POST[ 'content' ] !== '') {
	   exit("Sorry, this field should not be filled. Are you trying to cheat.");
    }
	
	if (isset( $_POST['add-item'] ) && !wp_verify_nonce( $_POST['add-item'], 'cf_added' ) ) {
		exit("Sorry, your nonce did not verify.");
	}
	
    if (in_array($_POST[ 'cf-options' ], array( '', esc_html_e( 'Secret Beaches', 'Wild Beaches', 'Stand-Up', 'Surf Classess', 'Custom Experience' )))) {
		exit("Please fill in a valid select.");
	}

	if (isset($_POST[ 'cf-name' ]) && !rioexp_validate_cf_name($_POST['cf-name']) ) {
		exit("Please fill in a valid name.");
	}

	if (isset($_POST[ 'cf-email' ]) && !is_email($_POST['cf-email']) ) {
		exit("Please fill in a valid email.");
	}

	if (isset($_POST[ 'cf-date' ]) && !rioexp_validate_cf_date($_POST['cf-date']) ) {
		exit("Please fill in a valid date.");
    }

    if (isset($_POST[ 'cf-size' ]) && !rioexp_validate_cf_size($_POST['cf-size']) ) {
	   exit("Please fill in a valid size (max is 12).");
    }

    if (isset($_POST[ 'cf-message' ]) && !rioexp_validate_cf_textarea($_POST['cf-message']) ) {
		exit("Please fill in a valid message");
	
	} else { 
		// process form data
	}
}

/**
 * Functions Validate Contact Form inputs
 *
 * @param  string input filter.
 * @return validate data.
 */

function rioexp_validate_cf_name( $input ) {
    // scenario 1: empty
    if (empty($input)) { 
        return false; 
    }
    // scenario 2: more than 22 characters 
    if (strlen(trim($input)) > 22) {
        return false;
    }
    // scenario 3: use numbers
    if (preg_match( '/^\D*$/', $input )==0 ) {
        return false;
    }     
    // passed successfully
    return true;
}


function rioexp_validate_cf_size($input) {
    // scenario 1: more than 2 characters 
    if (strlen(trim($input)) > 2) {
        return false;
    }
 	// passed successfully
    if (empty($input)) { 
	    return true; 
    } 
    // passed successfully
    if (filter_var($input, FILTER_VALIDATE_INT) === 0 || filter_var($input, FILTER_VALIDATE_INT)) {
        return true;
    }
}

function rioexp_validate_cf_date($date, $input = 'Y-m-d') {

    $d = DateTime::createFromFormat($input, $date);
    // The Y ( 4 digits year ) returns TRUE for any integer with any number of digits so changing the comparison from == to === fixes the issue.
    return $d && $d->format($input) === $date;
}


function rioexp_validate_cf_textarea( $input ) {
    // scenario 1: empty
    if (empty($input)) { 
        return false; 
    }
    // scenario 2: more than 200 characters 
    if (strlen(trim($input)) > 200) {
        return false;
    }  
    // passed successfully
    return true;
}


/**
 * Functions for Sanitize Contact Form inputs
 *
 * @param  string input filter.
 * @return safe data.
 */


function rioexp_sanitize_text($input) {
    return trim(stripslashes(sanitize_text_field($input)));
}

function rioexp_sanitize_email($input) {
    return trim(stripslashes(sanitize_email($input)));
}

function rioexp_sanitize_textarea($input) {
    return trim(stripslashes(sanitize_textarea_field($input)));
}

function rioexp_sanitize_number($input) {
    return trim(stripslashes(absint($input)));
}



/**
 * Function Error validation
 *
 * @param  string input filter.
 * @return data.
 */

 function rioexp_cf_form() {
    if (isset($_POST['cf-submitted']) && rioexp_validate_form()) {
        
		$args = array(
        'options' => rioexp_sanitize_text($_POST['cf-options']),
		'name' => rioexp_sanitize_text($_POST['cf-name']),
		'email' => rioexp_sanitize_email($_POST['cf-email']),
		'date' => rioexp_sanitize_number($_POST['cf-date']),
		'size' => rioexp_sanitize_number($_POST['cf-size']),
		'message' => rioexp_sanitize_textarea($_POST['cf-message']),
	    );
	    rioexp_deliver_mail($args);
	} else {
		return false;
	}
}
add_action('init', 'rioexp_cf_form');


/**
 * Function Form Delivery
 *
 * @param  string input filter.
 * @return data.
 */

function rioexp_deliver_mail($args = array()) {

 // This $default array is a way to initialize some default values that will be overwritten by our $args array.
 // We could add more keys as we see fit and it's a nice way to see what parameter we are using in our function.
 // It will only be overwritten with the values of our $args array if the keys are present in $args.
 // This uses WP wp_parse_args() function.
    $defaults = array(
    'options' => '',
    'name' => '',
    'email' => '',
    'date' => '', 
    'size' => '',
    'message' => '',
    'to' => get_option('admin_email'), // get the administrator's email address
    );

	$args = wp_parse_args($args, $defaults);

	$headers = "From: {$args['name']}  <{$args['email']}>"."\r\n";

 // Send email returns true on success, false otherwise
    if (wp_mail($args['to'], $args['message'], $headers)) {
	 return;
    } else {
    
    return false;
    }
}

/**
 * Functions Redirect to Thank You Page after Form Submited
 *
 * @param  string input filter.
 * @return validate data.
 */

function rioexp_redirect_form_submitted () {

	if (is_page( 3707 ) && $_SERVER['REQUEST_METHOD'] == 'POST') { 
		header('Location: http://192.168.64.3/wordpress/thank-you'); 
    }
    
    if (is_page( 527 ) && $_SERVER['REQUEST_METHOD'] == 'POST') { 
		header('Location: http://192.168.64.3/wordpress/en/page-thank-you'); 
    }
    
    if (is_page( 630 ) && $_SERVER['REQUEST_METHOD'] == 'POST') { 
		header('Location: http://192.168.64.3/wordpress/es/pagina-gracias'); 
	}
}
add_action( 'astra_html_before','rioexp_redirect_form_submitted' );