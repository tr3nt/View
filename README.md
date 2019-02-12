## View

Generate Views from main Layout and HTML files with PHP

simple as:

```
$view = new View();

// Get contact.html and load into visitor_layout.html
$view->setView('contact', 'visitor_layout');

// Add <script> tag to <head> section
$view->addHeader('js/jquery.min.js');

// Add 'title' variable to <body> section
$view->add(['title' => 'Hello World!']);

// Print on screen
$view->render();
```

**visitor_layout.html** example:
```
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Example</title>
        
        {headers}
        
    </head>
    <body>
    
        {content}
    
    </body>
</html>
```

**contact.html** example:
```
<h1>{title}</h1>
```


- TODO:
  - Set Arrays on variable views.

_Cause we can only set strings for now._