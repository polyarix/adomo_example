<?php

namespace App\Helpers\Factory\Payment\Handler;

use Illuminate\Http\Request;

abstract class AbstractPaymentHandler
{
    /**
     * @var Request
     */
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    abstract public function getDescription(): string;
    abstract public function getRedirectUrl(): string;
    abstract public function getType(): string;
    abstract public function getId(): int;
    abstract public function getAmount(): int;

    public function getMetaData(): array
    {
        return [];
    }
}
