# Laravel Resource Creator

The purpose of this package is to create view, style, and javascript. You will see that it's able to create all boilerplates to reduce repetitive works.

## Installation
If you installed **[Packagified Laravel](https://github.com/bulentAkgul/packagified-laravel)**, you should have this package already. So skip installation.
```
sail composer require bakgul/laravel-resource-creator --dev
```
**NOTE**: This package will not install **[Laravel File Creator](https://github.com/bulentAkgul/laravel-file-creator)**, but you will need it to create Balde component classes and Livewire classes. 

Next, you need to publish the settings through executing the following command. By doing so, you will have a new file named **packagify.php** in the config folder. The resources types in the "**resources**" array. The meins settings of files in the **files** array under the keys of "*view, css, js*." A quite deep explanations are provided in the comment blocks of those array.
```
sail artisan packagify:publish-config
```
After publishing stubs, you will be able to update the stub files as you need. It's safe to delete the untouched files.
```
sail artisan packagify:publish-stub
```

### Command Signature
```
create:resource {name} {type} {package?} {app?} {--p|parent=} {--c|class} {--t|taskless} {--f|force}
```

### Arguments and Options
+ **Name**: subs/name:task

  + **subs**: You can specify subfolders like **sub1/sub2/sub3** when you need deeper file structure.

  + **name**: The file name without any suffix.

  + **task**: This is optional.
    + *exist*: You may set one or more tasks with a dot-seperatod fashion like "**users:index**" or "**users:index.store.update**." If you pass a task that isn't in the list of the given file type's task list, and the global task list (see the tasks array on **config/packagify.php**), it will be ignored.
    + *missing*: If the underlying file type has tasks, a seperate file will be generated for each of them. Otherwise a single file will be generated.

+ **Type**: name:variation:role

  + **name**: It should be one of 'view, css, js.' It will be determined which file type will be generated based on the app type. For example, if you create files for admin app, and the admin app's type is 'vue', then the view files will be Vue, js files will be store and route files. The settings of those types are in the 'resources' array on 'packagify.php'.

  + **variation**: It's required and should be one of the variatons of the specified file type.

  + **role**: It's optional.
    + *exist*: It should be one of the items in the roles array.
    + *missing*: It will be default one which is no-role.

+ **Package**: It won't be used when you work on a Standalone Laravel or Standalone Package. If you don't specify a valid package name, the file will be generated in the resources folder.

+ **App**: To create files for a specific app, you need to specified the app name. The settings are in **apps** array on **packagify.php** file.

+ **Parent**: When you create a section, you need to tell what is the page name that holds the creating section.

+ **Class**: When you create a Blade component, you need to add "**-c**" or "**--class**" to the command to create a class of the component.

+ **Taskless**: The file types that have tasks like service, or test, will be generated as a seperate file for each task unless tasks are specified. But sometime, you may want to create a single file without any task. To do that, you need to append "**-t**" or "**--taskless**" to your command. This will cancel the default behaviour of the task explosion.

+ **Force**: Normally, a file will not be regenerated if it exists. If this options is passed, a new file will be created anyway.

## Packagified Laravel
The main package that includes this one can be found here: **[Packagified Laravel](https://github.com/bulentAkgul/packagified-laravel)**

## The Packages That Will Be Installed By This Package
+ **[Command Evaluator](https://github.com/bulentAkgul/command-evaluator)**
+ **[File Content](https://github.com/bulentAkgul/file-content)**
+ **[File History](https://github.com/bulentAkgul/file-history)**
+ **[Kernel](https://github.com/bulentAkgul/kernel)**