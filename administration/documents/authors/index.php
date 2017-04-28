<?php

$access = 'administrator';

include(__DIR__.'/../../../engine/header.php');
require_once(__DIR__.'/../../../engine/modules/users/users.php');
require_once(__DIR__.'/../../../engine/modules/disciplines/disciplines.php');
require_once(__DIR__.'/../../../engine/modules/documents/documents.php');

$users       = new Users($db, $smarty, $config['user_types'], $config['security']['auth_salt']);
$disciplines = new Disciplines($db, $users);
$documents   = new Documents($db, $users, $disciplines, $config['documents']['allowed_types'], $config['documents']['upload_dir']);
$document    = null;
$author_list = null;
$id          = max((int)$_GET['id'], 0);

try {
	$document    = $documents->get_document($id);
	$author_list = $users->get_authors_in_document($id);
} catch (Exception $e) {
	$smarty->assign('error', $e->getMessage());
}

$smarty->assign('document', $document);
$smarty->assign('author_list', $author_list);
$smarty->assign('page', $disciplines->page);
$smarty->assign('count', $disciplines->document_list_count);
$smarty->assign('limit', $disciplines->document_list_limit);

$smarty->display('pages/administration/documents/authors/index.tpl');

include(__DIR__.'/../../../engine/footer.php');

?>