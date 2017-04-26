<h1>Редактирование расписания</h1>
{if isset($error)}
<p class="error">{$error}</p>
{/if}
{if isset($edit_schedule)}
<form action="/schedules/edit.php?id={$edit_schedule.id}" method="POST">
	<fieldset>
		<table>
			<tr>
				<td>название:</td>
				<td>
					<input type="text" name="name" value="{$edit_schedule.name}">
				</td>
			</tr>
			<tr>
				<td>группа:</td>
				<td>
					<select name="group">
					{foreach from=$group_list item=group}
					{if $edit_schedule.group_id == $group.id}
						<option value="{$group.id}" selected>{$group.name}</option>
					{else}
						<option value="{$group.id}">{$group.name}</option>
					{/if}
					{/foreach}
					</select>
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