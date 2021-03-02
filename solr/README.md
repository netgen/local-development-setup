# Set up Apache Solr

Here you will install Apache Solr. Open https://downloads.apache.org/lucene/solr
in your browser and find the Solr package for the version you want to install.
Copy the link to it.

## Set up recent version of Solr

If you want to use multiple versions of Solr, this is the recommended way to
install it, and the procedure is the same for both macOS and Ubuntu. This type
of setup allows you to easily have multiple Solr versions and start/stop them
when needed. The only drawback is that you have to manually start it each time
you need it.

If you want to install it as a service instead, there are instructions at the
end of this document.

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

## Use a specific Java version

If your Solr version requires a different Java version than the one you have
installed globally, you can install that specific Java version on aside, and use
it to run that specific version of Solr.

First, in the console create `java` directory in your home directory and
position into it:

```console
mkdir ~/java
cd ~/java
```

Download your chosen Java SE Runtime Environment in the archive format from
https://www.oracle.com/java/technologies/javase/javase7-archive-downloads.html
and place it in the previously created directory `~/java`.

Extract it and delete the archive:

```console
cd ~/java
tar xzf jre-8u202-macosx-x64.tar.gz && rm jre-8u202-macosx-x64.tar.gz
```

Now you can use that specific version of Java with commands documented above by
defining `SOLR_JAVA_HOME` environment variable on the command line. For example:

```console
SOLR_JAVA_HOME=~/java/jre1.8.0_202.jre/Contents/Home ./bin/solr start -f
```

### Move Java out of the quarantine on macOS

For security reasons macOS will ask for user confirmation the first time the
downloaded program is run. However, the option to allow the program to run will
not be available for Java installed in the way documented above. To allow it to
run, remove the quarantine flag from the downloaded Java version by executing:

```console
xattr -d com.apple.quarantine ~/java/jre1.8.0_202.jre
```

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

To run this version of Solr, you will also need Java 7. In the console, create
`java` directory in your home directory and position into it:

```console
mkdir ~/java
cd ~/java
```

Download your chosen Java package in the archive format from
https://www.oracle.com/java/technologies/javase/javase7-archive-downloads.html.
Download Java SE Runtime Environment 7u51 and place it in the previously created
directory `~/java`.

Now you can extract it and delete the archive:

```console
cd ~/java
tar xzf jre-7u51-macosx-x64.tar.gz && rm jre-7u51-macosx-x64.tar.gz
```

If you use macOS, it will prevent you from executing an unverified binary, so
make sure you remove the quarantine flag from the downloaded Java version by
executing:

```console
xattr -d com.apple.quarantine ~/java/jre1.7.0_51.jre
```

You can now use Java directly from the extracted directory, for example:

```console
~/java/jre1.7.0_51.jre/Contents/Home/bin/java -version
```

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

## Set up recent version of Solr as a service on Ubuntu (optional)

If you will be using only one version of Solr, then it makes sense to install
it as a service. This setup is similar to the one on production servers, and it
makes it easier to start/stop Solr, and it makes it possible to start Solr
automatically after the reboot.

**Note:** this kind of setup will create `solr` user as well as `solr` user group,
and you will have to use this user to manage cores and data.

### 1 Install

In order to install Solr as a service, execute the following commands:

```console
sudo apt install default-jre
cd /opt
sudo wget https://downloads.apache.org/lucene/solr/7.7.3/solr-7.7.3.tgz
sudo tar -xvzf solr-7.7.3.tgz solr-7.7.3/bin/install_solr_service.sh --strip-components 2
sudo ./install_solr_service.sh solr-7.7.3.tgz
sudo rm -rf install_solr_service.sh solr-7.7.3.tgz
```

### 2 Start

You can control the Solr service with following commands:

```console
sudo systemcl start solr
sudo systemcl stop solr
sudo systemcl restart solr
sudo systemcl status solr
```

### 3 Start automatically after reboot

To check if Solr service is set to automatically start after the reboot, to
enable or disable it, use the following commands:

```console
sudo systemctl is-enabled solr
sudo systemctl enable solr
sudo systemctl disable solr
```

### 4 Add a new core

When using Solr as a service, cores are located in the `/var/solr/data`
directory.

You can use `solr` command to create a new core using a specific configuration.
Prepare your configuration in a separate directory, then execute:

```console
solr create_core -c my_new_core -d /var/solr/data
```

If you want to manually create cores (e.g. if you have them in your project
repository), you need to use the `solr` user:

```console
sudo su solr
```

### 5 Uninstall Solr as a service

If you want to uninstall Solr as a service (e.g. if you decided to have multiple
versions of Solr at the same time), you can do that by executing the following
commands:

**Warning:** This will delete all your cores and data in them!

```console
sudo service solr stop
sudo rm -r /var/solr
sudo rm -r /opt/solr-7.7.3
sudo rm -r /opt/solr 
sudo rm /etc/init.d/solr
sudo deluser --remove-home solr
sudo deluser --group solr
sudo update-rc.d -f solr remove
sudo rm -rf /etc/default/solr.in.sh
```
