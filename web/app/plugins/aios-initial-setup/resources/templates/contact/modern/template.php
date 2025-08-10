<?php

namespace AiosInitialSetup\Resources\Template;

class ContentTemplate
{
    public static function render()
    {
        $contact_options = get_option('contact_options', []);
        $image_src = isset($contact_options['agent_team_photo']) ? wp_get_attachment_image_url($contact_options['agent_team_photo'], 'full') : 'https://resources.agentimage.com/images/generate-pages/about-modern-agent.jpg';

        $title = isset($contact_options['title']) ? "<h2 class=\"ai-modern-contact-title\" data-aos=\"fade-up\" data-aos-delay=\"200\">" . wp_unslash($contact_options['title']) . "</h2>" : "";

		// Phone Email
		$contact = client_info_values("phone", "<li>
            <span class=\"ai-font-phone-alt phone\"></span>
            [ai_phone unwrap_em=true href=\"{href-phone}\"]{default-phone}[/ai_phone]
		</li>") . client_info_values("cell", "<li>
            <span class=\"ai-font-cellphone phone\"></span>
            [ai_phone unwrap_em=true href=\"{href-phone}\"]{default-phone}[/ai_phone]
        </li>") . client_info_values("fax", "<li>
            <span class=\"ai-font-fax phone\"></span>
            [ai_phone unwrap_em=true href=\"{href-phone}\"]{default-phone}[/ai_phone]
        </li>") . client_info_values("email", "<li>
            <span class=\"ai-font-envelope envelope\"></span>
            [mail_to email=\"{default-email}\"]{default-email}[/mail_to]
        </li>") . client_info_values("address", "<li>
            <span class=\"ai-font-location-c pin\"></span>
            <p>{" . (isset($contact_options['address-display']) && $contact_options['address-display'] === "compact" ? "default-compact-address" : "default-full-address") . "}</p>
        </li>");

		if (! empty($contact)) {
			$contact = "<ul class=\"ai-modern-contact-info\" data-aos=\"fade-up\" data-aos-delay=\"200\">$contact</ul>";
		}
		
        // Contact Form
        $form_title = get_option('contact-theme-form-title', '');
        $form = ! empty(get_option('contact-theme-form', '')) ? "<div class=\"ai-modern-contact-form\" data-aos=\"fade-up\" data-aos-delay=\"400\">
            <div class=\"ai-modern-contact-form-container\">
                $form_title
                [contact-form-7 id=\"" . get_option('contact-theme-form', '') . "\" html_class=\"use-floating-validation-tip custom-page-cf\"]
            </div>
        </div>" : "";

        $iframe_map = isset($contact_options['iframe_map']) ? "<div class=\"ai-modern-contact-map\" data-aos=\"fade-up\">
    <iframe src=\"" . $contact_options['iframe_map'] . "\" width=\"1450\" height=\"480\" frameborder=\"0\" style=\"border:0;\" allowfullscreen=\"\"  title=\"Map Embed Link\" aria-hidden=\"false\" tabindex=\"0\"></iframe>
</div>" : "";

        return do_shortcode("<div class=\"ai-modern-contact-entry\">
    <div class=\"container\">
        <div class=\"ai-modern-contact-entry-inner\">
            <div class=\"ai-modern-contact-photo\" data-aos=\"fade-right\">
                <span>
                    <canvas width=\"550\" height=\"670\" style=\"background-image: url($image_src);\"></canvas>
                </span>
            </div>
            <div class=\"ai-modern-contact-main\">
                $title
                $contact
                $form
            </div>
        </div>
    </div>
</div>
$iframe_map");
    }
}
