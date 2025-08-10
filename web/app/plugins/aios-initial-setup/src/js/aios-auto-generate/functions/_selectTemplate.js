export default function SelectTemplate() {
	const btn = jQuery('.auto-generate-page-classic-editor');

	btn.on('click', function(e) {
		e.preventDefault();

		request(jQuery(this));
	});

	function request(currentEl) {
		const id = currentEl.data('id');
		const name = currentEl.data('name');
		const type = currentEl.data('type');

		currentEl.attr('disabled', 'disabled');
		Swal.fire({
			type: 'warning',
			title: "Are you sure you want to override the content?",
			text: "This will generate content and form.",
			showCancelButton: true,
			confirmButtonText: "Yes!",
		}).then((result) => {
			if (result.value === true) {
				Swal.fire({
					type: 'warning',
					title: "Auto Generate is in Progress",
					showConfirmButton: false,
				});

				// AJAX
				const request = jQuery.ajax({
					url: `${data.baseUrl}/wp-json/aios-auto-generate-page/v1/generate`,
					type: 'post',
					data: {
						id: id,
						name: name,
						type: type,
					},
					headers: {
						'Accept': 'application/json',
						'X-Requested-With': 'XMLHttpRequest',
						'X-WP-Nonce': data.nonce,
					}
				});

				request.done(function(data) {
					Swal.fire({
						type: data['status'],
						title: data['message'],
						showConfirmButton: false,
						timer: 1500,
					});

					if (data['edit'] !== null && data['edit'] !== undefined) {
						setTimeout(function() {
							window.location.href = '/wp-admin/post.php?post=' + data['edit_id'] + '&action=edit&classic-editor'
						}, 1000);
					}
				});

				request.fail(function(xhr, textStatus, errorThrown) {
					Swal.fire(
						xhr.responseJSON.message,
						'We can\'t process your request.',
						'error'
					)
				});

				currentEl.removeAttr('disabled')
			} else {
				currentEl.removeAttr('disabled')
			}
		});
	}
};
