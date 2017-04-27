<h1>Список документов</h1>
{if isset($error)}
<p class="error">{$error}</p>
{/if}
<ul class="menu mb">
	<li>
		<a href="/documents/add.php">Добавить новый документ</a>
	</li>
</ul>
<table class="table">
	<tr>
		<th>дисциплина</th>
		<th>название</th>
		<th>размер</th>
		<th>действия</th>
	</tr>
{foreach from=$document_list item=document}
	<tr>
		<td>{$document.discipline}</td>
		<td>{$document.name}</td>
		<td>{$document.size|filesize}</td>
		<td>
			<ul class="menu">
				<li><a href="/documents/authors/index.php?id={$document.id}">Авторы</a></li>
				<li><a href="/documents/download.php?id={$document.id}">Скачать</a></li>
				<li><a href="/documents/edit.php?id={$document.id}">Редактировать</a></li>
				<li><a href="/documents/delete.php?id={$document.id}">Удалить</a></li>
			</ul>
		</td>
	</tr>
{foreachelse}
	<tr>
		<td colspan="4">
			<p><i>Документов нет.</i></p>
		</td>
	</tr>
{/foreach}
</table>
{include file='paginator.tpl' page=$page count=$count limit=$limit}