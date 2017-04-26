<h1>Добавление пары в расписание "{$schedule.name}" на {$weekdays.$weekday_index}, {$weeks.$week}</h1>
{if isset($error)}
<p class="error">{$error}</p>
{/if}
<form action="/schedules/couples/day/add.php?id={$schedule.id}&week={$week}&weekday_index={$weekday_index}&couple_index={$couple_index}" method="POST">
	<fieldset>
		<table>
			<tr>
				<td>дисциплина:</td>
				<td>
					<select name="discipline">
					{foreach from=$discipline_list item=tdiscipline}
					{if $discipline == $tdiscipline.id}
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
					{if $teacher == $tteacher.id}
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
					<input type="text" name="auditory" value="{$auditory}">
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<button name="action" value="add_couple">Добавить</button>
				</td>
			</tr>
		</table>
	</fieldset>
</form>