<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cafe;
use App\Models\Category;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class AdminCafeController extends Controller
{
    public function index()
    {
        $cafes = Cafe::all();
        return view('admin.cafes.index', compact('cafes'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.cafes.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'location' => 'sometimes|string',
            'maps_link' => 'nullable|string',
            'photo' => 'nullable|image',
            'menu' => 'nullable|file',
            'rating' => 'nullable|numeric',
            'social_media' => 'nullable|string',
            'day' => 'nullable|array',
            'day.*' => 'required_with:open_time.*,close_time.*|string',
            'open_time' => 'nullable|array',
            'open_time.*' => 'required_with:day.*,close_time.*|date_format:H:i',
            'close_time' => 'nullable|array',
            'close_time.*' => 'required_with:day.*,open_time.*|date_format:H:i',
            'packages.*.name' => 'required|string|max:255',
            'packages.*.price' => 'required|numeric|min:0',
            'packages.*.description' => 'nullable|string',
            'tables' => 'nullable|array',
            'tables.*.table_number' => 'required|integer|min:1',
            'tables.*.capacity' => 'required|integer|min:1',
            'tables.*.status' => 'required|in:available,reserved',
        ]);

        // Handle file uploads
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('photos', 'public');
        }
        if ($request->hasFile('menu')) {
            $data['menu'] = $request->file('menu')->store('menus', 'public');
        }

        // Combine day, open_time, and close_time into one JSON string
        if (isset($data['day'])) {
            $operationalHours = [];
            foreach ($data['day'] as $index => $day) {
                $operationalHours[] = [
                    'day' => $day,
                    'open' => $data['open_time'][$index] ?? null,
                    'close' => $data['close_time'][$index] ?? null
                ];
            }
            $data['operational_hours'] = json_encode($operationalHours);
        }

        $cafe = Cafe::create($data);
        $cafe->categories()->sync($request->categories);

        // Save packages
        if ($request->has('packages')) {
            foreach ($request->packages as $packageData) {
                $cafe->packages()->create($packageData);
            }
        }

        return redirect()->route('admin.cafes.index')->with('success', 'Cafe successfully added.');
    }

    public function edit(Cafe $cafe)
    {
        $categories = Category::all();
        return view('admin.cafes.edit', compact('cafe', 'categories'));
    }

    public function update(Request $request, Cafe $cafe)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'location' => 'required',
            'description' => 'required',
            'maps_link' => 'nullable|url',
            'social_media' => 'nullable|string',
            'rating' => 'nullable|numeric|min:0|max:5',
            'day' => 'nullable|array',
            'day.*' => 'string',
            'open_time' => 'nullable|array',
            'open_time.*' => 'date_format:H:i',
            'close_time' => 'nullable|array',
            'close_time.*' => 'date_format:H:i',
            'photo' => 'nullable|image|max:10240',
            'menu' => 'nullable|file|max:20480',
            'packages.*.name' => 'required|string|max:255',
            'packages.*.price' => 'required|numeric|min:0',
            'packages.*.description' => 'nullable|string',
        ]);

        $operationalHours = [];
        if (isset($validatedData['day'])) {
            foreach ($validatedData['day'] as $index => $day) {
                if (!empty($day)) {
                    $operationalHours[] = [
                        'day' => $day,
                        'open' => $validatedData['open_time'][$index],
                        'close' => $validatedData['close_time'][$index],
                    ];
                }
            }
        }

        $cafe->operational_hours = json_encode($operationalHours);
        $cafe->name = $validatedData['name'];
        $cafe->location = $validatedData['location'];
        $cafe->description = $validatedData['description'];
        $cafe->maps_link = $validatedData['maps_link'];
        $cafe->social_media = $validatedData['social_media'];
        $cafe->rating = $validatedData['rating'];

        if ($request->hasFile('photo')) {
            if ($cafe->photo) {
                Storage::delete('public/' . $cafe->photo);
            }
            $cafe->photo = $request->file('photo')->store('photos', 'public');
        }

        if ($request->hasFile('menu')) {
            if ($cafe->menu) {
                Storage::delete('public/' . $cafe->menu);
            }
            $cafe->menu = $request->file('menu')->store('menus', 'public');
        }
        $cafe->save();

        // Update packages
        if ($request->has('packages')) {
            $cafe->packages()->delete(); // Delete existing packages
            foreach ($request->packages as $packageData) {
                $cafe->packages()->create($packageData); // Create new packages
            }
        }

        return redirect()->route('admin.cafes.index')->with('success', 'Cafe successfully updated.');
    }

    public function destroy(Cafe $cafe)
    {
        $cafe->delete();
        return redirect()->route('admin.cafes.index')->with('success', 'Cafe deleted successfully.');
    }
}
