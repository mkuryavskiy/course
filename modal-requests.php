<?php
require_once('files/functions.php');

function GetAction($action) {
	if(isset($_POST['action']) && $_POST['action'] == $action) {
		return true;
	} else {
		return false;
	}
}

if(!isset($_SESSION['auth']) || $_SESSION['auth'] == '') {
        	if(GetAction('add-otzyvPage')) {
				$comments_name = $layer->safe('comments-name');
				$comments_title = $layer->safe('comments-title');
				$comments_answer = $layer->safe('comments-answer');
				$comments_answer = $_POST['comments-answer'];
				$trimmed = trim($comments_answer, " \t\n\r\0\x0B");

				if (mb_strlen($comments_title, 'utf-8') < 30) {
				    echo 0;
        		}
        		else {
                $datess = date('d.m.Y H:i');

                $stmt = $pdo->prepare('INSERT INTO comments_not_added (comments_name, comments_title, comments_answer, comments_date) VALUES (:comments_name, :comments_title, :comments_answer, :comments_date)');
                $stmt->execute(array(':comments_name' => $comments_name, ':comments_title' => $comments_title, ':comments_answer' => $trimmed, ':comments_date' => $datess));
                echo 200;
			}
	}
}

else {

    if(GetAction('add-otzyvPage')) {
			$comments_name = $UserName;
			$comments_title = $layer->safe('comments-title');
			$comments_answer = $layer->safe('comments-answer');
			$comments_answer = $_POST['comments-answer'];
			$trimmed = trim($comments_answer, " \t\n\r\0\x0B");
 
			if (mb_strlen($comments_title, 'utf-8') < 30) { 
				echo 0;
        	}
        	
        	else {
        		$datess = date('d.m.Y H:i');
                $stmt = $pdo->prepare('INSERT INTO comments_not_added (comments_name, comments_title, comments_answer, comments_date) VALUES (:comments_name, :comments_title, :comments_answer, :comments_date)');
                $stmt->execute(array(':comments_name' => $UserName, ':comments_title' => $comments_title, ':comments_answer' => $trimmed, ':comments_date' => $datess));
                echo 200;
        	}
	}

}
