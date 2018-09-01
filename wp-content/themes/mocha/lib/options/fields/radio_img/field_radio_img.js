/*
 *
 * Mocha_Options_radio_img function
 * Changes the radio select option, and changes class on images
 *
 */
function mocha_radio_img_select(relid, labelclass){
	jQuery(this).prev('input[type="radio"]').prop('checked');

	jQuery('.mocha-radio-img-'+labelclass).removeClass('mocha-radio-img-selected');	
	
	jQuery('label[for="'+relid+'"]').addClass('mocha-radio-img-selected');
}//function