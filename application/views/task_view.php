<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>CobianMonitoring</title>
        <link rel="shortcut icon" href="<?= base_url(); ?>assets/img/CobianMonitoring.png" type="image/png">
        <link href="<?= base_url(); ?>assets/css/common.css" rel="stylesheet" type="text/css" media="all" />
        <link href="<?= base_url(); ?>assets/css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
        <script type="text/javascript" src="<?= base_url() . 'assets/js/jquery.js'; ?>"></script>
        <script type="text/javascript" src="<?= base_url() . 'assets/js/common.js'; ?>"></script>
        <script type="text/javascript" src="<?= base_url() . 'assets/js/bootstrap.js'; ?>"></script>
    </head>
    <body>
        <div id="container">
            <div id="body">
                <h5>Настройка заданий</h5>
                <button type="button" id="button_add" class="btn btn-default" data-toggle="modal" data-target="#add_modal">Добавить задание</button>
                <button type="button" id="button_add" class="btn btn-default" data-toggle="modal" data-target="#add_modal">Сохранить</button>
                <button type="button" id="button_add" class="btn btn-default" data-toggle="modal" data-target="#add_modal">Отмена</button>
            </div>
        </div>

        <!-- Модальное окно добавления задания -->
        <div class="modal fade" id="add_modal" tabindex="1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Добавление задания</h4>
                    </div>
                    <form method="POST" action="<?= base_url(); ?>Main/add_task">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Название задания</label>
                                <input type="text" class="form-control" id="input_title" name="title" placeholder="Название задания">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
                            <button type="submit" class="btn btn-primary">Сохранить</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script type="text/javascript">
            $keys = Array(
                'id'=>Array('auto_increment'),
                'title'=>Array('default'=>'habrahabr'), 
                'posts', 
                'userId'
            );
            $jdb->create('habr', $keys);
        </script>




    </body>
</html>