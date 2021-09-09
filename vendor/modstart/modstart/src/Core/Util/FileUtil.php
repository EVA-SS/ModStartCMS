<?php

namespace ModStart\Core\Util;

use ModStart\Core\Exception\BizException;

class FileUtil
{
    public static function mime($type)
    {
        static $mimeMap = [
            'png' => 'image/png',
            'gif' => 'image/gif',
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
        ];
        $type = strtolower($type);
        return isset($mimeMap[$type]) ? $mimeMap[$type] : null;
    }

    public static function extension($pathname)
    {
        $ext = strtolower(pathinfo($pathname, PATHINFO_EXTENSION));
        $i = strpos($ext, '?');
        if (false !== $i) {
            return substr($ext, 0, $i);
        }
        return $ext;
    }

    public static function arrayToCSVString($list)
    {
        $lines = [];
        foreach ($list as $item) {
            $line = [];
            foreach ($item as $v) {
                $line[] = '"' . str_replace('"', '""', $v) . '",';
            }
            $lines[] = join("", $line);
        }
        return chr(239) . chr(187) . chr(191) . join("\r\n", $lines);
    }

    public static function listAllFiles($dir, $filter = null, &$results = array(), $prefix = '')
    {
        $files = self::listFiles($dir, '*|.*');
        foreach ($files as $file) {
            if (null !== $filter && !call_user_func($filter, $file)) {
                continue;
            }
            if ($file['isDir']) {
                self::listAllFiles($file['path'] . '/' . $file['filename'], $filter, $results, $prefix ? $prefix . DIRECTORY_SEPARATOR . $file['filename'] : $file['filename']);
            }
            $file['filename'] = $prefix ? $prefix . DIRECTORY_SEPARATOR . $file['filename'] : $file['filename'];
            $results[] = $file;
        }
        return $results;
    }

    public static function listFiles($filename, $pattern = '*')
    {
        if (strpos($pattern, '|') !== false) {
            $patterns = explode('|', $pattern);
        } else {
            $patterns [0] = $pattern;
        }
        $i = 0;
        $dir = array();
        if (is_dir($filename)) {
            $filename = rtrim($filename, '/') . '/';
        }
        foreach ($patterns as $pattern) {
            $list = glob($filename . $pattern);
            if ($list !== false) {
                foreach ($list as $file) {
                    $f = basename($file);
                    if ($f === '..' || $f === '.') {
                        continue;
                    }
                    $dir [$i] ['filename'] = $f;
                    $dir [$i] ['path'] = dirname($file);
                    $dir [$i] ['pathname'] = realpath($file);
                    $dir [$i] ['owner'] = fileowner($file);
                    $dir [$i] ['perms'] = substr(base_convert(fileperms($file), 10, 8), -4);
                    $dir [$i] ['atime'] = fileatime($file);
                    $dir [$i] ['ctime'] = filectime($file);
                    $dir [$i] ['mtime'] = filemtime($file);
                    $dir [$i] ['size'] = filesize($file);
                    $dir [$i] ['type'] = filetype($file);
                    $dir [$i] ['ext'] = is_file($file) ? strtolower(substr(strrchr(basename($file), '.'), 1)) : '';
                    $dir [$i] ['isDir'] = is_dir($file);
                    $dir [$i] ['isFile'] = is_file($file);
                    $dir [$i] ['isLink'] = is_link($file);
                    $dir [$i] ['isReadable'] = is_readable($file);
                    $dir [$i] ['isWritable'] = is_writable($file);
                    $i++;
                }
            }
        }
        usort($dir, function ($a, $b) {
            if (($a["isDir"] && $b["isDir"]) || (!$a["isDir"] && !$b["isDir"])) {
                return $a["filename"] > $b["filename"] ? 1 : -1;
            } else {
                if ($a["isDir"]) {
                    return -1;
                } else if ($b["isDir"]) {
                    return 1;
                }
                if ($a["filename"] == $b["filename"]) return 0;
                return $a["filename"] > $b["filename"] ? -1 : 1;
            }
        });
        return $dir;
    }

    public static function name($pathname)
    {
        return strtolower(pathinfo($pathname, PATHINFO_BASENAME));
    }

    public static function formatByte($bytes, $decimals = 2)
    {
        $size = sprintf("%u", $bytes);
        if ($size == 0) {
            return ("0 Bytes");
        }
        $units = array(" Bytes", " KB", " MB", " GB", " TB", " PB", " EB", " ZB", " YB");
        return round($size / pow(1024, ($i = floor(log($size, 1024)))), $decimals) . $units[$i];
    }

    public static function formattedSizeToBytes($size_str)
    {
        $size_str = strtolower($size_str);
        $unit = preg_replace('/[^a-z]/', '', $size_str);
        $value = floatval(preg_replace('/[^0-9.]/', '', $size_str));

        $units = array('b' => 0, 'kb' => 1, 'mb' => 2, 'gb' => 3, 'tb' => 4, 'k' => 1, 'm' => 2, 'g' => 3, 't' => 4);
        $exponent = isset($units[$unit]) ? $units[$unit] : 0;

        return ($value * pow(1024, $exponent));
    }

    public static function getAndEnsurePathnameFolder($pathname)
    {
        $base = dirname($pathname);
        if (!file_exists($base)) {
            @mkdir($base, 0755, true);
        }
        return trim($base, '/') . '/';
    }

    public static function getPathnameFilename($pathname, $extension = true)
    {
        $pathInfo = pathinfo($pathname);
        return ($extension ? $pathInfo['basename'] : $pathInfo['filename']);
    }

    public static function ensureFilepathDir($pathname)
    {
        $dir = dirname($pathname);
        if (!file_exists($dir)) {
            @mkdir($dir, 0755, true);
        }
    }

    public static function number2dir($id, $depth = 3)
    {
        $width = $depth * 3;
        $idFormated = sprintf('%0' . $width . 'd', $id);
        $dirs = [];
        for ($i = 0; $i < $depth; $i++) {
            $dirs[] = substr($idFormated, $i * 3, 3);
        }
        return join('/', $dirs);
    }

    
    public static function copy($src, $dst, $replaceExt = null, $callback = null, $filter = null)
    {
        if (!file_exists($src)) {
            return;
        }
        if (is_file($src)) {
            if (!$filter || call_user_func($filter, $src, $dst)) {
                if (file_exists($dst) && md5_file($src) == md5_file($dst)) {
                    return;
                }
                if (null !== $replaceExt && file_exists($dst)) {
                    @rename($dst, $dst . $replaceExt);
                }
                if (!file_exists($dir = dirname($dst))) {
                    @mkdir($dir, 0755, true);
                }
                                if ($callback) {
                    call_user_func($callback, $src, $dst);
                }
                copy($src, $dst);
            }
            return;
        } else {
            if (!$filter || call_user_func($filter, $src, $dst)) {
            } else {
                return;
            }
        }
        $src = rtrim($src, '/') . '/';
        $dst = rtrim($dst, '/') . '/';
        $dir = opendir($src);
        @mkdir($dst, 0755, true);
        while (false !== ($file = readdir($dir))) {
            if (($file != '.') && ($file != '..')) {
                if (is_dir($src . $file)) {
                    self::copy($src . $file . '/', $dst . $file . '/', $replaceExt, $callback, $filter);
                } else {
                    if (!$filter || call_user_func($filter, $src . $file, $dst . $file)) {
                        if (file_exists($dst . $file) && md5_file($dst . $file) == md5_file($src . $file)) {
                            continue;
                        }
                        if (null !== $replaceExt && file_exists($dst . $file)) {
                            @rename($dst . $file, $dst . $file . $replaceExt);
                        }
                                                if ($callback) {
                            call_user_func($callback, $src . $file, $dst . $file);
                        }
                        copy($src . $file, $dst . $file);
                    }
                }
            }
        }
        closedir($dir);
    }

    
    public static function rm($dir, $removeSelf = true)
    {
        if (is_dir($dir)) {
            $dh = opendir($dir);
            while (($file = readdir($dh)) !== false) {
                if ($file != "." && $file != "..") {
                    $fullPath = rtrim($dir, '/') . '/' . $file;
                    if (is_dir($fullPath)) {
                        self::rm($fullPath, true);
                    } else {
                        @unlink($fullPath);
                    }
                }
            }
            closedir($dh);
            if ($removeSelf) {
                @rmdir($dir);
            }
        } else {
            @unlink($dir);
        }
        return true;
    }

    public static function safeCleanLocalTemp($path)
    {
        if (empty($path)) {
            return;
        }
        $tempPath = public_path('temp');
        if (starts_with($path, $tempPath)) {
            @unlink($path);
        }
    }

    public static function savePathToLocalTemp($path, $ext = '')
    {
        $tempPath = public_path('temp/' . md5($path) . (starts_with($ext, '.') ? $ext : '.' . $ext));
        if (file_exists($tempPath)) {
            return $tempPath;
        }
        if (StrUtil::startWith($path, 'http://') || StrUtil::startWith($path, 'https://') || StrUtil::startWith($path, '//')) {
            if (StrUtil::startWith($path, '//')) {
                $path = 'http://' . $path;
            }
            $image = CurlUtil::getRaw($path);
            if (empty($image)) {
                return null;
            }
            @mkdir(public_path('temp'));
            file_put_contents($tempPath, $image);
        } else {
            if (StrUtil::startWith($path, '/')) {
                $path = substr($path, 1);
            }
            $tempPath = public_path($path);
        }
        if (!file_exists($tempPath)) {
            return null;
        }
        return $tempPath;
    }

    public static function generateLocalTempPath($ext = 'tmp')
    {
        if (!file_exists(public_path('temp'))) {
            @mkdir(public_path('temp'));
        }
        for ($i = 0; $i < 10; $i++) {
            $tempPath = public_path('temp/' . RandomUtil::lowerString(32) . '.' . $ext);
            if (!file_exists($tempPath)) {
                return $tempPath;
            }
        }
        BizException::throws('FileUtil generateLocalTempPath error');
    }

}
