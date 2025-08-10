<?php

echo wp_kses_post(getActivityLogByCategory('Options', esc_attr($_GET['search'])));
