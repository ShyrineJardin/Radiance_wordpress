export default function Prerequisite() {
    const btn = jQuery('.auto-generate-page-classic-prerequisite'),
        btnClose = jQuery('.agp-prerequisite-frame-close');

    btn.on('click', function(e) {
        e.preventDefault();

        const currentEl = jQuery(this);

        jQuery('.agp-prerequisite-frame').removeClass('agp-prerequisite-frame-open');
        // currentEl.parent().find('.agp-prerequisite-frame').addClass('agp-prerequisite-frame-open');
        jQuery('.agp-prerequisite-frame').addClass('agp-prerequisite-frame-open');
    });

    btnClose.on('click', function(e) {
        e.preventDefault();

        const currentEl = jQuery(this);
        currentEl.parents('.agp-prerequisite-frame').removeClass('agp-prerequisite-frame-open');
    });
};
