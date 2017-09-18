    <script type="text/javascript">
            $(document).ready(function() {
                // Initialise the table
                $("#table-1").tableDnD();
            });
        </script>
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
                        foreach ($task as $key => $i) {
                            echo '<tr id="' . $i['id'] . '">';
                                echo '<td class="task_title">';
                                echo $i['task_title'];
                                echo '</td>';
                                
                                echo '<td>'.$i['id'].'</td>';
                                echo '<td>'.$i['order_id'].'</td>';
                            echo '</tr>';

                        }
                        ?>
                    </tbody>
                </table >


                <a href="<?= base_url();?>" type="button" class="btn btn-default" >Назад</a>
                <button type="button" id="button_add" class="btn btn-default" data-toggle="modal" data-target="#add_modal">Добавить задание</button>
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

        <!-- <script type="text/javascript">
            $keys = Array(
                'id'=>Array('auto_increment'),
                'title'=>Array('default'=>'habrahabr'), 
                'posts', 
                'userId'
                );
            $jdb->create('habr', $keys);
        </script> -->
       



        <!-- Перетаскивание строк таблицы -->
        <script type="text/javascript">
            // var fixHelper = function(e, ui) {
            //     ui.children().each(function() {
            //         $(this).width($(this).width());
            //     });
            //     return ui;
            // };
            $("#sort tbody").sortable({
                // helper: fixHelper,
                cursor: "move",
                update: function() {
                    // alert('Hello');
                    $.ajax({
                    url: '<?= base_url();?>task/sort_save/', // ссылка на обработчик
                    type: "POST",
                    data: { order: $('#sort tbody').sortable("toArray")
                    },
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