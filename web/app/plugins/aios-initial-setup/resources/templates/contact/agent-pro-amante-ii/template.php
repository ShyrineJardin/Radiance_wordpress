<?php

namespace AiosInitialSetup\Resources\Template;

class ContentTemplate
{
    public static function render()
    {
        $contact_options = get_option('contact_options', []);
        $image_src = isset($contact_options['agent_team_photo']) ? wp_get_attachment_image_url($contact_options['agent_team_photo'], 'full') : 'https://resources.agentimage.com/images/generate-pages/about-amante-ii-agent.jpg';

        $title = isset($contact_options['title']) ? "<h2 class=\"aios-contact-title\" data-aos=\"fade-up\" data-aos-delay=\"100\" data-aos-once=\"true\">" . wp_unslash($contact_options['title']) . "</h2>" : "";
        $subtitle = isset($contact_options['subtitle']) ? "<p data-aos=\"fade-up\" data-aos-delay=\"200\" data-aos-once=\"true\">" . wp_unslash($contact_options['subtitle']) . "</p>" : "";

        // Contact Form
        $form_title = get_option('contact-theme-form-title', '');
        $form = ! empty(get_option('contact-theme-form', '')) ? "<div data-aos=\"fade-up\" data-aos-delay=\"400\" data-aos-once=\"true\">
		$form_title
    [contact-form-7 id=\"" . get_option('contact-theme-form') . "\" html_class=\"use-floating-validation-tip custom-page-cf\"]
</div>" : "";

        $iframe_map = isset($contact_options['iframe_map']) ? "<div class=\"aios-contact-map\" data-aos=\"fade-up\" data-aos-delay=\"0\" data-aos-once=\"true\">
		<iframe src=\"" . $contact_options['iframe_map'] . "\" width=\"1600\" height=\"590\" frameborder=\"0\" style=\"border:0;\" allowfullscreen=\"\" title=\"Map Embed Link\"></iframe>
	</div>" : "";

        return do_shortcode("<div class=\"aios-contact-us\">
	<div class=\"aios-contact-form\" data-aos=\"fade-up\" data-aos-delay=\"0\" data-aos-once=\"true\">
		<div class=\"aios-contact-form-inner\">
			$title
			$subtitle
			$form
		</div>
	</div>
	<div class=\"aios-contact-photo\" data-aos=\"fade-up\" data-aos-delay=\"0\" data-aos-once=\"true\">
		<img src=\"$image_src\" alt=\"" . get_the_title() . "\">
	</div>
	$iframe_map
</div>");
    }
}
