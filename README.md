## What is this repository for?
**Coverage Insight** - is a software tool designed to help insurance agents get the most out of their book of business by making customer insurance review meetings as insightful as possible. The principles involved in Coverage Insight’s features focus on improving client retention, uncovering new policy sales, and ultimately making more money.

* Current Release: 3.0
* Next Release: 3.5

## How do I get set up? ##

 ## You will need the following development software tools installed:
   - [x] LAMP (Linux, Apache, MySQL, PHP)
   - [x] Code Editor  (Sublime Text, Webstorm use what you are most comfortable with)
   - [x] Node ([Install NPM Tool](https://nodejs.org))
   - [x] Composer (https://getcomposer.org)
   
 ## Configuration
  1. Before you can work to Coverage Insights Tool you need to "Clone" this repository 
```
```

  2. After you cloned the project, go to project directory -> installer folder -> and extract the Yii framework and Node Modules that was compressed to **.tar**
```
     $ cd app.coverage-insight.local
     $ cd installer
     $ tar -xf node_modules.tar -C ../node_modules
     $ tar -xf yii16.tar -C ../yii16
```
	 
 ## Dependencies
 ```
1. Yii v1.1.16
2. PHP 5.4+
3. MySQL
```

 ## Database configuration
   1. Edit the content of this configuration file `protected/config/development/main.php`, `protected/config/staging/main.php` and `protected/config/production/main.php`
   
 ## Deployment instructions
  1. The deployment can only be done by FTP, but before uploading your files you need to make sure that the VPN was running


