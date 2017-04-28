<h1>Добавление нового пользователя</h1>
{if isset($error)}
<p class="error">{$error}</p>
{/if}
<form action="/administration/users/add.php" method="POST">
	<fieldset>
		<table>
			<tr>
				<td>ФИО:</td>
				<td>
					<input type="text" name="name" value="{$name}">
				</td>
			</tr>
			<tr>
				<td>тип:</td>
				<td>
					<select name="type">
					{foreach from=$user_types key=utype item=name}
					{if $type == $utype}
						<option value="{$utype}" selected>{$name}</option>
					{else}
						<option value="{$utype}">{$name}</option>
					{/if}
					{/foreach}
					</select>
				</td>
			</tr>
			<tr>
				<td>описание:</td>
				<td>
					<textarea name="description" cols="30" rows="5">{$description}</textarea>
				</td>
			</tr>
			<tr>
				<td>пароль:</td>
				<td>
					<input type="password" name="password">
				</td>
			</tr>
			<tr>
				<td>повтор пароля:</td>
				<td>
					<input type="password" name="password_confirm">
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