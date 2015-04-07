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

### Configure TouchYourPass
There is few fields to configure in `inc/conf.php`.

## Contribute

### Dependency tools

* `composer` fo PHP dependencies
* `bower` for JS dependencies

### First: On your side

1. Create an account on [https://git.framasoft.org](https://git.framasoft.org)
1. Create a fork : [Create the fork](https://git.framasoft.org/olivierperez/TouchYourPass/fork/new)
1. Create a branch `feature/[Description]` from the `develop` branch
    * Where `[Description]` is a short description of what you will do
1. Make changes and commit on your branch
1. Push the branch on your own fork
1. Ask for a merge request to `develop`

### Next: On our side

1. Someone will read your work
    * Try to organize your commits in order to simplify the reading
1. If the reader need to ask you questions or to comment your work, he will do it on the merge request
1. If the merge request seams to be good, he could merge your branch to `develop` branch

### Fix after reading

The reading of the merge requests can lead to some fixes.
You can make those fixes on your branch, it will update the merge request too.

### Colors
[Color palette - http://paletton.com/#uid=20B0r0khCij9Qooeblwn8gsuBc5](http://paletton.com/#uid=20B0r0khCij9Qooeblwn8gsuBc5)
