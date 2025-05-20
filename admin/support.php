<?php
require_once('files/header.php');
?>

<style>
    html {
        overflow-y: visible !important;
        -ms-overflow-style: visible !important;
    }

    [v-cloak] {
        display: none;
    }

    .category-button {
        border: 2px solid black;
        border-radius: 24px;
        padding: 8px;
        margin: 8px;
        display: block;
        float: left;
        position: relative;
        z-index: 10;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
    }

    .swe a {
        text-decoration: none;
    }

    .category-button:hover {
        background-color: rgba(0, 0, 0, 0.7);
        color: #fff;
    }

    #app .panel {
        margin-bottom: 0px;
        background-color: #fff;
        border: 1px solid transparent;
        border-top-color: transparent;
        border-right-color: transparent;
        border-bottom-color: transparent;
        border-left-color: transparent;
        border-radius: 4px;
        -webkit-box-shadow: 0 1px 1px rgba(0, 0, 0, .05);
        box-shadow: 0 1px 1px rgba(0, 0, 0, .05);
    }

    #app .panel-default {
        border-color: #ddd;
    }

    #app .panel-body {
        padding: 15px;
    }

    #app h3 span {
        margin-right: 10px;
    }

    #app h3 span.active,
    #app h3 span.active:hover {
        color: #337ab7;
        font-weight: 600;
        text-decoration: none;
        cursor: text;
    }

    #app h3 span:hover {
        color: #48b0f7;
        text-decoration: underline;
        cursor: pointer;
    }

    #app h4 span {
        margin-right: 10px;
    }

    #app h4 span.active,
    #app h4 span.active:hover {
        color: #337ab7;
        font-weight: 600;
        text-decoration: none;
        cursor: text;
    }

    #app h4 span:hover {
        color: #48b0f7;
        text-decoration: underline;
        cursor: pointer;
    }

    .btn-success[disabled] {
        background-color: gray;
        color: black;
        border-color: gray;
    }

    .comment_row {
        font-size: 14px;
        padding: 11px 8px;
    }

    .comment_row:hover {
        background-color: #f7f7f7;
    }

    .btn_create_ticket {
        margin-top: 22px;
        margin-bottom: 14px;
        text-decoration: none;
    }

    .btn_create_ticket:hover {
        text-decoration: none;
    }

    .panel {
        font-size: 14px;
        padding: 8px 13px;
        margin-bottom: 0;
    }

    .btn_next_page {
        background: white;
        color: black;
        border-color: black;
        border-width: 1px;
        margin-top: 29px;
    }

    .btn_next_page:hover {
        background: rgba(34, 34, 34, .9);
        color: white;
    }

    .btn_next_page.btn_next_page_loading {
        background-image: -webkit-linear-gradient(45deg, rgba(255, 255, 255, .15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, .15) 50%, rgba(255, 255, 255, .15) 75%, transparent 75%, transparent);
        background-image: -o-linear-gradient(45deg, rgba(255, 255, 255, .15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, .15) 50%, rgba(255, 255, 255, .15) 75%, transparent 75%, transparent);
        background-image: linear-gradient(45deg, rgba(255, 255, 255, .15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, .15) 50%, rgba(255, 255, 255, .15) 75%, transparent 75%, transparent);
        background-color: #5bc0de;
        -webkit-background-size: 40px 40px;
        background-size: 40px 40px;
        -webkit-animation: progress-bar-stripes 2s linear infinite;
        -o-animation: progress-bar-stripes 2s linear infinite;
        animation: progress-bar-stripes 2s linear infinite;
        border-color: #5bc0de !important;
        color: white;
    }

    .table thead th,
    .table tr td {
        padding: 14px 8px !important;
        font-size: 13px !important;
    }

    .media {
        display: flex;
    }

    .media-body {
        flex: 1 1 100%;
        padding-left: 10px;
    }

    #app button.close {
        z-index: 999999;
        position: relative;
    }

    .dataTables_paginate {
        box-sizing: border-box;
        display: inline-block;
        min-width: 1.5em;
        text-align: center;
        text-decoration: none !important;
        cursor: pointer;
        color: #fff !important;
        background: #111 !important;
        border: none;
        padding: .5em 2em;
        /* font-size: 16px; */
        text-align: center;
        cursor: pointer;
        outline: none;
        color: #fff;
        border: none;
        /* border-radius: 5px; */
        border: none !important;
        margin: 0 .1em;
        /* box-shadow: 7px 6px 28px 1px rgba(0, 0, 0, 0.24); */
    }

    /* Adding styles on 'active' state */

    .page-item.active .dataTables_paginate,
    .page-item:hover .dataTables_paginate {
        /* box-shadow: 7px 6px 28px 1px rgba(0, 0, 0, 0.24); */
        /* transform: translateY(4px); */
        /* Moving button 4px to y-axis */
        color: #eee !important;
        border: 1px solid #979797 !important;
        margin-top: -1px;
    }

    .ellipsis {
        background: none !important;
        border: none !important;
        margin: 0 .2em;
    }

    .pagination {
        display: flex;
        flex-wrap: wrap;
    }

    .btn_page {
        display: flex;
        justify-content: flex-end;
    }
</style>
<section class="page-section" id="app" v-cloak>
    <div class="row col-lg-12 col-center">
        <div class="container-fluid padding-25 sm-padding-10">
            <div class="row">
                <div class="col-sm-12" id="results">
                    <div class='row'>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <h4 style="margin-bottom: 6px;">
                                <span @click="tickets_filter_set('mode', 'all')" :class="tickets_filter_class('mode', 'all', 'active')">Все</span>
                                <span @click="tickets_filter_set('mode', 'active')" :class="tickets_filter_class('mode', 'active', 'active')">В работе</span>
                                <span @click="tickets_filter_set('mode', 'new')" :class="tickets_filter_class('mode', 'new', 'active')">Новые</span>
                                <span style="display: none" @click="tickets_filter_set('mode', 'not_viewed')" :class="tickets_filter_class('mode', 'not_viewed', 'active')">Ждут ответа</span>
                                <span @click="tickets_filter_set('mode', 'closed')" :class="tickets_filter_class('mode', 'closed', 'active')">Архив</span>
                            </h4>

                        </div>

                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered cell-border">
                            <thead>
                                <tr>
                                    <th width="60">ID</th>
                                    <th width="120" title="Дата">Дата</th>
                                    <th>Пользователь</th>
                                    <th>Категория</th>
                                    <th>Тема</th>
                                    <th width="60">Сообщений</th>
                                    <th width="90">Статус</th>
                            </thead>
                            <tbody>
                                <template v-if="tickets.length">
                                    <tr v-for="ticket in tickets" :key="'tickets_' + ticket.id">
                                    <tr v-for="ticket in sorted_tickets">
                                        <td @click="ticket_click(ticket.id)" style="cursor: pointer">{{ticket.id}}</td>
                                        <td @click="ticket_click(ticket.id)" style="cursor: pointer">{{ticket.date_created_dmy}}</td>
                                        <td @click="ticket_click(ticket.id)" style="cursor: pointer">{{ticket.author_name}}</td>
                                        <td @click="ticket_click(ticket.id)" style="cursor: pointer">{{ticket.project_title}}</td>
                                        <td @click="ticket_click(ticket.id)" class="td_title" style="cursor: pointer">{{ticket.title}}</td>
                                        <td @click="ticket_click(ticket.id)" class="td_title" style="cursor: pointer">{{ticket.comments_count}}
                                            <span v-if="ticket.comments_count > 0 && !ticket.last_msg_view_admin" class="label label-success" style="padding: .2em .6em .3em;">new</span>
                                        </td>
                                        <td @click="ticket_click(ticket.id)" style="cursor: pointer">{{ticket.status_title}}</td>
                                    </tr>
                                    </tr>
                                </template>
                                <template v-else>
                                    <tr>
                                        <td colspan='6' align='center'>Обращений нет</td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>
                    <div class="btn_page">
                        <nav>
                            <ul class="pagination justify-content-center">
                                <li @click="pageIndexMinus" class="page-item"><span class="page-link dataTables_paginate">Предыдущая</span></li>
                                <li v-if="btnPagination[btnPaginationActive] + Math.ceil(paginationBtnCount / 2) > paginationBtnCount" class="page-item" @click="paginationFirstBtn">
                                    <span class="page-link dataTables_paginate">1</span>
                                </li>
                                <li v-if="ellipsisStart" class="page-item"><span class="ellipsis">…</span></li>

                                <li v-for="(item, index) in btnPagination" :key="index" @click="pageTickets(index, item)" class="page-item" :class="btnPaginationActive === index ? 'active' : ''">
                                    <span class="page-link dataTables_paginate">{{ item + 1 }}</span>
                                </li>

                                <li v-if="ellipsisEnd" class="page-item"><span class="ellipsis">…</span></li>
                                <li v-if="btnPagination[btnPaginationActive] + Math.ceil(paginationBtnCount / 2) < ticketsPageSize" class="page-item" @click="paginationLastBtn(ticketsPageSize)">
                                    <span class="page-link dataTables_paginate">{{ ticketsPageSize }}</span>
                                </li>
                                <li @click="pageIndexPlus" class="page-item"><span class="page-link dataTables_paginate">Следующая</span></li>
                            </ul>
                        </nav>

                        <!-- <button @click="prevPage" class="dataTables_paginate " data-dt-idx="0" tabindex="0" id="categories_previous">Предыдущая</button> -->
                        <!-- <button @click="nextPage" class="dataTables_paginate " data-dt-idx="0" tabindex="0" id="categories_previous">Следующая</button> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <modal name="modal_ticket_create" width="50%" :min-width="300" :max-width="500" height="auto" :adaptive="true" :click-to-close="true" :scrollable="true">
        <div class="panel panel-default">
            <div class="panel-body">
                <button @click="$modal.hide('modal_ticket_create')" type="button" class="close pull-right" aria-label="Close">
                    <i class="fa fa-times" aria-hidden="true" style="padding: 0px 0px 10px 10px;"></i>
                </button>
                <div class='row'>
                    <div class='col-md-12'>
                        <div class="form-group">
                            <label style="font-weight: normal">Категория</label>
                            <select class="form-control select_projects" ref="select_projects" v-model="modal_ticket_create_project_id">
                                <option v-for="project in projects" :value="project.id">
                                    {{project.title}}
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class='col-md-12'>
                        <div class="form-group">
                            <label style="font-weight: normal">Тема</label>
                            <input type="text" class="form-control" autocomplete='off' v-model="modal_ticket_create_title" />
                        </div>
                    </div>
                    <div class='col-md-12'>
                        <div class="form-group">
                            <label style="font-weight: normal">Сообщение</label>
                            <textarea class="form-control" rows="8" v-model="modal_ticket_create_body"></textarea>
                        </div>
                    </div>
                    <div class='col-md-12'>
                        <div class="form-group">

                            <label style="font-weight: normal">Добавить скриншот</label>

                            <vue-dropzone ref="myVueDropzone" id="dropzone" :options="dropzoneOptions" :destroy-dropzone="false" @vdropzone-file-added="vdropzone_file_added_my" @vdropzone-thumbnail="vdropzone_thumbnail_my" @vdropzone-sending="vdropzone_sending_my" @vdropzone-queue-complete="vdropzone_queue_complete_my">
                            </vue-dropzone>






                        </div>
                    </div>
                    <div class='col-md-12'>
                        <div class="form-group">
                            <div class="text-danger" v-if="modal_ticket_submit_error_text">
                                {{modal_ticket_submit_error_text}}
                            </div>
                        </div>
                    </div>
                    <div class='col-md-12'>
                        <button type="button" class="btn btn-mod btn-medium btn-round pull-left" @click="modal_ticket_create_submit" :disabled="modal_ticket_create_submit_clicked">
                            <span>Отправить</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </modal>
    <modal name="modal_ticket" width="80%" :min-width="300" :max-width="700" height="auto" :adaptive="true" :click-to-close="true" classes="" :scrollable="true">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class='row'>
                    <div class='col-md-12'>
                        <template v-if='modal_ticket_project_id'>
                            {{modal_ticket_project_title}}
                        </template>
                        <button @click="$modal.hide('modal_ticket')" type="button" class="close pull-right" aria-label="Close">
                            <i class="fa fa-times" aria-hidden="true" style="padding: 0px 0px 10px 10px;"></i>
                        </button>
                    </div>
                </div>
                <div class='row'>
                    <div class='col-md-12'>
                        <b>Создано:</b> {{modal_ticket_date_created}}<BR />
                        <b>Обновлено:</b> {{modal_ticket_date_updated}}<BR />
                        <b>Статус:</b> <span v-html="modal_ticket_status_title"></span> <button @click="set_status()" class="btn btn-info btn-sm"><span>Установить</span></button> <button @click="delete_ticket()" class="btn btn-danger btn-sm"><span>Удалить тикет</span></button><BR />

                    </div>
					<div class='col-md-12' style='word-break: break-all;'>
						<BR />
						<h3 style='margin: 0'>{{modal_ticket_title}}</h3>
						{{modal_ticket_body}}
						<BR />
						<BR/>
						<template v-if="order_id && order_id !== 'undefined'">
							<b>ID заказов:</b> {{order_id}}<BR />
						</template>
					</div>
                    <div class='col-md-12' v-if="modal_ticket_files">
                        <BR />
                        <span>Скриншоты:</span><BR />
                        <div v-for="(file, key) in modal_ticket_files" :key="'ticket_file' + key">
                            <a :href="file.link" target="_blank">
                                <img :src="file.link" width="100" />
                            </a>
                        </div>
                    </div>
                    <BR />
                    <div class='col-md-12' style='margin-top: 15px'>
                        <div class="form-group">
                            <textarea id="textareaComment" autocomplete="off" class="form-control comment_text" rows="5" placeholder='Комментарий' v-model="comment_new" :disabled="ticket_close_but_disabled() || comment_add_but_disabled()"></textarea>
                        </div>
                    </div>
                    <div class='col-md-12' v-if="comment_add_submit_error_text">
                        <div class="form-group">
                            <div class="text-danger"><span>{{comment_add_submit_error_text}}</span></div>
                        </div>
                    </div>
                    <div class="col-md-12">

                        <div class="form-group">
                            <button @click="comment_add()" class="btn btn-default btn-default-2 pull-left" :disabled="comment_add_but_disabled()">
                                <span>
                                    Добавить комментарий
                                </span>
                            </button>

                            <button v-if="!comment_add_file_clicked" @click="comment_add_file_click()" class="btn btn-default btn-default-2 pull-right">
                                <span>
                                    Добавить скриншот
                                </span>
                            </button>
                        </div>

                    </div>
                    <div class='col-md-12' v-if="comment_add_file_clicked">
                        <div class="form-group" style="margin-top: 15px">
                            <vue-dropzone ref="myVueDropzone" id="dropzone" :options="dropzoneOptions" :destroy-dropzone="false" @vdropzone-file-added="vdropzone_file_added_my_comment" @vdropzone-thumbnail="vdropzone_thumbnail_my_comment" @vdropzone-sending="vdropzone_sending_my_comment" @vdropzone-queue-complete="vdropzone_queue_complete_my_comment">
                            </vue-dropzone>
                        </div>
                    </div>


                    <div class="col-md-12" style="margin-left: 0px; margin-right: 0px">
                        <template v-if="comments.length">
                            <div v-for="(comment, key) in comments" :key="comment.id">
                                <div v-if="key == 0" class="row" style="margin-top: 26px; margin-bottom: 4px"></div>
                                <div v-else class="row">
                                    <hr style='margin-top: 10px; margin-bottom: 10px;' />
                                </div>

                                <div class="row comment_row" style='margin-left: -5px; margin-right: -5px'>
                                    <div class="media">
                                        <div class="media-left" v-if="comment.my">
                                            <img class="media-object" src="/theme/img/operator.png" style='width: 50px; height: 50px; max-width: none' />
                                        </div>
                                        <div class="media-body">
                                            <b v-if="!comment.my" style='color: #fd3489;'>
                                                {{comment.author_name}}
                                            </b>
                                            <b v-else>
                                                {{comment.author_name}}
                                            </b>

                                            <small style="color: gray" class="pull-right">
                                                {{comment.date_created_dmy}}
                                            </small>
                                            <div v-html="json_br(comment.body)"></div>

                                            <div v-if="comment.files">
                                                <BR />
                                                <div v-for="(file, key) in comment.files" :key="'comment_file' + file.id">
                                                    <a :href="file.link" target="_blank">
                                                        <img :src="file.link" width="300" />
                                                    </a>
                                                </div>
                                            </div>
                                        </div>




                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>

                </div>
            </div>
        </div>
    </modal>
</section>





<script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
<script src="/theme/js/vue/vue-2.6.12.min.js?8" type="text/javascript"></script>
<script src="/theme/js/axios.min.js"></script>
<script src="/theme/js/vue/vue2-datepicker/vue2-datepicker.lib.js"></script>
<link href="/theme/js/vue/vue-js-modal/styles.css?4" rel="stylesheet">
<script src="/theme/js/vue/vue-js-modal/index.js"></script>
<link href="/theme/js/vue/vue-dropzone/vue2Dropzone.css?3" rel="stylesheet">
<script src="/theme/js/vue/vue-dropzone/vue2Dropzone.js"></script>
<script type="text/javascript">
    Vue.use(DatePicker.default);
    Vue.use(window["vue-js-modal"].default);
    Vue.use(vue2Dropzone);

    var app = new Vue({
        el: '#app',
        components: {
            vueDropzone: vue2Dropzone
        },
        data: {
            base_url: '/',

            btnPaginationActive: 0,
            btnPagination: [],
            paginationBtnCount: 4,
            ticketsPageSize: 0,
            ellipsisStart: false,
            ellipsisEnd: false,

            tickets: [],
            comments: [],
            projects: [],

            tickets_filter: {
                mode: 'all',
                changed: false
            },

            currentSort: 'name',
            currentSortDir: 'asc',
            tickets_size: 15,
            tickets_page: 1,

            next_page_but_clicked: false,
            tickets_load_count: 0,

            init_ticket_create: false,
            init_project_id: null,
            init_ticket_id: null,

            modal_ticket_create_project_id: null,
            modal_ticket_create_title: '',
            modal_ticket_create_body: '',
            modal_ticket_create_submit_clicked: false,
            modal_ticket_submit_error_text: '',
            modal_ticket_id: null,

            modal_ticket_project_id: null,
            modal_ticket_project_title: '',
            modal_ticket_executor_name: '',
            modal_ticket_author_name: '',
            modal_ticket_title: '',
            modal_ticket_body: '',
            modal_ticket_files: null,
            modal_ticket_status_id: null,
            modal_ticket_status_title: '',
            modal_ticket_date_created: '',
            modal_ticket_date_updated: '',
            order_id: '',
            comment_add_but_clicked: false,
            comment_new: '',
            comment_new_id: null,
            comment_add_submit_error_text: '',
            comment_add_file_clicked: false,
            comment_new_file_ok: false,

            dropzoneOptions: {
                url: '/tickets/api_admin.php',
                method: 'post',
                paramName: "file",
                autoDiscover: false,
                autoProcessQueue: false,
                thumbnailWidth: 175,
                thumbnailHeight: 175,
                thumbnailMethod: 'crop',
                addRemoveLinks: true,
                dictDefaultMessage: "<i class='fa fa-cloud-upload' style='margin-right: 6px; vertical-align: middle;'></i> Загрузить файл",
                //                timeout: 60000,
                withCredentials: true,
                maxFiles: 1,
                maxFilesize: 10 // MB
            },

            modal_error_text: ''
        },
        watch: {
            'projects': function() {
                //                this.select_modal_projects();
            }
        },
        computed: {
            sorted_tickets: function() {
                return this.tickets.sort((a, b) => {
                    let modifier = 1;
                    if (this.currentSortDir === 'desc') modifier = -1;
                    if (a[this.currentSort] < b[this.currentSort]) return -1 * modifier;
                    if (a[this.currentSort] > b[this.currentSort]) return 1 * modifier;
                    return 0;
                }).filter((row, index) => {
                    let start = (this.tickets_page - 1) * this.tickets_size;
                    let end = this.tickets_page * this.tickets_size;
                    if (index >= start && index < end) return true;
                });
            },
        },
        filters: {
            to_fixed: function(v) {
                if (!v) {
                    return '';
                }

                var value = parseFloat(v);

                return value.toFixed(0);
            },
            json_br: function(v) {
                if (v) {
                    return v.replace(/\n/g, "<br>");
                }

                return v;
            }
        },
        created: function() {
            this.http_tickets_get();
            this.http_projects_get();
        },
        mounted: function() {
            var _this = this;

            if (this.init_ticket_create) {
                this.ticket_create_click();
            }

            if (this.init_ticket_id) {
                this.ticket_click(this.init_ticket_id);
            }

        },
        methods: {
            nextPage: function() {
                if ((this.tickets_page * this.tickets_size) < this.tickets.length) this.tickets_page++;
            },
            prevPage: function() {
                if (this.tickets_page > 1) this.tickets_page--;
            },

            next_page_but: function() {
                this.next_page_but_clicked = true;
                this.tickets_page++;
                this.http_tickets_get();
            },
            tickets_filter_class: function(name, value, class_name) {
                if (this.tickets_filter[name] == value) {
                    var _class = {};
                    _class[class_name] = true;

                    return _class;
                }

                return '';
            },
            tickets_filter_set: function(name, value) {
                if (this.tickets_filter[name] == value) {
                    return;
                }

                this.tickets_filter[name] = value;

                if (name == 'mode') {
                    this.tickets_filter.changed = true;
                }

                this.http_tickets_get();
            },
            //            select_modal_projects: function() {
            //                this.$nextTick(function () {
            //                    window.$('.select_projects').selectpicker('refresh');
            //                });
            //            },
            ticket_click: function(ticket_id) {
                this.comment_add_submit_error_text = '';
                this.comment_add_file_clicked = false;
                this.comment_new_file_ok = false;
                //                this.$refs.myVueDropzone.removeAllFiles();

                this.http_ticket_get(ticket_id);
            },
            ticket_create_click: function() {
                this.modal_ticket_id = null;
                this.comment_new_id = null;
                this.modal_ticket_submit_error_text = null;

                if (this.init_project_id) {
                    this.modal_ticket_create_project_id = this.init_project_id;
                }

                //                this.select_modal_projects();      
                this.$modal.show('modal_ticket_create');
            },
            modal_ticket_create_clear: function() {
                this.modal_ticket_id = null;
                this.modal_ticket_create_submit_clicked = false;
                this.modal_ticket_create_project_id = null;
                this.modal_ticket_create_title = '';
                this.modal_ticket_create_body = '';
                this.modal_ticket_submit_error_text = null;
            },
            modal_ticket_submit_error: function(error_text, obj) {
                this.modal_ticket_submit_error_text = error_text;
                this.modal_ticket_create_submit_clicked = false;

                if (obj) {
                    console.log(error_text, obj);
                }
            },
            modal_ticket_create_submit: function() {
                var _this = this;
                this.modal_ticket_create_submit_clicked = true;

                if (!this.modal_ticket_create_project_id) {
                    this.modal_ticket_submit_error_text = 'Укажите категорию';
                    this.modal_ticket_create_submit_clicked = false;

                    return false;
                }

                if (!this.modal_ticket_create_title) {
                    this.modal_ticket_submit_error_text = 'Укажите тему вопроса';
                    this.modal_ticket_create_submit_clicked = false;

                    return false;
                }

                if (!this.modal_ticket_create_body) {
                    this.modal_ticket_submit_error_text = 'Опишите подробно вашу проблему';
                    this.modal_ticket_create_submit_clicked = false;

                    return false;
                }

                var formData = new FormData();
                formData.append('project_id', this.modal_ticket_create_project_id);
                formData.append('title', this.modal_ticket_create_title);
                formData.append('body', this.modal_ticket_create_body);

                axios.post(this.base_url + 'tickets/api_admin.php?action=createTicket', formData).then(function(response) {
                        if (response.data.status === true) {
                            _this.modal_ticket_id = response.data.data;
                            _this.$refs.myVueDropzone.processQueue();
                            _this.http_tickets_get();
                            _this.$modal.hide('modal_ticket_create');
                            _this.modal_ticket_create_clear();
                        } else {
                            _this.modal_ticket_submit_error('Ошибка', response.data);
                        }
                    })
                    .catch(function(error) {
                        _this.modal_ticket_submit_error('Ошибка HTTP', error);
                    });
            },

            comment_add_but_disabled: function() {
                if (this.comment_add_but_clicked) {
                    return true;
                }

                if (this.modal_ticket_status_id == 3) {
                    return true;
                }

                return false;
            },
            ticket_close_but_disabled: function() {
                if (this.ticket_close_but_clicked) {
                    return true;
                }
            },

            delete_ticket: function() {
                var _this = this;

                axios.post(this.base_url + 'tickets/api_admin.php?action=delTicket&id=' + this.modal_ticket_id).then(function(response) {
                    if (response.data.status === true) {
                        _this.http_tickets_get();
                        _this.$modal.hide('modal_ticket');
                    }
                }).catch(function(error) {
                    _this.modal_error('Ошибка HTTP', error);
                    _this.comment_add_but_clicked = false;
                });

            },







            comment_add: function() {
                var _this = this;
                this.comment_add_but_clicked = true;
                this.comment_add_submit_error_text = '';
                this.comment_new_id = null;

                var comment_text = this.comment_new && this.comment_new.trim();
                if (!comment_text) {
                    this.comment_add_but_clicked = false;
                    this.comment_add_submit_error_text = 'Укажите комментарий';

                    return false;
                }

                var formData = new FormData();
                formData.append('body', comment_text);
                axios.post(this.base_url + 'tickets/api_admin.php?action=addComment&id=' + this.modal_ticket_id, formData).then(function(response) {
                        if (response.data.status === true) {
                            _this.comment_new_id = response.data.data;

                            if (_this.comment_new_file_ok) {
                                //                            setTimeout(function () {
                                _this.$refs.myVueDropzone.processQueue();
                                //                            }, 500);
                                //                            _this.$refs.myVueDropzone.processQueue();
                            }

                            if (_this.comment_new_file_ok) {
                                setTimeout(() => _this.http_comments_get(_this.modal_ticket_id), 2000);
                            } else {
                                _this.http_comments_get(_this.modal_ticket_id);
                            }


                            _this.comment_add_but_clicked = false;
                            _this.comment_add_file_clicked = false;

                            _this.comment_add_textarea_focused = false;
                            _this.comment_new = '';
                            _this.comment_new_file_ok = false;

                            _this.http_tickets_get();
                        }
                    })
                    .catch(function(error) {
                        _this.modal_error('Ошибка HTTP', error.response.data);
                        _this.comment_add_but_clicked = false;
                        _this.http_tickets_get();
                        _this.http_comments_get(_this.modal_ticket_id);
                        // _this.$refs.myVueDropzone.processQueue();
                        setTimeout(() => _this.$refs.myVueDropzone.processQueue(), 1000);
                        setTimeout(() => _this.http_comments_get(_this.modal_ticket_id), 2000);
                        _this.comment_new = '';
                    });
            },



            comment_add_file_click: function() {
                this.comment_add_file_clicked = true;
            },


            set_status: function() {
                var _this = this;
                var ticket_status_select = document.getElementById('ticket_status'),
                    ticket_status = ticket_status_select.options[ticket_status_select.selectedIndex].value;

                var formData = new FormData();
                formData.append('status', ticket_status);

                axios.post(this.base_url + 'tickets/api_admin.php?action=setStatus&id=' + this.modal_ticket_id, formData).then(function(response) {
                        if (response.data.status === true) {
                            _this.http_tickets_get();
                            _this.modal_ticket_date_updated = response.data.data.date_updated_dmy;
                            _this.modal_ticket_status_id = response.data.data.status;
                        }
                    })
                    .catch(function(error) {
                        _this.modal_error('Ошибка HTTP', error);
                    });

            },



            http_tickets_get: function() {
                var _this = this;
                var filter_str = '';

                if (this.tickets_filter.changed) {
                    this.tickets_page = 1;
                }

                filter_str += '&mode=' + this.tickets_filter.mode;
                filter_str += '&page=' + this.tickets_page;
                axios.get(this.base_url + 'tickets/api_admin.php?action=getTickets' + filter_str).then(function(response) {

                        if (_this.tickets_page == 1 || _this.tickets_filter.changed) {
                            _this.tickets = [];
                        }

                        if (response.data.status === true) {
                            if (_this.tickets_page > 1) {
                                _this.tickets = _this.tickets.concat(response.data.data);
                            } else {
                                _this.tickets = response.data.data;
                            }

                            _this.tickets_load_count = response.data.data.length;
                        } else {
                            _this.tickets_load_count = 0;
                        }

                        _this.ticketsPageSize = Math.ceil(_this.tickets_load_count / _this.tickets_size);
                        _this.paginationBtnCount = _this.paginationBtnCount % 2 === 0 ? _this.paginationBtnCount /*- 1*/ : _this.paginationBtnCount;

                        let countButtonsView = _this.paginationBtnCount < _this.ticketsPageSize ? _this.paginationBtnCount : _this.ticketsPageSize;

                        _this.btnPagination = [];

                        for (var i = 0; i < countButtonsView; i++) {
                            _this.btnPagination[i] = i;
                        }

                        _this.ellipsisEnd = _this.btnPagination[_this.btnPaginationActive] + Math.ceil(_this.ticketsPageSize / 2) < _this.ticketsPageSize;


                        _this.next_page_but_clicked = false;
                    })
                    .catch(function(error) {
                        _this.tickets = [];
                        _this.next_page_but_clicked = false;
                        _this.modal_error('Ошибка HTTP', error);
                    });
            },
            pageTickets(i, page = null) {
                if (this.btnPagination[i] !== undefined) {
                    this.btnPaginationActive = i;
                    let cbHalf = Math.floor(this.paginationBtnCount / 2);
                    let countRight = this.btnPaginationActive - cbHalf;
                    let countLeft = cbHalf - this.btnPaginationActive;

                    if (this.btnPaginationActive - cbHalf > 0) {
                        for (let index = 0; index < countRight; index++) {
                            if (this.btnPagination[this.btnPagination.length - 1] + 1 < this.ticketsPageSize) {
                                this.btnPagination.push(this.btnPagination[this.btnPagination.length - 1] + 1);
                                this.btnPagination.shift();
                                this.btnPaginationActive--;
                            }
                        }
                    } else if (this.btnPaginationActive - cbHalf < 0) {
                        for (let index = 0; index < countLeft; index++) {
                            if (this.btnPagination[0] > 0) {
                                this.btnPagination.unshift(this.btnPagination[0] - 1);
                                this.btnPagination.pop();
                                this.btnPaginationActive++;
                            }
                        }
                    }

                    if (page) {
                        this.tickets_page = page + 1;
                    }

                    this.ellipsisStart = this.btnPagination[this.btnPaginationActive] + Math.ceil(this.paginationBtnCount / 2) - 1 > this.paginationBtnCount;
                    this.ellipsisEnd = this.btnPagination[this.btnPaginationActive] + Math.ceil(this.paginationBtnCount / 2) + 1 < this.ticketsPageSize;
                }
            },
            pageIndexPlus() {
                if (this.btnPagination[this.btnPaginationActive + 1] !== undefined && this.btnPaginationActive < this.ticketsPageSize) {
                    this.pageTickets(this.btnPaginationActive + 1);

                    this.nextPage();
                }
            },
            pageIndexMinus() {
                if (this.btnPagination[this.btnPaginationActive - 1] !== undefined && this.btnPaginationActive > 0) {
                    this.pageTickets(this.btnPaginationActive - 1);

                    this.prevPage();
                }
            },
            paginationFirstBtn() {
                let countButtonsView = this.paginationBtnCount < this.ticketsPageSize ? this.paginationBtnCount : this.ticketsPageSize;

                this.btnPagination = [];

                for (var i = 0; i < countButtonsView; i++) {
                    this.btnPagination[i] = i;
                }

                this.btnPaginationActive = 0;

                this.tickets_page = 1;

                this.ellipsisStart = false;
                this.ellipsisEnd = this.btnPagination[this.btnPaginationActive] + Math.ceil(this.paginationBtnCount / 2) + 1 < this.ticketsPageSize;
            },
            paginationLastBtn(num) {
                let countButtonsView = this.paginationBtnCount < this.ticketsPageSize ? this.paginationBtnCount : this.ticketsPageSize;

                this.btnPagination = [];

                for (var i = 0; i < countButtonsView; i++) {
                    this.btnPagination[i] = (num - i) - 1;
                }

                this.btnPagination.reverse();

                this.btnPaginationActive = countButtonsView - 1;

                this.tickets_page = num;

                this.ellipsisStart = this.btnPagination[this.btnPaginationActive] + Math.ceil(this.paginationBtnCount / 2) - 1 > this.paginationBtnCount;
                this.ellipsisEnd = false;
            },


            http_projects_get: function() {
                var _this = this;
                axios.get(this.base_url + 'tickets/api_admin.php?action=getProjects').then(function(response) {
                        if (response.data.status === true) {
                            _this.projects = response.data.data;
                        }
                    })
                    .catch(function(error) {
                        _this.modal_error('Ошибка HTTP', error);
                    });
            },


            http_ticket_get: function(ticket_id) {
                var _this = this;
                axios.get(this.base_url + 'tickets/api_admin.php?action=getTicket&id=' + ticket_id).then(function(response) {
                        if (response.data.status === true) {
                            var result = response.data.data;

                            _this.modal_ticket_id = result.id;
                            _this.modal_ticket_project_id = result.project_id;
                            _this.modal_ticket_project_title = result.project_title;
                            _this.modal_ticket_executor_name = result.executor_name;
                            _this.modal_ticket_author_name = result.author_name;
                            _this.modal_ticket_title = result.title;
                            _this.modal_ticket_body = result.body;
                            _this.modal_ticket_files = result.files;
                            _this.modal_ticket_status_id = result.status_id;
                            _this.modal_ticket_status_title = result.status_title;
                            _this.modal_ticket_date_created = result.date_created_dmy;
                            _this.modal_ticket_date_updated = result.date_updated_dmy;
                            _this.order_id = result.order_id;
                            _this.comments = [];

                            _this.$modal.show('modal_ticket');

                            _this.http_comments_get(result.id);
                        } else {
                            _this.modal_error('Тикет не найден', null);
                        }
                    })
                    .catch(function(error) {
                        _this.modal_error('Ошибка HTTP', error);
                    });
            },















            http_comments_get: function(ticket_id) {
                var _this = this;
                axios.get(this.base_url + 'tickets/api_admin.php?action=getComments&id=' + ticket_id).then(function(response) {
                        _this.comments = [];
                        if (response.data.status === true) {
                            var result = response.data.data;
                            console.log(result)
                            _this.comments = result;
                            // _this.comment_new = '';
                        }
                    })
                    .catch(function(error) {
                        _this.comments = [];
                        _this.modal_error('Ошибка HTTP', error);
                    });
            },




            vdropzone_file_added_my: function(file) {
                //                console.log(file);
            },
            vdropzone_thumbnail_my: function(file, dataUrl) {
                //                console.log(file, dataUrl);
            },
            vdropzone_sending_my: function(file, xhr, formData) {
                formData.append('action', 'uploadFile');
                formData.append('ticket_id', this.modal_ticket_id);
                formData.append('filename', file.name);
                //                console.log(file);
            },
            vdropzone_queue_complete_my: function() {
                this.$refs.myVueDropzone.removeAllFiles();
                //                this.http_comment_get(this.comment_new_id);
                //                this.comment_new_id = null;
                //                console.log('complete');
            },

            vdropzone_file_added_my_comment: function(file) {
                //                console.log('vdropzone_file_added_my_comment');
            },
            vdropzone_thumbnail_my_comment: function(file, dataUrl) {
                var _this = this;

                //                console.log('vdropzone_thumbnail_my_comment');
                this.comment_new_file_ok = true;

                if (!this.comment_new) {
                    this.comment_new = 'Добавлен скриншот';
                }

                this.comment_add();
            },
            vdropzone_sending_my_comment: function(file, xhr, formData) {
                formData.append('action', 'uploadFile');
                formData.append('ticket_id', this.modal_ticket_id);
                formData.append('comment_id', this.comment_new_id);
                formData.append('filename', file.name);
            },
            vdropzone_queue_complete_my_comment: function() {
                this.$refs.myVueDropzone.removeAllFiles();
                //                this.http_comment_get(this.comment_new_id);
                //                this.comment_new_id = null;
                //                console.log('vdropzone_queue_complete_my_comment');
            },








            json_br: function(v) {
                return v.replace(/\n/g, "<br>");
            },

            modal_error: function(error_text, error_obj) {
                console.log(error_obj);
                this.modal_error_text = error_text;
                this.$modal.show('modal_error');
            }
        },
        directives: {
            'input-focus': function(el, binding) {
                Vue.nextTick(function() {
                    el.focus();
                    //console.log(el);
                });
            }
        }
    });
</script>

<?php
require_once('files/footer.php');
?>