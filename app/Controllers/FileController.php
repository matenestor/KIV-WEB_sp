<?php


class FileController {

    private const DIR = "files/";

    public function receiveFile() {
        $fileName = basename($_FILES["file"]["name"]);
        $fileName = iconv("UTF-8", "WINDOWS-1250", $fileName);
        $path = self::DIR.$fileName;

        return move_uploaded_file($_FILES["file"]["tmp_name"], $path);
    }

    public function sendFile($fileName) {

    }
}