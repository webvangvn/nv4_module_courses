<?php

/**
 * @Project NUKEVIET 4.x
 * @Author webvang (hoang.nguyen@webvang.vn)
 * @Copyright (C) 2016 webvang. All rights reserved
 * @License: Not free read more http://nukeviet.vn/vi/store/modules/nvtools/
 * @Createdate Wed, 06 Apr 2016 09:05:18 GMT
 */

if ( ! defined( 'NV_IS_MOD_COURSES' ) ) die( 'Stop!!!' );

function theme_main( $namhoc, $lophoc, $ext, $script)
{
    global $global_config, $lang_module, $module_info, $module_name, $module_file, $lang_global;
    $xtpl = new XTemplate( "main.tpl", NV_ROOTDIR . "/themes/" . $module_info['template'] . "/modules/".$module_file."/" );
    $xtpl->assign( 'LANG', $lang_module );
    $xtpl->assign( 'CAUHINH', $ext );
    $xtpl->assign( 'SCRIPT', $script );
    $hocki = array(1 => 'Học kì I', 2 => 'Học kì II', 3 => 'Cả năm');
    for ($i = 1; $i <=3; $i ++){
 	
    $xtpl->assign( 'MAHK', $i );
    $xtpl->assign( 'TENHK', $hocki[$i]);
    $xtpl->parse('main.block_table.loop_hk');
    }
	if ( ! empty( $namhoc) )
    {
       foreach ( $namhoc as $nhoc){
       $xtpl->assign( 'MANAMHOC', $nhoc[0]);
       $xtpl->assign( 'TENNAMHOC', $nhoc[1]);
       $xtpl->parse('main.block_table.loop_nh');
       }
    }
		if ( ! empty( $lophoc) )
    {
       foreach ( $lophoc as $lhoc){
       $xtpl->assign( 'MALOPHOC', $lhoc[0]);
       $xtpl->assign( 'TENLOPHOC', $lhoc[1]);
       $xtpl->parse('main.block_table.loop_lh');
       }
    }
    $xtpl->parse('main.block_table');
    $xtpl->parse( 'main' );
    return $xtpl->text( 'main' );
}

function viewcat_grid_new($array_sciencecatpage, $catid, $generate_page)
{
    global $site_mods, $module_name, $module_file, $module_upload, $lang_module, $module_config, $module_info, $global_array_sciencecat, $global_array_sciencecat, $catid, $page;

    $xtpl = new XTemplate('viewcat_grid.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file);
    $xtpl->assign('LANG', $lang_module);
    $xtpl->assign('IMGWIDTH1', $module_config[$module_name]['homewidth']);

    if ($catid > 0 and (($global_array_sciencecat[$catid]['viewdescription'] and $page == 1) or $global_array_sciencecat[$catid]['viewdescription'] == 2)) {
        $xtpl->assign('CONTENT', $global_array_sciencecat[$catid]);
        if ($global_array_sciencecat[$catid]['image']) {
            $xtpl->assign('HOMEIMG1', NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_upload . '/' . $global_array_sciencecat[$catid]['image']);
            $xtpl->parse('main.viewdescription.image');
        }
        $xtpl->parse('main.viewdescription');
    }

    if (! empty($catid)) {
        $xtpl->assign('CAT', $global_array_sciencecat[$catid]);
        $xtpl->parse('main.cattitle');
    }

    
    foreach ($array_sciencecatpage as $array_row_i) {
        $newday = $array_row_i['publtime'] + (86400 * $array_row_i['newday']);
        $array_row_i['publtime'] = nv_date('d/m/Y h:i:s A', $array_row_i['publtime']);

        $xtpl->clear_autoreset();
        if ($module_config[$module_name]['showtooltip']) {
            $array_row_i['hometext_clean'] = nv_clean60($array_row_i['hometext'], $module_config[$module_name]['tooltip_length'], true);
        }
        $xtpl->assign('CONTENT', $array_row_i);

        
            if ($module_config[$module_name]['showtooltip']) {
                $xtpl->assign('TOOLTIP_POSITION', $module_config[$module_name]['tooltip_position']);
                $xtpl->parse('main.viewcatloop.tooltip');
            }

            if (defined('NV_IS_MODADMIN')) {
                $xtpl->assign('ADMINLINK', nv_link_edit_page($array_row_i['id']) . " " . nv_link_delete_page($array_row_i['id']));
                $xtpl->parse('main.viewcatloop.adminlink');
            }

            if ($array_row_i['imghome'] != '') {
                $xtpl->assign('HOMEIMG1', $array_row_i['imghome']);
                $xtpl->assign('HOMEIMGALT1', ! empty($array_row_i['homeimgalt']) ? $array_row_i['homeimgalt'] : $array_row_i['name_courses']);
                $xtpl->parse('main.viewcatloop.image');
            }

            if ($newday >= NV_CURRENTTIME) {
                $xtpl->parse('main.viewcatloop.newday');
            }

            $xtpl->set_autoreset();
            $xtpl->parse('main.viewcatloop');
        
    }

    if (! empty($generate_page)) {
        $xtpl->assign('GENERATE_PAGE', $generate_page);
        $xtpl->parse('main.generate_page');
    }

    $xtpl->parse('main');
    return $xtpl->text('main');
}

function viewcat_list_new($array_sciencecatpage, $catid, $page, $generate_page)
{
    global $module_name, $module_file, $module_upload, $lang_module, $module_config, $module_info, $global_array_sciencecat;

    $xtpl = new XTemplate('viewcat_list.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file);
    $xtpl->assign('LANG', $lang_module);
    $xtpl->assign('IMGWIDTH1', $module_config[$module_name]['homewidth']);

    if ($catid > 0 and (($global_array_sciencecat[$catid]['viewdescription'] and $page == 0) or $global_array_sciencecat[$catid]['viewdescription'] == 2)) {
        $xtpl->assign('CONTENT', $global_array_sciencecat[$catid]);
        if ($global_array_sciencecat[$catid]['image']) {
            $xtpl->assign('HOMEIMG1', NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_upload . '/' . $global_array_sciencecat[$catid]['image']);
            $xtpl->parse('main.viewdescription.image');
        }
        $xtpl->parse('main.viewdescription');
    }

    $a = $page;
    foreach ($array_sciencecatpage as $array_row_i) {
        $newday = $array_row_i['publtime'] + (86400 * $array_row_i['newday']);
        $array_row_i['publtime'] = nv_date('d/m/Y h:i:s A', $array_row_i['publtime']);

        if ($module_config[$module_name]['showtooltip']) {
            $array_row_i['hometext'] = nv_clean60($array_row_i['hometext'], $module_config[$module_name]['tooltip_length'], true);
        }

        $xtpl->clear_autoreset();
        $xtpl->assign('NUMBER', ++$a);
        $xtpl->assign('CONTENT', $array_row_i);

        if ($module_config[$module_name]['showtooltip']) {
            $xtpl->assign('TOOLTIP_POSITION', $module_config[$module_name]['tooltip_position']);
            $xtpl->parse('main.viewcatloop.tooltip');
        }

        if (defined('NV_IS_MODADMIN')) {
            $xtpl->assign('ADMINLINK', nv_link_edit_page($array_row_i['id']) . " " . nv_link_delete_page($array_row_i['id']));
            $xtpl->parse('main.viewcatloop.adminlink');
        }

        if ($array_row_i['imghome'] != '') {
            $xtpl->assign('HOMEIMG1', $array_row_i['imghome']);
            $xtpl->assign('HOMEIMGALT1', ! empty($array_row_i['homeimgalt']) ? $array_row_i['homeimgalt'] : $array_row_i['title']);
            $xtpl->parse('main.viewcatloop.image');
        }

        if ($newday >= NV_CURRENTTIME) {
            $xtpl->parse('main.viewcatloop.newday');
        }

        $xtpl->set_autoreset();
        $xtpl->parse('main.viewcatloop');
    }
    if (! empty($generate_page)) {
        $xtpl->assign('GENERATE_PAGE', $generate_page);
        $xtpl->parse('main.generate_page');
    }

    $xtpl->parse('main');
    return $xtpl->text('main');
}

function viewcat_page_new($array_sciencecatpage, $array_sciencecat_other, $generate_page)
{
    global $site_mods, $global_array_sciencecat, $module_name, $module_file, $module_upload, $lang_module, $module_config, $module_info, $global_array_sciencecat, $catid, $page;

    $xtpl = new XTemplate('viewcat_page.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file);
    $xtpl->assign('LANG', $lang_module);
    $xtpl->assign('IMGWIDTH1', $module_config[$module_name]['homewidth']);

    if ($catid > 0 and (($global_array_sciencecat[$catid]['viewdescription'] and $page == 1) or $global_array_sciencecat[$catid]['viewdescription'] == 2)) {
        $xtpl->assign('CONTENT', $global_array_sciencecat[$catid]);
        if ($global_array_sciencecat[$catid]['image']) {
            $xtpl->assign('HOMEIMG1', NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_upload . '/' . $global_array_sciencecat[$catid]['image']);
            $xtpl->parse('main.viewdescription.image');
        }
        $xtpl->parse('main.viewdescription');
    }

    $a = 0;
    foreach ($array_sciencecatpage as $array_row_i) {
        $newday = $array_row_i['publtime'] + (86400 * $array_row_i['newday']);
        $array_row_i['publtime'] = nv_date('d/m/Y h:i:s A', $array_row_i['publtime']);
        $array_row_i['listcatid'] = explode(',', $array_row_i['listcatid']);
        $num_sciencecat = sizeof($array_row_i['listcatid']);

        $n = 1;
        foreach ($array_row_i['listcatid'] as $listcatid) {
            $listcat = array( 'title' => $global_array_sciencecat[$listcatid]['title'], "link" => $global_array_sciencecat[$listcatid]['link'] );
            $xtpl->assign('CAT', $listcat);
            (($n < $num_sciencecat) ? $xtpl->parse('main.viewcatloop.cat.comma') : '');
            $xtpl->parse('main.viewcatloop.cat');
            ++$n;
        }
        if ($a == 0) {
            $xtpl->clear_autoreset();
            $xtpl->assign('CONTENT', $array_row_i);

            if (defined('NV_IS_MODADMIN')) {
                $xtpl->assign('ADMINLINK', nv_link_edit_page($array_row_i['id']) . " " . nv_link_delete_page($array_row_i['id']));
                $xtpl->parse('main.viewcatloop.featured.adminlink');
            }

            if ($array_row_i['imghome'] != '') {
                $xtpl->assign('HOMEIMG1', $array_row_i['imghome']);
                $xtpl->assign('HOMEIMGALT1', ! empty($array_row_i['homeimgalt']) ? $array_row_i['homeimgalt'] : $array_row_i['title']);
                $xtpl->parse('main.viewcatloop.featured.image');
            }

            if ($newday >= NV_CURRENTTIME) {
                $xtpl->parse('main.viewcatloop.featured.newday');
            }

            if (isset($site_mods['comment']) and isset($module_config[$module_name]['activecomm']) and $module_config[$module_name]['activecomm']) {
                $xtpl->parse('main.viewcatloop.featured.comment');
            }

            $xtpl->parse('main.viewcatloop.featured');
        } else {
            $xtpl->clear_autoreset();
            $xtpl->assign('CONTENT', $array_row_i);

            if (defined('NV_IS_MODADMIN')) {
                $xtpl->assign('ADMINLINK', nv_link_edit_page($array_row_i['id']) . " " . nv_link_delete_page($array_row_i['id']));
                $xtpl->parse('main.viewcatloop.news.adminlink');
            }

            if ($array_row_i['imghome'] != '') {
                $xtpl->assign('HOMEIMG1', $array_row_i['imghome']);
                $xtpl->assign('HOMEIMGALT1', ! empty($array_row_i['homeimgalt']) ? $array_row_i['homeimgalt'] : $array_row_i['title']);
                $xtpl->parse('main.viewcatloop.news.image');
            }

            if ($newday >= NV_CURRENTTIME) {
                $xtpl->parse('main.viewcatloop.news.newday');
            }

            if (isset($site_mods['comment']) and isset($module_config[$module_name]['activecomm']) and $module_config[$module_name]['activecomm']) {
                $xtpl->parse('main.viewcatloop.news.comment');
            }

            $xtpl->set_autoreset();
            $xtpl->parse('main.viewcatloop.news');
        }
        ++$a;
    }
    $xtpl->parse('main.viewcatloop');

    if (! empty($array_sciencecat_other)) {
        $xtpl->assign('ORTHERNEWS', $lang_module['other']);

        foreach ($array_sciencecat_other as $array_row_i) {
            $newday = $array_row_i['publtime'] + (86400 * $array_row_i['newday']);
            $array_row_i['publtime'] = nv_date("d/m/Y", $array_row_i['publtime']);
            $xtpl->assign('RELATED', $array_row_i);
            if ($newday >= NV_CURRENTTIME) {
                $xtpl->parse('main.related.loop.newday');
            }
            $xtpl->parse('main.related.loop');
        }

        $xtpl->parse('main.related');
    }

    if (! empty($generate_page)) {
        $xtpl->assign('GENERATE_PAGE', $generate_page);
        $xtpl->parse('main.generate_page');
    }

    $xtpl->parse('main');
    return $xtpl->text('main');
}

function viewcat_top($array_sciencecatcontent, $generate_page)
{
    global $site_mods, $module_name, $module_file, $module_upload, $lang_module, $module_config, $module_info, $global_array_sciencecat, $catid, $page;

    $xtpl = new XTemplate('viewcat_top.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file);
    $xtpl->assign('LANG', $lang_module);
    $xtpl->assign('IMGWIDTH0', $module_config[$module_name]['homewidth']);

    if ($catid > 0 and (($global_array_sciencecat[$catid]['viewdescription'] and $page == 1) or $global_array_sciencecat[$catid]['viewdescription'] == 2)) {
        $xtpl->assign('CONTENT', $global_array_sciencecat[$catid]);
        if ($global_array_sciencecat[$catid]['image']) {
            $xtpl->assign('HOMEIMG1', NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_upload . '/' . $global_array_sciencecat[$catid]['image']);
            $xtpl->parse('main.viewdescription.image');
        }
        $xtpl->parse('main.viewdescription');
    }

    // Cac bai viet phan dau
    if (! empty($array_sciencecatcontent)) {
        $a = 0;
        foreach ($array_sciencecatcontent as $key => $array_sciencecatcontent_i) {
            $newday = $array_sciencecatcontent_i['publtime'] + (86400 * $array_sciencecatcontent_i['newday']);
            $array_sciencecatcontent_i['publtime'] = nv_date('d/m/Y h:i:s A', $array_sciencecatcontent_i['publtime']);
            $xtpl->assign('CONTENT', $array_sciencecatcontent_i);

            if ($a == 0) {
                if ($array_sciencecatcontent_i['imghome'] != '') {
                    $xtpl->assign('HOMEIMG0', $array_sciencecatcontent_i['imghome']);
                    $xtpl->assign('HOMEIMGALT0', $array_sciencecatcontent_i['homeimgalt']);
                    $xtpl->parse('main.catcontent.image');
                }

                if (defined('NV_IS_MODADMIN')) {
                    $xtpl->assign('ADMINLINK', nv_link_edit_page($array_sciencecatcontent_i['id']) . " " . nv_link_delete_page($array_sciencecatcontent_i['id']));
                    $xtpl->parse('main.catcontent.adminlink');
                }
                if ($newday >= NV_CURRENTTIME) {
                    $xtpl->parse('main.catcontent.newday');
                }
                if (isset($site_mods['comment']) and isset($module_config[$module_name]['activecomm']) and $module_config[$module_name]['activecomm']) {
                    $xtpl->parse('main.catcontent.comment');
                }
                $xtpl->parse('main.catcontent');
            } else {
                if ($newday >= NV_CURRENTTIME) {
                    $xtpl->parse('main.catcontentloop.newday');
                }
                $xtpl->parse('main.catcontentloop');
            }
            ++$a;
        }
    }

    // Het cac bai viet phan dau
    if (! empty($generate_page)) {
        $xtpl->assign('GENERATE_PAGE', $generate_page);
        $xtpl->parse('main.generate_page');
    }

    $xtpl->parse('main');
    return $xtpl->text('main');
}

function viewsubcat_main($viewcat, $array_sciencecat)
{
    global $module_name, $module_file, $site_mods, $global_array_sciencecat, $lang_module, $module_config, $module_info;

    $xtpl = new XTemplate($viewcat . '.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file);
    $xtpl->assign('LANG', $lang_module);
    $xtpl->assign('TOOLTIP_POSITION', $module_config[$module_name]['tooltip_position']);
    $xtpl->assign('IMGWIDTH', $module_config[$module_name]['homewidth']);
    
    // Hien thi cac chu de con
    foreach ($array_sciencecat as $key => $array_row_i) {
        if (isset($array_sciencecat[$key]['content'])) {
            $array_row_i['rss'] = NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=" . $module_info['alias']['rss'] . "/" . $array_row_i['alias'];
            $xtpl->assign('CAT', $array_row_i);
            $catid = intval($array_row_i['catid']);

            if ($array_row_i['subcatid'] != '') {
                $_arr_subcat = explode(',', $array_row_i['subcatid']);
                $limit = 0;
                foreach ($_arr_subcat as $catid_i) {
                    if ($global_array_sciencecat[$catid_i]['inhome'] == 1) {
                        $xtpl->assign('SUBCAT', $global_array_sciencecat[$catid_i]);
                        $xtpl->parse('main.listcat.subcatloop');
                        $limit++;
                    }
                    if ($limit >= 3) {
                        $more = array(
                            'title' => $lang_module['more'],
                            'link' => $global_array_sciencecat[$catid]['link']
                        );
                        $xtpl->assign('MORE', $more);
                        $xtpl->parse('main.listcat.subcatmore');
                        break;
                    }
                }
            }

            $a = 0;

            foreach ($array_sciencecat[$key]['content'] as $array_row_i) {
                $newday = $array_row_i['publtime'] + (86400 * $array_row_i['newday']);
                $array_row_i['publtime'] = nv_date('d/m/Y H:i', $array_row_i['publtime']);
                ++$a;

                if ($a == 1) {
                    if ($newday >= NV_CURRENTTIME) {
                        $xtpl->parse('main.listcat.newday');
                    }
                    $xtpl->assign('CONTENT', $array_row_i);

                    if ($array_row_i['imghome'] != "") {
                        $xtpl->assign('HOMEIMG', $array_row_i['imghome']);
                        $xtpl->assign('HOMEIMGALT', ! empty($array_row_i['homeimgalt']) ? $array_row_i['homeimgalt'] : $array_row_i['title']);
                        $xtpl->parse('main.listcat.image');
                    }

                    if (defined('NV_IS_MODADMIN')) {
                        $xtpl->assign('ADMINLINK', nv_link_edit_page($array_row_i['id']) . " " . nv_link_delete_page($array_row_i['id']));
                        $xtpl->parse('main.listcat.adminlink');
                    }
                } else {
                    if ($newday >= NV_CURRENTTIME) {
                        $xtpl->assign('CLASS', 'icon_new_small');
                    } else {
                        $xtpl->assign('CLASS', 'icon_list');
                    }
                    $array_row_i['hometext'] = nv_clean60($array_row_i['hometext'], $module_config[$module_name]['tooltip_length'], true);
                    $xtpl->assign('OTHER', $array_row_i);
                    if ($module_config[$module_name]['showtooltip']) {
                        $xtpl->parse('main.listcat.related.loop.tooltip');
                    }
                    $xtpl->parse('main.listcat.related.loop');
                }

                if ($a > 1) {
                    $xtpl->assign('WCT', 'col-md-16 ');
                } else {
                    $xtpl->assign('WCT', 'col-md-24');
                }

                $xtpl->set_autoreset();
            }

            if ($a > 1) {
                $xtpl->parse('main.listcat.related');
            }

            if (isset($site_mods['comment']) and isset($module_config[$module_name]['activecomm']) and $module_config[$module_name]['activecomm']) {
                $xtpl->parse('main.listcat.comment');
            }

            $xtpl->parse('main.listcat');
        }
    }

    $xtpl->parse('main');
    return $xtpl->text('main');
}

function viewcat_two_column($array_content, $array_sciencecatpage)
{
    global $site_mods, $module_name, $module_file, $module_upload, $module_config, $module_info, $lang_module, $global_array_sciencecat, $catid, $page;

    $xtpl = new XTemplate('viewcat_two_column.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file);
    $xtpl->assign('LANG', $lang_module);
    $xtpl->assign('IMGWIDTH0', $module_config[$module_name]['homewidth']);
    
    if ($catid and (($global_array_sciencecat[$catid]['viewdescription'] and $page == 1) or $global_array_sciencecat[$catid]['viewdescription'] == 2)) {
        $xtpl->assign('CONTENT', $global_array_sciencecat[$catid]);
        if ($global_array_sciencecat[$catid]['image']) {
            $xtpl->assign('HOMEIMG1', NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_upload . '/' . $global_array_sciencecat[$catid]['image']);
            $xtpl->parse('main.viewdescription.image');
        }
        $xtpl->parse('main.viewdescription');
    }

    // Bai viet o phan dau
    if (! empty($array_content)) {
        foreach ($array_content as $key => $array_content_i) {
            $newday = $array_content_i['publtime'] + (86400 * $array_content_i['newday']);
            $array_content_i['publtime'] = nv_date('d/m/Y h:i:s A', $array_content_i['publtime']);
            $xtpl->assign('NEWSTOP', $array_content_i);

            if ($key == 0) {
                if ($array_content_i['imghome'] != "") {
                    $xtpl->assign('HOMEIMG0', $array_content_i['imghome']);
                    $xtpl->assign('HOMEIMGALT0', $array_content_i['homeimgalt']);
                    $xtpl->parse('main.catcontent.content.image');
                }

                if (defined('NV_IS_MODADMIN')) {
                    $xtpl->assign('ADMINLINK', nv_link_edit_page($array_content_i['id']) . " " . nv_link_delete_page($array_content_i['id']));
                    $xtpl->parse('main.catcontent.content.adminlink');
                }

                if ($newday >= NV_CURRENTTIME) {
                    $xtpl->parse('main.catcontent.content.newday');
                }

                if (isset($site_mods['comment']) and isset($module_config[$module_name]['activecomm']) and $module_config[$module_name]['activecomm']) {
                    $xtpl->parse('main.catcontent.content.comment');
                }

                $xtpl->parse('main.catcontent.content');
            } else {
                if ($newday >= NV_CURRENTTIME) {
                    $xtpl->parse('main.catcontent.other.newday');
                }

                if ($module_config[$module_name]['showtooltip']) {
                    $xtpl->assign('TOOLTIP_POSITION', $module_config[$module_name]['tooltip_position']);
                    $xtpl->parse('main.catcontent.other.tooltip');
                }

                $xtpl->parse('main.catcontent.other');
            }
        }

        $xtpl->parse('main.catcontent');
    }

    // Theo chu de
    $a = 0;

    foreach ($array_sciencecatpage as $key => $array_sciencecatpage_i) {
        $number_content = isset($array_sciencecatpage[$key]['content']) ? sizeof($array_sciencecatpage[$key]['content']) : 0;

        if ($number_content > 0) {
            $array_sciencecatpage_i['rss'] = NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=" . $module_info['alias']['rss'] . "/" . $array_sciencecatpage_i['alias'];

            $xtpl->assign('CAT', $array_sciencecatpage_i);
            $xtpl->assign('ID', ($a + 1));

            $k = 0;

            $array_content_i = $array_sciencecatpage_i['content'][0];
            $newday = $array_content_i['publtime'] + (86400 * $array_content_i['newday']);
            $array_content_i['hometext'] = nv_clean60($array_content_i['hometext'], 200);
            $array_content_i['publtime'] = nv_date('d/m/Y h:i:s A', $array_content_i['publtime']);

            $xtpl->assign('CONTENT', $array_content_i);

            if ($array_content_i['imghome'] != '') {
                $xtpl->assign('HOMEIMG01', $array_content_i['imghome']);
                $xtpl->assign('HOMEIMGALT01', ! empty($array_content_i['homeimgalt']) ? $array_content_i['homeimgalt'] : $array_content_i['title']);
                $xtpl->parse('main.loopcat.content.image');
            }

            if (defined('NV_IS_MODADMIN')) {
                $xtpl->assign('ADMINLINK', nv_link_edit_page($array_content_i['id']) . " " . nv_link_delete_page($array_content_i['id']));
                $xtpl->parse('main.loopcat.content.adminlink');
            }

            if ($newday >= NV_CURRENTTIME) {
                $xtpl->parse('main.loopcat.content.newday');
            }

            if (isset($site_mods['comment']) and isset($module_config[$module_name]['activecomm']) and $module_config[$module_name]['activecomm']) {
                $xtpl->parse('main.loopcat.content.comment');
            }

            $xtpl->parse('main.loopcat.content');

            if ($number_content > 1) {
                for ($index = 1; $index < $number_content; ++$index) {
                    if ($newday >= NV_CURRENTTIME) {
                        $xtpl->parse('main.loopcat.other.newday');
                        $xtpl->assign('CLASS', 'icon_new_small');
                    } else {
                        $xtpl->assign('CLASS', 'icon_list');
                    }
                    if ($module_config[$module_name]['showtooltip']) {
                        $xtpl->assign('TOOLTIP_POSITION', $module_config[$module_name]['tooltip_position']);
                        $array_sciencecatpage_i['content'][$index]['hometext'] = nv_clean60($array_sciencecatpage_i['content'][$index]['hometext'], $module_config[$module_name]['tooltip_length'], true);
                        $xtpl->parse('main.loopcat.other.tooltip');
                    }

                    $xtpl->assign('CONTENT', $array_sciencecatpage_i['content'][$index]);
                    $xtpl->parse('main.loopcat.other');
                }
            }

            if ($a % 2) {
                $xtpl->parse('main.loopcat.clear');
            }

            $xtpl->parse('main.loopcat');
            ++$a;
        }
    }

    // Theo chu de
    $xtpl->parse('main');
    return $xtpl->text('main');
}

function detail_theme($news_contents, $array_keyword, $related_new_array, $related_array, $topic_array, $content_comment)
{
    global $global_config, $module_info, $lang_module, $module_name, $module_file, $module_config, $lang_global, $user_info, $admin_info, $client_info;

    $xtpl = new XTemplate('detail.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file);
    $xtpl->assign('LANG_GLOBAL', $lang_global);
    $xtpl->assign('NV_BASE_SITEURL', NV_BASE_SITEURL);
    $xtpl->assign('TEMPLATE', $global_config['module_theme']);
    $xtpl->assign('LANG', $lang_module);
    $xtpl->assign('TOOLTIP_POSITION', $module_config[$module_name]['tooltip_position']);
    

    $xtpl->assign('NEWSID', $news_contents['id']);

    $xtpl->assign('DETAIL', $news_contents);
    $xtpl->assign('SELFURL', $client_info['selfurl']);

    

    if ($news_contents['showhometext']) {
        if (! empty($news_contents['image']['src'])) {
            if ($news_contents['image']['position'] == 1) {
                if (! empty($news_contents['image']['note'])) {
                    $xtpl->parse('main.showhometext.imgthumb.note');
                } else {
                    $xtpl->parse('main.showhometext.imgthumb.empty');
                }
                $xtpl->parse('main.showhometext.imgthumb');
            } elseif ($news_contents['image']['position'] == 2) {
                if (! empty($news_contents['image']['note'])) {
                    $xtpl->parse('main.showhometext.imgfull.note');
                }
                $xtpl->parse('main.showhometext.imgfull');
            }
        }

        $xtpl->parse('main.showhometext');
    }
	
	// Hien thi tabs
	if (!empty($news_contents['tabs'])) {
		$i=0;
		foreach ($news_contents['tabs'] as $tabs_id => $tabs_value) {
			$tabs_content = '';
			$tabs_key = $tabs_value['content'];

			if ($tabs_key == 'content_detail') {
				// Chi tiết khóa học

				$tabs_content = $news_contents['bodytext'];
			} elseif ($tabs_key == 'content_comments') {
				// Bình luận

				$tabs_content = $content_comment;
			} elseif ($tabs_key == 'content_rate') {
				// Đánh giá sản phẩm
					
				if (!empty($news_contents['allowed_rating']) and !empty($pro_config['review_active'])) {
					$tabs_content = nv_review_content($news_contents);
				}
			} elseif ($tabs_key == 'content_listcourse') {
				// Danh sách sinh viên

				
					$tabs_content = nv_listcourse_tpl($news_contents);
			}

			if (!empty($tabs_content)) {
				$xtpl->assign('TABS_TITLE', $tabs_value[NV_LANG_DATA . '_title']);
				$xtpl->assign('TABS_ID', $tabs_id);
				$xtpl->assign('TABS_KEY', $tabs_key);

				if (!empty($tabs_value['icon'])) {
					$xtpl->assign('TABS_ICON', NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/' . $tabs_value['icon']);
					$xtpl->parse('main.courses_detail.tabs.tabs_title.icon');
				} else {
					$xtpl->parse('main.courses_detail.tabs.tabs_title.icon_default');
				}

				$xtpl->assign('TABS_CONTENT', $tabs_content);
				if ($i == 0) {
					$xtpl->parse('main.courses_detail.tabs.tabs_title.active');
					$xtpl->parse('main.courses_detail.tabs.tabs_content.active');
				}
				$xtpl->parse('main.courses_detail.tabs.tabs_title');
				$xtpl->parse('main.courses_detail.tabs.tabs_content');
			}
			$i++;
		}
		
		$xtpl->parse('main.courses_detail.tabs');
		 if (! empty($array_keyword)) {
			$t = sizeof($array_keyword) - 1;
			foreach ($array_keyword as $i => $value) {
				$xtpl->assign('KEYWORD', $value['keyword']);
				$xtpl->assign('LINK_KEYWORDS', NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=tag/' . urlencode($value['alias']));
				$xtpl->assign('SLASH', ($t == $i) ? '' : ', ');
				$xtpl->parse('main.keywords.loop');
			}
			$xtpl->parse('main.courses_detail.keywords');
		}
	}
	$xtpl->parse('main.courses_detail');
	
   

   




    if ($news_contents['status'] != 1) {
        $xtpl->parse('main.no_public');
    }

    $xtpl->parse('main');
    return $xtpl->text('main');
}

function no_permission()
{
    global $module_info, $module_file, $lang_module;

    $xtpl = new XTemplate('detail.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file);

    $xtpl->assign('NO_PERMISSION', $lang_module['no_permission']);
    $xtpl->parse('no_permission');
    return $xtpl->text('no_permission');
}

function topic_theme($topic_array, $topic_other_array, $generate_page, $page_title, $description, $topic_image)
{
    global $lang_module, $module_info, $module_name, $module_file, $topicalias, $module_config, $topicid;

    $xtpl = new XTemplate('topic.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file);
    $xtpl->assign('LANG', $lang_module);
    $xtpl->assign('TOPPIC_TITLE', $page_title);
    $xtpl->assign('IMGWIDTH1', $module_config[$module_name]['homewidth']);
    if (! empty($description)) {
        $xtpl->assign('TOPPIC_DESCRIPTION', $description);
        if (! empty($topic_image)) {
            $xtpl->assign('HOMEIMG1', $topic_image);
            $xtpl->parse('main.topicdescription.image');
        }
        $xtpl->parse('main.topicdescription');
    }
    if (! empty($topic_array)) {
        foreach ($topic_array as $topic_array_i) {
            $xtpl->assign('TOPIC', $topic_array_i);
            $xtpl->assign('TIME', date('H:i', $topic_array_i['publtime']));
            $xtpl->assign('DATE', date('d/m/Y', $topic_array_i['publtime']));

            if (! empty($topic_array_i['src'])) {
                $xtpl->parse('main.topic.homethumb');
            }

            if ($topicid and defined('NV_IS_MODADMIN')) {
                $xtpl->assign('ADMINLINK', nv_link_edit_page($topic_array_i['id']) . ' ' . nv_link_delete_page($topic_array_i['id']));
                $xtpl->parse('main.topic.adminlink');
            }

            $xtpl->parse('main.topic');
        }
    }

    if (! empty($topic_other_array)) {
        foreach ($topic_other_array as $topic_other_array_i) {
            $topic_other_array_i['publtime'] = nv_date('H:i d/m/Y', $topic_other_array_i['publtime']);

            $xtpl->assign('TOPIC_OTHER', $topic_other_array_i);
            $xtpl->parse('main.other.loop');
        }

        $xtpl->parse('main.other');
    }

    if (! empty($generate_page)) {
        $xtpl->assign('GENERATE_PAGE', $generate_page);
        $xtpl->parse('main.generate_page');
    }

    $xtpl->parse('main');
    return $xtpl->text('main');
}

function sendmail_themme($sendmail)
{
    global $module_info, $module_file, $global_config, $lang_module, $lang_global;

    $xtpl = new XTemplate('sendmail.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file);
    $xtpl->assign('SENDMAIL', $sendmail);
    $xtpl->assign('LANG', $lang_module);
    $xtpl->assign('NV_BASE_SITEURL', NV_BASE_SITEURL);
    $xtpl->assign('GFX_NUM', NV_GFX_NUM);

    if ($global_config['gfx_chk'] > 0) {
        $xtpl->assign('CAPTCHA_REFRESH', $lang_global['captcharefresh']);
        $xtpl->assign('CAPTCHA_REFR_SRC', NV_BASE_SITEURL . NV_ASSETS_DIR . '/images/refresh.png');
        $xtpl->assign('N_CAPTCHA', $lang_global['securitycode']);
        $xtpl->assign('GFX_WIDTH', NV_GFX_WIDTH);
        $xtpl->assign('GFX_HEIGHT', NV_GFX_HEIGHT);
        $xtpl->parse('main.content.captcha');
    }

    $xtpl->parse('main.content');

    if (! empty($sendmail['result'])) {
        $xtpl->assign('RESULT', $sendmail['result']);
        $xtpl->parse('main.result');

        if ($sendmail['result']['check'] == true) {
            $xtpl->parse('main.close');
        }
    }

    $xtpl->parse('main');
    return $xtpl->text('main');
}

function news_print($result)
{
    global $module_info, $module_file, $lang_module;

    $xtpl = new XTemplate('print.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file);
    $xtpl->assign('CONTENT', $result);
    $xtpl->assign('LANG', $lang_module);

    if (! empty($result['image']['width'])) {
        if ($result['image']['position'] == 1) {
            if (! empty($result['image']['note'])) {
                $xtpl->parse('main.image.note');
            }

            $xtpl->parse('main.image');
        } elseif ($result['image']['position'] == 2) {
            if ($result['image']['note'] > 0) {
                $xtpl->parse('main.imagefull.note');
            }

            $xtpl->parse('main.imagefull');
        }
    }

    if ($result['copyright'] == 1) {
        $xtpl->parse('main.copyright');
    }

    if (! empty($result['author']) or ! empty($result['source'])) {
        if (! empty($result['author'])) {
            $xtpl->parse('main.author.name');
        }

        if (! empty($result['source'])) {
            $xtpl->parse('main.author.source');
        }

        $xtpl->parse('main.author');
    }

    if ($result['status'] != 1) {
        $xtpl->parse('main.no_public');
    }
    $xtpl->parse('main');
    return $xtpl->text('main');
}

// Search
function search_theme($key, $check_num, $date_array, $array_sciencecat_search)
{
    global $module_name, $module_info, $module_file, $lang_module, $module_name;

    $xtpl = new XTemplate('search.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file);
    $xtpl->assign('LANG', $lang_module);
    $xtpl->assign('NV_LANG_VARIABLE', NV_LANG_VARIABLE);
    $xtpl->assign('NV_LANG_DATA', NV_LANG_DATA);
    $xtpl->assign('NV_NAME_VARIABLE', NV_NAME_VARIABLE);
    $xtpl->assign('MODULE_NAME', $module_name);
    $xtpl->assign('BASE_URL_SITE', NV_BASE_SITEURL . 'index.php');
    $xtpl->assign('TO_DATE', $date_array['to_date']);
    $xtpl->assign('FROM_DATE', $date_array['from_date']);
    $xtpl->assign('KEY', $key);
    $xtpl->assign('NV_OP_VARIABLE', NV_OP_VARIABLE);
    $xtpl->assign('OP_NAME', 'search');

    foreach ($array_sciencecat_search as $search_sciencecat) {
        $xtpl->assign('SEARCH_sciencecat', $search_sciencecat);
        $xtpl->parse('main.search_sciencecat');
    }

    for ($i = 0; $i <= 3; ++$i) {
        if ($check_num == $i) {
            $xtpl->assign('CHECK' . $i, 'selected=\'selected\'');
        } else {
            $xtpl->assign('CHECK' . $i, '');
        }
    }

    $xtpl->parse('main');
    return $xtpl->text('main');
}

function search_result_theme($key, $numRecord, $per_pages, $page, $array_content, $catid)
{
    global $module_file, $module_info, $lang_module, $module_name, $global_array_sciencecat, $module_config, $global_config;

    $xtpl = new XTemplate('search.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file);
    $xtpl->assign('LANG', $lang_module);
    $xtpl->assign('KEY', $key);
    $xtpl->assign('IMG_WIDTH', $module_config[$module_name]['homewidth']);
    $xtpl->assign('TITLE_MOD', $lang_module['search_modul_title']);

    if (! empty($array_content)) {
        foreach ($array_content as $value) {
            $catid_i = $value['catid'];

            $xtpl->assign('LINK', $global_array_sciencecat[$catid_i]['link'] . '/' . $value['alias'] . "-" . $value['id'] . $global_config['rewrite_exturl']);
            $xtpl->assign('TITLEROW', strip_tags(BoldKeywordInStr($value['title'], $key)));
            $xtpl->assign('CONTENT', BoldKeywordInStr($value['hometext'], $key) . "...");
            $xtpl->assign('TIME', date('d/m/Y h:i:s A', $value['publtime']));
            $xtpl->assign('AUTHOR', BoldKeywordInStr($value['author'], $key));
            $xtpl->assign('SOURCE', BoldKeywordInStr(GetSourceNews($value['sourceid']), $key));

            if (! empty($value['homeimgfile'])) {
                $xtpl->assign('IMG_SRC', $value['homeimgfile']);
                $xtpl->parse('results.result.result_img');
            }

            $xtpl->parse('results.result');
        }
    }

    if ($numRecord == 0) {
        $xtpl->assign('KEY', $key);
        $xtpl->assign('INMOD', $lang_module['search_modul_title']);
        $xtpl->parse('results.noneresult');
    }

    if ($numRecord > $per_pages) {
        // show pages

        $url_link = $_SERVER['REQUEST_URI'];
        if (strpos($url_link, '&page=') > 0) {
            $url_link = substr($url_link, 0, strpos($url_link, '&page='));
        } elseif (strpos($url_link, '?page=') > 0) {
            $url_link = substr($url_link, 0, strpos($url_link, '?page='));
        }
        $_array_url = array( 'link' => $url_link, 'amp' => '&page=' );
        $generate_page = nv_generate_page($_array_url, $numRecord, $per_pages, $page);

        $xtpl->assign('VIEW_PAGES', $generate_page);
        $xtpl->parse('results.pages_result');
    }

    $xtpl->assign('NUMRECORD', $numRecord);
    $xtpl->assign('MY_DOMAIN', NV_MY_DOMAIN);

    $xtpl->parse('results');
    return $xtpl->text('results');
}




/**
 * nv_review_content
 *
 * @param mixed $news_contents
 * @return
 */
function nv_review_content($news_contents)
{
    global $module_info, $lang_module, $lang_global, $module_name, $module_data, $module_file, $pro_config, $op, $user_info;

    $xtpl = new XTemplate('review_content.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file);
    $xtpl->assign('LANG', $lang_module);
    $xtpl->assign('LINK_REVIEW', NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=review&id=' . $news_contents['id'] . '&1');

    if (!empty($user_info)) {
      /*   $user_info['full_name'] = nv_show_name_user($user_info['first_name'], $user_info['last_name'], $user_info['username']); */
        $xtpl->assign('SENDER', !empty($user_info['full_name']) ? $user_info['full_name'] : $user_info['username']);
    }
    $xtpl->assign('RATE_TOTAL', $news_contents['rating_total']);
    $xtpl->assign('RATE_VALUE', $news_contents['rating_point']);
    if ($pro_config['review_captcha']) {
        $xtpl->parse('main.captcha');
    }

    $xtpl->parse('main');
    return $xtpl->text('main');
}
