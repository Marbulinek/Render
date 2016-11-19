# Render
Did you create HTML and CSS template of your new website and now you need render menu quickly?
Class Render will take responsibility about it. Of course, generating menu and navigation is in package...

## Implementation
index.php - main page

First step - create instance of class Render
```php
<?php
include_once "Render.php";
$Render = new Render();
?>
```

## Optional settings


```php
<?php

//define base at url bar which will open pages
$Render->nastavBazu("page"); 

//name of the dir located at disk which contain pages
$Render->nastavPriecinokStranok("stranky"); 

//website defined as fail site - example: 404_page_not_found
$Render->nastavStrankuChyby("chyba"); 
 

//creating links at documents
$Render->vytvorLink("O jídelně");
$Render->vytvorLink("Provozní řád");
$Render->vytvorLink("Ceník stravování");
$Render->vytvorLink("Jídelníček");
$Render->vytvorLink("Kontakt");
  
//create navigator  A)
$Render->renderNavigator();
  
//or for support nice url pages .HTACCESS (napr. 'http://example.eu/o-nas') B) 
$Render->renderSEONavigator();
  
//rendering menu
$Render->renderMenu();

?>
```
