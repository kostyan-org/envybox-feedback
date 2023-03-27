## Задание
> Сделать форму обратной связи.
> При сохранении заявки использовать паттерн фабрика.
> Реализовать структуру, чтобы можно было добавлять новые места для хранения заявок, например другая база данных или email.
> Изначально реализовать сохранение в базу и в файл. Саму структуру базы можно не делать.

> Поля: имя, телефон, само обращение. Валидация данных на бекенде.

> Что необходимо использовать:
> - PHP 7
> - ООП (для создания заявки и места для хранения заявки)
> - Фреймворк Laravel или mvc фреймворк
> - DDD для организации приложения (не обязательно)
> - Обязательно Vuejs

## Реализация

Клонируем
```sh
git clone https://github.com/kostyan-org/envybox-feedback.git
```


Переходим
```sh
cd envybox-feedback
```


Билдим и запускаем контейнеры
```sh
docker-compose up -d --build
```

Переходим
```sh
cd app
```


Проваливаемся в контейнер
```sh
docker exec -ti envybox-feedback-www-1 bash
```


Обновляем
```sh
composer update
```


Создаем БД
```sh
php bin/console doctrine:database:create
```


Накатываем миграции
```sh
php bin/console doctrine:migrations:migrate
```


Меняем владельца для корректной работы (точка нужна =))
```sh
chown -R www-data:www-data .
```


Открываем в браузере
http://localhost/index.html
