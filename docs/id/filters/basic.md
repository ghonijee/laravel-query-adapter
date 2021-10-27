Package ini mampu membuat query `where` untuk suatu model berdasarkan request yang dikirm. Secara default `Laravel Query Adapter` akan membaca request data dengan kata kunci `filter`.

## Format Filter Request
Format request untuk membuat sebuah filter adalah
```json
['field_name','condition','value']
```
untuk detail kondisi apa saja yang didukung pada package ini bisa dilihat pada tabel berikut:

| Condition | Query Result |
|--|--|
| `contains` | `where('fieldName','like','%value%')` |
| `notcontains` | `where('fieldName','not like','value')` |
| `startswith` | `where('fieldName','like','value%')` |
| `endswith` | `where('fieldName','like','%value')` |
| `=` | `where('fieldName','value')` |
| `!=` | `whereNot('fieldName','value')` |
| `>=` | `where('fieldName','>=','value')` |
| `<=` | `where('fieldName','<=','value')` |

dan masih banyak lagi sesuai dengan condition yang anda butuhkan untuk mendapatkan data.

jika ingin menambahkan beberapa kondisi sekaligus pada request, maka cukup dengan menjadikannya sebagai array multidimensi.
```json
[['field_name','condition','value'],'conjungtion',['field_name','condition','value']]
```
List conjungtion untuk mutli filter
| Conjungtion | Query Result |
|--|--|
| `and` | `where('fieldName','like','%value%')` |
| `or` | `orWhere('fieldName','like','value')` |
| `!` | `where('fieldName','not like','value%')` |


## Penggunaan dasar
```php
// GET /users?filter=['name','contains','jhon']

$users = QueryAdapter::for(User::class)
    ->get();

// $users will contain all users with "john" in their name
```

## Penggunaan untuk beberapa kondisi

```php
// GET /users?filter=[['name','contains','jhon'],'and',['email','contains','gmail']]

$users = QueryAdapter::for(User::class)
    ->get();

// $users will contain all users with "john" in their name AND contain email with gmail
```