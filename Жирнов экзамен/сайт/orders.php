<?php
// orders.php
session_start();
require_once 'db.php';

// Проверка авторизации
if (!isset($_SESSION['token']) || empty($_SESSION['token'])) {
    header("Location: login.php");
    exit();
}

$token = $_SESSION['token'];
try {
    // Получаем информацию о пользователе
    $stmt = $db->prepare("SELECT id, login, type, full_name FROM users WHERE token = ?");
    $stmt->execute([$token]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user || !in_array($user['type'], ['cook', 'waiter'])) {
        $_SESSION['token'] = '';
        header("Location: login.php");
        exit();
    }

    // Получаем список смен для фильтрации
    $shifts = $db->query("SELECT * FROM shifts ORDER BY date DESC")->fetchAll(PDO::FETCH_ASSOC);

    // Получаем выбранную смену
    $selected_shift = isset($_GET['shift_id']) ? (int)$_GET['shift_id'] : null;

    // Обработка изменения статуса заказа
    if (isset($_POST['update_status'])) {
        $order_id = (int)$_POST['order_id'];
        $new_status = $_POST['new_status'];
        
        // Проверка допустимых статусов для каждой роли
        $allowed_statuses = [
            'cook' => ['ready', 'not_ready'],
            'waiter' => ['accepted', 'paid', 'closed']
        ];
        
        if (in_array($new_status, $allowed_statuses[$user['type']])) {
            $stmt = $db->prepare("UPDATE orders SET status = ? WHERE id = ?");
            $stmt->execute([$new_status, $order_id]);
        }
        
        header("Location: orders.php");
        exit();
    }

    // Фильтрация по смене
    $where_clause = $selected_shift ? "WHERE shift_id = $selected_shift" : "";

    // Получаем список заказов
    $query = "
        SELECT o.*, s.date as shift_date, t.name as table_name, w.full_name as waiter_name 
        FROM orders o 
        LEFT JOIN shifts s ON o.shift_id = s.id 
        LEFT JOIN tables t ON o.table_id = t.id 
        LEFT JOIN users w ON o.waiter_id = w.id 
        $where_clause 
        ORDER BY o.created_at DESC
    ";

    $stmt = $db->prepare($query);
    $stmt->execute();
    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die('Ошибка базы данных: ' . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Управление заказами</title>
    <link rel="stylesheet" href="styles/add.css">
    <style>
        .order-filters {
            margin-bottom: 20px;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 5px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .order-status {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 14px;
            font-weight: bold;
            color: white;
        }

        .status-new { background-color: #007bff; }
        .status-accepted { background-color: #6c757d; }
        .status-cooking { background-color: #ffc107; color: black; }
        .status-ready { background-color: #28a745; }
        .status-paid { background-color: #17a2b8; }
        .status-closed { background-color: #dc3545; }

        .status-actions {
            display: flex;
            gap: 5px;
        }

        .status-button {
            padding: 5px 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            color: white;
            transition: opacity 0.2s;
        }

        .status-button:hover {
            opacity: 0.9;
        }

        .btn-cooking { background-color: #ffc107; color: black; }
        .btn-ready { background-color: #28a745; }
        .btn-accept { background-color: #6c757d; }
        .btn-paid { background-color: #17a2b8; }
        .btn-close { background-color: #dc3545; }

        .btn-new-order {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            text-decoration: none;
            display: inline-block;
        }

        .btn-new-order:hover {
            background-color: #0056b3;
            text-decoration: none;
            color: white;
        }

        .order-items {
            font-size: 14px;
            color: #666;
            margin-top: 5px;
            white-space: pre-line;
        }

        .table-responsive {
            overflow-x: auto;
            margin-top: 20px;
        }

        table {
            min-width: 100%;
            border-collapse: collapse;
        }

        th {
            background-color: #f8f9fa;
            padding: 12px;
            text-align: left;
            font-weight: bold;
            color: #333;
        }

        td {
            padding: 12px;
            border-bottom: 1px solid #dee2e6;
            vertical-align: top;
        }

        tr:hover {
            background-color: #f8f9fa;
        }

        .empty-message {
            text-align: center;
            padding: 20px;
            color: #666;
            font-style: italic;
        }

        @media (max-width: 768px) {
            .order-filters {
                flex-direction: column;
                gap: 10px;
            }
            
            .status-actions {
                flex-wrap: wrap;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="user-info">
            <span>Пользователь: <?php echo htmlspecialchars($user['full_name']); ?></span>
            <span>Роль: <?php echo $user['type'] === 'cook' ? 'Повар' : 'Официант'; ?></span>
            <a href="logout.php" class="btn-logout">Выйти</a>
        </div>

        <h1>Управление заказами</h1>

        <div class="order-filters">
            <form method="GET" style="display: flex; gap: 10px; align-items: center;">
                <label for="shift_id">Смена:</label>
                <select name="shift_id" id="shift_id" onchange="this.form.submit()">
                    <option value="">Все смены</option>
                    <?php foreach ($shifts as $shift): ?>
                        <option value="<?php echo $shift['id']; ?>" <?php echo $selected_shift == $shift['id'] ? 'selected' : ''; ?>>
                            <?php echo date('d.m.Y', strtotime($shift['date'])); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </form>

            <?php if ($user['type'] === 'waiter'): ?>
                <a href="create_order.php" class="btn-new-order">Создать заказ</a>
            <?php endif; ?>
        </div>

        <?php if (empty($orders)): ?>
            <div class="empty-message">Заказов в выбранной смене нет</div>
        <?php else: ?>
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>№ Заказа</th>
                            <th>Дата смены</th>
                            <th>Стол</th>
                            <th>Официант</th>
                            <th>Статус</th>
                            <th>Сумма</th>
                            <th>Создан</th>
                            <th>Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orders as $order): ?>
                            <tr>
                                <td><?php echo $order['id']; ?></td>
                                <td><?php echo date('d.m.Y', strtotime($order['shift_date'])); ?></td>
                                <td><?php echo htmlspecialchars($order['table_name']); ?></td>
                                <td><?php echo htmlspecialchars($order['waiter_name']); ?></td>
                                <td>
                                    <span class="status status-<?php echo $order['status']; ?>">
                                        <?php
                                        $status_labels = [
                                            'new' => 'Новый',
                                            'accepted' => 'Принят',
                                            'not_ready' => 'Не готов',
                                            'ready' => 'Готов',
                                            'paid' => 'Оплачен',
                                            'closed' => 'Закрыт'
                                        ];
                                        echo $status_labels[$order['status']] ?? $order['status'];
                                        ?>
                                    </span>
                                </td>
                                <td class="price"><?php echo number_format($order['total_amount'], 2, '.', ' '); ?> ₽</td>
                                <td><?php echo date('d.m.Y H:i', strtotime($order['created_at'])); ?></td>
                                <td class="action-buttons">
                                    <?php if ($user['type'] === 'cook'): ?>
                                        <form method="POST" style="display: inline;">
                                            <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
                                            <?php if ($order['status'] === 'not_ready'): ?>
                                                <button type="submit" name="update_status" value="ready" class="btn-success">Готов</button>
                                            <?php elseif ($order['status'] === 'ready'): ?>
                                                <button type="submit" name="update_status" value="not_ready" class="btn-warning">Не готов</button>
                                            <?php endif; ?>
                                        </form>
                                    <?php endif; ?>
                                    
                                    <?php if ($user['type'] === 'waiter'): ?>
                                        <form method="POST" style="display: inline;">
                                            <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
                                            <?php if ($order['status'] === 'new'): ?>
                                                <button type="submit" name="update_status" value="accepted" class="btn-primary">Принять</button>
                                            <?php elseif ($order['status'] === 'ready'): ?>
                                                <button type="submit" name="update_status" value="paid" class="btn-success">Оплачен</button>
                                            <?php elseif ($order['status'] === 'paid'): ?>
                                                <button type="submit" name="update_status" value="closed" class="btn-info">Закрыть</button>
                                            <?php endif; ?>
                                        </form>
                                        <a href="view_order.php?id=<?php echo $order['id']; ?>" class="btn-view">Просмотр</a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
