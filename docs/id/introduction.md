Package ini dibuat untuk memudahkan proses mendapatkan data dengan menggunakan filter, sort, atau select berdasarkan request data yang dikirimkan. Package ini secara khusus diciptakan untuk memenuhi kebutuhan integrasi antara Framework [Laravel](https://laravel.com) dengan [Data Grid by DevExpress](https://js.devexpress.com/Overview/DataGrid/). Namun secara umum package ini dapat digunakan meskipun tanpa menggunakan [Data Grid by DevExpress](https://js.devexpress.com/Overview/DataGrid/). 

Package `QueryAdapter` ini juga mengimplementasikan Laravel default Eloquent builder. Ini membuat anda dapat menggunakan fungsi-fungsi yang ada di Eloquent dapat anda gunakan juga menggunakan package ini.
  
## Instalasi

Package laravel-query-adapter ini dapat di install melalui composer dengan command
```bash
composer require ghonijee/laravel-query-adapter
```


## Penggunaan Dasar

Package ini dapat digunakan dengan beberapa opsi, bisa menggunakan Facade `QueryBuilder` atau langsung menggunakan Class `DxAdapter`. 

### Jika menggunakan model langsung

```php
use GhoniJee\DxAdapter\QueryAdapter;

$data = QueryAdapter::for(User::class)->get();
```
bisa juga dengan memanggil class `DxAdapter`.
```php
use GhoniJee\DxAdapter\DxAdapter;

$data = DxAdapter::for(User::class)->get();
```

### Jika menggunakan query atau instance model yang sudah dibuat sebelumnya
```php
use GhoniJee\DxAdapter\QueryAdapter;

$qeury = User::query();
$data = QueryAdapter::load($query)->get();
```
bisa juga dengan memanggil class `DxAdapter`.
```php
use GhoniJee\DxAdapter\DxAdapter;

$qeury = User::query();
$data = DxAdapter::load($query)->get();
```

### Menambahkan custom filter diluar API Request yang dikirim
Karena class yang ada merupakan instance dari Eloqeunt laravel, jadi semua method yang ada pada eloquent bisa juga dipanggil dengan chaining method.

```php
use GhoniJee\DxAdapter\QueryAdapter;

$qeury = User::query();
$data = QueryAdapter::load($query)->where('active', true)->get();
```



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