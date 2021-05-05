# About

My setup for creating a WordPress plugin (Windows, VS Code).

Includes
- Laravel Mix with browserSync
- composer autoload
- namespaces
- WordPress Coding standards & php formatting
- note - nothing for uninstall plugin

## With browserSync

1. Rename the project folder & 'marie-wp-plugin-starter' entry file

3. Find & replace 'MariePluginStarter' with an appropiate namespace

4. Find & replace functions prefixed with 'marie_wp_plugin_starter'

5. Find & replace any 'marie-wp-plugin-starter'

6. Edit webpack.mix.js. Set proxy to wherever WordPress is running

7. Make sure src/js/name-of-your-script.js matches `mix.js()`  call in `webpack.mix.js` and `enqueue()` call in `YourPlugin\Base->Enqueue`

8. Make sure src/scss/name-of-your-style.scss matches `mix.scss()` call in `webpack.mix.js` and is `name-of-your-css.css` in  `enqueue()` call in `YourPlugin\Base->Enqueue`


```js
mix.browserSync({
  proxy: 'localhost/some-wp-install',
  // ...
});
```

5. `npm install` for laravel-mix & browserSync stuff.
6. `composer install` for CodeSniffer and autoload.
7. `npx mix watch`

Now the plugin can be activated. Client side js & css should be enqueued from dist folder.

## Without browserSync

- delete the package.json (and node_modules if it exists)
- delete the mix.browserSync() call in webpack.mix.js
  and just run

```
npm init -y
```

```
npm install laravel-mix --save-dev
```

run `npx mix ` to compile. The first time that `npx mix ` is run the mix dependencies will be added automatically. Run `npx mix` again.

## WordPress Coding Standards & formatting

Note: WordPress coding standards require codesniffer https://github.com/squizlabs/PHP_CodeSniffer (included in composer.json).

To get the Coding Standards & formatting working

1.  ### Clone the WordPress coding standards if you don't already have them.

```bash
git clone -b master https://github.com/WordPress/WordPress-Coding-Standards.git wpcs
```

I keep mine in C:/Users/Me/wpcs and update them every so often. phpcs wants to know where the standards are as an absolute path and keeping them in "~/wpcs" makes things easier.

2. ### Set the _ABSOLUTE_ path to the standards.

```bash
 ./vendor/bin/phpcs --config-set installed_paths ~/wpcs
```

#### Check that setting the path worked

```bash
 ./vendor/bin/phpcs -i
```

gives list of available standards and now should include WordPress...



## PHP Sniffer & Beautifer for VS Code.

I originally used [phpcbf](https://github.com/soderlind/vscode-phpcbf) as the default formatter with these settings in vscode settings.json

```json
"phpcs.standard": "Wordpress",
"phpcbf.enable": true,
"phpcbf.executablePath": "./vendor/bin/phpcbf.bat",
"phpcbf.documentFormattingProvider": true,
"phpcbf.onsave": true,
"phpcbf.standard": "Wordpress",
"[php]": {
		"editor.defaultFormatter": "persoderlind.vscode-phpcbf",
},

```

Using the `persoderlind.vscode-phpcbf` as default formatter technically worked but caused the progress bar at the top of vscode (.monaco-progress-container) to go back and over finitely until all tabs were closed. 

[PHP Sniffer & Beautifier for VS Code](https://github.com/valeryan/vscode-phpsab) seems to work better. Here is the relevant part of settings.json. 

```json
"phpsab.snifferEnable" : false,
"phpsab.autoRulesetSearch": false,
"phpsab.fixerEnable": true,
"phpsab.snifferShowSources": true,
"phpsab.standard": "WordPress",
"[php]": {
    "editor.defaultFormatter": "valeryanm.vscode-phpsab",        
},
  "phpcs.standard": "Wordpress",
```
* reload VS Code.
* now shift+alt+f should format php files 

## phpcs.xml

phpcs.xml stops WordPress standards complaining about class names and class file names.
