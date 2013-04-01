Welcome to the Indy Framework.

The Indy Framework is written in PHP and aims to provide three main areas of functionality:

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


Latest Changes 

1st April 2013
==============
Restructured the Git repository to separate the documentation out of the framework
directory. I've also move some of the providers that haven't been fully tested out
of the main framework directory into a directory called 'extra'

15th April 2012
==============

Refactored Page handling to lower memory footprint
Refactored Tag handling to improve nested tag support.
General bug fixing
