<h1>Редактирование пары в расписании "{$schedule.name}" на {$weekdays[$edit_couple.weekday_index]}, {$weeks[$edit_couple.week]}</h1>
{if isset($error)}
<p class="error">{$error}</p>
{/if}
{if isset($edit_couple)}
<form action="/administration/schedules/couples/day/edit.php?id={$edit_couple.id}" method="POST">
	<fieldset>
		<table>
			<tr>
				<td>дисциплина:</td>
				<td>
					<select name="discipline">
					{foreach from=$discipline_list item=tdiscipline}
					{if $edit_couple.discipline_id == $tdiscipline.id}
						<option value="{$tdiscipline.id}" selected>{$tdiscipline.name}</option>
					{else}
						<option value="{$tdiscipline.id}">{$tdiscipline.name}</option>
					{/if}
					{/foreach}
					</select>
				</td>
			</tr>
			<tr>
				<td>преподаватель:</td>
				<td>
					<select name="teacher">
					{foreach from=$teacher_list item=tteacher}
					{if $edit_couple.user_id == $tteacher.id}
						<option value="{$tteacher.id}" selected>{$tteacher.name}</option>
					{else}
						<option value="{$tteacher.id}">{$tteacher.name}</option>
					{/if}
					{/foreach}
					</select>
				</td>
			</tr>
			<tr>
				<td>аудитория:</td>
				<td>
					<input type="text" name="auditory" value="{$edit_couple.auditory}">
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<button name="action" value="edit_couple">Сохранить</button>
				</td>
			</tr>
		</table>
	</fieldset>
</form>
{/if}