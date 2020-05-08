# Install and configure `MySQL` database server

Here you will install and configure MySQL database server.

**Step 1**: Install MySQL server using `brew`:

```bash
brew install mysql
```

**Step 2**: Start MySQL server:

```bash
brew services start mysql
```

**Step 3**: Set up `root` user password:

```bash
mysql_secure_installation
```

Follow the instructions to configure `root` as password for the `root` user and
disallow remote login for it. This will be sufficient for local development
needs.

## Tips

You will probably want a graphical UI client to work with the database server.
For MacOS, [TablePlus](https://tableplus.com/) is a good choice, offering
unlimited free trial with reasonable limitations for light use.
