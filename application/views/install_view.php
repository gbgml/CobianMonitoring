<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>CobianMonitoring</title>
    <link rel="shortcut icon" href="/assets/img/CobianMonitoring.png" type="image/png">
    <link href="/assets/css/common.css" rel="stylesheet" type="text/css" media="all" />
    <link href="/assets/css/bootstrap-3.3.7.css" rel="stylesheet" type="text/css" media="all" />
    <script type="text/javascript" src="/assets/js/jquery-3.2.1.js"></script>
    <script type="text/javascript" src="/'assets/js/common.js"></script>
    <script type="text/javascript" src="/assets/js/bootstrap-3.3.7.js"></script>
</head>
<body>
    <div id="container_install">
        <div id="body">
            <h2 class="text-center">Начальная настройка</h2><br><br>
            <form action="/main/install" method="POST" class="form-horizontal">
                <div class="form-group">
                    <label for="inputBaseUrl" class="col-sm-4 control-label">URL сайта</label>
                    <div class="col-sm-8">
                        <input type="url" name="inputBaseUrl" class="form-control" id="inputBaseUrl" placeholder="http://test">
                    </div>
                </div> 
                <div class="form-group">
                    <label for="inputDBServer" class="col-sm-4 control-label">Сервер БД</label>
                    <div class="col-sm-8">
                        <input type="text" name="inputDBServer" class="form-control" id="inputDBServer" placeholder="db_server">
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputDBLogin" class="col-sm-4 control-label">Логин БД</label>
                    <div class="col-sm-8">
                        <input type="text" name="inputDBLogin" class="form-control" id="inputDBLogin" placeholder="root">
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputDBPassword" class="col-sm-4 control-label">Пароль БД</label>
                    <div class="col-sm-8">
                        <input type="password" name="inputDBPassword" class="form-control" id="inputDBPassword" placeholder="Password">
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputEmailUser" class="col-sm-4 control-label">Email для отчетов</label>
                    <div class="col-sm-8">
                        <input type="email" name="inputEmailUser" class="form-control" id="inputEmailUser" placeholder="Email">
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputEmailPassword" class="col-sm-4 control-label">Пароль от Email</label>
                    <div class="col-sm-8">
                        <input type="password" name="inputEmailPassword" class="form-control" id="inputEmailPassword" placeholder="Password">
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputEmailServer" class="col-sm-4 control-label">Сервер Email</label>
                    <div class="col-sm-8">
                        <input type="text" name="inputEmailServer" class="form-control" id="inputEmailServer" placeholder="server">
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputEmailPop3Port" class="col-sm-4 control-label">POP3 порт Email Сервера</label>
                    <div class="col-sm-8">
                        <input type="text" name="inputEmailPop3Port" class="form-control" id="inputEmailPop3Port" placeholder="110">
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-4 col-sm-8">
                      <button type="submit" class="btn btn-primary">Сохранить</button>
                  </div>
              </div>



          </form>
      </div>
  </div>
</body>
</html>