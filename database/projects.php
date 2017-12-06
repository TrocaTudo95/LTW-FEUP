<?php
  include_once('database/projectUsers.php');

  function addTask($dbh,$projectref,$information,$priority,$datedue,$ischecked, $assignedTo){
    $stmt = $dbh->prepare('SELECT id FROM tasks WHERE projectRef = ? AND information = ?');
    $stmt->execute(array($projectref,$information));
    $result = $stmt->fetch();
    if ($result){
      echo('Task duplicated');
      return;
    }
    $stmt = $dbh->prepare('INSERT INTO tasks VALUES (?,?,?,?,?,?,?)');
    $stmt->execute(array(NULL,$projectref,$information,$priority,$datedue,$ischecked,$assignedTo));
  }

  function addTasks($dbh,$items,$project_id){
    foreach($items as $item){
      addTask($dbh,$project_id,$item['text'],$item['priority'],$item['datedue'],0);
    }
  }

  function addCategories($dbh,$title){
    $stmt = $dbh->prepare('SELECT id FROM categories WHERE title = ?');
    $stmt->execute(array($title,$userref));
    $result = $stmt->fetch();
    if ($result){
      // category already exists
      return $result['id'];
    }else{
      $stmt = $dbh->prepare('INSERT INTO categories VALUES (?,?)');
      $stmt->execute(array(NULL,$title));
      return $dbh->lastInsertId();

    }
  }
/**
 * Add a project list to the database and check if it already exists.
 */
  function addProject($dbh,$name, $color, $userref,$categoryref){
    $stmt = $dbh->prepare('SELECT id from projects WHERE Name = ? AND userRef = ? AND categoryRef = ?');
    $stmt->execute(array($name,$userref,$categoryref));
    $result = $stmt->fetch();
    if ($result){
      return $result['id'];
    }else{

      $stmt = $dbh->prepare('INSERT INTO projects VALUES (?,?,?,?,?)');
      $stmt->execute(array(NULL,$name,$color,$userref,$categoryref));
      $project_id = $dbh->lastInsertId();
      $stmt = $dbh->prepare('INSERT INTO projectUsers VALUES (?,?,?)');
      $stmt->execute(array($project_id,$userref,1));
      return $project_id;
    }
  }
  function getProjectsForCreatorId($dbh,$userid){
    $stmt = $dbh->prepare('SELECT * from projects WHERE creator = ?');
    $stmt->execute(array($userid));
    return $stmt->fetchAll();
  }

  function quick_sort_projects($array,$dbh){
      $length = count($array);
       if($length <= 1){
           return $array;
          }
           else{
               $pivot = $array[0];
               $taskPivot = getProjectTasks($dbh,$pivot['id'])[0];
               $left = $right = array();
               for($i = 1; $i < count($array); $i++)
               {
                 $taskProject = getProjectTasks($dbh,$array[$i]['id'])[0];
                    if($taskProject.dateDue < $taskPivot.dateDue){
                          $left[] = $array[$i];
                      }
                    else{
                        $right[] = $array[$i];
                        }
               }

               return array_merge(quick_sort_projects($left,$dbh), array($pivot), quick_sort_projects($right,$dbh));
               }
  }


  function getAllProjects($dbh){
      $stmt = $dbh->prepare('SELECT * from projects');
      $stmt->execute();
      quick_sort_projects($stmt,$dbh);
      return $stmt->fetchAll();

  }


  function quick_sort_tasks($array){
	    $length = count($array);
	     if($length <= 1){
		       return $array;
	        }
	         else{
		           $pivot = $array[0];
		           $left = $right = array();
		           for($i = 1; $i < count($array); $i++)
		           {
			              if($array[$i].dateDue < $pivot.dateDue){
				                  $left[] = $array[$i];
			                }
			              else{
				                $right[] = $array[$i];
			                  }
		           }

		           return array_merge(quick_sort_tasks($left), array($pivot), quick_sort_tasks($right));
	             }
  }

  function getProjectTasks($dbh,$project_id){
    $stmt = $dbh->prepare('SELECT * from tasks WHERE projectRef = ?');
    $stmt->execute(array($project_id));
    //quick_sort_tasks($stmt);
    return $stmt->fetchAll();
  }

  function getProjectCreator($dbh, $project_id){
    $stmt = $dbh->prepare('SELECT creator from projects WHERE id = ?');
    $stmt->execute(array($project_id));
    return $stmt->fetch()['creator'];

  }


  function getAllProjectsForUser($dbh, $user_id){
    $stmt = $dbh->prepare("SELECT projects.id,name,color,users.username as 'creator',categories.title as 'category' from projects INNER JOIN projectUsers ON projects.id = projectUsers.projectRef INNER JOIN categories ON categories.id = projects.categoryRef  INNER JOIN users on projects.creator= users.id WHERE projectUsers.userRef = ? ");
    $stmt->execute(array($user_id));
    return $stmt->fetchAll();
}

  /**
   * Returns 0 if project deleted with success, -1 if creator id is incorrect or project does not exist.
   */
  function deleteProject($dbh,$project_id,$creator_id){
    $stmt = $dbh->prepare('SELECT * FROM projects WHERE id = ? AND creator = ?');
    $stmt->execute(array($project_id,$creator_id));
    $result = $stmt->fetch();
    if ($result){
      removeAllProjectUsers($dbh,$project_id);
      $stmt = $dbh->prepare('DELETE FROM projects WHERE id = ?');
      $stmt->execute(array($project_id));
      return 0;
    }
    return -1;
  }

  function getCategoryTitle($dbh,$category_id){
    $stmt = $dbh->prepare('SELECT title from categories WHERE id = ?');
    $stmt->execute(array($category_id));
    $result = $stmt->fetch();
    if ($result){
      return $result['title'];
    }
    die(-1);
  }



?>
