<h1>Удаление автора из документа</h1>
{if isset($error)}
<p class="error">{$error}</p>
{/if}
{if isset($document) && isset($author)}
<p>Вы уверены, что хотите удалить автора "{$author.name}" из документа "{$document.name}"?</p>
<ul class="menu mb">
	<li>
		<form action="/documents/authors/delete.php?id={$document.id}&author_id={$author.id}" method="POST">
			<input type="hidden" name="action" value="delete_author">
			<input type="submit" value="Да">
		</form>
	</li>
	<li><a href="/documents/authors/index.php?id={$document.id}">Нет</a></li>
</ul>
{/if}