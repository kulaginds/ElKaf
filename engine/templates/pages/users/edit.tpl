<h1>Редактирование пользователя</h1>
{if isset($error)}
<p class="error">{$error}</p>
{/if}
{if isset($edit_user)}
<form action="/users/edit.php?id={$edit_user.id}" method="POST">
	<fieldset>
		<table>
			<tr>
				<td>ФИО:</td>
				<td>
					<input type="text" name="name" value="{$edit_user.name}">
				</td>
			</tr>
			<tr>
				<td>тип:</td>
				<td>
					<select name="type">
					{foreach from=$user_types key=type item=name}
					{if $edit_user.type == $type}
						<option value="{$type}" selected>{$name}</option>
					{else}
						<option value="{$type}">{$name}</option>
					{/if}
					{/foreach}
					</select>
				</td>
			</tr>
			<tr>
				<td>описание:</td>
				<td>
					<textarea name="description" cols="30" rows="5">{$edit_user.description}</textarea>
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