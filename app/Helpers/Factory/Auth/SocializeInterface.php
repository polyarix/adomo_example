<?php

namespace App\Helpers\Factory\Auth;

interface SocializeInterface
{
    public function getFirstName(): ?string;
    public function getLastName(): ?string;
    public function getEmail(): ?string;
    public function getScopes(): array;
}
