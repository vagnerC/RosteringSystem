<?php
function draw_calendar($month,$year){

	/* draw table */
	$calendar = '<table cellpadding="0" cellspacing="0" class="calendar">';
	
	/* table headings */
	
	$calendar .= '<tr class="calendar-row">';
	$calendar .= '<td colspan="9" class="calendar-day-head">'.date("F", mktime(0, 0, 0, $month, 10))."/".$year.'</td>';
	$calendar .= '</tr>';
	
	$headings = array('Week','Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Payment');
	$calendar.= '<tr class="calendar-row"><td class="calendar-day-head">'.implode('</td><td class="calendar-day-head">',$headings).'</td></tr>';
	
	/* days and weeks vars now ... */
	$running_day = date('w',mktime(0,0,0,$month,1,$year));
	$days_in_month = date('t',mktime(0,0,0,$month,1,$year));
	$days_in_this_week = 1;
	$day_counter = 0;
	$dates_array = array();
	$first_column = 0;
	$last_column = 8;
	
	
	/* row for week one */
	$calendar.= '<tr class="calendar-row">';
	
	if($first_column == 0):
	$calendar.= '<td class="calendar-day">';
	$calendar.= '+++';
	$calendar.= '</td>';
	$first_column++;
	endif;
	
	
	/* print "blank" days until the first of the current week */
	for($x = 0; $x < $running_day; $x++):
	$calendar.= '<td class="calendar-day-np"> </td>';
	$days_in_this_week++;
	endfor;
	
	/* keep going with days.... */
	for($list_day = 1; $list_day <= $days_in_month; $list_day++):
	$calendar.= '<td class="calendar-day">';
	/* add in the day number */
	$calendar.= '<div class="day-number">'.$list_day.'</div>';
	
	/* QUERY THE DATABASE FOR AN ENTRY FOR THIS DAY !!  IF MATCHES FOUND, PRINT THEM !! */
	if($year == 2018 and $month == 03 AND $list_day == 3):
	$calendar.= '<p>John (09 - 18)</p>';
	elseif($year == 2018 and $month == 03 AND $list_day == 20):
	$calendar.= '<p>Mary (13 - 22)</p>';
	else:
	$calendar.= '<p>Mark (09 - 15)</p>';
	endif;
	
	$calendar.= '</td>';
	if($running_day == 6):
	   $calendar.= '</tr>';
	   $first_column = 0;
	if(($day_counter+1) != $days_in_month):
	$calendar.= '<tr class="calendar-row">';
	endif;
	$running_day = -1;
	$days_in_this_week = 0;
	endif;
	$days_in_this_week++; $running_day++; $day_counter++;
	endfor;
	
	/* finish the rest of the days in the week */
	if($days_in_this_week < 8):
	for($x = 1; $x <= (8 - $days_in_this_week); $x++):
	$calendar.= '<td class="calendar-day-np"> </td>';
	endfor;
	endif;
	
	/* final row */
	$calendar.= '</tr>';
	
	/* end the table */
	$calendar.= '</table>';
	
	/* all done, return result */
	return $calendar;
}
?>