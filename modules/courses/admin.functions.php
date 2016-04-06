<?php

/**
 * @Project NUKEVIET 4.x
 * @Author webvang (hoang.nguyen@webvang.vn)
 * @Copyright (C) 2016 webvang. All rights reserved
 * @License: Not free read more http://nukeviet.vn/vi/store/modules/nvtools/
 * @Createdate Wed, 06 Apr 2016 09:05:18 GMT
 */

if ( ! defined( 'NV_ADMIN' ) or ! defined( 'NV_MAINFILE' ) or ! defined( 'NV_IS_MODADMIN' ) ) die( 'Stop!!!' );

define( 'NV_IS_FILE_ADMIN', true );


$allow_func = array( 'main', 'setting', 'group', 'science', 'sciencecat', 'subjects', 'subjectscat', 'teacher', 'student', 'admins', 'add_group', 'del_group', 'list_group', 'change_group', 'add_science', 'del_science', 'list_science', 'add_sciencecat', 'del_sciencecat', 'list_sciencecat', 'change_sciencecat', 'add_subjects', 'del_subjects', 'list_subjects', 'add_subjectscat', 'del_subjectscat', 'list_subjectscat', 'change_subjectscat', 'add_teacher', 'del_teacher', 'list_teacher', 'add_student', 'del_student', 'list_student');