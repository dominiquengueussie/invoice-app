<?php

namespace App\Http\Controllers;

use App\Models\Counter;
use App\Models\Invoice;
use App\Models\Customer;
use App\Models\InvoiceItem;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function get_all_invoice()
    {
        $invoices = Invoice::with('customer')->orderBy('id', 'DESC')->get();
        return response()->json([
            'invoices' => $invoices
        ], 200);
    }

    public function search_invoice(Request $request)
    {

        $result_search = $request->get('s');

        if ($result_search != null) {
            $invoices = Invoice::with('customer')
                ->where('id', 'LIKE', "%$result_search%")->get();
            return response()->json([
                'invoices' => $invoices
            ], 200);
        } else {
            return $this->get_all_invoice();
        }
    }

    public function create_invoice(Request $request)
    {
        $counter = Counter::where('key', 'invoice')->first();
        $random = Counter::where('key', 'invoice')->first();

        $invoice = Invoice::orderBy('id', 'DESC')->first();

        if ($invoice) {
            $invoice = $invoice->id + 1;
            $counters = $counter->value + $invoice;
        } else {
            $counters = $counter->value;
        }

        $formData =
            [
                'number' => $counter->prefix . $counters,
                'customer_id' => null,
                'customer' => null,
                'date' => date('Y-m-d'),
                'date_echeance' => null,
                'reference' => null,
                'remise' => 0,
                'term_and_conditions' => 'Default terms and conditions',
                'items' => [
                    'product_id' => null,
                    'product' => null,
                    'unit_price' => 0,
                    'quantity' => 1,
                ]
            ];
        return response()->json($formData);
    }

    public function add_invoice(Request $request)
    {

        $invoiceitem = $request->input('invoice_item');

        $invoicedata['customer_id'] = $request->input('customer_id');
        $invoicedata['date'] = $request->input('date');
        $invoicedata['date_echeance'] = $request->input('date_echeance');
        $invoicedata['number'] = $request->input('number');
        $invoicedata['reference'] = $request->input('reference');
        $invoicedata['remise'] = $request->input('remise');
        $invoicedata['sous_total'] = $request->input('subtotal');
        $invoicedata['total'] = $request->input('total');
        $invoicedata['terms_and_conditions'] = $request->input('customer_id');

        $invoice = Invoice::create($invoicedata);

        foreach (json_decode($invoiceitem) as $item) {
            $itemdata['invoice_id'] = $invoice->id;
            $itemdata['product_id'] = $item->id;
            $itemdata['quantity'] = $item->quantity;
            $itemdata['unit_price'] = $item->unit_price;

            InvoiceItem::create($itemdata);
        }
    }

    public function show_invoice($id)
    {
        $invoice = Invoice::with(['customer', 'invoice_items.product'])->find($id);
        return response()->json([
            'invoice' => $invoice
        ], 200);
    }

    public function edit_invoice($id)
    {
        $editInvoice = Invoice::with(['customer', 'invoice_items.product'])->find($id);
        return response()->json([
            'invoice' => $editInvoice
        ], 200);
    }
}
