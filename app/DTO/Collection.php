<?php

namespace App\DTO;

use App\DTO\MeasureObject;

final class Collection
{
    /**
     * @var Measure[] The measures
     */
    private $list;

    /**
     * The constructor.
     * 
     * @param MeasureObject ...$measure The measure
     */
    public function __construct(MeasureObject ...$measure) 
    {
        $this->list = $measure;
    }

    function __destruct() {
      }    
    
    /**
     * Add measure to list.
     *
     * @param Measure $measure The measure
     *
     * @return void
     */
    public function add(MeasureObject $measure): void
    {
        $this->list[] = $measure;
    }

    /**
     * Get all measures.
     *
     * @return Measure[] The measures
     */
    public function all(): array
    {
        return $this->list;
    }
}