<?php

echo wp_kses_post(getActivityLogByCategory('Plugin', esc_attr($_GET['search'])));
