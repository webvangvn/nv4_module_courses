<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2016 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Mon, 11 Apr 2016 02:21:36 GMT
 */

if ( ! defined( 'NV_IS_FILE_ADMIN' ) ) die( 'Stop!!!' );

if ( $nv_Request->isset_request( 'get_alias_title', 'post' ) )
{
	$alias = $nv_Request->get_title( 'get_alias_title', 'post', '' );
	$alias = change_alias( $alias );
	die( $alias );
}

//change status
if( $nv_Request->isset_request( 'change_status', 'post, get' ) )
{
	$id = $nv_Request->get_int( 'id', 'post, get', 0 );
	$content = 'NO_' . $id;

	$query = 'SELECT status FROM ' . NV_PREFIXLANG . '_' . $module_data . '_courses WHERE id=' . $id;
	$row = $db->query( $query )->fetch();
	if( isset( $row['status'] ) )
	{
		$status = ( $row['status'] ) ? 0 : 1;
		$query = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_courses SET status=' . intval( $status ) . ' WHERE id=' . $id;
		$db->query( $query );
		$content = 'OK_' . $id;
	}
	$nv_Cache->delMod( $module_name );
	include NV_ROOTDIR . '/includes/header.php';
	echo $content;
	include NV_ROOTDIR . '/includes/footer.php';
	exit();
}

if( $nv_Request->isset_request( 'ajax_action', 'post' ) )
{
	$id = $nv_Request->get_int( 'id', 'post', 0 );
	$new_vid = $nv_Request->get_int( 'new_vid', 'post', 0 );
	$content = 'NO_' . $id;
	if( $new_vid > 0 )
	{
		$sql = 'SELECT id FROM ' . NV_PREFIXLANG . '_' . $module_data . '_courses WHERE id!=' . $id . ' ORDER BY publtime ASC';
		$result = $db->query( $sql );
		$publtime = 0;
		while( $row = $result->fetch() )
		{
			++$publtime;
			if( $publtime == $new_vid ) ++$publtime;
			$sql = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_courses SET publtime=' . $publtime . ' WHERE id=' . $row['id'];
			$db->query( $sql );
		}
		$sql = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_courses SET publtime=' . $new_vid . ' WHERE id=' . $id;
		$db->query( $sql );
		$content = 'OK_' . $id;
	}
	$nv_Cache->delMod( $module_name );
	include NV_ROOTDIR . '/includes/header.php';
	echo $content;
	include NV_ROOTDIR . '/includes/footer.php';
	exit();
}
if ( $nv_Request->isset_request( 'delete_id', 'get' ) and $nv_Request->isset_request( 'delete_checkss', 'get' ))
{
	$id = $nv_Request->get_int( 'delete_id', 'get' );
	$delete_checkss = $nv_Request->get_string( 'delete_checkss', 'get' );
	if( $id > 0 and $delete_checkss == md5( $id . NV_CACHE_PREFIX . $client_info['session_id'] ) )
	{
		$publtime=0;
		$sql = 'SELECT publtime FROM ' . NV_PREFIXLANG . '_' . $module_data . '_courses WHERE id =' . $db->quote( $id );
		$result = $db->query( $sql );
		list( $publtime) = $result->fetch( 3 );
		
		$db->query('DELETE FROM ' . NV_PREFIXLANG . '_' . $module_data . '_courses  WHERE id = ' . $db->quote( $id ) );
		if( $publtime > 0)
		{
			$sql = 'SELECT id, publtime FROM ' . NV_PREFIXLANG . '_' . $module_data . '_courses WHERE publtime >' . $publtime;
			$result = $db->query( $sql );
			while(list( $id, $publtime) = $result->fetch( 3 ))
			{
				$publtime--;
				$db->query( 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_courses SET publtime=' . $publtime . ' WHERE id=' . intval( $id ));
			}
		}
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
	$row['id_courses'] = $nv_Request->get_title( 'id_courses', 'post', '' );
	$row['sciencecat'] = $nv_Request->get_title( 'sciencecat', 'post', '' );
	$row['teacherid'] = $nv_Request->get_int( 'teacherid', 'post', 0 );
	$row['alias'] = $nv_Request->get_title( 'alias', 'post', '' );
	$row['alias'] = ( empty($row['alias'] ))? change_alias( $row['title'] ) : change_alias( $row['alias'] );
	$row['name_courses'] = $nv_Request->get_title( 'name_courses', 'post', '' );
	$row['schedule'] = $nv_Request->get_title( 'schedule', 'post', '' );
	$row['duration'] = $nv_Request->get_int( 'duration', 'post', 0 );
	$row['feeonline'] = $nv_Request->get_int( 'feeonline', 'post', 0 );
	$row['feeoffline'] = $nv_Request->get_int( 'feeoffline', 'post', 0 );
	$row['total'] = $nv_Request->get_int( 'total', 'post', 0 );
	if( preg_match( '/^([0-9]{1,2})\/([0-9]{1,2})\/([0-9]{4})$/', $nv_Request->get_string( 'time_start', 'post' ), $m ) )
	{
		$_hour = $nv_Request->get_int( 'time_start_hour', 'post' );
		$_min = $nv_Request->get_int( 'time_start_min', 'post' );
		$row['time_start'] = mktime( $_hour, $_min, 0, $m[2], $m[1], $m[3] );
	}
	else
	{
		$row['time_start'] = 0;
	}
	if( preg_match( '/^([0-9]{1,2})\/([0-9]{1,2})\/([0-9]{4})$/', $nv_Request->get_string( 'time_end', 'post' ), $m ) )
	{
		$_hour = $nv_Request->get_int( 'time_end_hour', 'post' );
		$_min = $nv_Request->get_int( 'time_end_min', 'post' );
		$row['time_end'] = mktime( $_hour, $_min, 0, $m[2], $m[1], $m[3] );
	}
	else
	{
		$row['time_end'] = 0;
	}
	$row['note'] = $nv_Request->get_editor( 'note', '', NV_ALLOWED_HTML_TAGS );
	$row['inhome'] = $nv_Request->get_int( 'inhome', 'post', 0 );
	$row['homeimgthumb'] = $nv_Request->get_int( 'homeimgthumb', 'post', 0 );
	$row['hometext'] = $nv_Request->get_editor( 'hometext', '', NV_ALLOWED_HTML_TAGS );
	$row['homeimgfile'] = $nv_Request->get_title( 'homeimgfile', 'post', '' );
	if( is_file( NV_DOCUMENT_ROOT . $row['homeimgfile'] ) )
	{
		$row['homeimgfile'] = substr( $row['homeimgfile'], strlen( NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/' ) );
	}
	else
	{
		$row['homeimgfile'] = '';
	}
	$row['bodytext'] = $nv_Request->get_editor( 'bodytext', '', NV_ALLOWED_HTML_TAGS );

	if( empty( $row['id_courses'] ) )
	{
		$error[] = $lang_module['error_required_id_courses'];
	}
	elseif( empty( $row['sciencecat'] ) )
	{
		$error[] = $lang_module['error_required_sciencecat'];
	}
	elseif( empty( $row['teacherid'] ) )
	{
		$error[] = $lang_module['error_required_teacherid'];
	}
	elseif( empty( $row['alias'] ) )
	{
		$error[] = $lang_module['error_required_alias'];
	}
	elseif( empty( $row['name_courses'] ) )
	{
		$error[] = $lang_module['error_required_name_courses'];
	}
	elseif( empty( $row['feeonline'] ) )
	{
		$error[] = $lang_module['error_required_feeonline'];
	}
	elseif( empty( $row['feeoffline'] ) )
	{
		$error[] = $lang_module['error_required_feeoffline'];
	}
	elseif( empty( $row['total'] ) )
	{
		$error[] = $lang_module['error_required_total'];
	}
	elseif( empty( $row['time_start'] ) )
	{
		$error[] = $lang_module['error_required_time_start'];
	}
	elseif( empty( $row['time_end'] ) )
	{
		$error[] = $lang_module['error_required_time_end'];
	}
	elseif( empty( $row['hometext'] ) )
	{
		$error[] = $lang_module['error_required_hometext'];
	}
	elseif( empty( $row['bodytext'] ) )
	{
		$error[] = $lang_module['error_required_bodytext'];
	}

	if( empty( $error ) )
	{
		try
		{
			if( empty( $row['id'] ) )
			{

				$row['homeimgalt'] = '';

				$stmt = $db->prepare( 'INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . '_courses (id_courses, sciencecat, teacherid, alias, name_courses, schedule, duration, feeonline, feeoffline, total, time_start, time_end, note, status, inhome, publtime, homeimgthumb, hometext, homeimgfile, homeimgalt, bodytext) VALUES (:id_courses, :sciencecat, :teacherid, :alias, :name_courses, :schedule, :duration, :feeonline, :feeoffline, :total, :time_start, :time_end, :note, :status, :inhome, :publtime, :homeimgthumb, :hometext, :homeimgfile, :homeimgalt, :bodytext)' );

				$stmt->bindValue( ':status', 1, PDO::PARAM_INT );

				$weight = $db->query( 'SELECT max(publtime) FROM ' . NV_PREFIXLANG . '_' . $module_data . '_courses' )->fetchColumn();
				$weight = intval( $weight ) + 1;
				$stmt->bindParam( ':publtime', $weight, PDO::PARAM_INT );

				$stmt->bindParam( ':homeimgalt', $row['homeimgalt'], PDO::PARAM_STR );

			}
			else
			{
				$stmt = $db->prepare( 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_courses SET id_courses = :id_courses, sciencecat = :sciencecat, teacherid = :teacherid, alias = :alias, name_courses = :name_courses, schedule = :schedule, duration = :duration, feeonline = :feeonline, feeoffline = :feeoffline, total = :total, time_start = :time_start, time_end = :time_end, note = :note, inhome = :inhome, homeimgthumb = :homeimgthumb, hometext = :hometext, homeimgfile = :homeimgfile, bodytext = :bodytext WHERE id=' . $row['id'] );
			}
			$stmt->bindParam( ':id_courses', $row['id_courses'], PDO::PARAM_STR );
			$stmt->bindParam( ':sciencecat', $row['sciencecat'], PDO::PARAM_STR );
			$stmt->bindParam( ':teacherid', $row['teacherid'], PDO::PARAM_INT );
			$stmt->bindParam( ':alias', $row['alias'], PDO::PARAM_STR );
			$stmt->bindParam( ':name_courses', $row['name_courses'], PDO::PARAM_STR );
			$stmt->bindParam( ':schedule', $row['schedule'], PDO::PARAM_STR );
			$stmt->bindParam( ':duration', $row['duration'], PDO::PARAM_INT );
			$stmt->bindParam( ':feeonline', $row['feeonline'], PDO::PARAM_INT );
			$stmt->bindParam( ':feeoffline', $row['feeoffline'], PDO::PARAM_INT );
			$stmt->bindParam( ':total', $row['total'], PDO::PARAM_INT );
			$stmt->bindParam( ':time_start', $row['time_start'], PDO::PARAM_INT );
			$stmt->bindParam( ':time_end', $row['time_end'], PDO::PARAM_INT );
			$stmt->bindParam( ':note', $row['note'], PDO::PARAM_STR, strlen($row['note']) );
			$stmt->bindParam( ':inhome', $row['inhome'], PDO::PARAM_INT );
			$stmt->bindParam( ':homeimgthumb', $row['homeimgthumb'], PDO::PARAM_INT );
			$stmt->bindParam( ':hometext', $row['hometext'], PDO::PARAM_STR, strlen($row['hometext']) );
			$stmt->bindParam( ':homeimgfile', $row['homeimgfile'], PDO::PARAM_STR );
			$stmt->bindParam( ':bodytext', $row['bodytext'], PDO::PARAM_STR, strlen($row['bodytext']) );

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
	$row = $db->query( 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_courses WHERE id=' . $row['id'] )->fetch();
	if( empty( $row ) )
	{
		Header( 'Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op );
		die();
	}
}
else
{
	$row['id'] = 0;
	$row['id_courses'] = '';
	$row['sciencecat'] = '0';
	$row['teacherid'] = 0;
	$row['alias'] = '';
	$row['name_courses'] = '';
	$row['schedule'] = '';
	$row['duration'] = 0;
	$row['feeonline'] = 0;
	$row['feeoffline'] = 0;
	$row['total'] = 0;
	$row['time_start'] = 0;
	$row['time_end'] = 0;
	$row['note'] = '';
	$row['inhome'] = 1;
	$row['homeimgthumb'] = 0;
	$row['hometext'] = '';
	$row['homeimgfile'] = '';
	$row['bodytext'] = '';
}

if( empty( $row['time_start'] ) )
{
	$row['time_start'] = '';
}
else
{
	$row['time_start'] = date( 'd/m/Y', $row['time_start'] );
}

if( empty( $row['time_end'] ) )
{
	$row['time_end'] = '';
}
else
{
	$row['time_end'] = date( 'd/m/Y', $row['time_end'] );
}
if( ! empty( $row['homeimgfile'] ) and is_file( NV_UPLOADS_REAL_DIR . '/' . $module_upload . '/' . $row['homeimgfile'] ) )
{
	$row['homeimgfile'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/' . $row['homeimgfile'];
}

if( defined( 'NV_EDITOR' ) ) require_once NV_ROOTDIR . '/' . NV_EDITORSDIR . '/' . NV_EDITOR . '/nv.php';
$row['note'] = htmlspecialchars( nv_editor_br2nl( $row['note'] ) );
if( defined( 'NV_EDITOR' ) and nv_function_exists( 'nv_aleditor' ) )
{
	$row['note'] = nv_aleditor( 'note', '100%', '300px', $row['note'] );
}
else
{
	$row['note'] = '<textarea style="width:100%;height:300px" name="note">' . $row['note'] . '</textarea>';
}

$row['hometext'] = htmlspecialchars( nv_editor_br2nl( $row['hometext'] ) );
if( defined( 'NV_EDITOR' ) and nv_function_exists( 'nv_aleditor' ) )
{
	$row['hometext'] = nv_aleditor( 'hometext', '100%', '300px', $row['hometext'] );
}
else
{
	$row['hometext'] = '<textarea style="width:100%;height:300px" name="hometext">' . $row['hometext'] . '</textarea>';
}

$row['bodytext'] = htmlspecialchars( nv_editor_br2nl( $row['bodytext'] ) );
if( defined( 'NV_EDITOR' ) and nv_function_exists( 'nv_aleditor' ) )
{
	$row['bodytext'] = nv_aleditor( 'bodytext', '100%', '300px', $row['bodytext'] );
}
else
{
	$row['bodytext'] = '<textarea style="width:100%;height:300px" name="bodytext">' . $row['bodytext'] . '</textarea>';
}

$array_sciencecat_courses = array();
$_sql = 'SELECT catid,title FROM nv4_vi_courses_sciencecat';
$_query = $db->query( $_sql );
while( $_row = $_query->fetch() )
{
	$array_sciencecat_courses[$_row['catid']] = $_row;
}

$array_teacherid_courses = array();
$_sql = 'SELECT id,lname FROM nv4_vi_courses_teacher';
$_query = $db->query( $_sql );
while( $_row = $_query->fetch() )
{
	$array_teacherid_courses[$_row['id']] = $_row;
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
		->from( '' . NV_PREFIXLANG . '_' . $module_data . '_courses' );

	if( ! empty( $q ) )
	{
		$db->where( 'id_courses LIKE :q_id_courses OR sciencecat LIKE :q_sciencecat OR teacherid LIKE :q_teacherid OR name_courses LIKE :q_name_courses OR feeonline LIKE :q_feeonline OR feeoffline LIKE :q_feeoffline OR total LIKE :q_total OR time_start LIKE :q_time_start OR time_end LIKE :q_time_end OR status LIKE :q_status' );
	}
	$sth = $db->prepare( $db->sql() );

	if( ! empty( $q ) )
	{
		$sth->bindValue( ':q_id_courses', '%' . $q . '%' );
		$sth->bindValue( ':q_sciencecat', '%' . $q . '%' );
		$sth->bindValue( ':q_teacherid', '%' . $q . '%' );
		$sth->bindValue( ':q_name_courses', '%' . $q . '%' );
		$sth->bindValue( ':q_feeonline', '%' . $q . '%' );
		$sth->bindValue( ':q_feeoffline', '%' . $q . '%' );
		$sth->bindValue( ':q_total', '%' . $q . '%' );
		$sth->bindValue( ':q_time_start', '%' . $q . '%' );
		$sth->bindValue( ':q_time_end', '%' . $q . '%' );
		$sth->bindValue( ':q_status', '%' . $q . '%' );
	}
	$sth->execute();
	$num_items = $sth->fetchColumn();

	$db->select( '*' )
		->order( 'publtime ASC' )
		->limit( $per_page )
		->offset( ( $page - 1 ) * $per_page );
	$sth = $db->prepare( $db->sql() );

	if( ! empty( $q ) )
	{
		$sth->bindValue( ':q_id_courses', '%' . $q . '%' );
		$sth->bindValue( ':q_sciencecat', '%' . $q . '%' );
		$sth->bindValue( ':q_teacherid', '%' . $q . '%' );
		$sth->bindValue( ':q_name_courses', '%' . $q . '%' );
		$sth->bindValue( ':q_feeonline', '%' . $q . '%' );
		$sth->bindValue( ':q_feeoffline', '%' . $q . '%' );
		$sth->bindValue( ':q_total', '%' . $q . '%' );
		$sth->bindValue( ':q_time_start', '%' . $q . '%' );
		$sth->bindValue( ':q_time_end', '%' . $q . '%' );
		$sth->bindValue( ':q_status', '%' . $q . '%' );
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

foreach( $array_sciencecat_courses as $value )
{
	$xtpl->assign( 'OPTION', array(
		'key' => $value['catid'],
		'title' => $value['title'],
		'selected' => ($value['catid'] == $row['sciencecat']) ? ' selected="selected"' : ''
	) );
	$xtpl->parse( 'main.select_sciencecat' );
}
foreach( $array_teacherid_courses as $value )
{
	$xtpl->assign( 'OPTION', array(
		'key' => $value['id'],
		'title' => $value['lname'],
		'selected' => ($value['id'] == $row['teacherid']) ? ' selected="selected"' : ''
	) );
	$xtpl->parse( 'main.select_teacherid' );
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
		for( $i = 1; $i <= $num_items; ++$i )
		{
			$xtpl->assign( 'WEIGHT', array(
				'key' => $i,
				'title' => $i,
				'selected' => ( $i == $view['publtime'] ) ? ' selected="selected"' : '') );
			$xtpl->parse( 'main.view.loop.publtime_loop' );
		}
		$xtpl->assign( 'CHECK', $view['status'] == 1 ? 'checked' : '' );
		$view['time_start'] = ( empty( $view['time_start'] )) ? '' : nv_date( 'H:i d/m/Y', $view['time_start'] );
		$view['time_end'] = ( empty( $view['time_end'] )) ? '' : nv_date( 'H:i d/m/Y', $view['time_end'] );
		$view['sciencecat'] = $array_sciencecat_courses[$view['sciencecat']]['title'];
		$view['teacherid'] = $array_teacherid_courses[$view['teacherid']]['lname'];
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
if( empty( $row['id'] ) )
{
	$xtpl->parse( 'main.auto_get_alias' );
}

$xtpl->parse( 'main' );
$contents = $xtpl->text( 'main' );

$page_title = $lang_module['courses'];

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme( $contents );
include NV_ROOTDIR . '/includes/footer.php';