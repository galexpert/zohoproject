<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

скачиваем проект с ветки master

$ git clone https://github.com/galexpert/test-service-np.git <имя_папки>

создаем и подключаем БД на лкальном сервере

в файле локальном .env необходимо установить настройки

APP_KEY=<сгенерировать свой ключ приложения>

APP_URL=<локальный адрес>

QUEUE_CONNECTION=database

DB_DATABASE=<локальная база данных>

стартуем работу локального сервера...

далее в консоли выполняем такие действия

устанавливаем все зависимости

npm install

composer install

необходимо выполнить команды:

php artisan key:generate

php artisan storage:link

php artisan migrate 

npm run build или vite build

чтобы сайт корректно отображался, возможно придется настроить редирект с основного локального домена на папку /public local-domain --> /local-domain/public Это возможно сделать в настройках вашего сервера или в файле .htacces

рабочая тестовая страница должна открываться локальному домену вашего проекта (.env APP_URL=) напр http://localhost

Если все правильно выполненно, там будет форма для создания аккаунта и сделки на zoho CRM

по непонятным причинам (исключительно) при создании аккаунта  с zoho crm приходит ответ 202 (взято в работу). Иногда создается корректно. Возможно в причине работа сервера или ограничение колличества попыток. При создании зделки всегда проблем ни разу не было. 


Стек реализации: PHP 8+, MySql 5.7, Laravel 10, Vue 3 , Bootstrap 5. Доп библиотеки (vue-toastification красивые сообщения, @vuelidate - валидация формы на клиенте.

Реализация:
Из формы компонента Vue zohoForm.vue попадают в контроллер ZohoController.php  проходят валидацию в ZohoRequest. Следующим этапом request передается в ZohoService.php . Там данные передаются с ключами доступа на https://www.zohoapis.eu , после чего создается аккаунт и зделка. ответ возвращается в контроллер ZohoController.php  который передает их обрадно в компонент Vue zohoForm.vue. Результат должен отобразится под формой и во всплывающем сообщении.

