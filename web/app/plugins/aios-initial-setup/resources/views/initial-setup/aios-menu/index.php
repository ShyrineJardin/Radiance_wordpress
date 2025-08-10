<!-- BEGIN: Row Box -->
<div class="wpui-row wpui-row-box">
  <div class="wpui-col-md-3">
    <p class="mt-0"><span class="wpui-settings-title">Cache</p>
  </div>
  <div class="wpui-col-md-9">
    <div class="form-group mt-1">
        <?php 
          if($aios_menu['disable_transient'] == 'true'){
            echo '<a href="#" class="wpui-secondary-button text-uppercase enable-aios-menu-cache">Enable</a>';
          }else{
             echo '<a href="#" class="wpui-secondary-button text-uppercase disable-aios-menu-cache">Disable</a>';
          }

        ?>
        <span class="form-group-description">Cache will automatically Enable after 1 hr from the time you disable it</span>
    </div>
  </div>
</div>
<!-- END: Row Box -->

<!-- BEGIN: Row Box -->
<div class="wpui-row wpui-row-box">
  <div class="wpui-col-md-3">
    <p class="mt-0"><span class="wpui-settings-title">Cache Expiration</span></p>
  </div>
  <div class="wpui-col-md-9">
    <div class="form-group mt-1">
     	<input type="text" name="aios-menu-settings[expiration_duration]" id="aios-menu-expiration-duration" placeholder="86400(1 day)" value="<?= $aios_menu['expiration_duration'] ?>">
        <span class="form-group-description">This needs to be base on seconds</span>
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
