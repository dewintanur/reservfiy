<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cafe;
use App\Models\Table;

class AdminTableController extends Controller
{
    public function index(Cafe $cafe)
    {
        $tables = Table::where('cafe_id', $cafe->id)->get();
        return view('admin.tables.index', compact('cafe', 'tables'));
    }

    public function store(Request $request, Cafe $cafe)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'table_number' => 'required|integer',
            'capacity' => 'required|integer',
            'status' => 'required|in:available,reserved',
        ]);
        

        // Create a new table instance and save it to the database
        $table = new Table();
        $table->cafe_id = $cafe->id;
        $table->table_number = $validatedData['table_number'];
        $table->capacity = $validatedData['capacity'];
        $table->status = $validatedData['status'];
        $table->save();

        // Redirect back to the table index page with a success message
        return redirect()->route('admin.tables.index', $cafe->id)->with('success', 'Table added successfully');
    }
}
