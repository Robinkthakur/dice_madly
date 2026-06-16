<?php

namespace App\Http\Resources\Api\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

use Illuminate\Support\Facades\Storage;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'profile_id' => $this->profile_id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'gender' => $this->gender,
            'age' => $this->age,
            'marital_status' => $this->marital_status,
            'is_active' => (bool) $this->is_active,
            'is_verified' => (bool) $this->is_verified,
            'verified_until' => $this->verified_until?->toIso8601String(),
            'phone_verified_at' => $this->phone_verified_at?->toIso8601String(),
            'dob' => $this->dob?->format('Y-m-d'),
            'profile_image' => $this->profile_image 
                ? (
                    str_starts_with($this->profile_image, 'http')
                        ? (
                            preg_match('/(profiles|id_proofs|selfies)\/[^\/]+$/', $this->profile_image, $matches)
                                ? Storage::disk('public')->url($matches[0])
                                : $this->profile_image
                        )
                        : Storage::disk('public')->url($this->profile_image)
                )
                : null,
            'onboarding_step' => $this->onboarding_step ?? 'bio_dp',
            'about_me' => $this->profile?->about_me,
            'qualification' => $this->relationLoaded('education') ? $this->education?->highest_qualification : ($this->education?->highest_qualification ?? null),
            'profession' => $this->relationLoaded('occupation') ? $this->occupation?->occupation : ($this->occupation?->occupation ?? null),
            'country' => $this->profile?->country,
            'state' => $this->profile?->state,
            'city' => $this->profile?->city,
            'mother_tongue' => $this->profile?->mother_tongue,
            'profile_completion_percentage' => $this->profileCompletionPercentage(),
            'interests' => $this->relationLoaded('interestOptions') 
                ? $this->interestOptions->map(fn($o) => ['id' => $o->id, 'name' => $o->name, 'category' => $o->category])
                : null,
            'interest_options' => $this->relationLoaded('interestOptions') 
                ? $this->interestOptions->map(fn($o) => ['id' => $o->id, 'name' => $o->name, 'category' => $o->category])
                : null,
            'created_at' => $this->created_at?->toIso8601String(),
            'updated_at' => $this->updated_at?->toIso8601String(),
        ];
    }
}
