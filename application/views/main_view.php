<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Backup</title>
        <link rel="shortcut icon" href="<?= base_url(); ?>/assets/img/backup.png" type="image/png">
        <link href="<?= base_url(); ?>assets/css/common.css" rel="stylesheet" type="text/css" media="all" />
        <link href="<?= base_url(); ?>assets/css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
        <script type="text/javascript" src="<?= base_url() . 'assets/js/jquery.js'; ?>"></script>
        <script type="text/javascript" src="<?= base_url() . 'assets/js/common.js'; ?>"></script>

        <script type="text/javascript" src="<?= base_url() . 'assets/js/bootstrap.js'; ?>"></script>
    </head>
    <body>
        <div id="container">
            <!--            <div class="row">
                            <div class="col-md-6"><img src="<?= base_url(); ?>assets/img/backup.png" id="logo_img" align="left"><h2 id="title"><a class="title_link" href="<?= base_url(); ?>">Каллендарь Резервных копий</a></h2></div>
                            <div class="col-md-6"></div>
                        </div>-->
            <div id="body">
                <h5>Новых писем - <?php echo $new_mail_count; ?>  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  Удаленных заданий - <?= $del_item_count; ?></h5>
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
                    ?>
                    <!-- Вторая строка -->
                    <?php
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
                        echo '<div data-trigger="focus" role="button" data-toggle="popover" data-placement="right" data-trigger="hover" data-content="' . $i['description'] . '">';
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

                            echo '><div style="font-size: 11px;" role="button" data-toggle="popover" data-placement="bottom" data-content="'
                            . '<a href=Main/edit_item/0/' . $i['id'] . '/' . date('Y-m-d', $date_temp) . '>Не делалась</a><br>'
                            . '<a href=Main/edit_item/1/' . $i['id'] . '/' . date('Y-m-d', $date_temp) . '>Полная</a><br>'
                            . '<a href=Main/edit_item/2/' . $i['id'] . '/' . date('Y-m-d', $date_temp) . '>Разностная</a><br>'
                            . '<a href=Main/edit_item/3/' . $i['id'] . '/' . date('Y-m-d', $date_temp) . '>Ошибка</a><br>'
                            . '<a href=Main/edit_item/4/' . $i['id'] . '/' . date('Y-m-d', $date_temp) . '>Удаленная</a><br>'
                            . '">&nbsp;</div></td>';
                            ++$j;
                        } while ($j < 7);





                        // Строки
//                        for($i=1;$i<38;$i++){
//                            echo '<td>';
//                            echo '</td>';
//                        }
                        // Статусы заданий
//                        foreach ($item as $item_key => $k) {
//                            if ($k['task'] == $i['id']) {
//                                echo '<td>';
//                                //echo $k['status'];
//                                echo '</td>';
//                            }
//                        }

                        echo '</tr>';
                    }

                    // Тестовый вывод
//                    echo '<xmp>';
//                    print_r($item);
//                    echo '</xmp>';
                    // Вывод заданий
                    /* foreach ($task as $key => $item){
                      echo '<tr><td>';
                      echo $item['title'];
                      echo '</td></tr>';
                      } */
                    ?>
    <!--                    <tr>
                            <td>
                            </td>
                            <td>
                            </td>
                        </tr>-->
                </table>
                <button type="button" id="button_add" class="btn btn-default" data-toggle="modal" data-target="#add_modal">Добавить задание</button>
            </div>
        </div>
        <!-- Modal -->
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

    </body>
</html>