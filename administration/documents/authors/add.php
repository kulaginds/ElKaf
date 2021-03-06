<?php

$access = 'administrator';

include(__DIR__.'/../../../engine/header.php');
require_once(__DIR__.'/../../../engine/modules/users/users.php');
require_once(__DIR__.'/../../../engine/modules/disciplines/disciplines.php');
require_once(__DIR__.'/../../../engine/modules/documents/documents.php');

$users       = new Users($db, $smarty, $config['user_types'], $config['security']['auth_salt']);
$disciplines = new Disciplines($db, $users);
$documents   = new Documents($db, $auth, $users, $disciplines, $config['documents']['allowed_types'], $config['documents']['upload_dir']);
$id          = max((int)$_GET['id'], 0);
$document    = null;
$author_list = null;

try {
	$documents->handle_actions();
} catch (Exception $e) {
	$smarty->assign('error', $e->getMessage());
}

try {
	$document    = $documents->get_document($id);
	$author_list = $users->get_authors_not_in_document($id);
} catch (Exception $e) {
	$smarty->assign('error', $e->getMessage());
}

$smarty->assign('document', $document);
$smarty->assign('author_list', $author_list);

$smarty->display('pages/administration/documents/authors/add.tpl');

include(__DIR__.'/../../../engine/footer.php');

?>