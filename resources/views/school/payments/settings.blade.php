@extends('layouts.admin')

@section('title', 'Payment Settings - School Management System')

@section('content')
@include('sms.partials.design-system')
<style>
    .sms-page {
        background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
        min-height: calc(100vh - 80px);
        padding: 2rem;
    }
    .sms-page-header {
        margin-bottom: 2rem;
    }
    .sms-page-title {
        font-size: 2.25rem;
        font-weight: 800;
        color: var(--sms-gray-900);
        margin-bottom: 0.5rem;
        background: linear-gradient(135deg, var(--sms-primary), var(--sms-accent));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    .sms-page-subtitle {
        color: var(--sms-gray-600);
        font-size: 1.125rem;
    }
    .sms-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        border: 1px solid rgba(59, 130, 246, 0.1);
        padding: 2.5rem;
        margin-bottom: 2rem;
        transition: all 0.3s ease;
    }
    .sms-card:hover {
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
        transform: translateY(-2px);
    }
    .sms-card-header {
        margin-bottom: 2rem;
        padding-bottom: 1.5rem;
        border-bottom: 3px solid var(--sms-gray-200);
    }
    .sms-card-title {
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--sms-gray-900);
        margin-bottom: 0.75rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    .sms-card-title i {
        color: var(--sms-primary);
        font-size: 1.5rem;
    }
    .sms-card-subtitle {
        color: var(--sms-gray-600);
        font-size: 0.9375rem;
        line-height: 1.6;
    }
    .form-group {
        margin-bottom: 2rem;
    }
    .form-label {
        display: block;
        font-weight: 700;
        color: var(--sms-gray-900);
        margin-bottom: 0.75rem;
        font-size: 0.9375rem;
    }
    .form-control {
        width: 100%;
        padding: 1rem 1.25rem;
        border: 2px solid var(--sms-gray-300);
        border-radius: 12px;
        font-size: 0.9375rem;
        transition: all 0.3s;
        background: white;
    }
    .form-control:focus {
        outline: none;
        border-color: var(--sms-primary);
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
        transform: translateY(-1px);
    }
    .form-check {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 1.5rem;
        padding: 1rem;
        background: var(--sms-gray-50);
        border-radius: 10px;
        cursor: pointer;
        transition: all 0.2s;
    }
    .form-check:hover {
        background: var(--sms-blue-50);
    }
    .form-check-input {
        width: 1.5rem;
        height: 1.5rem;
        cursor: pointer;
        accent-color: var(--sms-primary);
    }
    .form-check-label {
        font-weight: 600;
        color: var(--sms-gray-900);
        cursor: pointer;
    }
    .help-text {
        font-size: 0.8125rem;
        color: var(--sms-gray-500);
        margin-top: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .help-text a {
        color: var(--sms-primary);
        text-decoration: none;
        font-weight: 600;
    }
    .help-text a:hover {
        text-decoration: underline;
    }
    .btn-primary {
        background: linear-gradient(135deg, var(--sms-primary), var(--sms-accent));
        color: white;
        padding: 1.25rem 3rem;
        border-radius: 12px;
        border: none;
        font-weight: 700;
        font-size: 1.125rem;
        cursor: pointer;
        transition: all 0.3s;
        box-shadow: 0 4px 15px rgba(59, 130, 246, 0.4);
        display: inline-flex;
        align-items: center;
        gap: 0.75rem;
        width: 100%;
        justify-content: center;
    }
    .btn-primary:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 25px rgba(59, 130, 246, 0.5);
    }
    .btn-primary:active {
        transform: translateY(-1px);
    }
    .btn-primary i {
        font-size: 1.25rem;
    }
    .alert {
        padding: 1.25rem 1.5rem;
        border-radius: 12px;
        margin-bottom: 2rem;
        border-left: 4px solid;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-weight: 600;
    }
    .alert-success {
        background: #d1fae5;
        color: #065f46;
        border-color: #10b981;
    }
    .alert-danger {
        background: #fee2e2;
        color: #991b1b;
        border-color: #ef4444;
    }
    .gateway-section {
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        border: 2px solid var(--sms-gray-200);
    }
    .divider {
        height: 2px;
        background: linear-gradient(90deg, transparent, var(--sms-gray-300), transparent);
        margin: 2rem 0;
    }
    .input-group {
        position: relative;
    }
    .input-icon {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: var(--sms-gray-400);
    }
    .input-icon + .form-control {
        padding-left: 3rem;
    }
</style>

<div class="sms-page">
    <div class="container-fluid py-4">
        <div class="sms-page-header">
            <h1 class="sms-page-title">Payment Settings</h1>
            <p class="sms-page-subtitle">Configure payment gateways and bank transfer details for your school</p>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <form action="{{ route('school.payments.settings.update') }}" method="POST">
            @csrf

            <!-- Payment Gateway Settings -->
            <div class="sms-card">
                <div class="sms-card-header">
                    <h3 class="sms-card-title">
                        <i class="fas fa-credit-card"></i>
                        Payment Gateway Settings
                    </h3>
                    <p class="sms-card-subtitle">Configure your payment gateway credentials. Only one gateway can be active at a time.</p>
                </div>

                <!-- Paystack -->
                <div class="gateway-section">
                    <div class="form-check">
                        <input type="checkbox" name="paystack_enabled" id="paystack_enabled" value="1" 
                            {{ old('paystack_enabled', $settings->paystack_enabled) ? 'checked' : '' }} class="form-check-input">
                        <label for="paystack_enabled" class="form-check-label">
                            <i class="fab fa-paypal"></i> Enable Paystack
                        </label>
                    </div>
                    <div class="form-group mt-3">
                        <label for="paystack_public_key" class="form-label">Paystack Public Key</label>
                        <div class="input-group">
                            <i class="fas fa-key input-icon"></i>
                            <input type="text" name="paystack_public_key" id="paystack_public_key" 
                                value="{{ old('paystack_public_key', $settings->paystack_public_key) }}" 
                                class="form-control" placeholder="pk_test_...">
                        </div>
                        <small class="help-text">
                            <i class="fas fa-info-circle"></i>
                            Get your keys from <a href="https://dashboard.paystack.com/#/settings/developer" target="_blank">Paystack Dashboard</a>
                        </small>
                    </div>
                    <div class="form-group">
                        <label for="paystack_secret_key" class="form-label">Paystack Secret Key</label>
                        <div class="input-group">
                            <i class="fas fa-lock input-icon"></i>
                            <input type="password" name="paystack_secret_key" id="paystack_secret_key" 
                                value="{{ old('paystack_secret_key', $settings->paystack_secret_key) }}" 
                                class="form-control" placeholder="sk_test_...">
                        </div>
                        <small class="help-text">
                            <i class="fas fa-shield-alt"></i>
                            Keep this secret. Never expose in frontend code.
                        </small>
                    </div>
                </div>

                <div class="divider"></div>

                <!-- Flutterwave -->
                <div class="gateway-section">
                    <div class="form-check">
                        <input type="checkbox" name="flutterwave_enabled" id="flutterwave_enabled" value="1" 
                            {{ old('flutterwave_enabled', $settings->flutterwave_enabled) ? 'checked' : '' }} class="form-check-input">
                        <label for="flutterwave_enabled" class="form-check-label">
                            <i class="fas fa-money-bill-wave"></i> Enable Flutterwave
                        </label>
                    </div>
                    <div class="form-group mt-3">
                        <label for="flutterwave_public_key" class="form-label">Flutterwave Public Key</label>
                        <div class="input-group">
                            <i class="fas fa-key input-icon"></i>
                            <input type="text" name="flutterwave_public_key" id="flutterwave_public_key" 
                                value="{{ old('flutterwave_public_key', $settings->flutterwave_public_key) }}" 
                                class="form-control" placeholder="FLWPUBK-...">
                        </div>
                        <small class="help-text">
                            <i class="fas fa-info-circle"></i>
                            Get your keys from <a href="https://dashboard.flutterwave.com/settings/apis" target="_blank">Flutterwave Dashboard</a>
                        </small>
                    </div>
                    <div class="form-group">
                        <label for="flutterwave_secret_key" class="form-label">Flutterwave Secret Key</label>
                        <div class="input-group">
                            <i class="fas fa-lock input-icon"></i>
                            <input type="password" name="flutterwave_secret_key" id="flutterwave_secret_key" 
                                value="{{ old('flutterwave_secret_key', $settings->flutterwave_secret_key) }}" 
                                class="form-control" placeholder="FLWSECK-...">
                        </div>
                    </div>
                </div>

                <div class="divider"></div>

                <!-- General Settings -->
                <div class="form-group">
                    <label for="currency" class="form-label">Currency</label>
                    <select name="currency" id="currency" class="form-control">
                        <option value="NGN" {{ old('currency', $settings->currency ?? 'NGN') === 'NGN' ? 'selected' : '' }}>NGN - Nigerian Naira</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="minimum_payment_percentage" class="form-label">Minimum Payment Percentage</label>
                    <div class="input-group">
                        <i class="fas fa-percent input-icon"></i>
                        <input type="number" name="minimum_payment_percentage" id="minimum_payment_percentage" 
                            value="{{ old('minimum_payment_percentage', $settings->minimum_payment_percentage ?? 0) }}" 
                            class="form-control" min="0" max="100" step="0.01" placeholder="0.00">
                    </div>
                    <small class="help-text">
                        <i class="fas fa-info-circle"></i>
                        Minimum percentage required for partial payments (e.g., 50 for 50%). Set to 0 to allow any amount.
                    </small>
                </div>
            </div>

            <!-- Bank Transfer Settings -->
            <div class="sms-card">
                <div class="sms-card-header">
                    <h3 class="sms-card-title">
                        <i class="fas fa-university"></i>
                        Manual Bank Transfer Settings
                    </h3>
                    <p class="sms-card-subtitle">Configure bank details for manual transfers. Parents will see these when choosing bank transfer.</p>
                </div>

                <div class="form-group">
                    <label for="bank_name" class="form-label">Bank Name</label>
                    <div class="input-group">
                        <i class="fas fa-building input-icon"></i>
                        <input type="text" name="bank_name" id="bank_name" 
                            value="{{ old('bank_name', $settings->bank_name) }}" 
                            class="form-control" placeholder="e.g., Access Bank, GTBank">
                    </div>
                </div>

                <div class="form-group">
                    <label for="account_name" class="form-label">Account Name</label>
                    <div class="input-group">
                        <i class="fas fa-user-tie input-icon"></i>
                        <input type="text" name="account_name" id="account_name" 
                            value="{{ old('account_name', $settings->account_name) }}" 
                            class="form-control" placeholder="School Account Name">
                    </div>
                </div>

                <div class="form-group">
                    <label for="account_number" class="form-label">Account Number</label>
                    <div class="input-group">
                        <i class="fas fa-hashtag input-icon"></i>
                        <input type="text" name="account_number" id="account_number" 
                            value="{{ old('account_number', $settings->account_number) }}" 
                            class="form-control" placeholder="10-digit account number">
                    </div>
                </div>

                <div class="form-group">
                    <label for="transfer_instructions" class="form-label">Transfer Instructions</label>
                    <textarea name="transfer_instructions" id="transfer_instructions" rows="4" 
                        class="form-control" placeholder="Instructions for parents making transfers...">{{ old('transfer_instructions', $settings->transfer_instructions) }}</textarea>
                    <small class="help-text">
                        <i class="fas fa-info-circle"></i>
                        Additional instructions shown to parents
                    </small>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="sms-card" style="background: linear-gradient(135deg, var(--sms-primary), var(--sms-accent)); border: none;">
                <button type="submit" class="btn-primary" style="background: white; color: var(--sms-primary); box-shadow: 0 4px 15px rgba(255, 255, 255, 0.3);">
                    <i class="fas fa-save"></i>
                    Save Payment Settings
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
