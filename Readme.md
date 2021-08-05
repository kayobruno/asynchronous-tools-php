# Asynchronous Tools PHP

## React PHP

### Install composer
`composer install`

### Run php socket file
`php src/react-php/socket.php`

### Open new command line and run
`telnet 127.0.0.1 7181` 

### Command to exit from chat
`quit` or kill (`crtl + c`) server to stop all chats

### Executing read file example with greater then 10 milion lines

Executing asyncronously:

```php src/react-php/read-file-async.php```

Executing syncronously:

use `--memory-limit` argument to limit memory on 12M

```php src/react-php/read-file-sync.php```
