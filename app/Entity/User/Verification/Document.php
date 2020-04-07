<?php

namespace App\Entity\User\Verification;

use App\Entity\User\User;
use App\Events\User\Document\DocumentRejected;
use App\Events\User\Document\DocumentVerified;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    const MAX_UPLOAD_SIZE = 5120; // 5 Mb

    const STATUS_WAIT = 'wait';
    const STATUS_VERIFIED = 'verified';
    const STATUS_REJECTED = 'rejected';

    const TYPE_PASSPORT = 'passport';
    const TYPE_CERTIFICATE = 'certificate';
    const TYPE_DOCUMENT = 'document';
    const TYPE_JURISTIC = 'juristic';

    const STORAGE_DIR = 'documents';

    protected $table = 'user_verification_documents';
    protected $fillable = ['user_id', 'path', 'crop', 'status', 'type', 'public', 'reject_reason', 'status_changed_at'];

    protected $casts = [
        'status_changed_at' => 'datetime',
        'public' => 'boolean'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reject(Carbon $date, ?string $reason = null)
    {
        if($this->isRejected()) {
            throw new \DomainException('Document is already rejected.');
        }
        $this->update(['reject_reason' => $reason, 'status_changed_at' => $date, 'status' => self::STATUS_REJECTED]);
        $this->setPrivate();

        event(new DocumentRejected($this->user, $this));
    }
    public function verify(Carbon $date)
    {
        if($this->isVerified()) {
            throw new \DomainException('Document is already verified.');
        }

        $this->update(['status_changed_at' => $date, 'status' => self::STATUS_VERIFIED]);

        $user = $this->user;
        $user->addRating(User::RATING_VERIFY_PASSPORT_POINTS);

        if($this->isPassport()) {
            $user->addRating(User::RATING_VERIFY_PASSPORT_POINTS);
        } else {
            $user->addRating(User::RATING_VERIFY_DOCUMENT_POINTS);
        }

        event(new DocumentVerified($user, $this));
    }

    // set public/private for documents (for example, passport would be private, will be showed only for owner; certificates are public)
    public function setPublic()
    {
        if($this->isPublic()) {
            throw new \DomainException('The document is already public.');
        }
        return $this->update(['public' => true]);
    }
    public function setPrivate()
    {
        if($this->isPrivate()) {
            throw new \DomainException('The document is already private.');
        }
        return $this->update(['public' => false]);
    }

    public function scopePublic($query)
    {
        return $query->where('public', true);
    }
    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }
    public function scopePassport($query)
    {
        return $query->where('type', self::TYPE_PASSPORT);
    }
    public function scopeCertificates($query)
    {
        return $query->where('type', self::TYPE_CERTIFICATE);
    }
    public function scopeDocuments($query)
    {
        return $query->where('type', self::TYPE_DOCUMENT);
    }
    public function scopeVerified($query)
    {
        return $query->where('type', self::STATUS_VERIFIED);
    }

    public function isPublic(): bool
    {
        return $this->public === true;
    }
    public function isPrivate(): bool
    {
        return $this->public === false;
    }

    // statuses
    public function isWait(): bool
    {
        return $this->status === self::STATUS_WAIT;
    }
    public function isVerified(): bool
    {
        return $this->status === self::STATUS_VERIFIED;
    }
    public function isRejected(): bool
    {
        return $this->status === self::STATUS_REJECTED;
    }

    // types
    public function isPassport(): bool
    {
        return $this->type === self::TYPE_PASSPORT;
    }
    public function isCertificate(): bool
    {
        return $this->type === self::TYPE_CERTIFICATE;
    }
    public function isDocument(): bool
    {
        return $this->type === self::TYPE_DOCUMENT;
    }
    public function isJuristic(): bool
    {
        return $this->type === self::TYPE_JURISTIC;
    }

    public function getPath(): string
    {
        return "app/{$this->path}";
    }
    public function getCrop(): string
    {
        return "storage/{$this->crop}";
    }

    public function getType()
    {
        return static::getTypesList()[$this->type];
    }

    public static function getTypesList(): array
    {
        return [
            self::TYPE_CERTIFICATE => 'Сертификат',
            self::TYPE_PASSPORT => 'Фото паспорта',
            self::TYPE_DOCUMENT => 'Документ',
            self::TYPE_JURISTIC => 'Для юридических лиц'
        ];
    }
}
