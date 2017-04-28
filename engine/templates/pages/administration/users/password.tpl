<h1>Установка нового пароля пользователя</h1>
{if isset($error)}
<p class="error">{$error}</p>
{/if}
{if isset($edit_user)}
<form action="/administration/users/password.php?id={$edit_user.id}" method="POST">
	<fieldset>
		<table>
			<tr>
				<td>пользователь:</td>
				<td>{$edit_user.name}</td>
			</tr>
			<tr>
				<td>пароль:</td>
				<td>
					<input type="password" name="password" value="{$password}">
				</td>
			</tr>
			<tr>
				<td>повтор пароля:</td>
				<td>
					<input type="password" name="password_confirm" value="{$password_confirm}">
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<button name="action" value="password">Сохранить</button>
				</td>
			</tr>
		</table>
	</fieldset>
</form>
{/if}