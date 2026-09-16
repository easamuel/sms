@php
    $session = $examSessions->get($exam->id) ?? null;
    $isCompleted = $session && $session->status === 'completed';
    $isInProgress = $session && $session->status === 'in_progress';
    $examDate = $exam->scheduled_date ?? $exam->start_date;
    $isToday = $examDate ? \Carbon\Carbon::parse($examDate)->isToday() : false;
    $isPast = $examDate ? \Carbon\Carbon::parse($examDate)->isPast() : false;
    $isFuture = $examDate ? \Carbon\Carbon::parse($examDate)->isFuture() : false;
    $canTake = !$isCompleted && !$isInProgress && ($isToday || ($isPast && !$exam->enforce_schedule)) && $feeStatus['cleared'];
@endphp

<div class="sms-exam-item">
    <div class="sms-exam-info">
        <div class="sms-exam-name">{{ $exam->title ?? $exam->name ?? 'Untitled Exam' }}</div>
        <div class="sms-exam-date">
            @if($examDate)
                @if($isToday)
                    <strong>Today</strong> - {{ \Carbon\Carbon::parse($examDate)->format('M j, Y') }}
                @elseif($isFuture)
                    Scheduled: {{ \Carbon\Carbon::parse($examDate)->format('M j, Y') }}
                @else
                    {{ \Carbon\Carbon::parse($examDate)->format('M j, Y') }}
                @endif
            @else
                Date TBA
            @endif
            @if($exam->duration_minutes)
                | Duration: {{ $exam->duration_minutes }} minutes
            @endif
        </div>
    </div>
    <div class="sms-exam-actions">
        @if($isCompleted)
            <a href="{{ route('sms.student.exams.result', $session->id) }}" class="sms-btn sms-btn-primary">
                <i class="fas fa-eye"></i> View Result
            </a>
        @elseif($isInProgress)
            <a href="{{ route('sms.student.exams.take', $exam->id) }}" class="sms-btn sms-btn-primary">
                <i class="fas fa-play"></i> Continue
            </a>
        @elseif($canTake)
            <form method="POST" action="{{ route('sms.student.exams.start', $exam->id) }}" style="display: inline;">
                @csrf
                <button type="submit" class="sms-btn sms-btn-primary">
                    <i class="fas fa-play"></i> Take Exam
                </button>
            </form>
        @else
            @if($isFuture)
                <span class="sms-badge sms-badge-warning">
                    Scheduled for {{ \Carbon\Carbon::parse($examDate)->format('M j') }}
                </span>
            @elseif(!$feeStatus['cleared'])
                <span class="sms-badge sms-badge-danger">
                    Fee Required ({{ $feeStatus['percentage_paid'] }}% paid)
                </span>
            @else
                <span class="sms-badge sms-badge-info">Not Available</span>
            @endif
        @endif
    </div>
</div>
