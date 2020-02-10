       $query = new Query();
            $query->select('u.first_name,u.last_name,u.user_image,u.event_radious_range,a.activity_name,ue.event_start_date,ue.activity_id,ue.user_id,ue.event_end_date,ue.event_startpoint_longitude,ue.event_startpoint_latitude,ue.event_location,ue.event_duration,ue.id AS event_id,ue.updated_at')
                ->from('user_events as ue')
                ->join('LEFT JOIN', 'users as u', 'u.id =ue.user_id')
                ->join('LEFT JOIN', 'activities as a', 'a.`id` = `ue`.`activity_id`')
                ->where("`ue`.`event_status` != '" . Yii::$app->params['event_status']['completed'] . "' AND `ue`.`event_start_date` >= CURDATE() AND `ue`.`event_start_date` <= CURDATE() +  INTERVAL 7 DAY AND (6371 * acos( cos(radians({$user_latitude}) ) * cos(radians( `ue`.`event_startpoint_latitude`))*cos( radians( `ue`.`event_startpoint_longitude` ) - radians({$user_longitude}) ) + sin( radians({$user_latitude}) ) * sin( radians( `ue`.`event_startpoint_latitude`)))) < {$radius}  ");

            //->select( 'u.first_name,u.last_name,u.joining_date,projects.name as project_name,projects.handled_by as team_lead_id,department.name as department_name,up.user_id,up.start_date,up.end_date,up.allocated_hours,up.avg_hours,((up.avg_hours * 100) / 8) AS resource_utilization,((select sum(avg_hours) as total from user_projects where user_id= up.user_id) * 100 )/8 as total_utilization' );
            $command = $query->orderBy('ue.event_start_date ASC')->createCommand();
            $arrEventDetails = $command->queryAll();
