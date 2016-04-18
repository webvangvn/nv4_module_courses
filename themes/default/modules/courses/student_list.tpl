<!-- BEGIN: main -->
<!-- BEGIN: view -->
<div class="table-responsive">
		<table class="table table-striped table-bordered table-hover">
			<thead>
				<tr>
					<th class="w100">{LANG.number}</th>
					<th>{LANG.id_student}</th>
					<th>{LANG.fname}</th>
					<th>{LANG.lname}</th>
					<th>{LANG.email}</th>
					<th>{LANG.phone}</th>
					<th>{LANG.address}</th>
				</tr>
			</thead>
			<!-- BEGIN: generate_page -->
			<tfoot>
				<tr>
					<td class="text-center" colspan="6">{NV_GENERATE_PAGE}</td>
				</tr>
			</tfoot>
			<!-- END: generate_page -->
			<tbody>
				<!-- BEGIN: loop -->
				<tr>
					<td> {VIEW.number} </td>
					<td> {VIEW.id_student} </td>
					<td> {VIEW.fname} </td>
					<td> {VIEW.lname} </td>
					<td> {VIEW.email} </td>
					<td> {VIEW.phone} </td>
					<td> {VIEW.address} </td>
					
				</tr>
				<!-- END: loop -->
			</tbody>
		</table>
	</div>
<!-- END: view -->

<!-- END: main -->