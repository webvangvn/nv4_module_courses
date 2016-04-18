<!-- BEGIN: main -->
<!-- BEGIN: cat_title -->
<div style="background:#eee;padding:10px">
	{CAT_TITLE}
</div>
<!-- END: cat_title -->
<!-- BEGIN: data -->
<div class="table-responsive">
	<table class="table table-striped table-bordered table-hover">
		<col span="6" style="white-space: nowrap;" />
		<col class="w250" />
		<col style="white-space: nowrap;" />
		<thead>
			<tr>
				<th class="text-center">{LANG.weight}</th>
				<th class="text-center">{LANG.name}</th>
				<th class="text-center">{LANG.functional}</th>
			</tr>
		</thead>
		<tbody>
			<!-- BEGIN: loop -->
			<tr>
				<td class="text-center">
				<!-- BEGIN: stt -->
				{STT}
				<!-- END: stt -->
				<!-- BEGIN: weight -->
				<select class="form-control" id="id_weight_{ROW.catid}" onchange="nv_chang_subjectcat('{ROW.catid}','weight');">
					<!-- BEGIN: loop -->
					<option value="{WEIGHT.key}"{WEIGHT.selected}>{WEIGHT.title}</option>
					<!-- END: loop -->
				</select>
				<!-- END: weight -->
				</td>
				<td><strong>{ROW.title}</strong>
				</td>
				<td class="text-center">{ROW.adminfuncs}</td>
			</tr>
			<!-- END: loop -->
		</tbody>
	</table>
</div>
<!-- END: data -->
<!-- END: main -->