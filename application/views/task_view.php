    <body>
        <div id="container">
            <div id="body">
                <h5>Настройка заданий</h5>
                <table id="sort" class="table table-bordered table-hover table-condensed">
                    <thead>
                        <tr>
                            <td>Наименование задания</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $server_lable = '';
                        foreach ($task as $key => $i) {
                            // Разделитель Сервер
                            if ($i['server_title'] != $server_lable) {
                                echo '<tr id="srv_id.'.$i['server_id'].'" class="open-edit-server-modal" data-toggle="modal" data-target="#edit_server" data-tr-id="'. $i['server_id'] .'" >';
                                echo '<td class="task_title"><b>';
                                echo $i['server_title'];
                                echo '</b></td></tr>';
                            }
                            $server_lable = $i['server_title'];

                            // Название задания
                            echo '<tr id="' . $i['id'] . '" class="open-edit-modal" data-toggle="modal" data-target="#edit_modal" data-tr-id="'. $i['id'] .'" >';
                            echo '<td class="task_title">';
                            echo $i['task_title'];
                            echo '</td>';
                            echo '</tr>';
                        }

                        // Сервера без заданий
                        foreach ($empty_server as $key => $i) {
                            echo '<tr id="srv_id.'.$i['id'].'" class="open-edit-server-modal" data-toggle="modal" data-target="#edit_server" data-tr-id="'. $i['id'] .'" >';
                            echo '<td class="task_title"><b>';
                            echo $i['title'];
                            echo '</b></td></tr>';
                        }
                        ?>
                    </tbody>
                </table >


                <a href="<?= base_url();?>" type="button" class="btn btn-default" >Назад</a>
                <button type="button" id="button_add" class="btn btn-default" data-toggle="modal" data-target="#add_modal">Добавить задание</button>
                <button type="button" id="button_add_server" class="btn btn-default" data-toggle="modal" data-target="#add_server">Добавить сервер (группу)</button>
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
                    <form method="POST" action="<?= base_url(); ?>task/add_task">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Название задания</label>
                                <input type="text" class="form-control" id="input_title" name="title" placeholder="Название задания">
                                <label for="task_description">Описание задания</label>
                                <textarea type="text" class="form-control" id="task_description" name="task_description" placeholder="Описание задания"></textarea>
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
        
        <!-- Модальное окно редактирования задания -->
        <div class="modal fade" id="edit_modal" tabindex="2" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Редактирование задания</h4>
                    </div>
                    <form method="POST" action="<?= base_url(); ?>task/update_task">
                        <div class="modal-body">
                            <div class="form-group">
                                <?php
                                    $hidden_id = array(
                                        'type' => 'hidden',
                                        'name' => 'task_id',
                                        'id' => 'task_id',
                                        'value' => '',
                                    );
                                    echo form_input($hidden_id);
                                ?>
                                <label for="task_title">Название задания</label>
                                <input type="text" class="form-control" id="task_title" name="task_title" placeholder="Название задания">
                                <label for="task_description">Описание задания</label>
                                <textarea type="text" class="form-control" id="task_description" name="task_description" placeholder="Описание задания"></textarea>
                            </div>
                            <div class="modal-footer">
                                    <button type="button" id="button_test" class="btn btn-danger" data-toggle="modal" data-target="#delete_modal">Удалить</button>
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
                                    <button type="submit" class="btn btn-primary">Сохранить</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Модальное окно Добавления сервера -->
        <div class="modal fade" id="add_server" tabindex="2" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Добавление сервера (группы)</h4>
                    </div>
                    <form method="POST" action="<?= base_url(); ?>task/add_server">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="task_title">Название сервера</label>
                                <input type="text" class="form-control" id="server_title" name="server_title" placeholder="Название сервера">
                            </div>
                            <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
                                    <button type="submit" class="btn btn-primary">Сохранить</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Модальное окно Редактирования сервера -->
        <div class="modal fade" id="edit_server" tabindex="2" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Редактирование сервера (группы)</h4>
                    </div>
                    <form method="POST" action="<?= base_url(); ?>task/update_server">
                        <div class="modal-body">
                            <div class="form-group">
                                <?php
                                    $hidden_id = array(
                                        'type' => 'hidden',
                                        'name' => 'server_id',
                                        'id' => 'server_id',
                                        'value' => '',
                                    );
                                    echo form_input($hidden_id);
                                ?>
                                <label for="task_title">Название сервера</label>
                                <input type="text" class="form-control" id="server_title_input" name="server_title" placeholder="Название сервера">
                            </div>
                            <div class="modal-footer">
                                    <button type="button" id="button_test" class="btn btn-danger" data-toggle="modal" data-target="#delete_modal">Удалить</button>
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
                                    <button type="submit" class="btn btn-primary">Сохранить</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Модальное окно удаления задания -->
        <div class="modal fade" id="delete_modal" tabindex="2" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Удаление</h4>
                    </div>
                    <form method="POST" action="<?= base_url(); ?>task/update_task">
                        <div class="modal-body">
                            <div class="form-group">
                                <?php
                                    $hidden_id = array(
                                        'type' => 'hidden',
                                        'name' => 'task_delete_id',
                                        'id' => 'task_delete_id',
                                        'value' => '',
                                    );
                                    echo form_input($hidden_id);
                                ?>
                                <p>Вы уверены что хотите удалить <b><span id="task_delete_title"></span></b></p>
                                
                            </div>
                            <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
                                    <a id="task_del" class="btn btn-danger">Удалить</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
            
            <!-- Заполнение модального окна данными -->
            <script type="text/javascript">
                $(document).ready(function(){
                    // Редактирование Задания
                    $(document).on("click", ".open-edit-modal", function () {
                        var tr_id = $(this).data('tr-id');
                        $.ajax({
                            url: '<?= base_url();?>task/get_one_task/', // ссылка на обработчик
                            type: "POST",
                            data: 'tr_id=' + tr_id,
                            success: function (data) {
                                parse = JSON.parse(data);
                                $("#task_id").val(parse[0].id);
                                $("#task_title").val(parse[0].title);
                                $("#task_description").val(parse[0].description);
                                $("#task_delete_title").html(parse[0].title);
                                $("a#task_del").attr("href", "<?= base_url();?>task/delete_task/" + parse[0].id);
                            },
                            error: function () {
                                // обработка если надо
                            }
                        });                        
                    });
                    // Редактирование Сервера
                    $(document).on("click", ".open-edit-server-modal", function () {
                        var tr_id = $(this).data('tr-id');
                        $.ajax({
                            url: '<?= base_url();?>task/get_one_server/', // ссылка на обработчик
                            type: "POST",
                            data: 'tr_id=' + tr_id,
                            success: function (data) {
                                console.log(data);
                                parse = JSON.parse(data);
                                $("#server_id").val(parse[0].id);
                                $("#server_title_input").val(parse[0].title);
                                $("#task_delete_title").html(parse[0].title);
                                $("a#task_del").attr("href", "<?= base_url();?>task/delete_server/" + parse[0].id);
                                console.log(parse[0].title);
                            },
                            error: function () {
                                // обработка если надо
                            }
                        });                        
                    });


                })
            </script>

        <!-- Перетаскивание строк таблицы -->
        <script type="text/javascript">
            $("#sort tbody").sortable({
                cursor: "move",
                update: function() {
                    $.ajax({
                        url: '<?= base_url();?>task/sort_save/', // ссылка на обработчик
                        type: "POST",
                        data: { order: $('#sort tbody').sortable("toArray")},
                        success: function (data) {
                            // обработка если надо
                        },
                        error: function () {
                            // обработка если надо
                        }
                    });
                }
            });
            $("#sort tbody").disableSelection();
        </script>
    </body>
    </html>