<?php

namespace AiosInitialSetup\Resources\Template;

class ContentTemplate
{
    public static function render()
    {
        $about_options = get_option('about_options', []);


        $image_src = isset($about_options['agent_team_photo']) ? wp_get_attachment_image_url($about_options['agent_team_photo'], 'full') : 'https://resources.agentimage.com/images/equinox-agent-photo.jpg';
		$image_meta = isset($about_options['agent_team_photo']) ? wp_get_attachment_metadata($about_options['agent_team_photo']) : '';
		$image_width = isset($image_meta['width']) ? 'width="'.$image_meta['width'].'"' : '';
		$image_height = isset($image_meta['height']) ? 'height="'.$image_meta['height'].'"' : '';

		$image_overlay = isset($about_options['about_overlay_photo']) ? wp_get_attachment_image_url($about_options['about_overlay_photo'], 'full') : 'https://resources.agentimage.com/images/equinox-about-overlay.jpg';
		$sticy_distance = isset($about_options['sticky_distance']) ? $about_options['sticky_distance'] : '160';


        $title = isset($about_options['title']) ? wp_unslash($about_options['title']) : "";
        $subtitle = isset($about_options['subtitle']) ? wp_unslash($about_options['subtitle']) : "";
        $content = wpautop( isset($about_options['content']) ? wp_unslash($about_options['content']) : "" );

        return do_shortcode('
			<div class="ip-equinox-about__container site-container" data-sticky-container>
				<div class="ip-equinox-about__photo">
					<div class="ip-equinox-about__photo--wrap" data-margin-top="'.$sticy_distance.'" data-sticky-for="1023" data-sticky-class="is-sticky">
						<div class="ip-equinox-about__photo--overlay" style="background-image: url('.$image_overlay.')"></div>
						<img src="'.$image_src.'" alt="'.strip_tags($title).'" '.$image_width.' '.$image_height.'>
					</div>
				</div>

				<div class="ip-equinox-about__content">
					<div class="about__title">
						<h2>
							<strong>'.$title.'</strong>
							<small>'.$subtitle.'</small>
						</h2>
					</div><!-- end of site heading -->
					'.$content.'
				</div>
			</div>

		');
    }
}
