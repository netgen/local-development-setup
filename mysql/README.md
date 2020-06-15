# Install and configure MySQL database server

Here you will install and configure MySQL database server.

## 1. Install and start `MySQL` server

### 1.1 Install on Mac using `Homebrew`

To install `MySQL` server using `Homebrew` execute the following on the command
line:

```console
brew install mysql
```

Now start `MySQL` server by executing:

```console
brew services start mysql
```

This will also ensure that `MySQL` server starts automatically after a reboot.

### 1.2 Install on Mac using `MacPorts`

To install `MySQL` server using `MacPorts` execute the following on the command
line:

```console
sudo port install mysql8-server
```

Select `mysql8` as your preferred version of `MySQL` with:

```console
sudo port select mysql mysql8
```

Now initialize the server with:

```console
sudo /opt/local/lib/mysql8/bin/mysqld --initialize --user=_mysql
```

Take note of the generated `root` password.

Now you can start the server with:

```console
sudo port load mysql8-server
```

This will also ensure that `MySQL` server starts automatically after a reboot.

## 2. Secure the installation

Execute the following on the command line:

```console
mysql_secure_installation
```

Follow the instructions to configure `root` as password for the `root` user. If
`MySQL` was installed using `MacPorts`, enter the password generated at the
initialization.

Additionally, follow the instructions to skip setting up VALIDATE PASSWORD
component, remove anonymous users and test databases and disallow the remote
login for `root`. That will be sufficient for local development needs.

## 3. Configure the server

Note: this step is necessary only if `MacPorts` was used to install the `MySQL`
server.

Edit file `/opt/local/etc/mysql8/my.cnf`, remove the line including the default
MacPorts settings and add the following configuration.

```dosini
[mysqld]
basedir="/opt/local"
bind-address=127.0.0.1
```

Now reload the server with:

```console
sudo port reload mysql8-server
```

## 4. Test that server is up and running

Log into the server by executing the following on the command line:

```console
mysql -uroot -p
```

Enter the password when asked. If you set up everything correctly, you should
arrive at the MySQL command-line client:

```text
Welcome to the MySQL monitor.  Commands end with ; or \g.
Your MySQL connection id is 49

Copyright (c) 2000, 2020, Oracle and/or its affiliates. All rights reserved.

Oracle is a registered trademark of Oracle Corporation and/or its
affiliates. Other names may be trademarks of their respective
owners.

Type 'help;' or '\h' for help. Type '\c' to clear the current input statement.

mysql>
```

## 5. Limit the size of binary logs

On the `mysql` prompt, execute the following to set binary log expiry to 1 day:

```console
SET GLOBAL binlog_expire_logs_seconds=86400;
SET PERSIST binlog_expire_logs_seconds=86400;
```

You can now type `exit` to exit the MySQL command-line client.

## 6. Install a GUI client for `MySQL`

You will probably want a graphical UI client to work with the database server.
For MacOS, [TablePlus](https://tableplus.com/) is a good choice, offering
unlimited free trial with reasonable limitations for light use.

Install the client and configure the connection to your `MySQL` server.

If the connection works, you've finished installing and configuring your MySQL
server.
