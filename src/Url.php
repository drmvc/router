<?php namespace DrMVC;

class Url implements Interfaces\Url
{
    /**
     * Current URL
     * @var string
     */
    private $_url;

    /**
     * Url constructor.
     * @param   string|null $url
     */
    public function __construct(string $url = null)
    {
        if (null !== $url) {
            $this->setUrl($url);
        }
    }

    /**
     * Return only URI or URL
     *
     * @return  string
     */
    public function getUri(): string
    {
        return parse_url($this->getUrl())['path'];
    }

    /**
     * Get current URL
     *
     * @return  string
     */
    public function getUrl(): string
    {
        return $this->_url;
    }

    /**
     * Set url into the variable
     *
     * @param   string $url
     * @return  Interfaces\Url
     */
    public function setUrl(string $url): Interfaces\Url
    {
        $this->_url = $url;
        return $this;
    }

    // TODO: implement autodetect
}