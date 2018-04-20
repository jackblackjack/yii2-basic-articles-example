<p align="center">
    <h1 align="center">Простейший новостной сайт с авторизацией и оповещением пользователей о событиях (Yii 2 Basic Project Template)</h1>
    <br>
</p>

## Создание базового образа
----------------------------------
> **Внимание:** Описание дано без учета случаев возникновения ошибок. В случае возникновения ошибок Вы должны справиться с ними сами. 

**1.** Разверните окружение для разработки.
Установите [VirtualBox](https://www.virtualbox.org/) и [Vagrant](https://www.vagrantup.com/).

**2.** Создайте типовое базовое приложение yii2
```
composer create-project --prefer-dist yiisoft/yii2-app-basic basic
```

**3.** Создайте собственный репозиторий на github.com
```
git init
git add .
git commin -m "First commit"
git remote add origin remote github/repo/url
git push origin master
```
**4.** Запустите виртуальную машину
- Укажите github токен в файле vagrant/config/vagrant-local.yml
```
cd basic
vagrant up
vagrant ssh
```

**5.** Внесите изменения в конфигурацию сервера

- Изменения в php.ini
> **Найти наименование сервиса php7 можно выполнив комнаду:** sudo service --status-all | grep php 

```
sudo sed -i 's/\(;\)\(cgi.fix_pathinfo=\)\([0-9]\+\)/\21/' /etc/php/7.0/fpm/php.ini && sudo service php7.0-fpm restart
```

- Изменения в конфигурации nginx
```
sudo rm -f /etc/nginx/sites-enabled/default && sudo service nginx restart
```

- Внесите изменения в файл config/test_db.php
```
cd /app && sudo sed -i 's/dbname=yii2_basic_tests/\dbname=yii2basic_test/' config/test_db.php
```

- Внесите изменения в composer.json
- В секцию "require":
````
"require": {
    "yii2mod/yii2-rbac": "*"
}
````

- В секцию "require-dev":
````
"require-dev": {
    ...
    "codeception/codeception": "^2.4",
    "codeception/verify": "^1.0",
    "codeception/specify": "^1.0"
}
````
- В секцию "extra":
````
"extra": {
    "yii\\composer\\Installer::postCreateProject": {
        "setPermission": [
            {
                ...
                "migrations": "0755"
            }
        ]
    }
}
````

- **6.** Обновите проект
```
cd /app && composer update
```
