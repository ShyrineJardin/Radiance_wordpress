<?php 
    class AIOSSTARTETHEMEWIDGETS
    {

        /**
         * Admin constructor.
         */
        public function __construct()
        {
            add_action( 'widgets_init', [$this, 'ai_starter_theme_register_sidebars'] , 11, 2);
        }

        /*
        * Register sidebars
        */
        function ai_starter_theme_register_sidebars() {

            // Default Sidebars
            register_sidebar(array(
                'name' => 'Primary Sidebar',
                'id'=>'primary-sidebar',
                'before_widget' => '<div id="%1$s" class="widget-set %2$s">',
                'after_widget' => '</div>',
                'before_title' => '<h2 class="widget-title">',
                'after_title' => '</h2>'
            ));

            /// Custom Sidebar
            $items = [
                'Mobile Header',
                'Expanded Menu: Logo',
                'Expanded Menu: Contact Info',
                'Header: Logo',
                'Header: Contact Info',
                'Home: Slider',
                'Home: Quick Search',
                'Home: Proven Performance',
                'Home: Featured Properties',
                'Home: Welcome',
                'Home: Featured Communities',
                'Home: Reviews',
                'Home: Call to Action',
                'Home: Latest News',
                'Home: Facebook',
                'Home: Instagram',
                'Footer: Form',
                'Footer: Logo',
                'Footer: Brokerage Logo',
                'Footer: Contact Info',
                'Footer: Company',
                'Footer: Newsletter',
                'Footer: Social Media',
                'Footer: Disclaimer',
            ];

            foreach ($items as $item) {
                if (! empty($item)) {
                    register_sidebar([
                        'name' => $item,
                        'id' => sanitize_title($item),
                        'before_widget' => '',
                        'after_widget' => '',
                        'before_title' => '',
                        'after_title' => ''
                    ]);
                }
            }

        }

    }

    new AIOSSTARTETHEMEWIDGETS();