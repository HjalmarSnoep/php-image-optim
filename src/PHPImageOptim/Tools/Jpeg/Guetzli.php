<?php

namespace PHPImageOptim\Tools\Jpeg;

use Exception;
use PHPImageOptim\Tools\Common;
use PHPImageOptim\Tools\ToolsInterface;

class Guetzli extends Common implements ToolsInterface
{
    /**
     * @var string
     */
    private $attributes = '';

    /**
     * Guetzli constructor.
     * @param array $options
     */
    public function __construct(array $options = ['quality' => 85])
    {
        $arguments = [];

        foreach ($options as $key => $value) {
            $arguments[] = sprintf('--%s %s', $key, $value);
        }

        $this->attributes = join(' ', $arguments);
    }

    /**
     * @return ToolsInterface
     * @throws Exception
     */
    public function optimise(): ToolsInterface
    {
        exec(
            sprintf(
                $this->binaryPath . ' %s %s %s',
                $this->attributes,
                escapeshellarg($this->imagePath),
                escapeshellarg($this->imagePath)
            ),
            $aOutput,
            $iResult
        );

        if ($iResult !== 0) {
            throw new Exception('Guetzli was unable to optimise image.');
        }
        return $this;
    }

    public function checkVersion()
    {
        exec($this->binaryPath . ' --version', $aOutput, $iResult);
    }
}
