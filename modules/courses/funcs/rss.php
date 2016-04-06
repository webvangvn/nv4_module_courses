<?php

/**
 * @Project NUKEVIET 4.x
 * @Author webvang (hoang.nguyen@webvang.vn)
 * @Copyright (C) 2016 webvang. All rights reserved
 * @License: Not free read more http://nukeviet.vn/vi/store/modules/nvtools/
 * @Createdate Wed, 06 Apr 2016 09:05:18 GMT
 */

if ( ! defined( 'NV_IS_MOD_COURSES' ) ) die( 'Stop!!!' );

$page_title = $module_info['custom_title'];
$key_words = $module_info['keywords'];

$array_data = array();



$contents = nv_theme_courses_rss( $array_data );

include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme( $contents );
include NV_ROOTDIR . '/includes/footer.php';
