<div class="aios-shortcode">
	<?php
		$partner_shortcodes = [
			[
				'title' 		=> 'Client Partner Photo',
				'description' 	=> 'Returns the value of Client Partner Photo',
				'shortcode' 	=> '[ai_client_partner_photo]'
			],
			[
				'title' 		=> 'Client Partner Name',
				'description' 	=> 'Returns the value of Client Partner Name',
				'shortcode' 	=> '[ai_client_partner_name]'
			],
			[
				'title' 		=> 'Client Partner Address',
				'description' 	=> 'Returns the value of Client Partner Address',
				'full_description' => '
					Attribute Value
					<ul>
						<li>compact - 1 line address: default</li>
						<li>full - 4 lines address</li>
						<li>street - street number</li>
						<li>unit - unit number</li>
						<li>city - city number</li>
						<li>state - state number</li>
						<li>zip - zip number</li>
						<li>country - country number</li>
					</ul>',
				'shortcode' 	=> '[ai_client_partner_address type=\'compact\']'
			],
			[
				'title' 		=> 'Client Partner Email',
				'description' 	=> 'Returns the value of obfuscated Client Partner Email, {default-email} will return the given email',
				'shortcode' 	=> '[ai_client_partner_email]{default-email}[/ai_client_partner_email]',
				'plain_text' 	=> '[ai_client_partner_email_text]'
			],
			[
				'title' 		=> 'Client Partner Phone Number',
				'description' 	=> 'Returns the value of Client Partner Phone Number',
				'shortcode' 	=> '[ai_client_partner_phone]{default-phone}[/ai_client_partner_phone]',
				'plain_text' 	=> '[ai_client_partner_phone_text]',
				'country_code' 	=> '[ai_client_partner_country_code_phone_text]'
			],
			[
				'title' 		=> 'Client Partner Cell Number',
				'description' 	=> 'Returns the value of Client Partner Cell Number',
				'shortcode' 	=> '[ai_client_partner_cell]{default-cell}[/ai_client_partner_cell]',
				'plain_text' 	=> '[ai_client_partner_cell_text]',
				'country_code' 	=> '[ai_client_partner_country_code_cell_text]'
			],
			[
				'title' 		=> 'Client Partner Fax Number',
				'description' 	=> 'Returns the value of Client Partner Fax Number',
				'shortcode' 	=> '[ai_client_partner_fax]{default-fax}[/ai_client_partner_fax]',
				'plain_text' 	=> '[ai_client_partner_fax_text]',
				'country_code' 	=> '[ai_client_partner_country_code_fax_text]'
			],
			[
				'title' 		=> 'Client Partner Facebook',
				'description' 	=> 'Returns the value of Client Partner Facebook',
				'shortcode' 	=> '[ai_client_partner_facebook]'
			],
			[
				'title' 		=> 'Client Partner Twitter',
				'description' 	=> 'Returns the value of Client Partner Twitter',
				'shortcode' 	=> '[ai_client_partner_twitter]'
			],
			[
				'title' 		=> 'Client Partner Google Business',
				'description' 	=> 'Returns the value of Client Partner Google Business',
				'shortcode' 	=> '[ai_client_partner_google_business]'
			],
			[
				'title' 		=> 'Client Partner LinkedIn',
				'description' 	=> 'Returns the value of Client Partner LinkedIn',
				'shortcode' 	=> '[ai_client_partner_linkedin]'
			],
			[
				'title' 		=> 'Client Partner YouTube',
				'description' 	=> 'Returns the value of Client Partner YouTube',
				'shortcode' 	=> '[ai_client_partner_youtube]'
			],
			[
				'title' 		=> 'Client Partner Instagram',
				'description' 	=> 'Returns the value of Client Partner Instagram',
				'shortcode' 	=> '[ai_client_partner_instagram]'
			],
			[
				'title' 		=> 'Client Partner Pinterest',
				'description' 	=> 'Returns the value of Client Partner Pinterest',
				'shortcode' 	=> '[ai_client_partner_pinterest]'
			],
			[
				'title' 		=> 'Client Partner Trulia',
				'description' 	=> 'Returns the value of Client Partner Trulia',
				'shortcode' 	=> '[ai_client_partner_trulia]'
			],
			[
				'title' 		=> 'Client Partner Zillow',
				'description' 	=> 'Returns the value of Client Partner Zillow',
				'shortcode' 	=> '[ai_client_partner_zillow]'
			],
			[
				'title' 		=> 'Client Partner Houzz',
				'description' 	=> 'Returns the value of Client Partner Houzz',
				'shortcode' 	=> '[ai_client_partner_houzz]'
			],
			[
				'title' 		=> 'Client Partner Blogger',
				'description' 	=> 'Returns the value of Client Partner Blogger',
				'shortcode' 	=> '[ai_client_partner_blogger]'
			],
			[
				'title' 		=> 'Client Partner Yelp',
				'description' 	=> 'Returns the value of Client Partner Yelp',
				'shortcode' 	=> '[ai_client_partner_yelp]'
			],
			[
				'title' 		=> 'Client Partner Skype',
				'description' 	=> 'Returns the value of Client Partner Skype',
				'shortcode' 	=> '[ai_client_partner_skype]'
			],
			[
				'title' 		=> 'Client Partner Caimeiju',
				'description' 	=> 'Returns the value of Client Partner Caimeiju',
				'shortcode' 	=> '[ai_client_partner_caimeiju]'
			],
			[
				'title' 		=> 'Client Partner RSS link',
				'description' 	=> 'Returns the value of Client Partner RSS link',
				'shortcode' 	=> '[ai_client_partner_rss]'
			],
			[
				'title' 		=> 'Client Partner Cameo',
				'description' 	=> 'Returns the value of Client Partner Cameo',
				'shortcode' 	=> '[ai_client_partner_cameo]'
			],
			[
				'title' 		=> 'Client Partner TikTok',
				'description' 	=> 'Returns the value of Client Partner TikTok',
				'shortcode' 	=> '[ai_client_partner_tiktok]'
			],
			[
				'title' 		=> 'Client Google Map',
				'description' 	=> 'Returns the value of Client Partner Google Map',
				'shortcode' 	=> '[ai_client_partner_gmap]'
			]
		];

		foreach ( $partner_shortcodes as $shortcode => $value ) {
			$output = '<div class="wpui-row wpui-row-box">
				<div class="wpui-col-md-3">
					<p class="mt-0"><span class="wpui-settings-title">' . $value['title'] . '</span> ' . $value['description'] . '</p>
				</div>
				<div class="wpui-col-md-9">
					<input type="text" class="auto-highlight widefat" readonly value="' . $value['shortcode'] . '">';

				if( ! empty( $value['plain_text'] ) ) {
					$output .= '<p class="mt-3">Plain Text</p>
						<input type="text" class="auto-highlight widefat" readonly value="' . $value['plain_text'] . '">';
				}

				if( ! empty( $value['country_code'] ) ) {
					$output .= '<p class="mt-3">Country Code</p>
						<input type="text" class="auto-highlight widefat" readonly value="' . $value['country_code'] . '">';
				}

				if( ! empty( $value['full_description'] ) ) {
					$output .= '<p class="mt-3">' . $value['full_description'] . '</p>';
				}

			$output .= '
				</div>
			</div>';

			echo $output;
		}
	?>
</div>
