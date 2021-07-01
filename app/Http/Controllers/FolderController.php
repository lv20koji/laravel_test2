<?php

namespace App\Http\Controllers;

use App\Models\Folder;
use Illuminate\Http\Request;
use App\Http\Requests\CreateFolder;
use App\Http\Requests\EditFolder;
use App\Models\Task;
// ★ Authクラスをインポートする
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class FolderController extends Controller
{
    public function showCreateForm(){
        return view('folders/create');
    }

    public function create(CreateFolder $request)
    {
        // フォルダモデルのインスタンスを作成する
        $folder = new Folder();
        // タイトルに入力値を代入する
        $folder->title = $request->title;

        // ★ ユーザーに紐づけて保存
        Auth::user()->folders()->save($folder);

        // インスタンスの状態をデータベースに書き込む
        $folder->save();

        //追加したフォルダの表示画面に戻る。
        return redirect()->route('tasks.index', [
            'folder' => $folder->id,
        ]);
    }

    public function delete(Folder $folder){
        $deleteid = $folder->id;

        //タスクの存在チェック
        $taskCount = Task::where('folder_id', $deleteid)->count();
        if ($taskCount !== 0){
            $error = "フォルダの中にタスクが存在します";
            return redirect()->route('tasks.index', [
                'folder' => $folder->id,
            ])
            ->withErrors($error);
        };

        Folder::destroy($deleteid);
        return redirect()->route('home');
    }

    /**
     * フォルダー編集フォーム
     * @param Folder $folder
     * @return \Illuminate\View\View
     */
    public function showEditForm(Folder $folder)
    {
        Log::info ("エディットフォーム");

        return view('folders.edit', [
            'folder' => $folder,
        ]);
    }

    /**
     * フォルダー編集
     * @param Folder $folder
     * @param EditFolder $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function edit(Folder $folder, EditFolder $request)
    {

        Log::debug("フォルダーエディット");

        $folder->title = $request->title;
        $folder->save();

        return redirect()->route('tasks.index', [
            'folder' => $folder->id,
        ]);
    }

}
