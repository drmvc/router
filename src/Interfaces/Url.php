<?php namespace DrMVC\Interfaces;

interface Url
{
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