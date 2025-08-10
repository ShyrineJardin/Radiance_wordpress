<?php

namespace AiosInitialSetup\Resources\Template;

class ContentTemplate
{
    public static function render()
    {
        $contact_options = get_option('contact_options', []);
        $image_src = isset($contact_options['agent_team_photo']) ? wp_get_attachment_image_url($contact_options['agent_team_photo'], 'full') : 'https://resources.agentimage.com/images/legacy-agent-photo.jpg';

        $title = isset($contact_options['title']) ? "<div class=\"aios-cu-title\"><strong>" . wp_unslash($contact_options['title']) . "</strong></div>" : "";

		// Contact Information
		$contact = client_info_values("phone", "<span>
			[ai_phone unwrap_em=true href=\"{href-phone}\"]<em class=\"ai-font-phone-alt\"></em> {default-phone}[/ai_phone]
		</span>") . client_info_values("cell", "<span>
			[ai_phone unwrap_em=true href=\"{href-phone}\"]<em class=\"ai-font-cellphone\"></em> {default-phone}[/ai_phone]
		</span>") . client_info_values("fax", "<span>
			[ai_phone unwrap_em=true href=\"{href-fax}\"]<em class=\"ai-font-fax\"></em> {default-phone}[/ai_phone]
		</span>") . client_info_values("email", "<span>
			[mail_to email=\"{default-email}\"]<em class=\"ai-font-envelope-f\"></em> {default-email}[/mail_to]
		</span>") . client_info_values("address", "<span>
			<em class=\"ai-font-location-c\"></em> {" . (isset($contact_options['address-display']) && $contact_options['address-display'] === "compact" ? "default-compact-address" : "default-full-address") . "}
		</span>");

		if (! empty($contact)) {
			$contact = "<div class=\"aios-cu-contact\">
				<p>$contact</p>
			</div>";
		}

		// SMW
		$smi = client_info_values("facebook", "<a href=\"{smi-link}\" target=\"_blank\" rel=\"noopener noreferrer\"><em class=\"ai-font-facebook\"></em><span class=\"hidden\">facebook</span></a>");
		$smi .= client_info_values("twitter", "<a href=\"{smi-link}\" target=\"_blank\" rel=\"noopener noreferrer\"><em class=\"ai-font-twitter\"></em><span class=\"hidden\">X</span></a>");
		$smi .= client_info_values("linkedin", "<a href=\"{smi-link}\" target=\"_blank\" rel=\"noopener noreferrer\"><em class=\"ai-font-linkedin\"></em><span class=\"hidden\">linkedin</span></a>");
		$smi .= client_info_values("youtube", "<a href=\"{smi-link}\" target=\"_blank\" rel=\"noopener noreferrer\"><em class=\"ai-font-youtube\"></em><span class=\"hidden\">youtube</span></a>");
		$smi .= client_info_values("instagram", "<a href=\"{smi-link}\" target=\"_blank\" rel=\"noopener noreferrer\"><em class=\"ai-font-instagram\"></em><span class=\"hidden\">instagram</span></a>");
		$smi .= client_info_values("pinterest", "<a href=\"{smi-link}\" target=\"_blank\" rel=\"noopener noreferrer\"><em class=\"ai-font-pinterest\"></em><span class=\"hidden\">pinterest</span></a>");
		$smi .= client_info_values("trulia", "<a href=\"{smi-link}\" target=\"_blank\" rel=\"noopener noreferrer\"><em class=\"ai-font-trulia\"></em><span class=\"hidden\">trulia</span></a>");
		$smi .= client_info_values("zillow", "<a href=\"{smi-link}\" target=\"_blank\" rel=\"noopener noreferrer\"><em class=\"ai-font-zillow\"></em><span class=\"hidden\">zillow</span></a>");
		$smi .= client_info_values("houzz", "<a href=\"{smi-link}\" target=\"_blank\" rel=\"noopener noreferrer\"><em class=\"ai-font-houzz\"></em><span class=\"hidden\">houzz</span></a>");
		$smi .= client_info_values("blogger", "<a href=\"{smi-link}\" target=\"_blank\" rel=\"noopener noreferrer\"><em class=\"ai-font-blogger\"></em><span class=\"hidden\">blogger</span></a>");
		$smi .= client_info_values("yelp", "<a href=\"{smi-link}\" target=\"_blank\" rel=\"noopener noreferrer\"><em class=\"ai-font-yelp\"></em><span class=\"hidden\">yelp</span></a>");
		$smi .= client_info_values("skype", "<a href=\"{smi-link}\" target=\"_blank\" rel=\"noopener noreferrer\"><em class=\"ai-font-skype\"></em><span class=\"hidden\">skype</span></a>");
		$smi .= client_info_values("caimeiju", "<a href=\"{smi-link}\" target=\"_blank\" rel=\"noopener noreferrer\"><em class=\"ai-font-caimeiju\"></em><span class=\"hidden\">caimeiju</span></a>");
		$smi .= client_info_values("rss", "<a href=\"{smi-link}\" target=\"_blank\" rel=\"noopener noreferrer\"><em class=\"ai-font-rss\"></em><span class=\"hidden\">rss</span></a>");
		$smi .= client_info_values("cameo", "<a href=\"{smi-link}\" target=\"_blank\" rel=\"noopener noreferrer\"><em class=\"ai-font-cameo\"></em><span class=\"hidden\">cameo</span></a>");
		$smi .= client_info_values("tiktok", "<a href=\"{smi-link}\" target=\"_blank\" rel=\"noopener noreferrer\"><em class=\"ai-font-tiktok\"></em><span class=\"hidden\">tiktok</span></a>");

		if (!empty($smi)) {
			$smi = "<div class=\"aios-cu-smi\" data-aos=\"fade-up\" data-aos-delay=\"600\" data-aos-once=\"true\">$smi</div>";
		}
		
        // Contact Form
        $form_title = get_option('contact-theme-form-title', '');
        $form = ! empty(get_option('contact-theme-form', '')) ? "<div class=\"aios-cu-form\" data-aos=\"fade-up\" data-aos-delay=\"0\" data-aos-once=\"true\">
			$form_title
			[contact-form-7 id=\"" . get_option('contact-theme-form', '') . "\" html_class=\"use-floating-validation-tip  custom-page-cf\"]
		</div>" : "";

        $iframe_map = isset($contact_options['iframe_map']) ? "<div class=\"col-md-12\">
		<div class=\"aios-cu-bottom\">
			<div class=\"aios-cu-map\" data-aos=\"fade-up\" data-aos-delay=\"0\" data-aos-once=\"true\">
				<iframe src=\"" . $contact_options['iframe_map'] . "\" width=\"600\" height=\"383\" frameborder=\"0\" style=\"border:0;\" allowfullscreen=\"\" title=\"Map Embed Link\" aria-hidden=\"false\" tabindex=\"0\"></iframe>
			</div>
		</div>
	</div>" : "";

        return do_shortcode("<div class=\"row aios-cu-inner\">
	<div class=\"col-md-6\">
		<div class=\"aios-cu-left\">
			<div class=\"aios-cu-main\">
				<div class=\"aios-cu-info\" data-aos=\"fade-up\" data-aos-delay=\"0\" data-aos-once=\"true\">
					<h2 class=\"aios-cu-title\">$title</h2>
					$contact
				</div>
				$smi
				$form
			</div>
		</div>
	</div>
	<div class=\"col-md-6\">
		<div class=\"aios-cu-right\">
			<div class=\"aios-cu-img\" data-aos=\"fade-up\" data-aos-delay=\"0\" data-aos-once=\"true\">
				<img src=\"$image_src\" alt=\"" . get_the_title() . "\" class=\"img-responsive\">
			</div>
		</div>
	</div>
	$iframe_map
</div>");
    }
}
