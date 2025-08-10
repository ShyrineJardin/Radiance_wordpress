<?php

namespace AiosInitialSetup\Resources\Template;

class ContentTemplate
{
    public static function render()
    {
        $about_options = get_option('about_options', []);
        $image_src = isset($about_options['agent_team_photo']) ? wp_get_attachment_image_url($about_options['agent_team_photo'], 'full') : 'https://resources.agentimage.com/images/generate-pages/about-modern-agent.jpg';
        $title = isset($about_options['title']) ? $about_options['title'] : "";
        $content = wpautop( isset($about_options['content']) ? $about_options['content'] : "" );

        // Contact Info
        $contact_info = client_info_values("phone", "<li><span class=\"ai-font-phone-alt phone\"></span> [ai_phone unwrap_em=true href=\"{href-phone}\"]{default-phone}[/ai_phone]</li>") . client_info_values("cell", "<li><span class=\"ai-font-cellphone\"></span> [ai_phone unwrap_em=true href=\"{href-phone}\"]{default-phone}[/ai_phone]</li>") . client_info_values("fax", "<li><span class=\"ai-font-fax\"></span> [ai_phone unwrap_em=true href=\"{href-phone}\"]{default-phone}[/ai_phone]</li>") . client_info_values("email", "<li><span class=\"ai-font-envelope envelope\"></span> [mail_to email=\"{default-email}\"]{default-email}[/mail_to]</li>");

        if (!empty($contact_info)) {
            $contact_info = "<div>
                <ul class=\"ai-modern-about-contact\">
                    $contact_info
                </ul>
            </div>";
        }

        // Social Media
        $smi = client_info_values("facebook", "<li><a href=\"{smi-link}\" target=\"_blank\" rel=\"nofollow noopener\" class=\"ai-font-facebook\"><span class=\"hidden\">facebook</span></a></li>");
		$smi .= client_info_values("twitter", "<li><a href=\"{smi-link}\" target=\"_blank\" rel=\"nofollow noopener\" class=\"ai-font-twitter\"><span class=\"hidden\">X</span></a></li>");
		$smi .= client_info_values("linkedin", "<li><a href=\"{smi-link}\" target=\"_blank\" rel=\"nofollow noopener\" class=\"ai-font-linkedin\"><span class=\"hidden\">linkedin</span></a></li>");
		$smi .= client_info_values("youtube", "<li><a href=\"{smi-link}\" target=\"_blank\" rel=\"nofollow noopener\" class=\"ai-font-youtube\"><span class=\"hidden\">youtube</span></a></li>");
		$smi .= client_info_values("instagram", "<li><a href=\"{smi-link}\" target=\"_blank\" rel=\"nofollow noopener\" class=\"ai-font-instagram\"><span class=\"hidden\">instagram</span></a></li>");
		$smi .= client_info_values("pinterest", "<li><a href=\"{smi-link}\" target=\"_blank\" rel=\"nofollow noopener\" class=\"ai-font-pinterest\"><span class=\"hidden\">pinterest</span></a></li>");
		$smi .= client_info_values("trulia", "<li><a href=\"{smi-link}\" target=\"_blank\" rel=\"nofollow noopener\" class=\"ai-font-trulia\"><span class=\"hidden\">trulia</span></a></li>");
		$smi .= client_info_values("zillow", "<li><a href=\"{smi-link}\" target=\"_blank\" rel=\"nofollow noopener\" class=\"ai-font-zillow\"><span class=\"hidden\">zillow</span></a></li>");
		$smi .= client_info_values("houzz", "<li><a href=\"{smi-link}\" target=\"_blank\" rel=\"nofollow noopener\" class=\"ai-font-houzz\"><span class=\"hidden\">houzz</span></a></li>");
		$smi .= client_info_values("blogger", "<li><a href=\"{smi-link}\" target=\"_blank\" rel=\"nofollow noopener\" class=\"ai-font-blogger\"><span class=\"hidden\">blogger</span></a></li>");
		$smi .= client_info_values("yelp", "<li><a href=\"{smi-link}\" target=\"_blank\" rel=\"nofollow noopener\" class=\"ai-font-yelp\"><span class=\"hidden\">yelp</span></a></li>");
		$smi .= client_info_values("skype", "<li><a href=\"{smi-link}\" target=\"_blank\" rel=\"nofollow noopener\" class=\"ai-font-skype\"><span class=\"hidden\">skype</span></a></li>");
		$smi .= client_info_values("caimeiju", "<li><a href=\"{smi-link}\" target=\"_blank\" rel=\"nofollow noopener\" class=\"ai-font-caimeiju\"><span class=\"hidden\">caimeiju</span></a></li>");
		$smi .= client_info_values("rss", "<li><a href=\"{smi-link}\" target=\"_blank\" rel=\"nofollow noopener\" class=\"ai-font-rss\"><span class=\"hidden\">rss</span></a></li>");
		$smi .= client_info_values("cameo", "<li><a href=\"{smi-link}\" target=\"_blank\" rel=\"nofollow noopener\" class=\"ai-font-cameo\"><span class=\"hidden\">cameo</span></a></li>");
		$smi .= client_info_values("tiktok", "<li><a href=\"{smi-link}\" target=\"_blank\" rel=\"nofollow noopener\" class=\"ai-font-tiktok\"><span class=\"hidden\">tiktok</span></a></li>");
        
        if (! empty($smi)) {
            $smi = "<div>
            <ul class=\"ai-modern-about-smi\">
                $smi
            </ul>
        </div>";
        }

        // Contact Form
        $form_title = get_option('about-theme-form-title', '');
        $form = ! empty(get_option('about-theme-form', '')) ? "<div class=\"ai-template-form-wrap\" data-aos=\"fade-up\">
    <div class=\"container\">
        <div class=\"ai-template-form\">
            <div class=\"ai-template-form-title\">$form_title</div>
            [contact-form-7 id=\"" . get_option('about-theme-form') . "\" html_class=\"use-floating-validation-tip\"]
        </div>
    </div>
</div>" : "";

        // Call to Action
        $cta = "";
        
        if (isset($about_options['cta_1_image']) && ! empty($about_options['cta_1_image'])) {
            $cta_image_src = isset($about_options['cta_1_image']) ? wp_get_attachment_image_url($about_options['cta_1_image'], 'full') : 'https://resources.agentimage.com/images/ai-classic-contact-photo.jpg';
            $cta_title = isset($about_options['cta_1_title']) && ! empty($about_options['cta_1_title']) ? "<h3>" . $about_options['cta_1_title'] . "</h3>" : "" ;
            $cta_url = isset($about_options['cta_1_url']) && ! empty($about_options['cta_1_url']) ? $about_options['cta_1_url'] : "" ;
            
            $cta .= "<li data-aos=\"fade-right\" data-aos-delay=\"200\">
        <a href=\"$cta_url\">
            <canvas width=\"533\" height=\"340\" style=\"background-image: url($cta_image_src);\"></canvas>
            <div>$cta_title</div>
        </a>
    </li>";
        }

        if (isset($about_options['cta_2_image']) && ! empty($about_options['cta_2_image'])) {
            $cta_image_src = isset($about_options['cta_2_image']) ? wp_get_attachment_image_url($about_options['cta_2_image'], 'full') : 'https://resources.agentimage.com/images/ai-classic-contact-photo.jpg';
            $cta_title = isset($about_options['cta_2_title']) && ! empty($about_options['cta_2_title']) ? "<h3>" . $about_options['cta_2_title'] . "</h3>" : "" ;
            $cta_url = isset($about_options['cta_2_url']) && ! empty($about_options['cta_2_url']) ? $about_options['cta_2_url'] : "" ;
            
            $cta .= "<li data-aos=\"fade-right\" data-aos-delay=\"200\">
        <a href=\"$cta_url\">
            <canvas width=\"533\" height=\"340\" style=\"background-image: url($cta_image_src);\"></canvas>
            <div>$cta_title</div>
        </a>
    </li>";
        }

        if (isset($about_options['cta_3_image']) && ! empty($about_options['cta_3_image'])) {
            $cta_image_src = isset($about_options['cta_3_image']) ? wp_get_attachment_image_url($about_options['cta_3_image'], 'full') : 'https://resources.agentimage.com/images/ai-classic-contact-photo.jpg';
            $cta_title = isset($about_options['cta_3_title']) && ! empty($about_options['cta_3_title']) ? "<h3>" . $about_options['cta_3_title'] . "</h3>" : "" ;
            $cta_url = isset($about_options['cta_3_url']) && ! empty($about_options['cta_3_url']) ? $about_options['cta_3_url'] : "" ;
            
            $cta .= "<li data-aos=\"fade-right\" data-aos-delay=\"200\">
        <a href=\"$cta_url\">
            <canvas width=\"533\" height=\"340\" style=\"background-image: url($cta_image_src);\"></canvas>
            <div>$cta_title</div>
        </a>
    </li>";
        }

        if (! empty($cta)) {
            $cta = "<ul class=\"ai-modern-about-cta\">$cta</ul>";
        }

        $testimonials = "";

        if (isset($about_options['testimonial_show']) && $about_options['testimonial_show'] === "show") {
            $testimonial_url = isset($about_options['testimonial_url']) && ! empty($about_options['testimonial_url']) ? $about_options['testimonial_url'] : "[blogurl]/testimonials/";
            $testimonials = "<div class=\"ai-modern-about-testi\" data-aos=\"fade-up\">
    <div class=\"ai-modern-about-testi-slider\">
        [aios_testimonials]
            <div class=\"ai-modern-about-testi-item\">
                <a href=\"$testimonial_url\">
                    <h3>{{testimonial_title}}</h3>
                    <img src=\"https://resources.agentimage.com/images/generate-pages/about-modern-testimonial-quote.png\" alt=\"Quote Icon\">
                    <p>“{{testimonial_excerpt}}”</p>
                    <canvas width=\"178\" height=\"178\" style=\"background-image: url({{testimonial_featured_image}});\"></canvas>
                </a>
            </div>
        [/aios_testimonials]
    </div>
    <div class=\"ai-modern-about-testi-controls\">
        <span class=\"ai-modern-about-testi-arrow ai-modern-about-testi-prev ai-font-arrow-b-p\"></span>
        <span class=\"ai-modern-about-testi-arrow ai-modern-about-testi-next ai-font-arrow-b-n\"></span>
    </div>
</div>"; 
        }

        return do_shortcode("<div class=\"ai-modern-about-entry\">
    <div class=\"container\">
        <div class=\"ai-modern-about-photo\" data-aos=\"fade-right\">
            <canvas width=\"550\" height=\"670\" style=\"background-image: url($image_src)\"></canvas>
        </div>
        <div class=\"ai-modern-about-main\">
            <div class=\"ai-modern-about-title\" data-aos=\"fade-up\" data-aos-delay=\"200\">
                <h2>$title</h2>
            </div>
            <div class=\"ai-modern-about-content\" data-aos=\"fade-up\" data-aos-delay=\"200\">
                $content
            </div>
            <div class=\"ai-modern-about-info\" data-aos=\"fade-up\" data-aos-delay=\"400\">
                $contact_info
                $smi
            </div>
        </div>
    </div>
</div>

$form

$cta

$testimonials");
    }
}
