<h1>Удаление документа</h1>
{if isset($error)}
<p class="error">{$error}</p>
{/if}
{if isset($delete_document)}
<p>Вы уверены, что хотите удалить файл "{$delete_document.name}"?</p>
<ul class="menu mb">
	<li>
		<form action="/teaching/documents/delete.php?id={$delete_document.id}" method="POST">
			<input type="hidden" name="action" value="delete">
			<input type="submit" value="Да">
		</form>
	</li>
	<li><a href="/teaching/documents/index.php">Нет</a></li>
</ul>
{/if}