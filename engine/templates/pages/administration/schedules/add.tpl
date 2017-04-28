<h1>Добавление нового расписания</h1>
{if isset($error)}
<p class="error">{$error}</p>
{/if}
<form action="/administration/schedules/add.php" method="POST">
	<fieldset>
		<table>
			<tr>
				<td>название:</td>
				<td>
					<input type="text" name="name" value="{$name}">
				</td>
			</tr>
			<tr>
				<td>группа:</td>
				<td>
					<select name="group">
					{foreach from=$group_list item=tgroup}
					{if $group == $tgroup.id}
						<option value="{$tgroup.id}" selected>{$tgroup.name}</option>
					{else}
						<option value="{$tgroup.id}">{$tgroup.name}</option>
					{/if}
					{/foreach}
					</select>
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