# Slinky

Open URL shortener service.

## Установка

1. Клонировать репозиторий:

```bash
git clone https://github.com/vommuan/slinky.git slinky
```

2. Создать пустую базу данных.
3. Переименовать файл config/db_sample.php в config/db.php
4. Открыть файл config/db.php и ввести параметры подключения к базе данных.
5. Выполнить миграции.

```bash
yii migrate
```

6. Настроить веб-сервер (Apache или Nginx). Корень сайта приходится на папку: web/
