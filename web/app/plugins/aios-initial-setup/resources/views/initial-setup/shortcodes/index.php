<div class="aios-shortcode">
	<div class="wpui-row wpui-row-box">
		<div class="wpui-col-md-3">
			<p class="mt-0"><span class="wpui-settings-title">Responsive Images</span> Returns set of adaptive images.</p>
		</div>
		<div class="wpui-col-md-9">
			<input class="auto-highlight" readonly type="text" value='[aios_responsive_image id="99"]'>
			<p class="mb-0"><strong>Attributes:</strong></p>
			<ul>
				<li><strong>id</strong> - Image ID . Default: empty(required)</li>
				<li><strong>sizes</strong> - Sizes separated by commas(viewport is required). Default: medium,medium_large,large,full. Default: 400,768,1024</li>
				<li><strong>viewport</strong> - Width of monitor where to change the image sizez separated by commas(viewport is required). Default: 400,768,1024</li>
				<li><strong>id_name</strong> - ID attribute for img element</li>
				<li><strong>class</strong> - Class attribute for img element. Default: img-responsive</li>
				<li><strong>alt</strong> - Use for custom alt, if empty this will get alt from upload images. Default: Image Alt</li>
				<li><strong>lazyload</strong> - Lazyload srcset. Default: falses</li>
			</ul>
		</div>
	</div>
	<div class="wpui-row wpui-row-box">
		<div class="wpui-col-md-3">
			<p class="mt-0"><span class="wpui-settings-title">Quick Search Select City Autocomplete</span> Returns autocomplete select using bootstrap.</p>
		</div>
		<div class="wpui-col-md-9">
			<input class="auto-highlight" readonly type="text" value='[aios_quick_search_autocomplete]'>
			<p>Enable quick search under <strong>"Quick Search"</strong></p>
			<p class="mb-0"><strong>Attributes:</strong></p>
			<ul>
				<li><strong>id</strong> - list of value accepted(city, zip, neighborhood, mlsarea). Default: Selected Area Type</li>
				<li><strong>name</strong> - NAME Attribute of select tag. Default: Selected Area Type</li>
				<li><strong>class</strong> - class Attribute of select tag. Default: <em>empty</em></li>
				<li><strong>placeholder</strong> - Default: Selected Area Type</li>
				<li><strong>status_placeholder</strong> - Default: Start typing a {selected data types}</li>
			</ul>
		</div>
	</div>
	<div class="wpui-row wpui-row-box">
		<div class="wpui-col-md-3">
			<p class="mt-0"><span class="wpui-settings-title">Quick Search Property Type</span> Returns list of property type.</p>
		</div>
		<div class="wpui-col-md-9">
			<input class="auto-highlight" readonly type="text" value='[aios_quick_search_property_type]'>
			<p>Enable quick search under <strong>"Quick Search"</strong></p>
			<p class="mb-0"><strong>Attributes:</strong></p>
			<ul>
				<li><strong>id</strong> - ID Attribute of select tag. Default: <em>property-type</em></li>
				<li><strong>name</strong> - NAME Attribute of select tag. Default: <em>propertyType</em></li>
				<li><strong>class</strong> - class Attribute of select tag. Default: <em>empty</em></li>
				<li><strong>placeholder</strong> - Default: <em>Select Property Type</em></li>
				<li><strong>use_ihf_default</strong> - if set to true this will not use attribute "<strong>types</strong>". Default: <em>false</em></li>
				<li><strong>types</strong> - Display lists of property type. Use double arrow operator "=>" for value and display text, separator "|" for new option. <br>Default: "commercial=>Commercial | 
					condo-coop=>Condo/coop | 
					investment=>Investment | 
					land=>Land | 
					mobile-manufactured=>Mobile/manufactured | 
					residential=>Residential | 
					single-family=>Single Family | 
					townhouse=>Townhouse | 
					vacation=>Vacation"
				</li>
			</ul>
		</div>
	</div>
	<div class="wpui-row wpui-row-box">
		<div class="wpui-col-md-3">
			<p class="mt-0"><span class="wpui-settings-title">Quick Search Beds</span> Returns number of beds.</p>
		</div>
		<div class="wpui-col-md-9">
			<input class="auto-highlight" readonly type="text" value='[aios_quick_search_beds]'>
			<p>Enable quick search under <strong>"Quick Search"</strong></p>
			<p class="mb-0"><strong>Attributes:</strong></p>
			<ul>
				<li><strong>id</strong> - ID Attribute of select tag. Default: <em>beds</em></li>
				<li><strong>name</strong> - NAME Attribute of select tag. Default: <em>bedrooms</em></li>
				<li><strong>class</strong> - class Attribute of select tag. Default: <em>empty</em></li>
				<li><strong>placeholder</strong> - Default: <em>Beds</em></li>
				<li><strong>min</strong> - minimum number of beds. Default: <em>1</em></li>
				<li><strong>max</strong> - maximum number of beds. Default: <em>20</em></li>
			</ul>
		</div>
	</div>
	<div class="wpui-row wpui-row-box">
		<div class="wpui-col-md-3">
			<p class="mt-0"><span class="wpui-settings-title">Quick Search Baths</span> Returns number of baths.</p>
		</div>
		<div class="wpui-col-md-9">
			<input class="auto-highlight" readonly type="text" value='[aios_quick_search_baths]'>
			<p>Enable quick search under <strong>"Quick Search"</strong></p>
			<p class="mb-0"><strong>Attributes:</strong></p>
			<ul>
				<li><strong>id</strong> - ID Attribute of select tag. Default: <em>baths</em></li>
				<li><strong>name</strong> - NAME Attribute of select tag. Default: <em>bathCount</em></li>
				<li><strong>class</strong> - class Attribute of select tag. Default: <em>empty</em></li>
				<li><strong>placeholder</strong> - Default: <em>Baths</em></li>
				<li><strong>min</strong> - minimum number of beds. Default: <em>1</em></li>
				<li><strong>max</strong> - maximum number of beds. Default: <em>20</em></li>
				<li><strong>halfbath</strong> - if set to true this will return number with 0.5 increment. Default: <em>false</em></li>
			</ul>
		</div>
	</div>
	<div class="wpui-row wpui-row-box">
		<div class="wpui-col-md-3">
			<p class="mt-0"><span class="wpui-settings-title">Quick Search Price</span> Returns list of prices.</p>
		</div>
		<div class="wpui-col-md-9">
			<input class="auto-highlight" readonly type="text" value='[aios_quick_search_price]'>
			<p>Enable quick search under <strong>"Quick Search"</strong></p>
			<p class="mb-0"><strong>Attributes:</strong></p>
			<ul>
				<li><strong>id</strong> - ID Attribute of select tag. Default: <em>price</em></li>
				<li><strong>name</strong> - NAME Attribute of select tag. Default: <em>empty(but maxListPrice will be added)</em></li>
				<li><strong>isMinPrice</strong> - for iHomefinder if true name will change to "minListPrice" else "maxListPrice". Default: <em>maxListPrice</em></li>
				<li><strong>class</strong> - class Attribute of select tag. Default: <em>empty</em></li>
				<li><strong>placeholder</strong> - Default: <em>Price</em></li>
				<li><strong>prices</strong> - List of prices. Use separator "|" to seperate prices. Default: <strong><em>100000|250000|500000|750000|1000000|1250000|1500000|1750000|2000000</em></strong><br>
					Note that on prices you can add hyphen "-" to have min price and max price on one select sample attribute: 100000-200000|300000-400000|500000-600000
				</li>
				<li><strong>currency</strong> - Current to used. Default: <em>$</em></li>
			</ul>
		</div>
	</div>
	<div class="wpui-row wpui-row-box">
		<div class="wpui-col-md-3">
			<p class="mt-0"><span class="wpui-settings-title">Site URL</span> Returns the site's URL</p>
		</div>
		<div class="wpui-col-md-9">
			<input class="auto-highlight" readonly type="text" value='[blogurl]'>
		</div>
	</div>
	<div class="wpui-row wpui-row-box">
		<div class="wpui-col-md-3">
			<p class="mt-0"><span class="wpui-settings-title">Current URL</span> Returns the current page url</p>
		</div>
		<div class="wpui-col-md-9">
			<input class="auto-highlight" readonly type="text" value='[current_url]'>
		</div>
	</div>
	<div class="wpui-row wpui-row-box">
		<div class="wpui-col-md-3">
			<p class="mt-0"><span class="wpui-settings-title">Phone Number</span> Returns the em formartted phone number URL (e.g. <em class="ai-mobile-phone" data-href="1.800.979.5799" data-ext="08" >Call 1.800.979.5799</em> )</p>
		</div>
		<div class="wpui-col-md-9">
			<input class="auto-highlight" readonly type="text" value='[ai_phone href="+1.800.979.5799"]Call 800.979.5799[/ai_phone]'>
			<p class="mb-0"><strong>Attributes:</strong></p>
			<ul>
				<li>
                    <strong>filter - the script automatically adds '.' between the numbers. Set this to 'false' to disable. Default is true</strong>
				</li>
				<li>
					<strong>href</strong> - exact phone number details as long as it contains 10 or 11 digits number excluding special characters and spaces. For country code you are require to add plus sign(+).<br>
					<em>HREF value format: </em><strong>+1.123.456.7890</strong>
				</li>
				<li>extension - extension number can up to 4 digits</li>
				<li>
					<strong>convert_js - Display as anchor tag instead of appeding via javascript. Default is false</strong>
				</li>
				<li>
					<strong>unwrap_em - Unwrap anchor tag, condition <em>convert_js</em> must be true. Default is false</strong>
				</li>
				<li><strong>class</strong> - class of the anchor tag, condition <em>convert_js</em> must be true.</li>
			</ul>
		</div>
	</div>
	<div class="wpui-row wpui-row-box">
		<div class="wpui-col-md-3">
			<p class="mt-0"><span class="wpui-settings-title">Child Theme URL</span> Returns the child theme URL (e.g. http://www.mysite.com/wp-content/themes/my-custom-theme).</p>
		</div>
		<div class="wpui-col-md-9">
			<input class="auto-highlight" readonly type="text" value='[stylesheet_directory]'>
		</div>
	</div>
	<div class="wpui-row wpui-row-box">
		<div class="wpui-col-md-3">
			<p class="mt-0"><span class="wpui-settings-title">Parent Theme URL</span> Returns the parent theme URL(e.g. http://www.mysite.com/wp-content/themes/aios-starter-theme).</p>
		</div>
		<div class="wpui-col-md-9">
			<input class="auto-highlight" readonly type="text" value='[template_directory]'>
		</div>
	</div>
	<div class="wpui-row wpui-row-box">
		<div class="wpui-col-md-3">
			<p class="mt-0"><span class="wpui-settings-title">Credits</span> Returns AgentImage credits</p>
		</div>
		<div class="wpui-col-md-9">
			<input class="auto-highlight" readonly type="text" value='[agentimage_credits credits="Real Estate Website Design by <a target="_blank" href="https://www.agentimage.com" style="text-decoration:underline;font-weight:bold">Agent Image</a>"]'>
			<p class="mb-0"><strong>Attributes:</strong></p>
			<ul>
				<li>credits - HTML of the credits</li>
				<li>renew - true or false, replace the current save credits.</li>
				<li>seo -  true or false, SEO credits.</li>
			</ul>
		</div>
	</div>
	<div class="wpui-row wpui-row-box">
		<div class="wpui-col-md-3">
			<p class="mt-0"><span class="wpui-settings-title">Sitemap</span> Outputs an alphabetical list of pages in the site</p>
		</div>
		<div class="wpui-col-md-9">
			<input class="auto-highlight" readonly type="text" value='[sitemap]'>
			<p class="mb-0"><strong>Attributes:</strong></p>
			<ul>
				<li>Everything supported by the <a href="https://codex.wordpress.org/Function_Reference/wp_list_pages" target="_blank">wp_list_pages()</a> function</li>
			</ul>
		</div>
	</div>
	<div class="wpui-row wpui-row-box">
		<div class="wpui-col-md-3">
			<p class="mt-0"><span class="wpui-settings-title">Custom Sitemap</span> Output all posts/pages/custom post type</p>
		</div>
		<div class="wpui-col-md-9">
			<input class="auto-highlight" readonly type="text" value='[custom_sitemap]'>
			<p>You need to enable this module under Advanced->Settings check "Custom Sitemap"</p>
			<p class="mb-0"><strong>Attributes:</strong></p>
			<ul>
				<li><strong>exclude_post_type</strong><br>
					Will not include post type. Default: ''.</li>
				<li><strong>exclude_ids</strong><br>
					Will not include posts/pages/custom post type with match ID. Note that if is a parent child will be also hide. Default : ''</li>
				<li><strong>orderby</strong><br>
					Designates the ascending or descending order of the 'orderby' parameter accepted value "ASC", "DESC". Default: "ASC"</li>
				<li><strong>order</strong><br>
					Sort retrieved posts by parameter accepted value "ID", "author", "title", "name", "date", "modified", "parent", "rand", "comment_count", "menu_order", "meta_value", "meta_value_num", "title menu_order", "post__in". Default: "Title"</li>
				<li><strong>orderby_child</strong><br>
					Designates the ascending or descending order of the 'orderby' parameter accepted value "ASC", "DESC". Default: "ASC"</li>
				<li><strong>order_child</strong><br>
					Sort retrieved posts by parameter accepted value "ID", "author", "title", "name", "date", "modified", "parent", "rand", "comment_count", "menu_order", "meta_value", "meta_value_num", "title menu_order", "post__in". Default: "Title"</li>
			</ul>
		</div>
	</div>
	<div class="wpui-row wpui-row-box">
		<div class="wpui-col-md-3">
			<p class="mt-0"><span class="wpui-settings-title">Custom Sitemap with Taxonomy</span> Output all posts/pages/custom post type/taxonomies</p>
		</div>
		<div class="wpui-col-md-9">
			<input class="auto-highlight" readonly type="text" value='[custom_sitemap_taxonomy]'>
			<p>You need to enable this module under Advanced->Settings check "Custom Sitemap"</p>
			<p class="mb-0"><strong>Attributes:</strong></p>
			<ul>
				<li><strong>exclude_post_type</strong><br>
					Will not include post type. Default: ''.</li>
				<li><strong>exclude_ids</strong><br>
					Will not include posts/pages/custom post type with match ID. Note that if is a parent child will be also hide. Default : ''</li>
				<li><strong>exclude_tax_type</strong><br>
					Will not include taxonomies. Default: ''.</li>
				<li><strong>exclude_term_ids</strong><br>
					Will not include terms with match ID. Default : ''</li>
				<li><strong>order</strong><br>
					Order by title. Default: "ASC"</li>
			</ul>
		</div>
	</div>
	<div class="wpui-row wpui-row-box">
		<div class="wpui-col-md-3">
			<p class="mt-0"><span class="wpui-settings-title">Navigation</span> Outputs a list of pages based on the main site navigation.</p>
		</div>
		<div class="wpui-col-md-9">
			<input class="auto-highlight" readonly type="text" value='[wp_nav_menu]'>
			<p>Everything supported by the <a href="https://developer.wordpress.org/reference/functions/wp_nav_menu/" target="_blank">wp_nav_menu()</a> function</p>
			<p class="mb-0"><strong>Attributes:</strong></p>
			<ul>
				<li><strong>submenu</strong> - Only display the contents of the submenu under a navigation item</li>
			</ul>
		</div>
	</div>
	<div class="wpui-row wpui-row-box">
		<div class="wpui-col-md-3">
			<p class="mt-0"><span class="wpui-settings-title">Current Year</span> Set Dynamic Year.</p>
		</div>
			<div class="wpui-col-md-9">
			<input class="auto-highlight" readonly type="text" value='[currentYear]'>
			<p class="mb-0"><strong>Attributes:</strong></p>
			<ul>
				<li><strong>currentYear</strong>- Set Current Year</li>
			</ul>
		</div>
	</div>
	<div class="wpui-row wpui-row-box">
		<div class="wpui-col-md-3">
			<p class="mt-0"><span class="wpui-settings-title">Email Address</span> Obfuscates an email address to help reduce spam.</p>
		</div>
		<div class="wpui-col-md-9">
			<input class="auto-highlight" readonly type="text" value='[mail_to email="user@thedesignpeople.com"]user@thedesignpeople.com[/mail_to]'>
			<p class="mb-0"><strong>Attributes:</strong></p>
			<ul>
				<li><strong>email</strong> - an email address</li>
				<li><strong>class</strong> - class of the anchor tag</li>
			</ul>
		</div>
	</div>
	<div class="wpui-row wpui-row-box">
		<div class="wpui-col-md-3">
			<p class="mt-0"><span class="wpui-settings-title">Video Placeholder</span> Default video placeholder for AI sites.</p>
		</div>
		<div class="wpui-col-md-9">
			<input class="auto-highlight" readonly type="text" value='[agentimage_video width="560" height="315"]'>
			<p class="mb-0"><strong>Attributes:</strong></p>
			<ul>
				<li><strong>width</strong> - width of video</li>
				<li><strong>height</strong> - height of video</li>
			</ul>
		</div>
	</div>
	<div class="wpui-row wpui-row-box">
		<div class="wpui-col-md-3">
			<p class="mt-0"><span class="wpui-settings-title">Asynchronous Iframe</span> Asynchronous load.</p>
		</div>
		<div class="wpui-col-md-9">
			<input class="auto-highlight" readonly type="text" value='[iframe_async src="http://agentimage.com/" width="800" height="400"]'>
			<p class="mb-0"><strong>Attributes:</strong></p>
			<ul>
				<li><strong>width</strong> - width of iframe</li>
				<li><strong>height</strong> - height of iframe</li>
				<li><strong>id</strong> - id of iframe</li>
				<li><strong>class</strong> - class of iframe</li>
				<li><strong>additional</strong> - additional attribute for the iframe( i.e. additional="frameborder=0 sandbox=allow-forms scrolling=yes" )</li>
			</ul>
		</div>
	</div>
	<div class="wpui-row wpui-row-box">
		<div class="wpui-col-md-3">
			<p class="mt-0"><span class="wpui-settings-title">Mortgage Calculator</span> Adds a mortgage calculator any page or widget.</p>
		</div>
		<div class="wpui-col-md-9">
			<input class="auto-highlight" readonly type="text" value='[aios-mortgage-calculator years="5" interest="5.5" tax="10" insurance="500"]'>
			<p class="mb-0"><strong>Attributes:</strong></p>
			<ul>
				<li><strong>years</strong> - loan duration. Default: 5</li>
				<li><strong>interest</strong> - interest rate. Default: 5.5</li>
				<li><strong>tax</strong> - annual property tax. Default: 10</li>
				<li><strong>insurance</strong> - annual insurance. Default: 500</li>
			</ul>
		</div>
	</div>
	<div class="wpui-row wpui-row-box">
		<div class="wpui-col-md-3">
			<p class="mt-0"><span class="wpui-settings-title">Image URL</span> This will display siteurl or theme dir.</p>
		</div>
		<div class="wpui-col-md-9">
			<textarea class="auto-highlight" readonly style="height: 135px !important">[aios_element]
		&lt;div class="classes" style="background-image: url({{theme_dir}}/images/sample.jpg)">&lt;/div>
		[blogurl]
		&lt;a href="[blogurl]">&lt;img src="{{blogurl}}/wp-content/themes/theme_name/images/test.jpg" alt="">&lt;/a>
	[/aios_element]</textarea>
			<p class="mb-0"><strong>Inline Attributes:</strong></p>
			<ul>
				<li><strong>{{theme_dir}}</strong> - Return Stylesheet Directory URI</li>
				<li><strong>{{blogurl}}</strong> - Return Site URL</li>
			</ul>
			<p class="mb-0"><strong>Attributes:</strong></p>
			<ul>
				<li><strong>element</strong> - HTML Element</li>
				<li><strong>class</strong> - Class</li>
				<li><strong>width</strong> - Width</li>
				<li><strong>height</strong> - Height</li>
				<li><strong>style</strong> - style</li>
				<li><strong>data-src</strong> - for lazy load use</li>
				<li><strong>data-class</strong> - for lazy load use</li>
				<li><strong>data-animation</strong> - for lazy load use</li>
				<li><strong>data-offset</strong> - for lazy load use</li>
			</ul>
		</div>
	</div>
	<div class="wpui-row wpui-row-box">
		<div class="wpui-col-md-3">
			<p class="mt-0"><span class="wpui-settings-title">AIOS Image</span> Returns image src/html via attachment id</p>
		</div>
		<div class="wpui-col-md-9">
			<input class="auto-highlight" readonly type="text" value='[aios_image id="1"]'>
			<p class="mb-0"><strong>Attributes:</strong></p>
			<ul>
				<li><strong>id</strong> - attachment ID</li>
				<li><strong>return</strong> - return type: [<strong>htmt</strong>, <strong>src</strong>]</li>
				<li><strong>element</strong> - shortcode element: [<strong>img</strong>, <strong>div</strong>, <strong>canvas</strong>]</li>
				<li><strong>width</strong> - image width</li>
				<li><strong>height</strong> - image height</li>
				<li><strong>alt</strong> - image custom alt, returns image alt if left empty</li>
				<li><strong>class</strong> - element class, separated by space</li>
				<li><strong>lazyload</strong> - image lazyload: [<strong>true</strong>, <strong>false</strong>]</li>
				<li><strong>placeholder</strong> - placeholder image for lazyload</li>
			</ul>
		</div>
	</div>
</div>