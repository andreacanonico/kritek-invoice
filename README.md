Hello! My name is Andrea Canonico. I've sended my CV by your form you sent me by email. This is my first project with Symfony, Twig and Doctrine. In realty I've always worked with Laravel, CodeIgniter, jQuery etc and recently with Vue.js

Thanks for the opportunity

<h1>Symfony project specifications</h1>

    using php 8.x
    using symfony 5.4.x

Create a simple form for creating an invoice and with the equivalent invoice lines.

The graphics are not important I'm interested in seeing how it fares with symfony programming and styling.

Use doctrine.


The fields for the invoice entity are:

    Id (auto increment)
    Invoice date (type date)
    Invoice number (type int)
    Customer Id (type int)

The fields for the entity invoice lines are:

    Id (auto increment)
    Invoice Id (to be linked through foreign key to the invoice entity)
    Description (type text, see how it is called exactly)
    Quantity (type int)
    Amount (type decimal 12.2)
    VAT amount (type decimal 12.2)
    Total with VAT (type decimal 12.2)

You will have to create the sql folder where you will put the dump of your db.


Exclude some folders especially the vendor folder, use the file .gitignore with the following lines:

    /web/bundles/
    /app/bootstrap.php.cache
    /app/cache/*
    /app/config/parameters.yml
    /app/logs/*
    !.app/cache/.gitkeep
    !.app/logs/.gitkeep
    /app/phpunit.xml
    /build/
    /vendor/
    /bin/
    /composer.phar

The tables must be translated into English  as well as fields and entities.