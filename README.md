# Slinky

Open URL shortener service.

## Установка

1. Клонировать репозиторий:

```bash
git clone https://github.com/vommuan/slinky.git slinky
```

2. Выполнить установку зависимых пакетов:

```bash
composer install
```

3. Создать пустую базу данных.
4. Переименовать файл config/db_sample.php в config/db.php
5. Открыть файл config/db.php и ввести параметры подключения к базе данных.
6. Выполнить миграции.

```bash
yii migrate
```

7. Настроить веб-сервер (Apache или Nginx). Корень сайта приходится на папку: web/
