# Install and configure MySQL database server

Here you will install and configure MySQL database server.

**Step 1**: Install MySQL server using `brew`:

```console
brew install mysql
```

**Step 2**: Start MySQL server:

```console
brew services start mysql
```

This will also ensure that MySQL server is automatically started after boot.

**Step 3**: Set up `root` user password and disallow the remote login:

```console
mysql_secure_installation
```

Follow the instructions to configure `root` as password for the `root` user and
disallow the remote login. That will be sufficient for local development needs.

**Step 4**: Test that server is up and running by logging into it from the
command line:

```console
mysql -uroot -p
```

If everything is set up correctly, you should arrive at the MySQL command
prompt:

```text
Welcome to the MySQL monitor.  Commands end with ; or \g.
Your MySQL connection id is 49
Server version: 8.0.19 Homebrew

Copyright (c) 2000, 2020, Oracle and/or its affiliates. All rights reserved.

Oracle is a registered trademark of Oracle Corporation and/or its
affiliates. Other names may be trademarks of their respective
owners.

Type 'help;' or '\h' for help. Type '\c' to clear the current input statement.

mysql>
```

**Step 5**: Limit the size of binary logs

On the `mysql` prompt, execute the following to set binary log expiry to 1 day:

```console
SET GLOBAL binlog_expire_logs_seconds=86400;
```

With that you've finished installing and configuring your MySQL server.

## Tips

You will probably want a graphical UI client to work with the database server.
For MacOS, [TablePlus](https://tableplus.com/) is a good choice, offering
unlimited free trial with reasonable limitations for light use.
