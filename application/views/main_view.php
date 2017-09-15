<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>CobianMonitoring</title>
    <link rel="shortcut icon" href="<?= base_url(); ?>assets/img/CobianMonitoring.png" type="image/png">
    <link href="<?= base_url(); ?>assets/css/common.css" rel="stylesheet" type="text/css" media="all" />
    <link href="<?= base_url(); ?>assets/css/bootstrap-3.3.7.css" rel="stylesheet" type="text/css" media="all" />
    <script type="text/javascript" src="<?= base_url() . 'assets/js/jquery.js'; ?>"></script>
    <script type="text/javascript" src="<?= base_url() . 'assets/js/common.js'; ?>"></script>
    <script type="text/javascript" src="<?= base_url() . 'assets/js/bootstrap-3.3.7.js'; ?>"></script>
</head>
<body>
    <div id="container">
        <div id="body">
            <h5>Новых писем - <?php echo $new_mail_count; ?>  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  Удаленных заданий - <?php echo $del_item_count; ?></h5>
            <table class="table table-bordered table-hover table-condensed">
                <!--Шапка таблицы-->
                <?php
                $i = -30;
                echo '<tr>';
                echo '<td>Наименование задания</td>';
                        // Перебор дат
                do {
                    echo '<td ';
                    $date_temp = strtotime('+' . $i . ' day');
                    echo ((date('w', $date_temp) == 0 || date('w', $date_temp) == 6) ? 'class="warning"><b>'
                        . date('d', $date_temp) . '</b>' : 'class="info">' . date('d', $date_temp));
                    echo '</td>';
                    ++$i;
                } while ($i < 7);
                echo '</tr>';

                    // Вывод серверов

                $server_lable = '';
                foreach ($task as $key => $i) {
                        // Разделитель Сервер
                    if ($i['server_title'] != $server_lable) {
                        echo '<tr><td class="task_title"><b>';
                        echo $i['server_title'];
                        echo '</b></td></tr>';
                    }
                    $server_lable = $i['server_title'];

                        // Название задания
                    echo '<tr><td class="task_title">';
                    echo '<div tabindex="0" data-trigger="focus" role="button" data-toggle="popover" data-html="true"  data-placement="right" data-content="' . $i['description'] . '">';
                    echo $i['task_title'];
                    echo '</div>';
                    echo '</td>';



                        // Строка статусов заданий
                        // Перебор дат
                    $j = -30;
                    do {
                        echo '<td ';

                        $date_temp = strtotime('+' . $j . ' day');
                        $end_status = NULL;
                        foreach ($item as $item_key => $k) {
                            if ($k['date'] == date('Y-m-d', $date_temp) and $k['task'] == $i['id']) {

                                    //echo 'class="success">';
//                                    echo ((date('w', $date_temp) == 0 || date('w', $date_temp) == 6) ? 'class="success"><b>'
//                                            . date('d', $date_temp) . '</b>' : 'class="info">' . $k['status']);

                                switch ($k['status']) {

                                    case 1:
                                    $end_status = 1;
                                    break;
                                    case 2:
                                    $end_status = 2;
                                    break;
                                    case 3:
                                    $end_status = 3;
                                    break;
                                    case 4:
                                    $end_status = 4;
                                    break;
                                }
                            }
                                // Применение стиля
                        }
                        switch ($end_status) {

                            case 1:
                            echo 'class="color_full"';
                            break;
                            case 2:
                            echo 'class="color_inc"';
                            break;
                            case 3:
                            echo 'class="color_error"';
                            break;
                            case 4:
                            echo 'class="active"';
                            break;
                        }
                            //echo date('d-m-Y', $date_temp);

                        echo '><div tabindex="0" data-trigger="focus" style="font-size: 11px;" data-toggle="popover" data-placement="bottom" data-html="true" data-content="'
                        . '<a href=Main/edit_item/0/' . $i['id'] . '/' . date('Y-m-d', $date_temp) . '>Не делалась</a><br>'
                        . '<a href=Main/edit_item/1/' . $i['id'] . '/' . date('Y-m-d', $date_temp) . '>Полная</a><br>'
                        . '<a href=Main/edit_item/2/' . $i['id'] . '/' . date('Y-m-d', $date_temp) . '>Разностная</a><br>'
                        . '<a href=Main/edit_item/3/' . $i['id'] . '/' . date('Y-m-d', $date_temp) . '>Ошибка</a><br>'
                        . '<a href=Main/edit_item/4/' . $i['id'] . '/' . date('Y-m-d', $date_temp) . '>Удаленная</a><br>'
                        . '">&nbsp;</div></td>';
                        ++$j;
                    } while ($j < 7);
                    echo '</tr>';
                }
                ?>
            </table>
            <a type="button" id="button_add" class="btn btn-default" href="<?= base_url() . 'task'; ?>">Настройка</a>
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
      $('[data-toggle="popover"]').popover()
    </script>
</body>
</html>