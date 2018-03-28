<?php

namespace DrMVC\Router\Interfaces;

interface Url
{
    /**
     * Detect current URI automatically
     *
     * @return  Url
     */
    public function autodetect(): Url;

    /**
     * Return only URI or URL
     *
     * @return  string
     */
    public function getUri(): string;

    /**
     * Get current URL
     *
     * @return  string
     */
    public function getUrl(): string;

    /**
     * Set url into the variable
     *
     * @param   string $url
     * @return  Url
     */
    public function setUrl(string $url): Url;
}