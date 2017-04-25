<h1>Добавление новой группы</h1>
{if isset($error)}
<p class="error">{$error}</p>
{/if}
<form action="/groups/add.php" method="POST">
	<fieldset>
		<table>
			<tr>
				<td>название:</td>
				<td>
					<input type="text" name="name" value="{$name}">
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<button name="action" value="add">Добавить</button>
				</td>
			</tr>
		</table>
	</fieldset>
</form>