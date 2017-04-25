<h1>Редактирование группы</h1>
{if isset($error)}
<p class="error">{$error}</p>
{/if}
{if isset($edit_group)}
<form action="/groups/edit.php?id={$edit_group.id}" method="POST">
	<fieldset>
		<table>
			<tr>
				<td>название:</td>
				<td>
					<input type="text" name="name" value="{$edit_group.name}">
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