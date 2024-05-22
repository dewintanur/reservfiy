<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function show()
    {
        return view('profile.show', [
            'user' => auth()->user()
        ]);
    }
    public function update(Request $request, User $user)
{
    $request->validate([
        'username' => 'sometimes|string|max:255',
        'email' => 'sometimes|string|email|max:255',
        'address' => 'sometimes|string|max:255',
        'photo' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    try {
        if ($request->hasFile('photo')) {
            // Hapus foto lama jika ada
            if ($user->photo) {
                Storage::delete('public/profil/'.$user->photo);
            }
            // Simpan foto baru
            $filename = time().'.'.$request->photo->extension();
            $request->photo->storeAs('public/profil', $filename);
            $user->photo = $filename;
        }

        // Update user data
        $userData = [
            'name' => $request->username ?? $user->name,
            'email' => $request->email ?? $user->email,
            'alamat' => $request->address ?? $user->alamat,
            'photo' => $user->photo ?? null,
        ];

        // Jika password diinput, enkripsi dan tambahkan ke data pengguna yang akan diperbarui
        if ($request->filled('password')) {
            $userData['password'] = bcrypt($request->password);
        }

        // Update user
        $user->update($userData);

        return redirect()->route('profile.show')->with('success', 'Profile updated successfully.');
    } catch (\Exception $e) {
        // Tangkap kesalahan dan tampilkan pesan
        return back()->withInput()->withErrors(['error' => $e->getMessage()]);
    }
}

}
