<?php

namespace App\Http\Controllers;

use App\Models\Offday;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OffdayController extends Controller
{
    public function index()
    {
        $offdays = Offday::all();
        return view('admin.offdays.index', compact('offdays'));
    }

    public function create()
    {
        return view('offday.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'reason' => 'required|string|max:255',
            'document' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
        ]);

        $documentPath = $request->file('document') ? $request->file('document')->store('documents') : null;

        Offday::create([
            'user_id' => Auth::id(),
            'reason' => $request->reason,
            'document' => $documentPath,
            'status' => 'pending',
        ]);

        return redirect()->route('offday.index')->with('success', 'İzin talebiniz oluşturuldu.');
    }

    public function show($id)
    {
        $offday = Offday::findOrFail($id);
        return view('offdays.show', compact('offday'));
    }

    public function approve($id)
    {
        $offday = Offday::findOrFail($id);
        $offday->update(['status' => 'approved']);

        return redirect()->route('offdays.index')->with('success', 'İzin talebi onaylandı.');
    }

    public function reject($id)
    {
        $offday = Offday::findOrFail($id);
        $offday->update(['status' => 'rejected']);

        return redirect()->route('offdays.index')->with('success', 'İzin talebi reddedildi.');
    }



    public function index1()
    {
        $offdays = Offday::where('user_id', Auth::id())->get();
        return view('offday.index', compact('offdays'));
    }


}
