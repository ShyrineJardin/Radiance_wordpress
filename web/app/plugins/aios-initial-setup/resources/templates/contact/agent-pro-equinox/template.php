<?php

namespace AiosInitialSetup\Resources\Template;

class ContentTemplate
{
    public static function render()
    {
        $contact_options = get_option('contact_options', []);

		
        $image_src = isset($contact_options['agent_team_photo']) ? wp_get_attachment_image_url($contact_options['agent_team_photo'], 'full') : 'https://resources.agentimage.com/images/equinox-contact-agent-photo.jpg';
		$image_meta = isset($contact_options['agent_team_photo']) ? wp_get_attachment_metadata($contact_options['agent_team_photo']) : '';
		$image_width = isset($image_meta['width']) ? 'width="'.$image_meta['width'].'"' : '';
		$image_height = isset($image_meta['height']) ? 'height="'.$image_meta['height'].'"' : '';


        $title = isset($contact_options['title']) ? $contact_options['title'] : "Send me a <br> Message";




        $form = ! empty(get_option('contact-theme-form', '')) ? "[contact-form-7 id=\"" . get_option('contact-theme-form', '') . "\" html_class=\"custom-page-cf\"]" : "";


        return do_shortcode('
			<div class="ip-equinox-contact__container site-container">

				<div class="ip-equinox-contact__form">
					<div class="ip-equinox-contact__form--title">
						<h2>
							<strong>'.$title.'</strong>
						</h2>
					</div><!-- end of site heading -->
					<div class="ip-equinox-contact__fields">
						<div class="ip-equinox-contact__field">
							'.$form.'
						</div>
					</div>
				</div>
				<div class="ip-equinox-contact__image">
					<img src="'.$image_src.'" '.$image_width.' '.$image_height.' alt="'.strip_tags($title).'">
				</div>

			</div>
		');
    }
}
