<?php

namespace AiosInitialSetup\Resources\Template;

class ContentTemplate
{
    public static function render()
    {
        $about_options = get_option('about_options', []);
        $image_src = isset($about_options['agent_team_photo']) ? wp_get_attachment_image_url($about_options['agent_team_photo'], 'full') : 'https://resources.agentimage.com/images/generate-pages/about-amante-ii-agent.jpg';
        $title = isset($about_options['title']) ? "<div class=\"section-title-a\">" . wp_unslash($about_options['title']) . "</div>" : "";
        $content = wpautop( isset($about_options['content']) ? wp_unslash($about_options['content']) : "" );

        return do_shortcode("<div id=\"welcome\" class=\"ip-welcome\">
            <div class=\"container\">
                <div class=\"welcome-right\">
                    <div class=\"welcome-agent\" data-aos=\"fade-right\" data-aos-once=\"true\"  data-aos-offset=\"100\">
                        <img src=\"$image_src\" alt=\"" . get_the_title() . "\" class=\"img-responsive\">
                    </div>
                </div>
                <div class=\"welcome-left\" data-aos=\"fade-left\" data-aos-once=\"true\"  data-aos-offset=\"100\">
                    <div class=\"welcome-text\">
                        $title
                        $content
                    </div>
                </div>

            </div>
        </div>");
    }
}
