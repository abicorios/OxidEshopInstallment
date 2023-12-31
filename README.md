# Oxid Eshop Installment
This repository contains the solution for the test task found here: [Test Task](https://drive.google.com/drive/folders/1drDJmsZ9IEB7ZD4oNTHzS34uO5L-5eCt).

## Development Environment

Edit the `/etc/hosts` file and add the line: `127.0.0.1 localhost.local`

To set up the development environment, follow these steps:
```bash
mkdir oxideshop
cd oxideshop
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

## Migrations
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

## Deployment

Follow these steps to create a Digital Ocean Droplet with Docker Compose using this guide: https://github.com/abicorios/digital.ocean.docker.compose.doc

1. Log in as a user via SSH.

2. Install the OXID eShop, following the same steps as in the development environment:

   ```bash
   mkdir oxideshop
   cd oxideshop
   git clone git@github.com:OXID-eSales/docker-eshop-sdk.git .
   git clone git@github.com:OXID-eSales/docker-eshop-sdk-recipes.git recipes/oxid-esales
   cd recipes/oxid-esales
   git checkout b-6.4.x
   cd ../..
   ./recipes/oxid-esales/shop/b-6.4.x-ce-dev/run.sh
   ```

3. Edit `docker-compose.yml` and remove the following services: `mailhog`, `adminer`, `selenium`, `seleniumfirefox`. Then execute `make down` and `make up` to apply the changes. Log in to https://your.domain.com/admin and update the admin password. To access the MySQL database, use the following command: `docker compose exec mysql mysql -u root -proot -D example`.

4. Replace `localhost.local` with your domain name in these files: `docker-compose.yml`, `services/php.yml`, `source/source/config.inc.php`, and `containers/httpd/project.conf`. Additionally, add your domain to the `.env` file after `APP_DOMAIN=` and add your email after `MY_EMAIL=`.

5. Add the certbot service to the `docker-compose.yml` file:

   ```yaml
   certbot:
     image: certbot/certbot
     container_name: certbot
     volumes:
       - certbot-etc:/etc/letsencrypt
       - certbot-var:/var/lib/letsencrypt
       - ./source/source:/var/www
       - ./source/source/.well-known:/var/www/.well-known
       - ./source/source/.well-known/acme-challenge:/var/www/.well-known/acme-challenge
     depends_on:
       php:
         condition: service_started
     command: certonly --webroot --webroot-path=/var/www --email ${MY_EMAIL} --agree-tos --no-eff-email --force-renewal -d ${APP_DOMAIN}
   ```

   Apply the changes by running `make down` and `make up`.

6. Check the result of the certbot process with `docker logs certbot`. You should see a success message.

7. Copy the generated certificates to the project:

   ```bash
   cp /var/lib/docker/volumes/oxideshop_certbot-etc/_data/live/your.domain.com/cert.pem ~/oxideshop/containers/httpd/certs/server.crt
   cp /var/lib/docker/volumes/oxideshop_certbot-etc/_data/live/your.domain.com/privkey.pem ~/oxideshop/containers/httpd/certs/server.key
   ```

   Apply the changes with `make down` and `make up`.

8. Add a redirect from HTTP to HTTPS in the `~/oxideshop/source/source/.htaccess` file within the `<IfModule mod_rewrite.c>` section:

   ```apacheconf
   RewriteCond %{HTTPS} !=on
   RewriteRule ^ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
   ```

9. Your website should now be accessible using HTTPS on your domain.

10. Download the module:

```bash
cd ~/oxideshop/source/source/modules
mkdir abicorios
cd abicorios
git clone git@github.com:abicorios/OxidEshopInstallment.git
```

11. Add the module to the `source/composer.json` file:

```json
"repositories": {
    "abicorios/installment": {
        "type": "path",
        "url": "./source/modules/abicorios/OxidEshopInstallment/"
    }
}
```

12. Install the module:

```bash
cd ~/oxideshop
make php
composer require abicorios/installment -n
php bin/oe-console oe:module:install-configuration source/modules/abicorios/OxidEshopInstallment
rm -rf source/tmp/*
php vendor/bin/oe-eshop-db_migrate migrate abicorios_installment
```

13. To enable the module, log in to the OXID eShop admin panel, navigate to `Service -> Tools`, and click on `Update DB Views now`. Then, proceed to `Extensions -> Modules` and activate the module.
