<?php
require '../SMTP-Mailer/PHPMailer.php';
require '../SMTP-Mailer/SMTP.php';
require '../SMTP-Mailer/Exception.php';
require_once('../files/functions.php');
$user->IsAdmin();

function sendEmailToUser($userId, $title, $text)
{
    global $pdo;
    $stmt = $pdo->prepare('SELECT UserEmail FROM users WHERE UserID = :UserID');
    $stmt->execute([':UserID' => $userId]);
    
    if ($user = $stmt->fetch()) {
        $title = '=?utf-8?B?' . base64_encode($title) . '?=';
        $body = "<div>$text</div>";

        // Настройки PHPMailer
        $mail = new PHPMailer\PHPMailer\PHPMailer();
        try {
            $mail->isSMTP();
            $mail->CharSet = "UTF-8";
            $mail->SMTPAuth = true;
            $mail->Debugoutput = function ($str, $level) {
                $GLOBALS['status'][] = $str;
            };

            // Настройки вашей почты
            $mail->Host = 'mail.wiq.by'; // SMTP сервера вашей почты
            $mail->Username = 'noreply@wiq.by'; // Логин на почте
            $mail->Password = '126125gg'; // Пароль на почте
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;
            $mail->setFrom('noreply@wiq.by', 'WIQ.BY'); // Адрес самой почты и имя отправителя

            // Получатель письма
            $mail->addAddress($user['UserEmail']);

            // Прикрепление файлов к письму
            $mail->isHTML(true);
            $mail->Subject = $title;
            $mail->Body = $body;

            // Отправка сообщения
            if ($mail->send()) {
                $result = "success";
            } else {
                $result = "error";
            }

        } catch (Exception $e) {
            $result = "error";
            $status = "Сообщение не было отправлено. Причина ошибки: {$mail->ErrorInfo}";
        }
    }
}

if (empty($_REQUEST['action'])) die();

$_mode2status = ['new' => 1, 'active' => 2, 'closed' => 3];
$_status_title = ['1' => 'НОВЫЙ', '2' => 'В РАБОТЕ', '3' => 'ЗАКРЫТ'];
$_projects = [
    (object)['id' => 1, 'title' => 'Техническая поддержка', 'title_en' => 'Technical support', 'sort' => 1],
    (object)['id' => 2, 'title' => 'Финансовый отдел', 'title_en' => 'Payments', 'sort' => 2],
    (object)['id' => 3, 'title' => 'Гарантия', 'title_en' => 'Guarantee', 'sort' => 3],
    (object)['id' => 4, 'title' => 'Биржа заданий (заработок)', 'title_en' => 'Social Media Exchange (Earnings)', 'sort' => 4],
    (object)['id' => 5, 'title' => 'Сотрудничество', 'title_en' => 'Partnership', 'sort' => 5],
    (object)['id' => 6, 'title' => 'Франшиза', 'title_en' => 'Franchise', 'sort' => 6],
];

$_users_names = [];

function getUserName($user_id)
{
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
    case 'delTicket':
        $stmt = $pdo->prepare('DELETE FROM tickets WHERE id = :id');
        $result = $stmt->execute([':id' => (int)$_REQUEST['id']]);

        echo json_encode(['status' => true, 'data' => '']);
        die();

        break;
    case 'getTickets':
        $mode = (!empty($_REQUEST['mode']) && isset($_mode2status[$_REQUEST['mode']])) ? $_REQUEST['mode'] : 'all';
        $stmt = ($mode == 'all')
            ? $pdo->prepare('SELECT * FROM tickets ORDER BY id DESC')
            : $pdo->prepare('SELECT * FROM tickets WHERE status_id = :status_id ORDER BY id DESC');
        $stmt->execute(($mode == 'all') ? [] : [':status_id' => $_mode2status[$mode]]);
        if ($stmt->rowCount() > 0) {
            $tickets = $stmt->fetchAll();
            $result = [];
            foreach ($tickets as $ticket) {
                $stmt = $pdo->prepare('SELECT COUNT(id) FROM tickets_comments WHERE ticket_id = :ticket_id LIMIT 1');
                $stmt->execute([':ticket_id' => $ticket['id']]);
                $count_comments = $stmt->fetch();

                $result[] = (object)[
                    'id' => $ticket['id'],
                    'author_id' => $ticket['author_id'],
                    'author_name' => getUserName($ticket['author_id']),
                    'title' => $ticket['title'],
                    'body' => $ticket['body'],
                    'project_id' => $ticket['project_id'],
                    'comments_count' => ($count_comments['COUNT(id)'] > 0 ? $count_comments['COUNT(id)'] : 1),
                    'last_msg_view_admin' => (bool)$ticket['last_msg_view_admin'],
                    'date_created_dmy' => date("d.m.Y H:i", strtotime($ticket['date_created_dmy'])),
                    'date_updated_dmy' => date("d.m.Y H:i", strtotime($ticket['date_updated_dmy'])),
                    'project_title' => $_projects[$ticket['project_id'] - 1]->title,
                    'project_title_en' => $_projects[$ticket['project_id'] - 1]->title_en,
                    'status_title' => $_status_title[$ticket['status_id']],
                    'order_id' => $ticket["order_id"],
                ];
            }

            echo json_encode(['status' => true, 'data' => $result]);
            die();
        }
        echo json_encode(['status' => false, 'data' => 'empty data']);
        break;
    case 'getProjects':
        echo json_encode(['status' => true, 'data' => $_projects]);
        break;
    case 'uploadFile':
        $ticket_id = (!empty($_POST['ticket_id'])) ? (int)$_POST['ticket_id'] : 0;
        $comment_id = (!empty($_POST['comment_id'])) ? (int)$_POST['comment_id'] : 0;
        $filename = (!empty($_POST['filename'])) ? $_POST['filename'] : '';
        if ($ticket_id > 0 && !empty($filename)) {
            $stmt = $pdo->prepare('SELECT * FROM tickets WHERE id = :ticket_id LIMIT 1');
            $stmt->execute(array(':ticket_id' => $ticket_id));
            if ($stmt->rowCount() == 1) {
                $ticket = $stmt->fetch();
                $author_id = $ticket['author_id'];
            } else {
                $author_id = 0;
            }

            if (!empty($_FILES['file']) && isset($_FILES['file']['error']) && $_FILES['file']['error'] == 0 && $_FILES['file']['size'] <= 10485760 && preg_match('#^image/.+$#i', $_FILES['file']['type'])) {
                $curl = curl_init();
                curl_setopt($curl, CURLOPT_URL, 'https://api.imageban.ru/v1');
                curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: TOKEN zlUz2dWf44OosQMyNVl6'));
                curl_setopt($curl, CURLOPT_POST, 1);
                curl_setopt($curl, CURLOPT_POSTFIELDS, [
                    'name' => $filename, 'secret_key' => 'bz7Hg57hMZxqmppIxUYJXtlPpjrW5XyMyny', 'image' => base64_encode(file_get_contents($_FILES['file']['tmp_name']))
                ]);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                $result = curl_exec($curl);
                $result = json_decode($result, true);
                if (isset($result['success']) && $result['success'] && isset($result['data']) && isset($result['data']['link']) && isset($result['data']['short_link'])) {
                    $stmt = $pdo->prepare('INSERT INTO tickets_files (ticket_id, comment_id, short_link, link) VALUES (:ticket_id, :comment_id, :short_link, :link)');
                    if ($stmt->execute([':ticket_id' => $ticket_id, ':comment_id' => $comment_id, ':short_link' => $result['data']['short_link'], ':link' => $result['data']['link']])) {
                        echo json_encode(['status' => false, 'data' => $result['data']['short_link']]);
                        die();
                    }
                }
            }
        }
        echo json_encode(['status' => false, 'data' => 'empty data']);
        break;
    case 'getTicket':
        $ticket_id = (!empty($_REQUEST['id'])) ? (int)$_REQUEST['id'] : 0;
        $stmt = $pdo->prepare('SELECT * FROM tickets WHERE id = :ticket_id LIMIT 1');
        $stmt->execute(array(':ticket_id' => $ticket_id));
        if ($stmt->rowCount() == 1) {
            $ticket = $stmt->fetch();
            $stmt = $pdo->prepare('SELECT * FROM tickets_files WHERE ticket_id = :ticket_id AND comment_id = :comment_id LIMIT 1');
            $stmt->execute(array(':ticket_id' => $ticket_id, ':comment_id' => 0));
            $files = ($stmt->rowCount() == 1) ? [(object)$stmt->fetch()] : null;

            $status_select = '<select id="ticket_status" class="form-control inline mr-1" style="width: auto; -webkit-appearance: auto;">';
            foreach ($_status_title as $status_id => $status_title) {
                $status_select .= '<option value="' . $status_id . '"' . (($status_id == $ticket['status_id']) ? ' selected' : '') . '>' . $status_title . '</option>';
            }
            $status_select .= '</select>';

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
                'status_title' => $status_select,
                'files' => $files,
                'order_id' => $ticket["order_id"],
            ];
            echo json_encode(['status' => true, 'data' => $result]);

            $stmt = $pdo->prepare('UPDATE tickets SET last_msg_view_admin = :last_msg_view_admin WHERE id = :ticket_id LIMIT 1');
            $stmt->execute([':last_msg_view_admin' => '1', ':ticket_id' => $ticket_id]);

            die();
		}
		echo json_encode(['status' => false, 'data' => 'empty data']);
		break;
    case 'getComments':
        $ticket_id = (int)($_REQUEST['id'] ?? 0);

        $stmt = $pdo->prepare('SELECT * FROM tickets WHERE id = :ticket_id LIMIT 1');
        $stmt->execute([':ticket_id' => $ticket_id]);

        if ($stmt->rowCount() == 1) {
            $ticket = $stmt->fetch();

            $stmt = $pdo->prepare('SELECT * FROM tickets_comments WHERE ticket_id = :ticket_id ORDER BY id DESC');
            $stmt->execute([':ticket_id' => $ticket_id]);

            if ($stmt->rowCount() > 0) {
                $comments = $stmt->fetchAll();
                $result = [];

                foreach ($comments as $comment) {
                    $stmt = $pdo->prepare('SELECT * FROM tickets_files WHERE ticket_id = :ticket_id AND comment_id = :comment_id LIMIT 1');
                    $stmt->execute([':ticket_id' => $ticket_id, ':comment_id' => $comment['id']]);

                    $files = ($stmt->rowCount() == 1) ? [(object)['id' => $stmt->fetch()['id'], 'short_link' => $stmt->fetch()['short_link'], 'link' => $stmt->fetch()['link']]] : null;

                    $result[] = (object)[
                        'id' => $comment['id'],
                        'body' => $comment['body'],
                        'date_created_dmy' => date("d.m.Y H:i", strtotime($comment['date_created_dmy'])),
                        'files' => $files,
                        'my' => ($comment['author_id'] != $ticket['author_id']),
                        'author_name' => ($comment['author_id'] == $_SESSION['auth']) ? 'Вы' : getUserName($comment['author_id']),
                    ];
                }

                echo json_encode(['status' => true, 'data' => $result]);

                $stmt = $pdo->prepare('UPDATE tickets SET last_msg_view_admin = :last_msg_view_admin WHERE id = :ticket_id LIMIT 1');
                $stmt->execute([':last_msg_view_admin' => '1', ':ticket_id' => $ticket_id]);

                die();
            }
        }
        echo json_encode(['status' => false, 'data' => 'empty data']);
        break;

    case 'addComment':
        $ticket_id = (int)($_REQUEST['id'] ?? 0);
        $body = $_POST['body'] ?? '';

        if ($ticket_id > 0 && !empty($body)) {
            $stmt = $pdo->prepare('SELECT * FROM tickets WHERE id = :ticket_id LIMIT 1');
            $stmt->execute([':ticket_id' => $ticket_id]);

            if ($stmt->rowCount() == 1) {
                $ticket = $stmt->fetch();
                $stmt = $pdo->prepare('INSERT INTO tickets_comments (ticket_id, body, author_id) VALUES (:ticket_id, :body, :author_id)');
                if ($stmt->execute([':ticket_id' => $ticket_id, ':body' => $body, ':author_id' => $_SESSION['auth']])) {
                    $comment_id = $pdo->lastInsertId();

                    $stmt = $pdo->prepare('UPDATE tickets SET last_msg_view_author = :last_msg_view_author WHERE id = :ticket_id LIMIT 1');
                    $stmt->execute([':last_msg_view_author' => '0', ':ticket_id' => $ticket_id]);

                    if ($ticket['status_id'] == 1) {
                        $stmt = $pdo->prepare('UPDATE tickets SET status_id = :status_id WHERE id = :ticket_id LIMIT 1');
                        $stmt->execute([':status_id' => 2, ':ticket_id' => $ticket_id]);
                    }

                    $msg = '<h2>У вас новое сообщение от техподдержки <a href="http://wiq.by" target="_blank" data-saferedirecturl="https://www.google.com/url?q=http://wiq.by&amp;source=gmail&amp;ust=1698449541463000&amp;usg=AOvVaw1YRF1ZN0ArDab4rPjqeg4T">wiq.by</a></h2>';
                    $msg .= 'У Вас новое сообщение от тех.поддержки <a href="https://wiq.by/">wiq.by</a><br>';
                    $msg .= 'Прочитать можно по ссылке: <a href="https://wiq.by/support.php?id=' . $ticket_id . '">wiq.by/support.php?id=' . $ticket_id . '</a><br>';
                    $msg .= '<br><br><br><br><br><a href="http://wiq.by" target="_blank" data-saferedirecturl="https://www.google.com/url?q=http://wiq.by&amp;source=gmail&amp;ust=1698449541463000&amp;usg=AOvVaw1YRF1ZN0ArDab4rPjqeg4T">WIQ.BY';

                    sendEmailToUser($ticket['author_id'], 'У вас новое сообщение', $msg);

                    echo json_encode(['status' => true, 'data' => $comment_id]);
                    die();
                }
            }
        }
        echo json_encode(['status' => false, 'data' => 'empty data']);
        break;

    case 'setStatus':
        $ticket_id = (int)($_REQUEST['id'] ?? 0);
        $status = (int)($_POST['status'] ?? 0);

        if ($ticket_id > 0 && $status > 0) {
            $stmt = $pdo->prepare('UPDATE tickets SET status_id = :status_id WHERE id = :ticket_id LIMIT 1');
            $stmt->execute([':status_id' => $status, ':ticket_id' => $ticket_id]);

            $stmt = $pdo->prepare('SELECT date_updated_dmy FROM tickets WHERE id = :ticket_id LIMIT 1');
            $stmt->execute([':ticket_id' => $ticket_id]);
            $r = $stmt->fetch();
            $date_updated_dmy = $r['date_updated_dmy'];

            echo json_encode(['status' => true, 'data' => (object)[
                'status' => $status,
                'date_updated_dmy' => date("d.m.Y H:i", strtotime($date_updated_dmy)),
            ]]);
            die();
        }
        echo json_encode(['status' => false, 'data' => 'empty data']);
        break;

    default:
        die();
}
?>
