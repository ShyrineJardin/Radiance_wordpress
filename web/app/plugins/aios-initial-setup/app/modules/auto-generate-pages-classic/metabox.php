<?php

namespace AiosInitialSetup\App\Modules\AutoGeneratePagesClassicEditor;

class Metabox {

	public function __construct()
	{
		add_action('admin_enqueue_scripts', [$this, 'enqueue_admin_script']);
		add_action('add_meta_boxes', [$this, 'modified_post_meta']);
	}

	public function enqueue_admin_script()
	{
		if (strpos(get_current_screen()->id, 'page') !== false) {
			wp_enqueue_style('aios-auto-generate', AIOS_INITIAL_SETUP_RESOURCES . 'vite/css/aios-auto-generate.css');
			wp_enqueue_script('aios-auto-generate', AIOS_INITIAL_SETUP_RESOURCES . 'vite/js/aios-auto-generate.js', ['jquery']);
			wp_localize_script('aios-auto-generate', 'data', [
				'nonce' => wp_create_nonce('wp_rest'),
				'baseUrl' => get_home_url(),
			]);
		}
	}

	public function modified_post_meta()
	{
		add_meta_box('aios_auto_generate_preset_template', 'Preset Template', [$this, 'modified_post_meta_function'], 'page', 'side', 'high');
	}

    /**
     * @param $post
     */
	public function modified_post_meta_function($post)
	{
        $cdnUrl = cdnDomainSwitcher();
		$items = [
			[
				'type' => 'amante-ii',
				'image' => "$cdnUrl/images/generate-pages/about-amante-ii.jpg",
				'title' => 'About',
                'alternative' => ['amante-ii', 'marshall', 'galaxy'],
			],
            [
                'type' => 'amante-ii',
                'image' => "$cdnUrl/images/generate-pages/contact-amante-ii.jpg",
                'title' => 'Contact',
	            'alternative' => ['amante-ii', 'marshall', 'galaxy', 'panorama', 'purist', 'radiance'],
            ],
            [
                'type' => 'iconic',
                'image' => "$cdnUrl/images/generate-pages/about-iconic.jpg",
                'title' => 'About',
	            'alternative' => ['iconic'],
            ],
            [
                'type' => 'iconic',
                'image' => "$cdnUrl/images/generate-pages/contact-iconic.jpg",
                'title' => 'Contact',
	            'alternative' => ['iconic'],
            ],
            [
                'type' => 'element',
                'image' => "$cdnUrl/images/generate-pages/about-element.jpg",
                'title' => 'About',
	            'alternative' => ['element', 'metropolitan', 'beacon', 'endeavor'],
            ],
            [
                'type' => 'element',
                'image' => "$cdnUrl/images/generate-pages/contact-element.jpg",
                'title' => 'Contact',
	            'alternative' => ['element', 'metropolitan', 'beacon', 'radiance'],
            ],
            [
                'type' => 'legacy',
                'image' => "$cdnUrl/images/generate-pages/about-legacy.jpg",
                'title' => 'About',
	            'alternative' => ['legacy', 'vega', 'panorama', 'endeavor', 'purist'],
            ],
            [
                'type' => 'legacy',
                'image' => "$cdnUrl/images/generate-pages/contact-legacy.jpg",
                'title' => 'Contact',
	            'alternative' => ['legacy', 'vega'],
            ],
			[
				'type' => 'classic',
				'image' => "$cdnUrl/images/generate-pages/about-classic.jpg",
				'title' => 'About',
			],
			[
				'type' => 'classic',
				'image' => "$cdnUrl/images/generate-pages/contact-classic.jpg",
				'title' => 'Contact'
			],
			[
				'type' => 'modern',
				'image' => "$cdnUrl/images/generate-pages/about-modern.jpg",
				'title' => 'About'
			],
            [
                'type' => 'modern',
                'image' => "$cdnUrl/images/generate-pages/contact-modern.jpg",
                'title' => 'Contact'
            ],
			[
				'type' => 'minimalist',
				'image' => "$cdnUrl/images/generate-pages/about-minimalist.jpg",
				'title' => 'About',
//                'prerequisite' => [
//                    [
//                        'title' => 'Install and Active',
//                        'description' => '- Slick<br>
//                        - Animate on Scroll(AOS)',
//                    ],
//                    [
//                        'title' => 'Declare the ff. in :root CSS psuedo:',
//                        'description' => '--aios-auto-generate-page-primary: #454545;<br>
//                            --aios-auto-generate-page-secondary: #c2b687;<br>
//                            --aios-auto-generate-page-tertiary: #c1c1c1;',
//                    ],
//                ]
			],
			[
				'type' => 'minimalist',
				'image' => "$cdnUrl/images/generate-pages/contact-minimalist.jpg",
				'title' => 'Contact'
			],
		];

        $option = get_option(AIOS_AUTO_GENERATE_PAGES, []);
    ?>
		<div class="auto-generate-page">
            <p>
                Selected template:
                <strong>
                    <?php
                        if (isset($option[$post->ID])) {
                            echo "{$option[$post->ID]['type']}-{$option[$post->ID]['theme']}";
                        } else {
                            echo "None";
                        }
                    ?>
                </strong>
            </p>
			<div class="auto-generate-page-button">
                <?php
                    if (isset($option[$post->ID])) {
//                        $customizerSectionUrl = get_admin_url() . "customize.php?autofocus[panel]=preset-{$post->ID}&url=" . urlencode(get_permalink($post->ID));

//                        echo "
//                            <a href=\"{$customizerSectionUrl}\" class=\"button button-primary button-large\">Edit in Customizer</a>
//                            <style>
//                                #wpui-container-minimalist {display: none !important;}
//                            </style>
//                        ";
                        echo "
                            <button id=\"auto-generate-revoke-classic-editor\" class=\"button button-secondary button-large\" data-id=\"{$post->ID}\" " . (! isset($option[$post->ID]) ? 'disabled' : '') . ">Revoke Page Template</button>
                            <script>
                                jQuery(document).ready(function() {
                                    jQuery(\"#page_template\").attr(\"disabled\", \"disabled\");
                                });
                            </script>
                        ";
                    } else {
                        echo "<button id=\"auto-generate-page-classic-editor\" class=\"button button-primary button-large\">Template Gallery</button>";
                    }
                ?>
			</div>
            <?php
                if (isset($option[$post->ID])) {
                    echo "<p>Note: <strong>Page Attribute Select Template</strong> is disabled, revoke the preset template to select other template.</p>";
                } else {
                    echo "<p>Note: <strong>Page Attribute Select Template</strong> will be disabled once you select a template.</p>";
                }
            ?>
		</div>

		<div class="agp-frame">
			<div class="agp-frame-overlay"></div>
			<div class="agp-frame-container">
				<div class="agp-frame-header">
					<h2>Template Gallery</h2>
					<div class="agp-frame-select">
						<label for="agp-frame-page-selector">Page Type:</label>
						<select id="agp-frame-page-selector">
							<option value="all">All</option>
							<option value="about">About</option>
							<option value="contact">Contact</option>
						</select>
                        <label for="agp-frame-selector">Category:</label>
						<select id="agp-frame-selector">
							<option value="all">All</option>
							<option value="classic">Classic</option>
							<option value="modern">Modern</option>
							<option value="minimalist">Minimalist</option>
                            <option value="amante-ii">Amante II</option>
                            <option value="iconic">Iconic</option>
                            <option value="element">Element</option>
                            <option value="legacy">Legacy</option>
						</select>
						<div class="agp-frame-close" data-type="button"></div>
					</div>
				</div>
				<div class="agp-frame-content">
					<!-- Items -->
					<div class="agp-frame-items">
						<!-- Item -->
						<?php
                            $templates = get_transient('aios-filtered-templates');
                            $filteredTemplates = $templates && $templates !== 'Unauthorized' ? $templates['auto-generate-pages'] : [];
                            foreach ($items as $item) {
                                // Check if theme is available for use
                                $isAvailable = isset($filteredTemplates[$item['type']]) ? $filteredTemplates[$item['type']]['available'] : false;

                                // Check if product type is agent-pro then we need to lock other AP themes
                                if ($templates['product-type'] === 'agent-pro') {
	                                $isAvailable = false;

	                                foreach ($item['alternative'] as $name) {
	                                    if ($isAvailable === false) {
		                                    $themeName = str_replace('-', ' ', $name);
		                                    $currentThemeName = strtolower(wp_get_theme()->get('Name'));
		                                    $isAvailable = strpos($currentThemeName, $themeName) !== false;
                                        }
                                    }
                                }

                                // Template Details
                                $name = strtolower(str_replace(' ', '-', $item['title']));
                                $type = ucfirst($item['type']);
                                $htmlPrerequisite = "";

                                if (isset($item['prerequisite'])) {
                                    $htmlPrerequisite = "<div class=\"agp-prerequisite-frame\">";
                                    $htmlPrerequisite .= "<div class=\"agp-prerequisite-frame-header\">
                                            <h4>
                                                <span>Pre-requisites:</span>
                                                {$type} {$item['title']}
                                            </h4>
						                    <div class=\"agp-prerequisite-frame-close\" data-type=\"button\"></div>
                                        </div>";
                                    foreach ($item['prerequisite'] as $prerequisite) {
                                        $htmlPrerequisite .= "<h5>{$prerequisite['title']}</h5>
                                            <p>{$prerequisite['description']}</p>";
                                    }
                                    $htmlPrerequisite .= "</div>";
                                }

                                $colorPalette = wp_get_current_user()->user_login ? "<button class=\"auto-generate-page-classic-prerequisite button button-secondary button-large\" data-name=\"{$name}\" data-type=\"{$item['type']}\" data-id=\"{$post->ID}\">Color Palette</button>" : "";
                                $buttons = $isAvailable ? "{$colorPalette}<button class=\"auto-generate-page-classic-editor button button-primary button-large\" data-name=\"{$name}\" data-type=\"{$item['type']}\" data-id=\"{$post->ID}\">Select Template</button>" : "Locked";
                                $lockedClass = $isAvailable ? '' : 'agp-frame-item-locked';

                                echo "<div class=\"agp-frame-item {$lockedClass}\" data-page=\"{$name}\" data-type=\"{$item['type']}\">
                                    <div class=\"agp-frame-item-content\">
                                        <img src=\"{$item['image']}\" alt=\"{$item['title']}\">
                    
                                        <div class=\"agp-frame-item-description\">
                                            <h3>
                                                <span>{$type}</span>
                                                {$item['title']}
                                            </h3>
                                            
                                            <div class=\"agp-frame-item-prerequisite\">
                                                {$buttons}
                                                {$htmlPrerequisite}
                                            </div>
                                        </div>
                                    </div>
                                </div>";
                            }
						?>
					</div>
				</div>
			</div>
		</div>

        <div class="agp-prerequisite-frame">
            <div class="agp-prerequisite-frame-header">
                <h4>Color Palette</h4>
                <div class="agp-prerequisite-frame-close" data-type="button"></div>
            </div>
            <p>:root css was utilize here any edit can be done through active theme style. Add "--background-color: #ffffff;" to the :root, most of the template with overlay used this.</p>
        </div>
		<?php
	}

}

new Metabox();
