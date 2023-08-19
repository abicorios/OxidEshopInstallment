# Oxid Eshop Installment
This repository contains the solution for the test task found here: [Test Task](https://drive.google.com/drive/folders/1drDJmsZ9IEB7ZD4oNTHzS34uO5L-5eCt).

## Development Environment

Edit the `/etc/hosts` file and add the line: `127.0.0.1 localhost.local`

To set up the development environment, follow these steps:
```bash
git clone git@github.com:OXID-eSales/docker-eshop-sdk.git .
git clone git@github.com:OXID-eSales/docker-eshop-sdk-recipes.git recipes/oxid-esales
cd recipes/oxid-esales
git checkout b-6.4.x
cd ../..
./recipes/oxid-esales/shop/b-6.4.x-ce-dev/run.sh
```
Access the website at: [http://localhost.local/](http://localhost.local/)

Access MySQL at: [http://localhost.local:8080/](http://localhost.local:8080/) (login: root, pass: root)

Access the admin panel at: [http://localhost.local/admin](http://localhost.local/admin) (login: admin, pass: admin)

Access Mailhog at: [http://localhost.local:8025/](http://localhost.local:8025/)

The main directory contains files and subdirectories with container settings. For more information about container-related commands, run `make help`. The `source` subdirectory includes the `composer.json` file and a `vendor` subdirectory. The `source/source` subdirectory contains the Oxid eShop source code.

You can open the `source` subdirectory (which contains the `composer.json` file) in your IDE to use information about PHP libraries.

For optimizing the container setup, you can remove `selenium`, `seleniumfirefox`, and `mailhog` from the `docker-compose.yml` file. Afterward, execute `make down` and `make up` to apply the changes.

In VS Code, you can add the subdirectory of the developing module to the workspace for managing the module's repository. Go to `File -> Add Folder to Workspace...`. To avoid confusion, you can rename the repository of the `source` subdirectory, for example, to `source/.git.b`, or use `Close Repository` from the context menu.

## Debugging

In `containers/php/xdebug.ini`, set `xdebug.start_with_request=yes`. Then run `make down` and `make up` to apply the changes. In `source/.vscode/launch.json`, configure as follows:
```json
{
    "version": "0.2.0",
    "configurations": [
        {
            "name": "Listen for XDebug",
            "type": "php",
            "request": "launch",
            "port": 9003,
            "pathMappings": {
                "/var/www/html/source": "${workspaceFolder}/source"
            }
        }
    ]
}
```

## Learning Module Creation

For learning about module creation, you can refer to the following resources:
- [Udemy Course: Academy OXID eShop Developer Training Basic](https://www.udemy.com/course/academy-oxid-eshop-developer-training-basic/learn/lecture/17262346)
- [OXID eShop modules Developer Documentation](https://docs.oxid-esales.com/developer/en/6.4/development/modules_components_themes/module/index.html)

## Installing and Updating Modules during Development

To initiate module development, create the directory `source/modules/abicorios/OxidEshopInstallment` and add the files `metadata.php`, `composer.json`, and `views/admin/blocks/article_main__admin_article_main_extended.tpl` (first few commits of this repository). In the main `source/composer.json` file, include:
```json
"repositories": {
    "abicorios/installment": {
        "type": "path",
        "url": "./source/modules/abicorios/OxidEshopInstallment/"
    }
}
```

To install the module, follow these steps:
```bash
make up
make php
composer require abicorios/installment -n
php bin/oe-console oe:module:install-configuration source/modules/abicorios/OxidEshopInstallment # apply metadata changes
rm -rf source/tmp/* # clear templates cache to apply template changes
```

Frequently used admin pages: `Extensions -> Modules` (list of modules), `Service -> Tools -> Update DB Views now` (to apply changes in the database).

Also, to update admin pages, it can be useful to use the `Reload frame` option from the browser context menu.

# Migrations
Documentation: https://docs.oxid-esales.com/developer/en/6.4/development/tell_me_about/migrations.html, https://www.doctrine-project.org/projects/doctrine-migrations/en/2.2/reference/migration-classes.html#migration-classes, see also `source/migration/data`

Generate migration files:
```bash
make php
php vendor/bin/oe-eshop-db_migrate generate abicorios_installment
```

Run migrations:
```bash
php vendor/bin/oe-eshop-db_migrate migrate abicorios_installment
```
