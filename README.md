# Downloader
File downloader
This class will help you to download files.

## Basic Usage

```php
<?php

use Yardan\Downloader\Downloader;
use Yardan\Downloader\LinkCorrecter;

try {
    $downloader = new Downloader(new LinkCorrecter());
    $result = $test->setSource('https://studentshare.net/themes/default-bootstrap/img/academic_materials.jpg')->download();
} catch (Exception $e){
    echo $e->getMessage();
}

```
