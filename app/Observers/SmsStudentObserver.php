<?php

namespace App\Observers;

use App\Models\Sms\SmsStudent;
use Illuminate\Support\Facades\DB;

class SmsStudentObserver
{
    /**
     * Handle the SmsStudent "updating" event.
     * Prevent direct parent_id updates that bypass the 2-child limit
     */
    public function updating(SmsStudent $student)
    {
        // Only check if parent_id is being changed
        if ($student->isDirty('parent_id') && $student->parent_id !== null) {
            $newParentId = $student->parent_id;
            $oldParentId = $student->getOriginal('parent_id');
            
            // If parent_id is being set (not removed)
            if ($newParentId !== null) {
                // Count children via pivot table
                $pivotCount = DB::table('parent_student')
                    ->where('parent_id', $newParentId)
                    ->count();
                
                // Count children via old parent_id (excluding current student)
                $oldParentIdCount = SmsStudent::where('parent_id', $newParentId)
                    ->where('id', '!=', $student->id)
                    ->where('school_id', $student->school_id)
                    ->count();
                
                $totalChildren = $pivotCount + $oldParentIdCount;
                
                // Block if parent already has 2 or more children
                if ($totalChildren >= 2) {
                    throw new \Exception("Cannot assign student to this parent. Maximum of 2 children per parent is enforced. This parent already has {$totalChildren} children.");
                }
            }
        }
    }
}
