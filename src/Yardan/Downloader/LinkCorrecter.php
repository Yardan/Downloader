<?php

namespace Yardan\Downloader;

use Yardan\Downloader\Exception\TypeException;

class LinkCorrecter implements LinkCorrectorInterface
{
    public function correctLink($link)
    {
        if (!is_string($link)) {
            throw new TypeException('$link must be string');
        }

        $link= trim($link);
        if (preg_match('/^([htp]{1,4}):(\/*)(.*?)$/i', $link, $matches)) {
            if ($matches[1]!=='http') {
                $matches[1] = 'http';
            }
            if ($matches[2]!=='//') {
                $matches[2] = '//';
            }
            $link = $matches[1].':'.$matches[2].$matches[3];
        } else {
            $link = 'http://'.$link;
        }
        return $link;
    }
}