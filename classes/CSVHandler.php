<?php

namespace redirects\classes;

use redirects\classes\helpers\CSVReader;

class CSVHandler {
    private $file_path;

    public function __construct($file_path) {
        $this->file_path = $file_path;
    }

    public function getCSVContent() {
        $csv = new CSVReader($this->file_path);

        $csvContent = [];

        foreach ($csv as $key => $row) {
            if ($key === 0) {
                continue;
            }

            if (empty($row)) {
                continue;
            }

            $csvContent[] = $row;
        }

        return $csvContent;
    }
}