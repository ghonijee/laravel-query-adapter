---
title: Pengenalan
weight: 1
---


Package ini dibuat untuk memudahkan proses mendapatkan data dengan menggunakan filter, sort, atau select berdasarkan request data yang dikirimkan. Package ini secara khusus diciptakan untuk memenuhi kebutuhan integrasi antara Framework [Laravel](https://laravel.com) dengan [Data Grid by DevExpress](https://js.devexpress.com/Overview/DataGrid/). Namun secara umum package ini dapat digunakan meskipun tanpa menggunakan [Data Grid by DevExpress](https://js.devexpress.com/Overview/DataGrid/). 

Package `QueryAdapter` ini juga mengimplementasikan Laravel default Eloquent builder. Ini membuat anda dapat menggunakan fungsi-fungsi yang ada di Eloquent dapat anda gunakan juga menggunakan package ini.
  

## Penggunaan Dasar

### Membuat query untuk filter data berdasarkan request: `/users?filter=["name","contains","jhon"]`:

  

```php

use GhoniJee\DxAdapter\QueryAdapter;

  
$users  =  QueryAdapter::for(User::class)->get();

// semua `User` yang memiliki nama berisi jhon akan didapatkan datanya.

```

[Baca selengkapnya untuk fitur filter]()
  

### Membuat query untuk sortBy berdasarkan request:: `/users?sort=["desc"=>false, "selector"=>"name"]`:

```php

use GhoniJee\DxAdapter\QueryAdapter;

  
$users  =  QueryAdapter::for(User::class)->get();

// mendapatkan data semua user sorted by ascending name

```

  

[Baca selengkapnya terkait fitur sorting](https://docs.spatie.be/laravel-query-builder/v2/features/sorting/)
 

### Membuat query untuk mendapatkan data field tertentu `/users?select=["id","email"]`

  

```php

use GhoniJee\DxAdapter\QueryAdapter;
  
$users  =  QueryAdapter::for(User::class)->get();

// mendapatkan data user hanya untuk field id & email

```

  

[Baca selengkapnya untuk selected data]()

  

## Terimakasih
 - [Team Spatie](https://spatie.be/), karena package ini dibuat berdasarkan refrensi package [Laravel Query Builder](https://spatie.be/docs/laravel-query-builder/v3/introduction). 
 - [Alfredo Eka WIbowo](https://github.com/edo-floo) yang sudah membuat base DxAdapter.