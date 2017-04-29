<?php

$access = 'student';

include(__DIR__.'/../../engine/header.php');
require_once(__DIR__.'/../../engine/modules/users/users.php');
require_once(__DIR__.'/../../engine/modules/disciplines/disciplines.php');
require_once(__DIR__.'/../../engine/modules/documents/documents.php');

$users           = new Users($db, $smarty, $config['user_types'], $config['security']['auth_salt']);
$disciplines     = new Disciplines($db, $users);
$documents       = new Documents($db, $auth, $users, $disciplines, $config['documents']['allowed_types'], $config['documents']['upload_dir']);
$discipline      = null;
$document_list   = null;
$id              = max((int)$_GET['id'], 0);

try {
	$discipline    = $disciplines->get_discipline($id);
	$document_list = $documents->get_discipline_document_list($id);
} catch (Exception $e) {
	$smarty->assign('error', $e->getMessage());
}

$smarty->assign('discipline', $discipline);
$smarty->assign('document_list', $document_list);

$smarty->display('pages/dormitory/disciplines/info.tpl');

include(__DIR__.'/../../engine/footer.php');

?>