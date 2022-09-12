<?php

class UploadHandler
{
    private $allowedType;
    private $maxSize;
    private $destinationPath;

    public function __construct()
    {
        $this->maxSize = 5 * 1000000; //5 MB
        $this->allowedType = [
            "video/mp4" => "mp4",
            "video/x-matroska" => "mkv",
            "text/plain" => "txt",
            "application/pdf" => "pdf",
            "application/vnd.ms-powerpoint" => "ppt",
            "application/vnd.openxmlformats-officedocument.presentationml.presentation" => "pptx",
            "application/msword" => "doc",
            "application/vnd.openxmlformats-officedocument.wordprocessingml.document" => "docx"
        ];
        $this->setDefaultDestinationPath();
    }

    public function getMaxSize()
    { //bytes
        return $this->maxSize;
    }

    public function getDestinationPath()
    {
        return $this->destinationPath;
    }

    public function setDefaultDestinationPath()
    {
        // uploads/materi
        $this->destinationPath = "/uploads/materi";
    }

    public function setDestinationPath($path)
    {
        $this->destinationPath = $path;
    }

    public function isValidType($mime)
    {
        return array_key_exists($mime, $this->allowedType);
    }

    public function isValidSize($size)
    {
        return $size < $this->maxSize;
    }

    public function appendFileNameWithDate($file_name)
    {
        $tz = 'Asia/Jakarta';
        $timestamp = time();
        $dt = new DateTime("now", new DateTimeZone($tz));
        $dt->setTimestamp($timestamp);
        $time = $dt->format('Ymd-His');

        $segment = explode(".", $file_name);
        $arr_count = count($segment);

        if ($arr_count === 1)
            return $file_name . "_" . $time;

        $ext = array_pop($segment);
        $segment[$arr_count - 2] .= "_" . $time;
        $segment[] = $ext;

        return implode(".", $segment);
        // output:
        // abc.pdf - abc_time.pdf
        // a.b.c.pdf - a.b.c_time.pdf
        // abc - abc_time
    }
}
