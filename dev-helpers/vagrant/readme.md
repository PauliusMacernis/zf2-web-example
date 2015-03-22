How to install the virtual environment?
1. Do "vagrant up" (more info: https://www.vagrantup.com)
2. Append local host file with "192.168.56.101	veikt.dev" (without ")
3. Remove "public" directory of "veikt.dev/public_html"
4. Navigate to "veikt.dev/public_html"
5. Do "git clone https://github.com/sugalvojau/veikt.com.git . " (more info: http://git-scm.com/)
6. Open the file "veikt.dev/public_html/public/.htaccess" and comment (or remove) the "A2 Switcher Block" section


How to install web application (1/2)?
1. Navigate to "veikt.dev/veikt.dev/public_html" and do "composer.phar install" (more info: https://getcomposer.org/)
2. Copy *.php.dist files from public_html/module/**/config to "veikt.dev/public_html/config/autoload/*.php". Owervrite file if any with the same name exists.


How to connect to database with HeidiSQL (more info: http://www.heidisql.com/)?
1. Open HeidiSQL.
2. Click "New", give a name to the session (e.g.: "veikt.dev")
3. Network type: "MySQL (SSH tunnel)"
4. Hostname: 127.0.0.1
5. User: "root"
6. Password: "123"
7. Open "SSH tunnel" tab and select the location of plink file (more info: http://www.chiark.greenend.org.uk/~sgtatham/putty/)
8. SSH host: 127.0.0.1
9. Port: 2222
10. Username: "vagrant"
11. Private key file: select SSH key generated at puphpet/files/dot/ssh/id_rsa. This key is generated after your initial $ vagrant up
12. Save
13. Open
14. If being prompt "Store key in cache?" then answer anything you like or "yes" (as I do for now)


How to install web application (2/2) (database part)?
1. By using HeidiSQL (or other DB management tool) run every sql script you find in "veikt.dev/public_html/module/*/sql" directory. Don`t forget tu run it against the web database named "veikt", not against any other database. :)

...........
And then... Navigate to "veikt.dev" by using your web browser.


How to get a user to connect to the web?
1 . At the moment you have to create user by hands. It means you have to navigate to "http://veikt.dev/user/account/register" and register the user. If you registered successfully then you can log in with the user by going to "http://veikt.dev/user/log/in". If you wish to get other role than the usual "member" then you have to chenge the role of existing user to the one you wish. The change must be made in database table user column role. Two values exists for today: "member" and "admin".