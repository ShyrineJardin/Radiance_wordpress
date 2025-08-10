<?php get_header();

    use AIOS\Communities\Controllers\Options;
    use AIOS\Communities\Func\aios_communities_details_page_template_ap_legacy;

    // Communities Settings From Option Page
    $communities_settings 		= Options::options();
    if( !empty( $communities_settings ) ) extract( $communities_settings );

    $post_id =  get_the_ID();
    $title = the_title();
    $content = the_content();
    $permalink = the_permalink();
    $featuredImage = get_the_post_thumbnail_url( $post_id, 'full' );
  

?>
asdasda
<?php get_footer(); ?>