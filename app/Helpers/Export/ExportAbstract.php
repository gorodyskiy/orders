<?php

namespace App\Helpers\Export;

abstract class ExportAbstract
{
    /**
     * List of available class methods.
     * 
     * @var array<string, string>.
     */
    private $aliases = [
        'prepare' => 'prepareData',
    ];

    /**
     * @var string
     */
    protected $extention;

    /**
     * @var string
     */
    protected $prefix;

    /**
     * @var Collection
     */
    protected $data;

    /**
     * ExportAbstract constructor.
     */
    public function __construct()
    {
        //
    }

    /**
     * Invoking inaccessible methods in an object context.
     * 
     * @param string $method
     * @param array $args
     * @return void
     */
    public function __call($method, $args)
    {
        $method = $this->aliases[$method];
        return $this->$method(...$args);
    }

    /**
     * Invoking inaccessible methods in a static context.
     * 
     * @param string $method
     * @param array $args
     * @return void
     */
    public static function __callStatic($method, $args)
    {
        $instance = (new static);
        $method = $instance->aliases[$method];
        return $instance->$method(...$args);
    }

    /**
     * Export data to CSV.
     * 
     * @return string
     */
    abstract public function export(): string;

    /**
     * Prepare data for export.
     * 
     * @param ?Collection $data
     * @return self
     */
    abstract public function prepareData($data): self;

    /**
     * Generate expoert filename.
     * 
     * @return string
     */
    protected function filename(): string
    {
        return public_path('export') .'/'.
            $this->dataType .'_'.
            date('YmdHis') .
            $this->extention;
    }

    /**
     * Get arrat keys for export file head.
     * 
     * @return array<int, string>
     */
    protected function head(): array
    {
        return array_keys(
            $this->data->first()->toArray()
        );
    }
}
