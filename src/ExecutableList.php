<?php

namespace Zvax\Stepping;

class ExecutableList implements \Iterator
{
    private $position;
    private $data;

    public function addStep(Step $step)
    {
        $this->data[] = $step;
    }

    public function __construct(array $steps = [])
    {
        $this->position = 0;
        $this->data = $steps;
    }

    public function current()
    {
        return $this->data[$this->position];
    }

    public function next()
    {
        ++$this->position;
    }

    public function rewind()
    {
        $this->position = 0;
    }

    public function valid()
    {
        return isset($this->data[$this->position]);
    }

    public function key()
    {
        return $this->position;
    }


}