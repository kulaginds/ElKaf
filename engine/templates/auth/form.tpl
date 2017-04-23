<form action="index.php" method="POST">
	<fieldset>
		<legend>Форма входа</legend>
		{if isset($error)}
		<p class="error">{$error}</p>
		{/if}
		<table>
			<tr>
				<td>ФИО:</td>
				<td>
					<input type="text" name="name" value="{$name}">
				</td>
			</tr>
			<tr>
				<td>Пароль:</td>
				<td>
					<input type="password" name="password" value="{$password}">
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<button type="submit" name="action" value="login">Войти</button>
				</td>
			</tr>
		</table>
	</fieldset>
</form>