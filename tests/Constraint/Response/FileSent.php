<?php

declare(strict_types=1);

namespace Tests\Constraint\Response;

use Psr\Http\Message\ResponseInterface;

/**
 * FileSent
 *
 * @internal
 */
class FileSent extends ResponseBase
{
    /**
     * @var \Cake\Http\Response
     */
    protected ResponseInterface $response;

    /**
     * Checks assertion
     *
     * @param mixed $other Expected type
     * @return bool
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ParameterTypeHint.MissingNativeTypeHint
     */
    public function matches($other): bool
    {
        return $this->response->getFile() !== null;
    }

    /**
     * Assertion message
     *
     * @return string
     */
    public function toString(): string
    {
        return 'file was sent';
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
