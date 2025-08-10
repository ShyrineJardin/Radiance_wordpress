<?php

echo wp_kses_post(getActivityLogByCategory('Taxonomy', esc_attr($_GET['search'])));
