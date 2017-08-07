<?php

namespace App\Zhenggg\Widgets\Chart;

use Illuminate\Support\Arr;

class Line extends Chart
{
    protected $colorNames = [
        'aqua'    => [0, 255, 255],
        'black'   => [0, 0, 0],
        'blue'    => [0, 0, 255],
        'fuchsia' => [255, 0, 255],
        'gray'    => [128, 128, 128],
        'green'   => [0, 128, 0],
        'lime'    => [0, 255, 0],
        'maroon'  => [128, 0, 0],
        'navy'    => [0, 0, 128],
        'olive'   => [128, 128, 0],
        'purple'  => [128, 0, 128],
        'red'     => [255, 0, 0],
        'silver'  => [192, 192, 192],
        'teal'    => [0, 128, 128],
        'white'   => [255, 255, 255],
        'yellow'  => [255, 255, 0],
    ];

    protected $options = [
        'responsive' => true,
        'maintainAspectRatio' => false,
    ];

    protected $labels = [];

    public function __construct($labels = [], $data = [])
    {
        $this->data['labels'] = $labels;

        $this->data['datasets'] = [];

        $this->add($data);
    }

    public function add($label, $data = [], $fillColor = 'rgba(75,192,192,1)')
    {
        if (is_array($label)) {
            if (Arr::isAssoc($label)) {
                $this->data[] = $label;
            } else {
                foreach ($label as $item) {
                    call_user_func_array([$this, 'add'], $item);
                }
            }

            return $this;
        }

        $this->data['datasets'][] = [
            'label'         => $label,
            'fill'         => false,
            'fillColor'     => $fillColor,
            'data'          => $data,

        ];

        return $this;
    }

    public function script()
    {
        $data = json_encode($this->data);
        $options = json_encode($this->options);
        return <<<EOT


    var canvas = $("#{$this->elementId}").get(0).getContext("2d");
    var chart = new Chart(canvas).Line($data, $options);


EOT;
    }
}
