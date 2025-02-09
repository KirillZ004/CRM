<?php session_start();
if (isset($_GET['do']) && $_GET['do'] === 'logout') {
    require_once 'api/auth/LogoutUser.php'; 
    require_once 'api/DB.php';

    LogoutUser('login.php', $DB, $_SESSION['token']);

}
require_once 'api/auth/AuthCheck.php';

AuthCheck('','login.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRM | Клиенты</title>
    <link rel="stylesheet" href="styles/modules/font-awesome-4.7.0/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="styles/settings.css">
    <link rel="stylesheet" href="styles/pages/clients.css">
    <link rel="stylesheet" href="styles/modules/micromodal.css" >
    <style>
        /* Sample CSS for table styling */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #f5f5f5;
        }
        .icon {
            cursor: pointer;
        }
    </style>
</head>
<body>
    <header class="header">
        <div class="container">
            <p class="header__admin">
                
            </p>
            <ul class="header__links">
                <li><a href="">Клиент</a></li>
                <li><a href="">Товары</a></li>
                <li><a href="">Заказы</a></li>
            </ul>
            <a href="?do=logout" class="header__logout">Выйти</a>
        </div>
    </header>
    <main>
        <section class="filters">
            <div class="container">
                <form action="">
                    <label for="search">Поск по имени</label>
                    <input type="text" id="search" name="search" placeholder="Кирилл">
                    <select name="sort" id="sort">
                        <option value="0">По возрастанию</option>
                        <option value="1">По убыванию</option>
                    </select>
                </form>
            </div>
        </section>
        <h2 class="clients__title">Список клиентов</h2>
            <button onclick="MicroModal.show('add-modal')" class="clients__add">
                <i class="fa fa-user-plus fa-1x" aria-hidden="true"></i>
            </button>
        <section class="clients">
            
            <div class="container">
           
                <table>
                    <thead>
                        <tr>
                            <th>ИД</th>
                            <th>ФИО</th>
                            <th>Почта</th>
                            <th>Телефон</th>
                            <th>День рождения</th>
                            <th>Дата создания</th>
                            <th>История заказов</th>
                            <th>Редактировать</th>
                            <th>Удалить</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                        require 'api/DB.php';
                        require_once ('api/clients/OutputClients.php');

                        $clients = $DB->query(
                            "SELECT * FROM clients
                            ")->fetchAll();

                        OutputClients($clients);
                        
                    ?>
                        <!-- Sample Data -->
                        <tr>
                            <td>0</td>
                            <td>Жирнов Кирилл Сергеевич</td>
                            <td>kirillzirnov47@gmail.ru</td>
                            <td>8-999-300-88-09</td>
                            <td>14.02.2004</td>
                            <td>2023-01-01</td> <!-- Sample creation date -->
                            <td onclick="MicroModal.show('history-modal')"><i class="fa fa-history"></i></td>
                            <td onclick="MicroModal.show('edit-modal')"><i class="fa fa-pencil"></i></td>
                            <td onclick="MicroModal.show('delete-modal')"><i class="fa fa-trash"></i></td>
                        </tr> 
                        <tr>
                            <td>1</td>
                            <td>Жирнов Кирилл Сергеевич</td>
                            <td>kirillzirnov47@gmail.ru</td>
                            <td>8-999-300-88-09</td>
                            <td>14.02.2004</td>
                            <td>2023-01-01</td> <!-- Sample creation date -->
                            <td><i class="fa fa-history icon" aria-hidden="true"></i></td>
                            <td><i class="fa fa-pencil-square-o icon" aria-hidden="true"></i></td>
                            <td><i class="fa fa-trash-o icon" aria-hidden="true"></i></td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Жирнов Кирилл Сергеевич</td>
                            <td>kirillzirnov47@gmail.ru</td>
                            <td>8-999-300-88-09</td>
                            <td>14.02.2004</td>
                            <td>2023-01-01</td> <!-- Sample creation date -->
                            <td><i class="fa fa-history icon" aria-hidden="true"></i></td>
                            <td><i class="fa fa-pencil-square-o icon" aria-hidden="true"></i></td>
                            <td><i class="fa fa-trash-o icon" aria-hidden="true"></i></td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Жирнов Кирилл Сергеевич</td>
                            <td>kirillzirnov47@gmail.ru</td>
                            <td>8-999-300-88-09</td>
                            <td>14.02.2004</td>
                            <td>2023-01-01</td> <!-- Sample creation date -->
                            <td><i class="fa fa-history icon" aria-hidden="true"></i></td>
                            <td><i class="fa fa-pencil-square-o icon" aria-hidden="true"></i></td>
                            <td><i class="fa fa-trash-o icon" aria-hidden="true"></i></td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Жирнов Кирилл Сергеевич</td>
                            <td>kirillzirnov47@gmail.ru</td>
                            <td>8-999-300-88-09</td>
                            <td>14.02.2004</td>
                            <td>2023-01-01</td> <!-- Sample creation date -->
                            <td><i class="fa fa-history icon" aria-hidden="true"></i></td>
                            <td><i class="fa fa-pencil-square-o icon" aria-hidden="true"></i></td>
                            <td><i class="fa fa-trash-o icon" aria-hidden="true"></i></td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Жирнов Кирилл Сергеевич</td>
                            <td>kirillzirnov47@gmail.ru</td>
                            <td>8-999-300-88-09</td>
                            <td>14.02.2004</td>
                            <td>2023-01-01</td> <!-- Sample creation date -->
                            <td><i class="fa fa-history icon" aria-hidden="true"></i></td>
                            <td><i class="fa fa-pencil-square-o icon" aria-hidden="true"></i></td>
                            <td><i class="fa fa-trash-o icon" aria-hidden="true"></i></td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Жирнов Кирилл Сергеевич</td>
                            <td>kirillzirnov47@gmail.ru</td>
                            <td>8-999-300-88-09</td>
                            <td>14.02.2004</td>
                            <td>2023-01-01</td> <!-- Sample creation date -->
                            <td><i class="fa fa-history icon" aria-hidden="true"></i></td>
                            <td><i class="fa fa-pencil-square-o icon" aria-hidden="true"></i></td>
                            <td><i class="fa fa-trash-o icon" aria-hidden="true"></i></td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Жирнов Кирилл Сергеевич</td>
                            <td>kirillzirnov47@gmail.ru</td>
                            <td>8-999-300-88-09</td>
                            <td>14.02.2004</td>
                            <td>2023-01-01</td> <!-- Sample creation date -->
                            <td><i class="fa fa-history icon" aria-hidden="true"></i></td>
                            <td><i class="fa fa-pencil-square-o icon" aria-hidden="true"></i></td>
                            <td><i class="fa fa-trash-o icon" aria-hidden="true"></i></td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Жирнов Кирилл Сергеевич</td>
                            <td>kirillzirnov47@gmail.ru</td>
                            <td>8-999-300-88-09</td>
                            <td>14.02.2004</td>
                            <td>2023-01-01</td> <!-- Sample creation date -->
                            <td><i class="fa fa-history icon" aria-hidden="true"></i></td>
                            <td><i class="fa fa-pencil-square-o icon" aria-hidden="true"></i></td>
                            <td><i class="fa fa-trash-o icon" aria-hidden="true"></i></td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Жирнов Кирилл Сергеевич</td>
                            <td>kirillzirnov47@gmail.ru</td>
                            <td>8-999-300-88-09</td>
                            <td>14.02.2004</td>
                            <td>2023-01-01</td> <!-- Sample creation date -->
                            <td><i class="fa fa-history icon" aria-hidden="true"></i></td>
                            <td><i class="fa fa-pencil-square-o icon" aria-hidden="true"></i></td>
                            <td><i class="fa fa-trash-o icon" aria-hidden="true"></i></td>
                            </tr>
                         <tr>
                            <td>2</td>
                            <td>Жирнов Кирилл Сергеевич</td>
                            <td>kirillzirnov47@gmail.ru</td>
                            <td>8-999-300-88-09</td>
                            <td>14.02.2004</td>
                            <td>2023-01-01</td> <!-- Sample creation date -->
                            <td><i class="fa fa-history icon" aria-hidden="true"></i></td>
                            <td><i class="fa fa-pencil-square-o icon" aria-hidden="true"></i></td>
                            <td><i class="fa fa-trash-o icon" aria-hidden="true"></i></td>
                            </tr>
                            <tr>
                            <td>2</td>
                            <td>Жирнов Кирилл Сергеевич</td>
                            <td>kirillzirnov47@gmail.ru</td>
                            <td>8-999-300-88-09</td>
                            <td>14.02.2004</td>
                            <td>2023-01-01</td> <!-- Sample creation date -->
                            <td><i class="fa fa-history icon" aria-hidden="true"></i></td>
                            <td><i class="fa fa-pencil-square-o icon" aria-hidden="true"></i></td>
                            <td><i class="fa fa-trash-o icon" aria-hidden="true"></i></td>
                            </tr>
                            <tr>
                            <td>2</td>
                            <td>Жирнов Кирилл Сергеевич</td>
                            <td>kirillzirnov47@gmail.ru</td>
                            <td>8-999-300-88-09</td>
                            <td>14.02.2004</td>
                            <td>2023-01-01</td> <!-- Sample creation date -->
                            <td><i class="fa fa-history icon" aria-hidden="true"></i></td>
                            <td><i class="fa fa-pencil-square-o icon" aria-hidden="true"></i></td>
                            <td><i class="fa fa-trash-o icon" aria-hidden="true"></i></td>
                            </tr>
                            <tr>
                            <td>2</td>
                            <td>Жирнов Кирилл Сергеевич</td>
                            <td>kirillzirnov47@gmail.ru</td>
                            <td>8-999-300-88-09</td>
                            <td>14.02.2004</td>
                            <td>2023-01-01</td> <!-- Sample creation date -->
                            <td><i class="fa fa-history icon" aria-hidden="true"></i></td>
                            <td><i class="fa fa-pencil-square-o icon" aria-hidden="true"></i></td>
                            <td><i class="fa fa-trash-o icon" aria-hidden="true"></i></td>
                            </tr>
                            <tr>
                            <td>2</td>
                            <td>Жирнов Кирилл Сергеевич</td>
                            <td>kirillzirnov47@gmail.ru</td>
                            <td>8-999-300-88-09</td>
                            <td>14.02.2004</td>
                            <td>2023-01-01</td> <!-- Sample creation date -->
                            <td><i class="fa fa-history icon" aria-hidden="true"></i></td>
                            <td><i class="fa fa-pencil-square-o icon" aria-hidden="true"></i></td>
                            <td><i class="fa fa-trash-o icon" aria-hidden="true"></i></td>
                            </tr>
                            <tr>
                            <td>2</td>
                            <td>Жирнов Кирилл Сергеевич</td>
                            <td>kirillzirnov47@gmail.ru</td>
                            <td>8-999-300-88-09</td>
                            <td>14.02.2004</td>
                            <td>2023-01-01</td> <!-- Sample creation date -->
                            <td><i class="fa fa-history icon" aria-hidden="true"></i></td>
                            <td><i class="fa fa-pencil-square-o icon" aria-hidden="true"></i></td>
                            <td><i class="fa fa-trash-o icon" aria-hidden="true"></i></td>
                            </tr>
                            <tr>
                            <td>2</td>
                            <td>Жирнов Кирилл Сергеевич</td>
                            <td>kirillzirnov47@gmail.ru</td>
                            <td>8-999-300-88-09</td>
                            <td>14.02.2004</td>
                            <td>2023-01-01</td> <!-- Sample creation date -->
                            <td><i class="fa fa-history icon" aria-hidden="true"></i></td>
                            <td><i class="fa fa-pencil-square-o icon" aria-hidden="true"></i></td>
                            <td><i class="fa fa-trash-o icon" aria-hidden="true"></i></td>
                            </tr>
                            <tr>
                            <td>2</td>
                            <td>Жирнов Кирилл Сергеевич</td>
                            <td>kirillzirnov47@gmail.ru</td>
                            <td>8-999-300-88-09</td>
                            <td>14.02.2004</td>
                            <td>2023-01-01</td> <!-- Sample creation date -->
                            <td><i class="fa fa-history icon" aria-hidden="true"></i></td>
                            <td><i class="fa fa-pencil-square-o icon" aria-hidden="true"></i></td>
                            <td><i class="fa fa-trash-o icon" aria-hidden="true"></i></td>
                            </tr>
                            <tr>
                            <td>2</td>
                            <td>Жирнов Кирилл Сергеевич</td>
                            <td>kirillzirnov47@gmail.ru</td>
                            <td>8-999-300-88-09</td>
                            <td>14.02.2004</td>
                            <td>2023-01-01</td> <!-- Sample creation date -->
                            <td><i class="fa fa-history icon" aria-hidden="true"></i></td>
                            <td><i class="fa fa-pencil-square-o icon" aria-hidden="true"></i></td>
                            <td><i class="fa fa-trash-o icon" aria-hidden="true"></i></td>
                            </tr>
                            
                    </tbody>
                </table>
            </div> 
        </section>
    </main>

    <div class="modal micromodal-slide" id="add-modal" aria-hidden="true">
        <div class="modal__overlay" tabindex="-1" data-micromodal-close>
          <div class="modal__container" role="dialog" aria-modal="true" aria-labelledby="modal-1-title">
            <header class="modal__header">
              <h2 class="modal__title" id="modal-1-title">
                Добавить клиента
              </h2>
              <button class="modal__close" aria-label="Close modal" data-micromodal-close></button>
            </header>
            <main class="modal__content" id="modal-1-content">
                <form>
                    <div class="reg-form-group">
                        <label for="fullName" class="reg-form-label">ФИО</label>
                        <input type="text" id="fullName" name="fullName" class="reg-form-input" required>
                    </div>
                    <div class="reg-form-group">
                        <label for="email" class="reg-form-label">Почта</label>
                        <input type="email" id="email" name="email" class="reg-form-input" required>
                    </div>
                    <div class="reg-form-group">
                        <label for="phone" class="reg-form-label">Телефон</label>
                        <input type="tel" id="phone" name="phone" class="reg-form-input" required>
                    </div>
                    <div class="reg-form-group">
                        <label for="birthDate" class="reg-form-label">День рождения</label>
                        <input type="date" id="birthDate" name="birthDate" class="reg-form-input" required>
                    </div>
                    <button type="submit" class="reg-form-button reg-form-create-button">Создать</button>
                    <button type="button" class="reg-form-button reg-form-cancel-button" onclick="MicroModal.close('add-modal');">Отменить</button>
                </form>
            </main>
          </div>
        </div>
    </div>

    <div class="modal micromodal-slide" id="edit-modal" aria-hidden="true">
        <div class="modal__overlay" tabindex="-1" data-micromodal-close>
          <div class="modal__container" role="dialog" aria-modal="true" aria-labelledby="modal-1-title">
            <header class="modal__header">
              <h2 class="modal__title" id="modal-1-title">
                Редактировать клиента
              </h2>
              <button class="modal__close" aria-label="Close modal" data-micromodal-close></button>
            </header>
            <main class="modal__content" id="modal-1-content">
                <form>
                    <div class="reg-form-group">
                        <label for="fullName" class="reg-form-label">ФИО</label>
                        <input type="text" id="fullName" name="fullName" class="reg-form-input" required>
                    </div>
                    <div class="reg-form-group">
                        <label for="email" class="reg-form-label">Почта</label>
                        <input type="email" id="email" name="email" class="reg-form-input" required>
                    </div>
                    <div class="reg-form-group">
                        <label for="phone" class="reg-form-label">Телефон</label>
                        <input type="tel" id="phone" name="phone" class="reg-form-input" required>
                    </div>
                    <button type="submit" class="reg-form-button reg-form-create-button">Редактировать</button>
                    <button type="button" class="reg-form-button reg-form-cancel-button" onclick="MicroModal.close('edit-modal');">Отменить</button>
                </form>
            </main>
          </div>
        </div>
    </div>

    <div class="modal micromodal-slide" id="delete-modal" aria-hidden="true">
        <div class="modal__overlay" tabindex="-1" data-micromodal-close>
          <div class="modal__container" role="dialog" aria-modal="true" aria-labelledby="modal-1-title">
            <header class="modal__header">
              <h2 class="modal__title" id="modal-1-title">
                <!--  -->
                Вы уверены , что хотите удалить клиента?
              </h2>
              <button class="modal__close" aria-label="Close modal" data-micromodal-close></button>
            </header>
            <!--  -->
            <main class="modal__content" id="modal-1-content">
                <button>Удалить</button>
                <button onclick="MicroModal.close('delete-modal');">Отменить</button>
            </main>
          </div>
        </div>
    </div>

    <div class="modal micromodal-slide" id="history-modal" aria-hidden="true">
        <div class="modal__overlay" tabindex="-1" data-micromodal-close>
          <div class="modal__container" role="dialog" aria-modal="true" aria-labelledby="modal-1-title">
            <header class="modal__header">
                <!-- Change -->
              <h2 class="modal__title" id="modal-1-title">
                История заказов
              </h2>
              <!-- Change -->
              <small>Фамилия Имя отчество</small>
              <button class="modal__close" aria-label="Close modal" data-micromodal-close></button>
            </header>
            <main class="modal__content" id="modal-1-content">
                <div class="order">
                    <div class="order__info">
                        <h3 class="order__number">Заказ №1</h3>
                        <time class="order__date">Дата оформления : 2025-01-13 09:25:36</time>
                        <p class="order__total">Общая сумма : 300.00</p>
                    </div>
                    <table class="order__items">
                        <tr>
                            <th>ИД</th>
                            <th>Название товара</th>
                            <th>Количество</th>
                            <th>Цена</th>
                        </tr>
                        <tr>
                            <td>9s13</td>
                            <td>Футболка</td>
                            <td>10</td>
                            <td>10000</td>
                        </tr>
                        <tr>
                            <td>9s13</td>
                            <td>Футболка</td>
                            <td>10</td>
                            <td>10000</td>
                        </tr>
                    </table>
                </div>
            </main>
          </div>
        </div>
    </div>
    
          

    <script defer 
    src="https://unpkg.com/micromodal/dist/micromodal.min.js"></script>
    <script defer src="scripts/initClientsModal.js"></script>
</body>
</html>

