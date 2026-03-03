<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class VerifyOTP extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $otp; // إضافة متغير الـ OTP

    /**
     * Create a new message instance.
     */
    public function __construct($user, $otp)
    {
        $this->user = $user;
        $this->otp = $otp; // تعيين قيمة الـ OTP
    }

    /**
     * Email subject
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Jordan–EU Investment Conference 2026 - OTP Verification',
        );
    }

    /**
     * Email content
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.verify-otp',
            with: [
                'user' => $this->user,
                'otp' => $this->otp,
            ],
        );
    }

    /** 
     * Attachments
     */
    public function attachments(): array
    {
        return [];
    }
}