<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Loan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LoanController extends Controller
{
    public function index()
    {
        $items = Item::with('category')->get(); 
        $myLoans = Loan::with('item')->where('user_id', Auth::id())->get(); 
        
        return view('dashboard', compact('items', 'myLoans'));
    }

    public function store(Request $request)
    {
        $request->validate(['item_id' => 'required|exists:items,id']);

        try {
            DB::transaction(function () use ($request) {
                $item = Item::lockForUpdate()->find($request->item_id);

                if ($item->stock <= 0) {
                    throw new \Exception('Stok barang habis!');
                }

                $item->decrement('stock');

                Loan::create([
                    'user_id' => Auth::id(), 
                    'item_id' => $item->id,
                    'borrow_date' => now(),
                    'status' => 'borrowed',
                ]);
            });

            return back()->with('success', 'Peminjaman berhasil.');

        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function returnItem($loanId)
    {
        try {
            DB::transaction(function () use ($loanId) {
                $loan = Loan::where('id', $loanId)
                            ->where('user_id', Auth::id())
                            ->where('status', 'borrowed')
                            ->firstOrFail();

                $loan->update([
                    'status' => 'returned',
                    'return_date' => now(),
                ]);

                $item = Item::lockForUpdate()->find($loan->item_id);
                $item->increment('stock');
            });

            return back()->with('success', 'Barang berhasil dikembalikan.');

        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengembalikan barang.');
        }
    }
}