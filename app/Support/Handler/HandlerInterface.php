<?php
namespace App\Support\Handler;

use Illuminate\Http\JsonResponse;
use App\Models\User;

interface HandlerInterface
{
    public function handle(mixed $data): JsonResponse;
}