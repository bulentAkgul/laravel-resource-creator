# Laravel Resource Creator

This package aims to create the view, style, and javascript. It can create all boilerplates to reduce repetitive tasks.

## Installation

If you installed [**Packagified Laravel**](https://github.com/bulentAkgul/packagified-laravel), you should have this package already. So skip installation.
```
composer require bakgul/laravel-resource-creator --dev
```
**NOTE**: This package will not install [**Laravel File Creator**](https://github.com/bulentAkgul/laravel-file-creator), but you will need it to create the Balde component and Livewire classes.

Next, you need to publish the settings by executing the following command. By doing so, you will have a new file named **packagify.php** in the config folder. The resource types are in the "**resources**" array. The main settings of files in the **files** array under the keys of "*view, css, js*." Quite deep explanations are provided in the comment blocks of those arrays.
```
sail artisan packagify:publish-config
```
After publishing stubs, you will be able to update the stub files as you need. It's safe to delete the unedited files.
```
sail artisan packagify:publish-stub
```
### Command Signature
```
create:resource {name} {type} {package?} {app?} {--p|parent=} {--c|class} {--t|taskless} {--f|force}
```

### Arguments and Options

-   **name**: subs/name:task

    -   **subs**: You can specify subfolders like **sub1/sub2/sub3** when you need a deeper file structure.

    -   **name**: The file name without any suffix.
 
    -   **task**: This is optional.
        -   *exist*: You may set one or more tasks with a dot-separated fashion like "**users:index**" or "**users:index.store.update**." The task should be in the file type and its pairs' and the global task lists (see the tasks array on **config/packagify.php**). Otherwise, it will be ignored.
        -   *missing*: If the underlying file type has tasks, a separate file will be generated for each of them. Otherwise, a single file will be generated.

-   **Type**: name:variation:role
    -   **name**: It should be one of 'view, css, js.' It will be determined which file type will be generated based on the app type. For example, if you create files for the admin app, and the admin app's type is 'vue', then the view files will be Vue, and js files will be 'store' and 'route' files. The settings of those types are in the 'resources' array on 'packagify.php'.
   
    -   **variation**: It's required and should be one of the variations of the specified file type.
    
    -   **role**: It's optional.
        -   *exist*: It should be one of the items in the roles array.
        -   *missing*: It will be the default one which is no-role.

-   **Package**: It won't be used when working on a Standalone Laravel or Standalone Package. If you don't specify a valid package name, the file will be generated in the resources folder.

-   **App**: To create files for a specific app, you must specify the app name. The settings are in the **apps** array on **the packagify.php** file.

-   **Parent**: When you create a section, you need to tell what is the page name that holds the creating section.

-   **Class**: When you create a Blade component, you need to add "**-c**" or "**--class**" to the command to create a class of the component.

-   **Taskless**: The sections will be generated as a separate file for each task unless the comment has tasks. But sometimes, you may want to create a single file without any task. In such cases, you need to append '-t' or '--taskless' to your command. This will cancel the default behavior of the task explosion.

-   **Force**: Normally, a file will not be regenerated if it exists. If this option is passed, a new file will be created anyway.

## Packagified Laravel

The main package that includes this one can be found here: [**Packagified Laravel**](https://github.com/bulentAkgul/packagified-laravel)

## The Packages That Will Be Installed By This Package

-   [**Command Evaluator**](https://github.com/bulentAkgul/command-evaluator)
-   [**File Content**](https://github.com/bulentAkgul/file-content)
-   [**File History**](https://github.com/bulentAkgul/file-history)
-   [**Kernel**](https://github.com/bulentAkgul/kernel)