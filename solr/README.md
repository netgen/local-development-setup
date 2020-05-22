# Install Apache Solr

Here you will install Apache Solr. Open https://downloads.apache.org/lucene/solr
in your browser and find the Solr package for the version you want to install.
Copy the link to it.

In the console, create `solr` directory in your home directory:

```console
cd ~
mkdir solr
cd solr
```

Now download your chosen Solr package, extract it, delete the archive and
position into the extracted directory:

```console
wget https://downloads.apache.org/lucene/solr/7.7.3/solr-7.7.3.tgz
tar xzf solr-7.7.3.tgz
rm solr-7.7.3.tgz
cd solr-7.7.3
```

From here, you can start the Solr server using the provided `solr` command:

```console
./bin/solr start
```

After the server has started, verify that you can access its web interface on
http://localhost:8983/solr.

The command above will start the server in the background, and you can stop it
with:

```console
./bin/solr stop
```

For debugging purposes you might want to have the server running in the
foreground with `-f` switch:

```console
./bin/solr start -f
```

In this case, stop the server when needed with `Control-C`.

## Adding a new core to the server

You can use `solr` command to create a new core using a specific configuration.
Prepare your configuration in a separate directory, then execute:

```console
./bin/solr create_core -c my_new_core -d /path/to/my/config
```

To find out about other available options, execute the `solr` command without
arguments and follow the given instructions.
