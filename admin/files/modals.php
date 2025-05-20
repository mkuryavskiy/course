<div class="modal fade stick-up" id="create-category-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header clearfix text-left">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
                </button>
                <h5><span class="semi-bold">Створення категорії</span></h5>
            </div>
            <div class="modal-body">
                <form role="form" id="create-category">
                    <ul class="nav nav-tabs" style="margin-bottom: 15px;">
                        <li class="active"><a href="#first-tab-content" data-toggle="tab"></a></li>
                        <li><a href="#second-tab-content" data-toggle="tab">UA</a></li>
                    </ul>

                    <div class="tab-content" style="width: 100%; padding: 0;">
                        <div id="first-tab-content" class="tab-pane fade in active">
                            <div class="form-group-attached">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group form-group-default">
                                            <label>Назва</label>
                                            <input type="text" id="CategoryName" name="CategoryName" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-8">
                                        <div class="form-group form-group-default">
                                            <label>Опис</label>
                                            <textarea rows="15" id="CategoryDescription" name="CategoryDescription" class="form-control"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group form-group-default">
                                            <label>Статус</label>
                                            <select name="CategoryActive" class="form-control">
                                                <option value="Yes">Активна</option>
                                                <option value="No">Не активна</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="second-tab-content" class="tab-pane fade">
                            <div class="form-group-attached">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group form-group-default">
                                            <label>Назва</label>
                                            <input type="text" id="CategoryNameUA" name="CategoryNameUA" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-8">
                                        <div class="form-group form-group-default">
                                            <label>Опис</label>
                                            <textarea rows="15" id="CategoryDescriptionUA" name="CategoryDescriptionUA" class="form-control"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="last-tab-content" class="tab-pane fade">
                            <div class="form-group-attached">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group form-group-default">
                                            <label>Назва</label>
                                            <input type="text" id="CategoryNameEN" name="CategoryNameEN" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-8">
                                        <div class="form-group form-group-default">
                                            <label>Опис</label>
                                            <textarea rows="15" id="CategoryDescriptionEN" name="CategoryDescriptionEN" class="form-control"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4 m-t-10 sm-m-t-10">
                            <button type="button" class="btn btn-primary btn-block m-t-5" onClick="CategoryCreate();">Створити</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Редагування категорії -->

<div class="modal fade stick-up" id="edit-category-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header clearfix text-left">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
                </button>
                <h5><span class="semi-bold">Редагування категорії</span></h5>
            </div>
            <div class="modal-body">
                <form role="form" id="save-category">
                    <ul class="nav nav-tabs" style="margin-bottom: 15px;">
                        <li class="active"><a href="#first-tab-content-Category" data-toggle="tab"></a></li>
                        <li><a href="#second-tab-content-Category-UA" data-toggle="tab">UA</a></li>
                        <li><a href="#last-tab-content-Category-EN" data-toggle="tab">EN</a></li>
                    </ul>

                    <div class="tab-content" style="width: 100%; padding: 0;">
                        <div id="first-tab-content-Category" class="tab-pane fade  in active">
                            <div class="form-group-attached">
                                <input type="hidden" id="EditCategoryID" name="EditCategoryID">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group form-group-default">
                                            <label>Назва</label>
                                            <input type="text" id="EditCategoryName" name="EditCategoryName" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-8">
                                        <div class="form-group form-group-default">
                                            <label>Опис</label>
                                            <textarea id="EditCategoryDescription" name="EditCategoryDescription" class="form-control"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group form-group-default">
                                            <label>Статус</label>
                                            <select name="EditCategoryActive" class="form-control">
                                                <option id="EditCategoryActive" selected></option>
                                                <option disabled>-----</option>
                                                <option value="Yes">Активна</option>
                                                <option value="No">Вимкнена</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="second-tab-content-Category-UA" class="tab-pane fade">
                            <div class="form-group-attached">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group form-group-default">
                                            <label>Назва</label>
                                            <input type="text" id="EditCategoryNameUA" name="EditCategoryNameUA" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-8">
                                        <div class="form-group form-group-default">
                                            <label>Опис</label>
                                            <textarea id="EditCategoryDescriptionUA" name="EditCategoryDescriptionUA" class="form-control"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="last-tab-content-Category-EN" class="tab-pane fade">
                            <div class="form-group-attached">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group form-group-default">
                                            <label>Назва</label>
                                            <input type="text" id="EditCategoryNameEN" name="EditCategoryNameEN" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-8">
                                        <div class="form-group form-group-default">
                                            <label>Опис</label>
                                            <textarea id="EditCategoryDescriptionEN" name="EditCategoryDescriptionEN" class="form-control"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4 m-t-10 sm-m-t-10">
                            <button type="button" class="btn btn-primary btn-block m-t-5" onClick="CategorySave();">Зберегти</button>
                        </div>
                        <div class="col-sm-4 m-t-10 sm-m-t-10">
                            <button type="button" class="btn btn-danger btn-block m-t-5" onClick="CategoryDelete();">Видалити</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Створення послуги -->

<div class="modal fade stick-up" id="create-service-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header clearfix text-left">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
                </button>
                <h5><span class="semi-bold">Створення послуги</span></h5>
            </div>
            <div class="modal-body">
                <form role="form" id="create-service">
                    <ul class="nav nav-tabs" style="margin-bottom: 15px;">
                        <li class="active"><a href="#first-tab-content-RU" data-toggle="tab"></a></li>
                        <li><a href="#second-tab-content-UA" data-toggle="tab">UA</a></li>
                        <li><a href="#last-tab-content-EN" data-toggle="tab">EN</a></li>
                    </ul>

                    <div class="tab-content" style="width: 100%; padding: 0;">
                        <div id="first-tab-content-RU" class="tab-pane fade in active">
                            <div class="form-group-attached">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group form-group-default">
                                            <label>Назва</label>
                                            <input type="text" placeholder="Facebook Likes [Instant]" id="ServiceName" name="ServiceName" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-8">
                                        <div class="form-group form-group-default">
                                            <label>Опис</label>
                                            <textarea rows="15" placeholder="High quality likes, instant delivery." id="ServiceDescription" name="ServiceDescription" class="form-control"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group form-group-default">
                                            <label>Категорія</label>
                                            <select class="form-control" name="ServiceCategoryID">
                                                <?php
                                                $stmt = $pdo->prepare('SELECT * FROM categories WHERE CategoryActive = "Yes" ORDER BY sort DESC');
                                                $stmt->execute();

                                                foreach ($stmt->fetchAll() as $row) {
                                                    echo '<option value="' . $row['CategoryID'] . '">' . $row['CategoryName'] . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group form-group-default">
                                            <div id="service-api-input">
                                                <button type="button" onClick="addAPI();" class="pull-right btn btn-info">Додати API</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group form-group-default">
                                            <div id="service-order-api-input">
                                                <button type="button" onClick="addOrderAPI();" class="pull-right btn btn-info">Додати чек-статус API</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group form-group-default">
                                            <label>Мінімум</label>
                                            <input type="text" placeholder="300" id="ServiceMinQuantity" name="ServiceMinQuantity" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group form-group-default">
                                            <label>Максимум</label>
                                            <input type="number" placeholder="5000" id="ServiceMaxQuantity" name="ServiceMaxQuantity" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group form-group-default">
                                            <label>Тип</label>
                                            <select name="ServiceType" class="form-control">
                                                <option value="default">Default</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group form-group-default">
                                            <label>Ціна</label>
                                            <input type="text" placeholder="0.99" id="ServicePrice" name="ServicePrice" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group form-group-default">
                                            <label>Ціна реселлеру</label>
                                            <input type="number" placeholder="0.49" id="ServiceResellerPrice" name="ServiceResellerPrice" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group form-group-default">
                                            <label>Статус</label>
                                            <select name="ServiceActive" class="form-control">
                                                <option value="Yes">Активна</option>
                                                <option value="No">Вимкнена</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-5">
                                        <div class="form-group form-group-default">
                                            <label>Скасування послуги</label>
                                            <select name="ServiceCancel" class="form-control">
                                                <option value="" disabled selected>Виберіть опцію</option>
                                                <option disabled>-----</option>
                                                <option value="Yes">Так</option>
                                                <option value="No">Ні</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group form-group-default">
                                            <label>Refill</label>
                                            <select name="ServiceRefill" class="form-control">
                                                 <option value="" disabled selected>Виберіть опцію</option>
                                                <option disabled>-----</option>
                                                <option value="Yes">Так</option>
                                                <option value="No">Ні</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-5">
                                        <div class="form-group form-group-default">
                                            <label>Термін refill (днів)</label>
                                            <input type="number" placeholder="30" id="ServiceRefillDuration" name="ServiceRefillDuration" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="second-tab-content-UA" class="tab-pane fade">
                            <div class="form-group-attached">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group form-group-default">
                                            <label>Назва</label>
                                            <input type="text" placeholder="Facebook Likes [Instant]" id="ServiceNameUA" name="ServiceNameUA" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-8">
                                        <div class="form-group form-group-default">
                                            <label>Опис</label>
                                            <textarea rows="15" placeholder="High quality likes, instant delivery." id="ServiceDescriptionUA" name="ServiceDescriptionUA" class="form-control"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="last-tab-content-EN" class="tab-pane fade">
                            <div class="form-group-attached">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group form-group-default">
                                            <label>Назва</label>
                                            <input type="text" placeholder="Facebook Likes [Instant]" id="ServiceNameEN" name="ServiceNameEN" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-8">
                                        <div class="form-group form-group-default">
                                            <label>Опис</label>
                                            <textarea rows="15" placeholder="High quality likes, instant delivery." id="ServiceDescriptionEN" name="ServiceDescriptionEN" class="form-control"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4 m-t-10 sm-m-t-10">
                            <button type="button" class="btn btn-primary btn-block m-t-5" onClick="ServiceCreate();">Створити</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Редагування послуги -->

<div class="modal fade stick-up" id="edit-service-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header clearfix text-left">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
                </button>
                <h5><span class="semi-bold">Редагування послуги</span></h5>
            </div>
            <div class="modal-body">
                <form role="form" id="save-service">
                    <ul class="nav nav-tabs" style="margin-bottom: 15px;">
                        <li class="active"><a href="#first-tab-edit-service" data-toggle="tab"></a></li>
                        <li><a href="#second-tab-edit-serviceUA" data-toggle="tab">UA</a></li>
                        <li><a href="#last-tab-edit-serviceEN" data-toggle="tab">EN</a></li>
                    </ul>

                    <div class="tab-content" style="width: 100%; padding: 0;">
                        <div id="first-tab-edit-service" class="tab-pane fade in active">
                            <div class="form-group-attached">
                                <input type="hidden" name="EditServiceID" id="EditServiceID">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group form-group-default">
                                            <label>Назва</label>
                                            <input type="text" placeholder="Facebook Likes [Instant]" id="EditServiceName" name="EditServiceName" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-8">
                                        <div class="form-group form-group-default">
                                            <label>Опис</label>
                                            <textarea rows="15" placeholder="High quality likes, instant delivery." id="EditServiceDescription" name="EditServiceDescription" class="form-control"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group form-group-default">
                                            <label>Категорія</label>
                                            <select class="form-control" name="EditServiceCategoryID">
                                                <option id="EditServiceCategoryID" selected></option>
                                                <option disabled>-----</option>
                                                <?php
                                                $stmt = $pdo->prepare('SELECT * FROM categories WHERE CategoryActive = "Yes" ORDER BY sort DESC');
                                                $stmt->execute();

                                                foreach ($stmt->fetchAll() as $row) {
                                                    echo '<option value="' . $row['CategoryID'] . '">' . $row['CategoryName'] . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group form-group-default">
                                            <label>API</label>
                                            <input type="text" placeholder="http://reseller.com/api/v2/?key=your_key&action=add&service=service_id&quantity=[QUANTITY]&link=[LINK]" id="EditServiceAPI" name="EditServiceAPI" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group form-group-default">
                                            <label>Чек-статус API</label>
                                            <input type="text" placeholder="http://reseller.com/api/v2?key=your_key&action=status&order=[OrderID]" id="EditServiceOrderAPI" name="EditServiceOrderAPI" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group form-group-default">
                                            <label>Мінімум</label>
                                            <input type="text" placeholder="300" id="EditServiceMinQuantity" name="EditServiceMinQuantity" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group form-group-default">
                                            <label>Максимум</label>
                                            <input type="number" placeholder="5000" id="EditServiceMaxQuantity" name="EditServiceMaxQuantity" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group form-group-default">
                                            <label>Тип</label>
                                            <select name="EditServiceType" class="form-control">
                                                <option id="EditServiceType" selected></option>
                                                <option disabled>-----</option>
                                                <option value="default">Default</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group form-group-default">
                                            <label>Ціна</label>
                                            <input type="text" placeholder="0.99" id="EditServicePrice" name="EditServicePrice" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group form-group-default">
                                            <label>Ціна реселлеру</label>
                                            <input type="text" placeholder="0.49" inputmode="numeric" pattern="[-+]?[0-9]*[.,]?[0-9]+" id="EditServiceResellerPrice" name="EditServiceResellerPrice" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group form-group-default">
                                            <label>Статус</label>
                                            <select name="EditServiceActive" class="form-control">
                                                <option id="EditServiceActive" selected></option>
                                                <option disabled>-----</option>
                                                <option value="Yes">Активна</option>
                                                <option value="No">Вимкнена</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-5">
                                        <div class="form-group form-group-default">
                                            <label>Скасування послуги</label>
                                            <select name="EditServiceCancel" class="form-control">
                                                <option id="EditServiceCancel" selected></option>
                                                <option disabled>-----</option>
                                                <option value="Yes">Так</option>
                                                <option value="No">Ні</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group form-group-default">
                                            <label>Refill</label>
                                            <select name="EditServiceRefill" class="form-control">
                                                <option id="EditServiceRefill" selected></option>
                                                <option disabled>-----</option>
                                                <option value="Yes">Так</option>
                                                <option value="No">Ні</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-5">
                                        <div class="form-group form-group-default">
                                            <label>Термін refill (днів)</label>
                                            <input type="number" placeholder="30" id="EditServiceRefillDuration" name="EditServiceRefillDuration" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="second-tab-edit-serviceUA" class="tab-pane fade">
                            <div class="form-group-attached">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group form-group-default">
                                            <label>Назва</label>
                                            <input type="text" placeholder="Facebook Likes [Instant]" id="EditServiceNameUA" name="EditServiceNameUA" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-8">
                                        <div class="form-group form-group-default">
                                            <label>Опис</label>
                                            <textarea rows="15" placeholder="High quality likes, instant delivery." id="EditServiceDescriptionUA" name="EditServiceDescriptionUA" class="form-control"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="last-tab-edit-serviceEN" class="tab-pane fade">
                            <div class="form-group-attached">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group form-group-default">
                                            <label>Назва</label>
                                            <input type="text" placeholder="Facebook Likes [Instant]" id="EditServiceNameEN" name="EditServiceNameEN" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-8">
                                        <div class="form-group form-group-default">
                                            <label>Опис</label>
                                            <textarea rows="15" placeholder="High quality likes, instant delivery." id="EditServiceDescriptionEN" name="EditServiceDescriptionEN" class="form-control"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4 m-t-10 sm-m-t-10">
                            <button type="button" class="btn btn-primary btn-block m-t-5" onClick="ServiceSave();">Зберегти</button>
                        </div>
                        <div class="col-sm-4 m-t-10 sm-m-t-10">
                            <button type="button" class="btn btn-danger btn-block m-t-5" onClick="ServiceDelete();">Видалити</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Створення користувача -->

<div class="modal fade stick-up" id="add-user-modal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header clearfix text-left">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
				</button>
				<h5><span class="semi-bold">Створення користувача</span></h5>
			</div>
			<div class="modal-body">
				<form role="form" id="add-user">
					<div class="form-group-attached">
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group form-group-default">
									<label>Логін</label>
									<input type="text" id="UserName" name="UserName" class="form-control">
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group form-group-default">
									<label>Email</label>
									<input type="email" id="UserEmail" name="UserEmail" class="form-control">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-3">
								<div class="form-group form-group-default">
									<label>Група</label>
									<input type="text" id="UserGroup" name="UserGroup" class="form-control">
								</div>
							</div>
							<div class="col-sm-9">
								<div class="form-group form-group-default">
									<label>API ключ</label>
									<input type="text" id="UserAPI" name="UserAPIsx" class="form-control">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-3">
								<div class="form-group form-group-default">
									<label>Баланс</label>
									<input type="number" id="UserBalance" name="UserBalance" class="form-control">
								</div>
							</div>
							<div class="col-sm-9">
								<div class="form-group form-group-default">
									<label>IP</label>
									<input type="text" id="UserAPI" name="UserAPIsx" class="form-control">
								</div>
							</div>
						</div>
					</div>
				</form>
				<div class="row">
					<div class="col-sm-4 m-t-10 sm-m-t-10">
						<button type="button" class="btn btn-primary btn-block m-t-5" onClick="UserCreate();">Створити</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Редагування користувача -->

<div class="modal fade stick-up" id="edit-user-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header clearfix text-left">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
                </button>
                <h5><span class="semi-bold">Редагування користувача</span></h5>
            </div>
            <div class="modal-body">
                <form role="form" id="save-user">
                    <div class="form-group-attached">
                        <input type="hidden" name="EditUserID" id="EditUserID">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group form-group-default">
                                    <label>Логін</label>
                                    <input type="text" placeholder="Preferred User Name" id="EditUserName" name="EditUserName" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <div class="form-group form-group-default">
                                    <label>Email</label>
                                    <textarea rows="15" placeholder="some_email@googlemail.com" id="EditUserEmail" name="EditUserEmail" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group form-group-default">
                                    <label>Група</label>
                                    <select class="form-control" name="EditUserGroup">
                                        <option id="EditUserGroup" selected></option>
                                        <option disabled>-----</option>
                                        <option value="user">User</option>
                                        <option value="administrator">Administrator</option>
                                        <option value="reseller">Reseller</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group form-group-default">
                                    <label>API ключ</label>
                                    <input type="text" placeholder="da0a9sdijn12end09asijdasas9duij1" id="EditUserAPI" name="EditUserAPI" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group form-group-default">
                                    <label>Баланс</label>
                                    <input type="number" placeholder="150" id="EditUserBalance" name="EditUserBalance" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group form-group-default">
                                    <label>Telegram</label>
                                    <input type="text" placeholder="@" id="EditUserTelegram" name="EditUserTelegram" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4 m-t-10 sm-m-t-10">
                            <button type="button" class="btn btn-primary btn-block m-t-5" onClick="UserSave();">Зберегти</button>
                        </div>
                    </div>
                    <hr>
                    <h2>Бан</h2>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group form-group-default">
                                <label>Час (0 - назавжди)</label>
                                <input type="text" placeholder="15/05/2032" id="EditUserBanExpireDate" name="EditUserBanExpireDate" class="form-control">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group form-group-default">
                                <label>Причина</label>
                                <textarea placeholder="User was rude." id="EditUserBanReason" name="EditUserBanReason" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="col-sm-4 m-t-10 sm-m-t-10">
                            <button type="button" class="btn btn-warning btn-block m-t-5" onClick="UserBan();">Заблокувати</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Створення користувача -->

<div class="modal fade stick-up" id="create-user-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header clearfix text-left">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
                </button>
                <h5><span class="semi-bold">Створення користувача</span></h5>
            </div>
            <div class="modal-body">
                <form role="form" id="create-user">
                    <div class="form-group-attached">
                        <input type="hidden" name="EditUserID" id="EditUserID">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group form-group-default">
                                    <label>Логін</label>
                                    <input type="text" placeholder="Preferred User Name" id="UserName" name="UserName" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <div class="form-group form-group-default">
                                    <label>Email</label>
                                    <textarea rows="15" placeholder="some_email@googlemail.com" id="UserEmail" name="UserEmail" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group form-group-default">
                                    <label>Пароль</label>
                                    <input type="password" placeholder="****" id="UserPassword" name="UserPassword" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group form-group-default">
                                    <label>Повторіть пароль</label>
                                    <input type="password" placeholder="****" id="UserRetypePassword" name="UserRetypePassword" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group form-group-default">
                                    <label>Група</label>
                                    <select class="form-control" name="UserGroup">
                                        <option value="user">User</option>
                                        <option value="administrator">Administrator</option>
                                        <option value="reseller">Reseller</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group form-group-default">
                                    <label>API ключ</label>
                                    <input type="text" value="<?php echo md5(time() . 'hash$' . rand(3, 3000)); ?>" placeholder="da0a9sdijn12end09asijdasas9duij1" id="UserAPI" name="UserAPI" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group form-group-default">
                                    <label>Баланс</label>
                                    <input type="number" placeholder="150" id="UserBalance" name="UserBalance" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4 m-t-10 sm-m-t-10">
                            <button type="button" class="btn btn-success btn-block m-t-5" onClick="UserCreate();">Створити</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Редагування коментарів -->

<div class="modal fade stick-up" id="add-otzyv-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header clearfix text-left">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i></button>
                <h5><span class="semi-bold">Створення відгуку</span></h5>
            </div>
            <div class="modal-body">
                <form role="form" id="add-otzyv">
                    <div class="form-group-attached">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group form-group-default">
                                    <label>Ім'я</label>
                                    <input type="text" id="comments-name" name="comments-name" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group form-group-default">
                                    <label>Відгук</label>
                                    <input type="text" id="comments-title" name="comments-title" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group form-group-default" style="display: none;">
                                <label>Відповідь</label>
                                <input value="<span class='fa fa-star'></span> <span class='fa fa-star'></span> <span class='fa fa-star'></span> <span class='fa fa-star'></span> <span class='fa fa-star'></span>" type="text" id="comments-answer" name="comments-answer" class="form-control">
                            </div>
                        </div>
                    </div>
                </form>
                <div class="row">
					<div class="col-sm-4 m-t-10 sm-m-t-10">
						<button type="button" class="btn btn-primary btn-block m-t-5" onClick="OtzyvCreate();">Створити</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade stick-up" id="add-otzyv-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header clearfix text-left">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i></button>
                <h5><span class="semi-bold">Створення відгуку</span></h5>
            </div>
            <div class="modal-body">
                <form role="form" id="add-otzyv">
                    <div class="form-group-attached">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group form-group-default">
                                    <label>Ім'я</label>
                                    <input type="text" id="comments-name" name="comments-name" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group form-group-default">
                                    <label>Відгук</label>
                                    <input type="text" id="comments-title" name="comments-title" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group form-group-default" style="display: none;">
                                <label>Відповідь</label>
                                <input value="<span class='fa fa-star'></span> <span class='fa fa-star'></span> <span class='fa fa-star'></span> <span class='fa fa-star'></span> <span class='fa fa-star'></span>" type="text" id="comments-answer" name="comments-answer" class="form-control">
                            </div>
                        </div>
                    </div>
                </form>
                <div class="row">
					<div class="col-sm-4 m-t-10 sm-m-t-10">
						<button type="button" class="btn btn-primary btn-block m-t-5" onClick="OtzyvCreate();">Створити</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade stick-up" id="edit-otzyv-modal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header clearfix text-left">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
				</button>
				<h5><span class="semi-bold">Редагування відгуку</span></h5>
			</div>
			<div class="modal-body">
				<form role="form" id="save-otzyv">
					<div class="form-group-attached">
						<input type="hidden" id="edit-comments-id" name="edit-comments-id">
						<div class="row">
							<div class="col-sm-12">
								<div class="form-group form-group-default">
									<label>Ім'я</label>
									<input type="text" id="edit-comments-name" name="edit-comments-name" class="form-control">
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-12">
								<div class="form-group form-group-default">
									<label>Відгук</label>
									<textarea rows="7" cols="7" style="width: 100%; height: auto;" id="edit-comments-title" name="edit-comments-title" class="form-control"> </textarea>
								</div>
							</div>
						</div>


						<div class="form-group form-group-default">
							<label>Зірки</label>

							<select class="form-control" name="edit-comments-active">
								<option id="edit-comments-active" selected></option>
								<option disabled>-----</option>
								<?php
								$stmt = $pdo->prepare('SELECT * FROM comments_option WHERE id = id');
								$stmt->execute();

								foreach ($stmt->fetchAll() as $row) {
									echo '<option value="' . $row['option_value'] . '">' . $row['option_number'] . '</option>';
								}
								?>
							</select>
						</div>

						<div style="display: none;" class="row">
							<div class="col-sm-12">
								<div class="form-group form-group-default">
									<label>Відповідь</label>
									<input value="0" type="text" id="edit-commentsAdd-answer" name="edit-commentsAdd-answer" class="form-control">
								</div>
							</div>
						</div>
					</div>
				</form>
				<div class="row">
					<div class="col-sm-4 m-t-10 sm-m-t-10">
						<button type="button" class="btn btn-primary btn-block m-t-5" onClick="OtzyvAddSave();">Зберегти</button>
					</div>
					<div class="col-sm-4 m-t-10 sm-m-t-10">
						<button type="button" class="btn btn-danger btn-block m-t-5" onClick="OtzyvAddDelete();">Видалити</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Edit LiqPay -->
<div class="modal fade stick-up" id="changeLiqpay-modal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header clearfix text-left">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
				</button>
				<h5><span class="semi-bold">Зміна налаштувань LiqPay</h5>
			</div>
			<div class="modal-body">
					<div class="form-group-attached">
						<div class="row">
							<div class="col-sm-12">
								<div class="form-group form-group-default">
									<label>LiqPay private</label>
									<input type="text" id="liqpay_private" name="private" value="<?php echo $liqpay_private; ?>" class="form-control" placeholder="LiqPay Private">
								</div>
							</div>
						</div>

						<div style="" class="row">
							<div class="col-sm-6">
								<div class="form-group form-group-default">
									<label>LiqPay public</label>
									<input type="text" id="liqpay_public" name="public" value="<?php echo $liqpay_public; ?>" class="form-control" placeholder="LiqPay Public">
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group form-group-default" style="border-right-color:  rgba(0, 0, 0, 0.07);">
									<label>Бонус</label>
									<input type="text" id="liqpay_bonus" name="bonus" value="0" class="form-control form_percentage" placeholder="Бонус (%)">
								</div>
							</div>

							<div class="col-sm-12">
								<div class="form-group form-group-default">
									<label>Комісія поповнення</label>
									<input type="text" id="liqpay_comission" name="comission" value="<?php echo $liqpay_comission; ?>" class="form-control form_percentage" placeholder="Комісія (%)">
								</div>
							</div>
                        </div>
			    	<div class="row">
							<div class="col-sm-12">
								<div class="form-group form-group-default">
									<label style="color:red" id="liqpay_result"></label>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-4 m-t-10 sm-m-t-10">
							<button type="button" class="btn btn-primary btn-block m-t-5" onclick="save_liqpay_settings()">Зберегти</button>
						</div>
					</div>
			</div>
		</div>
	</div>
</div>

<!-- Редагування Payeer -->
<div class="modal fade stick-up" id="changePayeer-modal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header clearfix text-left">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i></button>
				<h5><span class="semi-bold">Зміна налаштувань Payeer</span></h5>
			</div>
			<div class="modal-body">
				<div class="form-group-attached">
					<div class="row">
						<div class="col-sm-12">
							<div class="form-group form-group-default">
								<label>Merchant ID</label>
								<input type="text" id="payeer_merchant_id" name="merchant_id" value="<?=htmlspecialchars($payeer['merchant_id'])?>" class="form-control" placeholder="Merchant ID">
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-sm-6">
							<div class="form-group form-group-default">
								<label>Secret Key</label>
								<input type="text" id="payeer_secret_key" name="secret_key" value="<?=htmlspecialchars($payeer['secret_key'])?>" class="form-control" placeholder="Secret Key">
							</div>
						</div>

						<div class="col-sm-6">
							<div class="form-group form-group-default" style="border-right-color:  rgba(0, 0, 0, 0.07);">
									<label>Бонус</label>
									<input type="text" id="payeer_bonus" name="bonus" value="<?=htmlspecialchars($payeer['bonus'])?>" class="form-control form_percentage" placeholder="Бонус (%)">
							</div>
						</div>

						<div class="col-sm-12">
							<div class="form-group form-group-default">
								<label>Комісія поповнення (%)</label>
								<input type="text" id="payeer_commission" name="commission" value="<?=htmlspecialchars($payeer['commission'])?>" class="form-control form_percentage" placeholder="Комісія (%)">
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-sm-12">
							<div class="form-group form-group-default">
								<label style="color:red" id="payeer_result"></label>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4 m-t-10 sm-m-t-10">
						<button type="button" class="btn btn-primary btn-block m-t-5" onclick="save_payeer_settings()">Зберегти</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Створення НОВИНИ -->
<div class="modal fade stick-up" id="add-News-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header clearfix text-left">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
                </button>
                <h5><span class="semi-bold">Створення новини</span></h5>
            </div>
            <div class="modal-body">
                <form role="form" id="add-News">
                    <ul class="nav nav-tabs" style="margin-bottom: 15px;">
                        <li class="active"><a href="#first-tab-add-News" data-toggle="tab"></a></li>
                        <li><a href="#second-tab-add-NewsUA" data-toggle="tab">UA</a></li>
                        <li><a href="#last-tab-add-NewsEN" data-toggle="tab">EN</a></li>
                    </ul>
                    <div class="tab-content" style="width: 100%; padding: 0;">
                        <div id="first-tab-add-News" class="tab-pane fade in active">
                            <div class="form-group-attached">
                                <div class="form-group form-group-default">
                                    <label>Заголовок</label>
                                    <textarea rows="5" id="NEWSQuestion" name="NEWSQuestion" class="form-control"></textarea>
                                </div>
                                <div class="form-group form-group-default">
                                    <label>Новина</label>
                                    <textarea rows="5" id="NEWSAnswer" name="NEWSAnswer" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                        <div id="second-tab-add-NewsUA" class="tab-pane fade">
                            <div class="form-group-attached">
                                <div class="form-group form-group-default">
                                    <label>Заголовок</label>
                                    <textarea rows="5" id="NEWSQuestionUA" name="NEWSQuestionUA" class="form-control"></textarea>
                                </div>
                                <div class="form-group form-group-default">
                                    <label>Новина</label>
                                    <textarea rows="5" id="NEWSAnswerUA" name="NEWSAnswerUA" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                        <div id="last-tab-add-NewsEN" class="tab-pane fade">
                            <div class="form-group-attached">
                                <div class="form-group form-group-default">
                                    <label>Заголовок</label>
                                    <textarea rows="5" id="NEWSQuestionEN" name="NEWSQuestionEN" class="form-control"></textarea>
                                </div>
                                <div class="form-group form-group-default">
                                    <label>Новина</label>
                                    <textarea rows="5" id="NEWSAnswerEN" name="NEWSAnswerEN" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4 m-t-10 sm-m-t-10">
                            <button type="button" class="btn btn-primary btn-block m-t-5" onClick="NEWSCreate();">Створити</button>
                        </div>
                        <div class="col-sm-4 m-t-10 sm-m-t-10">
                            <div class="form-group form-group-default">
                                <input type="checkbox" name="specshow" id="specshow" value="1" /> основна
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade stick-up" id="edit-News-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header clearfix text-left">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
                </button>
                <h5><span class="semi-bold">Редагування новини</span></h5>
            </div>
            <div class="modal-body">
                <form role="form" id="save-News">
                    <ul class="nav nav-tabs" style="margin-bottom: 15px;">
                        <li class="active"><a href="#first-tab-edit-News" data-toggle="tab"></a></li>
                        <li><a href="#second-tab-edit-NewsUA" data-toggle="tab">UA</a></li>
                        <li><a href="#last-tab-edit-NewsEN" data-toggle="tab">EN</a></li>
                    </ul>
                    <div class="tab-content" style="width: 100%; padding: 0;">
                        <div id="first-tab-edit-News" class="tab-pane fade in active">
                            <div class="form-group-attached">
                                <input type="hidden" id="EditNEWSID" name="EditNEWSID">
                                <div class="form-group form-group-default">
                                    <label>Заголовок</label>
                                    <textarea rows="15" id="EditNEWSQuestion" name="EditNEWSQuestion" class="form-control"></textarea>
                                </div>
                                <div class="form-group form-group-default">
                                    <label>Новина</label>
                                    <textarea rows="5" id="EditNEWSAnswer" name="EditNEWSAnswer" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                        <div id="second-tab-edit-NewsUA" class="tab-pane fade">
                            <div class="form-group-attached">
                                <div class="form-group form-group-default">
                                    <label>Заголовок</label>
                                    <textarea rows="15" id="EditNEWSQuestionUA" name="EditNEWSQuestionUA" class="form-control"></textarea>
                                </div>
                                <div class="form-group form-group-default">
                                    <label>Новина</label>
                                    <textarea rows="5" id="EditNEWSAnswerUA" name="EditNEWSAnswerUA" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                        <div id="last-tab-edit-NewsEN" class="tab-pane fade">
                            <div class="form-group-attached">
                                <div class="form-group form-group-default">
                                    <label>Заголовок</label>
                                    <textarea rows="15" id="EditNEWSQuestionEN" name="EditNEWSQuestionEN" class="form-control"></textarea>
                                </div>
                                <div class="form-group form-group-default">
                                    <label>Новина</label>
                                    <textarea rows="5" id="EditNEWSAnswerEN" name="EditNEWSAnswerEN" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4 m-t-10 sm-m-t-10">
                            <button type="button" class="btn btn-primary btn-block m-t-5" onClick="NEWSSave();">Зберегти</button>
                        </div>
                        <div class="col-sm-4 m-t-10 sm-m-t-10">
                            <button type="button" class="btn btn-danger btn-block m-t-5" onClick="NEWSDelete();">Видалити</button>
                        </div>
                        <div class="col-sm-4 m-t-10 sm-m-t-10">
                            <div class="form-group form-group-default">
                                <input type="checkbox" name="editspecshow" id="editspecshow" value="1" /> основна
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Редагування НОВИНИ -->
<div class="modal fade stick-up" id="add-update-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header clearfix text-left">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
                </button>
                <h5><span class="semi-bold">Створення оновлення</span></h5>
            </div>
            <div class="modal-body">
                <form role="form" id="add-update">
                    <ul class="nav nav-tabs" style="margin-bottom: 15px;">
                        <li class="active"><a href="#first-tab-add-update" data-toggle="tab"></a></li>
                        <li><a href="#second-tab-add-updateUA" data-toggle="tab">UA</a></li>
                        <li><a href="#last-tab-add-updateEN" data-toggle="tab">EN</a></li>
                    </ul>
                    <div class="tab-content" style="width: 100%; padding: 0;">
                        <div id="first-tab-add-update" class="tab-pane fade in active">
                            <div class="form-group-attached">
                                <div class="form-group form-group-default">
                                    <label>Послуга</label>
                                    <input type="text" id="update-create-service" name="update-create-service" class="form-control">
                                </div>
                                <div class="form-group form-group-default">
                                    <label>Зміни</label>
                                    <input type="text" id="update-create-changes" name="update-create-changes" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div id="second-tab-add-updateUA" class="tab-pane fade">
                            <div class="form-group-attached">
                                <div class="form-group form-group-default">
                                    <label>Послуга</label>
                                    <input type="text" id="update-create-serviceUA" name="update-create-serviceUA" class="form-control">
                                </div>
                                <div class="form-group form-group-default">
                                    <label>Зміни</label>
                                    <input type="text" id="update-create-changesUA" name="update-create-changesUA" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div id="last-tab-add-updateEN" class="tab-pane fade">
                            <div class="form-group-attached">
                                <div class="form-group form-group-default">
                                    <label>Послуга</label>
                                    <input type="text" id="update-create-serviceEN" name="update-create-serviceEN" class="form-control">
                                </div>
                                <div class="form-group form-group-default">
                                    <label>Зміни</label>
                                    <input type="text" id="update-create-changesEN" name="update-create-changesEN" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="row">
                    <div class="col-sm-4 m-t-10 sm-m-t-10">
                        <button type="button" class="btn btn-primary btn-block m-t-5" onClick="update_create();">Створити</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade stick-up" id="edit-update-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header clearfix text-left">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
                </button>
                <h5><span class="semi-bold">Редагування оновлення</span></h5>
            </div>
            <div class="modal-body">
                <form role="form" id="save-update">
                    <ul class="nav nav-tabs" style="margin-bottom: 15px;">
                        <li class="active"><a href="#first-tab-edit-update" data-toggle="tab"></a></li>
                        <li><a href="#second-tab-edit-updateUA" data-toggle="tab">UA</a></li>
                        <li><a href="#last-tab-edit-updateEN" data-toggle="tab">EN</a></li>
                    </ul>
                    <div class="tab-content" style="width: 100%; padding: 0;">
                        <div id="first-tab-edit-update" class="tab-pane fade in active">
                            <div class="form-group-attached">
                                <input type="hidden" id="update-edit-id" name="update-edit-id">
                                <div class="form-group form-group-default">
                                    <label>Послуга</label>
                                    <input type="text" id="update-edit-service" name="update-edit-service" class="form-control">
                                </div>
                                <div class="form-group form-group-default">
                                    <label>Зміни</label>
                                    <input type="text" id="update-edit-changes" name="update-edit-changes" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div id="second-tab-edit-updateUA" class="tab-pane fade">
                            <div class="form-group-attached">
                                <div class="form-group form-group-default">
                                    <label>Послуга</label>
                                    <input type="text" id="update-edit-serviceUA" name="update-edit-serviceUA" class="form-control">
                                </div>
                                <div class="form-group form-group-default">
                                    <label>Зміни</label>
                                    <input type="text" id="update-edit-changesUA" name="update-edit-changesUA" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div id="last-tab-edit-updateEN" class="tab-pane fade">
                            <div class="form-group-attached">
                                <div class="form-group form-group-default">
                                    <label>Послуга</label>
                                    <input type="text" id="update-edit-serviceEN" name="update-edit-serviceEN" class="form-control">
                                </div>
                                <div class="form-group form-group-default">
                                    <label>Зміни</label>
                                    <input type="text" id="update-edit-changesEN" name="update-edit-changesEN" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="row">
                    <div class="col-sm-4 m-t-10 sm-m-t-10">
                        <button type="button" class="btn btn-primary btn-block m-t-5" onClick="update_save();">Зберегти</button>
                    </div>
                    <div class="col-sm-4 m-t-10 sm-m-t-10">
                        <button type="button" class="btn btn-danger btn-block m-t-5" onClick="update_delete();">Видалити</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
(function($) {
    // Функція для обробки вводу відсотків для заданого селектора
    function setupPercentageInput(selector) {
        $(selector + ' .form_percentage').on('focusin', function () {
            let val = $(this).val().toString().trim();
            if (val.endsWith('%')) {
                val = val.slice(0, -1);
            }
            let val_clear = parseFloat(val.replace(',', '.'));
            if (isNaN(val_clear)) {
                $(this).val('');
            } else {
                $(this).val(val_clear);
            }
        }).on('focusout', function () {
            let val = $(this).val().toString().trim();
            let val_clear = parseFloat(val.replace(',', '.'));
            if (isNaN(val_clear) || val_clear === '') {
                val_clear = 0;
            }
            $(this).val(val_clear + '%');
        });
    }

    // Ініціалізація для обох модальних вікон LiqPay і Payeer
    setupPercentageInput('#changeLiqpay-modal');
    setupPercentageInput('#changePayeer-modal');
})(jQuery);
</script>