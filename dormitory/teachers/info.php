<?php

$access = 'student';

include(__DIR__.'/../../engine/header.php');
require_once(__DIR__.'/../../engine/modules/users/users.php');
require_once(__DIR__.'/../../engine/modules/disciplines/disciplines.php');
require_once(__DIR__.'/../../engine/modules/documents/documents.php');

$users           = new Users($db, $smarty, $config['user_types'], $config['security']['auth_salt']);
$disciplines     = new Disciplines($db, $users);
$documents       = new Documents($db, $auth, $users, $disciplines, $config['documents']['allowed_types'], $config['documents']['upload_dir']);
$teacher         = null;
$discipline_list = null;
$document_list   = null;
$id              = max((int)$_GET['id'], 0);

try {
	$teacher = $users->get_teacher($id);
} catch (Exception $e) {
	$smarty->assign('error', $e->getMessage());
}

try {
	$discipline_list = $disciplines->get_teacher_discipline_list($teacher['id']);
	$document_list   = $documents->get_teacher_document_list($teacher['id']);
} catch (Exception $e) {
	$smarty->assign('error', $e->getMessage());
}

$smarty->assign('teacher', $teacher);
$smarty->assign('discipline_list', $discipline_list);
$smarty->assign('document_list', $document_list);

$smarty->display('pages/dormitory/teachers/info.tpl');

include(__DIR__.'/../../engine/footer.php');

?>