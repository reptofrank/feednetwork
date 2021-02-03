# Feed Polling App

The following steps should be taken after setting up MySQL database

## Run Migrations

```bash
php bin/console docrine:migrations:migrate
```

## Load Fixtures

```bash
php bin/console doctrine:fixtures:load
```

Demo user email: user@axelerant.com
Demo admin email: user@axelerant.com

Password: password

Users can also be added at /register



## TODO

 - More tests
 - Use Symfony Form to build and validate form inputs