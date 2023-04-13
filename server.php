<?php 
    # Устанавливаем заголовки, описание что это и зачем есть возле функции
    cors();

    # Подключаемся к базе данных
    $connect = mysqli_connect('localhost', 'root', '', 'machicoro');
    # Если не удалось подключиться, заканчиваем выполнение кода
    # В случае ошибки подключения переменная $connect будет равна null
    if(!$connect) exit;

    if(isset($_POST['uid']) and isset($_POST['vars'])){
        # Если данные пришли, записываем их в переменную
        $uid = $_POST['uid'];
        $vars = $_POST['vars'];
        $who = $_POST['who'];

        # Проверяем, есть ли запись о пользователе в базе данных, если нет, то создаем ее
        # Отправляем к базе данных запрос на получение всех записей из таблицы `vars_table`, где uid (колонка таблицы) равнв полученному из post uid
        $query = mysqli_query($connect, "SELECT * FROM `vars_table` WHERE `uid`='$uid'");

        # Проверяем размер ответа от базы данных (количество строк), если равно нулю, значит в базе данных нет записи о этом игроке, создаем запись
        if(mysqli_num_rows($query) == 0)
            mysqli_query($connect, "INSERT INTO `vars_table`(`uid`, `variables`,`who`) VALUES ('$uid', '$vars','$who')"); # Создаем запись о игроке в таблице
        else
            $query = mysqli_query($connect, "UPDATE `vars_table` SET `variables`='$vars', `who`='$who' WHERE `uid`='$uid'"); # Если же запись уже есть, обновляем ее, так как MySQL не позволяет обновлять записи пересозданием

        # Отправляем назад ответ в формате JSON
        exit(
            json_encode(array('status' => true))
        );
    }

 
    // if(isset($_GET['uid'])){
    //     $uid = $_GET['uid'];

    //     # Получаем из базы данных наши переменные в виде MySQL объекта
    //     # Отправляем к базе данных запрос на получение, как и в post
    //     $vars = mysqli_query($connect, "SELECT `variables` FROM `vars_table` WHERE `uid`='$uid';");

    //     # Проверяем, нашлась ли строка с нужным нам uid, если нет, возвращаем назад false, если нашлась, продолжаем выполнение кода
    //     if(mysqli_num_rows($vars) == 0)
    //         exit(
    //             json_encode(array('status' => false))
    //         );

    //     # Отправляем назад ответ
    //     exit(
    //         json_encode(array(
    //             'status' => true,

    //             # fetch_assoc - функция для перобразования объекта MySQL в PHP объект
    //             # Если результат от базы данных подразумевает ответ не одной строкой, а несколькими, нужно использовать mysqli_fetch_all
    //             # Ссылки на руководства по этим функциям будут внизу документа
    //             'variables' => mysqli_fetch_assoc($vars)
    //         ))
    //     );
    // }

    function cors() {
        if (isset($_SERVER['HTTP_ORIGIN'])) {
            header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
            header('Access-Control-Allow-Credentials: true');
            header('Access-Control-Max-Age: 86400');
        }

        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
                header("Access-Control-Allow-Methods: GET, POST, OPTIONS");         

            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
                header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
        }
    }

    mysqli_close($connect);

    // cors();

    // # Подключаемся к базе данных
    // $connect = new mysqli('127.0.0.1', 'root', '', 'machi');
    // $connect->query ("SET NAMES 'utf8'");
    // # Если не удалось подключиться, заканчиваем выполнение кода
    // # В случае ошибки подключения переменная $connect будет равна null
    // if(!$connect) exit;

    // # Сохраняем наши переменные в базе данных
    // # Для начала, ловим пост-запрос от вервера и проверяем, пришли ли нужные нам данные
    // # В этом случае - uid и vars
    // if(isset($_POST['uid']) and isset($_POST['vars']) and isset($_POST['who'])){

    //     # Если данные пришли, записываем их в переменную
    //     $uid = $_POST['uid'];
    //     $vars = $_POST['vars'];
    //     $who = $_POST['who'];

    //     # Проверяем, есть ли запись о пользователе в базе данных, если нет, то создаем ее
    //     # Отправляем к базе данных запрос на получение всех записей из таблицы `vars_table`, где uid (колонка таблицы) равнв полученному из post uid
    //     $query = $connect->query("SELECT * FROM `vars_table` WHERE `uid`='$uid';");

    //     # Проверяем размер ответа от базы данных (количество строк), если равно нулю, значит в базе данных нет записи о этом игроке, создаем запись
    //     if($query->num_rows == 0)
    //         $connect->query("INSERT INTO `vars_table`(`uid`, `variables`, `whp`) VALUES ('$uid', '$vars', '$who');"); # Создаем запись о игроке в таблице
    //     else
    //         $query = $connect->query("UPDATE `vars_table` SET `variables`='$vars', `who` = '$who' WHERE `uid`='$uid';"); # Если же запись уже есть, обновляем ее, так как MySQL не позволяет обновлять записи пересозданием

    //     # Отправляем назад ответ в формате JSON
    //     exit(
    //         json_encode(array('status' => true))
    //     );
    // }

    // # Получаем переменные из базы данных по уникальному ключу
    // # Тут мы уже ловим GET-запрос. Почему GET? Из эстетических соображений: GET - получить, POST - отправить

    // # Делаем всё то же самое, что и при поимке post-запроса
    // // if(isset($_GET['uid'])){
    // //     $uid = $_GET['uid'];

    // //     # Получаем из базы данных наши паременные в виде MySQL объекта
    // //     # Отправляем к базе данных запрос на получение, как и в post
    // //     $vars = $connect->query("SELECT `variables` FROM `vars_table` WHERE `uid`='$uid';");

    // //     # Проверяем, нашлась ли строка с нужным нам uid, если нет, возвращаем назад false, если нашлась, продолжаем выполнение кода
    // //     if(mysqli_num_rows($vars) == 0)
    // //         exit(
    // //             json_encode(array('status' => false))
    // //         );

    // //     # Отправляем назад ответ
    // //     # Отправляем JS результат поиска, т.е. наши переменные со статусом true
    // //     exit(
    // //         json_encode(array(
    // //             'status' => true,

    // //             # fetch_assoc - функция для перобразования объекта MySQL в PHP объект
    // //             # Если результат от базы данных подразумевает ответ не одной строкой, а несколькими, нужно использовать mysqli_fetch_all
    // //             # Ссылки на руководства по этим функциям будут внизу документа
    // //             'variables' => mysqli_fetch_assoc($vars)
    // //         ))
    // //     );
    // // }

    // # Функция установки заголовков
    // # Заголовки нужны для подтверждения безопасности сервера, к которому обращается JS скрипт
    // # Изучать это на данном уровне особо смысла не несет, достаточно скопировать эту функцию, а после запустить ее в самом начале документа
    // function cors() {
    //     if (isset($_SERVER['HTTP_ORIGIN'])) {
    //         header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    //         header('Access-Control-Allow-Credentials: true');
    //         header('Access-Control-Max-Age: 86400');
    //     }

    //     if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

    //         if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
    //             header("Access-Control-Allow-Methods: GET, POST, OPTIONS");         

    //         if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
    //             header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
    //     }
    // }

    // # Закрываем подключение к базе данных. Это действие не обязательно, но в больших приложениях позволяет обойти стороной утечки памяти
    // $connect->close();
?>