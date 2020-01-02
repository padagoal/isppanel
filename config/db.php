<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'pgsql:host=localhost;dbname=crmdb',
    'username' => 'crmuser',
    'password' => 'crmpassword',
    'charset' => 'utf8',
];

// Schema cache options (for production environment)
//'enableSchemaCache' => true,
//'schemaCacheDuration' => 60,
//'schemaCache' => 'cache',

/*
 *     drop database crmdb;
create user crmuser with password 'crmpassword';
 create database crmdb;
 alter database crmdb owner to crmuser;

    drop database ispdb;
create user ispuser with password 'isppassword';
 create database ispdb;
 alter database ispdb owner to ispuser;


 */
