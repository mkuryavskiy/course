<?php
	require_once('files/header.php');
?>
<style>
    .nav-pills>li.active>a, .nav-pills>li.active>a:focus, .nav-pills>li.active>a:hover
    {
        color: #fff;
        background: linear-gradient(110deg,#ea037f,#0587f7);
    }
</style>
<section class="page-section">
<div class="container relative">
<h1 class="section-title font-alt">
<span style="color:#d92d53;"><?=Language("_how_it_works")?></span> <span style="color:#5048eb;">WIQ.BY</span>
</h1>
<div class="row">
    <div class="col-md-12" style="font-size: 18px;">
             <ul class="nav nav-pills">
                    <li class="active">
							<a data-toggle="tab" href="/how-it-works#menu0" style="text-decoration: none;"><?=Language("_step_1")?></a>
						</li>
						<li>
							<a data-toggle="tab" href="/how-it-works#menu1" style="text-decoration: none;"><?=Language("_step_2")?></a>
						</li>
						<li>
							<a data-toggle="tab" href="/how-it-works#menu2" style="text-decoration: none;"><?=Language("_step_3")?></a>
						</li>
						<li>
							<a data-toggle="tab" href="/how-it-works#menu3" style="text-decoration: none;"><?=Language("_step_4")?></a>
						</li>
					</ul>
					<hr>
					<div class="tab-content">
                    <?php
                    $contents = [
                        ['_creating', '_account', '_step_1_description', '_register', '1step.webp'],
                        ['_replenishing', '_balance', '_step_2_description', null, '2step.webp'],
                        ['_creating', '_order', '_step_3_description', null, null],
                        [null, null, null, null, 'step3.webp']
                    ];

                    foreach ($contents as $index => $content) {
                        $active = $index === 0 ? ' in active' : '';
                        echo "<div id=\"menu$index\" class=\"tab-pane fade$active\">";
                        if ($index < 3) {
                            echo "<div class=\"col-sm-6\">";
                            if ($content[0]) {
                                echo "<h1 class=\"mh\"><span style=\"color:#d92d53;\">" . Language($content[0]) . "</span> " . Language($content[1]) . "</h1>";
                                echo "<p class=\"mp\">" . Language($content[2]) . "</p>";
                                if ($content[3]) {
                                    echo "<a href=\"login\" class=\"btn btn-default btn-default-2 btn-block\">" . Language($content[3]) . "</a>";
                                }
                            }
                            if ($index === 2) {
                                echo "<div class=\"sub-tabs\">";
                                $subSteps = ['_select_category', '_select_service', '_enter_link', '_enter_quantity', '_click_order'];
                                foreach ($subSteps as $i => $subStep) {
                                    echo "<div><h3 class=\"sh\">" . sprintf("%02d", $i + 1) . " " . Language($subStep) . "</h3>";
                                    echo "<p class=\"mp\">" . Language($subStep . "_description") . "</p></div>";
                                }
                                echo "</div>";
                            }
                            echo "</div>";
                        }
                        if ($content[4]) {
                            $colClass = $index === 3 ? "col-sm-12" : "col-sm-6";
                            echo "<div class=\"$colClass\"><img class=\"img-responsive\" src=\"./theme/img/how-it-works/{$content[4]}\"></div>";
                        }
                        echo "</div>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>
<?php require_once('files/footer.php'); ?>