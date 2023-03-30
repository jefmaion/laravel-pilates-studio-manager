<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProfilePhotoRequest;
use App\Libraries\FileManager;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class UserProfileController extends Controller
{
    
    public function store(StoreProfilePhotoRequest $request, $idUser) {

        if(!$user = User::find($idUser)) {
            return redirect()->back()->with('error', 'Usuário não encontrado');
        }

        $profileFolder = Config::get('application.imgProfileFolder');

        FileManager::path($profileFolder);

        if(!$fileName = FileManager::saveImage($request->profile_image)) {
            return false;
        }

        if($user->image) {
            FileManager::destroy($user->image);
        }


        if(!$user->update(['image' => $fileName])) {
            return redirect()->back()->with('error', 'Erro ao Salvar');
        }

        return redirect()->back()->with('success', 'Foto adicionada com sucesso unico');
    }

}
