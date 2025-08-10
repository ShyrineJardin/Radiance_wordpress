jQuery(document).ready(function() {
    jQuery('.ai-minimalist-testimonial').not('.slick-initialized').slick({
        infinite: true,
        dots: false,
        arrows: true,
        nextArrow: '<span class="ai-minimalist-testimonial-arrow ai-minimalist-testimonial-arrow-prev ai-font-arrow-b-n"></span>',
        prevArrow: '<span class="ai-minimalist-testimonial-arrow ai-minimalist-testimonial-arrow-next ai-font-arrow-b-p"></span>',
        slidesToShow: 1,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 5000,
        fade: true,
        swipe: true,
    });
});
