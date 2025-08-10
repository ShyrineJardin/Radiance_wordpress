<?php

echo wp_kses_post(getActivityLogByCategory('Posts/Pages', esc_attr($_GET['search'])));
