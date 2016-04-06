<?php

/**
 * @Project NUKEVIET 4.x
 * @Author webvang (hoang.nguyen@webvang.vn)
 * @Copyright (C) 2016 webvang. All rights reserved
 * @License: Not free read more http://nukeviet.vn/vi/store/modules/nvtools/
 * @Createdate Wed, 06 Apr 2016 09:05:18 GMT
 */

if ( ! defined( 'NV_IS_MOD_COURSES' ) ) die( 'Stop!!!' );

/**
 * nv_theme_courses_main()
 * 
 * @param mixed $array_data
 * @return
 */
function nv_theme_courses_main ( $array_data )
{
    global $global_config, $module_name, $module_file, $lang_module, $module_config, $module_info, $op;

    $xtpl = new XTemplate( $op . '.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file );
    $xtpl->assign( 'LANG', $lang_module );

    

    $xtpl->parse( 'main' );
    return $xtpl->text( 'main' );
}

/**
 * nv_theme_courses_detail()
 * 
 * @param mixed $array_data
 * @return
 */
function nv_theme_courses_detail ( $array_data )
{
    global $global_config, $module_name, $module_file, $lang_module, $module_config, $module_info, $op;

    $xtpl = new XTemplate( $op . '.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file );
    $xtpl->assign( 'LANG', $lang_module );

    

    $xtpl->parse( 'main' );
    return $xtpl->text( 'main' );
}

/**
 * nv_theme_courses_search()
 * 
 * @param mixed $array_data
 * @return
 */
function nv_theme_courses_search ( $array_data )
{
    global $global_config, $module_name, $module_file, $lang_module, $module_config, $module_info, $op;

    $xtpl = new XTemplate( $op . '.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file );
    $xtpl->assign( 'LANG', $lang_module );

    

    $xtpl->parse( 'main' );
    return $xtpl->text( 'main' );
}

/**
 * nv_theme_courses_rss()
 * 
 * @param mixed $array_data
 * @return
 */
function nv_theme_courses_rss ( $array_data )
{
    global $global_config, $module_name, $module_file, $lang_module, $module_config, $module_info, $op;

    $xtpl = new XTemplate( $op . '.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file );
    $xtpl->assign( 'LANG', $lang_module );

    

    $xtpl->parse( 'main' );
    return $xtpl->text( 'main' );
}

/**
 * nv_theme_courses_Sitemap()
 * 
 * @param mixed $array_data
 * @return
 */
function nv_theme_courses_Sitemap ( $array_data )
{
    global $global_config, $module_name, $module_file, $lang_module, $module_config, $module_info, $op;

    $xtpl = new XTemplate( $op . '.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file );
    $xtpl->assign( 'LANG', $lang_module );

    

    $xtpl->parse( 'main' );
    return $xtpl->text( 'main' );
}

/**
 * nv_theme_courses_viewcat()
 * 
 * @param mixed $array_data
 * @return
 */
function nv_theme_courses_viewcat ( $array_data )
{
    global $global_config, $module_name, $module_file, $lang_module, $module_config, $module_info, $op;

    $xtpl = new XTemplate( $op . '.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file );
    $xtpl->assign( 'LANG', $lang_module );

    

    $xtpl->parse( 'main' );
    return $xtpl->text( 'main' );
}