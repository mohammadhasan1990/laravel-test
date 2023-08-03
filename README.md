# Laravel Subscription Project

### First register user to access routes

``
/api/register
``

### Login user

``
/api/login
``

### Site Crud 

``
/api/sites
``

### Admin Post Crud

``
/api/publish-posts
``

Available filters:

````
title
orderBy -> field name
direction -> order direction asc/desc
is_published -> 0 or 1
site_id -> can get from list of sites
````

### Send posts to user has not been sent yet. run in queue

``
/api/publish-posts/check
``

### Subscriber Post Lists

``
/api/subscriber-posts
``

### Subscribe user to specify site

``
/api/subscribe
``

### List of Subscribe sites

``
/api/subscribe/list
``

### Command to send published post to user has not been sent run in queue

``
php artisan sent:published-posts
``

Copyright Hasan
