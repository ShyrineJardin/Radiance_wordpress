<?php

namespace AiosInitialSetup\Resources\Template;

class ContentTemplate
{
    public static function render()
    {
        $about_options = get_option('about_options', []);


        $image_src = isset($about_options['agent_team_photo']) ? wp_get_attachment_image_url($about_options['agent_team_photo'], 'full') : 'https://resources.agentimage.com/images/elevate-agent-photo.jpg';
		$image_meta = isset($about_options['agent_team_photo']) ? wp_get_attachment_metadata($about_options['agent_team_photo']) : '';
		$image_width = isset($image_meta['width']) ? 'width="'.$image_meta['width'].'"' : '';
		$image_height = isset($image_meta['height']) ? 'height="'.$image_meta['height'].'"' : '';

		$image_overlay = isset($about_options['about_overlay_photo']) ? wp_get_attachment_image_url($about_options['about_overlay_photo'], 'full') : 'https://resources.agentimage.com/images/ap-elevate-about-overlay.jpg';
		$sticy_distance = isset($about_options['sticky_distance']) ? $about_options['sticky_distance'] : '160';


        $title = isset($about_options['title']) ? wp_unslash($about_options['title']) : "";
        $subtitle = isset($about_options['subtitle']) ? wp_unslash($about_options['subtitle']) : "";
        $content = wpautop( isset($about_options['content']) ? wp_unslash($about_options['content']) : "" );
		$add_meet = isset($about_options['add_meet']) ?  'meet' : "";
		$button_label	= isset($about_options['button_label']) ? wp_unslash($about_options['button_label']) : "CONTACT OLIVIA SMITH";
		$button_link	= isset($about_options['button_link']) ? wp_unslash($about_options['button_link']) : "/contact";

		
		$contatInfoArrs = [
			array(
				'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" viewBox="0 0 23 23" fill="none" class="svg-phone-icon">
						<g clip-path="url(#clip0_2562_18007)">
						<path d="M2.61128 2.14689C2.04393 2.62507 1.6133 3.24494 1.36317 3.94349C1.11304 4.64203 1.05232 5.39436 1.18719 6.12398C2.0763 9.94388 4.01197 13.4406 6.77715 16.2219C9.55877 18.9873 13.0558 20.923 16.8761 21.8119C17.1425 21.8803 17.4165 21.9151 17.6916 21.9154C18.9062 21.8441 20.0432 21.2949 20.8541 20.3878C21.3396 19.9791 21.6525 19.4019 21.73 18.7721L22.0329 16.5727C22.0665 16.3296 22.0106 16.0826 21.8755 15.8777C21.7404 15.6728 21.5354 15.524 21.2988 15.4591L17.0169 14.2851C16.8166 14.2304 16.6043 14.2386 16.4088 14.3087C16.2134 14.3789 16.0442 14.5075 15.9244 14.6771L14.7994 16.2689C14.7208 16.3751 14.6093 16.4524 14.4823 16.4888C14.3553 16.5252 14.2198 16.5186 14.0969 16.4701C12.4603 15.676 10.9835 14.5878 9.74032 13.2597C8.41229 12.0165 7.32408 10.5398 6.5299 8.90314C6.48141 8.78024 6.47485 8.64476 6.51124 8.51774C6.54763 8.39072 6.62493 8.27927 6.73115 8.20069L8.4044 7.07656C8.57438 6.95682 8.70331 6.78758 8.77362 6.59191C8.84393 6.39624 8.85221 6.18365 8.79732 5.9831L7.62049 1.70223C7.55576 1.46545 7.40702 1.26035 7.20208 1.12525C6.99714 0.990152 6.75002 0.934304 6.5069 0.968143L4.22607 1.27098C3.59623 1.34853 3.01999 1.66144 2.61128 2.14689ZM3.35878 2.75352C3.61931 2.44796 3.98834 2.25554 4.38803 2.21685L6.64682 1.91689C6.6581 1.91723 6.66899 1.92112 6.67794 1.928C6.68688 1.93488 6.69343 1.94441 6.69665 1.95523L7.87157 6.23706C7.87463 6.25168 7.87398 6.26684 7.86965 6.28114L6.16094 7.43114C5.88554 7.63525 5.68491 7.92428 5.59001 8.25368C5.4951 8.58307 5.51119 8.93454 5.63578 9.25389C6.47236 11.0173 7.63479 12.6067 9.06182 13.9382C10.3934 15.3653 11.9827 16.5277 13.7462 17.3643C13.9278 17.4356 14.1212 17.472 14.3164 17.4716C14.5633 17.4703 14.8065 17.4109 15.0263 17.2982C15.2461 17.1855 15.4362 17.0226 15.5814 16.8228L16.7055 15.2301C16.7106 15.223 16.7174 15.2173 16.7252 15.2136C16.7331 15.2099 16.7418 15.2083 16.7505 15.209L16.763 15.2099L21.0439 16.3849C21.0561 16.3882 21.0667 16.3959 21.0738 16.4064C21.0808 16.417 21.0838 16.4298 21.0822 16.4424L20.7842 18.6091C20.7457 19.0099 20.5529 19.3801 20.2465 19.6413L20.1756 19.7112C19.5378 20.43 18.6481 20.876 17.6907 20.9571C17.4954 20.9569 17.301 20.9324 17.1118 20.8842C13.4569 20.0383 10.111 18.1878 7.45182 15.5415C4.80871 12.8836 2.9606 9.5402 2.11582 5.88823C2.03035 5.31973 2.09346 4.7388 2.29901 4.20192C2.50456 3.66504 2.84555 3.1905 3.28882 2.82444L3.35878 2.75352Z" fill="black"/>
						</g>
						<defs>
						<clipPath id="clip0_2562_18007">
						<rect width="23" height="23" fill="white"/>
						</clipPath>
						</defs>
				</svg>',
				'content' => do_shortcode('[ai_client_phone]{default-phone}[/ai_client_phone]')
			),	
			array(
				'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" viewbox="0 0 35 35" fill="none">
								<path d="M31.9725 26.6475C31.9889 26.5984 32 26.5466 32 26.4921V8.50768C32 8.45284 31.9889 8.40071 31.9722 8.35129C31.9697 8.34452 31.9683 8.33775 31.9655 8.33098C31.9433 8.27309 31.9106 8.22096 31.8695 8.17526C31.8667 8.17221 31.8664 8.16849 31.8636 8.16544C31.8618 8.16375 31.8598 8.16307 31.858 8.16138C31.8142 8.11602 31.7623 8.07946 31.7042 8.05204C31.6997 8.05001 31.6962 8.0473 31.6917 8.04527C31.6367 8.02123 31.5768 8.00769 31.5138 8.00363C31.5076 8.00329 31.5017 8.00194 31.4954 8.00194C31.4895 8.0016 31.4843 8.00024 31.4783 8.00024H2.52236C2.51644 8.00024 2.51088 8.0016 2.50496 8.00194C2.49939 8.00227 2.49382 8.00329 2.48825 8.00363C2.42457 8.00769 2.36367 8.02157 2.30799 8.04594C2.30451 8.0473 2.30172 8.04967 2.29824 8.05102C2.23908 8.07844 2.18653 8.11568 2.14234 8.16172C2.1406 8.16341 2.13851 8.16375 2.13677 8.16544C2.13398 8.16815 2.13363 8.17187 2.13085 8.17492C2.08979 8.22062 2.05673 8.27309 2.03445 8.33098C2.03167 8.33775 2.03028 8.34452 2.02784 8.35163C2.01114 8.40105 2 8.45318 2 8.50802V26.4928C2 26.5483 2.01148 26.6011 2.02854 26.6512C2.03097 26.658 2.03236 26.6644 2.0348 26.6712C2.05742 26.7294 2.09083 26.7819 2.13224 26.8276C2.13468 26.8303 2.13537 26.8337 2.13781 26.8364C2.1399 26.8388 2.14268 26.8401 2.14512 26.8425C2.16217 26.8598 2.18096 26.875 2.20045 26.8899C2.20915 26.8963 2.21681 26.9041 2.22586 26.9102C2.24883 26.9258 2.27353 26.9383 2.29894 26.9498C2.3052 26.9525 2.31077 26.9569 2.31703 26.9593C2.38002 26.9853 2.44928 27.0002 2.52201 27.0002H31.4776C31.5504 27.0002 31.6196 26.9857 31.6826 26.9593C31.6924 26.9552 31.7014 26.9491 31.7108 26.9444C31.7324 26.9339 31.754 26.9231 31.7738 26.9099C31.7842 26.9028 31.7936 26.8936 31.8037 26.8858C31.8215 26.8719 31.8389 26.8581 31.8542 26.8422C31.857 26.8395 31.8601 26.8374 31.8629 26.8347C31.8657 26.8317 31.8664 26.8276 31.8692 26.8246C31.9099 26.7792 31.9426 26.7271 31.9649 26.6695C31.9683 26.6621 31.9701 26.655 31.9725 26.6475ZM3.04437 9.65932L11.8305 17.4659L3.04437 25.3347V9.65932ZM21.0524 17.0834C21.0162 17.1064 20.9779 17.1257 20.9476 17.1582C20.9361 17.1704 20.9323 17.1863 20.9222 17.1991L17.0002 20.6838L3.86776 9.01546H30.1326L21.0524 17.0834ZM12.6045 18.1534L16.648 21.7461C16.7479 21.8348 16.8738 21.8791 17.0002 21.8791C17.1265 21.8791 17.2525 21.8348 17.352 21.7461L21.3454 18.1981L30.1302 25.9847H3.8601L12.6045 18.1534ZM22.1197 17.5102L30.956 9.65932V25.3429L22.1197 17.5102Z" fill="black"/>
							</svg>',
				'content' => do_shortcode('[ai_client_email]{default-email}[/ai_client_email]')
			),	
			array(
				'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewbox="0 0 32 32" fill="none">
								<path d="M31.3626 6.64746H0.637438C0.285375 6.64746 0 6.9329 0 7.2849V24.7154C0 25.0674 0.285375 25.3528 0.637438 25.3528H31.3626C31.7146 25.3528 32 25.0674 32 24.7154V7.2849C32 6.9329 31.7146 6.64746 31.3626 6.64746ZM30.7251 24.078H1.27488V7.92234H30.7251L30.7251 24.078Z" fill="black"/>
								<path d="M20.7 19.5879H19.4377C19.0857 19.5879 18.8003 19.8733 18.8003 20.2253C18.8003 20.5773 19.0857 20.8628 19.4377 20.8628H20.7C21.052 20.8628 21.3374 20.5773 21.3374 20.2253C21.3374 19.8733 21.052 19.5879 20.7 19.5879Z" fill="black"/>
								<path d="M24.2671 19.5879H23.0049C22.6528 19.5879 22.3674 19.8733 22.3674 20.2253C22.3674 20.5773 22.6528 20.8628 23.0049 20.8628H24.2671C24.6192 20.8628 24.9046 20.5773 24.9046 20.2253C24.9046 19.8733 24.6192 19.5879 24.2671 19.5879Z" fill="black"/>
								<path d="M27.7972 19.5879H26.5349C26.1828 19.5879 25.8975 19.8733 25.8975 20.2253C25.8975 20.5773 26.1828 20.8628 26.5349 20.8628H27.7971C28.1492 20.8628 28.4346 20.5773 28.4346 20.2253C28.4346 19.8733 28.1493 19.5879 27.7972 19.5879Z" fill="black"/>
								<path d="M27.8142 15.4949H19.4377C19.0857 15.4949 18.8003 15.7803 18.8003 16.1323C18.8003 16.4843 19.0857 16.7697 19.4377 16.7697H27.8142C28.1663 16.7697 28.4517 16.4843 28.4517 16.1323C28.4517 15.7803 28.1663 15.4949 27.8142 15.4949Z" fill="black"/>
								<path d="M24.9243 11.4016H19.4377C19.0857 11.4016 18.8003 11.687 18.8003 12.039C18.8003 12.391 19.0857 12.6765 19.4377 12.6765H24.9243C25.2764 12.6765 25.5617 12.391 25.5617 12.039C25.5617 11.6871 25.2764 11.4016 24.9243 11.4016Z" fill="black"/>
								<path d="M10.0618 16.6287C6.5349 16.6287 3.66553 18.9857 3.66553 21.8827C3.66553 22.2347 3.9509 22.5201 4.30296 22.5201H15.8207C16.1727 22.5201 16.4581 22.2347 16.4581 21.8827C16.4581 18.9856 13.5887 16.6287 10.0618 16.6287ZM5.00615 21.2452C5.36403 19.5259 7.14509 18.1722 9.37684 17.9394V19.3602C9.37684 19.7122 9.66221 19.9977 10.0143 19.9977C10.3663 19.9977 10.6517 19.7122 10.6517 19.3602V17.9309C12.9277 18.1347 14.7546 19.5015 15.1176 21.2452H5.00615Z" fill="black"/>
								<path d="M10.0081 9.37964C8.18036 9.37964 6.69336 10.8666 6.69336 12.6944C6.69336 14.5221 8.18036 16.0091 10.0081 16.0091C11.8359 16.0091 13.3229 14.5221 13.3229 12.6944C13.3229 10.8666 11.8359 9.37964 10.0081 9.37964ZM10.0081 14.7342C8.8833 14.7342 7.9683 13.8191 7.9683 12.6944C7.9683 11.5696 8.88336 10.6546 10.0081 10.6546C11.1329 10.6546 12.0479 11.5696 12.0479 12.6944C12.0479 13.8191 11.1329 14.7342 10.0081 14.7342Z" fill="black"/>
							</svg>',
				'content' => do_shortcode('[ai_client_license]')
			)
		];


		$socialMediaArrs = [
			"facebook" => do_shortcode('[ai_client_facebook]'),
			"instagram" => do_shortcode('[ai_client_instagram]'),
			"youtube" => do_shortcode('[ai_client_youtube]'),
			"linkedin" => do_shortcode('[ai_client_linkedin]'),
			"twitter" => do_shortcode('[ai_client_twitter]'),
			"google-my-business-outline" => do_shortcode('[ai_client_google_business]'),
			"pinterest" => do_shortcode('[ai_client_pinterest]'),
			"trulia" => do_shortcode('[ai_client_trulia]'),
			"zillow" => do_shortcode('[ai_client_zillow]'),
			"houzz" => do_shortcode('[ai_client_houzz]'),
			"blogger" => do_shortcode('[ai_client_blogger]'),
			"yelp" => do_shortcode('[ai_client_yelp]'),
			"skype" => do_shortcode('[ai_client_skype]'),
			"caimeiju" => do_shortcode('[ai_client_caimeiju]'),
			"rss" => do_shortcode('[ai_client_rss]'),
			"cameo" => do_shortcode('[ai_client_cameo]'),
			"tiktok" => do_shortcode('[ai_client_tiktok]'),
			"gmap" => do_shortcode('[ai_client_gmap]'),
		];

        return do_shortcode('
			<div class="ip-elevate-about__container site-container" data-sticky-container>

			
				<div class="ip-elevate-about__photo">
					<div class="ip-elevate-about__photo--wrap" data-margin-top="'.$sticy_distance.'" data-sticky-for="1023" data-sticky-class="is-sticky">
						
						<div class="ip-elevate-about__photo--profile">
							<div class="ip-elevate-about__photo--overlay" style="background-image: url('.$image_overlay.')"></div>
							<img src="'.$image_src.'" alt="'.strip_tags($title).'" '.$image_width.' '.$image_height.'>
						</div>
						<div class="ip-elevate-about__contactInfo">
							<ul>
								'.implode('', array_map(function($contactInfo) {
									return '
									<li>
										
										'.$contactInfo['icon'].'
										
										<div class="contact__content">
											'.$contactInfo['content'].'
										</div>
									</li>';
								}, $contatInfoArrs)).'
							</ul>
							<div class="ip-elevate-about__socials">
							'.implode('', array_map(function($key, $socials) {
								if (!empty($socials)) {
									return '
										<a href="'.$socials.'" target="_blank">
											<span>'.$key.'</span>
											<i class="ai-font-'.$key.'"></i>
										</a>';
								}
							}, array_keys($socialMediaArrs), $socialMediaArrs)).'

							</div>
							<div class="cta-button">
								<a href="'.$button_link.'">'.$button_label.' +</a>
							</div>
						</div>
					</div>
				</div>

				<div class="ip-elevate-about__content">
					<div class="about__title">
							<h2>
								<small>'.$add_meet.'</small>
								<span>'.$title.'</span>
								<em>'.$subtitle.'</em>
							</h2>
					</div><!-- end of site heading -->
					'.$content.'
				</div>

				<div class="ip-elevate-about__contactInfo">
					<ul>
						'.implode('', array_map(function($contactInfo) {
							return '
							<li>
								
								'.$contactInfo['icon'].'
								
								<div class="contact__content">
									'.$contactInfo['content'].'
								</div>
							</li>';
						}, $contatInfoArrs)).'
					</ul>
					<div class="ip-elevate-about__socials">
					'.implode('', array_map(function($key, $socials) {
						if (!empty($socials)) {
							return '
								<a href="'.$socials.'" target="_blank">
									<span>'.$key.'</span>
									<i class="ai-font-'.$key.'"></i>
								</a>';
						}
					}, array_keys($socialMediaArrs), $socialMediaArrs)).'

					</div>
					<div class="cta-button">
						<a href="'.$button_link.'">'.$button_label.' +</a>
					</div>
				</div>

			</div>

		');
    }
}
