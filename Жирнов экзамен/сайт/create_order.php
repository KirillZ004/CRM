<?php
session_start();

// Проверка авторизации
if (!isset($_SESSION['token']) || empty($_SESSION['token'])) {
    header("Location: login.php");
    exit();
}

// Подключение к БД
require_once 'db.php';

// Получаем информацию о пользователе по токену
$token = $_SESSION['token'];
$stmt = $db->prepare("SELECT id, login, type, full_name FROM users WHERE token = ?");
$stmt->execute([$token]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Если пользователь не найден или не официант
if (!$user || $user['type'] !== 'waiter') {
    $_SESSION['token'] = '';
    header("Location: login.php");
    exit();
}

// Обработка создания заказа
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $db->beginTransaction();

        // Создание заказа
        $stmt = $db->prepare("
            INSERT INTO orders (shift_id, table_id, waiter_id, status, total_amount, created_at) 
            VALUES (?, ?, ?, 'new', ?, NOW())
        ");
        
        $total_amount = 0;
        foreach ($_POST['items'] as $item) {
            $total_amount += $item['price'] * $item['quantity'];
        }

        $stmt->execute([
            $_POST['shift_id'],
            $_POST['table_id'],
            $user['id'],
            $total_amount
        ]);

        $order_id = $db->lastInsertId();

        // Добавление позиций заказа
        $stmt = $db->prepare("
            INSERT INTO order_items (order_id, menu_item_id, quantity, price, notes) 
            VALUES (?, ?, ?, ?, ?)
        ");

        foreach ($_POST['items'] as $item) {
            $stmt->execute([
                $order_id,
                $item['menu_item_id'],
                $item['quantity'],
                $item['price'],
                $item['notes'] ?? null
            ]);
        }

        $db->commit();
        header("Location: orders.php");
        exit();

    } catch (Exception $e) {
        $db->rollBack();
        $error = "Ошибка при создании заказа: " . $e->getMessage();
    }
}

// Получение списка активных смен
$shifts = $db->query("
    SELECT * FROM shifts 
    WHERE date >= CURRENT_DATE 
    ORDER BY date ASC
")->fetchAll(PDO::FETCH_ASSOC);

// Получение списка столов
$tables = $db->query("SELECT * FROM tables ORDER BY name")->fetchAll(PDO::FETCH_ASSOC);

// Получение списка меню
$menu_items = $db->query("
    SELECT * FROM menu_items 
    WHERE is_active = 1 
    ORDER BY category, name
")->fetchAll(PDO::FETCH_ASSOC);

// Группировка пунктов меню по категориям
$menu_by_category = [];
foreach ($menu_items as $item) {
    $menu_by_category[$item['category']][] = $item;
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Создание заказа</title>
    <link rel="stylesheet" href="styles/add.css">
</head>
<body>
    <div class="container">
        <div class="user-info">
            <span>Пользователь: <?php echo htmlspecialchars($user['full_name']); ?></span>
            <span>Роль: Официант</span>
            <a href="logout.php" class="btn-logout">Выйти</a>
        </div>

        <h1>Создание заказа</h1>

        <?php if (isset($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST" id="orderForm" class="order-form">
            <div class="form-group">
                <label for="shift_id">Смена:</label>
                <select name="shift_id" id="shift_id" required>
                    <?php foreach ($shifts as $shift): ?>
                        <option value="<?php echo $shift['id']; ?>">
                            <?php echo date('d.m.Y', strtotime($shift['date'])); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="table_id">Стол:</label>
                <select name="table_id" id="table_id" required>
                    <?php foreach ($tables as $table): ?>
                        <option value="<?php echo $table['id']; ?>">
                            <?php echo htmlspecialchars($table['name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div id="orderItems" class="order-items">
                <h2>Позиции заказа</h2>
                <div class="menu-categories">
                    <?php foreach ($menu_by_category as $category => $items): ?>
                        <div class="menu-category">
                            <h3><?php echo htmlspecialchars($category); ?></h3>
                            <div class="menu-items">
                                <?php foreach ($items as $item): ?>
                                    <div class="menu-item" data-id="<?php echo $item['id']; ?>" data-price="<?php echo $item['price']; ?>">
                                        <div class="item-info">
                                            <span class="item-name"><?php echo htmlspecialchars($item['name']); ?></span>
                                            <span class="item-price"><?php echo number_format($item['price'], 2, '.', ' '); ?> ₽</span>
                                        </div>
                                        <div class="item-actions">
                                            <button type="button" class="btn-add-item">Добавить</button>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div id="selectedItems" class="selected-items">
                    <h3>Выбранные позиции</h3>
                    <div class="items-list"></div>
                    <div class="order-total">
                        Итого: <span id="totalAmount">0.00</span> ₽
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-submit">Создать заказ</button>
                <a href="orders.php" class="btn-back">Отмена</a>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selectedItems = new Map();
            const itemsList = document.querySelector('.items-list');
            const totalAmountElement = document.getElementById('totalAmount');

            function updateTotal() {
                let total = 0;
                selectedItems.forEach(item => {
                    total += item.price * item.quantity;
                });
                totalAmountElement.textContent = total.toFixed(2);
            }

            function updateItemsList() {
                itemsList.innerHTML = '';
                selectedItems.forEach((item, id) => {
                    const itemElement = document.createElement('div');
                    itemElement.className = 'selected-item';
                    itemElement.innerHTML = `
                        <input type="hidden" name="items[${id}][menu_item_id]" value="${id}">
                        <input type="hidden" name="items[${id}][price]" value="${item.price}">
                        <div class="item-details">
                            <span class="item-name">${item.name}</span>
                            <span class="item-price">${item.price.toFixed(2)} ₽</span>
                        </div>
                        <div class="item-controls">
                            <button type="button" class="btn-decrease">-</button>
                            <input type="number" name="items[${id}][quantity]" value="${item.quantity}" min="1" class="quantity-input">
                            <button type="button" class="btn-increase">+</button>
                            <textarea name="items[${id}][notes]" placeholder="Примечания" class="item-notes">${item.notes || ''}</textarea>
                            <button type="button" class="btn-remove">Удалить</button>
                        </div>
                    `;

                    // Обработчики кнопок
                    const quantityInput = itemElement.querySelector('.quantity-input');
                    const notesInput = itemElement.querySelector('.item-notes');

                    itemElement.querySelector('.btn-decrease').addEventListener('click', () => {
                        if (item.quantity > 1) {
                            item.quantity--;
                            quantityInput.value = item.quantity;
                            updateTotal();
                        }
                    });

                    itemElement.querySelector('.btn-increase').addEventListener('click', () => {
                        item.quantity++;
                        quantityInput.value = item.quantity;
                        updateTotal();
                    });

                    quantityInput.addEventListener('change', () => {
                        item.quantity = Math.max(1, parseInt(quantityInput.value) || 1);
                        quantityInput.value = item.quantity;
                        updateTotal();
                    });

                    notesInput.addEventListener('change', () => {
                        item.notes = notesInput.value;
                    });

                    itemElement.querySelector('.btn-remove').addEventListener('click', () => {
                        selectedItems.delete(id);
                        updateItemsList();
                        updateTotal();
                    });

                    itemsList.appendChild(itemElement);
                });
            }

            // Обработчики добавления позиций
            document.querySelectorAll('.btn-add-item').forEach(button => {
                button.addEventListener('click', () => {
                    const menuItem = button.closest('.menu-item');
                    const id = menuItem.dataset.id;
                    const price = parseFloat(menuItem.dataset.price);
                    const name = menuItem.querySelector('.item-name').textContent;

                    if (selectedItems.has(id)) {
                        const item = selectedItems.get(id);
                        item.quantity++;
                    } else {
                        selectedItems.set(id, {
                            name: name,
                            price: price,
                            quantity: 1,
                            notes: ''
                        });
                    }

                    updateItemsList();
                    updateTotal();
                });
            });

            // Валидация формы
            document.getElementById('orderForm').addEventListener('submit', (e) => {
                if (selectedItems.size === 0) {
                    e.preventDefault();
                    alert('Добавьте хотя бы одну позицию в заказ');
                }
            });
        });
    </script>
</body>
</html> 