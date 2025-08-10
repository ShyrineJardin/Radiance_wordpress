<?php

namespace AiosInitialSetup\Resources\Template;

class ContentTemplate
{
    public static function render()
    {
        $about_options = get_option('about_options', []);
        $image_src = isset($about_options['agent_team_photo']) ? wp_get_attachment_image_url($about_options['agent_team_photo'], 'full') : 'https://resources.agentimage.com/images/iconic-agent-photo.jpg';
        $add_meet = isset($about_options['add_meet']) ? $about_options['add_meet'] : "";
		$add_meet = $add_meet === "1" ? "<small>Meet</small>" : '';
        $title = isset($about_options['title']) ? wp_unslash($about_options['title'])  : "";
        $content = wpautop( isset($about_options['content']) ? wp_unslash($about_options['content']): "" );

        return do_shortcode("<div class=\"aios-about-wrap\">
	<div class=\"aios-about-inner\">

		<div class=\"aios-about-img\" data-aos=\"fade-right\" data-aos-delay=\"0\" data-aos-once=\"true\">
			<img src=\"$image_src\" alt=\"" . get_the_title() . "\">
		</div>

		<div class=\"aios-about-main\" data-aos=\"fade-left\" data-aos-delay=\"0\" data-aos-once=\"true\">
			<div class=\"global-title aios-about-title\">
				$add_meet<strong>$title</strong>
			</div>
			<div class=\"aios-about-content\">
				$content
			</div>
		</div>
	</div>
</div>");
    }
}
