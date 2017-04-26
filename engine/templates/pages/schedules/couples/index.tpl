<h1>Пары расписания "{$schedule.name}"</h1>
{if isset($error)}
<p class="error">{$error}</p>
{/if}
<ul class="menu mb">
	<li>
		<a href="/schedules/index.php">Список расписаний</a>
	</li>
</ul>
<form action="/schedules/couples/index.php" class="mb">
	<input type="hidden" name="id" value="{$schedule.id}">
	<select name="week" onchange="this.form.submit();">
	{foreach from=$weeks key=week_type item=week_name}
	{if $week == $week_type}
		<option value="{$week_type}" selected>{$week_name}</option>
	{else}
		<option value="{$week_type}">{$week_name}</option>
	{/if}
	{/foreach}
	</select>
</form>
<table class="table">
	<tr>
		<th>время</th>
	{foreach from=$weekdays key=weekday_index item=weekday}
		<th colspan="3">
			<a href="/schedules/couples/day/index.php?id={$schedule.id}&week={$week}&weekday_index={$weekday_index}">{$weekday}</a>
		</th>
	{/foreach}
	</tr>
{foreach from=$couple_weekday_list key=couple_index item=couple}
	<tr>
		<td>{"<hr>"|implode:$couples.$couple_index}</td>
	{foreach from=$couple key=weekday_index item=weekday}
		{if !empty($weekday)}
		<td>
			{$weekday.discipline}
		</td>
		<td>
			{$weekday.teacher}
		</td>
		<td>
		{if empty($weekday.auditory)}
			<p>-</p>
		{else}
			{$weekday.auditory}
		{/if}
		</td>
		{else}
		<td colspan="3"></td>
		{/if}
	{/foreach}
	</tr>
{foreachelse}
	<tr>
		<td colspan="24">
			<p><i>Нет пар.</i></p>
		</td>
	</tr>
{/foreach}
</table>