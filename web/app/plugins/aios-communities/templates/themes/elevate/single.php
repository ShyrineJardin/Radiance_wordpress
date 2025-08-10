<?php get_header();

    use AIOS\Communities\Controllers\Options;

    $communities_settings  = Options::options();
    if (!empty($communities_settings)) extract($communities_settings);

    $post_id    = get_the_ID();

    $aios_cta_title             =  get_post_meta($post_id, 'cta_title', true);
    $aios_cta_link              =  get_post_meta($post_id, 'cta_link', true);
    $aios_cta_new_tab           =  get_post_meta($post_id, 'cta_new_tab', true);
    $aios_display_cta           =  get_post_meta($post_id, 'display_cta', true);
    $aios_communities_shortcode = get_post_meta($post_id, 'aios_communities_shortcode', true);
    $listing_title              = get_post_meta($post_id, 'aios_communities_listing_title', true);
    $listing_subtitle           = get_post_meta($post_id, 'aios_communities_listing_subtitle', true);
?>

<div id="<?php echo ai_starter_theme_get_content_id('content-full') ?>">
    <article id="content" class="hfeed community-container">

        <?php do_action('aios_starter_theme_before_inner_page_content') ?>

        <?php if (have_posts()) : ?>

            <?php while (have_posts()) : the_post(); ?>

                <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                    <?php do_action('aios_starter_theme_before_entry_content') ?>

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

                                    if ( isset( $data['title'] ) && ! empty( $data['title'] ) ) {
                                        $tabId = preg_replace( '/[^A-Za-z0-9\-]/', '', strtolower( $data['title'] ) );

                                        if ( ! isset( $data['title_hide'] ) && empty( $data['title_hide'] ) ) {
                                            $contentTitle = "<h2 class=\"uppercase\">" . ( $data['title'] === "Introduction" ? get_the_title() : $data['title'] ) . "</h2>";
                                        }
                                        
                                        if ( ! isset( $data['title_hide_table'] ) && empty( $data['title_hide_table'] ) ) {
                                            $tabs[ $tabId ] = $data['title'];
                                            $tabClass = "entry-not-hidden";
                                        }
                                    }

                                    $entryClass = trim( "community-entry-content $tabClass" );
                                    $content .= "<div class=\"$entryClass\" data-id=\"$tabId\">";
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
                                                        $statCount = 0;

                                                        foreach ( $stat['child'] as $subStat ) {
                                                            if ($statCount !== 0) {
                                                                $statItems .= "<div class=\"community-stat-divider\"></div>";
                                                            }

                                                            $statItems .= "<div class=\"community-stat-item\">"
                                                                . ( $subStat[ 'number' ] ? "<h4>" . $subStat[ 'number' ] . "</h4>" : "" ) .
                                                                ( $subStat[ 'description' ] ? "<span>" . $subStat[ 'description' ] . "</span>" : "" ) .
                                                            "</div>";

                                                            $statCount++;
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
                                <h4 class="community-title">Table of Contents</h4>
                                <ul>
                                    <?php
                                        foreach ( $tabs as $k => $v ) {
                                            echo "<li class=\"" . ( $k === "introduction" ? "tab-active": "" ) . "\"><button type=\"button\"  data-id=\"$k\">$v</button></li>";
                                        }
                                    ?>
                                </ul>

                                <?php 
                                    if ( ! empty( do_shortcode( '[ai_client_email_text]' ) ) ) {
                                        echo do_shortcode( '[ai_client_email class="community-email"]Inquiries?<br /> send us a message[/ai_client_email]' );
                                    }
                                ?>
                            </div>
                        </div>
                        
                        <div class="community-content">
                            <?php echo $content; ?>
                        </div>
                    </div>

                    <?php if (!empty($aios_communities_shortcode)) : ?>
                        <div class="community-listings">
                            <div class="community-heading site-heading uppercase">
                                <h2 class="heading-1">
                                    <small><?=empty($listing_title) ? "Featured" : $listing_title?></small>
                                    <span><?=empty($listing_subtitle) ? "Properties" : $listing_subtitle?></span>
                                </h2>
                            </div>

                            <div class="community-properties">
                                <?=do_shortcode( $aios_communities_shortcode )?>
                            </div>

                            <?php if (!empty($aios_display_cta)) : ?>
                                <div class="site-button community-cta">
                                    <a href="<?= $aios_cta_link ? $aios_cta_link : '#aios-communities-scroll-to' ?>" <?= !empty($aios_cta_new_tab) ? 'target="_blank"' : '' ?> 
                                        <?= $aios_cta_link ? '' : 'class="aios-communities-scroll-to"' ?> > <?= $aios_cta_title ? $aios_cta_title : 'View more ' . get_the_title() . ' listings +' ?>
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                    <?php do_action('aios_starter_theme_after_entry_content') ?>

                </div>

            <?php endwhile; ?>

        <?php endif; ?>

        <?php do_action('aios_starter_theme_after_inner_page_content') ?>

    </article><!-- end #content -->

</div><!-- end #content-full -->


<?php get_footer(); ?>