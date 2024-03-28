<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $seconds = 0;
        $years = 0;

        foreach ($this->experiences as $experience) {
            $begin = strtotime($experience->begin);

            if (!is_null($experience->ended)) {
                $ended = strtotime($experience->ended);
            }
            else{
                $ended = strtotime("now");
            }

            $seconds += $ended - $begin;
        }

        $years = floor($seconds / 60 / 60 / 24 / (365 * 3 + 366) * 4);
        return [
            "name" => $this->name,
            "username" => $this->username,
            "email" => $this->email,
            "day_of_birth" => $this->day_of_birth,
            "experiences" => $this->experiences,
            "experience_year" => $years,
        ];
    }
}
