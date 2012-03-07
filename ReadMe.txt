Welcome to the Indy Framework.

The IndyFramework is written in PHP and aims to provide three main areas of functionality:

1. Service based application/web site developement
2. Custom Tags to keep the HTML sections of your project script free
3. Dollar Notation, a way of easily putting values into a markup pages without
   the need for PHP 'echo' command.

You can find the latest version of the project in it's GitHub repository
https://github.com/githublemming/indyframework

Status
======
Services         : Stable - This works and has no known bugs
Custom Tags      : Beta   - These work, but there are a few tweaks that need to
                   be made to improve them, and one or two known bugs 
Dollar Notation  : Alpha  - Works for basic notations ${somevalue} and
                   ${class.method}, need to add more variations.

Latest Changes - 3rd March 2012
==============

Improved Exception Handling, should be no more White Screens of Death. The
    error  message (and possibly) an exception should show on the page.
Improved logging
Removed some of the annoying Case Sensitivity
General bug fixing
