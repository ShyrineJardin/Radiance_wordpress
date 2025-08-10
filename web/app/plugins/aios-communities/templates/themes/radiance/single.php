<?php get_header();

    use AIOS\Communities\Controllers\Options;

    $communities_settings  = Options::options();
    if (!empty($communities_settings)) extract($communities_settings);

    $post_id    = get_the_ID();

    $aios_cta_title     =  get_post_meta($post_id, 'cta_title', true);
    $aios_cta_link      =  get_post_meta($post_id, 'cta_link', true);
    $aios_cta_new_tab   =  get_post_meta($post_id, 'cta_new_tab', true);
    $aios_communities_shortcode = get_post_meta($post_id, 'aios_communities_shortcode', true);
    $aios_display_cta           =  get_post_meta($post_id, 'display_cta', true);

?>

<div id="<?php echo ai_starter_theme_get_content_id('content-full') ?>">
    <article id="content" class="hfeed community-container">

        <?php do_action('aios_starter_theme_before_inner_page_content') ?>

        <?php if (have_posts()) : ?>

            <?php while (have_posts()) : the_post(); ?>

                <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                    <?php do_action('aios_starter_theme_before_entry_content') ?>
                    <?php
                        $aios_metaboxes_banner_title_layout = get_option('aios-metaboxes-banner-title-layout', '');
                        
                        if ( !is_custom_field_banner( get_queried_object() ) || $aios_metaboxes_banner_title_layout[1] != 1 ) {
                            $aioscm_used_custom_title   = get_post_meta( get_the_ID(), 'aioscm_used_custom_title', true );
                            $aioscm_main_title          = get_post_meta( get_the_ID(), 'aioscm_main_title', true );
                            $aioscm_sub_title           = get_post_meta( get_the_ID(), 'aioscm_sub_title', true );
                            $aioscm_title               = $aioscm_used_custom_title == 1 ? $aioscm_main_title . '<span>' . $aioscm_sub_title . '</span>' : get_the_title();
                            echo '<h1 class="entry-title hidden">' . $aioscm_title . '</h1>';
                        }
                    ?>

                    <div class="entry entry-content" data-sticky-container>
                        <?php 
                            $options = get_post_meta( get_the_ID(), 'community_field' );
                            $tabs = [];
                            $content = "";

                            if ( ! empty( $options ) ) {
                                foreach ( $options[0] as $k => $data ) {
                                    
                                    $contentTitle = "";
                                    $tabId = "";
                                    $tabClass = "";
                                    
                                    $entryTitle = $k === 0 ? 'class="entry-title"': '';

                                    if ( isset( $data['title'] ) && ! empty( $data['title'] ) ) {
                                        $tabId = preg_replace( '/[^A-Za-z0-9\-]/', '', strtolower( $data['title'] ) );

                                        if ( ! isset( $data['title_hide'] ) && empty( $data['title_hide'] ) ) {
                                            $contentTitle = "<h2 ".$entryTitle.">" . ( $data['title'] === "Introduction" ? get_the_title() : $data['title'] ) . "</h2>";
                                        }
                                        
                                        if ( ! isset( $data['title_hide_table'] ) && empty( $data['title_hide_table'] ) ) {
                                            $tabs[ $tabId ] = $data['title'];
                                            $tabClass = "entry-not-hidden";
                                        }
                                    }

                                    $entryClass = trim( "community-entry-content $tabClass" );
                                    $content .= "<div class=\"$entryClass\" data-id=\"$tabId\" id=\"$tabId\">";
                                    $content .= $contentTitle;
                                    
                                    foreach ( $data['fields'] as $k => $field ) {
                                        $content .= "<div class=\"community-entry-type\" data-type=\"" . $field['type'] . "\">";

                                            if ( $field['type'] === "textarea" && isset( $field['textarea'] ) && ! empty( $field['textarea'] ) ) {
                                                $content .= do_shortcode("<p class=\"comunity-paragraph\">" . $field['textarea'] . "</p>");
                                            } else if ( $field['type'] === "gallery" && isset( $field['gallery'] ) && ! empty( $field['gallery'] ) ) {
                                                $imageIds = explode( ',', $field[ 'gallery' ] );
                                                $imageHtml = "";
                                            
                                                foreach ($imageIds as $id) {
                                                    $imageHtml .= "<div class=\"community-gallery-item\">
                                                        <canvas width=\"419\" height=\"284\"></canvas>
                                                        " . wp_get_attachment_image( $id, 'full' ) . "
                                                    </div>";
                                                }

                                                $content .= "<div class=\"community-gallery grid-cols-" . $field['column'] . "\">" . $imageHtml . "</div>";
                                            } else if ( $field['type'] === "iframe" && isset( $field['iframe'] ) && ! empty( $field['iframe'] ) ) {
                                                $content .= "<iframe width=\"" . $field['iframewidth'] . "\" height=\"" . $field['iframeheight'] . "\" src=\"" . $field['iframe'] . "\" frameborder=\"0\"></iframe>";
                                            } else if ( $field['type'] === "tinymce" && isset( $field['tinymce'] ) && ! empty( $field['tinymce'] ) ) {
                                                $content .= do_shortcode(aioswpautop( $field['tinymce'] ));
                                            } else if ( $field['type'] === "stats" && isset( $field['stats'] ) && ! empty( $field['stats'] ) ) {
                                                $statsHtml = "<div class=\"community-stats\">";

                                                foreach ( $field['stats'] as $stat ) {
                                                    $imageUrl = wp_get_attachment_image_url( $stat['image'], 'large' );
                                                    $statTitleStyle = $imageUrl ? "style=\"background-image: url($imageUrl)\"" : "";
                                                    $statItems = "";

                                                    if ( isset( $stat['child'] ) ) {
                                                        foreach ( $stat['child'] as $subStat ) {
                                                            $statItems .= "<div class=\"community-stat-item\">"
                                                                . ( $subStat[ 'number' ] ? "<span>" . $subStat[ 'number' ] . "</span>" : "" ) .
                                                                ( $subStat[ 'description' ] ? "<span>" . $subStat[ 'description' ] . "</span>" : "" ) .
                                                            "</div>";
                                                        }
                                                    }

                                                    $statsHtml .= "<div class=\"community-stat\">
                                                        <div class=\"community-stat-title\">
                                                            <div class=\"community-stat-title-img\" $statTitleStyle></div>
                                                            <span>" . ( $stat[ 'title' ] ? $stat[ 'title' ] : "" ) . "</span>
                                                        </div>
                                                        <div class=\"community-stat-items\">
                                                            $statItems
                                                        </div>
                                                    </div>";
                                                }
                                                
                                                $statsHtml .= "</div>";
                                                $content .= $statsHtml;
                                                
                                            }
                                    
                                        $content .= "</div>";
                                    }
                                    
                                    $content .= "</div>";
                                }
                            }
                        ?>

                        <div class="community-tabs">
                            <div class="community-tabs-sticky" data-margin-top="120">
                                <div class="community-title">Table of Contents</div>
                                <ul>
                                    <?php
                                        foreach ( $tabs as $k => $v ) {
                                            echo "<li><button type=\"button\" data-id=\"$k\" class=\"" . ( $k === "introduction" ? "tab-active": "" ) . "\">$v</button></li>";
                                        }
                                    ?>
                                </ul>

                                <?php 
                                    if ( ! empty( do_shortcode( '[ai_client_email_text]' ) ) ) {
                                        echo do_shortcode( '[ai_client_email class="community-email"]<span class="ai-font-envelope-filled-a"></span> Inquiries?<br />
    send us a message[/ai_client_email]' );
                                    }
                                ?>
                            </div>
                        </div>
                        
                        <div class="community-content">
                            <?php echo $content; ?>

                            <?php if (!empty($aios_display_cta)) : ?>
                                <div class="community-cta">
                                    <div class="siteButton">
                                        <a href="<?= $aios_cta_link ? $aios_cta_link : '#featuredproperties' ?>" <?= !empty($aios_cta_new_tab) ? 'target="_blank"' : '' ?> <?= $aios_cta_link ? '' : 'class="aios-communities-scroll-to"' ?> > <span><?= $aios_cta_title ? $aios_cta_title : 'View ' . get_the_title() . ' Listings' ?></span></a>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <?php if (!empty($aios_communities_shortcode)) : ?>
                                <div class="community-properties" id="aios-communities-scroll-to">
                                    <?=do_shortcode( $aios_communities_shortcode )?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <?php do_action('aios_starter_theme_after_entry_content') ?>

                </div>

            <?php endwhile; ?>

        <?php endif; ?>

        <?php do_action('aios_starter_theme_after_inner_page_content') ?>

    </article><!-- end #content -->

</div><!-- end #content-full -->


<?php get_footer(); ?>