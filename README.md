# share-theme

### CSS modifications

To modify the CSS it is strongly suggested that you work with the SASS partials in this folder: ```wp-content/themes/share/scss```  For more information about SASS partials, please see this article: http://thesassway.com/beginner/how-to-structure-a-sass-project

Working with SASS partials as opposed to editing the compiled CSS makes for a much more maintainable and organized code structure.

You will need the following software installed:

* The most recent version of SASS: http://sass-lang.com/
* Compass and Susy, tools and frameworks for SASS: http://compass-style.org/ http://susy.oddbird.net/

In order to compile .scss into .css, do the following: (OS X directions supplied, Windows will be similar but you won't use Terminal)

* In Terminal, navigate to the template folder: ```wp-content/themes/share/```
* Type the following ```sass --watch scss:css``` and hit enter.
* SASS will begin watching the scss folder. Saving anything in the scss folder will automatically compile a new main.css and main.css.map, both of which should be uploaded.

### Credit

This theme was developed by Ian Hamilton at [colorcrate.com](http://colorcrate.com). It is built on BlankSlate from [tidythemes.com](http://tidythemes.com).

### Questions?

Shoot Ian an email at [ian@colorcrate.com](mailto:ian@colorcrate.com?subject=SHARE theme).