<?php

namespace AiosInitialSetup\Resources\Template;

class ContentTemplate
{
    public static function render()
    {
        $about_options = get_option('about_options', []);
        $image_src = isset($about_options['agent_team_photo']) ? wp_get_attachment_image_url($about_options['agent_team_photo'], 'full') : 'https://resources.agentimage.com/images/iconic-agent-photo.jpg';
        $title = isset($about_options['title']) ? wp_unslash($about_options['title']) : "";
        $content = wpautop( isset($about_options['content']) ? wp_unslash($about_options['content']) : "" );

        $form_title = get_option('about-theme-form-title', '');
		$form = ! empty(get_option('about-theme-form', '')) ? "<div class=\"aios-about-form\" data-aos=\"fade-left\" data-aos-delay=\"400\" data-aos-once=\"true\">
			$form_title
			[contact-form-7 id=\"" . get_option('about-theme-form') . "\" html_class=\"use-floating-validation-tip custom-page-cf\"]
		</div>" : "";

        return do_shortcode("<div class=\"row aios-about-inner\">
	<div class=\"col-md-12\">
			<div class=\"aios-about-right\" data-aos=\"fade-up\" data-aos-delay=\"0\" data-aos-once=\"true\">
					<img src=\"$image_src\" alt=\"" . get_the_title() . "\" class=\"img-responsive\">
			</div>
			<div class=\"aios-about-main\">
				<div class=\"aios-about-title\" data-aos=\"fade-up\" data-aos-delay=\"0\" data-aos-once=\"true\">
					<strong>$title</strong>
				</div>
				<div class=\"aios-about-content\" data-aos=\"fade-up\" data-aos-delay=\"100\" data-aos-once=\"true\">
					$content

					$form
				</div>
			</div>

	</div>

</div>");
    }
}
