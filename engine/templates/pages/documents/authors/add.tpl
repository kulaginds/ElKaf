<h1>Добавление авторов к документу</h1>
{if isset($error)}
<p class="error">{$error}</p>
{/if}
<form action="/documents/authors/add.php?id={$document.id}" method="POST">
<input type="hidden" name="action" value="add_authors">
<ul class="menu mb">
	<li><a href="/documents/authors/index.php?id={$document.id}">Cписок авторов</a></li>
</ul>
<table class="table">
	<tr>
		<th><input type="submit" value="Добавить"></th>
		<th>ФИО</th>
		<th>описание</th>
	</tr>
{foreach from=$author_list item=author}
	<tr>
		<td>
			<input type="checkbox" name="authors[]" value="{$author.id}">
		</td>
		<td>{$author.name}</td>
		<td>{$author.description}</td>
	</tr>
{foreachelse}
	<tr>
		<td colspan="3">
			<p><i>Авторов нет.</i></p>
		</td>
	</tr>
{/foreach}
	<tr>
		<th><input type="submit" value="Добавить"></th>
		<th>ФИО</th>
		<th>описание</th>
	</tr>
</table>
<ul class="menu mb">
	<li><a href="/documents/authors/index.php?id={$document.id}">Cписок авторов</a></li>
</ul>
</form>