<?php

/**
 * The MIT License (MIT)
 * Copyright (c) 2013 Sérgio Peixoto
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of
 * this software and associated documentation files (the "Software"), to deal in
 * the Software without restriction, including without limitation the rights to
 * use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of
 * the Software, and to permit persons to whom the Software is furnished to do so,
 * subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS
 * FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR
 * COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER
 * IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN
 * CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */

namespace speixoto\amcharts;

use Yii;
use yii\web\View;
use yii\base\InvalidConfigException;
use yii\helpers\Html;

/**
 * AmChart Widget For Yii2
 *
 * @author Sérgio Peixoto <matematico2002@hotmail.com>
 *
 * @link https://github.com/speixoto/yii2-amcharts
 * @link http://www.amcharts.com/
 */

class Widget extends yii\base\Widget
{
    /**
     * @var array the HTML attributes for the breadcrumb container tag.
     */
    public $options = [];
    /**
     * @var string the width of the chart
     */
    public $width = '640px';
    /**
     * @var string the height of the chart
     */
    public $height = '400px';
    /**
     * @var array the AmChart configuration array
     * @see http://docs.amcharts.com/3/javascriptcharts
     */
    public $chartConfiguration = [];

    protected $_chartDivId;

    public function init()
    {
        if (!isset($this->options['id'])) {
            $this->options['id'] = 'chartdiv-' . $this->getId();
        }
        $this->chartDivId = $this->options['id'];
        AmChartAsset::register($this->getView());

        parent::init();
    }

    public function run()
    {
        $this->makeChart();
        $this->options['style'] = "width: {$this->width}; height: {$this->height};";
        echo Html::tag('div', '', $this->options);
    }

    protected function makeChart()
    {
        $chartConfiguration = json_encode($this->chartConfiguration);
        $js = "AmCharts.makeChart('{$this->chartDivId}', {$chartConfiguration});";
        $this->getView()->registerJs($js, View::POS_READY);
    }

    protected function setChartDivId($value)
    {
        $this->_chartDivId = $value;
    }

    protected function getChartDivId()
    {
        return $this->_chartDivId;
    }
}