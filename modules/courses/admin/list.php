<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2016 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Fri, 08 Apr 2016 02:27:56 GMT
 */

if ( ! defined( 'NV_IS_FILE_ADMIN' ) ) die( 'Stop!!!' );

if ( $nv_Request->isset_request( 'delete_id', 'get' ) and $nv_Request->isset_request( 'delete_checkss', 'get' ))
{
	$id = $nv_Request->get_int( 'delete_id', 'get' );
	$delete_checkss = $nv_Request->get_string( 'delete_checkss', 'get' );
	if( $id > 0 and $delete_checkss == md5( $id . NV_CACHE_PREFIX . $client_info['session_id'] ) )
	{
		$db->query('DELETE FROM ' . NV_PREFIXLANG . '_' . $module_data . '_list  WHERE id = ' . $db->quote( $id ) );
		$nv_Cache->delMod( $module_name );
		Header( 'Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op );
		die();
	}
}

$row = array();
$error = array();
$row['id'] = $nv_Request->get_int( 'id', 'post,get', 0 );
if ( $nv_Request->isset_request( 'submit', 'post' ) )
{
	$row['cid'] = $nv_Request->get_title( 'cid', 'post', '' );
	$row['sid'] = $nv_Request->get_title( 'sid', 'post', '' );
	$row['tid'] = $nv_Request->get_title( 'tid', 'post', '' );

	if( empty( $row['cid'] ) )
	{
		$error[] = $lang_module['error_required_cid'];
	}
	elseif( empty( $row['sid'] ) )
	{
		$error[] = $lang_module['error_required_sid'];
	}
	elseif( empty( $row['tid'] ) )
	{
		$error[] = $lang_module['error_required_tid'];
	}

	if( empty( $error ) )
	{
		try
		{
			if( empty( $row['id'] ) )
			{
				$stmt = $db->prepare( 'INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . '_list (cid, sid, tid) VALUES (:cid, :sid, :tid)' );
			}
			else
			{
				$stmt = $db->prepare( 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_list SET cid = :cid, sid = :sid, tid = :tid WHERE id=' . $row['id'] );
			}
			$stmt->bindParam( ':cid', $row['cid'], PDO::PARAM_STR );
			$stmt->bindParam( ':sid', $row['sid'], PDO::PARAM_STR );
			$stmt->bindParam( ':tid', $row['tid'], PDO::PARAM_STR );

			$exc = $stmt->execute();
			if( $exc )
			{
				$nv_Cache->delMod( $module_name );
				Header( 'Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op );
				die();
			}
		}
		catch( PDOException $e )
		{
			trigger_error( $e->getMessage() );
			die( $e->getMessage() ); //Remove this line after checks finished
		}
	}
}
elseif( $row['id'] > 0 )
{
	$row = $db->query( 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_list WHERE id=' . $row['id'] )->fetch();
	if( empty( $row ) )
	{
		Header( 'Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op );
		die();
	}
}
else
{
	$row['id'] = 0;
	$row['cid'] = '';
	$row['sid'] = '';
	$row['tid'] = '';
}
$array_cid_courses = array();
$_sql = 'SELECT * FROM nv4_vi_courses_courses';
$_query = $db->query( $_sql );
while( $_row = $_query->fetch() )
{
	$array_cid_courses[$_row['id']] = $_row;
}

$array_sid_courses = array();
$_sql = 'SELECT * FROM nv4_vi_courses_students';
$_query = $db->query( $_sql );
while( $_row = $_query->fetch() )
{
	$array_sid_courses[$_row['id']] = $_row;
}

$array_tid_courses = array();
$_sql = 'SELECT * FROM nv4_vi_courses_teacher';
$_query = $db->query( $_sql );
while( $_row = $_query->fetch() )
{
	$array_tid_courses[$_row['id']] = $_row;
}


$q = $nv_Request->get_title( 'q', 'post,get' );

// Fetch Limit
$show_view = false;
if ( ! $nv_Request->isset_request( 'id', 'post,get' ) )
{
	$show_view = true;
	$per_page = 20;
	$page = $nv_Request->get_int( 'page', 'post,get', 1 );
	$db->sqlreset()
		->select( 'COUNT(*)' )
		->from( '' . NV_PREFIXLANG . '_' . $module_data . '_list' );

	if( ! empty( $q ) )
	{
		$db->where( 'cid LIKE :q_cid OR sid LIKE :q_sid OR tid LIKE :q_tid' );
	}
	$sth = $db->prepare( $db->sql() );

	if( ! empty( $q ) )
	{
		$sth->bindValue( ':q_cid', '%' . $q . '%' );
		$sth->bindValue( ':q_sid', '%' . $q . '%' );
		$sth->bindValue( ':q_tid', '%' . $q . '%' );
	}
	$sth->execute();
	$num_items = $sth->fetchColumn();

	$db->select( '*' )
		->order( 'id DESC' )
		->limit( $per_page )
		->offset( ( $page - 1 ) * $per_page );
	$sth = $db->prepare( $db->sql() );

	if( ! empty( $q ) )
	{
		$sth->bindValue( ':q_cid', '%' . $q . '%' );
		$sth->bindValue( ':q_sid', '%' . $q . '%' );
		$sth->bindValue( ':q_tid', '%' . $q . '%' );
	}
	$sth->execute();
}


$xtpl = new XTemplate( $op . '.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file );
$xtpl->assign( 'LANG', $lang_module );
$xtpl->assign( 'NV_LANG_VARIABLE', NV_LANG_VARIABLE );
$xtpl->assign( 'NV_LANG_DATA', NV_LANG_DATA );
$xtpl->assign( 'NV_BASE_ADMINURL', NV_BASE_ADMINURL );
$xtpl->assign( 'NV_NAME_VARIABLE', NV_NAME_VARIABLE );
$xtpl->assign( 'NV_OP_VARIABLE', NV_OP_VARIABLE );
$xtpl->assign( 'MODULE_NAME', $module_name );
$xtpl->assign( 'MODULE_UPLOAD', $module_upload );
$xtpl->assign( 'NV_ASSETS_DIR', NV_ASSETS_DIR );
$xtpl->assign( 'OP', $op );
$xtpl->assign( 'ROW', $row );

foreach( $array_cid_courses as $value )
{
	$xtpl->assign( 'OPTION', array(
		'key' => $value['id'],
		'title' => $value['id_courses'] . '-' . $value['name_courses'],
		'selected' => ($value['id'] == $row['cid']) ? ' selected="selected"' : ''
	) );
	$xtpl->parse( 'main.select_cid' );
}
foreach( $array_sid_courses as $value )
{
	$xtpl->assign( 'OPTION', array(
		'key' => $value['id'],
		'title' => $value['id_student'] . '-' . $value['fname'] . ' ' . $value['lname'],
		'selected' => ($value['id'] == $row['sid']) ? ' selected="selected"' : ''
	) );
	$xtpl->parse( 'main.select_sid' );
}
foreach( $array_tid_courses as $value )
{
	$xtpl->assign( 'OPTION', array(
		'key' => $value['id'],
		'title' => $value['fname'] . ' ' . $value['lname'],
		'selected' => ($value['id'] == $row['tid']) ? ' selected="selected"' : ''
	) );
	$xtpl->parse( 'main.select_tid' );
}
$xtpl->assign( 'Q', $q );

if( $show_view )
{
	$base_url = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op;
	if( ! empty( $q ) )
	{
		$base_url .= '&q=' . $q;
	}
	$generate_page = nv_generate_page( $base_url, $num_items, $per_page, $page );
	if( !empty( $generate_page ) )
	{
		$xtpl->assign( 'NV_GENERATE_PAGE', $generate_page );
		$xtpl->parse( 'main.view.generate_page' );
	}
	$number = $page > 1 ? ($per_page * ( $page - 1 ) ) + 1 : 1;
	while( $view = $sth->fetch() )
	{
		$view['number'] = $number++;
		$view['ctitle'] = $array_cid_courses[$view['cid']]['name_courses'];
		$view['cid'] = $array_cid_courses[$view['cid']]['id_courses'];
		$view['sid'] = $array_sid_courses[$view['sid']]['fname'] . ' ' . $array_sid_courses[$view['sid']]['lname'];
		$view['tid'] = $array_tid_courses[$view['tid']]['fname'] . ' ' . $array_tid_courses[$view['tid']]['lname'];
		$view['link_edit'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op . '&amp;id=' . $view['id'];
		$view['link_delete'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op . '&amp;delete_id=' . $view['id'] . '&amp;delete_checkss=' . md5( $view['id'] . NV_CACHE_PREFIX . $client_info['session_id'] );
		$xtpl->assign( 'VIEW', $view );
		$xtpl->parse( 'main.view.loop' );
	}
	$xtpl->parse( 'main.view' );
}


if( ! empty( $error ) )
{
	$xtpl->assign( 'ERROR', implode( '<br />', $error ) );
	$xtpl->parse( 'main.error' );
}

$xtpl->parse( 'main' );
$contents = $xtpl->text( 'main' );

$page_title = $lang_module['list'];

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme( $contents );
include NV_ROOTDIR . '/includes/footer.php';