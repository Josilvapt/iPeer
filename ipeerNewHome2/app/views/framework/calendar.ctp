<!--
Title: Tigra Calendar
URL: http://www.softcomplex.com/products/tigra_calendar/
Version: 3.2
Date: 10/14/2002 (mm/dd/yyyy)
Feedback: feedback@softcomplex.com (specify product title in the subject)
Note: Permission given to use this script in ANY kind of applications if
   header lines are left unchanged.
Note: Script consists of two files: calendar?.js and calendar.html
About us: Our company provides offshore IT consulting services.
    Contact us at sales@softcomplex.com if you have any programming task you
    want to be handled by professionals. Our typical hourly rate is $20.
-->
<html>
<head>
<title>iPeer Date Picker</title>
<style type="text/css">
	td {font-family: Tahoma, Verdana, sans-serif; font-size: 12px;}
</style>
<script language="javascript" type="text/javascript">

// months as they appear in the calendar's title
var ARR_MONTHS = ["January", "February", "March", "April", "May", "June",
		"July", "August", "September", "October", "November", "December"];
// week day titles as they appear on the calendar
var ARR_WEEKDAYS = ["Su", "Mo", "Tu", "We", "Th", "Fr", "Sa"];
// day week starts from (normally 0-Su or 1-Mo)
var NUM_WEEKSTART = 1;
// path to the directory where calendar images are stored. trailing slash req.
var STR_ICONPATH = 'images/calendar/';

var re_url = new RegExp('datetime=(\\-?\\d+)');
var dt_current = (re_url.exec(String(window.location))
	? new Date(new Number(RegExp.$1)) : new Date());

var re_id = new RegExp('id=(\\d+)');
var num_id = (re_id.exec(String(window.location))
	? new Number(RegExp.$1) : 0);

var obj_caller = (window.opener ? window.opener.calendars[num_id] : null);

if (obj_caller && obj_caller.year_scroll) {
	// get same date in the previous year
	var dt_prev_year = new Date(dt_current);
	dt_prev_year.setFullYear(dt_prev_year.getFullYear() - 1);
	if (dt_prev_year.getDate() != dt_current.getDate())
		dt_prev_year.setDate(0);

	// get same date in the next year
	var dt_next_year = new Date(dt_current);
	dt_next_year.setFullYear(dt_next_year.getFullYear() + 1);
	if (dt_next_year.getDate() != dt_current.getDate())
		dt_next_year.setDate(0);
}

// get same date in the previous month
var dt_prev_month = new Date(dt_current);
dt_prev_month.setMonth(dt_prev_month.getMonth() - 1);
if (dt_prev_month.getDate() != dt_current.getDate())
	dt_prev_month.setDate(0);

// get same date in the next month
var dt_next_month = new Date(dt_current);
dt_next_month.setMonth(dt_next_month.getMonth() + 1);
if (dt_next_month.getDate() != dt_current.getDate())
	dt_next_month.setDate(0);

// get first day to display in the grid for current month
var dt_firstday = new Date(dt_current);
dt_firstday.setDate(1);
dt_firstday.setDate(1 - (7 + dt_firstday.getDay() - NUM_WEEKSTART) % 7);

// function passing selected date to calling window
function set_datetime(n_datetime, b_close) {
	if (!obj_caller) return;

	var dt_datetime = obj_caller.prs_time(
		(document.cal ? document.cal.time.value : ''),
		new Date(n_datetime)
	);

	if (!dt_datetime) return;
	if (b_close) {
		window.close();
		obj_caller.target.value = (document.cal
			? obj_caller.gen_tsmp(dt_datetime)
			: obj_caller.gen_date(dt_datetime)
		);
	}
	else obj_caller.popup(dt_datetime.valueOf(), null);
}

</script>
</head>
<body bgcolor="#FFFFFF">
<table class="clsOTable" cellspacing="0" border="1" width="100%">
<tr><td bgcolor="#999999">
<table cellspacing="1" cellpadding="3" border="0" width="100%">
<tr><td colspan="7"><table cellspacing="0" cellpadding="0" border="0" width="100%">
<tr><td>
<script language="javascript" type="text/javascript">
document.write(
'<td>'+(obj_caller&&obj_caller.year_scroll?'<a href="javascript:set_datetime('+dt_prev_year.valueOf()+')"><?php echo $html->image('calendar/prev_year.gif',array('align'=>'middle', 'border'=>'0', 'width'=>'16', 'height'=>'16', 'alt'=>'previous year'))?><\/a>&nbsp;':'')+'<a href="javascript:set_datetime('+dt_prev_month.valueOf()+')"><?php echo $html->image('calendar/prev.gif',array('align'=>'middle', 'border'=>'0', 'width'=>'16', 'height'=>'16', 'alt'=>'previous month'))?><\/a><\/td>'+
'<td align="center" width="100%"><b><font color="white">'+ARR_MONTHS[dt_current.getMonth()]+' '+dt_current.getFullYear() + '<\/font><\/b><\/td>'+
'<td><a href="javascript:set_datetime('+dt_next_month.valueOf()+')"><?php echo $html->image('calendar/next.gif',array('align'=>'middle', 'border'=>'0', 'width'=>'16', 'height'=>'16', 'alt'=>'next month'))?><\/a>'+(obj_caller && obj_caller.year_scroll?'&nbsp;<a href="javascript:set_datetime('+dt_next_year.valueOf()+')"><?php echo $html->image('calendar/next_year.gif',array('align'=>'middle', 'border'=>'0', 'width'=>'16', 'height'=>'16', 'alt'=>'next year'))?><\/a>':'')+'<\/td>'
);
</script>
</td></tr>
</table></td></tr><tr>
<script language="javascript" type="text/javascript">

// print weekdays titles
for (var n=0; n<7; n++)
	document.write('<td bgcolor="#24588C" align="center"><font color="#ffffff">'+ARR_WEEKDAYS[(NUM_WEEKSTART+n)%7]+'<\/font><\/td>');
document.write('<\/tr>');

// print calendar table
var dt_current_day = new Date(dt_firstday);
while (dt_current_day.getMonth() == dt_current.getMonth() ||
	dt_current_day.getMonth() == dt_firstday.getMonth()) {
	// print row heder
	document.write('<tr>');
	for (var n_current_wday=0; n_current_wday<7; n_current_wday++) {
		if (dt_current_day.getDate() == dt_current.getDate() &&
			dt_current_day.getMonth() == dt_current.getMonth())
			// print current date
			document.write('<td bgcolor="#C7D0E7" align="center" width="14%">');
		else if (dt_current_day.getDay() == 0 || dt_current_day.getDay() == 6)
			// weekend days
			document.write('<td bgcolor="#E5E5E5" align="center" width="14%">');
		else
			// print working days of current month
			document.write('<td bgcolor="#E5E5E5" align="center" width="14%">');

		document.write('<a href="javascript:set_datetime('+dt_current_day.valueOf() +', true);">');

		if (dt_current_day.getMonth() == this.dt_current.getMonth())
			// print days of current month
			document.write('<font color="#000000">');
		else
			// print days of other months
			document.write('<font color="#606060">');

		document.write(dt_current_day.getDate()+'<\/font><\/a><\/td>');
		dt_current_day.setDate(dt_current_day.getDate()+1);
	}
	// print row footer
	document.write('<\/tr>');
}
if (obj_caller && obj_caller.time_comp)
	document.write('<form onsubmit="javascript:set_datetime('+dt_current.valueOf()+', true)" name="cal"><tr><td colspan="7" bgcolor="#FA7E04"><font color="White" face="tahoma, verdana" size="2">Time: <input type="text" name="time" value="'+obj_caller.gen_time(this.dt_current)+'" size="8" maxlength="8"><\/font><\/td><\/tr><\/form>');
</script>
</table></tr>
</table>
</body>
</html>
