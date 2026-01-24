<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Spatie\Backup\Events\BackupWasSuccessful;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\HeaderBag;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

class BackupController extends Controller
{
    public function index()
    {
        //$files = Storage::disk('local')->allFiles(env('APP_NAME'));
        //return $files;
        //return $this->showFiles();
       
        $data = $this->show_backups(); 
      
        return view('admin.backup.index', compact('data'));
    }

    public function create()
    {
        $result = Artisan::call('backup:run --only-db') ;
     
        if($result == 0){
            return Redirect::back()->with('success','Database backup was successful, .SQL file was saved in dump folder.');
        }else{
            return Redirect::back()->with('error','Error to back up database.');
        }
    }

    public function store(Request $request)
    {
      
        $result = \Artisan::call('backup:run --only-db') ;
     
        if($result == 0){
            return Redirect::back()->with('success','Database backup was successful, .SQL file was saved in dump folder.');
        }else{
            return Redirect::back()->with('error','Error to back up database.');
        }
   
    }

    public function showFiles() {
        $files_with_size = array();
        $files = Storage::disk('local')->files(env('APP_NAME'));
        foreach ($files as $key => $file) {
          $files_with_size[$key]['name'] = $file;
          $files_with_size[$key]['size'] = Storage::disk('local')->size($file);
        }
        dd($files_with_size);
    }

    public function show_backups()
    {
        $directory = env('APP_NAME');
        
        $allFiles = Storage::allFiles($directory);
        $files = array();
        foreach($allFiles as $file){
            $size = Storage::size($file)/1024;
            $file =[
                'name'=>$file,
                'size'=>round($size).'KB'
            ];
             
            $files[] = $file ;
        }
        return $files;
    }
 
}
