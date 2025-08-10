<!-- Added: Version 3.9.8 -->
<div class="aios-shortcode">
	<div class="wpui-row wpui-row-box">
		<div class="wpui-col-md-3">
			<p class="mt-0"><span class="wpui-settings-title">Post Type Custom Title/Banner</span></p>
		</div>
		<div class="wpui-col-md-9">
            <p>Lists of post meta field, to get meta field ex.<em> get_post_meta( $post_id, 'aios_custom_metabox', true )</em></p>
            <ul>
				<li><strong>aioscm_used_custom_title</strong> - Value of checkbox if used for custom title.</li>
				<li><strong>aioscm_main_title</strong> - Main Title</li>
				<li><strong>aioscm_sub_title</strong> - Sub Title</li>
                <li>
                    <strong>aioscm_banner</strong> - This return image ID instead URL, use "wp_get_attachment_image_url( $imgID, 'size' )" to get URL. Lists of available image sizes:
                    <?=get_image_sizes_output()?>
                </li>
            </ul>
            <p><strong>Add this to Posts, Page, Custom Post Type(Single), and Custom Template:</strong></p>
            <textarea class="auto-highlight" readonly style="height: 470px !important">&lt;?php
	$aioscm_used_custom_title = get_post_meta( get_the_ID(), 'aioscm_used_custom_title', true );
	$aioscm_main_title = get_post_meta( get_the_ID(), 'aioscm_main_title', true );
	$aioscm_sub_title = get_post_meta( get_the_ID(), 'aioscm_sub_title', true );
	$aioscm_banner_id = get_post_meta( get_the_ID(), 'aioscm_banner', true ); /** Return image ID */
    $aioscm_banner_id = !empty( $aioscm_banner_id ) ? $aioscm_banner_id : get_option( 'aios-metaboxes-default-banner-image', '' );
	$aioscm_banner = ( !empty( $aioscm_banner_id ) ? wp_get_attachment_image_url( $aioscm_banner_id, get_option( 'aios-metaboxes-default-banner-size', 'full' ) ) : '' );
?&gt;

<div id="hero" style="background-image: url(&lt;?=$aioscm_banner?&gt;);">
	<h1>
		&lt;?php 
			if( $aioscm_used_custom_title == 1 ) {
				echo $aioscm_main_title . '<em>' . $aioscm_sub_title . '</em>';
			} else {
				echo get_the_title();
			}
		?&gt;
	</h1>
</div></textarea>
		</div>
    </div>
</div>

<!-- Added: Version 3.9.8 -->
<div class="aios-shortcode">
	<div class="wpui-row wpui-row-box">
		<div class="wpui-col-md-3">
			<p class="mt-0"><span class="wpui-settings-title">Taxonomies Custom Title/Banner</span></p>
		</div>
		<div class="wpui-col-md-9">
            <ul>
				<li><strong>get_queried_object()</strong> - to get array of values of current taxonomy.</li>
				<li><strong>get_option()</strong> - get save options of taxonomy. ex: <em>get_option( "term_meta_" . $taxonomy_id )</em></li>
                <li>
                    <strong>For Banner</strong> - This return image ID instead URL, use "wp_get_attachment_image_url( $imgID, 'size' )" to get URL. Lists of available image sizes:
                    <?=get_image_sizes_output()?>
                </li>
            </ul>
            <p><strong>Add this to Archives:</strong></p>
            <textarea class="auto-highlight" readonly style="height: 470px !important">&lt;?php
	$post = $posts[0]; /** Hack. Set $post so that the_date() works. */
	$taxonomy_id = get_queried_object()->term_id;
	$taxonomy_name = get_queried_object()->name;
	$taxonomy_meta = get_option( "term_meta_" . $taxonomy_id );
	$taxonomy_banner = !empty( $taxonomy_meta['banner'] ) ? wp_get_attachment_image_url( $taxonomy_meta['banner'], get_option( 'aios-metaboxes-default-banner-size', 'full' ) ) : ( !empty( get_option( 'aios-metaboxes-default-banner-image', '' ) ) ? get_option( 'aios-metaboxes-default-banner-image', '' ) : '' );
?&gt;

<div id="hero" style="background-image: url(&lt;?=$taxonomy_banner?&gt;);">
	<h1 class="archive-title">
		 &lt;?php 
			if( $taxonomy_meta['used_custom_title'] == 1 ) {
				echo $taxonomy_meta['main_title'] . '<em>' . $taxonomy_meta['sub_title'] . '</em>';
			} else {
				echo $taxonomy_name;
			}
		?&gt;
	</h1>
</div></textarea>
		</div>
    </div>
</div>