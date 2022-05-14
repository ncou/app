<?php

declare(strict_types=1);

namespace Tests\Constraint\Response;

use Psr\Http\Message\ResponseInterface;

/**
 * BodyContains
 *
 * @internal
 */
class BodyContains extends ResponseBase
{
    /**
     * @var bool
     */
    protected bool $ignoreCase;

    /**
     * Constructor.
     *
     * @param \Psr\Http\Message\ResponseInterface $response A response instance.
     * @param bool $ignoreCase Ignore case
     */
    public function __construct(ResponseInterface $response, bool $ignoreCase = false)
    {
        parent::__construct($response);

        $this->ignoreCase = $ignoreCase;
    }

    /**
     * Checks assertion
     *
     * @param mixed $other Expected type
     * @return bool
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ParameterTypeHint.MissingNativeTypeHint
     */
    public function matches($other): bool
    {
        $method = 'mb_strpos';
        if ($this->ignoreCase) {
            $method = 'mb_stripos';
        }

        return $method($this->_getBodyAsString(), $other) !== false;
    }

    /**
     * Assertion message
     *
     * @return string
     */
    public function toString(): string
    {
        return 'is in response body';
    }
}
