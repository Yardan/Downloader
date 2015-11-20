<?php

namespace Yardan\Downloader;

use Exception;
use Yardan\Downloader\Exception\TypeException;

/**
 * Class Downloader
 * @package Yardan\Downloader
 */
class Downloader implements DownloaderInterface
{
    private $source = null;
    private $destination = null;
    private $directory = null;

    /**
     * @var LinkCorrectorInterface
     */
    private $linkCorrecter = null;

    /**
     * @param LinkCorrectorInterface|null $correcter
     * @param string $directory
     * @throws TypeException
     */
    public function __construct(LinkCorrectorInterface $correcter = null, $directory='tmp') {
        $this->setLinkCorrecter($correcter);
        $this->setDirectory($directory);
    }

    /**
     * Set Link correcter
     * @param LinkCorrectorInterface|null $correcter
     * @return $this
     */
    public function setLinkCorrecter(LinkCorrectorInterface $correcter = null){
        $this->linkCorrecter = $correcter;
        return $this;
    }

    /**
     * @return LinkCorrectorInterface
     */
    public function getLinkCorrecter(){
        return $this->linkCorrecter;
    }

    /**
     * @param $directory
     * @return $this
     * @throws TypeException
     */
    public function setDirectory($directory){
        if (!is_string($directory)) {
            throw new TypeException('$directory must be string');
        }
        $this->directory = $directory;
        return $this;
    }

    /**
     * @return null
     */
    public function getDirectory(){
        return $this->directory;
    }

    /**
     * @param $source
     * @return $this
     * @throws TypeException
     */
    public function setSource($source){
        if (!is_string($source)) {
            throw new TypeException('Source must be string');
        }
        $this->source = $source;
        return $this;
    }

    /**
     * Returns source filename
     * @return string
     */
    public function getSource(){
        return $this->source;
    }

    /**
     * Set Destination
     * @param $destination
     * @return $this
     * @throws TypeException
     */
    public function setOutputName($destination){
        if (!is_string($destination)) {
            throw new TypeException('Destination must be string');
        }
        $this->destination = $destination;
        return $this;
    }

    /**
     * Get Destination
     * @return null
     * @throws TypeException
     */
    public function getOutputName(){

        if (!is_null($this->destination) && is_string($this->destination)) {
            return $this->destination;
        }

        if(is_null($this->source) || !is_string($this->source)){
            throw new TypeException('Source is not settled!');
        }

        //otherwise get destination name from source name
        preg_match('/\/([0-9a-z_\.\-]+)$/i', $this->source, $matches);
        return $matches[1];
    }

    /**
     * Downloads file
     * @return string
     * @throws Exception
     * @throws TypeException
     */
    public function download(){

        if(is_null($this->getSource())){
            throw new Exception('You must set source file!');
        }

        if(is_null($this->getDirectory())){
            throw new Exception('You must set directory!');
        }

        if (!file_exists($this->getDirectory())) {
            throw new Exception('Directory '.$this->getDirectory().' is not exists!');
        }

        //destination path
        $destination = $this->getDirectory().DIRECTORY_SEPARATOR.$this->getOutputName();

        if(file_put_contents($destination, $this->curl_get_contents($this->source))){
            return $destination;
        } else {
            throw new Exception('Can\'t write to '.$destination.'!');
        }
    }

    /**
     * Get content by url
     * @param $url
     * @return string
     * @throws Exception
     * @throws TypeException
     */
    protected function curl_get_contents($url){
        if (!is_string($url)) {
            throw new TypeException('$url must be string');
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $data = curl_exec($ch);
        $header = substr($data, 0, curl_getinfo($ch, CURLINFO_HEADER_SIZE));
        $body = substr($data, curl_getinfo($ch, CURLINFO_HEADER_SIZE));
        curl_close($ch);

        if(!$this->checkResponse($header)){
            throw new Exception('Resourse is not available!');
        }
        return $body;
    }

    /**
     * @param $header
     * @return bool
     */
    protected function checkResponse($header){
        $headers = explode("\n", $header);

        $codes = array('200', '301', '302');

        foreach($headers as $item){
            if(strstr($item, 'HTTP')){
                $codeItem = $item;
                break;
            }
        }

        foreach($codes as $code){
            if(strstr($codeItem, $code)){
               return true;
            }
        }

        return false;
    }
















}