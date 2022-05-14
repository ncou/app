<?php

declare(strict_types=1);

namespace Tests\Constraint\Response;

use Psr\Http\Message\ResponseInterface;

/**
 * HeaderEquals
 *
 * @internal
 */
class HeaderEquals extends ResponseBase
{
    /**
     * @var string
     */
    protected string $headerName;

    /**
     * Constructor.
     *
     * @param \Psr\Http\Message\ResponseInterface $response A response instance.
     * @param string $headerName Header name
     */
    public function __construct(ResponseInterface $response, string $headerName)
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
        return $this->response->getHeaderLine($this->headerName) === $other;
    }

    /**
     * Assertion message
     *
     * @return string
     */
    public function toString(): string
    {
        $responseHeader = $this->response->getHeaderLine($this->headerName);

        return sprintf('equals content in header \'%s\' (`%s`)', $this->headerName, $responseHeader);
    }
}
