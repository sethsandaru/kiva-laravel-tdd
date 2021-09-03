<?php

namespace App\Services\Traits;

trait HasErrorMessage
{
    protected string $errorMessage;

    /**
     * Set error message and immediately return null
     *
     * @param string $errorMessage
     *
     * @return null
     */
    private function setErrorMessage(string $errorMessage)
    {
        $this->errorMessage = $errorMessage;
        return null;
    }

    /**
     * Get error message
     *
     * @return string
     */
    public function getErrorMessage(): string
    {
        return $this->errorMessage;
    }
}
