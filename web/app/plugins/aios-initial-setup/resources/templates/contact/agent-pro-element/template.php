<?php

namespace AiosInitialSetup\Resources\Template;

class ContentTemplate
{
    public static function render()
    {
        $contact_options = get_option('contact_options', []);
        $image_src = isset($contact_options['agent_team_photo']) ? wp_get_attachment_image_url($contact_options['agent_team_photo'], 'full') : 'https://resources.agentimage.com/images/element-contact-bg.jpg';

        $title = isset($contact_options['title']) ? "<div class=\"aios-contact-title\" data-aos=\"fade-up\" data-aos-delay=\"0\" data-aos-once=\"true\">
			<strong>" . wp_unslash($contact_options['title']) . "</strong>
		</div>" : "";

		// Contact Information
		$contact = "";
		
		$contact .= client_info_values("phone", "<li>
			[ai_phone unwrap_em=true href=\"{href-phone}\"]<i class=\"ai-font-phone-alt phone\"></i> {default-phone}[/ai_phone]
		</li>");
		
		$contact .= client_info_values("cell", "<li>
			[ai_phone unwrap_em=true href=\"{href-phone}\"]<i class=\"ai-font-cellphone\"></i> {default-phone}[/ai_phone]
		</li>");
		
		$contact .= client_info_values("fax", "<li>
			[ai_phone unwrap_em=true href=\"{href-phone}\"]<i class=\"ai-font-fax\"></i> {default-phone}[/ai_phone]
		</li>");

		$contact .= client_info_values("email", "<li>
			[mail_to email=\"{default-email}\"]<i class=\"ai-font-envelope envelope\"></i> {default-email}[/mail_to]
		</li>");
		
        $contact .= client_info_values("address", "<li class=\"aios-contact-address\">
			<i class=\"ai-font-location-c location\" aria-hidden=\"true\"></i>
			<p>{" . (isset($contact_options['address-display']) && $contact_options['address-display'] === "compact" ? "default-compact-address" : "default-full-address") . "}</p>
		</li>");

		if (! empty($contact)) {
			$contact = "<div class=\"aios-contact-info\" data-aos=\"fade-up\" data-aos-delay=\"200\" data-aos-once=\"true\"><ul>$contact</ul></div>";
		}

		$smi = client_info_values("facebook", "<li><a href=\"{smi-link}\" target=\"_blank\" rel=\"noopener noreferrer\" class=\"ai-font-facebook\"><span class=\"hidden\">facebook</span></a></li>");
		$smi .= client_info_values("twitter", "<li><a href=\"{smi-link}\" target=\"_blank\" rel=\"noopener noreferrer\" class=\"ai-font-twitter\"><span class=\"hidden\">X</span></a></li>");
		$smi .= client_info_values("linkedin", "<li><a href=\"{smi-link}\" target=\"_blank\" rel=\"noopener noreferrer\" class=\"ai-font-linkedin\"><span class=\"hidden\">linkedin</span></a></li>");
		$smi .= client_info_values("youtube", "<li><a href=\"{smi-link}\" target=\"_blank\" rel=\"noopener noreferrer\" class=\"ai-font-youtube\"><span class=\"hidden\">youtube</span></a></li>");
		$smi .= client_info_values("instagram", "<li><a href=\"{smi-link}\" target=\"_blank\" rel=\"noopener noreferrer\" class=\"ai-font-instagram\"><span class=\"hidden\">instagram</span></a></li>");
		$smi .= client_info_values("pinterest", "<li><a href=\"{smi-link}\" target=\"_blank\" rel=\"noopener noreferrer\" class=\"ai-font-pinterest\"><span class=\"hidden\">pinterest</span></a></li>");
		$smi .= client_info_values("trulia", "<li><a href=\"{smi-link}\" target=\"_blank\" rel=\"noopener noreferrer\" class=\"ai-font-trulia\"><span class=\"hidden\">trulia</span></a></li>");
		$smi .= client_info_values("zillow", "<li><a href=\"{smi-link}\" target=\"_blank\" rel=\"noopener noreferrer\" class=\"ai-font-zillow\"><span class=\"hidden\">zillow</span></a></li>");
		$smi .= client_info_values("houzz", "<li><a href=\"{smi-link}\" target=\"_blank\" rel=\"noopener noreferrer\" class=\"ai-font-houzz\"><span class=\"hidden\">houzz</span></a></li>");
		$smi .= client_info_values("blogger", "<li><a href=\"{smi-link}\" target=\"_blank\" rel=\"noopener noreferrer\" class=\"ai-font-blogger\"><span class=\"hidden\">blogger</span></a></li>");
		$smi .= client_info_values("yelp", "<li><a href=\"{smi-link}\" target=\"_blank\" rel=\"noopener noreferrer\" class=\"ai-font-yelp\"><span class=\"hidden\">yelp</span></a></li>");
		$smi .= client_info_values("skype", "<li><a href=\"{smi-link}\" target=\"_blank\" rel=\"noopener noreferrer\" class=\"ai-font-skype\"><span class=\"hidden\">skype</span></a></li>");
		$smi .= client_info_values("caimeiju", "<li><a href=\"{smi-link}\" target=\"_blank\" rel=\"noopener noreferrer\" class=\"ai-font-caimeiju\"><span class=\"hidden\">caimeiju</span></a></li>");
		$smi .= client_info_values("rss", "<li><a href=\"{smi-link}\" target=\"_blank\" rel=\"noopener noreferrer\" class=\"ai-font-rss\"><span class=\"hidden\">rss</span></a></li>");
		$smi .= client_info_values("cameo", "<li><a href=\"{smi-link}\" target=\"_blank\" rel=\"noopener noreferrer\" class=\"ai-font-cameo\"><span class=\"hidden\">cameo</span></a></li>");
		$smi .= client_info_values("tiktok", "<li><a href=\"{smi-link}\" target=\"_blank\" rel=\"noopener noreferrer\" class=\"ai-font-tiktok\"><span class=\"hidden\">tiktok</span></a></li>");

		if (!empty($smi)) {
			$smi = "<div class=\"aios-contact-smi\" data-aos=\"fade-up\" data-aos-delay=\"400\" data-aos-once=\"true\">
				<ul>
					$smi
				</ul>
			</div>";
		}

        // Contact Form
        $form_title = get_option('contact-theme-form-title', '');
        $form = ! empty(get_option('contact-theme-form', '')) ? "<div class=\"aios-contact-form\" data-aos=\"fade-up\" data-aos-delay=\"600\" data-aos-once=\"true\">
			<div class=\"aios-contact-form-inner\">
				<div class=\"aios-contact-form-title\">$form_title</div>
				[contact-form-7 id=\"" . get_option('contact-theme-form') . "\" html_class=\"use-floating-validation-tip custom-page-cf\"]
			</div>
		</div>" : "";

		// Iframe
        $iframe_map = isset($contact_options['iframe_map']) ? "<div class=\"aios-contact-map\" data-aos=\"fade-up\" data-aos-delay=\"800\" data-aos-once=\"true\">
			<iframe src=\"" . $contact_options['iframe_map'] . "\" width=\"1600\" height=\"518\" frameborder=\"0\" style=\"border:0;\" allowfullscreen=\"\" title=\"Map Embed Link\" aria-hidden=\"false\" tabindex=\"0\"></iframe>
		</div>" : "";

        return do_shortcode("<div class=\"aios-contact-wrap\">
	<div class=\"aios-contact-inner\">
		<div class=\"aios-contact-main\">
			<div class=\"aios-contact-main-bg\" style=\"background-image: url($image_src)\"></div>
			$title
			$contact
			$smi
			$form
		</div>
		$iframe_map
	</div>
</div>");
    }
}
