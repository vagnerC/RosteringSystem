<?php
function draw_calendar($month,$year,$type){
    include("resource/database.php");
    
    if(isset($_GET['m']) AND isset($_GET['y'])):
        $month  = $_GET['m'];
        $year   = $_GET['y'];
    endif;
    
    if($type == "specific"):
        $where = " AND staff_idStaff = '".$_SESSION['user_info']['id']."'";
    else:
        $where = "";
    endif;
    
    
    /* draw table */
	$calendar = '<table cellpadding="0" cellspacing="0" class="calendar">';
	
	/* table headings */
	
	$last_month    = date('m', strtotime("$year-$month-01".'last month'));
	$last_year     = date('Y', strtotime("$year-$month-01".'last month'));
	$next_month    = date('m', strtotime("$year-$month-01".'next month'));
	$next_year     = date('Y', strtotime("$year-$month-01".'next month'));
	
	$calendar .= '<tr class="calendar-row">';
	   $calendar .= '<td class="calendar-day-head"><a href="?m='.$last_month.'&y='.$last_year.'">'.date('F', strtotime("$year-$month-01".'last month')).'</a></td>';
	   $calendar .= '<td colspan="5" class="calendar-day-head">'.date("F", mktime(0, 0, 0, $month, 10))."/".$year.'</td>';
	   $calendar .= '<td class="calendar-day-head"><a href="?m='.$next_month.'&y='.$next_year.'">'.date('F', strtotime("$year-$month-01".'next month')).'</a></td>';
	$calendar .= '</tr>';
	
	$headings = array('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday');
	$calendar.= '<tr class="calendar-row"><td class="calendar-day-head">'.implode('</td><td class="calendar-day-head">',$headings).'</td></tr>';
	
	/* days and weeks vars now ... */
	$running_day = date('w',mktime(0,0,0,$month,1,$year));
	$days_in_month = date('t',mktime(0,0,0,$month,1,$year));
	$days_in_this_week = 1;
	$day_counter = 0;
	$dates_array = array();
	
	/* row for week one */
	$calendar.= '<tr class="calendar-row">';
	
	/* print "blank" days until the first of the current week */
	for($x = 0; $x < $running_day; $x++):
	$calendar.= '<td class="calendar-day-np"> </td>';
	$days_in_this_week++;
	endfor;
	
	/* keep going with days.... */
	for($list_day = 1; $list_day <= $days_in_month; $list_day++):
	
	$list_day = str_pad($list_day, 2, "0", STR_PAD_LEFT);
	
	$calendar.= '<td class="calendar-day" valign="top">';
	/* add in the day number */
	$calendar.= '<div class="day-number">'.$list_day.'</div>';
	
	/** QUERY THE DATABASE FOR AN ENTRY FOR THIS DAY !!  IF MATCHES FOUND, PRINT THEM !! **/
	try{
	    $sql = "SELECT
                typeRequest,
                name
                FROM request 
                INNER JOIN staff ON staff_idStaff = idStaff
                WHERE status = 'Approved'
                $where
                AND '$year-$month-$list_day' BETWEEN startDate AND finishDate";
	    
	    $sth = $DBH->prepare($sql);
	    
	    $sth->execute();
	    
	    if($sth->rowCount() > 0){
	        while ($row = $sth->fetch(PDO::FETCH_OBJ)){
	            if($row->typeRequest == "Day Off"){
	               $calendar.= '<div style= \'background-color: #FFEFD5\'>'.$row->name.' ('.$row->typeRequest.')</div>';
	            } elseif($row->typeRequest == "Holidays"){
	                $calendar.= '<div style= \'background-color: #FFC0CB\'>'.$row->name.' ('.$row->typeRequest.')</div>';
	            } else {
	                $calendar.= '<div style= \'background-color: #8FBC8F\'>'.$row->name.' ('.$row->typeRequest.')</div>';
	            }
	        }
	    }
	} catch(PDOException $e) {echo $e;}
	
	
	
	
	try{
	    $sql = "SELECT
                idStaff,
                name,
                DATE_FORMAT(startingTime, '%H:%i') AS startingTime,
                DATE_FORMAT(finishingTime, '%H:%i') AS finishingTime
                FROM roster
                INNER JOIN staff ON staff_idStaff = idStaff
                INNER JOIN businessHours ON businessHours_idBusinessHours = idbusinessHours
                WHERE openingTime LIKE '$year-$month-$list_day%'
                $where";
	    
	    $sth = $DBH->prepare($sql);
	    
	    $sth->execute();
	    
	    if($sth->rowCount() > 0){
	        while ($row = $sth->fetch(PDO::FETCH_OBJ)){
	            if($row->idStaff == $_SESSION['user_info']['id']):
	               $calendar.= '<div style= \'background-color: #8FBC8F\'>'.$row->name.' ('.$row->startingTime." - ".$row->finishingTime.')</div>';
	            else:
	               $calendar.= '<div style= \'background-color: #b4eeb4\'>'.$row->name.' ('.$row->startingTime." - ".$row->finishingTime.')</div>';
	            endif;
	        }
	    }
	} catch(PDOException $e) {echo $e;}
	
	
	
	
	$calendar.= '</td>';
	if($running_day == 6):
	$calendar.= '</tr>';
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