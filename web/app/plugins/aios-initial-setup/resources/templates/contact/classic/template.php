<?php

namespace AiosInitialSetup\Resources\Template;

class ContentTemplate
{
    public static function render()
    {
        $contact_options = get_option('contact_options', []);
        $image_src = isset($contact_options['agent_team_photo']) ? wp_get_attachment_image_url($contact_options['agent_team_photo'], 'full') : 'https://resources.agentimage.com/images/generate-pages/ai-classic-contact-photo.jpg';

        $title = isset($contact_options['title']) ? "<h2>" . wp_unslash($contact_options['title']) . "</strong></h2>" : "";
        $subtitle = isset($contact_options['subtitle']) ? "<p>" . wp_unslash($contact_options['subtitle']) . "</strong></p>" : "";

		// Address 
        $address = client_info_values("address", "<li><i class=\"ai-font-location-c\"></i>{" . (isset($contact_options['address-display']) && $contact_options['address-display'] === "compact" ? "default-compact-address" : "default-full-address") . "}</li>");

		// Phone Email
		$phone_email = client_info_values("phone", "<span>
			    [ai_phone unwrap_em=true href=\"{href-phone}\"]<i class=\"ai-font-phone-alt\"></i> {default-phone}[/ai_phone]
            </span>") . client_info_values("cell", "<span>
                [ai_phone unwrap_em=true href=\"{href-phone}\"]<i class=\"ai-font-cellphone\"></i> {default-phone}[/ai_phone]
            </span>") . client_info_values("fax", "<span>
                [ai_phone unwrap_em=true href=\"{href-phone}\"]<i class=\"ai-font-fax\"></i> {default-phone}[/ai_phone]
            </span>") . client_info_values("email", "[mail_to email=\"{default-email}\"]<i class=\"ai-font-envelope\"></i> {default-email}[/mail_to]");

		if (! empty($phone_email)) {
			$phone_email = "<li>$phone_email</li>";
		}

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
			$smi = "<li>$smi</li>";
		}
		
        // Contact Form
        $form = ! empty(get_option('contact-theme-form', '')) ? "[contact-form-7 id=\"" . get_option('contact-theme-form', '') . "\" html_class=\"use-floating-validation-tip custom-page-cf\"]" : "";

        $iframe_map = isset($contact_options['iframe_map']) ? "<div class=\"ai-classic-contact-map\">
        <div class=\"container\" data-aos=\"fade-up\" data-aos-duration=\"1000\" data-aos-once=\"true\">
            <div class=\"ai-classic-contact-map-wrap\">
                <iframe src=\"" . $contact_options['iframe_map'] . "\" width=\"600\" height=\"383\" frameborder=\"0\" style=\"border:0;\" allowfullscreen=\"\"  title=\"Map Embed Link\" aria-hidden=\"false\" tabindex=\"0\"></iframe>
            </div>
        </div>
    </div>" : "";

        return do_shortcode("<div class=\"ai-classic-contact-info-wrap\">
        <div class=\"container\">
            <div class=\"ai-classic-contact-infos\">
                <div class=\"ai-classic-contact-image\" data-aos=\"fade-up\" data-aos-duration=\"1000\" data-aos-once=\"true\">
                    <canvas width=\"517\" height=\"733\" style=\"background-image:url($image_src)\"></canvas>
                </div><!-- end of contact image -->
                <div class=\"ai-classic-contact-contents\" data-aos=\"fade-up\" data-aos-duration=\"1000\" data-aos-once=\"true\">
                    $title
					$subtitle
                    $form

                    <ul class=\"ai-classic-contact-informations\">
                        $phone_email
                        $address
                        $smi
                    </ul>

                </div>
            </div><!-- end of contact infos -->
        </div>
    </div><!-- end of contact info wrap -->
	$iframe_map");
    }
}
