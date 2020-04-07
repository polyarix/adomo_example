<?php

namespace App\UseCase\User\Profile;

use App\Entity\User\Verification\Document;
use App\Entity\User\User;
use App\Http\Requests\Api\User\Cabinet\Verification\UpdateRequest;
use App\Http\Requests\Api\User\Cabinet\Verification\UploadDocumentRequest;
use Carbon\Carbon;
use Illuminate\Http\UploadedFile;

class VerificationService
{
    public function update(User $user, UpdateRequest $request)
    {
        $user->update([
            'passport_series' => $request->get('passport_series'),
            'registration' => $request->get('registration'),
            'criminal_record' => $request->get('criminal_record')
        ]);
    }

    public function checkDocumentOwning(User $user, Document $document)
    {
        if($user->id !== $document->user->id && !$user->isAdmin()) {
            throw new \DomainException('You aren\'t own of the document.');
        }
    }

    public function verify(Document $document)
    {
        $document->verify($date = Carbon::now());
    }

    public function reject(Document $document, ?string $reason = null)
    {
        $document->reject($date = Carbon::now(), $reason);
    }

    public function attach(User $user, UploadDocumentRequest $request): Document
    {
        list($path, $cropPath) = $this->uploadFile($request->file('file'));

        $isPublic = true;
        if($request->type === Document::TYPE_PASSPORT) {
            if($user->documents()->passport()->verified()->exists()) {
                throw new \DomainException('You have already verified passport.');
            }

            $user->documents()->passport()->delete();
        }

        if(in_array($request->get('type'), [Document::TYPE_JURISTIC, Document::TYPE_PASSPORT, Document::TYPE_DOCUMENT])) {
            $isPublic = false;
        }

        /** @var Document $document */
        $document = $user->documents()->create([
            'path' => $path,
            'crop' => $cropPath,
            'type' => $request->get('type'),
            'public' => $isPublic,
        ]);

        return $document;
    }

    public function delete(User $user, Document $document)
    {
        if(!$user->documents()->where('id', $document->id)->exists()) {
            throw new \InvalidArgumentException('Document isn\'t exists.');
        }

        if($document->isVerified()) {
            throw new \DomainException('Нельзя удалить уже проверенный документ.');
        }

        $document->delete();
    }

    public function getDocumentById(int $id): Document
    {
        return Document::findOrFail($id);
    }

    public function uploadFile(UploadedFile $file)
    {
        $name = uniqid();
        $extension = $file->extension();
        $file->storeAs(Document::STORAGE_DIR, "{$name}.{$extension}");

        $baseName = storage_path()."/app/".Document::STORAGE_DIR."/{$name}";
        $basePublicName = storage_path()."/app/public/".Document::STORAGE_DIR."/{$name}";

        $file = \Image::make("{$baseName}.{$extension}")->resize(null, config('cropper.height'), function($constraint) {
            $constraint->aspectRatio();
        });
        $file->save("{$basePublicName}_crop.{$extension}", config('cropper.quality'));

        return [Document::STORAGE_DIR."/{$name}.{$extension}", Document::STORAGE_DIR."/{$name}_crop.{$extension}"];
    }
}
