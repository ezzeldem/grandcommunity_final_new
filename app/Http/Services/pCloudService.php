<?php

namespace App\Http\Services;

use pCloud\Sdk\App;
use pCloud\Sdk\File;
use pCloud\Sdk\Request as PCloudRequest;

class pCloudService
{
    public static $locationid;
    public static $access_token;
    public static $bestFolder;
    public static $folderid ;
    public static $campaignId = 15543122461;
    public static $name;

    public  function __construct()
    {
        self::$access_token = "P0gf7ZquflW4ue8ymZhONCc7ZjqarB77aGGFBhCcshGOT0BfnVcVk";
        self::$locationid =  1;
        self::$bestFolder =  "bestStory";
    }

    public function getFucntion($name)
    {
        self::$name = $name;
        try {
            $pCloudApp = new App();
            $pCloudApp->setAccessToken(self::$access_token);
            $pCloudApp->setLocationId(self::$locationid);
            $request = new PCloudRequest($pCloudApp);
            return $this->ParentFolder($request, $pCloudApp);
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    public function ParentFolder($mainfolder, $pCloudApp)
    {
        try {
        $array = $mainfolder->get("listfolder", ['folderid' => self::$campaignId]);
        foreach ($array as $element) {
            foreach ($element->contents as $conte) {
                if ($conte->name == self::$name) {
                    $folderId = $conte->folderid;
                }
            }
        }
        if (isset($folderId)){
            $listfolders = $mainfolder->get("listfolder", ['folderid' => $folderId]);
            if ($listfolders) {
                return  self::bestStory($listfolders, $pCloudApp);
            }
        }else{
            return [];
        }
    } catch (\Exception $e) {
        echo $e->getMessage();
    }
    }

    public static function bestStory($listfolders, $pCloudApp)
    {
        $request = new PCloudRequest($pCloudApp);
        foreach ($listfolders as $folders) {
            foreach ($folders->contents as $folder) {
                if ($folder->name == "bestStory") {
                    self::$folderid = $folder->folderid;
                }
            }
        }
        $folderContent  = $request->get("listfolder", ['folderid' => self::$folderid]);
        return self::ChildFolder($folderContent);
    }

    public static function ChildFolder($folderId)
    {
        $photos = array();
        collect($folderId)->each(function ($ele, $index) use (&$photos) {
            collect($ele->contents)->each(function ($el, $index) use (&$photos) {
                if ($el) {
                    array_push($photos, $el->fileid);
                } else {
                    return false;
                }
            });
        });
        $pCloudApp = new App();
        $pCloudApp->setAccessToken(self::$access_token);
        $pCloudApp->setLocationId(self::$locationid);
        $request = new PCloudRequest($pCloudApp);
        return self::getUrlFile($photos, $request);
    }

    public static function getUrlFile($photos, $request)
    {
        $files = array();
        foreach ($photos as $photo) {
            $protocol = 'https://';
            $fileMetadata = $request->get("getfilelink", ['fileid' => $photo]);
            $host = $fileMetadata->hosts[0];
            $domain = $protocol . $host;
            $file_path = $fileMetadata->path;
            $base_url = $domain . $file_path;
            array_push($files, $base_url);
        }

        return $files;
    }

    // public function downloadFile($pCloudApp)
    // {

    //     $pcloudFile = new File($pCloudApp);
    //     return   $fileMetadata = $pcloudFile->download(45801753050, "Abdullah/files");
    // }
}
