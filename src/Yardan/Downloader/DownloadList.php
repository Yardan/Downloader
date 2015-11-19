<?php

namespace Yardan\Downloader;

use Exception;

class DownloadList {

    private $downloadList = array();
    /**
     * @var DownloaderInterface
     */
    private $downloader = null;

    /**
     * @param $downloader
     * @param $list
     */
    public function __construct($downloader=null, $list=array()) {
        if(!is_null($downloader)){
            $this->setDownloader($downloader);
        }
        $this->setDownloadList($list);
    }

    /**
     * Set download list
     * @param array $list
     * @return $this
     */
    public function setDownloadList(array $list){
        $this->downloadList = $list;
        return $this;
    }

    /**
     * Set Downloader
     * @param DownloaderInterface $downloader
     * @return $this
     */
    public function setDownloader(DownloaderInterface $downloader){
        $this->downloader = $downloader;
        return $this;
    }

    /**
     * Downloads list
     * @todo return some responce
     * @throws Exception
     */
    public function downloadList(){
        if(is_null($this->downloader)){
            throw new Exception('You must set DownloaderInterface first!');
        }

        if(empty($this->downloadList)){
            throw new Exception('Download list is empty!');
        }

        foreach ($this->downloadList as $item) {
            $this->downloader->setSource($item);
            if (!$this->downloader->download()) {
                throw new Exception('Can\'t download '.$item.' to disc.');
            }
        }
    }
}