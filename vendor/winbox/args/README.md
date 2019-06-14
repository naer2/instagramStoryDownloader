Winbox-Args
===========

[![Build Status](https://travis-ci.org/johnstevenson/winbox-args.svg?branch=master)](https://travis-ci.org/johnstevenson/winbox-args)
[![Build status](https://ci.appveyor.com/api/projects/status/p4k75qqcyioj0mfl?svg=true)](https://ci.appveyor.com/project/johnstevenson/winbox-args)

A PHP function to escape command-line arguments, which on Windows replaces `escapeshellarg` with a more robust method. Install from [Packagist][packagist] and use it like this:

```php
$escaped = Winbox\Args::escape($argument);
```

Alternatively, you can just [copy the code][function] into your own project (but please keep the license attribution and documentation link).

### What it does
The following transformations are made:

* Double-quotes are escaped with a backslash, with any preceeding backslashes doubled up.
* The argument is only enclosed in double-quotes if it contains whitespace or is empty.
* Trailing backslashes are doubled up if the argument is enclosed in double-quotes.

See [How Windows parses the command-line](https://github.com/johnstevenson/winbox-args/wiki/How-Windows-parses-the-command-line) if you would like to know why.

By default, _cmd.exe_ meta characters are also escaped:

* by caret-escaping the transformed argument (if it contains internal double-quotes or `%...%` syntax).
* or by enclosing the argument in double-quotes.

There are a couple limitations:

1. If _cmd_ is started with _DelayedExpansion_ enabled, `!...!` syntax could expand environment variables.
2. If the program name requires caret-escaping and contains whitespace, _cmd_ will not recognize it.

See [How cmd.exe parses a command](https://github.com/johnstevenson/winbox-args/wiki/How-cmd.exe-parses-a-command) and [Implementing a solution](https://github.com/johnstevenson/winbox-args/wiki/Implementing-a-solution) for more information.

### Is that it?
Yup. An entire repo for a tiny function. However, it needs quite a lot of explanation because:

* the command-line parsing rules in Windows are not immediately obvious.
* PHP generally uses _cmd.exe_ to execute programs and this applies a different set of rules.
* there is no simple solution.

Full details explaining the different parsing rules, potential pitfalls and limitations can be found in the [Wiki][wiki].

## License
Winbox-Args is licensed under the MIT License - see the LICENSE file for details.

[function]: https://github.com/johnstevenson/winbox-args/blob/master/src/Args.php#L15
[wiki]:https://github.com/johnstevenson/winbox-args/wiki/Home
[packagist]: https://packagist.org/packages/winbox/args
