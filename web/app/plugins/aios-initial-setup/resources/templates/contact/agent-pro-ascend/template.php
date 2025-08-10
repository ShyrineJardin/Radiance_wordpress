<?php

namespace AiosInitialSetup\Resources\Template;

class ContentTemplate
{
    public static function render()
    {
        $contact_options = get_option('contact_options', []);

		
        $image_src = isset($contact_options['agent_team_photo']) ? wp_get_attachment_image_url($contact_options['agent_team_photo'], 'full') : 'https://resources.agentimage.com/images/ascend-form-background.jpg';
		$image_meta = isset($contact_options['agent_team_photo']) ? wp_get_attachment_metadata($contact_options['agent_team_photo']) : '';
		$image_width = isset($image_meta['width']) ? 'width="'.$image_meta['width'].'"' : '';
		$image_height = isset($image_meta['height']) ? 'height="'.$image_meta['height'].'"' : '';


        $title = isset($contact_options['title']) ? $contact_options['title'] : "Send us <br>a message";




        $form = ! empty(get_option('contact-theme-form', '')) ? "[contact-form-7 id=\"" . get_option('contact-theme-form', '') . "\" html_class=\"custom-page-cf\"]" : "";


        return do_shortcode('
			<div class="ipcontactus_ascend">
				<img src="'.$image_src.'" '.$image_width.' '.$image_height.' alt="Contact Us"  class="ipcontactus_ascend__background"/>

				<div class="ipcontactus_ascend__container flex-column">
					<h2 class="heading-1">'.$title.'</h2>
					<div class="ipcontactus_ascend__form">
					'.$form.'
					</div>
				</div>
			</div>			
		');
    }
}
