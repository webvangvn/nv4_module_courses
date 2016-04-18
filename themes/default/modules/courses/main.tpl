<!-- BEGIN: main -->
<div id="checkpoint">
	<div class="cpcontent">
		<div class="tieude">{CAUHINH.0}</div>
	</div>
</div>
<div id="checkpoint">
	<div class="cpcontent">
		<h3 class="header">Tra cứu kết quả học tập</h3>
		<!-- BEGIN: block_table-->
			<form id="search_diem" name="frm_search" method="post" align="center">
			<div class="huongdan" align="center"><a>{CAUHINH.1}</a></div>
			<table border = "0" class = "tracuutb" id = "tracuutb">
				<tr>
					<td height = "25px"><b>Từ khóa: </b></td>
					<td><span class="tracuu_input">
					<input name="keywords" id="keyword" type="text" style="width:220px"></td></span>			
				</tr>
				<tr>
					<td height = "25px">Khóa học:</td>
					<td><span class="tracuu_input">
						<select name="scienceid" id="scienceid" style="width:224px">
							<option value="0">Chọn khóa học</option>
							<!-- BEGIN: loop_nh-->
							<option value={MAKHOAHOC}>{TENKHOAHOC}</option>
							<!-- END: loop_nh -->
						</select></span>
					</td>
				</tr>
				<tr>
					<td height = "25px">Lớp học:</td>
					<td><span class="tracuu_input">
						<select name="classid" id="classid" style="width:224px">
							<option value="0">Chọn lớp học</option>
							<!-- BEGIN: loop_lh-->
							<option value={MALOPHOC}>{TENLOPHOC}</option>
							<!-- END: loop_lh -->
						</select></span>
					</td>
				</tr>
				<tr>
					<td height = "25px">Tìm theo:</td>
					<td>
						<span class="tracuu_input">
						<input value="1" name="findtype" id="ho" type="radio"> Họ Và Tên &nbsp;&nbsp;&nbsp;
						<input value="2" id="mahs" name="findtype" checked="checked" type="radio"> 
						Mã HS </span></td>
				</tr>

			</table>
				<div align = "center"><button id="button_submit" value="click" type="submit">Tra cứu</button></div>
			</form>
			<div style="clear:both"></div>
			<div id="result"></div>
			{SCRIPT}
		<!-- END: block_table -->
	</div>
	<div class="shadowmod">
		<span class="shadowmod1"></span>
		<span class="shadowmod2"></span>
	</div>
</div>

<!-- BEGIN: block_tablekq -->
<div id="checkpoint">
	<div class="cpcontent">
		<h3 class="header">Kết quả học tập</h3>
			<div class="kqseach">Tìm thấy <font color = red>{COUNT}</font> hồ sơ <font color = red>{KEY}</font></div>
			<table class="tieude" style="border-collapse:collapse;border-color:#999999" cellpadding="2" cellspacing="2" width="100%" border="1">
			<tr class = "stitle">
				<td width = 10%>Mã số </td>
				<td width = 10%>Niên khóa</td>
				<td width = 10%>Lớp </td>
				<td colspan="2" >Họ và tên</td>
				
				<td width = 15%>Ngày sinh</td>
				<td>Nơi sinh</td>
				<td width = 10%>Chi tiết</td>
			</tr>
			<!-- BEGIN:loop_kq -->
			<tr class = "tiet">
				<td><a href ={LINKS}={MAHS}&hkid={HKID}&namid={NAMID}&findtype={FINDTYPE}>{MAHS}</a></td>
				<td width = 10%>{NIENKHOA}</td>
				<td width = 10%>{TENLOP}</td>
				<td align = "left">&nbsp;{HO}</td>
				<td align = "left">&nbsp;{NAME}</td>
				<td>{NGSINH}</td>
				<td align = "left">{NOISINH}</td>
				<td><a href ={LINKS}={MAHS}&hkid={HKID}&namid={NAMID}&findtype={FINDTYPE}>Xem</a></td>
			</tr>
			<!-- END:loop_kq -->
			</table>
	</div>
	<div class="shadowmod">
		<span class="shadowmod1"></span>
		<span class="shadowmod2"></span>
	</div>
</div>
<!-- END: block_tablekq -->

<!-- END: main -->
<!-- BEGIN: hocsinh -->
<div id="checkpoint">
	<div class="cpcontent">
		<div class="tieude">{CAUHINH.0}</div>
	</div>
</div>
<div id="checkpoint">
	<div class="cpcontent">
		<h3 class="header">Tra cứu kết quả học tập</h3>
		<!-- BEGIN: block_table-->
			<form id="search_diem" name="frm_search" method="post" align="center">
			<table border = "0" class = "tracuutb" id = "tracuutb">
				<tr>
					<td height = "25px">Năm học:</td>
					<td><span class="tracuu_input">
						<select name="namid" id="namid" style="width:224px">
							<option value="0">Chọn năm học</option>
							<!-- BEGIN: loop_nh-->
							<option value={MANAMHOC}>{TENNAMHOC}</option>
							<!-- END: loop_nh -->
						</select></span>
					</td>
				</tr>
				<tr>
					<td height = "25px">Lớp học:</td>
					<td><span class="tracuu_input">
						<select name="lopid" id="lopid" style="width:224px">
							<option value="0">Chọn lớp học</option>
							<!-- BEGIN: loop_l-->
							<option value={MALOP}>{TENLOP}</option>
							<!-- END: loop_l -->
						</select></span>
					</td>
				</tr>
				<tr>
					<td height = "25px">Học kì:</td>
					<td><span class="tracuu_input">
						<select name="hkid" id="hkid" style="width:224px">
							<option value="0">Chọn học kì</option>
							<!-- BEGIN: loop_hk-->
							<option value={MAHK}>{TENHK}</option>
							<!-- END: loop_hk -->
						</select></span>
					</td>
				</tr>

			</table>
				<div align = "center"><button id="button_submit" value="click" type="submit">Tra cứu</button></div>
			</form>
			<div style="clear:both"></div>
			<div id="result"></div>
			{SCRIPT}
		<!-- END: block_table -->
	</div>
	<div class="shadowmod">
		<span class="shadowmod1"></span>
		<span class="shadowmod2"></span>
	</div>
</div>
<!-- BEGIN: block_tablekq -->
<div id="checkpoint">
	<div class="cpcontent">
		<h3 class="header">Kết quả học tập</h3>
			<div class="kqseach">Tìm thấy <font color = red>{COUNT}</font> hồ sơ với từ khoá <font color = red>{KEY}</font></div>
			<table class="tieude" style="border-collapse:collapse;border-color:#999999" cellpadding="2" cellspacing="2" width="100%" border="1">
			<tr class = "stitle">
				<td width = 10%>Mã số </td>
				<td>Họ tên</td>
				<td width = 15%>Ngày sinh</td>
				<td>Nơi sinh</td>
				<td width = 10%>Chi tiết</td>
			</tr>
			<!-- BEGIN:loop_kq -->
			<tr class = "tiet">
				<td><a href ={LINKS}={MAHS}&hkid={HKID}&namid={NAMID}&findtype={FINDTYPE}>{MAHS}</a></td>
				<td align = "left">&nbsp;{HOTEN}</td>
				<td>{NGSINH}</td>
				<td align = "left">{NOISINH}</td>
				<td><a href ={LINKS}={MAHS}&hkid={HKID}&namid={NAMID}&findtype={FINDTYPE}>Xem</a></td>
			</tr>
			<!-- END:loop_kq -->
			</table>
	</div>
	<div class="shadowmod">
		<span class="shadowmod1"></span>
		<span class="shadowmod2"></span>
	</div>
</div>
<!-- END: block_tablekq -->

<!-- END: hocsinh -->
<!-- BEGIN: diemhs -->
<div id="checkpoint">
	<div class="cpcontent">
		<div class="tieude">{CAUHINH.0}</div>
		bang diểm
		<!-- BEGIN: block_tablekq -->
			<div class="kqseach">Tìm thấy <font color = red>{COUNT}</font> hồ sơ với từ khoá <font color = red>{KEY}</font></div>
			<table class="tieude" style="border-collapse:collapse;border-color:#999999" cellpadding="2" cellspacing="2" width="100%" border="1">
			<tr class = "stitle">
				<td width = 10%>Mã số </td>
				<td>Họ </td>
				<td>Tên </td>
				<td width = 15%>Ngày sinh</td>
				<td>Nơi sinh</td>
				<td width = 10%>Chi tiết</td>
			</tr>
			<!-- BEGIN:loop_kq -->
			<tr class = "tiet">
				<td><a href ={LINKS}={MAHS}&hkid={HKID}&namid={NAMID}&findtype={FINDTYPE}>{MAHS}</a></td>
				<td align = "left">&nbsp;{HO}</td>
				<td align = "left">&nbsp;{NAME}</td>
				<td>{NGSINH}</td>
				<td align = "left">{NOISINH}</td>
				<td><a href ={LINKS}={MAHS}&hkid={HKID}&namid={NAMID}&findtype={FINDTYPE}>Xem</a></td>
			</tr>
			<!-- END:loop_kq -->
			</table>
		<!-- END: block_tablekq -->
	</div>
	<div class="shadowmod">
		<span class="shadowmod1"></span>
		<span class="shadowmod2"></span>
	</div>
</div>
<!-- END: diemhs-->
