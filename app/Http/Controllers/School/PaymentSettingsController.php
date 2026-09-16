<?php

namespace App\Http\Controllers\School;

use App\Models\SchoolPaymentSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentSettingsController extends BaseSchoolController
{
    public function index()
    {
        $school = $this->getSchool();
        
        if (!$school) {
            return redirect()->route('school-management.demo-login')
                ->with('error', 'School not found. Please login again.');
        }

        $settings = SchoolPaymentSetting::firstOrCreate(
            ['school_id' => $school->id],
            [
                'currency' => 'NGN',
                'minimum_payment_percentage' => 0,
            ]
        );

        // Refresh to get latest data from database
        $settings->refresh();
        
        // Double-check by getting directly from DB
        $dbAccountName = DB::table('school_payment_settings')
            ->where('id', $settings->id)
            ->value('account_name');
        
        if ($dbAccountName !== null && $settings->account_name !== $dbAccountName) {
            $settings->account_name = $dbAccountName;
        }

        return view('school.payments.settings', compact('settings', 'school'));
    }

    public function update(Request $request)
    {
        $school = $this->getSchool();
        
        if (!$school) {
            return redirect()->route('school-management.demo-login')
                ->with('error', 'School not found. Please login again.');
        }

        $validated = $request->validate([
            // Paystack
            'paystack_public_key' => 'nullable|string|max:255',
            'paystack_secret_key' => 'nullable|string|max:255',
            'paystack_enabled' => 'boolean',
            
            // Flutterwave
            'flutterwave_public_key' => 'nullable|string|max:255',
            'flutterwave_secret_key' => 'nullable|string|max:255',
            'flutterwave_enabled' => 'boolean',
            
            // Moniepoint
            'moniepoint_api_key' => 'nullable|string|max:255',
            'moniepoint_secret_key' => 'nullable|string|max:255',
            'moniepoint_enabled' => 'boolean',
            
            // General
            'currency' => 'required|string|size:3',
            'minimum_payment_percentage' => 'required|numeric|min:0|max:100',
            
            // Bank Details
            'bank_name' => 'nullable|string|max:255',
            'account_name' => 'nullable|string|max:255',
            'account_number' => 'nullable|string|max:255',
            'transfer_instructions' => 'nullable|string',
            'narration_format' => 'nullable|string|max:255',
        ]);

        // Ensure account_name is properly trimmed and saved
        if (isset($validated['account_name'])) {
            $validated['account_name'] = trim($validated['account_name']);
        }

        // Get or create the settings record
        $settings = SchoolPaymentSetting::firstOrCreate(
            ['school_id' => $school->id],
            [
                'currency' => 'NGN',
                'minimum_payment_percentage' => 0,
            ]
        );

        // Explicitly update each field to ensure they're saved
        $settings->fill($validated);
        $settings->save();

        // Force refresh to ensure we have the saved values
        $settings->refresh();

        // Verify the account_name was saved correctly by querying DB directly
        $savedAccountName = DB::table('school_payment_settings')
            ->where('id', $settings->id)
            ->value('account_name');
        
        $savedAccountNumber = DB::table('school_payment_settings')
            ->where('id', $settings->id)
            ->value('account_number');
        
        // If there's a mismatch, log it and try to fix it
        if ($savedAccountName !== $validated['account_name'] && !empty($validated['account_name'])) {
            \Log::warning('Account name mismatch detected, attempting direct update', [
                'school_id' => $school->id,
                'settings_id' => $settings->id,
                'input_account_name' => $validated['account_name'],
                'saved_account_name' => $savedAccountName,
            ]);
            
            // Direct database update as fallback
            DB::table('school_payment_settings')
                ->where('id', $settings->id)
                ->update(['account_name' => $validated['account_name']]);
            
            $settings->refresh();
            $savedAccountName = $validated['account_name'];
        }
        
        \Log::info('Payment settings updated', [
            'school_id' => $school->id,
            'settings_id' => $settings->id,
            'account_name_input' => $request->input('account_name'),
            'account_name_validated' => $validated['account_name'] ?? null,
            'account_name_saved_db' => $savedAccountName,
            'account_name_model' => $settings->account_name,
            'account_number_input' => $request->input('account_number'),
            'account_number_saved_db' => $savedAccountNumber,
            'account_number_model' => $settings->account_number,
        ]);

        return redirect()->route('school.payments.settings')
            ->with('success', 'Payment settings updated successfully.');
    }
}
