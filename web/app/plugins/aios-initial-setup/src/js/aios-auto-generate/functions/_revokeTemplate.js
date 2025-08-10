export default function RevokeTemplate() {
    const btn = jQuery('#auto-generate-revoke-classic-editor');

    btn.on('click', function(e) {
        e.preventDefault();

        const currentEl = jQuery(this);
        const id = currentEl.data('id');

        currentEl.attr('disabled', 'disabled');

        Swal.fire({
            type: 'warning',
            title: "Revoke preset template?",
            text: "",
            showCancelButton: true,
            confirmButtonText: "Yes!",
        }).then((result) => {
            if (result.value === true) {
                // AJAX
                const request = jQuery.ajax({
                    url: `${data.baseUrl}/wp-json/aios-auto-generate-page/v1/revoke`,
                    type: 'post',
                    data: {
                        id: id,
                    },
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-WP-Nonce': data.nonce,
                    }
                });

                request.done(function(data) {
                    Swal.fire({
                        type: 'success',
                        title: 'Revoked',
                        showConfirmButton: false,
                        timer: 1500,
                    });

                    setTimeout(function() {
                        window.location.reload();
                    }, 1000);
                });

                request.fail(function(xhr, textStatus, errorThrown) {
                    Swal.fire(
                        'Error',
                        'We can\'t process your request.',
                        'error'
                    )
                });

                currentEl.removeAttr('disabled')
            } else {
                currentEl.removeAttr('disabled')
            }
        });
    });
};
