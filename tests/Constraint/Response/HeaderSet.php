<?php

declare(strict_types=1);

namespace Tests\Constraint\Response;

use Psr\Http\Message\ResponseInterface;

/**
 * HeaderSet
 *
 * @internal
 */
class HeaderSet extends ResponseBase
{
    /**
     * @var string
     */
    protected string $headerName;

    /**
     * Constructor.
     *
     * @param \Psr\Http\Message\ResponseInterface|null $response A response instance.
     * @param string $headerName Header name
     */
    public function __construct(?ResponseInterface $response, string $headerName)
    {
        parent::__construct($response);

        $this->headerName = $headerName;
    }

    /**
     * Checks assertion
     *
     * @param mixed $other Expected content
     * @return bool
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ParameterTypeHint.MissingNativeTypeHint
     */
    public function matches($other): bool
    {
        return $this->response->hasHeader($this->headerName);
    }

    /**
     * Assertion message
     *
     * @return string
     */
    public function toString(): string
    {
        return sprintf('response has header \'%s\'', $this->headerName);
    }

    /**
     * Overwrites the descriptions so we can remove the automatic "expected" message
     *
     * @param mixed $other Value
     * @return string
     */
    protected function failureDescription(mixed $other): string
    {
        return $this->toString();
    }
}
