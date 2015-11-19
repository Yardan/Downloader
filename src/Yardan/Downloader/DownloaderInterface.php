<?php

namespace Yardan\Downloader;

interface DownloaderInterface
{
    public function download();

    public function setSource($source);

    public function setOutputName($destination);

    public function getSource();

    public function getOutputName();
}