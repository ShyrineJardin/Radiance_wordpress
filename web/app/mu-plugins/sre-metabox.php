<?php

add_action( 'wp_dashboard_setup', 'sre_dashboard_announcement_setup_function', 1 );
function sre_dashboard_announcement_setup_function() {
    add_meta_box( 'my_dashboard_widget', 'System Maintenance Notice', 'sre_dashboard_announcement_widget_function', 'dashboard', 'normal', 'high' );
}
function sre_dashboard_announcement_widget_function() {
    echo '<p>Our servers will be undergoing system maintenance on  November 16, 2023  </p>';
    echo '<ul> ';
        echo '<li><strong>Server Maintenance - November 16, 2023 between 1 and 3 AM Pacific time</strong>';
            echo '<ul>';
                echo '<li>We would like to inform you that our IT department will be conducting essential system maintenance to enhance the performance and reliability of our services. The maintenance is scheduled to take place on November 16, 2023 between 1 and 3 AM Pacific time. During this period, there may be temporary interruptions in accessing your site. We apologize for any inconvenience caused and assure you that our team will work diligently to minimize the downtime</li>';
            echo '</ul>';
        echo '</li>';
    echo '</ul>';
    echo '<p>Kindly note that our IT department has scheduled system and service maintenance on the specified dates. The outage is anticipated to occur within the specified window but may extend beyond those limits. We apologize for any inconvenience this may cause and appreciate your understanding. Thank you!</p>';
}
