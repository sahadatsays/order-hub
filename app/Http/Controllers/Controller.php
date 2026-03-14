<?php

namespace App\Http\Controllers;

abstract class Controller
{
    protected function tenantId(): ?int
    {
        return auth()->user()?->tenant_id;
    }
}
