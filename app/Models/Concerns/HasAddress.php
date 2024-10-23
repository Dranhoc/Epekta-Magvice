<?php

declare(strict_types=1);

namespace App\Models\Concerns;

/**
 * @property-read ?string $link_googlemap
 */
trait HasAddress
{
    public function getAddressArray(): array
    {
        $address = [
            $this->street ?: '',
            $this->street_number ?: '',
            trim(implode(' ', [
                $this->postal_code ?: '',
                $this->city ?: '',
            ])),
            $this->country ?: '',
        ];

        if (count($address = array_filter($address)) > 0) {
            return $address;
        }

        return [];
    }

    public function getAddressLine(string $glue = ', '): string
    {
        return trim(implode($glue, $this->getAddressArray()));
    }

    public function getAddressAttribute(): string
    {
        return $this->getAddressLine();
    }

    public function linkGoogleMap(): string
    {
        if ($this->link_googlemap) {
            return $this->link_googlemap;
        }

        return 'https://maps.google.com/?q='.urlencode($this->address);
    }

    public function linkEmbedGoogleMap(): string
    {
        if ($this->link_googlemap) {
            return $this->link_googlemap;
        }

        return 'https://www.google.com/maps/embed/v1/place?q='.urlencode($this->address).'&key='.config('services.google.key');
    }
}
