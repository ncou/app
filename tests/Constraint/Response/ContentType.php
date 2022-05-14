<?php

declare(strict_types=1);

namespace Tests\Constraint\Response;

use Psr\Http\Message\ResponseInterface;

/**
 * ContentType
 *
 * @internal
 */
class ContentType extends ResponseBase
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
     */
    public function matches($other): bool
    {
        return $other === $this->getType();
    }

    /**
     * Assertion message
     *
     * @return string
     */
    public function toString(): string
    {
        return 'is set as the Content-Type (`' . $this->getType() . '`)';
    }

    /**
     * Returns the current content type.
     *
     * @return string
     */
    private function getType(): string
    {
        $header = $this->response->getHeaderLine('Content-Type');
        if (strpos($header, ';') !== false) {
            return explode(';', $header)[0];
        }

        return $header;
    }
}
