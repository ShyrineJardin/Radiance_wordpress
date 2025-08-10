<?php

use AIOS\Communities\Controllers\Options;

$video_url                      = get_post_meta($post_id, 'aios_communities_video_url', true);
$listing_title                  = get_post_meta($post_id, 'aios_communities_listing_title', true);
$listing_subtitle               = get_post_meta($post_id, 'aios_communities_listing_subtitle', true);
$post_featured                  = get_post_meta($post_id, 'aios_communities_featured', true);
$aios_communities_shortcode     = get_post_meta($post_id, 'aios_communities_shortcode', true);
$aios_idxBrokerLink             = get_post_meta($post_id, 'aios_communities_idxBrokerLink', true);
$aios_idxBrokerLinkNewTab       = get_post_meta($post_id, 'aios_communities_idxBrokerLinkNewTab', true);
$aios_cta_title                 = get_post_meta($post_id, 'cta_title', true);
$aios_cta_link                  = get_post_meta($post_id, 'cta_link', true);
$aios_cta_new_tab               = get_post_meta($post_id, 'cta_new_tab', true);
$aios_display_cta               = get_post_meta($post_id, 'display_cta', true);
$aios_layout                    = get_post_meta($post_id, 'aios_communities_layout', true);
$communities_settings           = Options::options();
if (!empty($communities_settings)) extract($communities_settings);

?>

<div class="wpui-row wpui-row-box aios-communities-simplified">
    <div class="wpui-col-md-3">
        <p><span class="wpui-settings-title">Video URL</span></p>
    </div>

    <div class="wpui-col-md-9">
        <div class="form-group">
            <input type="text" name="aios_communities_video_url" value="<?= $video_url ?>">
        </div>
    </div>
</div>

<div class="wpui-row wpui-row-box">
    <div class="wpui-col-md-3">
        <p><span class="wpui-settings-title">Set as Featured</span></p>
    </div>

    <div class="wpui-col-md-9">
        <div class="form-group">
            <div class="form-checkbox-group form-toggle-switch">
                <div class="form-checkbox">
                    <label>
                        <input type="checkbox" value="yes" name="aios_communities_featured" class="hidden" <?= $post_featured == "yes" ? 'checked' : '' ?>>
                    </label>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="wpui-row wpui-row-box aios-communities-simplified aios-communities-cta">
    <div class="wpui-col-md-3">
        <p><span class="wpui-settings-title">CTA</span></p>
    </div>

    <div class="wpui-col-md-9">
        <div class="wpui-row">

            <div class="wpui-col-md-12">
                <div class="form-checkbox-group form-toggle-switch">
                    <div class="form-checkbox">
                        <label>
                            <input type="checkbox" value="yes" name="display_cta" class="hidden" <?= $aios_display_cta == "yes" ? 'checked' : '' ?>> Display CTA
                        </label>
                    </div>
                </div>
            </div>

            <div class="wpui-col-md-6">
                <div class="form-group">
                    <label for="cta_title">CTA Title</label>
                    <input type="text" id="cta_title" name=" cta_title" value="<?= $aios_cta_title ?>" placeholder="View Available Listings">
                </div>
            </div>
            <div class="wpui-col-md-6">
                <div class="form-group">
                    <label for="cta_link">CTA Link</label>
                    <input type="text" id="cta_link" name=" cta_link" value="<?= $aios_cta_link ?>" placeholder="https://">
                </div>
                <div class="form-checkbox form-checkbox-custom">
                    <label>
                        <input type="checkbox" value="yes" name="cta_new_tab" class="hidden" <?= $aios_cta_new_tab == "yes" ? 'checked' : '' ?>>New Tab
                    </label>
                </div>
            </div>
            <div class="wpui-col-md-12">
                <p> Note: The field placeholder will serve as the default CTA title, and if the CTA link is left empty, it will automatically anchor to the available listing.</p>
            </div>
        </div>
    </div>
</div>


<div class="wpui-row wpui-row-box aios-communities-simplified">
    <div class="wpui-col-md-3">
        <p><span class="wpui-settings-title">Content</span></p>
    </div>
    <div class="wpui-col-md-9">
        <?php
        $post      = get_post($post_id, OBJECT, 'edit');
        $content   = $post->post_content;
        $editor_id = 'content';

        wp_editor($content, $editor_id);
        ?>
    </div>
</div>

<div class="wpui-row wpui-row-box">
    <div class="wpui-col-md-3">
        <p><span class="wpui-settings-title">Listing Shortcode</span></p>
    </div>

    <div class="wpui-col-md-9">
        <div class="form-group">
            <div class="form-checkbox-group form-toggle-switch">
                <div class="form-checkbox">
                    <textarea name="aios_communities_shortcode" rows="" cols=""><?= $aios_communities_shortcode ?></textarea>
                    <em>Supports: Ihomefinder, IDX Broker, AIOS Listings, or any type of Shortcode</em>

                </div>
            </div>
        </div>
    </div>
</div>

<div class="wpui-row wpui-row-box aios-communities-simplified">
    <div class="wpui-col-md-3">
        <p><span class="wpui-settings-title">IDX Broker Search Link</span></p>
    </div>

    <div class="wpui-col-md-9">
        <div class="form-group">
            <input type="text" name="aios_communities_idxBrokerLink" value="<?= $aios_idxBrokerLink ?>">
        </div>

        <div class="form-checkbox-group">
            <div class="form-checkbox">
                <label>
                    <input type="checkbox" value="yes" name="aios_communities_idxBrokerLinkNewTab" class="hidden" <?= $aios_idxBrokerLinkNewTab == "yes" ? 'checked' : '' ?>> New Tab.
                </label>
            </div>
        </div>

    </div>
</div>

<div class="wpui-row wpui-row-box aios-communities-simplified">
    <div class="wpui-col-md-3">
        <p><span class="wpui-settings-title">Listing Title</span></p>
    </div>

    <div class="wpui-col-md-9">
        <div class="form-group">
            <input type="text" name="aios_communities_listing_title" value="<?= $listing_title ?>">
        </div>
    </div>
</div>

<div class="wpui-row wpui-row-box aios-communities-simplified">
    <div class="wpui-col-md-3">
        <p><span class="wpui-settings-title">Listing subtitle</span></p>
    </div>

    <div class="wpui-col-md-9">
        <div class="form-group">
            <input type="text" name="aios_communities_listing_subtitle" value="<?= $listing_subtitle ?>">
        </div>
    </div>
</div>



<div class="wpui-row wpui-row-box">
    <div class="wpui-col-md-3">
        <p><span class="wpui-settings-title">Layout Content Writing</span></p>
    </div>

    <div class="wpui-col-md-9">
        <div class="form-group">
            <div class="form-checkbox-group form-toggle-switch">
                <div class="form-checkbox">
                    <label>
                        <input type="checkbox" value="yes" name="aios_communities_layout" class="hidden" <?= $aios_layout == "yes" ? 'checked' : '' ?>>
                    </label>
                </div>
            </div>
        </div>
    </div>
</div>