<h1>Добавление нового документа</h1>
{if isset($error)}
<p class="error">{$error}</p>
{/if}
<form enctype="multipart/form-data" action="/documents/add.php" method="POST">
	<fieldset>
		<table>
			<tr>
				<td>файл:</td>
				<td>
					<input type="file" name="file"><br>
					<small>разрешённые типы файлов: <b>{", "|implode:$allowed_types}</b></small><br>
					<small>макс. размер файла: <b>{$max_file_size}</b></small>
				</td>
			</tr>
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
				<td colspan="2">
					<button name="action" value="add">Добавить</button>
				</td>
			</tr>
		</table>
	</fieldset>
</form>