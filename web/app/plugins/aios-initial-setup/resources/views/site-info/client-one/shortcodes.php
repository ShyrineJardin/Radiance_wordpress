<div class="aios-shortcode">
	<?php
		$shortcodes = [

			[
				'title' 		=> 'Client Photo',
				'description' 	=> 'Returns the value of Client Photo',
				'shortcode' 	=> '[ai_client_photo]'
			],
			[
				'title' 		=> 'Company Name',
				'description' 	=> 'Returns the value of Company Name',
				'shortcode' 	=> '[ai_company_name]'
			],
			[
				'title' 		=> 'Client Name',
				'description' 	=> 'Returns the value of Client Name',
				'shortcode' 	=> '[ai_client_name]'
			],
			[
				'title' 		=> 'Client Address',
				'description' 	=> 'Returns the value of Client Address',
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
				'shortcode' 	=> '[ai_client_address type=\'compact\']'
			],
			[
				'title' 		=> 'Client Email',
				'description' 	=> 'Returns the value of obfuscated Client Email, {default-email} will return the given email',
				'shortcode' 	=> '[ai_client_email]{default-email}[/ai_client_email]',
				'plain_text' 	=> '[ai_client_email_text]'
			],
			[
				'title' 		=> 'Client Phone Number',
				'description' 	=> 'Returns the value of Client Phone Number',
				'shortcode' 	=> '[ai_client_phone]{default-phone}[/ai_client_phone]',
				'plain_text' 	=> '[ai_client_phone_text]',
				'country_code' 	=> '[ai_client_country_code_phone_text]'
			],
			[
				'title' 		=> 'Client Cell Number',
				'description' 	=> 'Returns the value of Client Cell Number',
				'shortcode' 	=> '[ai_client_cell]{default-cell}[/ai_client_cell]',
				'plain_text' 	=> '[ai_client_cell_text]',
				'country_code' 	=> '[ai_client_country_code_cell_text]'
			],
			[
				'title' 		=> 'Client Fax Number',
				'description' 	=> 'Returns the value of Client Fax Number',
				'shortcode' 	=> '[ai_client_fax]{default-fax}[/ai_client_fax]',
				'plain_text' 	=> '[ai_client_fax_text]',
				'country_code' 	=> '[ai_client_country_code_fax_text]'
			],
			[
				'title' 		=> 'Client Facebook',
				'description' 	=> 'Returns the value of Client Facebook',
				'shortcode' 	=> '[ai_client_facebook]'
			],
			[
				'title' 		=> 'Client Twitter',
				'description' 	=> 'Returns the value of Client Twitter',
				'shortcode' 	=> '[ai_client_twitter]'
			],
			[
				'title' 		=> 'Client Google Business',
				'description' 	=> 'Returns the value of Client Google Business',
				'shortcode' 	=> '[ai_client_google_business]'
			],
			[
				'title' 		=> 'Client LinkedIn',
				'description' 	=> 'Returns the value of Client LinkedIn',
				'shortcode' 	=> '[ai_client_linkedin]'
			],
			[
				'title' 		=> 'Client YouTube',
				'description' 	=> 'Returns the value of Client YouTube',
				'shortcode' 	=> '[ai_client_youtube]'
			],
			[
				'title' 		=> 'Client Instagram',
				'description' 	=> 'Returns the value of Client Instagram',
				'shortcode' 	=> '[ai_client_instagram]'
			],
			[
				'title' 		=> 'Client Pinterest',
				'description' 	=> 'Returns the value of Client Pinterest',
				'shortcode' 	=> '[ai_client_pinterest]'
			],
			[
				'title' 		=> 'Client Trulia',
				'description' 	=> 'Returns the value of Client Trulia',
				'shortcode' 	=> '[ai_client_trulia]'
			],
			[
				'title' 		=> 'Client Zillow',
				'description' 	=> 'Returns the value of Client Zillow',
				'shortcode' 	=> '[ai_client_zillow]'
			],
			[
				'title' 		=> 'Client Houzz',
				'description' 	=> 'Returns the value of Client Houzz',
				'shortcode' 	=> '[ai_client_houzz]'
			],
			[
				'title' 		=> 'Client Blogger',
				'description' 	=> 'Returns the value of Client Blogger',
				'shortcode' 	=> '[ai_client_blogger]'
			],
			[
				'title' 		=> 'Client Yelp',
				'description' 	=> 'Returns the value of Client Yelp',
				'shortcode' 	=> '[ai_client_yelp]'
			],
			[
				'title' 		=> 'Client Skype',
				'description' 	=> 'Returns the value of Client Skype',
				'shortcode' 	=> '[ai_client_skype]'
			],
			[
				'title' 		=> 'Client Caimeiju',
				'description' 	=> 'Returns the value of Client Caimeiju',
				'shortcode' 	=> '[ai_client_caimeiju]'
			],
			[
				'title' 		=> 'Client RSS link',
				'description' 	=> 'Returns the value of Client RSS link',
				'shortcode' 	=> '[ai_client_rss]'
			],
			[
				'title' 		=> 'Client Cameo',
				'description' 	=> 'Returns the value of Client Cameo',
				'shortcode' 	=> '[ai_client_cameo]'
			],
			[
				'title' 		=> 'Client TikTok',
				'description' 	=> 'Returns the value of Client TikTok',
				'shortcode' 	=> '[ai_client_tiktok]'
			],
			[
				'title' 		=> 'Client Google Map',
				'description' 	=> 'Returns the value of Client Google Map',
				'shortcode' 	=> '[ai_client_gmap]'
			]
		];

		foreach ( $shortcodes as $shortcode => $value ) {
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
