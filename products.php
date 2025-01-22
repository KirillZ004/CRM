<?php

session_start();

require_once 'api/auth/AuthCheck.php';
AuthCheck('login.php');

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRM | Товары</title>
    <link rel="stylesheet" href="styles/modules/font-awesome-4.7.0/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="styles/settings.css">
    <link rel="stylesheet" href="styles/pages/products.css">
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
            <p class="header__admin">Фамилия И.О.</p>
            <ul class="header__links">
                <li><a href="">Клиент</a></li>
                <li><a href="">Товары</a></li>
                <li><a href="">Заказы</a></li>
            </ul>
            <a  class="header__logout" href="">Выйти</a>
        </div>
    </header>
    <main>
        <section class="filters">
            <div class="container">
                <form action="">
                    <label for="search">Поиск по названию</label>
                    <input type="text" id="search" name="search" placeholder="Введите название товара">
                    
                    <label for="filterBy">Фильтровать по:</label>
                    <select name="filterBy" id="filterBy">
                        <option value="name">Название</option>
                        <option value="price">Цена</option>
                        <option value="quantity">Количество</option>
                    </select>

                    <label for="sortOrder">Сортировка:</label>
                    <select name="sortOrder" id="sortOrder">
                        <option value="asc">По возрастанию</option>
                        <option value="desc">По убыванию</option>
                    </select>
                </form>
                
            </div>
        </section>
<h2 class="products__title">Список товаров</h2>
                <button onclick="MicroModal.show('modal-add-product')" class="products__add">
                    <i class="fa fa-plus fa-1x" aria-hidden="true"></i>
                </button>
        <section class="products">
            <div class="container">
                
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Название</th>
                            <th>Описание</th>
                            <th>Цена</th>
                            <th>Количество</th>
                            <th>Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Смартфон iPhone 13</td>
                            <td>256GB, черный, 2022 года</td>
                            <td>79 990 ₽</td>
                            <td>15</td>
                            <td>
                                <i class="fa fa-edit icon" title="Редактировать"></i>
                                <i class="fa fa-trash icon" title="Удалить"></i>
                                <i class="fa fa-qrcode icon" title="Создать QR-код"></i>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Ноутбук ASUS ROG</td>
                            <td>RTX 3060, 16GB RAM, 512GB SSD</td>
                            <td>129 990 ₽</td>
                            <td>8</td>
                            <td>
                                <i class="fa fa-edit icon" title="Редактировать"></i>
                                <i class="fa fa-trash icon" title="Удалить"></i>
                                <i class="fa fa-qrcode icon" title="Создать QR-код"></i>
                            </td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Наушники Sony WH-1000XM4</td>
                            <td>Беспроводные с шумоподавлением</td>
                            <td>27 990 ₽</td>
                            <td>20</td>
                            <td>
                                <i class="fa fa-edit icon" title="Редактировать"></i>
                                <i class="fa fa-trash icon" title="Удалить"></i>
                                <i class="fa fa-qrcode icon" title="Создать QR-код"></i>
                            </td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>Планшет Samsung Galaxy Tab S7</td>
                            <td>128GB, Wi-Fi, серебристый</td>
                            <td>49 990 ₽</td>
                            <td>12</td>
                            <td>
                                <i class="fa fa-edit icon" title="Редактировать"></i>
                                <i class="fa fa-trash icon" title="Удалить"></i>
                                <i class="fa fa-qrcode icon" title="Создать QR-код"></i>
                            </td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td>Умные часы Apple Watch Series 7</td>
                            <td>GPS, 45mm, алюминий</td>
                            <td>39 990 ₽</td>
                            <td>25</td>
                            <td>
                                <i class="fa fa-edit icon" title="Редактировать"></i>
                                <i class="fa fa-trash icon" title="Удалить"></i>
                                <i class="fa fa-qrcode icon" title="Создать QR-код"></i>
                            </td>
                        </tr>
                        <tr>
                            <td>6</td>
                            <td>Монитор LG UltraGear</td>
                            <td>27", 144Hz, 1ms, IPS</td>
                            <td>34 990 ₽</td>
                            <td>10</td>
                            <td>
                                <i class="fa fa-edit icon" title="Редактировать"></i>
                                <i class="fa fa-trash icon" title="Удалить"></i>
                                <i class="fa fa-qrcode icon" title="Создать QR-код"></i>
                            </td>
                        </tr>
                        <tr>
                            <td>7</td>
                            <td>Клавиатура Logitech G Pro X</td>
                            <td>Механическая, RGB подсветка</td>
                            <td>12 990 ₽</td>
                            <td>30</td>
                            <td>
                                <i class="fa fa-edit icon" title="Редактировать"></i>
                                <i class="fa fa-trash icon" title="Удалить"></i>
                                <i class="fa fa-qrcode icon" title="Создать QR-код"></i>
                            </td>
                        </tr>
                        <tr>
                            <td>8</td>
                            <td>Мышь Razer DeathAdder V2</td>
                            <td>20000 DPI, RGB подсветка</td>
                            <td>5 990 ₽</td>
                            <td>40</td>
                            <td>
                                <i class="fa fa-edit icon" title="Редактировать"></i>
                                <i class="fa fa-trash icon" title="Удалить"></i>
                                <i class="fa fa-qrcode icon" title="Создать QR-код"></i>
                            </td>
                        </tr>
                        <tr>
                            <td>9</td>
                            <td>Видеокарта NVIDIA RTX 3080</td>
                            <td>10GB GDDR6X, RGB подсветка</td>
                            <td>89 990 ₽</td>
                            <td>5</td>
                            <td>
                                <i class="fa fa-edit icon" title="Редактировать"></i>
                                <i class="fa fa-trash icon" title="Удалить"></i>
                                <i class="fa fa-qrcode icon" title="Создать QR-код"></i>
                            </td>
                        </tr>
                        <tr>
                            <td>10</td>
                            <td>Процессор Intel Core i9-12900K</td>
                            <td>16 ядер, 5.2 GHz</td>
                            <td>54 990 ₽</td>
                            <td>18</td>
                            <td>
                                <i class="fa fa-edit icon" title="Редактировать"></i>
                                <i class="fa fa-trash icon" title="Удалить"></i>
                                <i class="fa fa-qrcode icon" title="Создать QR-код"></i>
                            </td>
                        </tr>
                        <tr></tr>
                            <td>1</td>
                            <td>Смартфон iPhone 13</td>
                            <td>256GB, черный, 2022 года</td>
                            <td>79 990 ₽</td>
                            <td>15</td>
                            <td>
                                <i class="fa fa-edit icon" title="Редактировать"></i>
                                <i class="fa fa-trash icon" title="Удалить"></i>
                                <i class="fa fa-qrcode icon" title="Создать QR-код"></i>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Ноутбук ASUS ROG</td>
                            <td>RTX 3060, 16GB RAM, 512GB SSD</td>
                            <td>129 990 ₽</td>
                            <td>8</td>
                            <td>
                                <i class="fa fa-edit icon" title="Редактировать"></i>
                                <i class="fa fa-trash icon" title="Удалить"></i>
                                <i class="fa fa-qrcode icon" title="Создать QR-код"></i>
                            </td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Наушники Sony WH-1000XM4</td>
                            <td>Беспроводные с шумоподавлением</td>
                            <td>27 990 ₽</td>
                            <td>20</td>
                            <td>
                                <i class="fa fa-edit icon" title="Редактировать"></i>
                                <i class="fa fa-trash icon" title="Удалить"></i>
                                <i class="fa fa-qrcode icon" title="Создать QR-код"></i>
                            </td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>Планшет Samsung Galaxy Tab S7</td>
                            <td>128GB, Wi-Fi, серебристый</td>
                            <td>49 990 ₽</td>
                            <td>12</td>
                            <td>
                                <i class="fa fa-edit icon" title="Редактировать"></i>
                                <i class="fa fa-trash icon" title="Удалить"></i>
                                <i class="fa fa-qrcode icon" title="Создать QR-код"></i>
                            </td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td>Умные часы Apple Watch Series 7</td>
                            <td>GPS, 45mm, алюминий</td>
                            <td>39 990 ₽</td>
                            <td>25</td>
                            <td>
                                <i class="fa fa-edit icon" title="Редактировать"></i>
                                <i class="fa fa-trash icon" title="Удалить"></i>
                                <i class="fa fa-qrcode icon" title="Создать QR-код"></i>
                            </td>
                        </tr>
                        <tr>
                            <td>6</td>
                            <td>Монитор LG UltraGear</td>
                            <td>27", 144Hz, 1ms, IPS</td>
                            <td>34 990 ₽</td>
                            <td>10</td>
                            <td>
                                <i class="fa fa-edit icon" title="Редактировать"></i>
                                <i class="fa fa-trash icon" title="Удалить"></i>
                                <i class="fa fa-qrcode icon" title="Создать QR-код"></i>
                            </td>
                        </tr>
                        <tr>
                            <td>7</td>
                            <td>Клавиатура Logitech G Pro X</td>
                            <td>Механическая, RGB подсветка</td>
                            <td>12 990 ₽</td>
                            <td>30</td>
                            <td>
                                <i class="fa fa-edit icon" title="Редактировать"></i>
                                <i class="fa fa-trash icon" title="Удалить"></i>
                                <i class="fa fa-qrcode icon" title="Создать QR-код"></i>
                            </td>
                        </tr>
                        <tr>
                            <td>8</td>
                            <td>Мышь Razer DeathAdder V2</td>
                            <td>20000 DPI, RGB подсветка</td>
                            <td>5 990 ₽</td>
                            <td>40</td>
                            <td>
                                <i class="fa fa-edit icon" title="Редактировать"></i>
                                <i class="fa fa-trash icon" title="Удалить"></i>
                                <i class="fa fa-qrcode icon" title="Создать QR-код"></i>
                            </td>
                        </tr>
                        <tr>
                            <td>9</td>
                            <td>Видеокарта NVIDIA RTX 3080</td>
                            <td>10GB GDDR6X, RGB подсветка</td>
                            <td>89 990 ₽</td>
                            <td>5</td>
                            <td>
                                <i class="fa fa-edit icon" title="Редактировать"></i>
                                <i class="fa fa-trash icon" title="Удалить"></i>
                                <i class="fa fa-qrcode icon" title="Создать QR-код"></i>
                            </td>
                        </tr>
                        <tr>
                            <td>10</td>
                            <td>Процессор Intel Core i9-12900K</td>
                            <td>16 ядер, 5.2 GHz</td>
                            <td>54 990 ₽</td>
                            <td>18</td>
                            <td>
                                <i class="fa fa-edit icon" title="Редактировать"></i>
                                <i class="fa fa-trash icon" title="Удалить"></i>
                                <i class="fa fa-qrcode icon" title="Создать QR-код"></i>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
    </main>    

    <!-- Модальное окно для добавления товара -->
    <div class="modal micromodal-slide" id="modal-add-product" aria-hidden="true">
        <div class="modal__overlay" tabindex="-1" data-micromodal-close>
            <div class="modal__container" role="dialog" aria-modal="true" aria-labelledby="modal-add-product-title">
                <header class="modal__header">
                    <h2 class="modal__title" id="modal-add-product-title">
                        Добавить товар
                    </h2>
                    <button class="modal__close" aria-label="Close modal" data-micromodal-close></button>
                </header>
                <main class="modal__content" id="modal-add-product-content">
                    <form id="add-product-form">
                        <div class="form-group">
                            <label for="product-name">Название товара</label>
                            <input type="text" id="product-name" name="product-name" required>
                        </div>
                        <div class="form-group">
                            <label for="product-description">Описание</label>
                            <textarea id="product-description" name="product-description" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="product-price">Цена (₽)</label>
                            <input type="number" id="product-price" name="product-price" min="0" required>
                        </div>
                        <div class="form-group">
                            <label for="product-quantity">Количество</label>
                            <input type="number" id="product-quantity" name="product-quantity" min="0" required>
                        </div>
                    </form>
                </main>
                <footer class="modal__footer">
                    <button class="modal__btn modal__btn-primary" form="add-product-form">Добавить</button>
                    <button class="modal__btn" data-micromodal-close>Отмена</button>
                </footer>
            </div>
        </div>
    </div>

    <!-- Модальное окно для редактирования товара -->
    <div class="modal micromodal-slide" id="modal-edit-product" aria-hidden="true">
        <div class="modal__overlay" tabindex="-1" data-micromodal-close>
            <div class="modal__container" role="dialog" aria-modal="true" aria-labelledby="modal-edit-product-title">
                <header class="modal__header">
                    <h2 class="modal__title" id="modal-edit-product-title">
                        Редактировать товар
                    </h2>
                    <button class="modal__close" aria-label="Close modal" data-micromodal-close></button>
                </header>
                <main class="modal__content" id="modal-edit-product-content">
                    <form id="edit-product-form">
                        <input type="hidden" id="edit-product-id" name="edit-product-id">
                        <div class="form-group">
                            <label for="edit-product-name">Название товара</label>
                            <input type="text" id="edit-product-name" name="edit-product-name" required>
                        </div>
                        <div class="form-group">
                            <label for="edit-product-description">Описание</label>
                            <textarea id="edit-product-description" name="edit-product-description" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="edit-product-price">Цена (₽)</label>
                            <input type="number" id="edit-product-price" name="edit-product-price" min="0" required>
                        </div>
                        <div class="form-group">
                            <label for="edit-product-quantity">Количество</label>
                            <input type="number" id="edit-product-quantity" name="edit-product-quantity" min="0" required>
                        </div>
                    </form>
                </main>
                <footer class="modal__footer">
                    <button class="modal__btn modal__btn-primary" form="edit-product-form">Сохранить</button>
                    <button class="modal__btn" data-micromodal-close>Отмена</button>
                </footer>
            </div>
        </div>
    </div>

    <!-- Модальное окно для подтверждения удаления -->
    <div class="modal micromodal-slide" id="delete-modal" aria-hidden="true">
        <div class="modal__overlay" tabindex="-1" data-micromodal-close>
          <div class="modal__container" role="dialog" aria-modal="true" aria-labelledby="modal-1-title">
            <header class="modal__header">
              <h2 class="modal__title" id="modal-1-title">
                Вы уверены, что хотите удалить товар?
              </h2>
              <button class="modal__close" aria-label="Close modal" data-micromodal-close></button>
            </header>
            <main class="modal__content" id="modal-1-content">
                <button>Удалить</button>
                <button onclick="MicroModal.close('delete-modal');">Отменить</button>
            </main>
          </div>
        </div>
    </div>

    <!-- Модальное окно для QR-кода -->
    <div class="modal micromodal-slide" id="qr-modal" aria-hidden="true">
        <div class="modal__overlay" tabindex="-1" data-micromodal-close>
          <div class="modal__container" role="dialog" aria-modal="true" aria-labelledby="modal-qr-title">
            <header class="modal__header">
              <h2 class="modal__title" id="modal-qr-title">
                Создать QR-код
              </h2>
              <button class="modal__close" aria-label="Close modal" data-micromodal-close></button>
            </header>
            <main class="modal__content" id="modal-qr-content">
                <div id="qr-code-container"></div>
                <button onclick="MicroModal.close('qr-modal');">Закрыть</button>
            </main>
          </div>
        </div>
    </div>

    <script src="https://unpkg.com/micromodal/dist/micromodal.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/qrcode@1.4.4/build/qrcode.min.js"></script>
    <script>
        // Инициализация модальных окон
        MicroModal.init();

        // Открытие модального окна добавления товара
        document.querySelector('.add-product-btn').addEventListener('click', () => {
            MicroModal.show('modal-add-product');
        });

        // Открытие модального окна редактирования при клике на иконку редактирования
        document.querySelectorAll('.fa-edit').forEach(editIcon => {
            editIcon.addEventListener('click', () => {
                const row = editIcon.closest('tr');
                // Заполнение формы данными из строки таблицы
                document.getElementById('edit-product-id').value = row.cells[0].textContent;
                document.getElementById('edit-product-name').value = row.cells[1].textContent;
                document.getElementById('edit-product-description').value = row.cells[2].textContent;
                document.getElementById('edit-product-price').value = row.cells[3].textContent.replace(/[^\d]/g, '');
                document.getElementById('edit-product-quantity').value = row.cells[4].textContent;
                
                MicroModal.show('modal-edit-product');
            });
        });

        // Обработчик для кнопок удаления
        document.querySelectorAll('.fa-trash').forEach(deleteIcon => {
            deleteIcon.addEventListener('click', () => {
                MicroModal.show('delete-modal');
            });
        });

        // Обработчик для кнопок QR-кода
        document.querySelectorAll('.fa-qrcode').forEach(qrIcon => {
            qrIcon.addEventListener('click', () => {
                const row = qrIcon.closest('tr');
                const productData = {
                    id: row.cells[0].textContent,
                    name: row.cells[1].textContent,
                    description: row.cells[2].textContent,
                    price: row.cells[3].textContent,
                    quantity: row.cells[4].textContent
                };
                
                // Очищаем контейнер перед созданием нового QR-кода
                const container = document.getElementById('qr-code-container');
                container.innerHTML = '';
                
                // Создаем QR-код
                QRCode.toCanvas(container, JSON.stringify(productData), function (error) {
                    if (error) console.error(error);
                });
                
                MicroModal.show('qr-modal');
            });
        });
    </script>
</body>
</html>