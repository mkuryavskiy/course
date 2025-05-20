<?php
$needDataTables = true;

require_once('files/header.php');
require_once('files/currency_conversion.php');
$lang = strtoupper($_GET["lang"] ?? "");
?>

<style>
    #reseller-banner {
        position: relative;
        display: flex;
        align-items: center;
        width: 100%;
        height: 80px;
        padding: 0 20px;
        border-radius: 10px;
        color: #fff;
        background: linear-gradient(110deg, #ea037f, #0587f7);
        text-decoration: none;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }

    #reseller-banner:before {
        content: "";
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        z-index: 0;
        background: url('/theme/img/reseller-banner-bg-md.webp') 100% no-repeat;
        background-size: contain;
    }

    #reseller-banner .title {
        font-size: 24px;
        position: relative;
        line-height: 18px;
        font-weight: 500;
        text-align: left;
        letter-spacing: 2px;
        width: 800px;
        margin: 0;
    }

    #reseller-banner .title br {
        display: none;
    }

    #reseller-banner .arrow {
        position: absolute;
        right: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        top: 0;
        bottom: 0;
        margin: auto;
        width: 150px;
        height: 32px;
        border-radius: 16px;
        color: #fff;
        background-color: #e81586;
        font-size: 14px;
        font-weight: 800;
        letter-spacing: 0.88px;
    }

    #reseller-banner .arrow .icon {
        display: none;
    }

    @media only screen and (max-width: 1126px) {
        #reseller-banner .title {
            font-size: 20px;
        }
    }

    @media only screen and (max-width: 900px) {
        #reseller-banner .title {
            font-size: 20px;
            line-height: 26px;
        }

        #reseller-banner .title br {
            display: inline !important;
        }
    }

    @media only screen and (max-width: 540px) {
        #reseller-banner:before {
            background-image: none;
        }

        #reseller-banner .arrow {
            right: 20px;
            width: 32px;
        }

        #reseller-banner .arrow .arrow-text {
            display: none;
        }

        #reseller-banner .arrow .icon {
            display: block;
        }
    }

    .services_currency_widget {
        position: fixed;
        right: 2%;
        bottom: 0;
        padding: 5px;
        border: 1px solid rgba(51, 51, 51, 0.11);
        background-color: #f8f9fa;
        font-size: 16px;
        z-index: 101;
        border-radius: 10px 10px 0 0;
    }

    tbody tr td:nth-child(4),
    tbody tr td:nth-child(5),
    tbody tr td:nth-child(6) {
        text-align: center;
    }

    .page-section,
    .hidden_table {
        padding: 0;
    }

    body td {
        font-size: 13px;
    }

    table.dataTable tbody td,
    table.dataTable tbody th {
        padding: 15px 8px;
    }

    .table-responsive {
        -webkit-text-size-adjust: 100%;
        line-height: 1.6;
        -webkit-font-smoothing: antialiased;
        color: #333;
        box-sizing: border-box;
        -webkit-tap-highlight-color: transparent;
        min-height: .01%;
        overflow-x: auto;
        border-radius: 5px;
        box-shadow: 0px 0px 16px rgba(86, 77, 77, 0.21);
    }

    .table-responsive table {
        border-radius: 5px;
        width: 100%;
    }
</style>
<div style="margin-top: 100px;" class="row col-md-10 col-center">
    <div id="ins" class="section-title style-gradient wow fadeInUp" style="visibility: visible; animation-name: fadeInUp;">
        <div class="alert bshadow" style="background-image: url(/img/other/r-image.png); background-position: 80% 100%; background-repeat: no-repeat; border-radius: 5px !important;">
            <b><?= Language('_price_per_1000') ?></b><br>
            <?= Language('_contact_support') ?>
        </div>
        <a id="reseller-banner" href="discount" target="_blank">
            <h4 class="title"><?= Language('_become_reseller') ?> <br><?= Language('_get_discount') ?></h4>
            <div class="arrow">
                <span class="arrow-text d-md-inline-block mr-10"><?= Language('_more_info') ?></span>
                <i class="icon fa fa-arrow-right" aria-hidden="true"></i>
            </div>
        </a>
        <div class="text-center" style="padding-top: 13px;">
            <?php
            $socialLinks = [
                ['href' => '#cat18', 'icon' => 'fab fa-instagram'],
                ['href' => '#cat27', 'icon' => 'fab fa-vk'],
                ['href' => '#cat28', 'icon' => 'fab fa-telegram-plane'],
                ['href' => '#cat26', 'icon' => 'far fa-camera-retro'],
                ['href' => '#cat29', 'icon' => 'fab fa-youtube'],
                ['href' => '#cat30', 'icon' => 'fab fa-twitter'],
                ['href' => '#cat31', 'icon' => 'fab fa-whatsapp'],
            ];

            foreach ($socialLinks as $link) {
                echo "<a style='text-decoration: none; margin-right: 5px;' href='{$link['href']}'><i style='padding-left: 10px;' class='{$link['icon']}'></i></a>";
            }
            ?>
        </div>
    </div>
</div>
<section class="page-sectionXXX">
    <div class="row col-md-10 col-center">
        <div class="table-responsive dataTables_scroll">
            <table id="services-table" class="cell-border dataTable" cellspacing="0">
                <thead>
                    <tr>
                        <th class="list-th"><?= Language('_id') ?></th>
                        <th class="list_th list_th_s1"><?= Language('_service') ?></th>
                        <th class="list_th list_th_s1"><?= Language('_description') ?></th>
                        <th class="child_center list_th list_th_s3"><?= Language('_price') ?></th>
                        <th class="child_center list_th list_th_s3"><?= Language('_for_resellers') ?></th>
                        <th class="child_center list_th list_th_s4"><?= Language('_min_max') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $stmt2 = $pdo->prepare('SELECT * FROM categories WHERE CategoryActive = "Yes" ORDER BY sort DESC');
                    $stmt2->execute();

                    $catIcons = [
                        18 => 'fab fa-instagram', 19 => 'fab fa-instagram', 21 => 'fab fa-instagram',
                        22 => 'fab fa-instagram', 23 => 'fab fa-instagram', 24 => 'fab fa-instagram',
                        25 => 'fab fa-instagram', 47 => 'fab fa-instagram', 26 => 'far fa-camera-retro',
						27 => 'fab fa-vk',
                        28 => 'fab fa-telegram-plane', 33 => 'fab fa-telegram-plane', 34 => 'fab fa-telegram-plane',
						44 => 'fab fa-telegram-plane', 56 => 'fab fa-telegram-plane', 45 => 'fab fa-telegram-plane',
						29 => 'fab fa-youtube', 30 => 'fab fa-twitter',
                        31 => 'fas fa-heart-square', 32 => 'fab fa-whatsapp',
                    ];

$oldCat = null;
while ($category = $stmt2->fetch()) {
    $stmt = $pdo->prepare('SELECT * FROM services WHERE ServiceCategoryID = ? AND ServiceActive = "Yes" ORDER BY ServicePrice ASC');
    $stmt->execute([$category['CategoryID']]);
                        
                        while ($service = $stmt->fetch()) {
                            $catId = (int)$service['ServiceCategoryID'];
                            if ($oldCat !== $catId) {
                                // Use the appropriate language version of the category name
                                $categoryName = ($lang == "RU") ? $category['CategoryName'] : ($category['CategoryName'.strtoupper($lang)] ?: $category['CategoryName']);
                                $cleanCategoryName = cleanCategoryName($categoryName);

                                // Get the icon for the category
                                $iconClass = $catIcons[$catId] ?? 'fas fa-folder'; // Default icon if not found

                                echo "<tr>
                                    <td colspan='6' style='border-bottom: 1px solid black; border-top: 1px solid black; text-align: center; font-weight: bold; padding: 15px 8px;'>
                                        <a name='cat{$catId}'></a><i class='{$iconClass}'></i> {$cleanCategoryName}
                                    </td>
                                </tr>";
                                $oldCat = $catId;
                            }

                            $ServiceName = ($lang == "RU") ? $service['ServiceName'] : ($service['ServiceName'.strtoupper($lang)] ?: $service['ServiceName']);
                            $ServiceDescription = ($lang == "RU") ? $service['ServiceDescription'] : ($service['ServiceDescription'.strtoupper($lang)] ?: $service['ServiceDescription']);
                            $ServiceDescription = processDescription($ServiceDescription);

                            echo "<tr>
                                <td>{$service['ServiceID']}</td>
                                <td>{$ServiceName}</td>
                                <td style='width: 200px;'>{$ServiceDescription}</td>
                                <td>
                                    \${$service['ServicePrice']} " . Language('_for') . " 1000
                                    <hr style='margin:2px; border-top: 1px solid #eee; background-color: rgba(255,255,255, .08);'>
                                    ≈" . round($service['ServicePrice'] * $rate, 2) . $currency . "
                                </td>
                                <td>
                                    \${$service['ServiceResellerPrice']} " . Language('_for') . " 1000
                                    <hr style='margin:2px; border-top: 1px solid #eee; background-color: rgba(255,255,255, .08);'>
                                    ≈" . round($service['ServiceResellerPrice'] * $rate, 2) . $currency . "
                                </td>
                                <td>
                                    {$service['ServiceMinQuantity']} \ {$service['ServiceMaxQuantity']}
                                </td>
                            </tr>";
                        }
                    }

                    function cleanCategoryName($name) {
                        $name = preg_replace('/[\x{1F600}-\x{1F64F}\x{1F300}-\x{1F5FF}\x{1F680}-\x{1F6FF}\x{1F1E0}-\x{1F1FF}]/u', '', $name);
                        $name = preg_replace('/[^\p{L}\p{N}\s]/u', '', $name);
                        return trim($name);
                    }

                    function processDescription($description) {
                        if (preg_match_all('/(<span class=\'number\d{1}\'>[^<]*\d*[^<]*<\/span>)/is', $description, $matches)) {
                            $tmpAddAll = 0;
                            foreach ($matches[1] as $srcString) {
                                preg_match('/>(\d+)</', $srcString, $numberMatch);
                                $tmpInt = (int)$numberMatch[1];
                                $tmpInt = ($tmpInt < 10) ? mt_rand(100, 500) : $tmpInt;
                                $tmpAdd = random_int(-10, 10);
                                $tmpAddAll += $tmpAdd;
                                $tmpInt += $tmpAddAll;
                                $description = str_replace($srcString, str_replace($numberMatch[1], $tmpInt, $srcString), $description);
                            }
                        }
                        return $description;
                    }
                    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th class="list-th"><?= Language('_id') ?></th>
                        <th class="list_th list_th_s1"><?= Language('_service') ?></th>
                        <th class="list_th list_th_s1"><?= Language('_description') ?></th>
                        <th class="child_center list_th list_th_s3"><?= Language('_price') ?></th>
                        <th class="child_center list_th list_th_s3"><?= Language('_for_resellers') ?></th>
                        <th class="child_center list_th list_th_s4"><?= Language('_min_max') ?></th>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div style="margin-bottom: 50px;" class="text-center mt-30">
            <a style="text-decoration: none;" href="new-order" rel="nofollow" target="_blank" class="btn btn-warning btn-md text-uppercase"><i class="fas fa-shopping-basket"></i> <?= Language('_place_order') ?></a>
        </div>
    </div>
</section>

<?php require_once('files/footer.php'); ?>