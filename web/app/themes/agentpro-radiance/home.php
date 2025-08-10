<?php get_header(); ?>
<section class="hero">
    <div class="hero__container">
        <div class="hero__slideshow">
            <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Home: Slider") ) : ?><?php endif ?>
        </div>
    </div><!-- end of hero container -->
</section><!-- end of hero  -->

<section class="quicksearch">
    <div class="quicksearch__container site-container">
        <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Home: Quick Search") ) : ?><?php endif ?>
    </div> <!--- end of of quick search container -->
</section><!-- end of quick search section -->
<section class="provenPerformance">
    <div class="provenPerformance__container site-container">
        <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Home: Proven Performance") ) : ?><?php endif ?>
    </div><!-- end of proven performance container -->
</section><!-- end of proven performance section -->

<section class="hpProperties">
    <div class="hpProperties__container site-container">
        <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Home: Featured Properties") ) : ?><?php endif ?>
    </div><!-- end of container -->
</section> <!-- end of hp properties -->

<section class="hpWelcome">
    <div class="hpWelcome__container site-container">
        <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Home: Welcome") ) : ?><?php endif ?>
    </div><!-- end of container -->
</section><!-- end of hp welcome -->

<section class="hpFeaturedCommunities">
    <div class="hpFeaturedCommunities__container site-container">
        <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Home: Featured Communities") ) : ?><?php endif ?>
    </div><!-- end of container -->

</section><!-- end of communities -->
<section class="hpreviews">
    <div class="hpreviews__container site-container">
        <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Home: Reviews") ) : ?><?php endif ?>
    </div>
</section><!-- end of reviews -->

<section class="hpcta">
    <div class="hpcta__container site-container">
        <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Home: Call to Action") ) : ?><?php endif ?>
    </div>
</section><!-- end of cta -->

<section class="hpLatestNews">
    <div class="hpLatestNews__container site-container">
        <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Home: Latest News") ) : ?><?php endif ?>
    </div>
</section><!-- end of latest news -->

<section class="socialFb">
    <div class="socialFb__container site-container">
        <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Home: Facebook") ) : ?><?php endif ?>
    </div>
</section>


<section class="socialIg">
    <div class="socialIg__container site-container">
        <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Home: Instagram") ) : ?><?php endif ?>
    </div>
</section><!-- end of instagram -->

<?php get_footer(); ?>