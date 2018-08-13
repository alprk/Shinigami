# Shinigami

##Setup of the project
```
git clone https://github.com/alprk/Shinigami.git
```

```
cd shinigami
```

```
php bin/console doctrine:database:create
```

```
php bin/console make:migration
```

```
php bin/console doctrine:migrations:migrate
```

```
php bin/console doctrine:fixtures:load
```

###Admin : admin/admin
###Employee: employee/employee
###Player : player/player