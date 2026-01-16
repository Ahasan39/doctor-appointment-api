<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class ContactController extends ApiController
{
    /**
     * Handle contact form submission.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function submit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:2000',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Validation failed', 422, $validator->errors());
        }

        // Log the contact form submission
        Log::info('Contact form submission', [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'subject' => $request->subject,
            'message' => $request->message,
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'timestamp' => now(),
        ]);

        // In a real application, you would:
        // 1. Store in database (create a Contact model and migration)
        // 2. Send email notification to admin
        // 3. Send auto-reply to user
        // 4. Add to CRM system
        
        // For now, we'll just return success
        return $this->successResponse([
            'submitted_at' => now()->toDateTimeString(),
            'reference_id' => 'CNT-' . strtoupper(substr(md5($request->email . now()), 0, 8)),
        ], 'Thank you for contacting us. We will get back to you shortly.', 201);
    }

    /**
     * Get contact information.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function info()
    {
        $contactInfo = [
            'email' => 'info@doctorappointment.com',
            'phone' => '+1 (555) 123-4567',
            'address' => '123 Medical Center Drive, Healthcare City, HC 12345',
            'working_hours' => [
                'monday_friday' => '9:00 AM - 6:00 PM',
                'saturday' => '10:00 AM - 4:00 PM',
                'sunday' => 'Closed',
            ],
            'emergency' => '+1 (555) 911-HELP',
            'social_media' => [
                'facebook' => 'https://facebook.com/doctorappointment',
                'twitter' => 'https://twitter.com/doctorappointment',
                'instagram' => 'https://instagram.com/doctorappointment',
                'linkedin' => 'https://linkedin.com/company/doctorappointment',
            ],
        ];

        return $this->successResponse(
            $contactInfo,
            'Contact information retrieved successfully'
        );
    }
}
