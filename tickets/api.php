<?php
require_once('../files/functions.php');

$lang = (isset($_GET['lang']) && !empty($_GET['lang'])) ? substr($_GET['lang'], 0 ,3) : 'ru';

$user->IsLogged();
if (empty($_REQUEST['action'])) die();

$_mode2status = ['new' => 1, 'active' => 2, 'closed' => 3];
$_status_title = [
    '1' => Language('_status_new', 'support.php'),
    '2' => Language('_status_in_progress', 'support.php'),
    '3' => Language('_status_closed', 'support.php')
];
$_projects = [
			(object)['id' => 1, 'title' => Language('_technical', 'support.php', $lang), 'sort' => 1],
			(object)['id' => 2, 'title' => Language('_payments', 'support.php', $lang), 'sort' => 2],
			(object)['id' => 3, 'title' => Language('_guarantee', 'support.php', $lang), 'sort' => 3],
			(object)['id' => 4, 'title' => Language('_social', 'support.php', $lang), 'sort' => 4],
			(object)['id' => 5, 'title' => Language('_partnership', 'support.php', $lang), 'sort' => 5],
			(object)['id' => 6, 'title' => Language('_franchise', 'support.php', $lang), 'sort' => 6],
		];
$_users_names = [];

function getUserName($user_id) {
	global $_users_names, $pdo;
	if (isset($_users_names[$user_id])) return $_users_names[$user_id];

	$stmt = $pdo->prepare('SELECT UserName FROM users WHERE UserID = :UserID LIMIT 1');
	$stmt->execute(array(':UserID' => $user_id));

	if ($stmt->rowCount() == 1) {
		$user = $stmt->fetch();
		$_users_names[$user_id] = $user['UserName'];
		return $user['UserName'];
	}

	return '';
}

switch ($_REQUEST['action']) {
	case 'getTickets':
		$mode = (!empty($_REQUEST['mode']) && isset($_mode2status[$_REQUEST['mode']])) ? $_REQUEST['mode'] : 'all';
		$page = (!empty($_REQUEST['page']) && isset($_REQUEST['page'])) ? (int) $_REQUEST['page'] * 20 : 20;

		$stmtt = $pdo->prepare('SELECT COUNT(id) FROM tickets WHERE author_id = :author_id');
		$stmtt->execute([':author_id' => $_SESSION['auth']]);
		$total = $stmtt->fetch(PDO::FETCH_COLUMN);
		$amt = ceil($total / 20);
		$totalMinus = $amt - ($page / 20);

		if ($mode == 'all') {
			$stmt = $pdo->prepare('SELECT * FROM `tickets` WHERE `author_id` = :author_id ORDER BY `id` DESC LIMIT '.$page.' ');
			$stmt->execute([':author_id' => $_SESSION['auth']]);
		} else {
			$stmtt = $pdo->prepare('SELECT COUNT(id) FROM tickets WHERE author_id = :author_id AND status_id = :status_id');
			$stmtt->execute([':author_id' => $_SESSION['auth'], ':status_id' => $_mode2status[$mode]]);
			$total = $stmtt->fetch(PDO::FETCH_COLUMN);
			$amt = ceil($total / 20);
			$totalMinus = $amt - ($page / 20);

			$stmt = $pdo->prepare('SELECT * FROM tickets WHERE author_id = :author_id AND status_id = :status_id ORDER BY id DESC LIMIT '.$page.'');
			$stmt->execute([':author_id' => $_SESSION['auth'], ':status_id' => $_mode2status[$mode]]);
		}

		if ($stmt->rowCount() > 0) {
			$tickets = $stmt->fetchAll();
			$result = [];
			foreach ($tickets as $ticket) {
				$stmt = $pdo->prepare('SELECT COUNT(id) FROM tickets_comments WHERE ticket_id = :ticket_id LIMIT 1');
					$stmt->execute([':ticket_id' => $ticket['id']]);
					$count_comments = $stmt->fetch(PDO::FETCH_COLUMN);

				$result[] = (object)[
					'id' => $ticket['id'],
					'author_id' => $ticket['author_id'],
					'title' => $ticket['title'],
					'body' => $ticket['body'],
					'project_id' => $ticket['project_id'],
					'comments_count' => $count_comments,
					'last_msg_view_author' => (bool)$ticket['last_msg_view_author'],
					'date_created_dmy' => date("d.m.Y H:i", strtotime($ticket['date_created_dmy'])),
					'date_updated_dmy' => date("d.m.Y H:i", strtotime($ticket['date_updated_dmy'])),
					'project_title' => $_projects[$ticket['project_id'] - 1]->title,
					'project_title_en' => $_projects[$ticket['project_id'] - 1]->title_en,
					'status_title' => $_status_title[$ticket['status_id']],
					'order_id' => $ticket["order_id"],
				];
			}

			echo json_encode(['status' => true, 'data' => $result, 'total_minus' => $totalMinus]);
			die();
		}
		echo json_encode(['status' => false, 'data' => 'empty data', 'total_minus' => $totalMinus]);
		break;
	case 'getProjects':
		echo json_encode(['status' => true, 'data' => $_projects, 'total_minus' => $totalMinus]);
		break;
	case 'createTicket':
		$project_id = (!empty($_POST['project_id'])) ? (int)$_POST['project_id'] : 0;
		$title = (!empty($_POST['title'])) ? $_POST['title'] : '';
		$body = (!empty($_POST['body'])) ? $_POST['body'] : '';

		if ($project_id > 0 && $project_id <= 6 && !empty($title) && !empty($body)) {
			$author_id = $_SESSION["auth"];
			if(isset($_POST["order_id"])) {
				$order_id = $_POST["order_id"];
				$stmt = $pdo->prepare('INSERT INTO tickets (project_id, title, body, author_id, order_id) VALUES (:project_id, :title, :body, :author_id, :order_id)');
				if ($stmt->execute([':project_id' => $project_id, ':title' => $title, ':order_id'=>$order_id, ':body' => $body, ':author_id' => $_SESSION['auth']])) {
					$ticket_id = $pdo->lastInsertId();
					echo json_encode(['status' => true, 'data' => $ticket_id]);
					die();
				}
			} else {
				$stmt = $pdo->prepare('INSERT INTO tickets (project_id, title, body, author_id) VALUES (:project_id, :title, :body, :author_id)');
				if ($stmt->execute([':project_id' => $project_id, ':title' => $title, ':body' => $body, ':author_id' => $_SESSION['auth']])) {
					$ticket_id = $pdo->lastInsertId();
					echo json_encode(['status' => true, 'data' => $ticket_id]);
					die();
				}
			}
		}
		echo json_encode(['status' => false, 'data' => 'empty data']);
		break;
	case 'createFranschise':
		$project_id = 6;
		$title = 'Заявка на франшизу';
		$body = 'Заявка на франшизу';
		if (!empty($title) && !empty($body)) {
			$stmt = $pdo->prepare('INSERT INTO tickets (project_id, title, body, author_id, last_msg_view_author) VALUES (:project_id, :title, :body, :author_id, :last_msg_view_author)');
			if ($stmt->execute([':project_id' => $project_id, ':title' => $title, ':body' => $body, ':author_id' => $_SESSION['auth'], ':last_msg_view_author' => 0])) {
				$ticket_id = $pdo->lastInsertId();
				$body = 'Добрый день!<br>Вы оставляли заявку на франшизу<br>Еще актуально?';
				$stmt = $pdo->prepare('INSERT INTO tickets_comments (ticket_id, body, author_id) VALUES (:ticket_id, :body, :author_id)');
				$stmt->execute([':ticket_id' => $ticket_id, ':body' => $body, ':author_id' => 1]);
				echo json_encode(['status' => true, 'data' => $ticket_id]);
				die();
			}
		}
		echo json_encode(['status' => false, 'data' => 'empty data']);
		break;
	case 'uploadFile':
// Constants
define('MAX_FILE_SIZE', 10485760);
define('IMAGE_API_URL', 'https://api.imageban.ru/v1');
define('API_TOKEN', 'TOKEN zlUz2dWf44OosQMyNVl6');

// Function to make cURL requests
function makeCurlRequest($url, $data) {
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, ['Authorization: ' . API_TOKEN]);
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    return curl_exec($curl);
}

// Function to handle file upload
function handleFileUpload($file, $ticketId, $commentId, $filename, $pdo) {
    if (
        !empty($file) &&
        isset($file['error']) &&
        $file['error'] == 0 &&
        $file['size'] <= MAX_FILE_SIZE &&
        preg_match('#^image/.+$#i', $file['type'])
    ) {
        $curlData = [
            'name' => $filename,
            'secret_key' => 'bz7Hg57hMZxqmppIxUYJXtlPpjrW5XyMyny',
            'image' => base64_encode(file_get_contents($file['tmp_name']))
        ];

        $result = makeCurlRequest(IMAGE_API_URL, $curlData);
        $result = json_decode($result, true);

        if (
            isset($result['success']) &&
            $result['success'] &&
            isset($result['data']['link']) &&
            isset($result['data']['short_link'])
        ) {
            $stmt = $pdo->prepare('INSERT INTO tickets_files (ticket_id, comment_id, short_link, link) VALUES (:ticket_id, :comment_id, :short_link, :link)');

            if ($stmt->execute([
                ':ticket_id' => $ticketId,
                ':comment_id' => $commentId,
                ':short_link' => $result['data']['short_link'],
                ':link' => $result['data']['link']
            ])) {
                return $result['data']['short_link'];
            }
        }
    }

    return null;
}

// Main code
$ticketId = (!empty($_POST['ticket_id'])) ? (int)$_POST['ticket_id'] : 0;
$commentId = (!empty($_POST['comment_id'])) ? (int)$_POST['comment_id'] : 0;
$filename = (!empty($_POST['filename'])) ? $_POST['filename'] : '';

if ($ticketId > 0 && !empty($filename)) {
    $stmt = $pdo->prepare('SELECT author_id FROM tickets WHERE id = :ticket_id LIMIT 1');
    $stmt->execute([':ticket_id' => $ticketId]);

    $authorId = ($stmt->rowCount() == 1) ? $stmt->fetchColumn() : 0;

    if ($authorId == $_SESSION['auth']) {
        $fileShortLink = handleFileUpload($_FILES['file'], $ticketId, $commentId, $filename, $pdo);

        if ($fileShortLink) {
            echo json_encode(['status' => false, 'data' => $fileShortLink]);
            die();
        }
    }
}

echo json_encode(['status' => false, 'data' => 'empty data']);
case 'getTicket':
    $ticket_id = (!empty($_REQUEST['id'])) ? (int)$_REQUEST['id'] : 0;
    $stmt = $pdo->prepare('SELECT t.*, f.id AS file_id, f.short_link, f.link 
                           FROM tickets t
                           LEFT JOIN tickets_files f ON t.id = f.ticket_id AND f.comment_id = 0
                           WHERE t.id = :ticket_id AND t.author_id = :author_id
                           LIMIT 1');
    $stmt->execute([':ticket_id' => $ticket_id, ':author_id' => $_SESSION['auth']]);

    if ($stmt->rowCount() == 1) {
        $ticket = $stmt->fetch();

        $files = ($ticket['file_id']) ? [(object)['id' => $ticket['file_id'], 'short_link' => $ticket['short_link'], 'link' => $ticket['link']]] : null;

        $result = (object)[
            'id' => $ticket_id,
            'title' => $ticket['title'],
            'body' => $ticket['body'],
            'status_id' => $ticket['status_id'],
            'project_id' => $ticket['project_id'],
            'author_id' => $ticket['author_id'],
            'last_msg_view_author' => (bool)$ticket['last_msg_view_author'],
            'date_created_dmy' => date("d.m.Y H:i", strtotime($ticket['date_created_dmy'])),
            'date_updated_dmy' => date("d.m.Y H:i", strtotime($ticket['date_updated_dmy'])),
            'project_title' => $_projects[$ticket['project_id'] - 1]->title,
            'project_title_en' => $_projects[$ticket['project_id'] - 1]->title_en,
            'status_title' => $_status_title[$ticket['status_id']],
            'files' => $files,
            'order_id' => $ticket["order_id"],
        ];

        echo json_encode(['status' => true, 'data' => $result]);

        $stmt = $pdo->prepare('UPDATE tickets SET last_msg_view_author = :last_msg_view_author WHERE id = :ticket_id LIMIT 1');
        $stmt->execute([':last_msg_view_author' => '1', ':ticket_id' => $ticket_id]);

        die();
    }

    echo json_encode(['status' => false, 'data' => 'empty data']);
    break;
case 'getComments':
    $ticket_id = (!empty($_REQUEST['id'])) ? (int)$_REQUEST['id'] : 0;
    $stmt = $pdo->prepare('SELECT * FROM tickets t 
                           WHERE t.id = :ticket_id AND t.author_id = :author_id LIMIT 1');
    $stmt->execute([':ticket_id' => $ticket_id, ':author_id' => $_SESSION['auth']]);

    if ($stmt->rowCount() == 1) {
        $stmt = $pdo->prepare('SELECT c.*, f.id AS file_id, f.short_link, f.link 
                               FROM tickets_comments c
                               LEFT JOIN tickets_files f ON c.id = f.comment_id
                               WHERE c.ticket_id = :ticket_id 
                               ORDER BY c.id DESC');
        $stmt->execute([':ticket_id' => $ticket_id]);

        if ($stmt->rowCount() > 0) {
            $comments = $stmt->fetchAll();
            $result = [];

            foreach ($comments as $comment) {
                $files = ($comment['file_id']) ? [(object)['id' => $comment['file_id'], 'short_link' => $comment['short_link'], 'link' => $comment['link']]] : null;

                $result[] = (object)[
                    'id' => $comment['id'],
                    'body' => $comment['body'],
                    'date_created_dmy' => date("d.m.Y H:i", strtotime($comment['date_created_dmy'])),
                    'files' => $files,
                    'my' => ($comment['author_id'] == $_SESSION['auth']),
                    'author_name' => ($comment['author_id'] == $_SESSION['auth']) ? 'Вы' : 'Администратор',
                ];
            }

            echo json_encode(['status' => true, 'data' => $result]);

            $stmt = $pdo->prepare('UPDATE tickets SET last_msg_view_author = :last_msg_view_author WHERE id = :ticket_id LIMIT 1');
            $stmt->execute([':last_msg_view_author' => '1', ':ticket_id' => $ticket_id]);

            die();
        }
    }

    echo json_encode(['status' => false, 'data' => 'empty data']);
    break;
	case 'addComment':
		$ticket_id = (!empty($_REQUEST['id'])) ? (int)$_REQUEST['id'] : 0;
		$body = (!empty($_POST['body'])) ? $_POST['body'] : '';
		if ($ticket_id > 0 && !empty($body)) {
			$stmt = $pdo->prepare('SELECT * FROM tickets WHERE id = :ticket_id AND author_id = :author_id LIMIT 1');
			$stmt->execute(array(':ticket_id' => $ticket_id, ':author_id' => $_SESSION['auth']));
			if ($stmt->rowCount() == 1) {
				$ticket = $stmt->fetch();
				if ($ticket['status_id'] < 3) {
					$stmt = $pdo->prepare('INSERT INTO tickets_comments (ticket_id, body, author_id) VALUES (:ticket_id, :body, :author_id)');

				if ($stmt->execute([':ticket_id' => $ticket_id, ':body' => $body, ':author_id' => $_SESSION['auth']])) {
						$comment_id = $pdo->lastInsertId();

						$stmt = $pdo->prepare('UPDATE tickets SET last_msg_view_admin = :last_msg_view_admin WHERE id = :ticket_id LIMIT 1');
						$stmt->execute([':last_msg_view_admin' => '0', ':ticket_id' => $ticket_id]);

						echo json_encode(['status' => true, 'data' => $comment_id]);
						die();
					}
				}
			}
		}
		echo json_encode(['status' => false, 'data' => 'empty data']);
		break;
	default: die();
}