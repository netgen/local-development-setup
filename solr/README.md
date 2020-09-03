# Set up Apache Solr

Here you will install Apache Solr. Open https://downloads.apache.org/lucene/solr
in your browser and find the Solr package for the version you want to install.
Copy the link to it.

## Set up recent version of Solr

### 1 Install

In the console, create `solr` directory in your home directory and position into
it:

```console
mkdir ~/solr
cd ~/solr
```

Now download your chosen Solr package from
https://lucene.apache.org/solr/downloads.html, extract it, delete the archive
and position into the extracted directory:

```console
wget https://downloads.apache.org/lucene/solr/7.7.3/solr-7.7.3.tgz
tar xzf solr-7.7.3.tgz && rm solr-7.7.3.tgz
cd solr-7.7.3
```

### 2 Start

From the installation directory you can start the Solr server using the provided
`solr` command:

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

`-Dsolr.disable.shardsWhitelist=true`

In this case, stop the server when needed with `Control-C`.

### Add a new core

You can use `solr` command to create a new core using a specific configuration.
Prepare your configuration in a separate directory, then execute:

```console
./bin/solr create_core -c my_new_core -d /path/to/my/solr/config
```

Core can also be removed from the server:

```console
./bin/solr delete -c my_new_core
```

**Note**: Solr must be running for these commands to work.

To find out about other available options, execute the `solr` command without
arguments and follow the given instructions.

## Set up Solr version 4.10.4

### 1 Install

In the console, create `solr` directory in your home directory and position into
it:

```console
mkdir ~/solr
cd ~/solr
```

Now download your chosen Solr package from
https://archive.apache.org/dist/lucene/solr/, extract it, delete the archive
and position into the extracted directory:

```console
wget https://archive.apache.org/dist/lucene/solr/4.10.4/solr-4.10.4.tgz
tar xzf solr-4.10.4.tgz && rm solr-4.10.4.tgz
cd solr-4.10.4
```

To run this version of Solr, you will also Java 7. In the console, create `java`
directory in your home directory and position into it:

```console
mkdir ~/java
cd ~/java
```

Download your chosen java package in the archive format from
https://www.oracle.com/java/technologies/javase/javase7-archive-downloads.html.
Download Java SE Runtime Environment 7u51 and place it in the previously created
directory `~/java`.

Now you can extract it and delete the archive:

```console
cd ~/java
tar xzf jre-7u51-macosx-x64.tar.gz && rm jre-7u51-macosx-x64.tar.gz
```

You can use Java directly from the extracted directory, for example:

```console
~/java/jre1.7.0_51.jre/Contents/Home/bin/java -version
```

If you use MacOS, it will prevent you from executing an unverified binary, so
make sure you register your terminal application as a Developer Tool in System
Preferences > Security & Privacy > Privacy.

### 2 Configure

A big Solr query might fail because of request header size limitation set on the
Jetty connector. If this happens, you will get an error like:

```text
11380 [qtp853119666-17] WARN  org.eclipse.jetty.http.HttpParser  – HttpParser Full for /0:0:0:0:0:0:0:1:8983 <--> /0:0:0:0:0:0:0:1:57176
```

To fix this problem, open `~/solr/solr-4.10.4/example/etc/jetty.xml` file and
configure a bigger request query size:

```diff
<Call name="addConnector">
    <Arg>
        <New class="org.eclipse.jetty.server.bio.SocketConnector">
            <Set name="host"><SystemProperty name="jetty.host" /></Set>
            <Set name="port"><SystemProperty name="jetty.port" default="8983"/></Set>
            <Set name="maxIdleTime">50000</Set>
            <Set name="lowResourceMaxIdleTime">1500</Set>
            <Set name="statsOn">false</Set>
+            <Set name="requestHeaderSize">10240000</Set>
        </New>
    </Arg>
</Call>
```

### 3 Start

To start Solr, prepare your cores in `~/solr/solr-4.10.4/example/multicore` and
position into `~/solr/solr-4.10.4/example`. Then execute:

```console
~/java/jre1.7.0_51.jre/Contents/Home/bin/java -Djetty.port=8983 -Dsolr.solr.home=multicore -jar start.jar
```

The server will run in the foreground, and you can stop it when needed with
`Control-C`.
