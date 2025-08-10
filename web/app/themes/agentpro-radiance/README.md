
## AIOS Starter Theme

This is the standard base theme used on the following products.

* Agent Pro
* Semi-custom
* Imagine Studio

### Usage

1. Understand [Wordpress Template Hierarchy](https://developer.wordpress.org/themes/basics/template-hierarchy/).
2. Download package.
3. Unzip to `wp-content/themes`.
4. **None** of the contents of this package must be edited. 

### Hierarchy
- Assets
    - Css
        - defaults.min.css
        - global.css
        - homepage.css
    - js
        - scripts.js
    - Fonts
    - Image
- inc
    - Widgets
    - Func
    - Hooks
    - Enqueue
- templates
    - partials
    - fullwidth.php
    - left-sidebar.php
    - nosidebar.php

### Hooks

* `aios_starter_theme_before_inner_page_content` - prepend text to #content of inner pages

```php
<?php

/* Add this code to functions.php to easily display breadcrumbs on all inner pages */
function aios_starter_theme_add_breadcrumbs() {
	if ( function_exists('yoast_breadcrumb') ) {
		yoast_breadcrumb('<p class="yoast-breadcrumbs">','</p>');
	} 
}

add_action('aios_starter_theme_before_inner_page_content','aios_starter_theme_add_breadcrumbs');
```

* `aios_starter_theme_after_inner_page_content` - append text to #content of inner pages

```php
<?php

/* Add this code to functions.php to easily add a 'back to top' link to all inner pages. */
function aios_starter_theme_add_back_to_top() {
	echo '<a href="javascript:void(0)" onclick="window.scrollTo(0,0)">Back to top</a>';
}

add_action('aios_starter_theme_after_inner_page_content','aios_starter_theme_add_back_to_top');
```

### Compatibility

* At least Wordpress 4.4 to up

### Issues

Report bugs to the [issue tracker](http://gitlab.thedesignpeople.net/Themes/aios-starter-theme/issues). Bugs reported elsewhere will not be entertained.

More Instruction can be found  [here](https://aidocs.forge99.com/aios-starter-theme/#/features)

# For Node Base Development
To use this theme you will need :

- node.js
- npm
- local web server
- wordpress installed




## 2. Installation

### Clone

If you prefere to clone the Github repository, go head and do so
```
cd [path/to/your/wp-folder]/wp-content/themes
```

### Install dependencies

In the freshly installed theme folder run the command below
```
npm install
```

Minified Version.

```
npm run dev 
```
```
npm run build 
```
```
npm run watch 
```


Unminified for homepage.css
```
npm run build-dev
```