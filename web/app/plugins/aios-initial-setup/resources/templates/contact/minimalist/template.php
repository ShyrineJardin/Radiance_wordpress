<?php

namespace AiosInitialSetup\Resources\Template;

class ContentTemplate
{
    public static function render()
    {
        $contact_options = get_option('contact_options', []);
        $image_src = isset($contact_options['agent_team_photo']) ? wp_get_attachment_image_url($contact_options['agent_team_photo'], 'full') : 'https://resources.agentimage.com/images/generate-pages/ai-minimalist-about-agent.jpg';

        $title = isset($contact_options['title']) ? "<h1 class=\"entry-title\" data-aos=\"fade-up\" data-aos-duration=\"1000\" data-aos-once=\"true\">" . wp_unslash($contact_options['title']) . "</h1>" : "";
        $subtitle = isset($contact_options['subtitle']) ? "<h2 class=\"entry-sub-title\" data-aos=\"fade-up\" data-aos-duration=\"1000\" data-aos-once=\"true\">" . wp_unslash($contact_options['subtitle']) . "</h2>" : "";

		// Contact Details
		$contact = client_info_values("phone", "<li><span class=\"ai-font-phone\"></span> [ai_phone unwrap_em=true href=\"{href-phone}\"]{default-phone}[/ai_phone]</li>") . client_info_values("cell", "<li><span class=\"ai-font-cellphone\"></span> [ai_phone unwrap_em=true href=\"{href-phone}\"]{default-phone}[/ai_phone]</li>") . client_info_values("fax", "<li><span class=\"ai-font-fax\"></span> [ai_phone unwrap_em=true href=\"{href-phone}\"]{default-phone}[/ai_phone]</li>") . client_info_values("email", "<li><span class=\"ai-font-envelope\"></span> [mail_to email=\"{default-email}\"] {default-email}[/mail_to]</li>") . client_info_values("address", "<li><span class=\"ai-font-location-c\"></span> <span>{" . (isset($contact_options['address-display']) && $contact_options['address-display'] === "compact" ? "default-compact-address" : "default-full-address") . "}</span></li>");
		
		if (! empty($contact)) {
			$contact = "<div class=\"ai-minimalist-column-the-content\" data-aos=\"fade-up\" data-aos-duration=\"1000\" data-aos-once=\"true\">
                <ul class=\"ai-minimalist-contact-details\">
                    $contact
                </ul>
            </div>";
		}

		// Contact + SMW
		$contact_smw = client_info_values("phone", "<div>[ai_phone unwrap_em=true href=\"{href-phone}\"]{default-phone}[/ai_phone]</div>") . client_info_values("email", "<div> [mail_to email=\"{default-email}\"] {default-email}[/mail_to]</div>");
        $smi = client_info_values("facebook", "<a href=\"{smi-link}\" target=\"_blank\" rel=\"noopener noreferrer\" class=\"ai-font-facebook\"><span class=\"hidden\">facebook</span></a>");
		$smi .= client_info_values("twitter", "<a href=\"{smi-link}\" target=\"_blank\" rel=\"noopener noreferrer\" class=\"ai-font-twitter\"><span class=\"hidden\">X</span></a>");
		$smi .= client_info_values("linkedin", "<a href=\"{smi-link}\" target=\"_blank\" rel=\"noopener noreferrer\" class=\"ai-font-linkedin\"><span class=\"hidden\">linkedin</span></a>");
		$smi .= client_info_values("youtube", "<a href=\"{smi-link}\" target=\"_blank\" rel=\"noopener noreferrer\" class=\"ai-font-youtube\"><span class=\"hidden\">youtube</span></a>");
		$smi .= client_info_values("instagram", "<a href=\"{smi-link}\" target=\"_blank\" rel=\"noopener noreferrer\" class=\"ai-font-instagram\"><span class=\"hidden\">instagram</span></a>");
		$smi .= client_info_values("pinterest", "<a href=\"{smi-link}\" target=\"_blank\" rel=\"noopener noreferrer\" class=\"ai-font-pinterest\"><span class=\"hidden\">pinterest</span></a>");
		$smi .= client_info_values("trulia", "<a href=\"{smi-link}\" target=\"_blank\" rel=\"noopener noreferrer\" class=\"ai-font-trulia\"><span class=\"hidden\">trulia</span></a>");
		$smi .= client_info_values("zillow", "<a href=\"{smi-link}\" target=\"_blank\" rel=\"noopener noreferrer\" class=\"ai-font-zillow\"><span class=\"hidden\">zillow</span></a>");
		$smi .= client_info_values("houzz", "<a href=\"{smi-link}\" target=\"_blank\" rel=\"noopener noreferrer\" class=\"ai-font-houzz\"><span class=\"hidden\">houzz</span></a>");
		$smi .= client_info_values("blogger", "<a href=\"{smi-link}\" target=\"_blank\" rel=\"noopener noreferrer\" class=\"ai-font-blogger\"><span class=\"hidden\">blogger</span></a>");
		$smi .= client_info_values("yelp", "<a href=\"{smi-link}\" target=\"_blank\" rel=\"noopener noreferrer\" class=\"ai-font-yelp\"><span class=\"hidden\">yelp</span></a>");
		$smi .= client_info_values("skype", "<a href=\"{smi-link}\" target=\"_blank\" rel=\"noopener noreferrer\" class=\"ai-font-skype\"><span class=\"hidden\">skype</span></a>");
		$smi .= client_info_values("caimeiju", "<a href=\"{smi-link}\" target=\"_blank\" rel=\"noopener noreferrer\" class=\"ai-font-caimeiju\"><span class=\"hidden\">caimeiju</span></a>");
		$smi .= client_info_values("rss", "<a href=\"{smi-link}\" target=\"_blank\" rel=\"noopener noreferrer\" class=\"ai-font-rss\"><span class=\"hidden\">rss</span></a>");
		$smi .= client_info_values("cameo", "<a href=\"{smi-link}\" target=\"_blank\" rel=\"noopener noreferrer\" class=\"ai-font-cameo\"><span class=\"hidden\">cameo</span></a>");
		$smi .= client_info_values("tiktok", "<a href=\"{smi-link}\" target=\"_blank\" rel=\"noopener noreferrer\" class=\"ai-font-tiktok\"><span class=\"hidden\">tiktok</span></a>");

        if (!empty($smi)) {
            $contact_smw .= "<div class=\"ai-minimalist-column-agent-details-socials\">$smi</div>";
        }

		if (!empty($contact_smw)) {
			$contact_smw = "<div class=\"ai-minimalist-column-agent-details\" data-aos=\"fade-up\" data-aos-duration=\"1000\" data-aos-once=\"true\">$contact_smw</div>";
		}
		
        // Contact Form
        $form_title = get_option('contact-theme-form-title', '');
        $form = ! empty(get_option('contact-theme-form', '')) ? "<div class=\"container\">
        <div class=\"ai-minimalist-form-wrapper\" data-aos=\"fade-up\" data-aos-duration=\"1000\" data-aos-once=\"true\">
            <div class=\"ai-minimalist-form\">
                <div class=\"ai-minimalist-form-title\">$form_title</div>
                [contact-form-7 id=\"" . get_option('contact-theme-form', '') . "\" html_class=\"use-floating-validation-tip custom-page-cf\"]
            </div>
        </div>
    </div>" : "";

        // Call to Action
        $cta = "";
            
        if (isset($contact_options['cta_1_title']) && ! empty($contact_options['cta_1_title'])) {
            $cta_title = isset($contact_options['cta_1_title']) && ! empty($contact_options['cta_1_title']) ? "<h3>" . wp_unslash($contact_options['cta_1_title']) . "</h3>" : "" ;
            $cta_url = isset($contact_options['cta_1_url']) && ! empty($contact_options['cta_1_url']) ? $contact_options['cta_1_url'] : "" ;
            
            $cta .= "<div class=\"ai-minimalist-cta-button\">
                <a href=\"$cta_url\">$cta_title</a>
            </div>";
        }

        if (isset($contact_options['cta_2_title']) && ! empty($contact_options['cta_2_title'])) {
            $cta_title = isset($contact_options['cta_2_title']) && ! empty($contact_options['cta_2_title']) ? "<h3>" . wp_unslash($contact_options['cta_2_title']) . "</h3>" : "" ;
            $cta_url = isset($contact_options['cta_2_url']) && ! empty($contact_options['cta_2_url']) ? $contact_options['cta_2_url'] : "" ;
            
            $cta .= "<div class=\"ai-minimalist-cta-button\">
                <a href=\"$cta_url\">$cta_title</a>
            </div>";
        }

        if (isset($contact_options['cta_3_title']) && ! empty($contact_options['cta_3_title'])) {
            $cta_title = isset($contact_options['cta_3_title']) && ! empty($contact_options['cta_3_title']) ? "<h3>" . wp_unslash($contact_options['cta_3_title']) . "</h3>" : "" ;
            $cta_url = isset($contact_options['cta_3_url']) && ! empty($contact_options['cta_3_url']) ? $contact_options['cta_3_url'] : "" ;
            
            $cta .= "<div class=\"ai-minimalist-cta-button\">
                <a href=\"$cta_url\">$cta_title</a>
            </div>";
        }

        if (! empty($cta)) {
            $cta = "<div class=\"container\"><div class=\"ai-minimalist-cta\" data-aos=\"fade-up\" data-aos-duration=\"1000\" data-aos-once=\"true\">$cta</div></div>";
        }

        // Map
        $iframe_title = isset($contact_options['iframe_title']) ? "<div class=\"ai-minimalist-map-title\">" . $contact_options['iframe_title'] . "</div>" : "";
        $iframe_map = isset($contact_options['iframe_map']) ? "<div class=\"container\">
        <div class=\"ai-minimalist-map\">
            $iframe_title
            <div class=\"ai-minimalist-map-frame\">
                <iframe src=\"" . $contact_options['iframe_map'] . "\" width=\"500\" height=\"300\" frameborder=\"0\" style=\"border:0;\" allowfullscreen=\"\"  title=\"Map Embed Link\" aria-hidden=\"false\" tabindex=\"0\"></iframe>
            </div>
        </div>
    </div>" : "";

        return do_shortcode("<div class=\"container\">
        <div class=\"ai-minimalist-column-content\">
            <div class=\"ai-minimalist-column-content-left\">
                $title
                $subtitle
                <hr>
                $contact
            </div>

            <div class=\"ai-minimalist-column-content-right\">
                <div class=\"ai-minimalist-column-agent\">
                    <div class=\"ai-minimalist-column-agent-image\" data-aos=\"fade-up\" data-aos-duration=\"1000\" data-aos-once=\"true\">
                        <img src=\"$image_src\" alt=\"" . get_the_title() . "\">
                    </div>

                    $contact_smw
                </div>
            </div>
        </div>
    </div>

    $form
    $cta
    $iframe_map");
    }
}
