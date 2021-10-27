Package ini juga mampu membuat query berdasarkan API Request filter yang mengandung `relation` data. 

## Relation Filter
```php
// GET /users?filter=['post.title','contains','Laravel']

$users = QueryAdapter::for(User::class)
    ->get();

// and build query some to
$users = User::whereHas('post', function($q){
    $q->where('title','like','%laravel%');
})->get();
```

Pada suatu kondisi, kita juga membutuhkan untuk membuat group query berdasarkan field tertentu.
## Group Query
```php
// GET /users?filter=[['name','contains','Laravel'],'and',[['age','>=',10],'and',['age','<>=',20]]

$users = QueryAdapter::for(User::class)
    ->get();

// and build query some to
$users = User::where('name','like','%laravel%')->where(function($q){
    $q->where('age','>=',10);
     $q->where('age','<=',20);
})->get();
```