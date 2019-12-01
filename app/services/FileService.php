<?php


class FileService {

    /**
     * Checks if uploaded file has duplicate name as some in database.
     * If yes, then '-duplicate' is appended at its end and returned.
     *
     * @return false|string Name of file, ahat was checked
     */
    public function checkFileDuplicate() {
        // get base file name
        $fileName = basename($_FILES["file"]["name"]);
        // manage encoding
        // note: when this was uncommented, filenames were broken after
//        $fileName = iconv("UTF-8", "WINDOWS-1250", $fileName);

        // append '-duplicate' until there is not file with same name
        while (file_exists(FILES.$fileName)) {
            // explode by dot to insert file-rename-string before extension
            $parts = explode(".", $fileName);
            // put them back together with the dot, except for last one
            $fileName = $parts[0];
            for ($i = 1; $i < count($parts)-1; $i++) {
                $fileName .= ".".$parts[$i];
            }
            // append distinguishing string and extension
            $fileName .= "-duplicate.pdf";
        }

        // return possibly changed file name
        return $fileName;
    }

    /**
     * Saves given file on server.
     *
     * @param $fileName
     * @return bool
     */
    public function receiveFile($fileName) {
        // return true if file was uploaded successfully, else false
        return move_uploaded_file($_FILES["file"]["tmp_name"], FILES.$fileName);
    }

    public function sendFile($fileName) {

    }
}