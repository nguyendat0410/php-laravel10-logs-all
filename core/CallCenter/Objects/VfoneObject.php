<?php

namespace Core\CallCenter\Objects;

use Core\Entity;
use Exception;

class VfoneObject
{
    use Entity;

    private string $calldate;

    private string $caller;

    private string $callid;

    private string $callee;

    private string $did;

    private int $duration;

    private string $billsec;

    private string $recordingfile;

    private string $disposition;

    /**
     * @throws Exception
     */
    function __construct(array $inputData = [])
    {
        if (!empty($inputData)) {
            $this->populate($inputData);
        }
    }

    /**
     * @return string
     */
    public function getCalldate(): string
    {
        return $this->calldate;
    }

    /**
     * @return string
     */
    public function getCaller(): string
    {
        return $this->caller;
    }

    /**
     * @return string
     */
    public function getCallid(): string
    {
        return $this->callid;
    }

    /**
     * @return string
     */
    public function getCallee(): string
    {
        return $this->callee;
    }

    /**
     * @return int
     */
    public function getDuration(): int
    {
        return $this->duration;
    }

    /**
     * @return string
     */
    public function getBillsec(): string
    {
        return $this->billsec;
    }

    /**
     * @return string
     */
    public function getRecordingfile(): string
    {
        return $this->recordingfile;
    }

    /**
     * @return string
     */
    public function getDisposition(): string
    {
        return $this->disposition;
    }

    /**
     * @return string
     */
    public function getDid(): string
    {
        return $this->did;
    }

}
