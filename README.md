# Webdev Helper

![Codelab7](https://codelab7.com/wp-content/themes/codelab7/assets/images/logo/logo.png)

A Handy plugin to help new wordpress development. To start working and twisting wordpress functinality, this plugin provide base for the new plugin.

## Use
- Download Zip and unzip it at `wp-content/plugins` Folder.
- Start with `webdevhelper.php` to change Plug In Name.

### Register Actions and Hooks
You can use `includes/class-webdevhelper.php` file for adding actions and hooks.  Define hooks under `define_public_hooks` and `define_admin_hooks` as per your use.

And there must be a function for the same into file `public/class-webdevhelper-public.php` and `admin/class-webdevhelper-admin.php` for doing things with actions.
