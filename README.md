# ResourceHub
Resources for General Use

### PHP Version Class

Version class is used when we need the browser to refresh the cached JS files when they are modified.
This classes appends a time parameter to the path passed based on modified time so that the browser refreshes the JS File.

There are two functions available:
1. relative_version (For relative paths)
2. absolute_version (For absolute paths)

Can be used as ,
```php
$version = new Version;
$version->relative_path($path);
$version->absolute_path($path);
```

### PHP Socket Class

Socket class is used when we need to call a page or script via sockets.
There are two functions available,
1. do_in_background (Opens a conection to the URL but does not read from it)
2. do_in_foreground (Opens a conection to the URL but reads from it)

Can be used as ,
```php
$socket = new Socket;
$socket->do_in_background($link,$post_data,$ssl);
$socket->do_in_foreground($link,$post_data,$ssl,$length);
```
```
$link : URL of the File
$post_data : Array containing the POST parameters.
$ssl : true if the page called is on Secure server else false on Unsecure/Local server
$length : Specifies the length of string to read. Default is 128
```
