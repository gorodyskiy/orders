<?php

namespace App\Helpers\Export;

class Csv extends ExportAbstract
{
    /**
     * @var string
     */
    protected $extention = '.csv';

    /**
     * @var string
     */
    protected $dataType = 'orders';

    /**
     * Csv export constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Prepare data for export.
     * 
     * @param ?Collection $data
     * @return self
     */
    public function prepareData($data): self
    {
        $this->data = $data;
        return $this;
    }

    /**
     * Export data to CSV.
     * 
     * @param ?array
     * @return string
     */
    public function export(): string
    {
        $file = $this->filename();
        $handle = fopen($file, 'w');
        fputcsv($handle, $this->head(), ';');
        foreach ($this->data as $row) {
            $row = is_array($row) ? $row : $row->toArray();
            fputcsv($handle, $row, ';');
        }
        fclose($handle);
        return env('APP_URL') . str_replace(public_path(), '', $file);
    }
}
