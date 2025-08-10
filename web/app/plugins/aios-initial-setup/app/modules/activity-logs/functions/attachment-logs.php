<?php

echo wp_kses_post(getActivityLogByCategory('Attachment', esc_attr($_GET['search'])));
