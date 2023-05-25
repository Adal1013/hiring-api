<?php

namespace App\Http\DataTransferObjects\Candidates;

use Spatie\LaravelData\Data;

class CandidateData extends Data
{
    /**
     * @param string $name
     * @param string $source
     * @param int $owner
     * @param int $createdBy
     */
    public function __construct(
        public string $name,
        public string $source,
        public int $owner,
        public int $createdBy
    )
    {
    }

    /**
     * @return string[]
     */
    public static function rules(): array
    {
        return [
            'name' => 'required',
            'source' => 'required',
            'owner' => 'required',
            'createdBy' => 'required'
        ];
    }
}
