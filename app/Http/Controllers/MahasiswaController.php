<?php

namespace App\Http\Controllers;

use App\Models\DataMahasiswa;
use Illuminate\Http\Request;

class MahasiswaController extends Controller
{
    //function Read
    public function readDataMahasiswa(Request $request)
    {
        if ($request->search) {
            $data = DataMahasiswa::where('data_mahasiswas', 'LIKE', "%$request->search%")
                ->paginate(10);
            return view('task.index', [
                'data' => $data
            ]);
        }
        $data = DataMahasiswa::all();
        return view(
            '',
            [
                'mahasiswaList' => $data
                    ->paginate(10)
            ]
        );
    }

    //create
    public function createDataMahasiswa(Request $request){
        $data = $request->all();

        try{
            $mahasiswa = new DataMahasiswa();
            $mahasiswa->nama = $data['nama'];
            $mahasiswa->nim = $data['nim'];
            $mahasiswa->fakultas = $data['fakultas'];
            $mahasiswa->jurusan = $data['jurusan'];

            $mahasiswa->save();
            $status = "success";
            return response()->json(compact('status', 'lecture'),200);
        }catch(\Throwable $th){

            $status = 'failed';
            return response()->json(compact('status', 'th'),401);
        }
    }


    //function update
    public function updateDataMahasiswa($id, Request $request)
    {
        $data = $request->all();
        try {
            $data = DataMahasiswa::findOrFail($id);
            $data->nama = $data['nama'];
            $data->nim = $data['nim'];
            $data->fakultas = $data['fakultas'];
            $data->jurusan = $data['jurusan'];


            $data->save();
            $status = 'succes';
            return response()->json(compact('status', 'lecture'), 200);
            // return redirect('')->with('status','Data created Successfully');
        } catch (\Throwable $th) {
            //throw $th
            $status = 'error';
            return response()->json(compact('status', 'th'), 401);
            // return redirect('')->with('status','Data created Successfully');
        }
    }

    //delete function
    public function deleteDataMahasiswa($id)
    {
        $data = DataMahasiswa::findOrFail($id);
        $data->delete();

        $status = "delete status";
        return redirect('')->with('status', 'Data deleted Successfully');
    }
}