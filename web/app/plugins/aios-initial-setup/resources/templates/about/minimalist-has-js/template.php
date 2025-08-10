<?php

namespace AiosInitialSetup\Resources\Template;

class ContentTemplate
{
    public static function render()
    {
        $about_options = get_option('about_options', []);
        $image_src = isset($about_options['agent_team_photo']) ? wp_get_attachment_image_url($about_options['agent_team_photo'], 'full') : 'https://resources.agentimage.com/images/generate-pages/ai-minimalist-about-agent.jpg';
        $title = isset($about_options['title']) ? wp_unslash($about_options['title']) : "";
        $subtitle = isset($about_options['subtitle']) ? wp_unslash($about_options['subtitle']) : "";
        $content = wpautop( isset($about_options['content']) ? wp_unslash($about_options['content']) : "" );

        $phone_email = client_info_values("phone", "<div>[ai_phone unwrap_em=true href=\"{href-phone}\"]<span class=\"ai-font-phone\"></span> {default-phone}[/ai_phone]</div>") .  client_info_values("cell", "<div>[ai_phone unwrap_em=true href=\"{href-phone}\"]<span class=\"ai-font-cellphone\"></span> {default-phone}[/ai_phone]</div>") .  client_info_values("fax", "<div>[ai_phone unwrap_em=true href=\"{href-phone}\"]<span class=\"ai-font-fax\"></span> {default-phone}[/ai_phone]</div>") . client_info_values("email", "<div>[mail_to email=\"{default-email}\"]<span class=\"ai-font-envelope\"></span> {default-email}[/mail_to]</div>");

        // Social Media
        $smi = client_info_values("facebook", "<a href=\"{smi-link}\" target=\"_blank\" rel=\"nofollow noopener\" class=\"ai-font-facebook\"><span class=\"hidden\">facebook</span></a>");
		$smi .= client_info_values("twitter", "<a href=\"{smi-link}\" target=\"_blank\" rel=\"nofollow noopener\" class=\"ai-font-twitter\"><span class=\"hidden\">X</span></a>");
		$smi .= client_info_values("linkedin", "<a href=\"{smi-link}\" target=\"_blank\" rel=\"nofollow noopener\" class=\"ai-font-linkedin\"><span class=\"hidden\">linkedin</span></a>");
		$smi .= client_info_values("youtube", "<a href=\"{smi-link}\" target=\"_blank\" rel=\"nofollow noopener\" class=\"ai-font-youtube\"><span class=\"hidden\">youtube</span></a>");
		$smi .= client_info_values("instagram", "<a href=\"{smi-link}\" target=\"_blank\" rel=\"nofollow noopener\" class=\"ai-font-instagram\"><span class=\"hidden\">instagram</span></a>");
		$smi .= client_info_values("pinterest", "<a href=\"{smi-link}\" target=\"_blank\" rel=\"nofollow noopener\" class=\"ai-font-pinterest\"><span class=\"hidden\">pinterest</span></a>");
		$smi .= client_info_values("trulia", "<a href=\"{smi-link}\" target=\"_blank\" rel=\"nofollow noopener\" class=\"ai-font-trulia\"><span class=\"hidden\">trulia</span></a>");
		$smi .= client_info_values("zillow", "<a href=\"{smi-link}\" target=\"_blank\" rel=\"nofollow noopener\" class=\"ai-font-zillow\"><span class=\"hidden\">zillow</span></a>");
		$smi .= client_info_values("houzz", "<a href=\"{smi-link}\" target=\"_blank\" rel=\"nofollow noopener\" class=\"ai-font-houzz\"><span class=\"hidden\">houzz</span></a>");
		$smi .= client_info_values("blogger", "<a href=\"{smi-link}\" target=\"_blank\" rel=\"nofollow noopener\" class=\"ai-font-blogger\"><span class=\"hidden\">blogger</span></a>");
		$smi .= client_info_values("yelp", "<a href=\"{smi-link}\" target=\"_blank\" rel=\"nofollow noopener\" class=\"ai-font-yelp\"><span class=\"hidden\">yelp</span></a>");
		$smi .= client_info_values("skype", "<a href=\"{smi-link}\" target=\"_blank\" rel=\"nofollow noopener\" class=\"ai-font-skype\"><span class=\"hidden\">skype</span></a>");
		$smi .= client_info_values("caimeiju", "<a href=\"{smi-link}\" target=\"_blank\" rel=\"nofollow noopener\" class=\"ai-font-caimeiju\"><span class=\"hidden\">caimeiju</span></a>");
		$smi .= client_info_values("rss", "<a href=\"{smi-link}\" target=\"_blank\" rel=\"nofollow noopener\" class=\"ai-font-rss\"><span class=\"hidden\">rss</span></a>");
		$smi .= client_info_values("cameo", "<a href=\"{smi-link}\" target=\"_blank\" rel=\"nofollow noopener\" class=\"ai-font-cameo\"><span class=\"hidden\">cameo</span></a>");
		$smi .= client_info_values("tiktok", "<a href=\"{smi-link}\" target=\"_blank\" rel=\"nofollow noopener\" class=\"ai-font-tiktok\"><span class=\"hidden\">tiktok</span></a>");
        
        if (! empty($smi)) {
            $smi = "<div class=\"ai-minimalist-column-agent-details-socials\">$smi</div>";
        }

        $testimonials = "";

        if (isset($about_options['testimonial_show']) && $about_options['testimonial_show'] === "show") {
            $testimonial_url = isset($about_options['testimonial_url']) && ! empty($about_options['testimonial_url']) ? $about_options['testimonial_url'] : "[blogurl]/testimonials/";
            $testimonials = "<div class=\"ai-minimalist-testimonials\" data-aos=\"fade-up\" data-aos-duration=\"1000\" data-aos-once=\"true\">
            <div class=\"container\">
                <div class=\"ai-minimalist-testimonial\">
                    [aios_testimonials]
                        <div>
                            <a href=\"$testimonial_url\" class=\"ai-minimalist-testimonials-item\">
                                <span class=\"ai-minimalist-testimonials-item-name\">
                                    {{testimonial_title}}
                                </span>
                                <span class=\"ai-minimalist-testimonials-item-caption\">
                                    “{{testimonial_excerpt}}”
                                </span>
                            </a>
                        </div>
                    [/aios_testimonials]
                </div>
            </div>
        </div>"; 
        }

        // Contact Form
        $form_title = get_option('about-theme-form-title', '');
        $form = ! empty(get_option('about-theme-form', '')) ? "<div class=\"container\">
            <div class=\"ai-minimalist-form-wrapper\" data-aos=\"fade-up\" data-aos-duration=\"1000\" data-aos-once=\"true\">
                <div class=\"ai-minimalist-form\">
                    <div class=\"ai-minimalist-form-title\">$form_title</div>
                    [contact-form-7 id=\"" . get_option('about-theme-form') . "\" html_class=\"use-floating-validation-tip\"]
                </div>
            </div>
        </div>" : "";

        // Call to Action
        $cta = "";
        
        if (isset($about_options['cta_1_title']) && ! empty($about_options['cta_1_title'])) {
            $cta_title = isset($about_options['cta_1_title']) && ! empty($about_options['cta_1_title']) ? "<h3>" . $about_options['cta_1_title'] . "</h3>" : "" ;
            $cta_url = isset($about_options['cta_1_url']) && ! empty($about_options['cta_1_url']) ? $about_options['cta_1_url'] : "" ;
            
            $cta .= "<div class=\"ai-minimalist-cta-button\">
                    <a href=\"$cta_url\">$cta_title</a>
                </div>";
        }

        if (isset($about_options['cta_2_title']) && ! empty($about_options['cta_2_title'])) {
            $cta_title = isset($about_options['cta_2_title']) && ! empty($about_options['cta_2_title']) ? "<h3>" . $about_options['cta_2_title'] . "</h3>" : "" ;
            $cta_url = isset($about_options['cta_2_url']) && ! empty($about_options['cta_2_url']) ? $about_options['cta_2_url'] : "" ;
            
            $cta .= "<div class=\"ai-minimalist-cta-button\">
                    <a href=\"$cta_url\">$cta_title</a>
                </div>";
        }

        if (isset($about_options['cta_3_title']) && ! empty($about_options['cta_3_title'])) {
            $cta_title = isset($about_options['cta_3_title']) && ! empty($about_options['cta_3_title']) ? "<h3>" . $about_options['cta_3_title'] . "</h3>" : "" ;
            $cta_url = isset($about_options['cta_3_url']) && ! empty($about_options['cta_3_url']) ? $about_options['cta_3_url'] : "" ;
            
            $cta .= "<div class=\"ai-minimalist-cta-button\">
                    <a href=\"$cta_url\">$cta_title</a>
                </div>";
        }

        if (! empty($cta)) {
            $cta = "<div class=\"container\"><div class=\"ai-minimalist-cta\" data-aos=\"fade-up\" data-aos-duration=\"1000\" data-aos-once=\"true\">$cta</div></div>";
        }

        return do_shortcode("
        <div class=\"container\">
            <div class=\"ai-minimalist-column-content\">
                <div class=\"ai-minimalist-column-content-left\">
                    <h1 class=\"entry-title\" data-aos=\"fade-up\" data-aos-duration=\"1000\" data-aos-once=\"true\">$title</h1>
                    <h2 class=\"entry-sub-title\" data-aos=\"fade-up\" data-aos-duration=\"1000\" data-aos-once=\"true\">$subtitle</h2>

                    <div class=\"ai-minimalist-column-the-content\" data-aos=\"fade-up\" data-aos-duration=\"1000\" data-aos-once=\"true\">
                        $content
                    </div>
                </div>

                <div class=\"ai-minimalist-column-content-right\">
                    <div class=\"ai-minimalist-column-agent\">
                        <div class=\"ai-minimalist-column-agent-image\" data-aos=\"fade-up\" data-aos-duration=\"1000\" data-aos-once=\"true\">
                            <img src=\"$image_src\" alt=\"" . get_the_title() . "\">
                        </div>
                        <div class=\"ai-minimalist-column-agent-details\" data-aos=\"fade-up\" data-aos-duration=\"1000\" data-aos-once=\"true\">
                            $phone_email
                            $smi
                        </div>
                    </div>
                </div>
            </div>
        </div>

        $testimonials

        $form

        $cta");
    }
}
