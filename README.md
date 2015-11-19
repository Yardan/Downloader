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
    $downloader->setSource('http://site.com/img/picture.jpg')
    ->setDirectory('tmp')
    ->setOutputName('not-picture.jpg')
    ->download();
} catch (Exception $e){
    echo $e->getMessage();
}
```


## Details

If you did not not provide directory and output name, by default it will save file in directory 'tmp/' with original name. But first you should create 'tmp/' folder.

```php
<?php
use Yardan\Downloader\Downloader;
use Yardan\Downloader\LinkCorrecter;

try {
    $downloader = new Downloader(new LinkCorrecter());
    $downloader->setSource('http://site.com/img/picture.jpg')->download();
} catch (Exception $e){
    echo $e->getMessage();
}
```
