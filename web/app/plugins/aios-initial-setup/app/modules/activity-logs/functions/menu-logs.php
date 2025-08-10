<?php

echo wp_kses_post(getActivityLogByCategory('Menu', esc_attr($_GET['search'])));
