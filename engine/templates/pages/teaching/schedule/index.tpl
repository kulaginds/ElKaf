<h1>Моё расписание</h1>
{if isset($error)}
<p class="error">{$error}</p>
{/if}
<form action="/teaching/schedule/index.php" class="mb">
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
		<th colspan="3">{$weekday}</th>
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
			{$weekday.group}
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