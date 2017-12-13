if ($.fn.pagination){
	$.fn.pagination.defaults.beforePageText = 'หน้า';
	$.fn.pagination.defaults.afterPageText = 'จาก {pages}';
	$.fn.pagination.defaults.displayMsg = 'แสดง {from} ถึง {to} จาก {total} แถว';
}
if ($.fn.datagrid){
	$.fn.datagrid.defaults.loadMsg = 'กำลังร้องขอข้อมูล...';
}
if ($.fn.treegrid && $.fn.datagrid){
	$.fn.treegrid.defaults.loadMsg = $.fn.datagrid.defaults.loadMsg;
}
if ($.messager){
	$.messager.defaults.ok = 'ตกลง';
	$.messager.defaults.cancel = 'ยกเลิก';
}
if ($.fn.validatebox){
	$.fn.validatebox.defaults.missingMessage = 'ข้อมูลนี้จำเป็น';
	$.fn.validatebox.defaults.rules.email.message = 'อีเมลล์นี้ไม่ถูกต้อง';
	$.fn.validatebox.defaults.rules.url.message = 'URL ไม่ถูกต้อง';
	$.fn.validatebox.defaults.rules.length.message = 'Please enter a value between {0} and {1}.';
	$.fn.validatebox.defaults.rules.remote.message = 'Please fix this field.';
}
if ($.fn.numberbox){
	$.fn.numberbox.defaults.missingMessage = 'ข้อมูลนี้จำเป็น';
}
if ($.fn.combobox){
	$.fn.combobox.defaults.missingMessage = 'ข้อมูลนี้จำเป็น';
}
if ($.fn.combotree){
	$.fn.combotree.defaults.missingMessage = 'ข้อมูลนี้จำเป็น';
}
if ($.fn.combogrid){
	$.fn.combogrid.defaults.missingMessage = 'ข้อมูลนี้จำเป็น';
}
if ($.fn.calendar){
	$.fn.calendar.defaults.weeks = ['อา', 'จ', 'อ', 'พ', 'พฤ', 'ศ', 'ส'];
	$.fn.calendar.defaults.months = ['มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฏาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'];
}
if ($.fn.datebox){
	$.fn.datebox.defaults.currentText = 'วันนี้';
	$.fn.datebox.defaults.closeText = 'ปิด';
	$.fn.datebox.defaults.okText = 'ตกลง';
	$.fn.datebox.defaults.missingMessage = 'ข้อมูลนี้จำเป็น';
}
if ($.fn.datetimebox && $.fn.datebox){
	$.extend($.fn.datetimebox.defaults,{
		currentText: $.fn.datebox.defaults.currentText,
		closeText: $.fn.datebox.defaults.closeText,
		okText: $.fn.datebox.defaults.okText,
		missingMessage: $.fn.datebox.defaults.missingMessage
	});
}
