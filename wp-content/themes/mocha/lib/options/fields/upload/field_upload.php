<?php
class Mocha_Options_upload extends Mocha_Options{
	
	/**
	 * Field Constructor.
	 *
	 * Required - must call the parent constructor, then assign field and value to vars, and obviously call the render field function
	 *
	 * @since Mocha_Options 1.0
	*/
	function __construct($field = array(), $value ='', $parent = ''){
		
		parent::__construct($parent->sections, $parent->args, $parent->extra_tabs);
		$this->field = $field;
		$this->value = $value;
		
	}//function
	
	
	
	/**
	 * Field Render Function.
	 *
	 * Takes the vars and outputs the HTML for the field in the settings
	 *
	 * @since Mocha_Options 1.0
	*/
	function render(){
		
		$class = (isset($this->field['class']))? esc_attr( $this->field['class'] ):'regular-text';
		
		
		echo '<input type="hidden" id="'.esc_attr( $this->field['id'] ).'" name="'.$this->args['opt_name'].'['.$this->field['id'].']" value="'.$this->value.'" class="'.$class.'" />';
			
		echo '<img class="mocha-opts-screenshot" id="mocha-opts-screenshot-'.$this->field['id'].'" src="'.esc_url( $this->value ).'" width="30"/>';
		
		if($this->value == ''){$remove = ' style="display:none;"';$upload = '';}else{$remove = '';$upload = ' style="display:none;"';}
		echo ' <a href="javascript:void(0);" class="mocha-opts-upload button-secondary"'.$upload.' rel-id="'.$this->field['id'].'">'.esc_html__('Browse', 'mocha').'</a>';
		echo ' <a href="javascript:void(0);" class="mocha-opts-upload-remove"'.$remove.' rel-id="'.$this->field['id'].'">'.esc_html__('Remove Upload', 'mocha').'</a>';
		
		echo (isset($this->field['desc']) && !empty($this->field['desc']))?'<br/><br/><span class="description">'.esc_html( $this->field['desc'] ).'</span>':'';
		
	}//function
	
	
	
	/**
	 * Enqueue Function.
	 *
	 * If this field requires any scripts, or css define this function and register/enqueue the scripts/css
	 *
	 * @since Mocha_Options 1.0
	*/
	function enqueue(){
		
		wp_enqueue_script(
			'mocha-menu-upload-js',
			MOCHA_URL.'/options/fields/upload/field_upload.js',
			array('jquery', 'thickbox', 'media-upload'),
			time(),
			true
		);
		
		wp_enqueue_style('thickbox'); // thanks to https://github.com/rzepak
		
		wp_localize_script('mocha-menu-upload-js', 'mocha_upload', array('url' => MOCHA_URL.'/admin/img/mocha.png'));
		
	}//function
	
}//class
?>