<?php
include('files/header.php');
?>


<div class="row" style="display: none;">
    <div class="col-sm-6">
        <div class="panel panel-transparent">
            <div class="panel-body">
                <div class="tab-content">
                    <div class="tab-pane fade in active" id="position-bar">
                        <div class="notification-positions">
                            <div class="position pull-top active" data-placement="top">
                                <img alt="Loading bar" src="assets/img/notifications/loading_bar.svg" class="">
                            </div>
                            <div class="position pull-bottom" data-placement="bottom">
                                <img alt="Loading bar" src="assets/img/notifications/loading_bar.svg" class="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-4 col-lg-4 col-xlg-3 m-b-10">
        <div class="widget-16 panel no-border  no-margin widget-loader-circle">
            <div class="panel-heading">
                <div class="panel-title">Налаштування панелі керування</div>

                <div class="panel-controls">
                    <ul>
                        <li><a href="#" class="portlet-refresh text-black" data-toggle="refresh"><i
                                        class="portlet-icon portlet-icon-refresh"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="b-b b-grey p-l-20 p-r-20 p-b-10 p-t-10">
                <p class="pull-left">
                    Вимкнути реєстрацію
                    <br>
                    <font size="1px">Вимкнення реєстрацій</font>
                </p>
                <div class="pull-right">
                    <input type="checkbox" data-init-plugin="switchery" <?php if($settings['RestrictRegistrations'] == 'Yes') echo 'checked'; ?> onChange="updateMaintenanceMode();"/>
                </div>
				   <br>
                    <div class="form-group">
                        <div class="col-sm-12 form-group-default m-t-5">
                            <label>Назва сайту</label>
                            <input type="text" name="GooglePlusURl" value="<?php echo $settings['GooglePlusURL']; ?>" class="form-control" placeholder="Google+ Page URL." onChange="UpdateInputData(this.getAttribute('name'), this.value);">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12 form-group-default m-t-5">
                            <label>Бренд сайту</label>
                            <input type="text" name="WebsiteName" value="<?php echo $settings['WebsiteName']; ?>" class="form-control" placeholder="SMM Panel" onChange="UpdateInputData(this.getAttribute('name'), this.value);">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12 form-group-default m-t-5">
                            <label>Інформація про сайт</label>
                            <input type="text" style="resize: none;" name="WebsiteQuote" rows="2" class="form-control" placeholder="My SMM panel is the best." onChange="UpdateInputData(this.getAttribute('name'), this.value);" value="<?php echo $settings['WebsiteQuote']; ?>">
                        </div>
                    </div>
                <div class="clearfix"></div>
            </div>
        </div>
        <!-- END WIDGET -->
    </div>
    <div class="col-md-4 col-lg-4 col-xlg-3 m-b-10">
        <div class="widget-16 panel no-border  no-margin widget-loader-circle">
            <div class="panel-heading">
                <div class="panel-title">Налаштування оплати
                </div>
                <div class="panel-controls">
                    <ul>
                        <li><a href="#" class="portlet-refresh text-black" data-toggle="refresh"><i class="portlet-icon portlet-icon-refresh"></i></a></li>
                    </ul>
                </div>
            </div>
            <div class="p-l-20 p-r-20 p-b-10 p-t-10">
                <div class="row">
                    <!-- <div class="form-group">
                        <div class="col-sm-12 form-group-default m-t-5">
                            <label>FK Shop ID</label>
                            <input type="text" name="FkShopId" value="<?php echo $settings['FkShopId']; ?>" class="form-control" placeholder="FK Shop ID." onChange="UpdateInputData(this.getAttribute('name'), this.value, 'ID магазина Free-Kassa успешно изменен!');">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12 form-group-default m-t-5">
                            <label>FK Shop Secret Key</label>
                            <input type="text" name="FkSecret" value="<?php echo $settings['FkSecret']; ?>" class="form-control" placeholder="FkSecret Key #1." onChange="UpdateInputData(this.getAttribute('name'), this.value, 'Secret Key Free-Kassa успешно изменен!.');">
                        </div>
                    </div> -->
                    <div class="form-group">
                        <div class="col-sm-12 form-group-default m-t-5">
                            <label>Назва валюти</label>
                            <input type="text" name="Currency" value="<?php echo $settings['Currency']; ?>" class="form-control" placeholder="For example USD" onChange="UpdateInputData(this.getAttribute('name'), this.value);">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12 form-group-default m-t-5">
                            <label>Символ валюти</label>
                            <input type="text" name="CurrencySymbol" value="<?php echo $settings['CurrencySymbol']; ?>" class="form-control" placeholder="For example $" onChange="UpdateInputData(this.getAttribute('name'), this.value);">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12 form-group-default m-t-5">
                            <label>Партнерський відсоток</label>
                            <input type="number" name="ReferrsPercent" value="<?php echo $settings['ReferrsPercent']; ?>" class="form-control" placeholder="Referrs Percent(Ex. 5)" onChange="UpdateInputData(this.getAttribute('name'), this.value);">
                            <font size="1px">% буде виплачено рефоводу</font>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container-fluid container-fixed-lg bg-white">
            </div>
        </div>
    </div>
    <div class="col-md-4 col-lg-4 col-xlg-3 m-b-10">
        <div class="widget-16 panel no-border  no-margin widget-loader-circle">
            <div class="panel-heading">
                <div class="panel-title">Налаштування додаткові
                </div>
                <div class="panel-controls">
                    <ul>
                        <li><a href="#" class="portlet-refresh text-black" data-toggle="refresh"><i class="portlet-icon portlet-icon-refresh"></i></a></li>
                    </ul>
                </div>
            </div>
            <div class="p-l-20 p-r-20 p-b-10 p-t-10">
                <div class="row">
                    <div class="form-group">
                        <div class="col-sm-12 form-group-default m-t-5">
                            <label>Email для логов</label>
                            <input type="text" name="NotificationEmail" value="<?php echo $settings['NotificationEmail']; ?>" class="form-control" placeholder="E-mail for receiving notifications." onChange="UpdateInputData(this.getAttribute('name'), this.value);">
                        </div>
                    </div>
                </div>
            </div>
            <div class="container-fluid container-fixed-lg bg-white">
            </div>
        </div>
    </div>
</div>
<?php
require_once('files/footer.php');
?>
