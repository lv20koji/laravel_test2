<?php

namespace App\Policies;

use App\Models\Folder;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class FolderPolicy
{
    /**
     * フォルダの閲覧権限
     * @param User $user
     * @param Folder $folder
     * @return bool
     */
    public function view(User $user, Folder $folder)
    {
        // $folderUser = $folder->user_id;
        // $folderUser = $folder->id;

        // Log::info ("folderUser :" .$folderUser);
        // Log::info ($folderUser === 5);
        Log::info ($user->id);

        // Log::info ($user);
        Log::info ($folder->user_id);
        // Log::info ($folder->title);
        // Log::info ($folder->title === "テスト");

        // $logtest = 5;
        // Log::info ($logtest === 5);


        // return $user->id === $folder_userid;
        return $user->id == $folder->user_id;
    }
}
