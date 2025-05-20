<?php
	include('../files/functions.php');
	if(isset($user))
	$user->IsAdmin();
?>
<!DOCTYPE html>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css">

<html lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
		<meta charset="utf-8" />
		<title>Управление сайтом | WIQ</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, shrink-to-fit=no" />
		<link rel="icon" type="image/x-icon" href="../../favicon.png" />
		<link href="assets/plugins/pace/pace-theme-flash.css" rel="stylesheet" type="text/css" />
		<link href="assets/plugins/boostrapv3/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
		<link href="assets/plugins/font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css" />
		<link href="assets/plugins/jquery-scrollbar/jquery.scrollbar.css" rel="stylesheet" type="text/css" media="screen" />
		<link href="assets/plugins/bootstrap-select2/select2.css" rel="stylesheet" type="text/css" media="screen" />
		<link href="assets/plugins/switchery/css/switchery.min.css" rel="stylesheet" type="text/css" media="screen" />
		<link href="assets/plugins/nvd3/nv.d3.min.css" rel="stylesheet" type="text/css" media="screen" />
		<link href="assets/plugins/mapplic/css/mapplic.css" rel="stylesheet" type="text/css" />
		<link href="assets/plugins/rickshaw/rickshaw.min.css" rel="stylesheet" type="text/css" />
		<link href="assets/plugins/bootstrap-datepicker/css/datepicker3.css" rel="stylesheet" type="text/css" media="screen">
		<link href="assets/css/datatables.min.css" rel="stylesheet" type="text/css" media="screen">
		<link href="assets/plugins/jquery-metrojs/MetroJs.css" rel="stylesheet" type="text/css" media="screen" />
		<link href="pages/css/pages-icons.css" rel="stylesheet" type="text/css">
		<link class="main-stylesheet" href="pages/css/pages.css" rel="stylesheet" type="text/css" />

		<!--[if lte IE 9]>
		<link href="assets/plugins/codrops-dialogFx/dialog.ie.css" rel="stylesheet" type="text/css" media="screen" />
		<![endif]-->
	</head>
	<body class="fixed-header dashboard">
		<nav class="page-sidebar" data-pages="sidebar">
			<div class="sidebar-menu">
				<ul class="menu-items">
					<li class="m-t-30 ">
						<a href="index" class="detailed">
							<span class="title">Головна</span>
							<span class="details">Налаштування панелі</span>
						</a>
						<span class="bg-success icon-thumbnail"><i class="pg-home"></i></span>
					</li>
					<li>
						<a href="javascript:;">
							<span class="title">Категорії</span>
							<span class=" arrow"></span>
						</a>
						<span class="icon-thumbnail"><i class="fa fa-list-alt"></i></span>
						<ul class="sub-menu">
							<li class="">
								<a href="category-list">Усі категорії</a>
							</li>
							<li class="">
								<a onClick="CategoryCreateModal();">Створити нову</a>
							</li>
						</ul>
					</li>
					<li>
						<a href="javascript:;">
							<span class="title">Сервіси</span>
							<span class=" arrow"></span>
						</a>
						<span class="icon-thumbnail"><i class="fa fa-clone"></i></span>
						<ul class="sub-menu">
							<li class="">
								<a href="service-list">Всі послуги</a>
							</li>
							<li class="">
								<a style="cursor: pointer;" onClick="ServiceCreateModal();">Створити новий</a>
							</li>
						</ul>
					</li>
					<li>
						<a href="javascript:;">
							<span class="title">Користувачі</span>
							<span class=" arrow"></span>
						</a>
						<span class="icon-thumbnail"><i class="fa fa-users"></i></span>
						<ul class="sub-menu">
							<li class="">
								<a href="user-list">Повний список</a>
							</li>
							<li class="">
								<a href="user-banned-list">Заблоковані</a>
							</li>
							<li class="">
								<a href="user-referred-list">Реферальні</a>
							</li>
							<li class="">
								<a style="cursor: pointer;" onClick="UserCreateModal();">Створити нового</a>
							</li>
						</ul>
					</li>
					<li>
						<a href="javascript:;">
							<span class="title">Замовлення</span>
							<span class=" arrow"></span>
						</a>
						<span class="icon-thumbnail"><i class="fa fa-shopping-cart"></i></span>
						<ul class="sub-menu">
							<li class="">
								<a href="all-order-list">Повний список</a>
							</li>
							<li class="">
								<a href="completed-order-list">Завершені</a>
							</li>
							<li class="">
								<a href="in-process-order-list">У процесі</a>
							</li>
							<li class="">
								<a href="api-order-list">API</a>
							</li>
						</ul>
					</li>
					<li>
						<a href="deposit-list" class="detailed">
							<span class="title">Платежі</span>
							<span class="details">Повний список</span>
						</a>
						<span class="icon-thumbnail"><i class="fa fa-bank"></i></span>
					</li>

					<li>
						<a href="javascript:;">
							<span class="title">Платіжні системи</span>
							<span class=" arrow"></span>
						</a>
						<span class="icon-thumbnail"><i class="fa fa-question"></i></span>
						<ul class="sub-menu">
							<li class="">
								<a href="payment_systems">Список</a>
							</li>
						</ul>
					</li>




					<li>
						<a href="javascript:;">
							<span class="title">Новини</span>
							<span class=" arrow"></span>
						</a>
						<span class="icon-thumbnail"><i class="fa fa-newspaper-o"></i></span>
						<ul class="sub-menu">
							<li class="">
								<a href="news_list">Повний список</a>
							</li>
							<li class="">
								<a style="cursor: pointer;" onClick="NEWSCreateModal();">Створити</a>
							</li>
						</ul>
					</li>







					<li>
						<a href="javascript:;">
							<span class="title">Відгуки</span>
							<span class=" arrow"></span>
						</a>
						<span class="icon-thumbnail"><i class="fa fa-comments"></i></span>
						<ul class="sub-menu">
							<li class="">
								<a href="otzyvy_list">Відгуки на модерацію</a>
							</li>
							<li class="">
								<a href="otzyvy-add_list">Додані відгуки</a>
							</li>
							<li class="">
								<a style="cursor: pointer;" onClick="OtzyvCreateModal();">Створити</a>
							</li>
						</ul>
					</li>




					<li>
						<a href="javascript:;">
							<span class="title">Оновлення</span>
							<span class=" arrow"></span>
						</a>
						<span class="icon-thumbnail"><i class="fa fa-magic"></i></span>
						<ul class="sub-menu">
							<li class="">
								<a href="updates">Повний перелік</a>
							</li>
							<li class="">
								<a style="cursor: pointer;" onClick="update_create_modal();">Створити</a>
							</li>
						</ul>
					</li>
					<li>
						<a href="support" class="detailed">
							<span class="title">Підтримка</span>
							<span class="details">Тикети</span>
						</a>
						<span class="icon-thumbnail"><i class="fa fa-users"></i></span>
					</li>
				</ul>
				<div class="clearfix"></div>
			</div>
		</nav>
		<div class="page-container ">
		<div class="header ">
			<div class="container-fluid relative">
				<!-- LEFT SIDE -->
				<div class="pull-left full-height visible-sm visible-xs">
					<!-- START ACTION BAR -->
					<div class="header-inner">
						<a href="#" class="btn-link toggle-sidebar visible-sm-inline-block visible-xs-inline-block padding-5" data-toggle="sidebar">
						<span class="icon-set menu-hambuger"></span>
						</a>
					</div>
					<!-- END ACTION BAR -->
				</div>
				<!-- RIGHT SIDE -->

			</div>
			<!-- END MOBILE CONTROLS -->

			<div class=" pull-left sm-table hidden-xs hidden-sm">
				<div class="header-inner">
					<!-- START NOTIFICATION LIST -->
					<ul class="notification-list no-margin hidden-sm hidden-xs b-grey b-l b-r no-style p-l-30 p-r-20">
						<li class="p-r-15 inline">
							<div class="dropdown">
								</a>
								<!-- START Notification Dropdown -->
								<div class="dropdown-menu notification-toggle" role="menu" aria-labelledby="notification-center">
									<!-- START Notification -->
									<div class="notification-panel">
										<!-- START Notification Body-->
										<div class="notification-body scrollable padding-10">
											<?php

												$stmt = $pdo->prepare('SELECT o.*, u.`UserName`, s.`ServiceName`
                                                                         FROM orders o
                                                                         LEFT JOIN `users` u ON u.`UserID` = o.`OrderUserID`
                                                                         LEFT JOIN `services` s ON s.`ServiceID` = o.`OrderServiceID`
                                                                        ORDER BY o.OrderID DESC LIMIT 10');
												$stmt->execute();

												if($stmt->rowCount() > 0) {
													$html = '';

													foreach($stmt->fetchAll() as $row) {
														//$OrderUserName = $layer->GetData('users', 'UserName', 'UserID', $row['OrderUserID']);
														//$OrderServiceName = $layer->GetData('services', 'ServiceName', 'ServiceID', $row['OrderServiceID']);
														$OrderDate = $layer->time_ago($row['OrderDate']);

															$html .= '<div class="notificati on-item  clearfix">';
															$html .= '<div class="heading">';
															$html .= '<span class="bold text-success">'.$row['ServiceName'].'</span>';
															$html .= '<p>Пользователь: <a class="m-l-5 text-primary" href="user-orders?id='.$row['OrderUserID'].'"> '.$row['UserName'].'</a></p>';
															$html .= '<p>Цена : '.$row['OrderCharge'].' '.$settings['Currency'].'</p>';
															$html .= '<p>Количество: '.$row['OrderQuantity'].'</p>';
															$html .= '<span class="pull-right">'.$OrderDate.' ('.date('d.m.Y h:I:s', $row['OrderDate']).')</span>';
															$html .= '</div>';
															$html .= '<div class="option">';
															$html .= 'ID заказа: <a href="order-edit?id='.$row['OrderID'].'" class="mark">#'.$row['OrderID'].'</a>';
															$html .= '</div>';
															$html .= '</div>';
															$html .= '<hr>';

													}

													echo $html;
												} else {
													echo 'Заказов небыло.';
												}
												?>
										</div>
										<div class="notification-footer text-center">
											<a href="all-order-list" class="">Усі замовлення</a>
											<a data-toggle="refresh" class="portlet-refresh text-black pull-right">
											</a>
										</div>
									</div>
								</div>
							</div>
						</li>

					</ul>
				</div>
			</div>
			<div class="pull-left"><div class="header-inner">
											<?php
											$stmt = $pdo->prepare('SELECT id FROM tickets WHERE last_msg_view_admin = :last_msg_view_admin');
											$stmt->execute([':last_msg_view_admin' => '0']);
											$msg_count = $stmt->rowCount();
											?>
			<ul class="no-margin hidden-sm hidden-xs b-grey b-r no-style p-l-20 p-r-20"><li>
				</li></ul>
			</div></div>
			<div class=" pull-right">
				<div class="visible-lg visible-md m-t-10">
					<div class="pull-left p-r-10 p-t-10 fs-16 font-heading">
						&nbsp;
					</div>
					<div class="dropdown pull-right">
						<button class="profile-dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							</li>
						</ul>
					</div>
				</div>
				<!-- END User Info-->
			</div>
		</div>
		<div class="page-content-wrapper ">
			<!-- START PAGE CONTENT -->
			<div class="content sm-gutter">
				<!-- START CONTAINER FLUID -->
				<div class="container-fluid padding-25 sm-padding-10">
				<!-- END HEADER -->
