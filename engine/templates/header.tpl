<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<title>{$config.title}</title>
	<link rel="stylesheet" href="/css/template.css">
	<link rel="stylesheet" href="/css/main-theme.css">
</head>
<body>
	<div class="container">
		<header>
			<div class="picture">
				<img src="/images/univ.jpg" width="100" alt="Севастопольский государственный университет">
			</div>
			<div class="description">
				<h1>{$config.header.title}</h1>
				<p class="slogan">{$config.header.slogan}</p>
			</div>
		</header>
		<nav>
			<ul class="menu">
			{foreach from=$config.menu item=item}
				<li><a href="{$item.href}">{$item.title}</a></li>
			{/foreach}
			</ul>
		</nav>
		<div class="content">