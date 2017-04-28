<h1>Список авторов документа "{$document.name}"</h1>
{if isset($error)}
<p class="error">{$error}</p>
{/if}
<ul class="menu mb">
	<li>
		<a href="/administration/documents/index.php">Список документов</a>
	</li>
	<li>
		<a href="/administration/documents/authors/add.php?id={$document.id}">Добавить авторов к документу</a>
	</li>
</ul>
<table class="table">
	<tr>
		<th>ФИО</th>
		<th>описание</th>
		<th>действия</th>
	</tr>
{foreach from=$author_list item=author}
	<tr>
		<td>{$author.name}</td>
		<td>
		{if empty($author.description)}
			<p class="center"><i>нет</i></p>
		{else}
			{$author.description}
		{/if}
		</td>
		<td>
			<ul class="menu">
				<li><a href="/administration/documents/authors/delete.php?id={$document.id}&author_id={$author.id}">Удалить</a></li>
			</ul>
		</td>
	</tr>
{foreachelse}
	<tr>
		<td colspan="4">
			<p><i>У документа нет авторов.</i></p>
		</td>
	</tr>
{/foreach}
</table>
{include file='paginator.tpl' page=$page count=$count limit=$limit}