<?php

namespace AiosInitialSetup\Resources\Template;

class ContentTemplate
{
    public static function render()
    {
        $contact_options = get_option('contact_options', []);
        $image_src = isset($contact_options['agent_team_photo']) ? wp_get_attachment_image_url($contact_options['agent_team_photo'], 'full') : 'https://resources.agentimage.com/images/generate-pages/contact-amante-ii-agent.jpg';

        $title = isset($contact_options['title']) ? "<h2 class=\"aios-contact-title\" data-aos=\"fade-up\" data-aos-delay=\"100\" data-aos-once=\"true\">" . wp_unslash($contact_options['title']) . "</h2>" : "";

		// Address
		$name = client_info_values("name", "Sold by {name}<br />");
        $address = client_info_values("address", "<div class=\"contact-address\" data-aos=\"fade-in\" data-aos-delay=\"200\" data-aos-once=\"true\">
			<span>
				<em class=\"ai-font-location-c location\"></em>
				<p>
					$name
					{" . (isset($contact_options['address-display']) && $contact_options['address-display'] === "compact" ? "default-compact-address" : "default-full-address") . "}
				</p>
			</span>
		</div>");

		// Phone Email
        $phone_email = client_info_values("phone", "<span>
				[ai_phone unwrap_em=true href=\"{href-phone}\"]<em class=\"ai-font-phone\"></em> {default-phone}[/ai_phone]
			</span>") . client_info_values("cell", "<span>
				[ai_phone unwrap_em=true href=\"{href-phone}\"]<em class=\"ai-font-cellphone\"></em> {default-phone}[/ai_phone]
			</span>") . client_info_values("fax", "<span>
				[ai_phone unwrap_em=true href=\"{href-phone}\"]<em class=\"ai-font-fax\"></em> {default-phone}[/ai_phone]
			</span>") . client_info_values("email", "<span>
			[mail_to email=\"{default-email}\"]<em class=\"ai-font-envelope\"></em> {default-email}[/mail_to]
		</span>");

		if (! empty($phone_email)) {
			$phone_email = "<div class=\"contact-phone-email\" data-aos=\"fade-in\" data-aos-delay=\"400\" data-aos-once=\"true\">
				$phone_email
			</div>";
		}
		
        $smi = client_info_values("facebook", "<a href=\"{smi-link}\" target=\"_blank\" rel=\"noopener noreferrer\"><i class=\"ai-font-facebook\"></i><span class=\"hidden\">facebook</span></a>");
		$smi .= client_info_values("twitter", "<a href=\"{smi-link}\" target=\"_blank\" rel=\"noopener noreferrer\"><i class=\"ai-font-twitter\"></i><span class=\"hidden\">X</span></a>");
		$smi .= client_info_values("linkedin", "<a href=\"{smi-link}\" target=\"_blank\" rel=\"noopener noreferrer\"><i class=\"ai-font-linkedin\"></i><span class=\"hidden\">linkedin</span></a>");
		$smi .= client_info_values("youtube", "<a href=\"{smi-link}\" target=\"_blank\" rel=\"noopener noreferrer\"><i class=\"ai-font-youtube\"></i><span class=\"hidden\">youtube</span></a>");
		$smi .= client_info_values("instagram", "<a href=\"{smi-link}\" target=\"_blank\" rel=\"noopener noreferrer\"><i class=\"ai-font-instagram\"></i><span class=\"hidden\">instagram</span></a>");
		$smi .= client_info_values("pinterest", "<a href=\"{smi-link}\" target=\"_blank\" rel=\"noopener noreferrer\"><i class=\"ai-font-pinterest\"></i><span class=\"hidden\">pinterest</span></a>");
		$smi .= client_info_values("trulia", "<a href=\"{smi-link}\" target=\"_blank\" rel=\"noopener noreferrer\"><i class=\"ai-font-trulia\"></i><span class=\"hidden\">trulia</span></a>");
		$smi .= client_info_values("zillow", "<a href=\"{smi-link}\" target=\"_blank\" rel=\"noopener noreferrer\"><i class=\"ai-font-zillow\"></i><span class=\"hidden\">zillow</span></a>");
		$smi .= client_info_values("houzz", "<a href=\"{smi-link}\" target=\"_blank\" rel=\"noopener noreferrer\"><i class=\"ai-font-houzz\"></i><span class=\"hidden\">houzz</span></a>");
		$smi .= client_info_values("blogger", "<a href=\"{smi-link}\" target=\"_blank\" rel=\"noopener noreferrer\"><i class=\"ai-font-blogger\"></i><span class=\"hidden\">blogger</span></a>");
		$smi .= client_info_values("yelp", "<a href=\"{smi-link}\" target=\"_blank\" rel=\"noopener noreferrer\"><i class=\"ai-font-yelp\"></i><span class=\"hidden\">yelp</span></a>");
		$smi .= client_info_values("skype", "<a href=\"{smi-link}\" target=\"_blank\" rel=\"noopener noreferrer\"><i class=\"ai-font-skype\"></i><span class=\"hidden\">skype</span></a>");
		$smi .= client_info_values("caimeiju", "<a href=\"{smi-link}\" target=\"_blank\" rel=\"noopener noreferrer\"><i class=\"ai-font-caimeiju\"></i><span class=\"hidden\">caimeiju</span></a>");
		$smi .= client_info_values("rss", "<a href=\"{smi-link}\" target=\"_blank\" rel=\"noopener noreferrer\"><i class=\"ai-font-rss\"></i><span class=\"hidden\">rss</span></a>");
		$smi .= client_info_values("cameo", "<a href=\"{smi-link}\" target=\"_blank\" rel=\"noopener noreferrer\"><i class=\"ai-font-cameo\"></i><span class=\"hidden\">cameo</span></a>");
		$smi .= client_info_values("tiktok", "<a href=\"{smi-link}\" target=\"_blank\" rel=\"noopener noreferrer\"><i class=\"ai-font-tiktok\"></i><span class=\"hidden\">tiktok</span></a>");

		if (!empty($smi)) {
			$smi = "<div class=\"aios-contact-smis\" data-aos=\"fade-in\" data-aos-delay=\"600\" data-aos-once=\"true\">$smi</div>";
		}

        // Contact Form
        $form_title = get_option('contact-theme-form-title', '');
        $form = ! empty(get_option('contact-theme-form', '')) ? "<div class=\"aios-contact-form\" data-aos=\"fade-in\" data-aos-delay=\"0\" data-aos-once=\"true\">
				<div class=\"aios-contact-form-title\">$form_title</div>
				[contact-form-7 id=\"" . get_option('contact-theme-form') . "\" html_class=\"use-floating-validation-tip  custom-page-cf\"]
			</div>" : "";

			
        // Call to Action
        $cta = "";
        
        if (isset($contact_options['cta_1_title']) && ! empty($contact_options['cta_1_title'])) {
            $cta_title = isset($contact_options['cta_1_title']) && ! empty($contact_options['cta_1_title']) ? "<h3>" . wp_unslash($contact_options['cta_1_title']) . "</h3>" : "" ;
            $cta_url = isset($contact_options['cta_1_url']) && ! empty($contact_options['cta_1_url']) ? $contact_options['cta_1_url'] : "" ;
            
            $cta .= "<div data-aos=\"fade-right\" data-aos-delay=\"0\" data-aos-once=\"true\">
			<a href=\"$cta_url\" class=\"aios-site-button\"><span>$cta_title</span> <i class=\"ai-font-arrow-h-n\"></i></a>
		</div>";
        }

        if (isset($contact_options['cta_2_title']) && ! empty($contact_options['cta_2_title'])) {
            $cta_title = isset($contact_options['cta_2_title']) && ! empty($contact_options['cta_2_title']) ? "<h3>" . wp_unslash($contact_options['cta_2_title']) . "</h3>" : "" ;
            $cta_url = isset($contact_options['cta_2_url']) && ! empty($contact_options['cta_2_url']) ? $contact_options['cta_2_url'] : "" ;
            
            $cta .= "<div data-aos=\"fade-left\" data-aos-delay=\"400\" data-aos-once=\"true\">
				<a href=\"$cta_url\" class=\"aios-site-button\"><span>$cta_title</span> <i class=\"ai-font-arrow-h-n\"></i></a>
			</div>";
        }

        if (isset($contact_options['cta_3_title']) && ! empty($contact_options['cta_3_title'])) {
            $cta_title = isset($contact_options['cta_3_title']) && ! empty($contact_options['cta_3_title']) ? "<h3>" . wp_unslash($contact_options['cta_3_title']) . "</h3>" : "" ;
            $cta_url = isset($contact_options['cta_3_url']) && ! empty($contact_options['cta_3_url']) ? $contact_options['cta_3_url'] : "" ;
            
            $cta .= "<div data-aos=\"fade-left\" data-aos-delay=\"0\" data-aos-once=\"true\">
				<a href=\"$cta_url\" class=\"aios-site-button\"><span>$cta_title</span> <i class=\"ai-font-arrow-h-n\"></i></a>
			</div>";
        }

        if (! empty($cta)) {
            $cta = "<div class=\"ip-cta aios-contact-cta\"><div class=\"aios-ip-cta-list\">$cta</div></div>";
        }

		// Iframe
        $iframe_map = isset($contact_options['iframe_map']) ? "<div class=\"aios-contact-map\" data-aos=\"fade-left\" data-aos-delay=\"400\" data-aos-once=\"true\">
			<iframe src=\"" . $contact_options['iframe_map'] . "\" width=\"1140\" height=\"500\" frameborder=\"0\" style=\"border:0;\" allowfullscreen=\"\" title=\"Map Embed Link\" aria-hidden=\"false\" tabindex=\"0\"></iframe>
		</div>" : "";

        return do_shortcode("<div class=\"aios-contact-wrap\">
	<div class=\"aios-contact-inner\">
		<div class=\"aios-contact-logo\" data-aos=\"fade-right\" data-aos-delay=\"0\" data-aos-once=\"true\">
			$title
		</div>
		<div class=\"aios-contact-main\">
			<div class=\"aios-contact-photo\" data-aos=\"fade-left\" data-aos-delay=\"0\" data-aos-once=\"true\">
				<img src=\"$image_src\" alt=\"" . get_the_title() . "\">
			</div>
			$form
			$address
			$phone_email
			$smi
		</div>
		$cta
		$iframe_map
	</div>
</div>");
    }
}
