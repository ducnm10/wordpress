jQuery(document).ready(function(){
	
	
	if(jQuery('#last_tab').val() == ''){

		jQuery('.mocha-opts-group-tab:first').slideDown('fast');
		jQuery('#mocha-opts-group-menu li:first').addClass('active');
	
	}else{
		
		tabid = jQuery('#last_tab').val();
		jQuery('#'+tabid+'_section_group').slideDown('fast');
		jQuery('#'+tabid+'_section_group_li').addClass('active');
		
	}
	
	
	jQuery('input[name="'+mocha_opts.opt_name+'[defaults]"]').click(function(){
		if(!confirm(mocha_opts.reset_confirm)){
			return false;
		}
	});
	
	jQuery('.mocha-opts-group-tab-link-a').click(function(){
		relid = jQuery(this).attr('data-rel');
		
		jQuery('#last_tab').val(relid);
		
		jQuery('.mocha-opts-group-tab').each(function(){
			if(jQuery(this).attr('id') == relid+'_section_group'){
				jQuery(this).show();
			}else{
				jQuery(this).hide();
			}
			
		});
		
		jQuery('.mocha-opts-group-tab-link-li').each(function(){
				if(jQuery(this).attr('id') != relid+'_section_group_li' && jQuery(this).hasClass('active')){
					jQuery(this).removeClass('active');
				}
				if(jQuery(this).attr('id') == relid+'_section_group_li'){
					jQuery(this).addClass('active');
				}
		});
	});
	
	
	
	
	if(jQuery('#mocha-opts-save').is(':visible')){
		jQuery('#mocha-opts-save').delay(4000).slideUp('slow');
	}
	
	if(jQuery('#mocha-opts-imported').is(':visible')){
		jQuery('#mocha-opts-imported').delay(4000).slideUp('slow');
	}	
	
	jQuery('input, textarea, select').change(function(){
		jQuery('#mocha-opts-save-warn').slideDown('slow');
	});
	
	
	jQuery('#mocha-opts-import-code-button').click(function(){
		if(jQuery('#mocha-opts-import-link-wrapper').is(':visible')){
			jQuery('#mocha-opts-import-link-wrapper').fadeOut('fast');
			jQuery('#import-link-value').val('');
		}
		jQuery('#mocha-opts-import-code-wrapper').fadeIn('slow');
	});
	
	jQuery('#mocha-opts-import-link-button').click(function(){
		if(jQuery('#mocha-opts-import-code-wrapper').is(':visible')){
			jQuery('#mocha-opts-import-code-wrapper').fadeOut('fast');
			jQuery('#import-code-value').val('');
		}
		jQuery('#mocha-opts-import-link-wrapper').fadeIn('slow');
	});
	
	
	
	
	jQuery('#mocha-opts-export-code-copy').click(function(){
		if(jQuery('#mocha-opts-export-link-value').is(':visible')){jQuery('#mocha-opts-export-link-value').fadeOut('slow');}
		jQuery('#mocha-opts-export-code').toggle('fade');
	});
	
	jQuery('#mocha-opts-export-link').click(function(){
		if(jQuery('#mocha-opts-export-code').is(':visible')){jQuery('#mocha-opts-export-code').fadeOut('slow');}
		jQuery('#mocha-opts-export-link-value').toggle('fade');
	});
	
	

	
	
	
});