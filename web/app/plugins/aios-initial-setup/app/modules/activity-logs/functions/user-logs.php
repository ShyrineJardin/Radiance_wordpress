<?php

echo wp_kses_post(getActivityLogByCategory('User', esc_attr($_GET['search'])));
