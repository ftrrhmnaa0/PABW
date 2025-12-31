<?php 
 
namespace App\Http\Controllers; 
 
use App\Models\Biodata; 
use Illuminate\Http\Request; 
use Inertia\Inertia; 
 
class BiodataController extends Controller
{ 
    public function index()
    { 
        $biodatas = Biodata::all(); // memanggil data dari Model 
        return Inertia::render('Biodata/Index', ['biodatas' => $biodatas]); 
    } 
 
    public function create()// nama fungsi create 
    { 
        return Inertia::render('Biodata/Create'); 
    } 
 
    public function store(Request $request)
    { 
        $request->validate([
            'nama' => 'required|string|max:255', 
            'tempat_lahir' => 'required|string|max:255', 
            'tanggal_lahir' => 'required|date', 
        ]); 
 
        Biodata::create($request->all()); 
        return redirect()->route('biodata.index');
    }

     public function edit($id)  
    { 
        $biodata = Biodata::findOrFail($id); 
        return Inertia::render('Biodata/Edit', ['biodata' => $biodata]); 
    } 
 
    public function update(Request $request, $id)  
    { 
        $biodata = Biodata::findOrFail($id); 
        $biodata->update($request->all());
        return redirect()->route('biodata.index'); 
    } 
 
    public function destroy($id)
    { 
        Biodata::destroy($id); 
        return redirect()->route('biodata.index');
    } 
}