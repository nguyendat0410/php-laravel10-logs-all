<?php

namespace Core\CallCenter\Objects;

use Core\Entity;
use Exception;

class CallObject
{
    use Entity;
    private string $id;

    private string $uuid;

    private string $call_id;

    private string $phone;

    private string $extension;

    private mixed $time;

    private int $duration;

    private string $status;

    private string $type;

    private string $recording_file;

    private mixed $json_attributes;

    private $created_at;

    private $updated_at;

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
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getCallId(): string
    {
        return $this->call_id;
    }

    /**
     * @return string
     */
    public function getPhone(): string
    {
        return $this->phone;
    }

    /**
     * @return string
     */
    public function getExtension(): string
    {
        return $this->extension;
    }

    /**
     * @return mixed
     */
    public function getTime(): mixed
    {
        return $this->time;
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
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getUuid(): string
    {
        return $this->uuid;
    }

    /**
     * @return string
     */
    public function getRecordingFile(): string
    {
        return $this->recording_file;
    }

    /**
     * @return mixed
     */
    public function getJsonAttributes(): mixed
    {
        return $this->json_attributes;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

}
