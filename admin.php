<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Окно админа</title>
    <link rel="stylesheet" href="стили/style2.css">
</head>
<body>
    <div class="admin-panel">
        <h2>Панель администратора</h2>
        <div id="blockedNotification" style="display: none; color: red;">Вы заблокированы</div>
        <button id="showUsersBtn">Показать пользователей</button>
        <button id="addUserBtn">Добавить пользователя</button>

        <!-- Список пользователей -->
        <div id="usersList" style="display: none;">
            <h3>Список пользователей:</h3>
            <ul id="usersUL"></ul>
        </div>

        <!-- Форма редактирования пользователя -->
        <div id="editUserForm" style="display: none;">
            <h3>Редактировать пользователя:</h3>
            <form>
                <div class="form-group">
                    <label for="editUsername">Имя пользователя:</label>
                    <input type="text" id="editUsername" name="username">
                </div>
                <div class="form-group">
                    <label for="editEmail">Email:</label>
                    <input type="email" id="editEmail" name="email">
                </div>
                <button type="submit">Сохранить изменения</button>
            </form>
        </div>

        <!-- Форма добавления пользователя -->
        <div id="addUserForm" style="display: none;">
            <h3>Добавить пользователя:</h3>
            <form>
                <div class="form-group">
                    <label for="newUsername">Имя пользователя:</label>
                    <input type="text" id="newUsername" name="username">
                </div>
                <div class="form-group">
                    <label for="newEmail">Email:</label>
                    <input type="email" id="newEmail" name="email">
                </div>
                <button type="submit">Добавить пользователя</button>
            </form>
        </div>
    </div>

    <script src="script.js"></script>
</body>
</html>
