<?php
class Mocha_Options_multi_text extends Mocha_Options{	
	
	/**
	 * Field Constructor.
	 *
	 * Required - must call the parent constructor, then assign field and value to vars, and obviously call the render field function
	 *
	 * @since Mocha_Options 1.0.5
	*/
	function __construct($field = array(), $value ='', $parent){
		
		parent::__construct($parent->sections, $parent->args, $parent->extra_tabs);
		$this->field = $field;
		$this->value = $value;
		
		
	}//function
	
	
	
	/**
	 * Field Render Function.
	 *
	 * Takes the vars and outputs the HTML for the field in the settings
	 *
	 * @since Mocha_Options 1.0.5
	*/
	function render(){
		
		$class = (isset($this->field['class']))?esc_attr( $this->field['class'] ):'regular-text';
		
		echo '<ul id="'.$this->field['id'].'-ul">';
		
		if(isset($this->value) && is_array($this->value)){
			foreach($this->value as $k => $value){
				if($value != ''){
				
					echo '<li><input type="text" id="'.esc_attr( $this->field['id'] ).'-'.$k.'" name="'.$this->args['opt_name'].'['.$this->field['id'].'][]" value="'.esc_attr($value).'" class="'.$class.'" /> <a href="javascript:void(0);" class="mocha-opts-multi-text-remove">'.esc_html__('Remove', 'mocha').'</a></li>';
					
				}//if
				
			}//foreach
		}else{
		
			echo '<li><input type="text" id="'.esc_attr( $this->field['id'] ).'" name="'.$this->args['opt_name'].'['.$this->field['id'].'][]" value="" class="'.$class.'" /> <a href="javascript:void(0);" class="mocha-opts-multi-text-remove">'.esc_html__('Remove', 'mocha').'</a></li>';
		
		}//if
		
		echo '<li style="display:none;"><input type="text" id="'.esc_attr( $this->field['id'] ).'" name="" value="" class="'.$class.'" /> <a href="javascript:void(0);" class="mocha-opts-multi-text-remove">'.esc_html__('Remove', 'mocha').'</a></li>';
		
		echo '</ul>';
		
		echo '<a href="javascript:void(0);" class="mocha-opts-multi-text-add" rel-id="'.esc_attr( $this->field['id'] ).'-ul" rel-name="'.$this->args['opt_name'].'['.$this->field['id'].'][]">'.esc_html__('Add More', 'mocha').'</a><br/>';
		
		echo (isset($this->field['desc']) && !empty($this->field['desc']))?' <span class="description">'.esc_html( $this->field['desc'] ).'</span>':'';
		
	}//function
	
	
	/**
	 * Enqueue Function.
	 *
	 * If this field requires any scripts, or css define this function and register/enqueue the scripts/css
	 *
	 * @since Mocha_Options 1.0.5
	*/
	function enqueue(){
		
		wp_enqueue_script(
			'mocha-opts-field-multi-text-js', 
			MOCHA_OPTIONS_URL.'fields/multi_text/field_multi_text.js', 
			array('jquery'),
			time(),
			true
		);
		
	}//function
	
}//class
?>