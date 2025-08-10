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
        $phone_email = client_info_values("phone", "<li><i class=\"ai-font-phone\"></i> [ai_phone unwrap_em=true href=\"{href-phone}\"]{default-phone}[/ai_phone]</li>");
        $phone_email .= client_info_values("cell", "<li><i class=\"ai-font-cellphone\"></i> [ai_phone unwrap_em=true href=\"{href-phone}\"]{default-phone}[/ai_phone]</li>");
        $phone_email .= client_info_values("fax", "<li><i class=\"ai-font-fax\"></i> [ai_phone unwrap_em=true href=\"{href-phone}\"]{default-phone}[/ai_phone]</li>");
        $phone_email .= client_info_values("email", "<li><i class=\"ai-font-envelope\"></i> [mail_to email=\"{default-email}\"]{default-email}[/mail_to]</li>");
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

        return do_shortcode("<div class=\"aios-about-wrap\">
	<div class=\"row aios-about-inner\">
		<div class=\"col-md-12 aios-about-container\">
				<div class=\"aios-about-img\" data-aos=\"fade-left\" data-aos-delay=\"0\" data-aos-once=\"true\">
					<img src=\"$image_src\" alt=\"" . get_the_title() . "\">
				</div>
				<div class=\"aios-about-main\" data-aos=\"fade-right\" data-aos-delay=\"0\" data-aos-once=\"true\">
				<div class=\"entry-title aios-about-title\">
					$title
				</div>
				<div class=\"aios-about-content\">$content</div>

		</div>
		<div class=\"clear\"></div>
		<div class=\"row\" data-aos=\"fade-up\" data-aos-delay=\"0\" data-aos-once=\"true\">
			<div class=\"aios-about-info\">
				<ul>
                    $phone_email

					<li>
						<div class=\"aios-about-smis\">
                            $smi
						</div>
					</li>
				</ul>
			</div>
		</div>
	</div>
</div>");
    }
}
