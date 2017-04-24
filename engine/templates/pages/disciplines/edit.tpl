<h1>Редактирование дисциплины</h1>
{if isset($error)}
<p class="error">{$error}</p>
{/if}
{if isset($edit_discipline)}
<form action="/disciplines/edit.php?id={$edit_discipline.id}" method="POST">
	<fieldset>
		<table>
			<tr>
				<td>название:</td>
				<td>
					<input type="text" name="name" value="{$edit_discipline.name}">
				</td>
			</tr>
			<tr>
				<td>описание:</td>
				<td>
					<textarea name="description" cols="30" rows="5">{$edit_discipline.description}</textarea>
				</td>
			</tr>
			<tr>
				<td>литература:</td>
				<td>
					<textarea name="literature" cols="30" rows="5">{$edit_discipline.literature}</textarea>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<button name="action" value="edit">Сохранить</button>
				</td>
			</tr>
		</table>
	</fieldset>
</form>
{/if}