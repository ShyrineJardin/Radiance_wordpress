<div class="wpui-row wpui-templates">
	<?php foreach ($contact_templates as $template) : ?>
        <div class="wpui-col-md-6 my-3">
            <div class="wpui-template <?=$template['active'] ? "active-template" : ""?> <?=($template['available'] ? '' : 'wpui-template-lock')?>">
                <div class="wpui-template-canvas">
                <canvas width="500" height="300" style="background-image: url( <?=$template['screenshot']?> );"></canvas>
                <?=($template['available'] ? '' : '<div class="wpui-template-banner-lock ai-font-lock-b"></div>')?>
                </div>
                <?php if ($template['available']) : ?>
                    <div class="wpui-details">
                        <span><?=$template['name']?></span>
                        <?php if ($template['active']) : ?>
                            <a href="" class="wpui-template-activator wpui-template-activated">Active</a>
                        <?php else: ?>
                            <a href="" class="wpui-template-activator" data-theme-name="contact-theme" data-theme-value="<?=$template['fullname']?>" data-theme-slug="<?=$template['name']?>">Activate</a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
	<?php endforeach; ?>
</div>
