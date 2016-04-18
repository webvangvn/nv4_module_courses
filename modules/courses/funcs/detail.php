<?php

/**
 * @Project NUKEVIET 4.x
 * @Author webvang (hoang.nguyen@webvang.vn)
 * @Copyright (C) 2016 webvang. All rights reserved
 * @License: Not free read more http://nukeviet.vn/vi/store/modules/nvtools/
 * @Createdate Wed, 06 Apr 2016 09:05:18 GMT
 */

if ( ! defined( 'NV_IS_MOD_COURSES' ) ) die( 'Stop!!!' );

$contents = '';
$publtime = 0;

if (nv_user_in_groups($global_array_sciencecat[$catid]['groups_view'])) {
    $query = $db_slave->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_courses WHERE id = ' . $id);
    $news_contents = $query->fetch();
	
    if ($news_contents['id'] > 0) {
        $base_url_rewrite = nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $global_array_sciencecat[$news_contents['sciencecat']]['alias'] . '/' . $news_contents['alias'] . '-' . $news_contents['id'] . $global_config['rewrite_exturl'], true);
        if ($_SERVER['REQUEST_URI'] == $base_url_rewrite) {
            $canonicalUrl = NV_MAIN_DOMAIN . $base_url_rewrite;
        } elseif (NV_MAIN_DOMAIN . $_SERVER['REQUEST_URI'] != $base_url_rewrite) {
            //chuyen huong neu doi alias
            header('HTTP/1.1 301 Moved Permanently');
            Header('Location: ' . $base_url_rewrite);
            die();
        } else {
            $canonicalUrl = $base_url_rewrite;
        }

        $body_contents = $db_slave->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_courses where id=' . $news_contents['id'])->fetch();
        $news_contents = array_merge($news_contents, $body_contents);
        unset($body_contents);
        $show_no_image = $module_config[$module_name]['show_no_image'];

        if (defined('NV_IS_MODADMIN') or ($news_contents['status'] == 1 and $news_contents['publtime'] < NV_CURRENTTIME and ($news_contents['exptime'] == 0 or $news_contents['exptime'] > NV_CURRENTTIME))) {
            $news_contents['showhometext'] = $module_config[$module_name]['showhometext'];
            if (! empty($news_contents['homeimgfile'])) {
                $src = $alt = $note = '';
                $width = $height = 0;
                if ($news_contents['homeimgthumb'] == 1 and $news_contents['imgposition'] == 1) {
                    $src = NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_upload . '/' . $news_contents['homeimgfile'];
                    $news_contents['homeimgfile'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/' . $news_contents['homeimgfile'];
                    $width = $module_config[$module_name]['homewidth'];
                } elseif ($news_contents['homeimgthumb'] == 3) {
                    $src = $news_contents['homeimgfile'];
                    $width = ($news_contents['imgposition'] == 1) ? $module_config[$module_name]['homewidth'] : $module_config[$module_name]['imagefull'];
                } elseif (file_exists(NV_UPLOADS_REAL_DIR . '/' . $module_upload . '/' . $news_contents['homeimgfile'])) {
                    $src = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/' . $news_contents['homeimgfile'];
                    if ($news_contents['imgposition'] == 1) {
                        $width = $module_config[$module_name]['homewidth'];
                    } else {
                        $imagesize = @getimagesize(NV_UPLOADS_REAL_DIR . '/' . $module_upload . '/' . $news_contents['homeimgfile']);
                        if ($imagesize[0] > 0 and $imagesize[0] > $module_config[$module_name]['imagefull']) {
                            $width = $module_config[$module_name]['imagefull'];
                        } else {
                            $width = $imagesize[0];
                        }
                    }
                    $news_contents['homeimgfile'] = $src;
                }

                if (! empty($src)) {
                    $meta_property['og:image'] = (preg_match('/^(http|https|ftp|gopher)\:\/\//', $src)) ? $src : NV_MY_DOMAIN . $src;

                    if ($news_contents['imgposition'] > 0) {
                        $news_contents['image'] = array(
                            'src' => $src,
                            'width' => $width,
                            'alt' => (empty($news_contents['homeimgalt'])) ? $news_contents['name_courses'] : $news_contents['homeimgalt'],
                            'note' => $news_contents['homeimgalt'],
                            'position' => $news_contents['imgposition']
                        );
                    }
                } elseif (!empty($show_no_image)) {
                    $meta_property['og:image'] = NV_MY_DOMAIN . NV_BASE_SITEURL . $show_no_image;
                }
            } elseif (! empty($show_no_image)) {
                $meta_property['og:image'] = NV_MY_DOMAIN . NV_BASE_SITEURL . $show_no_image;
            }

            $publtime = intval($news_contents['publtime']);
            $meta_property['og:type'] = 'article';
            $meta_property['article:published_time'] = date('Y-m-dTH:i:s', $publtime);
            $meta_property['article:section'] = $global_array_sciencecat[$news_contents['sciencecat']]['title'];
        }

        if (defined('NV_IS_MODADMIN') and $news_contents['status'] != 1) {
            $alert = sprintf($lang_module['status_alert'], $lang_module['status_' . $news_contents['status']]);
            $my_footer .= "<script type=\"text/javascript\">alert('". $alert ."')</script>";
            $news_contents['allowed_send'] = 0;
        }
    }

    if ($publtime == 0) {
        $redirect = '<meta http-equiv="Refresh" content="3;URL=' . nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name, true) . '" />';
        nv_info_die($lang_global['error_404_title'], $lang_global['error_404_title'], $lang_global['error_404_content'] . $redirect);
    }

    $news_contents['url_sendmail'] = nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=sendmail/' . $global_array_sciencecat[$catid]['alias'] . '/' . $news_contents['alias'] . '-' . $news_contents['id'] . $global_config['rewrite_exturl'], true);
    $news_contents['url_print'] = nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=print/' . $global_array_sciencecat[$catid]['alias'] . '/' . $news_contents['alias'] . '-' . $news_contents['id'] . $global_config['rewrite_exturl'], true);
    $news_contents['url_savefile'] = nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=savefile/' . $global_array_sciencecat[$catid]['alias'] . '/' . $news_contents['alias'] . '-' . $news_contents['id'] . $global_config['rewrite_exturl'], true);


    $news_contents['publtime'] = nv_date('l - d/m/Y H:i', $news_contents['publtime']);

    $related_new_array = array();
    $related_array = array();
    if ($st_links > 0) {
        $db_slave->sqlreset()
            ->select('*')
            ->from(NV_PREFIXLANG . '_' . $module_data . '_courses')
            ->where('status=1 AND publtime > ' . $publtime)
            ->order('id ASC')
            ->limit($st_links);

        $related = $db_slave->query($db_slave->sql());

        while ($row = $related->fetch()) {
            if ($row['homeimgthumb'] == 1) {
                //image thumb
                $row['imghome'] = NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_upload . '/' . $row['homeimgfile'];
            } elseif ($row['homeimgthumb'] == 2) {
                //image file
                $row['imghome'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/' . $row['homeimgfile'];
            } elseif ($row['homeimgthumb'] == 3) {
                //image url
                $row['imghome'] = $row['homeimgfile'];
            } elseif (! empty($show_no_image)) {
                //no image
                $row['imghome'] = NV_BASE_SITEURL . $show_no_image;
            } else {
                $row['imghome'] = '';
            }

            $link = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $global_array_sciencecat[$catid]['alias'] . '/' . $row['alias'] . '-' . $row['id'] . $global_config['rewrite_exturl'];
            $related_new_array[] = array(
                'title' => $row['name_courses'],
                'time' => $row['publtime'],
                'link' => $link,
                'newday' => $global_array_sciencecat[$catid]['newday'],
                'hometext' => $row['hometext'],
                'imghome' => $row['imghome']
            );
        }
        $related->closeCursor();

        sort($related_new_array, SORT_NUMERIC);

        $db_slave->sqlreset()
            ->select('*')
            ->from(NV_PREFIXLANG . '_' . $module_data . '_courses')
            ->where('status=1 AND publtime < ' . $publtime)
            ->order('id DESC')
            ->limit($st_links);

        $related = $db_slave->query($db_slave->sql());
        while ($row = $related->fetch()) {
            if ($row['homeimgthumb'] == 1) {
                //image thumb
                $row['imghome'] = NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_upload . '/' . $row['homeimgfile'];
            } elseif ($row['homeimgthumb'] == 2) {
                //image file
                $row['imghome'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/' . $row['homeimgfile'];
            } elseif ($row['homeimgthumb'] == 3) {
                //image url
                $row['imghome'] = $row['homeimgfile'];
            } elseif (! empty($show_no_image)) {
                //no image
                $row['imghome'] = NV_BASE_SITEURL . $show_no_image;
            } else {
                $row['imghome'] = '';
            }

            $link = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $global_array_sciencecat[$catid]['alias'] . '/' . $row['alias'] . '-' . $row['id'] . $global_config['rewrite_exturl'];
            $related_array[] = array(
                'title' => $row['name_courses'],
                'time' => $row['publtime'],
                'link' => $link,
                'newday' => $global_array_sciencecat[$catid]['newday'],
                'hometext' => $row['hometext'],
                'imghome' => $row['imghome']
            );
        }

        $related->closeCursor();
        unset($related, $row);
    }

    $topic_array = array();

    if ($news_contents['allowed_rating']) {
        $time_set_rating = $nv_Request->get_int($module_name . '_' . $op . '_' . $news_contents['id'], 'cookie', 0);
        if ($time_set_rating > 0) {
            $news_contents['disablerating'] = 1;
        } else {
            $news_contents['disablerating'] = 0;
        }
        $news_contents['stringrating'] = sprintf($lang_module['stringrating'], $news_contents['total_rating'], $news_contents['click_rating']);
        $news_contents['numberrating'] = ($news_contents['click_rating'] > 0) ? round($news_contents['total_rating'] / $news_contents['click_rating'], 1) : 0;
        $news_contents['langstar'] = array(
            'note' => $lang_module['star_note'],
            'verypoor' => $lang_module['star_verypoor'],
            'poor' => $lang_module['star_poor'],
            'ok' => $lang_module['star_ok'],
            'good' => $lang_module['star_good}'],
            'verygood' => $lang_module['star_verygood']
        );
    }

   // Hien thi tabs
    $sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_tabs where active=1 ORDER BY weight ASC';
    $news_contents['tabs'] = $nv_Cache->db($sql, 'id', $module_name);
    $array_keyword = array();
    $key_words = array();
    $_query = $db_slave->query('SELECT a1.keyword, a2.alias FROM ' . NV_PREFIXLANG . '_' . $module_data . '_tags_id a1 INNER JOIN ' . NV_PREFIXLANG . '_' . $module_data . '_tags a2 ON a1.tid=a2.tid WHERE a1.id=' . $news_contents['id']);
    while ($row = $_query->fetch()) {
        $array_keyword[] = $row;
        $key_words[] = $row['keyword'];
        $meta_property['article:tag'][] = $row['keyword'];
    }
   // comment
    if (isset($site_mods['comment']) and isset($module_config[$module_name]['activecomm'])) {
        define('NV_COMM_ID', $id);//ID bài viết hoặc
        define('NV_COMM_AREA', $module_info['funcs'][$op]['func_id']);//để đáp ứng comment ở bất cứ đâu không cứ là bài viết
        //check allow comemnt
        $allowed = $module_config[$module_name]['allowed_comm'];//tuy vào module để lấy cấu hình. Nếu là module news thì có cấu hình theo bài viết
        if ($allowed == '-1') {
            $allowed = $news_contents['allowed_comm'];
        }
        define('NV_PER_PAGE_COMMENT', 5); //Số bản ghi hiển thị bình luận
        require_once NV_ROOTDIR . '/modules/comment/comment.php';
        $area = (defined('NV_COMM_AREA')) ? NV_COMM_AREA : 0;
        $checkss = md5($module_name . '-' . $area . '-' . NV_COMM_ID . '-' . $allowed . '-' . NV_CACHE_PREFIX);

        $content_comment = nv_comment_module($module_name, $checkss, $area, NV_COMM_ID, $allowed, 1);
    } else {
        $content_comment = '';
    }
 

    $contents = detail_theme($news_contents, $array_keyword, $related_new_array, $related_array, $topic_array, $content_comment);

    $page_title = $news_contents['name_courses'];
    $key_words = implode(', ', $key_words);
    $description = $news_contents['hometext'];
} else {
    $contents = no_permission($global_array_sciencecat[$catid]['groups_view']);
}

include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';