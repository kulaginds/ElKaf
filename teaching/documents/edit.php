<?php

$access = 'teacher';

include(__DIR__.'/../../engine/header.php');
require_once(__DIR__.'/../../engine/modules/users/users.php');
require_once(__DIR__.'/../../engine/modules/disciplines/disciplines.php');
require_once(__DIR__.'/../../engine/modules/documents/documents.php');

$users           = new Users($db, $smarty, $config['user_types'], $config['security']['auth_salt']);
$disciplines     = new Disciplines($db, $users);
$documents       = new Documents($db, $auth, $users, $disciplines, $config['documents']['allowed_types'], $config['documents']['upload_dir']);
$document        = null;
$discipline_list = null;
$id              = max((int)$_GET['id'], 0);

try {
	$documents->handle_actions();
} catch (Exception $e) {
	$smarty->assign('error', $e->getMessage());
}

try {
	$document        = $documents->get_teacher_document($auth->get_user()['id'], $id);
	$discipline_list = $disciplines->get_teacher_discipline_list($auth->get_user()['id']);
} catch (Exception $e) {
	$smarty->assign('error', $e->getMessage());
}

$smarty->assign('discipline_list', $discipline_list);
$smarty->assign('edit_document', $document);

$smarty->display('pages/teaching/documents/edit.tpl');

include(__DIR__.'/../../engine/footer.php');

?>