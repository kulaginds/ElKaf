<h1>Редактирование документа</h1>
{if isset($error)}
<p class="error">{$error}</p>
{/if}
{if isset($edit_document)}
<form action="/documents/edit.php?id={$edit_document.id}" method="POST">
	<fieldset>
		<table>
			<tr>
				<td>дисциплина:</td>
				<td>
					<select name="discipline">
					{foreach from=$discipline_list item=tdiscipline}
					{if $edit_document.discipline_id == $tdiscipline.id}
						<option value="{$tdiscipline.id}" selected>{$tdiscipline.name}</option>
					{else}
						<option value="{$tdiscipline.id}">{$tdiscipline.name}</option>
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