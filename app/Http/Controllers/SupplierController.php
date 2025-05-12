<?php
namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::all();
        return response()->json($suppliers);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'contact_email' => 'required|email',
        ]);
        $supplier = Supplier::create($validated);
        return response()->json($supplier, 201);
    }

    public function show($id)
    {
        $supplier = Supplier::find($id);
        if (!$supplier) {
            return response()->json(['error' => 'Supplier not found'], 404);
        }
        return response()->json($supplier);
    }

    public function update(Request $request, $id)
    {
        $supplier = Supplier::find($id);
        if (!$supplier) {
            return response()->json(['error' => 'Supplier not found'], 404);
        }
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'contact_email' => 'sometimes|required|email',
        ]);
        $supplier->update($validated);
        return response()->json($supplier);
    }

    public function destroy($id)
    {
        $supplier = Supplier::find($id);
        if (!$supplier) {
            return response()->json(['error' => 'Supplier not found'], 404);
        }
        $supplier->delete();
        return response()->json(['message' => 'Supplier deleted successfully']);
    }
}
