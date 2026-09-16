{{-- Mobile-Responsive Styles for All Pages --}}
<style>
    /* Mobile-First Responsive Design */
    
    /* Ensure all interactive elements are touch-friendly */
    a, button, input, select, textarea, .sms-btn, .btn {
        min-height: 44px;
        min-width: 44px;
        touch-action: manipulation;
        -webkit-tap-highlight-color: transparent;
    }
    
    /* Prevent text size adjustment on iOS */
    input, select, textarea {
        font-size: 16px;
    }
    
    /* Mobile-optimized tables */
    @media (max-width: 768px) {
        table {
            display: block;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            white-space: nowrap;
        }
        
        table thead {
            display: none;
        }
        
        table tbody {
            display: block;
        }
        
        table tr {
            display: block;
            margin-bottom: 1rem;
            border: 1px solid var(--sms-gray-200);
            border-radius: 8px;
            padding: 1rem;
            background: white;
        }
        
        table td {
            display: flex;
            justify-content: space-between;
            padding: 0.5rem 0;
            border: none;
            text-align: right;
        }
        
        table td::before {
            content: attr(data-label);
            font-weight: 600;
            color: var(--sms-gray-700);
            text-align: left;
            margin-right: 1rem;
        }
    }
    
    /* Mobile-optimized forms */
    @media (max-width: 640px) {
        .form-row,
        .sms-form-row {
            grid-template-columns: 1fr !important;
        }
        
        .filter-grid {
            grid-template-columns: 1fr !important;
        }
    }
    
    /* Mobile-optimized cards */
    @media (max-width: 640px) {
        .sms-card,
        .sms-stat-card,
        .sms-action-card {
            padding: 1rem !important;
            margin-bottom: 1rem !important;
        }
    }
    
    /* Smooth scrolling on mobile */
    html {
        -webkit-overflow-scrolling: touch;
        scroll-behavior: smooth;
    }
    
    /* Prevent horizontal scroll */
    body {
        overflow-x: hidden;
    }
    
    /* Mobile-friendly modals */
    @media (max-width: 640px) {
        .modal-dialog {
            margin: 0.5rem;
            max-width: calc(100% - 1rem);
        }
        
        .modal-content {
            border-radius: 12px;
        }
    }
</style>
