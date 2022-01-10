<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\TagService;
use Illuminate\Support\Facades\Auth;

class TagController
{
    public function __construct(
        private TagService $tagService
    )
    {
    }

    public function sharedTags()
    {
        /** @var User $user */
        $user = Auth::user();

        $sharedTags = $this->tagService->getUserSharedTags($user);

        return view('shared-tags', [
            'tags' => $sharedTags
        ]);
    }
}
