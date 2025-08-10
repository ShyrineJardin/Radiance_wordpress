(function ($, w, d, h, b) {

    const init = {
        commaSeparateNumber: function(val){
            while (/(\d+)(\d{3})/.test(val.toString())) {
                val = val.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
            }
            return val;
        },
		provenPerformance: function() {

            if ($('body').hasClass('home')) {
                function isScrolledIntoView(elem) {
                    const docViewTop = jQuery(window).scrollTop();
                    let docViewBottom = docViewTop + jQuery(window).height();

                    let elemTop = jQuery(elem).offset().top - 50;
                    let elemBottom = elemTop + jQuery(elem).height();

                    return elemBottom <= docViewBottom && elemTop >= docViewTop;
                }

                let shown = false;

                $(w).scroll(function () {
                    const myelement = $(".provenPerformance");
                    if (isScrolledIntoView(myelement)) {
                        if (!shown) {
                            $(".provenPerformance__items span").each(function () {
                                const $this = $(this);
                                const limit = parseInt($this.attr("data-number"));

                                $({ Counter: 0 }).animate(
                                    { Counter: limit },
                                    {
                                        duration: 1000,
                                        easing: "swing",
                                        step: function () {
											$this.text(init.commaSeparateNumber(Math.ceil(this.Counter)));
                                        },
                                    }
                                );
                            });
                        }
                        shown = true;
                    }
                });
            }
        },
        properties: function(){

            if (typeof Splide !== "undefined") {
                const block = "hpProperties";

                let $featuredProperties = new Splide(`.${block}__items`, {
                    type: "loop",
                    pagination: false,
                    arrows: true,
                    grid: {
                        cols: 2,
                        rows: 2,
                        gap: {
                            row: "16px",
                            col: "16px",
                        }, 

                    },
                    breakpoints: {
                        744: {
                            grid: {
                                cols: 1,
                                rows: 4,
                                gap: {
                                    row: "30px",
                                    col: "30px",
                                },
                            },
                        },
                        600: {
                            grid: {
                                gap: {
                                    row: "16px",
                                    col: "16px",
                                },
                            }
                        }
                    },
                });
                $featuredProperties.mount(window.splide.Extensions);
            } else {
                console.warn("Splide is not defined.");
            }

        },
        communities: function(){
            if (typeof Splide !== "undefined") {
                const block = 'hpFeaturedCommunities'

                let $communities = new Splide(`.${block}__items`, {
                    type: "loop",
                    pagination: false,
                    arrows: true,
                    grid: {
                        cols: 3,
                        rows: 2,
                        gap: {
                            row: "22px",
                            col: "22px",
                        }, 
                    },
                    breakpoints: {
                        744: {
                            grid: {
                                cols: 2,
                                rows: 3,
                                gap: {
                                    row: "42px",
                                    col: "42px",
                                },
                            },
                        },
                        600: {
                            grid: {
                                cols: 1,
                                rows: 1,
                            },
                        },
                    },
                });
                
                $communities.mount(window.splide.Extensions);
            } else {
                console.warn("Splide is not defined.");
            }
        },
        testimonials: function(){
            if (typeof Splide !== "undefined") {
                const block = 'hpreviews'

                let $testimonials = new Splide(`.${block}__items`, {
                    type: "loop",
                    pagination: false,
                    arrows: true,
                });
                
                $testimonials.mount(window.splide.Extensions);
            } else {
                console.warn("Splide is not defined.");
            }
            
        },

    }

    $(document).ready(function () {
        init.provenPerformance();
        init.properties();
        init.communities();
        init.testimonials();
    });

    $(window).on('load', function () {


    })


})(jQuery, window, document, 'html', 'body');