<h1>Документы дисциплины "{$discipline.name}"</h1>
{if isset($error)}
<p class="error">{$error}</p>
{/if}
<ul class="menu mb">
	<li>
		<a href="/teaching/documents/add.php?id={$discipline.id}">Добавить новый документ</a>
	</li>
</ul>
<table class="table">
	<tr>
		<th>автор</th>
		<th>название</th>
		<th>размер</th>
		<th>действия</th>
	</tr>
{foreach from=$document_list item=document}
	<tr>
		<td>
		{if $user.id == $document.author_id}
			Я
		{else}
			{$document.author}
		{/if}
		</td>
		<td>{$document.name}</td>
		<td>{$document.size|filesize}</td>
		<td>
		{if $user.id == $document.author_id}
			<ul class="menu">
				<li><a href="/teaching/documents/download.php?id={$document.id}">Скачать</a></li>
				<li><a href="/teaching/documents/edit.php?id={$document.id}">Редактировать</a></li>
				<li><a href="/teaching/documents/delete.php?id={$document.id}">Удалить</a></li>
			</ul>
		{/if}
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