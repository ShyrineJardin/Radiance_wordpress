<?php
echo wp_kses_post(getActivityLogByCategory('Theme', esc_attr($_GET['search'])));
