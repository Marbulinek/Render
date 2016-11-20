# Render
Did you create HTML and CSS template of your new website and now you need render menu quickly?
Class Render will take responsibility about it. Of course, generating menu and navigation is in package...

## Implementation
index.php - main page

First step - create instance of class Render
```php
<?php
include_once "Core/Render.php";
$Render = new Render();
?>
```

## Optional settings

```php
<?php

//define base at url bar which will open pages
$Render->SetBase("page");

//name of the dir located at disk which contain pages
$Render->SetPagesDir("subpagesFolder");

//website defined as fail site - example: 404_page_not_found
$Render->Set404Page("error");

//set css selector for active link
$Render->SetCSSActive("activeLink");
 
//links
$Render->CreateLink("Home");
$Render->CreateLink("About us");
$Render->CreateLink("Products and services");
$Render->CreateLink("Contact");
  
//create navigator
// 2 parameters - highlight  - if you want to use activeLink selector
//              - SEO -if you want to use nice seo names of links 
$Render->RenderNavigator();
  
//rendering menu
$Render->RenderMenu();

?>
```
