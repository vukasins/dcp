#Scaffolding wiki

##Kreiranje entiteta

```
php index.php create:entity --table "users_table" --path "src/Entity/UserEntity.php" --namespace "Account\Entity"
```

##Kreiranje mappera

```
php index.php create:mapper --table "users_table" --path "src/Mapper/UserMapper.php" --namespace "Account\Mapper" --parent "AbstractMapper" --mapper "UserMapper"
```

##Kreiranje modula

```
php index.php create:module --module "HelloModule" --mvc 1
```