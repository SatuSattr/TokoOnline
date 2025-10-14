Okay ini adalah perubahan besar pada codebase ini
Saat ini website ini hanya memiliki 2 role account
yaitu user dan admin. user hanya bisa melakukan belanja, checkout dan order, dan admin bisa memanage product dan melakukan crud.
saat ini setiap product ditambahkan oleh admin lewat fitur admin dashboard. yang ingin aku tambahkan adalah role ketiga yaitu "Seller"
dimana role ini memiliki fitur seperti user namun dia dapat menambahkan product atas nama dia. dia dapat memanage product tapi hanya untuk product yang memiliki id dari id dia atau product dia. update ini cukup besar karena kamu harus menambahkan kolom user_id pada product yang menandakan product ini ditambahakan oleh siapa.
kamu juga harus menambahkan role seller di controller user.

Fitur-Fitur tiap role:
User => menambahkan product ke cart, Melakukan checkout & order
Seller => Semua fitur user, memanage product milik dia, memanage orderan dari user terhadap product milik dia
Admin => Semua fitur Seller kecuali memanage orderan, dapat melakukan managing dan crud terhadap semua element kecuali cart.

aku ingin saat user malakukan checkout, data tersebut akan masuk ke table orders, dimana misal user melakukan banyak checkout sekaligus pada banyak item
maka data order akan dibuat untuk setiap item yang dicheckout
misal user melakukan checkout pada 3 item sekaligus, ketiga item ini memiliki seller yang berbeda, nah saat sudah mengisi form checkout dan menekan tombol checkout
data order tiap product nya akan masuk satu persatu ke tabel orders dengan product_id yang sesuai dengan tiap product dan user_id yang berisikan id dari user yang melakukan order

dengan begitu tiap product memilki penjualnya, dan aku ingin kamu menampilkan nama toko dari si penjual pada tiap card products.
