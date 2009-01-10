Installation steps:
1. Rename all *.dist files so they are without the extension, eg.
file.php.dist => file.php
2. Set path to symfony in ProjectConfiguration.class.php
(it should be there as default, but keep watch on where you keep pear!)
3. Set database user in databases.yml(previously databases.yml.dist)
4. Open terminal and navigate to this project
5. Run 'chmod 777 cache log web/uploads' command
6. Run 'rm -rf cache/*' command
7. Run 'php symfony doctrine:build-all-reload' command
8. Add following text in your vhosts config:

    # Be sure to only have this line once in your configuration
    NameVirtualHost 127.0.0.1:80

    # This is the configuration for coloni
    Listen 127.0.0.1:80
    
    <VirtualHost 127.0.0.1:80>
      ServerName coloni.localhost
      DocumentRoot "/youcoloniinstall/web"
      DirectoryIndex index.php
      <Directory "/yourcoloniinstall/web">
        AllowOverride All
        Allow from All
      </Directory>
    
      Alias /sf "/pathtosymfony/web/sf"
      <Directory "/pathtosymfony/web/sf">
        AllowOverride All
        Allow from All
      </Directory>
    </VirtualHost>

7. Append to your /etc/hosts:
127.0.0.1 coloni.localhost