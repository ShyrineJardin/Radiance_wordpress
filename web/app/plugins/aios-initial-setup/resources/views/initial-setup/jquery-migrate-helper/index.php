<!-- BEGIN: Row Box -->
<div class="wpui-row wpui-row-box">
  <div class="wpui-col-md-3">
    <p class="mt-0"><span class="wpui-settings-title">Admin Area</span> Default version 3.5.1</p>
  </div>
  <div class="wpui-col-md-9">
    <div class="form-group mt-1">
      <div class="form-checkbox-group">
        <div class="form-checkbox">
          <label>
            <input type="checkbox" name="aios-jquery-migrate[admin]" value="1" <?= $jQueryMigrate['admin'] ?? '' === 1 ? 'checked=checked' : '' ?>> Use jQuery version 1.12.4
          </label>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- END: Row Box -->

<!-- BEGIN: Row Box -->
<div class="wpui-row wpui-row-box">
  <div class="wpui-col-md-3">
    <p class="mt-0"><span class="wpui-settings-title">Frontend Area</span> Default version 1.12.4</p>
  </div>
  <div class="wpui-col-md-9">
    <div class="form-group mt-1">
      <div class="form-checkbox-group">
        <div class="form-checkbox">
          <label>
            <input type="checkbox" name="aios-jquery-migrate[frontend]" value="1" <?= $jQueryMigrate['frontend'] ?? '' === 1 ? 'checked=checked' : '' ?>> Use jQuery version 3.5.1
          </label>
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
