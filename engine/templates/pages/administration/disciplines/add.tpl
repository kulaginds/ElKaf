<h1>Добавление новой дисциплины</h1>
{if isset($error)}
<p class="error">{$error}</p>
{/if}
<form action="/administration/disciplines/add.php" method="POST">
	<fieldset>
		<table>
			<tr>
				<td>название:</td>
				<td>
					<input type="text" name="name" value="{$name}">
				</td>
			</tr>
			<tr>
				<td>описание:</td>
				<td>
					<textarea name="description" cols="30" rows="5">{$description}</textarea>
				</td>
			</tr>
			<tr>
				<td>литература:</td>
				<td>
					<textarea name="literature" cols="30" rows="5">{$literature}</textarea>
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