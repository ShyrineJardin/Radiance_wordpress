<?php

namespace AiosInitialSetup\Resources\Template;

class ContentTemplate
{
    public static function render()
    {
        $about_options = get_option('about_options', []);
        $image_src = isset($about_options['agent_team_photo']) ? wp_get_attachment_image_url($about_options['agent_team_photo'], 'full') : 'https://resources.agentimage.com/images/ai-classic-contact-photo.jpg';
        $title = isset($about_options['title']) ? wp_unslash($about_options['title']) : "";
        $content = wpautop( isset($about_options['content']) ? wp_unslash($about_options['content']) : "" );

        $phone_email = client_info_values("phone", "<span>[ai_phone unwrap_em=true href=\"{href-phone}\"]<i style=\"font-style: normal;\" class=\"ai-font-phone-alt\"></i> {default-phone}[/ai_phone]</span>") . client_info_values("cell", "<span>[ai_phone unwrap_em=true href=\"{href-phone}\"]<i style=\"font-style: normal;\" class=\"ai-font-cellphone\"></i> {default-phone}[/ai_phone]</span>") . client_info_values("fax", "<span>[ai_phone unwrap_em=true href=\"{href-phone}\"]<i style=\"font-style: normal;\" class=\"ai-font-fax\"></i> {default-phone}[/ai_phone]</span>") . client_info_values("email", "<span>[mail_to email=\"{default-email}\"]<i style=\"font-style: normal;\" class=\"ai-font-envelope\"></i> {default-email}[/mail_to]</span>");
        
        $smi = client_info_values("facebook", "<a href=\"{smi-link}\" target=\"_blank\" rel=\"noopener\"><i style=\"font-style: normal;\" class=\"ai-font-facebook\"></i><span style=\"display: none\">facebook</span></a>");
		$smi .= client_info_values("twitter", "<a href=\"{smi-link}\" target=\"_blank\" rel=\"noopener\"><i style=\"font-style: normal;\" class=\"ai-font-twitter\"></i><span style=\"display: none\">X</span></a>");
		$smi .= client_info_values("linkedin", "<a href=\"{smi-link}\" target=\"_blank\" rel=\"noopener\"><i style=\"font-style: normal;\" class=\"ai-font-linkedin\"></i><span style=\"display: none\">linkedin</span></a>");
		$smi .= client_info_values("youtube", "<a href=\"{smi-link}\" target=\"_blank\" rel=\"noopener\"><i style=\"font-style: normal;\" class=\"ai-font-youtube\"></i><span style=\"display: none\">youtube</span></a>");
		$smi .= client_info_values("instagram", "<a href=\"{smi-link}\" target=\"_blank\" rel=\"noopener\"><i style=\"font-style: normal;\" class=\"ai-font-instagram\"></i><span style=\"display: none\">instagram</span></a>");
		$smi .= client_info_values("pinterest", "<a href=\"{smi-link}\" target=\"_blank\" rel=\"noopener\"><i style=\"font-style: normal;\" class=\"ai-font-pinterest\"></i><span style=\"display: none\">pinterest</span></a>");
		$smi .= client_info_values("trulia", "<a href=\"{smi-link}\" target=\"_blank\" rel=\"noopener\"><i style=\"font-style: normal;\" class=\"ai-font-trulia\"></i><span style=\"display: none\">trulia</span></a>");
		$smi .= client_info_values("zillow", "<a href=\"{smi-link}\" target=\"_blank\" rel=\"noopener\"><i style=\"font-style: normal;\" class=\"ai-font-zillow\"></i><span style=\"display: none\">zillow</span></a>");
		$smi .= client_info_values("houzz", "<a href=\"{smi-link}\" target=\"_blank\" rel=\"noopener\"><i style=\"font-style: normal;\" class=\"ai-font-houzz\"></i><span style=\"display: none\">houzz</span></a>");
		$smi .= client_info_values("blogger", "<a href=\"{smi-link}\" target=\"_blank\" rel=\"noopener\"><i style=\"font-style: normal;\" class=\"ai-font-blogger\"></i><span style=\"display: none\">blogger</span></a>");
		$smi .= client_info_values("yelp", "<a href=\"{smi-link}\" target=\"_blank\" rel=\"noopener\"><i style=\"font-style: normal;\" class=\"ai-font-yelp\"></i><span style=\"display: none\">yelp</span></a>");
		$smi .= client_info_values("skype", "<a href=\"{smi-link}\" target=\"_blank\" rel=\"noopener\"><i style=\"font-style: normal;\" class=\"ai-font-skype\"></i><span style=\"display: none\">skype</span></a>");
		$smi .= client_info_values("caimeiju", "<a href=\"{smi-link}\" target=\"_blank\" rel=\"noopener\"><i style=\"font-style: normal;\" class=\"ai-font-caimeiju\"></i><span style=\"display: none\">caimeiju</span></a>");
		$smi .= client_info_values("rss", "<a href=\"{smi-link}\" target=\"_blank\" rel=\"noopener\"><i style=\"font-style: normal;\" class=\"ai-font-rss\"></i><span style=\"display: none\">rss</span></a>");
		$smi .= client_info_values("cameo", "<a href=\"{smi-link}\" target=\"_blank\" rel=\"noopener\"><i style=\"font-style: normal;\" class=\"ai-font-cameo\"></i><span style=\"display: none\">cameo</span></a>");
		$smi .= client_info_values("tiktok", "<a href=\"{smi-link}\" target=\"_blank\" rel=\"noopener\"><i style=\"font-style: normal;\" class=\"ai-font-tiktok\"></i><span style=\"display: none\">tiktok</span></a>");

        $cta = "";

        if (isset($about_options['cta_1_image']) && ! empty($about_options['cta_1_image'])) {
            $cta_image_src = isset($about_options['cta_1_image']) ? wp_get_attachment_image_url($about_options['cta_1_image'], 'full') : 'https://resources.agentimage.com/images/ai-classic-contact-photo.jpg';
            $cta_title = isset($about_options['cta_1_title']) && ! empty($about_options['cta_1_title']) ? "<h3>" . $about_options['cta_1_title'] . "</h3>" : "" ;
            $cta_url = isset($about_options['cta_1_url']) && ! empty($about_options['cta_1_url']) ? $about_options['cta_1_url'] : "" ;
            
            $cta .= "<div class=\"ai-classic-about-cta-col\" data-aos=\"fade-up\" data-aos-once=\"true\">
                <a href=\"$cta_url\">
                    <canvas width=\"359\" height=\"283\" style=\"background-image: url($cta_image_src);\"></canvas>
                    $cta_title
                </a>
            </div>";
        }

        if (isset($about_options['cta_2_image']) && ! empty($about_options['cta_2_image'])) {
            $cta_image_src = isset($about_options['cta_2_image']) ? wp_get_attachment_image_url($about_options['cta_2_image'], 'full') : 'https://resources.agentimage.com/images/ai-classic-contact-photo.jpg';
            $cta_title = isset($about_options['cta_2_title']) && ! empty($about_options['cta_2_title']) ? "<h3>" . $about_options['cta_2_title'] . "</h3>" : "" ;
            $cta_url = isset($about_options['cta_2_url']) && ! empty($about_options['cta_2_url']) ? $about_options['cta_2_url'] : "" ;
            
            $cta .= "<div class=\"ai-classic-about-cta-col\" data-aos=\"fade-up\" data-aos-once=\"true\">
                <a href=\"$cta_url\">
                    <canvas width=\"359\" height=\"283\" style=\"background-image: url($cta_image_src);\"></canvas>
                    $cta_title
                </a>
            </div>";
        }

        if (isset($about_options['cta_3_image']) && ! empty($about_options['cta_3_image'])) {
            $cta_image_src = isset($about_options['cta_3_image']) ? wp_get_attachment_image_url($about_options['cta_3_image'], 'full') : 'https://resources.agentimage.com/images/ai-classic-contact-photo.jpg';
            $cta_title = isset($about_options['cta_3_title']) && ! empty($about_options['cta_3_title']) ? "<h3>" . $about_options['cta_3_title'] . "</h3>" : "" ;
            $cta_url = isset($about_options['cta_3_url']) && ! empty($about_options['cta_3_url']) ? $about_options['cta_3_url'] : "" ;
            
            $cta .= "<div class=\"ai-classic-about-cta-col\" data-aos=\"fade-up\" data-aos-once=\"true\">
                <a href=\"$cta_url\">
                    <canvas width=\"359\" height=\"283\" style=\"background-image: url($cta_image_src);\"></canvas>
                    $cta_title
                </a>
            </div>";
        }

        if (! empty($cta)) {
            $cta = "<div class=\"ai-classic-about-cta\">
    <div class=\"container \">

        <div class=\"ai-classic-about-cta-container\">
            $cta
        </div>

    </div>
</div><!-- end of cta -->";
        }

        $form_title = get_option('about-theme-form-title', '');
		$form = ! empty(get_option('about-theme-form', '')) ? "<div class=\"ai-template-form-wrap\" data-aos=\"fade-up\">
    <div class=\"container\">
        <div class=\"ai-template-form\">
            <div class=\"ai-template-form-title\">$form_title</div>
            <div class=\"ai-template-form-container\">[contact-form-7 id=\"" . get_option('about-theme-form') . "\" html_class=\"use-floating-validation-tip\"]</div>
        </div>
    </div>
</div><!-- end of template wrap -->" : "";

        $testimonial = "";
        
        if (isset($about_options['testimonial_show']) && $about_options['testimonial_show'] === "show") { 
            $testimonial_url = isset($about_options['testimonial_url']) && ! empty($about_options['testimonial_url']) ? $about_options['testimonial_url'] : "[blogurl]/testimonials/";
            $testimonial_title = isset($about_options['testimonial_title']) && ! empty($about_options['testimonial_title']) ? $about_options['testimonial_title'] : "What our <span>clients say</span>";
            $testimonial = "<div class=\"ai-classic-about-testimonials\" data-aos=\"fade-up\" data-aos-once=\"true\">
    <div class=\"container\">
        <div class=\"ai-classic-about-testimonials-container\">
            <div class=\"ai-classic-about-testimonials-title\">
                <h2>$testimonial_title</h2>
            </div>

            <div class=\"ai-classic-about-slides\">
                [aios_testimonials]
                    <div>
                        <div class=\"ai-classic-about-slide\">
                            <a href=\"$testimonial_url\">
                                <div class=\"ai-classic-about-annotation\"></div>
                                <div class=\"ai-classic-about-testimonials-content\">
                                    <p>{{testimonial_excerpt}}</p>
                                    <div class=\"ai-classic-testi-header\">
                                        <div class=\"ai-classic-testi-name\">
                                            <h4>{{testimonial_title}}</h4>
                                            <span>{{testimonial_role}}</span>
                                        </div>

                                        <div class=\"ai-classic-about-star\">
                                            <i style=\"font-style: normal;\" class=\"ai-font-star-fill\"></i>
                                            <i style=\"font-style: normal;\" class=\"ai-font-star-fill\"></i>
                                            <i style=\"font-style: normal;\" class=\"ai-font-star-fill\"></i>
                                            <i style=\"font-style: normal;\" class=\"ai-font-star-fill\"></i>
                                            <i style=\"font-style: normal;\" class=\"ai-font-star-fill\"></i>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div><!-- end of slide -->
                    </div>
                [/aios_testimonials]
            </div><!-- end of slides -->

        </div> <!-- end of container -->
    </div>
</div><!-- end of testimonials -->";
        }

        return do_shortcode("<div class=\"ai-classic-about-content\">
    <div class=\"container\">
        <div class=\"ai-classic-about-details\">
            <div class=\"ai-classic-about-agentprofile\" data-aos=\"fade-right\" data-aos-once=\"true\">
                <img src=\"$image_src\" alt=\"" . get_the_title() . "\">
                <div class=\"ai-classic-agent-contact-info\">
                    <div class=\"ai-classic-email-phone\">
                        $phone_email
                    </div>
                    <div class=\"ai-classic-about-smi\">
                        $smi
                    </div>
                </div>
            </div>
            <!-- end of ai classic -->
            <div class=\"ai-classic-about-greetings\" data-aos=\"fade-left\" data-aos-duration=\"1000\">
                <h1>$title</h1>
                $content
            </div>
            <div class=\"clear\"></div>
        </div>
    </div>
    <!-- end of about details -->
</div>
<!-- end of content -->

$form

$cta

$testimonial
");
    }
}
