-- Добавляем тестовых сотрудников
INSERT INTO `employees` (`full_name`, `position`, `phone`, `email`, `hire_date`, `salary`, `status`) VALUES
('Петр Иванов', 'Повар', '+7(999)123-45-67', 'cook@test.com', '2024-01-15', 45000.00, 'active'),
('Мария Сидорова', 'Официант', '+7(999)765-43-21', 'waiter@test.com', '2024-01-20', 35000.00, 'active');

-- Добавляем пользователей с ролями повара и официанта
INSERT INTO `users` (`name`, `surname`, `login`, `password`, `type`, `bloked`, `token`, `blocked`, `amountAttempt`) VALUES
('Петр', 'Иванов', 'cook@test.com', '123456', 'cook', '0', NULL, 0, 0),
('Мария', 'Сидорова', 'waiter@test.com', '123456', 'waiter', '0', NULL, 0, 0);

-- Добавляем тестовую смену
INSERT INTO `shifts` (`shift_date`, `start_time`, `end_time`, `status`) VALUES
(CURRENT_DATE, '09:00:00', '22:00:00', 'in_progress');

-- Привязываем сотрудников к смене
INSERT INTO `shift_assignments` (`shift_id`, `employee_id`, `position`)
SELECT 
    (SELECT id FROM shifts WHERE status = 'in_progress' LIMIT 1),
    id,
    position
FROM employees; 