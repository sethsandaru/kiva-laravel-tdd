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
    public function setErrorMessage(string $errorMessage)
    {
        $this->errorMessage = $errorMessage;
        return null;
    }
}
