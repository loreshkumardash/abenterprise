<?php 
$total_hours = 0;
                      $total_minutes = 0;
                       if($records){for($i=0;$i<count($records);$i++){
                       
                        $start_time = $records[$i]['st_time'];
                        $end_time = $records[$i]['end_time'];

                        $login_timestamp = strtotime($start_time);
                        $logout_timestamp = strtotime($end_time);
                        $time_difference = $logout_timestamp - $login_timestamp;
 
                        $hours = floor($time_difference / 3600);
                        $time_difference %= 3600;
                        $minutes = floor($time_difference / 60);
                        $seconds = $time_difference % 60;
                        $total_hours += $hours;
                        $total_minutes += $minutes;
                        $time_difference_formatted = sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
                        $time_difference_12hour = date('H.i.s', strtotime($time_difference_formatted));


                        ?>
                      <tr>
                        
                        <td><?=$records[$i]['entry_date'] ;?></td>
                        <td><?=$records[$i]['firstname'];?> <?=$records[$i]['lastname'];?></td>
                        <td><?=$records[$i]['daily_work'] ;?></td>
                        <td><?= date('h.i.s', strtotime($records[$i]['st_time']));?></td>
                        <td><?= date('h.i.s', strtotime($records[$i]['end_time']));?></td>
                        <td><?=$time_difference_12hour ;?></td>
                      </tr>
                      <?php }}
                      $total_hours += floor($total_minutes / 60);
                      $total_minutes %= 60;

                      $hours = $total_hours;
                      $minutes = $total_minutes;
                      list($days, $remainingHours, $remainingMinutes) = hoursAndMinutesToDays($hours, $minutes);
                      ?>
                      <tr>
                        <td colspan="5" align="center"><b>Total Working Hours</b></td>
                        <td><b><?php echo "Hours is approximately " . $days . " days, " . $remainingHours . " hours, and " . $remainingMinutes . " minutes.";?></b></td>
                      </tr>