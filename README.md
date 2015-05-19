# Touch Your Pass

## What is that?
**Touch Your Pass** is a PHP passwords manager in which the adminisatrator/host can't see the user's passwords.

### Is it safe?
1. The authentication passwords are salted and hashed before storing them.
2. The `safe passwords` of the users are encrypted on the client side by a `main password`.
3. The `main password`, used to decrypted `safe passwords`, doesn't go on network (either in clear or encrypted).
4. The **source code is open**, if someone find a vulnerability he can fix it and propose the fix.

## How to install
* Copy/paste the files
* Create a database schema
* Go to: http://yourhost/install.php
    * Fill the form and submit it
* Protect acces to admin.php
    * Rename `example.htaccess` to `.htaccess`, and adapt it to your path
    * Rename `example.htpasswd` to `.htpasswd`. The default user is `admin` with `admin` password
* Create your user: http://yourhost/index.php/register
* Active this user: http://yourhost/admin.php/users

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
