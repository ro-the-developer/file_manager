### Тестовое задание по реализации файлового менеджера
ТЗ:
- в удобном для вас месте создать каталог или дерево каталогов с пользовательским названием/ми.
- возможность редактирования/удаления названия каталогов с историей, доступной не только локально.
- возможность загрузки файлов созданные каталоги, с удалением флага исполнения.
  Вести журнал загруженных файлов.
  
### Реализация

Поскольку в разместившей вакансию компании используется фреймворк Yii2, было принято решение выполнять тестовое задание
на его основе.
Что, с одной стороны, затруднило выполнение задания, но с другой дало возможность ознакомиться с этим фреймворком.

В итоге был реализован файловый менеджер с возможностью создавать, удалять и переименовывать
каталоги, а также загружать в них файлы.
При этом удалить или переименовать можно любой каталог, кроме корневого. 

Для простоты и мобильности была выбрана БД sqlite.

Код реализации можно посмотреть по ссылке [сравнения первого и последнего коммитов](https://github.com/ro-the-developer/file_manager/compare/b0cd92f6f1fe025b37cce1c9176971391c42eaa6...44a6bf98c4136baba686417a21f9c9af9f5d63ae).

### Установка

- Скачать проект 
- перейти в папку с проектом
- скачать зависимости (при необходимости установив composer)
- перейти в папку www
- запустить встроенный веб-сервер PHP
  (при необходимости - установить или раскомментировать модуль РНР `php-sqlite3`/`pdo_sqlite`)

Например:
```bash
git clone https://github.com/ro-the-developer/file_manager.git
cd file_manager
composer install
cd web
php -S localhost:8883
```
### Использование

- открыть в браузере адрес http://localhost:8883/
- авторизоваться, используя пары `demo`/`demo` или `admin`/`admin`
- перейти по ссылке из меню в раздел [File Manager](http://localhost:8883/files)
- выполнять действия в колонке **Manage**:
  - создание каталога
  - загрузка файла в текущий каталог
  - переименование текущего каталога
  - удаление текущего каталога 
    (если не отмечен чекбокс "со всем содержимым", то при наличии содержимого каталог не удалится)
- перемещаться между каталогами, используя список в колонке **Folders** или "Хлебные крошки" над ней
- перейти по ссылке из меню в раздел [View logs](http://localhost:8883/logs) (доступно только пользователю `admin`).
  При этом должны отобразиться логи всех выполненных ранее действий
