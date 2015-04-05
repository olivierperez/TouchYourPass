# Touch Your Pass

## What is that?
**Touch Your Pass** is a PHP passwords manager in which the adminisatrator/host can't see your passwords.

1. **Security level 1**: The connection password of the users are slat and hashed before storing them.
2. **Security level 2**: The `safe passwords` of the users are encrypted on the client side by a `main password`.
3. **Security level 3**: The `main password`, used to decrypted `safe passwords`, doesn't go on network (either in clear or encrypted).
4. **Security level 4**: The **code source is open**, if someone find a vulnerability he can fix it and propose the fix.

## How to use it
* Create a database schema
* Execute SQL script
* Copy/paste the files
* Copy `inc/conf.template.php` to `inc/conf.php`
* Configure your app in `inc/conf.php`
* Go to the tool: http://yourhost/

### How to create the database
Execute the sql script `install/install.sql` in your database schema.

### Configure the tool
There is few fields to configure in `inc/conf.php`.

## Contributors
[Color palette - http://paletton.com/#uid=20B0r0khCij9Qooeblwn8gsuBc5](http://paletton.com/#uid=20B0r0khCij9Qooeblwn8gsuBc5)
