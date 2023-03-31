<?php declare(strict_types=1);

namespace ChristelMusic;

class FormData
{
    /**
     * Indicates if the form was already submitted, to differentiate which class
     * to return. When unsubmitted, empty is not invalid.
     */
    private bool $is_submitted;

    public ?string $name;
    public ?string $email;
    public ?string $address;
    public ?string $postalCode;
    public ?string $city;
    public string $country;
    public int $quantityWatershed;
    public int $quantityLandslide;

    private array $errorMessages = [];

    public static function fromPost(array $postData): self
    {
        $formData = new self();
        $formData->is_submitted = true;
        $formData->name = $postData['name'];
        $formData->email = $postData['email'];
        $formData->address = $postData['address'];
        $formData->postalCode = $postData['postalCode'];
        $formData->city = $postData['city'];
        $formData->country = $postData['country'];
        $formData->quantityWatershed = intval($postData['quantityWatershed']);
        $formData->quantityLandslide = intval($postData['quantityLandslide']);

        $formData->validate();

        return $formData;
    }

    public static function empty(): self
    {
        $formData = new self();
        $formData->is_submitted = false;
        $formData->country = 'The Netherlands';
        $formData->quantityWatershed = 0;
        $formData->quantityLandslide = 0;

        return $formData;
    }

    public function isSubmitted(): bool
    {
        return $this->is_submitted;
    }

    public function isValid(): bool
    {
        return count($this->errorMessages) == 0;
    }

    public function getHtmlClass(string $field): string
    {
        if (!$this->is_submitted) {
            return '';
        }

        if (!empty($this->errorMessages[$field])) {
            return 'is-invalid';
        } else {
            return 'is-valid';
        }
    }

    public function getHtmlFeedback(string $field): string
    {
        if (!$this->is_submitted) {
            return '';
        }

        if (!empty($this->errorMessages[$field])) {
            return sprintf('<div class="invalid-feedback">%s</div>', $this->errorMessages[$field]);
        }

        return '';
    }

    private function validate(): void
    {
        foreach (['name', 'email', 'address', 'postalCode', 'city', 'country'] as $field) {
            if (empty($this->{$field})) {
                $this->errorMessages[$field] = 'This is a required field.';
            }
        }

        if (empty($this->quantityWatershed) && empty($this->quantityLandslide)) {
            $this->errorMessages['quantityWatershed'] = $this->errorMessages['quantityLandslide'] = 'At least one album must be ordered.';
        }

        if (!isset($this->errorMessages['email']) && !filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $this->errorMessages['email'] = 'This is an invalid email address.';
        }
    }
}
