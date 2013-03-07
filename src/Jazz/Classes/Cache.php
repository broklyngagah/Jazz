<?php

namespace Jazz\Classes;

/**
 * Description of Cache
 *
 * @author broklyn
 */
class Cache {
    
    private $dir;
    private $maxAge;
    
    public function __construct($cacheDir="") {
        if ("" === $cacheDir) {
            $this->dir = JAZZ_PROJECT_ROOT_DIR . '/app/cache/files';
        } else {
            $this->dir = $cacheDir;
        }
        
        if (!is_writable($this->dir)) {
            throw new Exception("cache folder isn\'t writable. Please fix this");
            //echo "<p>cache folder isn't writable. Please fix this.</p>";
            die();
        }
    }
    
    public function set($key, $data)
    {

        $filename = $this->getFilename($key);

        if (is_array($data) || is_object($data)) {
            $data = serialize($data);
        }

        file_put_contents($filename, $data);

    }
    
    public function get($key, $maxage = false)
    {

        $filename = $this->getFilename($key);

        // No file, we can stop..
        if (!file_exists($filename)) {
            return false;
        }

        $age = date("U") - filectime($filename);

        if (empty($maxage)) {
            $maxage = $this->maxage;
        }

        if ($age < $maxage) {
            $data = file_get_contents($filename);

            $unserdata = @unserialize($data);

            if ($unserdata !== false || $data === 'b:0;') {
                return $unserdata;
            } else {
                return $data;
            }

        } else {
            return false;
        }

    }
    
    public function isvalid($key, $maxage)
    {

        $filename = $this->getFilename($key);

        // No file, we can stop..
        if (!file_exists($filename)) {
            return false;
        }

        $age = date("U") - filectime($filename);

        if (empty($maxage)) {
            $maxage = $this->maxage;
        }

        return ($age < $maxage);

    }

    public function clear($key)
    {
        // @todo clear a certain cached value.
    }
    
    public function clearCache()
    {
        $result = array(
            'successfiles' => 0,
            'failedfiles' => 0,
            'failed' => array(),
            'successfolders' => 0,
            'failedfolders' => 0,
            'log' => ''
        );

        $this->clearCacheHelper('', $result);

        return $result;

    }
    
    private function clearCacheHelper($additional, &$result)
    {

        $currentfolder = realpath($this->dir."/".$additional);

        if (!file_exists($currentfolder)) {
            $result['log'] .= "Folder $currentfolder doesn't exist.<br>";

            return;
        }

        $d = dir($currentfolder);

        while (false !== ($entry = $d->read())) {

            if ($entry == "." || $entry == ".." || $entry == "index.html" || $entry == '.gitignore') {
                continue;
            }

            if (is_file($currentfolder."/".$entry)) {
                if (is_writable($currentfolder."/".$entry) && unlink($currentfolder."/".$entry)) {
                    $result['successfiles']++;
                } else {
                    $result['failedfiles']++;
                    $result['failed'][] = str_replace($this->dir, "cache", $currentfolder."/".$entry);
                }
            }

            if (is_dir($currentfolder."/".$entry)) {

                $this->clearCacheHelper($additional."/".$entry, $result);

                if (@rmdir($currentfolder."/".$entry)) {
                    $result['successfolders']++;
                } else {
                    $result['failedfolders']++;
                }

            }

        }

        $d->close();

    }

    private function getFilename($key)
    {
        return sprintf("%s/c_%s.cache", $this->dir, substr(md5($key), 0, 18));
    }
    
    
}

