
## About Booklib

Booklib is HTTP REST api service for handling books

## Deployment

- Create empty database file in location **<project_dir>/database/database.sqlite**
- For create database structure: **php artisan migrate**
- For filling database with test records: **php artisan db:seed --class=TestDataSeeder**
- For clear database: **php artisan migrate:reset** (then create database structure: **php artisan migrate**)

##TODO for Dev
- Количество книг у автора вычисляется на лету. 
  Лучше хранить в базе. 
  Менять количество при добалении/удалении автора книги и при удалении книги.
- Убрать pivot объект из relation выборок (аторы к книгам и книги к авторам)

## Available methods for Books 
- (POST) api/v1/book                             | create_book
- (GET) api/v1/book                              | get_all_books_paginate  
- (GET) api/v1/book/by_author/{author_id}        | find_books_by_author    
- (GET) api/v1/book/raw                          | get_all_books           
- (GET) api/v1/book/{book_id}                    | get_one_book
- (POST) api/v1/book/{book_id}                   | update_book
- (DELETE) api/v1/book/{book_id}                 | delete_one_book         
- (POST) api/v1/book/{book_id}/author            | add_author
- (DELETE) api/v1/book/{book_id}/author/{author_id} | delete_author_from_book        
- (GET) api/v1/book/{book_id}/authors            | get_book_authors

## Available methods for Authors
- (GET) api/v1/author                            | get_all_authors_paginate
- (POST) api/v1/author                           | create_author
- (GET) api/v1/author/raw                        | get_all_authors
- (GET) api/v1/author/{author_id}                | get_one_author
- (POST) api/v1/author/{author_id}               | update_author
- (DELETE) api/v1/author/{author_id}             | delete_one_author
- (GET) api/v1/author/{author_id}/books          | authors_books

## get_all_books_paginate params
GET params:
- page (NOT REQUIRED) (INT)
- name (STRING)

## get_all_authors_paginate params
GET params:
- page (NOT REQUIRED) (INT)
- fio (NOT REQUIRED) (STRING)

## get_all_books params
GET params:
- name (NOT REQUIRED) (STRING)

## get_all_authors params
GET params:
- fio (NOT REQUIRED) (STRING)

## create_book params
POST params (form-data):
- name (STRING)
- annotation (STRING)
- publish_date (DATE in format YYYY-MM-DD)

## create_author params
POST params (form-data):
- fio (STRING)
- birth_date (DATE in format YYYY-MM-DD)
- death_date (NOT REQUIRED) (DATE in format YYYY-MM-DD)

## add_author
POST params (form-data):
- author_id (INT)

## update_book
See: create_book params

## update_author
See: create_author params
