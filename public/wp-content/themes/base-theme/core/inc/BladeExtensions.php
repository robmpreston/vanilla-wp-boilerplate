<?php

/*
 * Add custom extension @acfrepeater to Bladerunner
 */
add_filter('bladerunner/extend', function($extensions) {
    $extensions[] = [
        'pattern' => '/(\s*)@acfrepeater\(((\s*)(.+))\)/',
        'replace' => '$1<?php if ( get_field( $2 ) ) : while ( has_sub_field( $2 ) ) : ',
    ];

    $extensions[] = [
        'pattern' => '/@acfend/',
        'replace' => '<?php endwhile; endif; ?>'
    ];

    return $extensions;
});

add_filter('bladerunner/template/bladepath', function ($path) { return $path . '/views'; });
