<?php

echo wp_kses_post(getActivityLogByCategory('all', esc_attr($_GET['search'])));
