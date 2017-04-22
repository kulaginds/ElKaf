<?php /* Smarty version 2.6.30, created on 2017-04-22 20:41:44
         compiled from header.tpl */ ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<title><?php echo $this->_tpl_vars['config']['title']; ?>
</title>
	<link rel="stylesheet" href="/css/template.css">
	<link rel="stylesheet" href="/css/main-theme.css">
</head>
<body>
	<div class="container">
		<header>
			<h1><?php echo $this->_tpl_vars['config']['header']['title']; ?>
</h1>
			<p class="slogan"><?php echo $this->_tpl_vars['config']['header']['slogan']; ?>
</p>
		</header>
		<nav>
			<ul class="menu">
			<?php $_from = $this->_tpl_vars['config']['menu']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
				<li><a href="<?php echo $this->_tpl_vars['item']['href']; ?>
"><?php echo $this->_tpl_vars['item']['title']; ?>
</a></li>
			<?php endforeach; endif; unset($_from); ?>
			</ul>
		</nav>
		<div class="content">