<?php 
    /*
    * Template Name: About
    */

get_header();?>


<div id="ip-radiance-about" class="ip-radiance-about">
    <div id="content-full">
        <article id="content" class="hfeed about-hfeed">

            <?php do_action('aios_starter_theme_before_inner_page_content') ?>

            <?php if(have_posts()) : ?>

                <?php while(have_posts()) : the_post(); ?>

                    <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                        <?php 
                            $aios_metaboxes_banner_title_layout = get_option( 'aios-metaboxes-banner-title-layout', '' );
                            if ( ! is_custom_field_banner( get_queried_object() ) || $aios_metaboxes_banner_title_layout[1] != 1 ) {
                                $aioscm_used_custom_title   = get_post_meta( get_the_ID(), 'aioscm_used_custom_title', true );
                                $aioscm_main_title          = get_post_meta( get_the_ID(), 'aioscm_main_title', true );
                                $aioscm_sub_title           = get_post_meta( get_the_ID(), 'aioscm_sub_title', true );
                                $aioscm_title               = $aioscm_used_custom_title == 1 ? $aioscm_main_title . '<span>' . $aioscm_sub_title . '</span>' : get_the_title();
                                echo '<h1 class="entry-title">' . $aioscm_title . '</h1>';
                            }
                        ?>

                        <?php do_action('aios_starter_theme_before_entry_content') ?>

                        <div class="entry entry-content about-entry-content"    >
                  
                            <!-- about template -->
                            
                            <section class="about-radiance">
                                <div class="about-radiance__container site-container">
                                    <div class="about-radiance__wrapper">
                                
                                        <div class="about-radiance__image">
                                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/wc-photo.jpg" alt="Liam Anderson">
                                        </div>

                                            <div class="about-radiance__header"> 
                                                <h2 class="about-radiance__title">LIAM ANDERSON</h2> 
                                                <div class="about-radiance__subtitle">
                                                    <span class="about-radiance__subtitle-line"></span> 
                                                    <h3 class="about-radiance__subtitle-text">Luxury Real Estate</h3>
                                                </div>
                                            </div>
                                            
                                            <div class="about-radiance__paragraph">

                                                <p>Liam Anderson not only represents homebuyers in Los Angeles; he lives there. That gives him a decided advantage over other agents who live in other parts of Los Angeles. His knowledge and experience when it comes  to buying and selling real estate in Los Angeles are simply unmatched.</p>
                                                <p>His thorough familiarity and knowledge of Los Angeles' communities,  neighborhoods, and local attractions help him match his clients with the right home for them. Liam Anderson is able to give his clients detailed information about the pluses and minuses of each area. Plus, as a  certified relocation expert, he stays on top of the latest changes and  trends in both the local and national real estate markets.</p>
                                                <p>A  graduate of General University and licensed by the Los Angeles Licensing Board, his educational background, combined with his many years of  experience, is what makes him a top agent at Luxury Real Estate. His  professionalism, winning personality, and personalized service are just  what buyers need to find the homes of their dreams.</p>
                                                <p>In the course  of five years, he has earned his reputation as a driven agent who gives  his clients a smooth and stress-free home buying and selling experience. He understands that every client is different and will work tirelessly  to help them achieve their real estate goals. There is no  one-size-fits-all method for representing his clients in their real  estate transactions.</p>
                                                
                                                <span class="paragraph-title">Track Record of Success</span>
                                                <p>Liam Anderson has a long track record of success as an agent with Luxury Real Estate. The quality of his service is something that all of his  clients are happy to attest to. Knowing the real estate business the way that he does has given him a stellar list of satisfied clients who list among his many great qualities his expertise.</p>
                                                <p>Compared to other area agents, no one comes close. Liam Anderson  works hard to get his clients the best deal, whether they are buying or  selling a home. Most importantly, he is there every step of the way to  answer his clients' questions promptly and straightforwardly.</p>
                                                <p>According to Liam Anderson, helping his clients understand the whole process is  part of his job. His goal is to serve as a trusted advisor and guide,  educating his clients so that they are a part of the process. His  invaluable input saves homebuyers thousands and gets sellers the best  asking price possible. That is exactly the type of agent buyers and  sellers want and need!</p>
                                                
                                                <span class="paragraph-title">Working With Liam Anderson</span>
                                                <p>There is a lot of peace of mind that comes with working with Liam  Anderson. He puts the effort and time into building strong relationships with his clients, which is crucial to creating a positive real estate  experience. When there are tough choices to be made and important  details to iron out, his clients trust him to help them make the right  decisions.</p>
                                                <p>Liam Anderson exemplifies the quality agents that  represent Luxury Real Estate. He doesn’t push his clients into buying  more houses than they can afford, and he doesn’t hold back any  information about the neighborhoods in Los Angeles. He is always on his  clients’ side, like a loyal friend. With all that he offers, probably  the best thing about working with Liam Anderson is the hassle-free  experience he provides. He does the heavy lifting: crunching the  numbers, searching through thousands of listings, and negotiating with  sellers or buyers agents so that his clients aren’t stressed out.</p>
                                                
                                                <span class="paragraph-title">Talk to Liam Today!</span>
                                                <p>Does Liam sound too good to be true? Believe it or not, he is just that  good and is ready right now to start the process of buying or selling a  home with you. The best way to find out just how good he is is to talk  to Liam today! We are positive that you will agree that Liam is the best agent in Los Angeles!</p>
                                                <p>Take a look around Liam's site to see the  type of properties Liam represents and all of the services that he  provides. If you are ready to work with an agent who puts you and your  needs first, he is just one phone call away. Fill out the contact form  or simply pick up the phone to talk to Liam Anderson today!</p>
                                            </div>

                                            <div class="about-radiance__contact">
                                                <div class="about-radiance__contact-item about-radiance__contact-item--tel"> 
                                                    <div class="contact-icon">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M3.2703 0.035656C3.5523 0.109067 3.69385 0.219662 4.19869 0.76131C4.34113 0.914205 4.61537 1.20662 4.80807 1.41116C5.6433 2.29783 5.62943 2.28241 5.7289 2.43988C5.86984 2.66298 5.93086 2.88499 5.93244 3.18082C5.93498 3.64544 5.82316 3.87659 5.34846 4.3874C4.74992 5.03152 4.74821 5.08037 5.30061 5.79204C5.63245 6.21961 6.20429 6.91313 6.51759 7.26805C7.82045 8.74398 8.90453 9.85382 10.0908 10.9261C10.4422 11.2437 10.5423 11.3012 10.7238 11.2895C10.8952 11.2784 10.9175 11.2619 11.362 10.8177C11.9141 10.2659 12.0226 10.2056 12.4633 10.2056C12.822 10.2056 13.1265 10.3468 13.3729 10.6275C13.4203 10.6815 13.5769 10.8485 14.2916 11.6072C15.1648 12.5342 15.1714 12.5419 15.2758 12.7528C15.5308 13.2677 15.4639 13.8417 15.0972 14.2865C14.9053 14.5194 14.0231 15.4443 13.8854 15.5571C13.4816 15.8878 12.8178 16.0709 12.3734 15.9742C11.9453 15.881 11.7701 15.7916 11.1942 15.3718C8.67285 13.5344 6.29943 11.3129 4.31147 8.92949C2.91855 7.25945 1.00734 4.54821 0.729177 3.84759C0.425962 3.0838 0.569093 2.13013 1.08237 1.49413C1.20072 1.34737 2.08922 0.400325 2.19322 0.309993C2.50351 0.0404316 2.90022 -0.0606112 3.2703 0.035656Z" fill="#767676"/>
                                                        </svg>                        
                                                    </div>
                                                    <div class="contact-info">
                                                        <p>843.973.0182</p>
                                                    </div>
                                                </div>

                                                <div class="about-radiance__contact-item about-radiance__contact-item--email">
                                                    <div class="contact-icon">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="19" height="12" viewBox="0 0 19 12" fill="none">
                                                        <g opacity="0.999">
                                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M1.43056 0.000982513C6.76824 -0.00163687 12.1059 0.000982513 17.4436 0.00882497C17.6129 0.0517389 17.7687 0.119717 17.9111 0.212729C17.9515 0.244146 17.9655 0.283358 17.9529 0.330366C17.866 0.41715 17.7742 0.498194 17.6773 0.573482C14.9748 2.72906 12.2753 4.88834 9.579 7.05135C9.49868 7.11596 9.41519 7.1212 9.32853 7.06704C6.56229 4.85546 3.79606 2.64389 1.02981 0.432318C0.981391 0.394721 0.942436 0.350286 0.912931 0.298996C0.968367 0.204588 1.05186 0.139245 1.1634 0.102934C1.256 0.0723646 1.34505 0.0383754 1.43056 0.000982513Z" fill="#767676"/>
                                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M0.46211 1.16168C0.527866 1.16379 0.583535 1.18732 0.629087 1.23226C2.57715 2.81121 4.52519 4.39015 6.47325 5.9691C6.51144 6.00157 6.53926 6.04078 6.55674 6.08674C6.52724 6.13803 6.48828 6.18247 6.43986 6.22006C4.52586 7.73038 2.61677 9.24659 0.712575 10.7687C0.645267 10.8212 0.572916 10.8656 0.495506 10.902C0.457468 10.8976 0.437982 10.8767 0.437064 10.8393C0.425927 7.63432 0.425927 4.42936 0.437064 1.22442C0.44391 1.20244 0.452259 1.18153 0.46211 1.16168Z" fill="#767676"/>
                                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M18.3286 1.16168C18.3565 1.16168 18.3842 1.16168 18.4121 1.16168C18.4343 4.40323 18.4343 7.64477 18.4121 10.8863C18.3782 10.8889 18.3448 10.8862 18.3119 10.8785C16.331 9.31589 14.3552 7.7474 12.3842 6.17301C12.3408 6.13667 12.3269 6.09223 12.3425 6.03969C14.3312 4.40409 16.3265 2.77809 18.3286 1.16168Z" fill="#767676"/>
                                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M7.14115 6.6514C7.19373 6.64687 7.24382 6.65471 7.29143 6.67493C7.98224 7.24546 8.67796 7.81011 9.37863 8.3689C9.44462 8.38321 9.50585 8.37275 9.5623 8.33753C10.2215 7.7901 10.8839 7.24635 11.5493 6.7063C11.6086 6.65053 11.6754 6.64008 11.7497 6.67493C13.8167 8.31859 15.8788 9.96811 17.9362 11.6235C17.9579 11.6528 17.9634 11.6841 17.9529 11.7176C17.8712 11.7992 17.7739 11.8593 17.6607 11.898C17.5431 11.9269 17.4262 11.9582 17.31 11.9921C12.0614 12.0026 6.81276 12.0026 1.56414 11.9921C1.36073 11.9575 1.17148 11.8895 0.996422 11.7882C0.885684 11.7062 0.891261 11.6277 1.01312 11.5529C3.05409 9.91534 5.09676 8.28149 7.14115 6.6514Z" fill="#767676"/>
                                                        </g>
                                                        </svg>                       
                                                    </div>
                                                    <div class="contact-info">
                                                        <p>info@radienceluxuryrealestate.com</p>
                                                    </div>
                                                </div>

                                                <div class="about-radiance__contact-item about-radiance__contact-item--socials"> 
                                                    <div class="socials-logo">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40" fill="none">
                                                        <circle cx="20" cy="20" r="19.5" stroke="#767676"/>
                                                        <path d="M22 21.5H24.5L25.5 17.5H22V15.5C22 14.4706 22 13.5 24 13.5H25.5V10.1401C25.1743 10.0969 23.943 10 22.6429 10C19.9284 10 18 11.6569 18 14.6997V17.5H15V21.5H18V30H22V21.5Z" fill="#767676"/>
                                                        </svg>
                                                    </div>

                                                    <div class="socials-logo">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40" fill="none">
                                                        <circle cx="20" cy="20" r="19.5" stroke="#767676"/>
                                                        <path d="M11.0429 11L17.8409 20.9281L11 29H12.5396L18.5288 21.9329L23.3679 29H28.6072L21.4268 18.5135L27.7942 11H26.2546L20.7389 17.5087L16.2823 11H11.0429ZM13.307 12.2387H15.714L26.3428 27.7611H23.9358L13.307 12.2387Z" fill="#767676"/>
                                                        </svg>
                                                    </div>

                                                    <div class="socials-logo">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40" fill="none">
                                                            <circle cx="20" cy="20" r="19.5" stroke="#767676"/>
                                                            <g transform="translate(13, 13) scale(0.9)">
                                                                <path d="M3.04786 1.55568C3.04786 2.38137 2.5063 3.09279 1.52393 3.09279C0.597537 3.09279 0 2.42137 0 1.59568C0 0.748554 0.579345 0 1.52393 0C2.46851 0 3.02967 0.707127 3.04786 1.55568ZM0 13.9997V3.88848H3.04786V13.9997H0Z" fill="#767676"/>
                                                                <path d="M4.52563 7.34318C4.52563 6.14178 4.48645 5.13752 4.44727 4.2704H7.18586L7.3216 5.61037H7.37898C7.76521 4.97895 8.70979 4.05469 10.2911 4.05469C12.2208 4.05469 13.6678 5.37323 13.6678 8.20888V13.9973H10.62V8.66173C10.62 7.42175 10.1582 6.47606 9.09602 6.47606C8.28718 6.47606 7.88136 7.14462 7.66865 7.69603C7.59028 7.89317 7.57209 8.16888 7.57209 8.44459V13.9973H4.52563V7.34318Z" fill="#767676"/>
                                                            </g>
                                                        </svg>
                                                    </div>

                                                    <div class="socials-logo">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="43" height="42" viewBox="0 0 43 42" fill="none">
                                                            <path d="M21.4297 0.5C32.5052 0.5 41.501 9.66839 41.501 21C41.501 32.3316 32.5052 41.5 21.4297 41.5C10.3543 41.4999 1.3584 32.3316 1.3584 21C1.3584 9.66844 10.3543 0.500077 21.4297 0.5Z" stroke="#767676"/>
                                                            <path d="M31.8499 26.7201C31.6101 27.6174 30.9033 28.3242 30.0059 28.5641C28.3795 29 21.8573 29 21.8573 29C21.8573 29 15.335 29 13.7086 28.5641C12.8113 28.3242 12.1045 27.6174 11.8646 26.7201C11.4287 25.0937 11.4287 21.7 11.4287 21.7C11.4287 21.7 11.4287 18.3063 11.8646 16.6799C12.1045 15.7826 12.8113 15.0758 13.7086 14.8359C15.335 14.4 21.8573 14.4 21.8573 14.4C21.8573 14.4 28.3795 14.4 30.0059 14.8359C30.9033 15.0758 31.6101 15.7826 31.8499 16.6799C32.2859 18.3063 32.2859 21.7 32.2859 21.7C32.2859 21.7 32.2859 25.0937 31.8499 26.7201ZM19.7716 18.5714V24.8286L25.1903 21.7L19.7716 18.5714Z" fill="#767676"/>
                                                        </svg>
                                                    </div>

                                                    <div class="socials-logo">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="43" height="42" viewBox="0 0 43 42" fill="none">
                                                            <path d="M21.4297 0.5C32.5052 0.5 41.501 9.66839 41.501 21C41.501 32.3316 32.5052 41.5 21.4297 41.5C10.3543 41.4999 1.3584 32.3316 1.3584 21C1.3584 9.66844 10.3543 0.500077 21.4297 0.5Z" stroke="#767676"/>
                                                            <path d="M18.6629 13.1801C17.8421 13.2196 17.2816 13.3533 16.7916 13.5499C16.2844 13.7516 15.8546 14.0224 15.4269 14.4606C14.9992 14.8987 14.7359 15.3378 14.5396 15.8563C14.3497 16.3576 14.221 16.9303 14.1848 17.7687C14.1485 18.6071 14.1405 18.8766 14.1445 21.0151C14.1485 23.1536 14.1578 23.4217 14.1976 24.2618C14.2368 25.0996 14.3673 25.6716 14.5598 26.172C14.7578 26.6897 15.0227 27.1283 15.4521 27.5651C15.8814 28.0018 16.3113 28.27 16.8204 28.4707C17.3111 28.6643 17.8722 28.7963 18.6933 28.833C19.5144 28.8697 19.7787 28.8782 21.873 28.8741C23.9673 28.87 24.231 28.8605 25.0538 28.8207C25.8766 28.7808 26.434 28.6466 26.9243 28.451C27.4315 28.2485 27.8615 27.9785 28.289 27.54C28.7165 27.1015 28.9797 26.6621 29.1758 26.1433C29.3659 25.6425 29.495 25.0696 29.5307 24.232C29.5666 23.3915 29.5751 23.1231 29.5711 20.9849C29.5671 18.8466 29.5577 18.5786 29.5187 17.7388C29.4796 16.899 29.3489 16.3287 29.1565 15.828C28.9583 15.3103 28.6937 14.8719 28.2645 14.4349C27.8352 13.9978 27.4045 13.7293 26.8964 13.5296C26.4055 13.3357 25.8446 13.2035 25.0235 13.1673C24.2024 13.1311 23.9381 13.1218 21.8431 13.1259C19.748 13.13 19.4857 13.1391 18.6629 13.1801ZM18.753 27.4162C18.0009 27.3828 17.5925 27.2553 17.3203 27.1485C16.9599 27.0067 16.7032 26.8354 16.4319 26.5612C16.1607 26.287 15.9941 26.0239 15.8534 25.6568C15.7477 25.379 15.6204 24.9625 15.5852 24.1947C15.547 23.3648 15.5389 23.1157 15.5345 21.0132C15.53 18.9107 15.5379 18.6619 15.5735 17.8317C15.6056 17.0645 15.7313 16.6471 15.8358 16.3695C15.9746 16.0011 16.1419 15.7395 16.4111 15.4627C16.6803 15.186 16.9372 15.0156 17.2972 14.8719C17.569 14.7636 17.977 14.6348 18.7288 14.5982C19.5424 14.5588 19.7861 14.551 21.8454 14.5464C23.9046 14.5418 24.149 14.5497 24.9629 14.5862C25.7144 14.6196 26.1234 14.7467 26.3951 14.854C26.7557 14.9957 27.0123 15.166 27.2834 15.4413C27.5544 15.7166 27.7215 15.9779 27.8622 16.3462C27.9685 16.6229 28.0947 17.0392 28.1302 17.8071C28.169 18.6376 28.1778 18.8866 28.1815 20.9886C28.1852 23.0906 28.1779 23.3403 28.1423 24.1701C28.1094 24.938 27.9847 25.355 27.88 25.6332C27.7411 26.0009 27.5737 26.2632 27.3043 26.5397C27.035 26.8163 26.7784 26.9867 26.4183 27.1304C26.1467 27.2386 25.7383 27.3677 24.9871 27.4043C24.1736 27.4433 23.9298 27.4515 21.8698 27.4561C19.8097 27.4606 19.5667 27.4521 18.7532 27.4162M25.0419 16.7911C25.0422 16.978 25.0968 17.1606 25.1988 17.3159C25.3008 17.4711 25.4456 17.592 25.6148 17.6632C25.7841 17.7344 25.9703 17.7528 26.1498 17.716C26.3293 17.6792 26.4941 17.5889 26.6234 17.4565C26.7526 17.3241 26.8405 17.1555 26.8759 16.9721C26.9113 16.7887 26.8926 16.5988 26.8222 16.4262C26.7518 16.2537 26.6328 16.1063 26.4804 16.0027C26.328 15.8992 26.1489 15.8441 25.9657 15.8445C25.7203 15.845 25.4851 15.945 25.3118 16.1225C25.1386 16.3 25.0415 16.5405 25.0419 16.7911ZM17.8969 21.0079C17.9012 23.2412 19.678 25.0476 21.8653 25.0433C24.0526 25.0391 25.8233 23.2255 25.8192 20.9921C25.815 18.7587 24.0378 16.9519 21.8502 16.9563C19.6625 16.9607 17.8927 18.7748 17.8969 21.0079ZM19.2864 21.005C19.2854 20.4858 19.4352 19.978 19.7169 19.5457C19.9987 19.1135 20.3996 18.7762 20.8691 18.5766C21.3386 18.3769 21.8555 18.3239 22.3546 18.4242C22.8536 18.5245 23.3122 18.7736 23.6726 19.14C24.0329 19.5063 24.2787 19.9736 24.379 20.4826C24.4792 20.9916 24.4293 21.5195 24.2356 21.9996C24.0419 22.4796 23.7131 22.8903 23.2907 23.1796C22.8684 23.4689 22.3716 23.6239 21.863 23.6249C21.5253 23.6256 21.1907 23.5584 20.8785 23.4271C20.5662 23.2959 20.2823 23.1031 20.0431 22.8598C19.8038 22.6165 19.6138 22.3275 19.484 22.0092C19.3542 21.691 19.287 21.3498 19.2864 21.005Z" fill="#767676"/>
                                                        </svg>
                                                    </div>
                                                </div>
                                            </div>
                                    </div>
                                </div>
                            </section>

                            
                            <!-- end of about template -->
                            
                        </div>

                        <?php do_action('aios_starter_theme_after_entry_content') ?>

                    </div>

                <?php endwhile; ?>

            <?php endif; ?>

            <?php do_action('aios_starter_theme_after_inner_page_content') ?>

        </article><!-- end #content -->

    </div><!-- end #content-full -->

        <section class="hpcta">
            <div class="hpcta__container site-container">
                <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Home: Call to Action") ) : ?><?php endif ?>
            </div>
        </section><!-- end of cta -->
        
</div><!-- end #ip-about -->

<?php get_footer();?>
