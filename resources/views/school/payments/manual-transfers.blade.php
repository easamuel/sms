@extends('layouts.admin')

@section('title', 'Manual Transfers - School Management System')
@section('page-title', 'Manual Bank Transfers')

@section('content')
@include('sms.partials.design-system')
<style>
    .sms-page {
        background: var(--sms-gray-50);
        min-height: calc(100vh - 80px);
    }
    .sms-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        border: 1px solid var(--sms-gray-200);
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }
    .sms-card-header {
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid var(--sms-gray-200);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .sms-card-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--sms-gray-900);
    }
    .transfer-item {
        border: 1px solid var(--sms-gray-200);
        border-radius: 8px;
        padding: 1.5rem;
        margin-bottom: 1rem;
        background: white;
    }
    .transfer-header {
        display: flex;
        justify-content: space-between;
        align-items: start;
        margin-bottom: 1rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid var(--sms-gray-200);
    }
    .transfer-info {
        flex: 1;
    }
    .transfer-student {
        font-weight: 700;
        font-size: 1.125rem;
        color: var(--sms-gray-900);
        margin-bottom: 0.25rem;
    }
    .transfer-parent {
        color: var(--sms-gray-600);
        font-size: 0.875rem;
        margin-bottom: 0.5rem;
    }
    .transfer-details {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        margin-bottom: 1rem;
    }
    .transfer-detail-item {
        display: flex;
        flex-direction: column;
    }
    .transfer-detail-label {
        font-size: 0.8125rem;
        color: var(--sms-gray-600);
        margin-bottom: 0.25rem;
    }
    .transfer-detail-value {
        font-weight: 600;
        color: var(--sms-gray-900);
    }
    .transfer-amount {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--sms-gray-900);
    }
    .transfer-actions {
        display: flex;
        gap: 0.75rem;
        margin-top: 1rem;
    }
    .btn {
        padding: 0.625rem 1.25rem;
        border-radius: 6px;
        font-weight: 600;
        font-size: 0.875rem;
        cursor: pointer;
        border: none;
        transition: all 0.2s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }
    .btn-success {
        background: #059669;
        color: white;
    }
    .btn-success:hover {
        background: #047857;
    }
    .btn-danger {
        background: #dc2626;
        color: white;
    }
    .btn-danger:hover {
        background: #b91c1c;
    }
    .btn-outline {
        background: white;
        color: var(--sms-blue-600);
        border: 1px solid var(--sms-blue-600);
    }
    .btn-outline:hover {
        background: var(--sms-blue-50);
    }
    .sms-badge {
        display: inline-flex;
        align-items: center;
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.8125rem;
        font-weight: 600;
    }
    .sms-badge-success {
        background: #d1fae5;
        color: #065f46;
    }
    .sms-badge-warning {
        background: #fef3c7;
        color: #92400e;
    }
    .sms-badge-danger {
        background: #fee2e2;
        color: #991b1b;
    }
    .proof-image {
        max-width: 300px;
        max-height: 300px;
        border-radius: 6px;
        border: 2px solid var(--sms-gray-200);
        cursor: pointer;
        transition: all 0.2s;
    }
    .proof-image:hover {
        border-color: var(--sms-primary);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        transform: scale(1.02);
    }
    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
        z-index: 1000;
        align-items: center;
        justify-content: center;
    }
    .modal.active {
        display: flex;
    }
    .modal-content {
        background: white;
        border-radius: 12px;
        padding: 2rem;
        max-width: 500px;
        width: 90%;
    }
    .form-group {
        margin-bottom: 1.25rem;
    }
    .form-label {
        display: block;
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: var(--sms-gray-700);
    }
    .form-control {
        width: 100%;
        padding: 0.625rem 0.75rem;
        border: 1px solid var(--sms-gray-300);
        border-radius: 6px;
        font-size: 0.875rem;
    }
    .alert {
        padding: 1rem;
        border-radius: 6px;
        margin-bottom: 1.5rem;
    }
    .alert-success {
        background: #d1fae5;
        color: #065f46;
        border: 1px solid #a7f3d0;
    }
    .alert-danger {
        background: #fee2e2;
        color: #991b1b;
        border: 1px solid #fecaca;
    }
    .filters {
        display: flex;
        gap: 1rem;
        margin-bottom: 1.5rem;
        flex-wrap: wrap;
    }
    .filter-link {
        padding: 0.5rem 1rem;
        border-radius: 6px;
        text-decoration: none;
        font-weight: 600;
        font-size: 0.875rem;
        transition: all 0.2s;
    }
    .filter-link.active {
        background: var(--sms-blue-600);
        color: white;
    }
    .filter-link:not(.active) {
        background: white;
        color: var(--sms-gray-700);
        border: 1px solid var(--sms-gray-300);
    }
</style>

<div class="sms-page">
    <div class="container-fluid py-4">
        <div class="sms-card">
            <div class="sms-card-header">
                <h3 class="sms-card-title">Manual Bank Transfers</h3>
                <a href="{{ route('school.payments.index') }}" class="btn btn-outline">
                    <i class="fas fa-arrow-left"></i> Back to Payments
                </a>
            </div>

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Filters -->
            <div class="filters">
                <a href="{{ route('school.payments.manual-transfers', ['status' => 'all']) }}" 
                   class="filter-link {{ $statusFilter === 'all' ? 'active' : '' }}">
                    All
                </a>
                <a href="{{ route('school.payments.manual-transfers', ['status' => 'pending']) }}" 
                   class="filter-link {{ $statusFilter === 'pending' ? 'active' : '' }}">
                    Pending
                </a>
                <a href="{{ route('school.payments.manual-transfers', ['status' => 'approved']) }}" 
                   class="filter-link {{ $statusFilter === 'approved' ? 'active' : '' }}">
                    Approved
                </a>
                <a href="{{ route('school.payments.manual-transfers', ['status' => 'rejected']) }}" 
                   class="filter-link {{ $statusFilter === 'rejected' ? 'active' : '' }}">
                    Rejected
                </a>
            </div>

            <!-- Transfers List -->
            @forelse($transfers as $transfer)
                <div class="transfer-item">
                    <div class="transfer-header">
                        <div class="transfer-info">
                            <div class="transfer-student">{{ $transfer->student->user->name ?? 'N/A' }}</div>
                            <div class="transfer-parent">Parent: {{ $transfer->parent->user->name ?? 'N/A' }}</div>
                            <div style="margin-top: 0.5rem;">
                                @if($transfer->status === 'pending')
                                    <span class="sms-badge sms-badge-warning">Pending</span>
                                @elseif($transfer->status === 'approved')
                                    <span class="sms-badge sms-badge-success">Approved</span>
                                @else
                                    <span class="sms-badge sms-badge-danger">Rejected</span>
                                @endif
                            </div>
                        </div>
                        <div class="transfer-amount">₦{{ number_format($transfer->amount, 2) }}</div>
                    </div>

                    <div class="transfer-details">
                        <div class="transfer-detail-item">
                            <div class="transfer-detail-label">Fee</div>
                            <div class="transfer-detail-value">{{ $transfer->studentFee->fee->name ?? 'N/A' }}</div>
                        </div>
                        <div class="transfer-detail-item">
                            <div class="transfer-detail-label">Transaction Reference</div>
                            <div class="transfer-detail-value">{{ $transfer->transaction_reference ?? 'N/A' }}</div>
                        </div>
                        <div class="transfer-detail-item">
                            <div class="transfer-detail-label">Bank</div>
                            <div class="transfer-detail-value">{{ $transfer->bank_name ?? 'N/A' }}</div>
                        </div>
                        <div class="transfer-detail-item">
                            <div class="transfer-detail-label">Account Number</div>
                            <div class="transfer-detail-value">{{ $transfer->account_number ?? 'N/A' }}</div>
                        </div>
                        <div class="transfer-detail-item">
                            <div class="transfer-detail-label">Submitted</div>
                            <div class="transfer-detail-value">{{ $transfer->created_at->format('M d, Y h:i A') }}</div>
                        </div>
                        @if($transfer->approved_at)
                            <div class="transfer-detail-item">
                                <div class="transfer-detail-label">{{ $transfer->status === 'approved' ? 'Approved' : 'Rejected' }} At</div>
                                <div class="transfer-detail-value">{{ $transfer->approved_at->format('M d, Y h:i A') }}</div>
                            </div>
                        @endif
                    </div>

                    @if($transfer->notes)
                        <div style="margin-bottom: 1rem; padding: 1rem; background: var(--sms-gray-50); border-radius: 6px;">
                            <strong>Notes:</strong> {{ $transfer->notes }}
                        </div>
                    @endif

                    @if($transfer->rejection_reason)
                        <div style="margin-bottom: 1rem; padding: 1rem; background: #fee2e2; border-radius: 6px; color: #991b1b;">
                            <strong>Rejection Reason:</strong> {{ $transfer->rejection_reason }}
                        </div>
                    @endif

                    @if($transfer->proof_document)
                        @php
                            $proofUrl = route('school.payments.manual-transfers.proof', $transfer->id);
                            $fileExtension = strtolower(pathinfo($transfer->proof_document, PATHINFO_EXTENSION));
                            $isImage = in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                            $isPdf = $fileExtension === 'pdf';
                        @endphp
                        <div style="margin-bottom: 1rem; padding: 1rem; background: var(--sms-gray-50); border-radius: 8px;">
                            <div class="transfer-detail-label" style="margin-bottom: 0.75rem;">Payment Proof</div>
                            <div style="display: flex; gap: 1rem; align-items: center; flex-wrap: wrap;">
                                @if($isImage)
                                    <a href="{{ $proofUrl }}" target="_blank" onclick="openProofModal(event, '{{ $proofUrl }}', 'image'); return false;" style="text-decoration: none;">
                                        <img src="{{ $proofUrl }}" 
                                             alt="Payment Proof" 
                                             class="proof-image"
                                             style="max-width: 300px; max-height: 300px; border-radius: 8px; border: 2px solid var(--sms-gray-200); cursor: pointer; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                                    </a>
                                @elseif($isPdf)
                                    <a href="{{ $proofUrl }}" target="_blank" onclick="openProofModal(event, '{{ $proofUrl }}', 'pdf'); return false;" style="text-decoration: none;">
                                        <div style="padding: 2rem; background: white; border-radius: 8px; border: 2px solid var(--sms-gray-200); text-align: center; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.borderColor='var(--sms-primary)'; this.style.boxShadow='0 4px 12px rgba(0,0,0,0.1)'" onmouseout="this.style.borderColor='var(--sms-gray-200)'; this.style.boxShadow='none'">
                                            <i class="fas fa-file-pdf" style="font-size: 3rem; color: #dc2626; margin-bottom: 0.5rem;"></i>
                                            <div style="font-weight: 600; color: var(--sms-gray-700); margin-bottom: 0.5rem;">PDF Document</div>
                                            <div style="font-size: 0.875rem; color: var(--sms-gray-500);">Click to view or download</div>
                                        </div>
                                    </a>
                                @else
                                    <a href="{{ $proofUrl }}" target="_blank" style="text-decoration: none;">
                                        <div style="padding: 2rem; background: white; border-radius: 8px; border: 2px solid var(--sms-gray-200); text-align: center; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.borderColor='var(--sms-primary)'; this.style.boxShadow='0 4px 12px rgba(0,0,0,0.1)'" onmouseout="this.style.borderColor='var(--sms-gray-200)'; this.style.boxShadow='none'">
                                            <i class="fas fa-file" style="font-size: 3rem; color: var(--sms-gray-400); margin-bottom: 0.5rem;"></i>
                                            <div style="font-weight: 600; color: var(--sms-gray-700); margin-bottom: 0.5rem;">Document</div>
                                            <div style="font-size: 0.875rem; color: var(--sms-gray-500);">Click to view or download</div>
                                        </div>
                                    </a>
                                @endif
                                <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                                    <a href="{{ $proofUrl }}" target="_blank" class="btn btn-outline" style="white-space: nowrap;">
                                        <i class="fas fa-eye"></i> View
                                    </a>
                                    <a href="{{ $proofUrl }}" download class="btn btn-outline" style="white-space: nowrap;">
                                        <i class="fas fa-download"></i> Download
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if($transfer->status === 'pending')
                        <div class="transfer-actions">
                            <form method="POST" action="{{ route('school.payments.manual-transfers.approve', $transfer->id) }}" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn btn-success" onclick="return confirm('Approve this transfer?')">
                                    <i class="fas fa-check"></i> Approve
                                </button>
                            </form>
                            <button type="button" class="btn btn-danger" onclick="openRejectModal({{ $transfer->id }})">
                                <i class="fas fa-times"></i> Reject
                            </button>
                        </div>
                    @endif
                </div>
            @empty
                <div class="text-center py-4 text-muted">
                    <p>No transfers found.</p>
                </div>
            @endforelse

            <!-- Pagination -->
            <div style="margin-top: 1.5rem;">
                {{ $transfers->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div id="rejectModal" class="modal">
    <div class="modal-content">
        <h3 style="margin-bottom: 1.5rem;">Reject Transfer</h3>
        <form id="rejectForm" method="POST">
            @csrf
            <div class="form-group">
                <label class="form-label">Rejection Reason</label>
                <textarea name="rejection_reason" class="form-control" rows="4" required placeholder="Please provide a reason for rejection..."></textarea>
            </div>
            <div style="display: flex; gap: 0.75rem; margin-top: 1.5rem;">
                <button type="submit" class="btn btn-danger">Reject Transfer</button>
                <button type="button" class="btn btn-outline" onclick="closeRejectModal()">Cancel</button>
            </div>
        </form>
    </div>
</div>

<!-- Proof Modal -->
<div id="proofModal" class="modal" onclick="closeProofModal()">
    <div class="modal-content" style="max-width: 90%; max-height: 90vh; position: relative;" onclick="event.stopPropagation()">
        <button onclick="closeProofModal()" style="position: absolute; top: 1rem; right: 1rem; background: rgba(0,0,0,0.7); color: white; border: none; border-radius: 50%; width: 40px; height: 40px; cursor: pointer; z-index: 10; display: flex; align-items: center; justify-content: center; font-size: 1.25rem;">
            <i class="fas fa-times"></i>
        </button>
        <div id="proofModalContent" style="max-height: 85vh; overflow: auto;">
            <img id="proofModalImage" src="" alt="Payment Proof" style="max-width: 100%; max-height: 85vh; border-radius: 6px; display: none;">
            <iframe id="proofModalPdf" src="" style="width: 100%; height: 85vh; border: none; border-radius: 6px; display: none;"></iframe>
        </div>
    </div>
</div>

<script>
function openRejectModal(transferId) {
    document.getElementById('rejectForm').action = `/school/payments/manual-transfers/${transferId}/reject`;
    document.getElementById('rejectModal').classList.add('active');
}

function closeRejectModal() {
    document.getElementById('rejectModal').classList.remove('active');
    document.getElementById('rejectForm').reset();
}

function openProofModal(event, fileSrc, fileType) {
    event.preventDefault();
    const modal = document.getElementById('proofModal');
    const imageEl = document.getElementById('proofModalImage');
    const pdfEl = document.getElementById('proofModalPdf');
    
    if (fileType === 'image') {
        imageEl.src = fileSrc;
        imageEl.style.display = 'block';
        pdfEl.style.display = 'none';
    } else if (fileType === 'pdf') {
        pdfEl.src = fileSrc;
        pdfEl.style.display = 'block';
        imageEl.style.display = 'none';
    } else {
        // Try to detect from URL
        if (fileSrc.toLowerCase().includes('.pdf')) {
            pdfEl.src = fileSrc;
            pdfEl.style.display = 'block';
            imageEl.style.display = 'none';
        } else {
            imageEl.src = fileSrc;
            imageEl.style.display = 'block';
            pdfEl.style.display = 'none';
        }
    }
    
    modal.classList.add('active');
}

function closeProofModal() {
    const modal = document.getElementById('proofModal');
    const imageEl = document.getElementById('proofModalImage');
    const pdfEl = document.getElementById('proofModalPdf');
    
    modal.classList.remove('active');
    // Clear sources to stop loading
    setTimeout(() => {
        imageEl.src = '';
        pdfEl.src = '';
    }, 300);
}
</script>
@endsection
