<?php

$access = 'teacher';

include(__DIR__.'/../../engine/header.php');
require_once(__DIR__.'/../../engine/modules/users/users.php');
require_once(__DIR__.'/../../engine/modules/disciplines/disciplines.php');
require_once(__DIR__.'/../../engine/modules/documents/documents.php');

$users         = new Users($db, $smarty, $config['user_types'], $config['security']['auth_salt']);
$disciplines   = new Disciplines($db, $users);
$documents     = new Documents($db, $auth, $users, $disciplines, $config['documents']['allowed_types'], $config['documents']['upload_dir']);
$document_list = null;
$discipline    = null;
$id            = max((int)$_GET['id'], 0);

try {
	$document_list = $documents->get_discipline_document_list($id);
	$discipline    = $disciplines->get_discipline($id);
} catch (Exception $e) {
	$smarty->assign('error', $e->getMessage());
}

$smarty->assign('discipline', $discipline);
$smarty->assign('document_list', $document_list);
$smarty->assign('page', $documents->page);
$smarty->assign('count', $documents->document_list_count);
$smarty->assign('limit', $documents->document_list_limit);

$smarty->display('pages/teaching/documents/discipline.tpl');

include(__DIR__.'/../../engine/footer.php');

?>