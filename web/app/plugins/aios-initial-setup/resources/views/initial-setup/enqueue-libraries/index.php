<!-- BEGIN: Row Box -->
<!--<div class="wpui-row wpui-row-box">-->
<!--  <div class="wpui-col-md-3">-->
<!--    <p class="mt-2"><span class="wpui-settings-title">Minified Resources</span></p>-->
<!--  </div>-->
<!--  <div class="wpui-col-md-9">-->
<!--    <div class="form-group">-->
<!--      <div class="form-checkbox-group">-->
<!--        <div class="form-toggle-switch">-->
<!--          <div class="form-checkbox">-->
<!--            <label>-->
<!--              <input type="checkbox" name="aios-enqueue-cdn[enable-minified-resources]" value="1" -->
<!--              Enable serving minified resources.-->
<!--            </label>-->
<!--            <p>Turning on this option will serve resources in one cdn files.</p>-->
<!--            <input id="refresh-minified-resources" type="submit" class="wpui-default-button text-uppercase wpui-min-width-initial mt-3" value="Refresh Minified Resources">-->
<!--          </div>-->
<!--        </div>-->
<!--      </div>-->
<!--    </div>-->
<!--  </div>-->
<!--</div>-->
<!-- END: Row Box -->

<!-- BEGIN: Row Box -->
<div class="wpui-row wpui-row-box">
	<div class="wpui-col-md-3">
		<p class="mt-0"><span class="wpui-settings-title">Enqueue Libraries</span> Libraries will be enqueue on Front End</p>
	</div>
	<div class="wpui-col-md-9">
		<div class="form-group">
			<div class="form-checkbox-group">

        <div class="form-toggle-switch">
          <div class="form-checkbox">
            <label>
              <input type="checkbox" name="aios-enqueue-cdn[lazyframe]" id="lazyframe" value="1" <?= $libraries['lazyframe'] ?? '' === 1 ? 'checked=checked' : '' ?>>
              <strong>Lazyframe</strong>
              <span class="form-group-description"><strong>JavaScript</strong> <em>(handler: </em>aios-lazyframe<em>)</em> - Lazyframe creates a responsive placeholder for embedded content and requests it when the user interacts with it. This decreases the page load and idle time. <a href="https://vb.github.io/lazyframe/" target="_blank">Demo</a></span>
            </label>
          </div>
        </div>

        <div class="form-toggle-switch">
          <div class="form-checkbox">
            <label>
              <input type="checkbox" name="aios-enqueue-cdn[picturefill]" id="picturefill" value="1" <?= $libraries['picturefill'] ?? '' === 1 ? 'checked=checked' : '' ?>>
              <strong>Picturefill</strong>
              <span class="form-group-description"><strong>JavaScript</strong> <em>(handler: </em>aios-picturefill<em>)</em> - Picturefill enables support for the picture element and associated features in browsers that do not yet support them. <a href="http://scottjehl.github.io/picturefill/" target="_blank">Demo</a></span>
            </label>
          </div>
        </div>

        <div class="form-toggle-switch">
          <div class="form-checkbox">
            <label>
              <input type="checkbox" name="aios-enqueue-cdn[bootstrap_no_components_css]" id="bootstrap_no_components_css" value="1" <?= $libraries['bootstrap_no_components_css'] ?? '' === 1 ? 'checked=checked' : '' ?>>
              <strong>CSS Bootstrap without Components</strong>
              <span class="form-group-description"><strong>CSS</strong> <em>(handler: </em>aios-starter-theme-bootstrap<em>)</em> - This will have only common css such as Grid system Tables, Forms, Buttons, Responsive utilities</span>
            </label>
          </div>
        </div>

        <div class="form-toggle-switch">
          <div class="form-checkbox">
            <label>
              <input type="checkbox" name="aios-enqueue-cdn[utilities]" id="utilities" value="1" <?= $libraries['utilities'] ?? '' === 1 ? 'checked=checked' : '' ?>>
              Utilities
              <span class="form-group-description"><strong>CSS</strong> <em>(handler: </em>aios-utilities-style<em>)</em> - <a href="https://im-demo.agentimage.com/aios-utilities/" target="_blank">Demo</a></span>
            </label>
          </div>
        </div>

        <div class="form-toggle-switch">
          <div class="form-checkbox">
            <label>
              <input type="checkbox" name="aios-enqueue-cdn[autosize]" id="autosize" value="1" <?= $libraries['autosize'] ?? '' === 1 ? 'checked=checked' : '' ?>>
              Autosize
              <span class="form-group-description"><strong>JavaScript</strong> <em>(handler: </em>aios-autosize-script<em>)</em></span>
            </label>
          </div>
        </div>

        <div class="form-toggle-switch">
          <div class="form-checkbox">
            <label>
              <input type="checkbox" name="aios-enqueue-cdn[chainHeight]" id="chainHeight" value="1" <?= $libraries['chainHight'] ?? '' === 1 || $libraries['chainHeight'] ?? '' === 1 ? 'checked=checked' : '' ?>>
              Chain Height
              <span class="form-group-description"><strong>JavaScript</strong> <em>(handler: </em>aios-chain-height-script<em>)</em></span>
            </label>
          </div>
        </div>

        <div class="form-toggle-switch">
          <div class="form-checkbox">
            <label>
              <input type="checkbox" name="aios-enqueue-cdn[splitNav]" id="splitNav" value="1" <?= $libraries['splitNav'] ?? '' === 1 ? 'checked=checked' : '' ?>>
              Split Nav
              <span class="form-group-description"><strong>JavaScript</strong> <em>(handler: </em>aios-splitNav-script<em>)</em></span>
            </label>
          </div>
        </div>

        <div class="form-toggle-switch">
          <div class="form-checkbox">
            <label>
              <input type="checkbox" name="aios-enqueue-cdn[slick]" id="slick" value="1" <?= $libraries['slick'] ?? '' === 1 ? 'checked=checked' : '' ?>>
              Slick v1.9.0
              <span class="form-group-description"><strong>CSS & JavaScript</strong> <em>(handler: </em>aios-slick-style AND aios-slick-script<em>)</em> - <a href="http://kenwheeler.github.io/slick/" target="_blank">Demo</a></span>
            </label>
          </div>
        </div>

        <div class="form-toggle-switch">
          <div class="form-checkbox">
            <label>
              <input type="checkbox" name="aios-enqueue-cdn[slick-1-8-1]" id="slick" value="1" <?= $libraries['slick-1-8-1'] ?? '' === 1 ? 'checked=checked' : '' ?>>
              Slick v1.8.1
              <span class="form-group-description"><strong>CSS & JavaScript</strong> <em>(handler: </em>aios-slick-style AND aios-slick-script<em>)</em> - <a href="http://kenwheeler.github.io/slick/" target="_blank">Demo</a></span>
            </label>
          </div>
        </div>

        <div class="form-toggle-switch">
          <div class="form-checkbox">
            <label>
              <input type="checkbox" name="aios-enqueue-cdn[swiper]" id="swiper" value="1" <?= $libraries['swiper'] ?? '' === 1 ? 'checked=checked' : '' ?>>
              Swiper 4.5.0
              <span class="form-group-description"><strong>CSS & JavaScript</strong> <em>(handler: </em>aios-swiper-style AND aios-swiper-script<em>)</em> - <a href="https://idangero.us/swiper/demos/" target="_blank">Demo</a></span>
            </label>
          </div>
        </div>

        <div class="form-toggle-switch">
          <div class="form-checkbox">
            <label>
              <input type="checkbox" name="aios-enqueue-cdn[simplebar]" id="simplebar" value="1" <?= $libraries['simplebar'] ?? '' === 1 ? 'checked=checked' : '' ?>>
              Simplebar v2.6.1
              <span class="form-group-description"><strong>CSS & JavaScript</strong> <em>(handler: </em>aios-simplebar-style AND aios-simplebar-script<em>)</em> - <a href="https://grsmto.github.io/simplebar/" target="_blank">Demo</a></span>
            </label>
          </div>
        </div>

        <div class="form-toggle-switch">
          <div class="form-checkbox">
            <label>
              <input type="checkbox" name="aios-enqueue-cdn[videoPlyr]" id="videoPlyr" value="1" <?= $libraries['videoPlyr'] ?? '' === 1 ? 'checked=checked' : '' ?>>
              Video Player
              <span class="form-group-description"><strong>JavaScript</strong> <em>(handler: </em>aios-videoPlyr-script<em>)</em></span>
            </label>
          </div>
        </div>

        <div class="form-toggle-switch">
          <div class="form-checkbox">
            <label>
              <input type="checkbox" name="aios-enqueue-cdn[sidebar_navigation]" id="sidebar_navigation" value="1" <?= $libraries['sidebar_navigation'] ?? '' === 1 ? 'checked=checked' : '' ?>>
              Sidebar Navigation v1.0.1
              <span class="form-group-description"><strong>JavaScript</strong> <em>(handler: </em>aios-sidebar-navigation-script<em>)</em></span>
            </label>
          </div>
        </div>

        <div class="form-toggle-switch">
          <div class="form-checkbox">
            <label>
              <input type="checkbox" name="aios-enqueue-cdn[aos]" id="aos" value="1" <?= $libraries['aos'] ?? '' === 1 ? 'checked=checked' : '' ?>>
              Animate On Scroll Library
              <span class="form-group-description"><strong>CSS & JavaScript</strong> <em>(handler: </em>aios-aos-style AND aios-aos-script<em>)</em> - <a href="https://michalsnik.github.io/aos/" target="_blank">Demo</a></span>
            </label>
          </div>
        </div>

        <div class="form-toggle-switch">
          <div class="form-checkbox">
            <label>
              <input type="checkbox" name="aios-enqueue-cdn[aos-mobile]" id="aos-mobile" value="1" <?= $libraries['aos-mobile'] ?? '' === 1 ? 'checked=checked' : '' ?>>
              Animate On Scroll Library on Mobile
              <span class="form-group-description">Option above should be enabled</span>
            </label>
          </div>
        </div>

        <div class="form-toggle-switch">
          <div class="form-checkbox">
            <label>
              <input type="checkbox" name="aios-enqueue-cdn[aios_lozad]" id="aios_lozad" value="1" <?= $libraries['aios_lozad'] ?? '' === 1 ? 'checked=checked' : '' ?>>
              Vanilla LazyLoad
              <span class="form-group-description"><strong>Lazy Load Images Video,Iframes, Background Images</strong><br>
                <em>
                  <strong>Class</strong>
                  aios-lazyload<br>
                  <strong>Data Handler</strong></br>
                  <strong>Background Image</strong> = data-aios-lazy-bg<br>
                  <strong>Image, Video, iframe</strong> = data-aios-lazy-src<br>
                <a href="https://github.com/verlok/vanilla-lazyload/tree/master" target="_blank">Demo</a>
                </em>
              </span>
            </label>
          </div>
        </div>


        <?php 
          $productSelected = get_option('aios_custom_login_screen');

          if ($productSelected != 'default') :
        ?>
        <hr class="mt-3">
        <div class="aios-font-options">
          <h5>Fonts</h5>
          <p class="float-left w-100 mt-3 mb-3"><strong>Compass</strong></p>

          <div class="form-toggle-switch">
              <div class="form-checkbox">
                <label>
                  <input type="checkbox" name="aios-enqueue-cdn[compass_serif]" id="compass_serif" value="1" <?= $libraries['compass_serif'] ?? '' === 1 ? 'checked=checked' : '' ?>>
                  Serif
                  <span class="form-group-description"><strong>Attributes</strong></span>
                  <ul>
                    <li>font-family:'Compass Serif';</li>
                    <li>font-weight: 400, 500, 600, 700</li>
                  </ul>

                  <span class="form-group-description"><strong>Alternate Family</strong></span>
                  <ul>
                    <li>font-family: 'Compass Serif Text';</li>
                    <li>font-weight: 400, 700</li>
                  </ul>
                </label>
              </div>
          </div>
          <div class="form-toggle-switch">
            <div class="form-checkbox">
              <label>
                <input type="checkbox" name="aios-enqueue-cdn[compass_sans_serif]" id="compass_sans_serif" value="1" <?= $libraries['compass_sans_serif'] ?? '' === 1 ? 'checked=checked' : '' ?>>
                Sans-Serif
                <span class="form-group-description"><strong>Attributes</strong></span>
                  <ul>
                    <li>font-family:'Compass Sans'</li>
                    <li>font-weight: 400, 500, 700</li>
                  </ul>

              </label>
            </div>
          </div>
          <div class="form-toggle-switch">
            <div class="form-checkbox">
              <label>
                <input type="checkbox" name="aios-enqueue-cdn[compass_pressura_mono]" id="compass_pressura_mono" value="1" <?= $libraries['compass_pressura_mono'] ?? '' === 1 ? 'checked=checked' : '' ?>>
                GT Pressura Mono
                <span class="form-group-description"><strong>Attributes</strong></span>
                <ul>
                  <li>font-family: 'GT Pressura Mono';</li>
                  <li>font-weight: 300, 400, 700</li>
                </ul>
              </label>
            </div>
          </div>
        </div>
        <?php endif;?>
        <hr class="mt-3"> 
        <div class="form-toggle-switch">
          <div class="form-checkbox">
            <label>
              <input type="checkbox" name="aios-enqueue-cdn[animate]" id="animate" value="1" <?= $libraries['animate'] ?? '' === 1 ? 'checked=checked' : '' ?>>
              Animate(Deprecated)
              <span class="form-group-description"><strong>CSS</strong> <em>(handler: </em>aios-animate-style<em>)</em> - <a href="https://daneden.github.io/animate.css/" target="_blank">Demo</a></span>
            </label>
          </div>
        </div>

        <div class="form-toggle-switch">
          <div class="form-checkbox">
            <label>
              <input type="checkbox" name="aios-enqueue-cdn[elementpeek]" id="elementpeek" value="1" <?= $libraries['elementpeek'] ?? '' === 1 ? 'checked=checked' : '' ?> data-require="animate">
              ElementPeek
              <span class="form-group-description"><strong>JavaScript</strong> <em>(handler: </em>aios-elementpeek-script<em>)</em> - <a href="https://im-demo.agentimage.com/element-peek/" target="_blank">Demo</a></span>
            </label>
          </div>
        </div>

			</div>
		</div>
	</div>
</div>
<!-- END: Row Box -->

<!-- BEGIN: Row Box -->
<div class="wpui-row wpui-row-submit">
	<div class="wpui-col-md-12">
		<div class="form-group">
			<input type="submit" class="save-option-ajax wpui-secondary-button text-uppercase" value="Save Changes">
		</div>
	</div>
</div>
<!-- END: Row Box -->
